//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var search_keyword = getUrlParam('keyword');
var search_parent_code = getUrlParam('parent_code');
var search_id = getUrlParam('id');
$('.add_material input[name="effective_date"]').val(now);
//日期控件初始化
$('.date').datetimepicker({
    format: 'YYYY-MM-DD',
});
//点击保存新增楼宇信息
$('#add_material .confirm').click(function(){
	var code = $('.add_material .code').html();
	var effective_date = $('.add_material').find('input[name="effective_date"]').val();
	var name = $('.add_material').find('input[name="name"]').val();
	var pcs = $('.add_material').find('input[name="pcs"]').val();
    var material_type = $('.add_material').find('input[name="material_type"]').val();
    var building_code = $('.add_material').find('input[name="building_code"]').val();
    var supplier = $('.add_material').find('input[name="supplier"]').val();
    var internal_no = $('.add_material').find('input[name="internal_no"]').val();
    var initial_no = $('.add_material').find('input[name="initial_no"]').val();
	var remark = $('.add_material').find('input[name="remark"]').val();

	remark = remark?remark:'';
	if(!effective_date){
		openLayer('请输入生效日期');
		return;
	}
	if(!name){
		openLayer('请输入物资名称');
		return;
	}
	if(!pcs){
		openLayer('请输入物资数量');
		return;
	}
	if(!material_type){
		openLayer('请选择物资类型');
		return;
	}
	//判断有效无效
	if($('.add_material .effective_status input[type="radio"]').eq(0).is(':checked')){
		effective_status = 'true';
	}
	else {
		effective_status = 'false';
	}
	$.ajax({
		url:getRootPath()+'/index.php/Material/insertMaterial',
		method:'post',
		data:{
			code:code,
			effective_date:effective_date,
			effective_status:effective_status,
			name:name,
			pcs:pcs,
            material_type:material_type,
            building_code:building_code,
            supplier:supplier,
            internal_no:internal_no,
            initial_no:initial_no,
			remark:remark
		},
		success:function(data){
			var data = JSON.parse(data);
			//成功之后自动刷新页面
			layer.open({
				  type: 1,
				  title: false,
				  //打开关闭按钮
				  closeBtn: 1,
				  shadeClose: false,
				  skin: 'tanhcuang',
				  content: data.message,
				  cancel: function(){ 
				    //右上角关闭回调
				    window.location = getRootPath() + "/index.php/Material/materialList";
				  }
			});
		},
		error:function(){
			console.log('新增物资出错');
		}
	})

})

//点击新增按钮,从后端取得楼宇编号信息
$('.add_btn').click(function(){
	$.ajax({
		url:getRootPath()+'/index.php/Material/getMaterialCode',
		success:function(data){
			var code = parseInt(data) + 1;
			$('.add_material .code').html(code);
		}
	})
})





//function write_building_hide(){
//	$('#write_building').modal('hide');
//}



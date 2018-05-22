//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var search_keyword = getUrlParam('keyword');
//var search_parent_code = getUrlParam('parent_code');
var search_material_type = getUrlParam('search_material_type');
$('.add_material input[name="effective_date"]').val(now);
//日期控件初始化
$('.date').datetimepicker({
    format: 'YYYY-MM-DD',
});


//特殊处理搜索框输入物资类型的中文，将它变成数字赋给keyword
var search_text=$('.searc_room_text').val()
console.log(search_text)
if (search_text.indexOf("工程物资") !== -1 ){
        keyword=101;
}
if (search_text.indexOf("安防物资") !== -1  ){
        keyword=102;
}
if (search_text.indexOf("消防物资")!==-1){
        keyword=103;
}
if (search_text.indexOf("保洁物资") !==-1){
        keyword=104;
}
if (search_text.indexOf("办公物资") !==-1){
        keyword=105;
}




//点击保存新增楼宇信息
$('#add_material .confirm').click(function(){

	var code = $('.add_material .code').html();
	var effective_date = $('.add_material').find('input[name="effective_date"]').val();
	var name = $('.add_material').find('input[name="name"]').val();
	var pcs = $('.add_material').find('input[name="pcs"]').val();
    var material_type = $('.add_material').find('input[name="material_type"]').data('ajax');
    var building_code = $('.add_material').find('input[name="building_code"]').data('ajax');
    var supplier = $('.add_material').find('input[name="supplier"]').val();
    var internal_no = $('.add_material').find('input[name="internal_no"]').val();
    var initial_no = $('.add_material').find('input[name="initial_no"]').val();
	var remark = $('.add_material').find('input[name="remark"]').val();
    var p_bs = $('.add_material').find('.select_buliding em');
//$('.add_material').find('input[name="effective_date"]').val();

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
   /* if(p_bs.length==0){
        openLayer('请选择至少一个地点!');
        return;
    }*/
    //if(!parent_code){
        //openLayer('请选择上级楼宇');
       // return;
   // }
	//判断有效无效
	if($('.add_material .effective_status input[type="radio"]').eq(0).is(':checked')){
		effective_status = 'true';
	}
	else {
		effective_status = 'false';
	}

    var person_position_datas = [];
    console.log(p_bs.length);
    for(var i=0;i<p_bs.length;i++){
        var p_b = p_bs.eq(i);
        var code = p_b.data('room_code');
        var person_position_data = '';
        person_position_data = {
            code:code
        }
        person_position_datas[i] = person_position_data;
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
            building_code:person_position_datas,
            supplier:supplier,
            internal_no:internal_no,
            initial_no:initial_no,
			remark:remark,
            //parent_code:parent_code_data,
            //territorys:person_position_datas
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
                     /* asynRefreshPage(getRootPath()+'/index.php/Material/materialList','Material/getMaterialList',table,data.total,'&keyword='+search_keyword);*/
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
		    if(parseInt(data)){
			var code = parseInt(data) + 1;
            }else{
		        var code = 1000000;
            }
			$('.add_material .code').html(code);
		}
	})
})



//动态获取所有楼宇信息
$('.select_parent_code').click(function(){
    $.ajax({
        type:"POST",
        url : getRootPath()+'/index.php/Material/getMaterialNameCode',
        dataType:"json",
        success:function(data){

            for(var i=0;i<data.length;i++){
                var code = data[i]['code'];
                var name = data[i]['name'];
                if($(".buildings #"+code).length==0) {
                    $('.buildings ul').append('<li><a href="javascript:;" id='+code+' data-ajax='+code+'>'+code+'-'+name+'</a></li>');
                }
            }
            $('.building_code_wrap .ka_drop_list li').click(function(){
                var building_code = $(this).find('a').data('ajax');
                 window.location.href="materialList?keyword="+search_keyword+"&page="+page+'&material_type='+material_type+"&building_code="+building_code;
            })
        }
    })
})



$('.material_type_wrap .ka_drop_list li').click(function(){
    var page = $('input[name="page"]').val();
    var material_type = $(this).find('a').data('ajax');
    var building_code = $('input[name="building_codes"]').val();
    var parent_code = $('input[name="parent_codes"]').val();
    console.log(material_type);
    window.location.href="materialList?keyword="+search_keyword+"&page=1"+'&material_type='+material_type+"&building_code="+building_code+"&parent_code="+parent_code;
})



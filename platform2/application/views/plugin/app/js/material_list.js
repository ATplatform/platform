//日期控件初始化
var now = new Date();
now = formatDate(now);
$('.date').datetimepicker({
    format: 'YYYY-MM-DD',
});


//参数初始化赋值
var page = $('input[name="page"]').val();
var keyword = $('input[name="keywords"]').val()
var material_type = $('input[name="material_types"]').val();
var building_code = $('input[name="building_codes"]').val();
var parent_code = $('input[name="parent_codes"]').val();


//带search的参数用于异步刷新页面时做分页和查询总条数
var search_material_type = getUrlParam('material_type');
var search_building_code = getUrlParam('building_code');
var search_parent_code = getUrlParam('parent_code');
var search_keyword = getUrlParam('keyword');


//获得普通模式数据url
function materialList(){
    window.location = getRootPath() + "/index.php/Material/materialList"
}
//获得搜索模式获得数据url
function materialListbySearch(){
    window.location.href="materialList?keyword="+keyword+"&page=1"+'&material_type='+material_type+"&building_code="+building_code+"&parent_code="+parent_code;
}

//获得页面跳转的url
function PageChangeToMaterialList(){
    window.location.href = "materialList?keyword=" + search_keyword + "&page=" + page+'&material_type='+search_material_type+'&building_code='+search_building_code+'&parent_code='+search_parent_code;
}

//传入插入数据url
function insertMaterial(){
    return getRootPath()+'/index.php/Material/insertMaterial'
}


//传入普通模式下的url
function getMaterialListbyNormal(){
   return getRootPath() + '/index.php/Material/getMaterialListbyNormal?page=' + page
}

//传入搜索模式下的url
function getMaterialListbySearch(){
    return getRootPath() + '/index.php/Material/getMaterialListbySearch?page=' + page+'&parent_code='+parent_code+'&building_code='+building_code+'&material_type='+material_type+'&keyword='+keyword
}


//传入最新的code的url
function getMaterialCode(){
    return getRootPath()+'/index.php/Material/getMaterialCode'
}

//传入展示楼宇信息的url
function getMaterialNameCode(){
	return getRootPath()+'/index.php/Material/getMaterialNameCode'
}




////////////////////////////数据展示功能/////////////////////////////////

//判断是普通模式还是搜索模式

    //普通模式的数据展示
    if( !$.trim(keyword) && !$.trim(material_type) && !$.trim(building_code)){
        $('#table').bootstrapTable({
            method: "get",
            undefinedText: '/',
            url: getMaterialListbyNormal(),
            dataType: 'json',
            // pagination:true,
            // pageSize: 15,
            // pageNumber: 1,
            // sortName: 'id',
            // sortOrder: 'desc',
            responseHandler: function (res) {
                //用于处理后端返回数据
                console.log(res);
                return res;
            },
            onLoadSuccess: function (data) {  //加载成功时执行
                console.log(data);
            },
            onLoadError: function () {  //加载失败时执行
                console.info("加载数据失败");
            }
        })
    }

    //搜索模式的数据展示
    else{
        $('#table').bootstrapTable({
            method: "get",
            undefinedText: '/',
            url: getMaterialListbySearch(),
            dataType: 'json',
            // pagination:true,
            // pageSize: 15,
            // pageNumber: 1,
            // sortName: 'id',
            // sortOrder: 'desc',
            responseHandler: function (res) {
                //用于处理后端返回数据
                console.log(res);
                return res;
            },
            onLoadSuccess: function (data) {  //加载成功时执行
                console.log(data);
            },
            onLoadError: function () {  //加载失败时执行
                console.info("加载数据失败");
            }
        })
    }

    //点击分页go,判断页面跳转
    $('.fenye_btn').click(function() {
        var page = $('input[name="fenye_input"]').val();
        var pagenumber = Number(page) + "";

        var myTotal = $('#current').text().split('/')[1];
        if (!/^[0-9]*$/.test(page)) {
            openLayer('请输入数字');
            $('input[name="fenye_input"]').val('');
            return;
        }
        if (page != pagenumber) {
            $('input[name="fenye_input"]').val(pagenumber);
            page = pagenumber;
        }
        if (Number(page) > Number(myTotal)) {
            $('input[name="fenye_input"]').val(myTotal);
            page = myTotal;
        }
        if (Number(page) < 1) {
            openLayer('请输入合法页数');
            $('input[name="fenye_input"]').val('');
            return;
        }


        PageChangeToMaterialList();
    })






//////////////////////////////////搜索功能////////////////////////////////////////
$('.Search_Item_wrap .ka_drop_list li').click(function(){
    var page = $('input[name="page"]').val();
    var material_type = $(this).find('a').data('ajax');
    var building_code = $('input[name="building_codes"]').val();
    var parent_code = $('input[name="parent_codes"]').val();
    var keyword = $('input[name="keywords"]').val();
    //var effective_date=$('.add_material input[name="effective_date"]').val(now);
    console.log(material_type);

    materialListbySearch();

})









//////////////////////////////////新增功能////////////////////////////////////////
//点击新增按钮,从后端取得楼宇编号信息
$('.add_btn').click(function(){
    $.ajax({
        url:getMaterialCode(),
        success:function(data){
            if(parseInt(data)){
                var code = parseInt(data) + 1;
            }else{
                var code = 1000000;
            }
            $('.add_Item .code').html(code);
        }
    })
})



//动态获取所有楼宇信息
$('.select_parent_code').click(function(){
    $.ajax({
        type:"POST",
        url : getMaterialNameCode(),
        dataType:"json",
        success:function(data){

            for(var i=0;i<data.length;i++){
                var code = data[i]['code'];
                var name = data[i]['name'];
                if($(".buildings #"+code).length==0) {
                    $('.buildings ul').append('<li><a href="javascript:;" id='+code+' data-ajax='+code+'>'+code+'-'+name+'</a></li>');
                }
            }

        }
    })
})



//点击保存新增楼宇信息
$('#add_Item .confirm').click(function(){

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
   if(p_bs.length==0){
        openLayer('请选择至少一个地点!');
        return;
    }
	//判断有效无效
	if($('.add_material .effective_status input[type="radio"]').eq(0).is(':checked')){
		effective_status = 'true';
	}
	else {
		effective_status = 'false';
	}

	//把building_code和parent_code导入服务器
    var building_codeAndParent_codes = [];
    console.log(p_bs.length);
    for(var i=0;i<p_bs.length;i++){
        var p_b = p_bs.eq(i);
        var code = p_b.data('room_code');
        var building_codeAndParent_code = '';
        building_codeAndParent_code = {
            code:code
        }
        building_codeAndParent_codes[i] = building_codeAndParent_code;
    }


    //传数据
	$.ajax({
		url:insertMaterial(),
		method:'post',
		data:{
			code:code,
			effective_date:effective_date,
			effective_status:effective_status,
			name:name,
			pcs:pcs,
            material_type:material_type,
            building_code:building_codeAndParent_codes,
            supplier:supplier,
            internal_no:internal_no,
            initial_no:initial_no,
			remark:remark,
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
                      materialList();
				  }
			});
		},
		error:function(){
			console.log('新增物资出错');
		}
	})

})





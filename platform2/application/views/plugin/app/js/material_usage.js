//////////////////////////////////////日期控件初始化////////////////////////////////
var now = new Date();
now = formatDate(now);
//新增模块的时间赋值
$('.add_Item').find('input[name="effective_date"]').val(now);


$('.date').datetimepicker({
    language:  'zh-CN',
    format: 'yyyy-mm-dd',
    weekStart: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 1
});


///////////////////////////////////////用户名初始化//////////////////////////////
var username=$('input[name="username"]').val();
username=JSON.parse(username)
$('.user span').html(username.name)


////////////////////////////////////////参数初始化赋值///////////////////////////////////////
var page = $('input[name="page"]').val();
var keyword = $('input[name="keywords"]').val()
var material_type = $('input[name="material_types"]').val();
var building_code = $('input[name="building_codes"]').val();
var parent_code = $('input[name="parent_codes"]').val();
var effective_date = $('input[name="effective_dates"]').val();

//带search的参数用于异步刷新页面时做分页和查询总条数
var search_material_type = getUrlParam('material_type');
var search_building_code = getUrlParam('building_code');
var search_parent_code = getUrlParam('parent_code');
var search_keyword = getUrlParam('keyword');
var search_effective_date = getUrlParam('effective_date');

//需要变动参数
//搜索模式url
function materialUsagebySearch(effective_date,page,material_type,building_code,parent_code,keyword){
    window.location.href="materialUsage?keyword="+keyword+"&page=1"+'&material_type='+material_type+"&building_code="+building_code+"&parent_code="+parent_code+"&effective_date="+effective_date;
}

//对应获得搜索模式数据方法的地址
function getMaterialUsagebySearch(){
    return getRootPath() + '/index.php/Material/getmaterialUsagebySearch?page=' + page+'&parent_code='+parent_code+'&building_code='+building_code+'&material_type='+material_type+'&keyword='+keyword+"&effective_date="+effective_date;
}

//搜索模式页面跳转
function PageChangeToMaterialUsage(){
    window.location.href = "materialUsage?keyword=" + search_keyword + "&page=" + page+'&material_type='+search_material_type+'&building_code='+search_building_code+'&parent_code='+search_parent_code+'&effective_date='+search_effective_date;
}


//不需要变动参数
//普通模式页面跳转
function materialUsage(){
    window.location = getRootPath() + "/index.php/Material/materialUsage"
}


//对应插入数据方法的地址
function insertMaterial(){
    return getRootPath()+'/index.php/Material/insertMaterialUsage'
}


//对应获得普通模式数据方法的地址
function getMaterialUsagebyNormal(){
   return getRootPath() + '/index.php/Material/getmaterialUsagebyNormal?page=' + page
}


//对应获得最新的code方法的地址
function getMaterialCode(){
    return getRootPath()+'/index.php/Material/getMaterialCode'
}

//对应展示楼宇信息方法的地址
function getMaterialNameCode(){
	return getRootPath()+'/index.php/Material/getMaterialNameCode'
}




/////////////////////////////////////数据展示功能/////////////////////////////////////////

//判断是普通模式还是搜索模式

    //普通模式的数据展示
    if( !$.trim(keyword) && !$.trim(material_type) && !$.trim(building_code) && !$.trim(effective_date)){
        $('#table').bootstrapTable({
            method: "get",
            undefinedText: '/',
            url: getMaterialUsagebyNormal(),
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
            url: getMaterialUsagebySearch(),
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


        PageChangeToMaterialUsage();
    })






///////////////////////////////////////搜索功能////////////////////////////////////////
$('.Search_Item_wrap .ka_drop_list li').click(function(){
    var page = $('input[name="page"]').val();
    var material_type = $(this).find('a').data('ajax');
    var building_code = $('input[name="building_codes"]').val();
    var parent_code = $('input[name="parent_codes"]').val();
    var keyword = $('input[name="keywords"]').val();
    var effective_date=$('input[name="effective_dates"]').val();


    materialUsagebySearch(effective_date,page,material_type,building_code,parent_code,keyword);

})









//////////////////////////////////////////新增功能////////////////////////////////////////
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
    var person_code = $('.add_Item ').find('.person_building_data li').data('code');
	var id = $('.add_Item ').find('input[name="id"]').val();
	//var effective_date = $('.add_Item').find('input[name="mgt_status"]').val();
	var remark = $('.add_Item').find('input[name="remark"]').val();
    var mgt_status = $('.add_Item').find("input[type='radio']:checked").val();

	/*var pcs = $('.add_Item').find('input[name="pcs"]').val();
    var material_type = $('.add_Item').find('input[name="material_type"]').data('ajax');
    var building_code = $('.add_Item').find('input[name="building_code"]').data('ajax');
	var remark = $('.add_Item').find('input[name="remark"]').val();*/

    //$('.add_material').find('input[name="effective_date"]').val();

	//remark = remark?remark:'';
	/*if(!effective_date){
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
	if($('.add_Item .effective_status input[type="radio"]').eq(0).is(':checked')){
		effective_status = 'true';
	}
	else {
		effective_status = 'false';
	}*/

	//把building_code和parent_code导入服务器



    //传数据
	$.ajax({
		url:insertMaterial(),
		method:'post',
		data:{
			id:id,
			//effective_date:effective_date,
            remark:remark,
            person_code:person_code,
            mgt_status:mgt_status
			/*pcs:pcs,
            material_type:material_type,
			remark:remark,*/
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
                      materialUsage();
				  }
			});
		},
		error:function(){
			console.log('新增物资出错');
		}
	})

})


$('.search_person_wrap .search_person_btn').click(function(){
    var name = $(this).closest('.search_person_wrap').find('.search_person_name').val();
    var search_person_wrap = $(this).closest('.search_person_wrap');
    $.ajax({
        method:'post',
        data:{
            name:name
        },
        url:getRootPath()+'/index.php/People/getPersonByName',
        //成功之后,将结果生成
        success:function(data){
            var data = data;
            //先清空之前的值
            $('.search_person_results').empty();
            if(data){
                data = JSON.parse(data);
                for(var i=0;i<data.length;i++){
                    var d = data[i];
                    var html = '<div class="single_person" data-last_name="'+d['last_name']+'" data-first_name="'+d['first_name']+'" data-code="'+d['code']+'"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a>'
                        +'<div class="fl">'
                        +'<span class="name">'+d['full_name']+'</span>'
                        +'<span class="id_number">'+d['id_number']+'</span>'
                        +'</div>';
                    console.log(html);
                    $('.search_person_results').append(html);
                }
            }
            else{
                $('.search_person_results').append("没有结果");
            }
        },
        error:function(){
            console.log('搜索出错');
        }
    })
})

//点击搜索到的住户,添加到结果列表
$(document).on('click','.search_person_results .single_person .add',function(){
    var single_person = $(this).closest('.single_person');
    var full_name = single_person.find('.name').html();
    var id_number = single_person.find('.id_number').html();
    var last_name = single_person.data('last_name');
    var first_name = single_person.data('first_name');

    var last_name = single_person.data('last_name');
    var first_name = single_person.data('first_name');
    var code = single_person.data('code');

    var html = '<li data-last_name="'+last_name+'" data-first_name="'+first_name+'" data-code="'+code +'" id="'+code+'"><span class="full_name">'+full_name+'</span><span class="id_number">'+id_number+'</span></li>';
    //只能添加一个物业人员
    if($(".person_building_data ul li").length==0){
        $('.person_building_data ul').append(html);
    }
})

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////日期控件初始化////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
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

///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////用户名初始化//////////////////////////////
///////////////////////////////////////////////////////////////////////////////
var username=$('input[name="username"]').val();
username=JSON.parse(username)
$('.user span').html(username.name)

///////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////参数与内容初始化赋值/////////////////////////
///////////////////////////////////////////////////////////////////////////////

var page = $('input[name="page"]').val();
var building_code = $('input[name="building_codes"]').val();
var parent_code = $('input[name="parent_codes"]').val();
var keyword = $('input[name="keywords"]').val()
var create_type = $('input[name="create_types"]').val();
var order_type=$('input[name="order_types"]').val();
var create_time=$('input[name="create_times"]').val();

//带search的参数用于异步刷新页面时做分页和查询总条数
var search_building_code = getUrlParam('building_code');
var search_parent_code = getUrlParam('parent_code');
var search_keyword = getUrlParam('keyword');
var search_create_time = getUrlParam('create_time');
var search_create_type = getUrlParam('create_type');
var search_order_type = getUrlParam('order_type');


//初始化搜索框的内容以及保存搜索内容
var now = getDate();
search_create_time = search_create_time?search_create_time:now;
$('.search_wrap .create_time').val(search_create_time);
$('.searc_room_text').val(search_keyword);
switch(search_create_type){
    case '101':$('.search_wrap .create_type').val('自动创建巡检工单');break;
    case '102':$('.search_wrap .create_type').val('自动创建异常处理工单');break;
    case '103':$('.search_wrap .create_type').val('循环创建工单');break;
    case '201':$('.search_wrap .create_type').val('物业人员创建工单');break;
    case '202':$('.search_wrap .create_type').val('住户/商户创建工单');break;
    default:$('.search_wrap .create_type').val('创建类型');break;
}
switch(search_order_type){
    case '101':$('.search_wrap .order_type').val('自动工单');break;
    case '201':$('.search_wrap .order_type').val('事事问物业');break;
    case '202':$('.search_wrap .order_type').val('物业帮你办');break;
    case '203':$('.search_wrap .order_type').val('异常报备');break;
    case '204':$('.search_wrap .order_type').val('投诉或建议');break;

    default:$('.search_wrap .order_type').val('工单类型');break;
}


//////////////////////////////////////////////////////////////////////////
///////////////////////////////所有的地址跳转//////////////////////////////
/////////////////////////////////////////////////////////////////////////
////////////////////////////传入参数//////////////////////////////
function href(index){
    var keys = [];
    var href='';
    for (var p in index){ keys.push(p);}
    href=index[keys[0]]+'?'+keys[1]+'='+index[keys[1]];
    if(keys.length>2)
    {
        for(var i=2;i<keys.length;i++){
            href +='&'+keys[i]+'='+index[keys[i]]
        }
    }
    return href
}



var List  = {
    method:'workorderList',
    page : 1,
    building_code: building_code,
    parent_code:parent_code,
    create_type:create_type,
    order_type:order_type,
    create_time:create_time,
    keyword:keyword
};

var getList  = {
    method:'getWorkorderList',
    page : page,
    building_code: building_code,
    parent_code:parent_code,
    create_type:create_type,
    order_type:order_type,
    create_time:create_time,
    keyword:keyword
};

var PageChangeToList={
    method:'workorderList',
    page : page,
    building_code: search_building_code,
    parent_code:search_parent_code,
    create_type:search_create_type,
    order_type:search_order_type,
    create_time:search_create_time,
    keyword:search_keyword
}

var Listhref=href(List);
var getListhref=href(getList);
var PageChangeToListhref=href(PageChangeToList)


console.log(getList)
/*

function getList(){
    return getRootPath() + '/index.php/Workorder/getWorkorderList?page=' + page+'&parent_code='+parent_code+'&building_code='+building_code+'&create_type='+create_type+'&order_type='+order_type+'&create_time='+create_time+'&keyword='+keyword;
}


function PageChangeToList(page){
    window.location.href = "workorderList?keyword=" + search_keyword + "&page=" + page+'&create_type='+search_create_type+'&building_code='+search_building_code+'&parent_code='+search_parent_code+'&create_time='+search_create_time+'&order_type='+search_order_type;
}
*/


//////////////////方法///////////////////////
//对应获得协同人和管家
function getOrderRecordPerson(){
    return getRootPath()+'/index.php/Workorder/getOrderRecordPerson'
}
//对应展示楼宇信息方法的地址
function getBuildingCode(){
	return getRootPath()+'/index.php/Workorder/getMaterialBuildingCode'
}

///////////搜索框X的href赋值//////////////
$('#clear').attr("href",'workorderList')


//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////调用函数//////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////








////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////数据展示功能/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////普通模式的数据展示/////////////////////////



    ///////////////////////////////////数据展示///////////////////////

        $('#table').bootstrapTable({
            method: "get",
            undefinedText: '/',
            url: getListhref,
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


/////////////////////////////////////////////分页//////////////////////////////
    $('.fenye_btn').click(function(){
        var page = $('input[name="fenye_input"]').val();
        if(!/^[0-9]*$/.test(page)){
            openLayer('请输入数字');
            $('input[name="fenye_input"]').val('');
            return;
        }
        var pagenumber=Number(page)+"";
        var myCurrent = $('#current').text().split('/')[0];
        var myTotal = $('#current').text().split('/')[1];
        if(page!=pagenumber) {
            $('input[name="fenye_input"]').val(pagenumber);
            page=pagenumber;
        }
        if(Number(page)>Number(myTotal)) {
            $('input[name="fenye_input"]').val(myTotal);
            page=myTotal;
        }
        if(Number(page)<1) {
            openLayer('请输入合法页数');
            $('input[name="fenye_input"]').val('');
            return;
        }
        window.location.href=PageChangeToListhref;
    })

////////////////////////////////////////////信息管理////////////////////////////////

    window.operateEvents = {
        'click .detail': function (e, value, row, index) {
            $('#person_detail').modal('show');
            var work_code = row.work_code;
            var create_type_name = row.create_type_name;
            var create_time = row.w_o_create_time;
            var create_person_name = row.create_person_name;
            var order_type_name = row.order_type_name;
            var accept_person_name = row.accept_person_name;
            var accept_time = row.accept_time;
            var work_state_name = row.work_state_name;
            var team_person_code=row.team_person_code;
            var property_person_code=row.property_person_code;
            var onsite_time=row.onsite_time;
            var if_false_name=row.if_false_name;
            var complete_time=row.complete_time;
            var process_pic=row.process_pic;
            var confirm_time=row.confirm_time;
            var comment_time=row.comment_time;
            var comment_score_name=row.comment_score_name;
            var comment=row.comment;
            var e_name=row.e_name;
            var process_pic=row.process_pic;
            process_pic=JSON.parse(process_pic);
            var html="";
            if(process_pic){
            for (var i=0;i<process_pic.length;i++) {
                html += "<img src=" + process_pic[i] + " width=200px; height=200px >";
            }
            }
            $('#person_detail').find('.work_code').html(work_code);
            $('#person_detail').find('.create_type_name').html(create_type_name);
            $('#person_detail').find('.create_time').html(create_time);
            $('#person_detail').find('.create_person_name').html(create_person_name);
            $('#person_detail').find('.order_type_name').html(order_type_name);
            $('#person_detail').find('.accept_person_name').html(accept_person_name);
            $('#person_detail').find('.accept_time').html(accept_time);
            $('#person_detail').find('.work_state_name').html(work_state_name);
            $('#person_detail').find('.onsite_time').html(onsite_time);
            $('#person_detail').find('.if_false_name').html(if_false_name);
            $('#person_detail').find('.complete_time').html(complete_time);
            $('#person_detail').find('.process_pic').html(process_pic);
            $('#person_detail').find('.confirm_time').html(confirm_time);
            $('#person_detail').find('.comment_time').html(comment_time);
            $('#person_detail').find('.comment_score_name').html(comment_score_name);
            $('#person_detail').find('.comment').html(comment);
            $('#person_detail').find('.e_name').html(e_name);
            $('#person_detail').find('.process_pic').html(html);
            $.ajax({
                data:{
                    team_person_code:team_person_code,
                    property_person_code:property_person_code
                },
                method:'post',
                url:getOrderRecordPerson(),
                //成功之后,将结果生成
                success:function(data){
                    var data = JSON.parse(data);
                    var team_person_name=data.team_person_last_name+data.team_person_first_name;
                    var property_person_name=data.property_person_last_name+data.property_person_first_name;
                    $('#person_detail').find('.team_person_name').html(team_person_name);
                    $('#person_detail').find('.property_person_name').html(property_person_name);
                },
                error:function(){
                }
            })


        }
    }






//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////搜索功能////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


///////////////////////搜索时间//////////////////

///////////////////////搜索时间////////////////
$('.search_wrap .create_time').datetimepicker().on('changeDate',function(e){
    var create_time=$('input[name="create_time"]').val();
    create_time=create_time +' 23:59:59';
    List.create_time=create_time
    window.location.href=href(List)
})

/////////////////////搜索创建类型////////////////
$(' .create_type_search_wrap .ka_drop_list li').click(function(){
    var create_type = $(this).find('a').data('ajax');
    List.create_type=create_type
    window.location.href=href(List)

})

/////////////////搜索工单类型////////////
$('.order_type_search_wrap .ka_drop_list li').click(function(){
    var order_type =$(this).find('a').data('ajax');
    List.order_type=order_type
    window.location.href=href(List)
})

////////////////搜索楼宇///////////////////
//树节点点击后跳转到相应的楼宇列表页面
$('#treeNav>span').on("select_node.jstree", function (e, node) {
    var building_code=node.node.original.code;
    var parent_code=node.node.original.code;
    List.building_code=building_code
    List.parent_code=parent_code
    window.location.href=href(List)
})






/*
//////////////////////////////////////////新增功能////////////////////////////////////////
//点击新增按钮,从后端取得楼宇编号信息
$('.add_btn').click(function(){
    $.ajax({
        url:getMaterialLatestCode(),
        success:function(data){
            if(parseInt(data)){
                var code = parseInt(data) + 1;
            }else{
                var code = 1000001;
            }
            $('.add_Item .code').html(code);
        }
    })
})



//动态获取所有楼宇信息
$('.select_parent_code').click(function(){
    $.ajax({
        type:"POST",
        url : getBuildingCode(),
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

////////////////////////////////在新增功能内点击树形菜单的效果////////////////////
//树节点点击后将节点赋值
$('#treeNavAdd>span,#treeNavWrite>span').on("select_node.jstree", function (e, node) {
    $('#treeNavWrite>span').jstree("close_all")
    var arr = node.node.id.split("_");
    var parent_code = arr[0];
    //当前节点的id
    var id = arr[1];
    //当前节点的文本值
    var name = node.node.text;
    //当前节点的房号code
    var room_code = node.node.original.code;
    console.log(room_code);
    console.log(node.node);
    // console.log($(this));
    //当前对象为包裹层元素(这里是span)
    var that = $(this);

    //父节点数组
    var parents_arr = node.node.parents;
    if (parents_arr.length == 3) {
        //表示到了室这一层级,需要获取到父节点,把父节点的名称拼接
        var imm_id = parents_arr[0];
        var imm_node = that.jstree("get_node", imm_id);
        var imm_name = imm_node.text;
        console.log(imm_node);
    }
    //表示是栋这一层级
    else if (parents_arr.length == 2) {

    }

    imm_name = imm_name ? imm_name : '';
    var html_tmp = "<em id=" + id + " data-room_code=" + room_code + ">" + imm_name + name + "<i class='fa fa-close'></i></em>";
    console.log(html_tmp);
    /*   if (that.closest('.model_content').find('.select_buliding #' + id).length == 0) {
           that.closest('.model_content').find('.select_buliding').append(html_tmp);
       }*/
/*
if($('.model_content').find('.select_buliding em i').length==0){
    $('.model_content').find('.select_buliding').append(html_tmp);
}

     if($(".person_building_data ul #"+code).length==0){
         $('.person_building_data ul').append(html);
     }


})

//点击删除当前节点
$('.select_buliding_wrap').on('click', '.select_buliding em i', function () {
    $(this).closest('em').remove();
})


//点击保存新增楼宇信息
$('#add_Item .confirm').click(function(){

	var code = $('.add_Item .code').html();
	var effective_date = $('.add_Item').find('input[name="effective_date"]').val();
	var name = $('.add_Item').find('input[name="name"]').val();
	var pcs = $('.add_Item').find('input[name="pcs"]').val();
    var material_type = $('.add_Item').find('input[name="material_type"]').data('ajax');
    var building_code = $('.add_Item').find('input[name="building_code"]').data('ajax');
    var materialfunction = $('.add_Item').find('input[name="function"]').val();
    var supplier = $('.add_Item').find('input[name="supplier"]').val();
    var internal_no = $('.add_Item').find('input[name="internal_no"]').val();
    var initial_no = $('.add_Item').find('input[name="initial_no"]').val();
	var remark = $('.add_Item').find('input[name="remark"]').val();
    var p_bs = $('.add_Item').find('.select_buliding em');
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
	if($('.add_Item .effective_status input[type="radio"]').eq(0).is(':checked')){
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
		url:insert(),
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
            materialfunction:materialfunction,
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
                     /!* asynRefreshPage(getRootPath()+'/index.php/Material/materialList','Material/getMaterialList',table,data.total,'&keyword='+search_keyword);*!/
                      materialList();
				  }
			});
		},
		error:function(){
			console.log('新增物资出错');
		}
	})

})

*/





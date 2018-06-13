///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////用户名初始化//////////////////////////////
///////////////////////////////////////////////////////////////////////////////
var username=$('input[name="username"]').val();
username=JSON.parse(username)
$('.user span').html(username.name)


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
/////////////////////////////////上面不用改////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////参数与内容初始化赋值/////////////////////////
///////////////////////////////////////////////////////////////////////////////
//初始化参数       /*********************************需要改动********************/
function platform() {
   return   {
       index:{
                method: '',
                page: '',
                building_code: '',
                parent_code: '',
                keyword: '',
                create_type: '',
                order_type: '',
                create_time: ''
        },

        findIndex:function () {
                    for (var n in this.index) {
                    var name = n + 's';
                    this.index[n] = $('input[name=' + name + ']').val();
                    }
                 return this.index
        },
        findUrlParam:function () {
        for (var n in this.index) {
            this.index[n] = getUrlParam(n);
        }
        return this.index
    }
}
}

//初始化信息管理参数 /*********************************需要改动********************/
var rowkeys={
    work_code:'',
    create_type_name:'',
    create_time :'',
    create_person_name:'',
    order_type_name :'',
    accept_person_name:'',
    accept_time:'',
    work_state_name :'',
    team_person_code:'',
    property_person_code :'',
    onsite_time :'',
    if_false_name:'',
    complete_time:'',
    process_pic:'',
    confirm_time:'',
    comment_time:'',
    comment_score_name:'',
    comment:'',
    e_name:'',
    process_pic:''
}


//初始化路径  /*********************************需要改动********************/
var router={
    List:'workorderList',
    getList:'getWorkorderList',
    getOrderRecordPerson:getRootPath()+'/index.php/Workorder/getOrderRecordPerson',
    getMaterialBuildingCode:getRootPath()+'/index.php/Workorder/getMaterialBuildingCode',
}



//初始化搜索框的内容以及保存搜索内容  /*********************************需要改动********************/
var index=new platform();
var indexFromphp=index.findIndex();//从后端获取的参数
var param=index.findUrlParam();  //从url获取的参数

var init_time=param.search_create_time
var init_keyword=param.search_keyword
var init_search_index_1=param.search_create_type
var init_search_index_2=param.search_order_type

//初始化时间
var now = getDate();
init_time = init_time?init_time:now;
$('.search_wrap .create_time').val(init_time);


//初始化输入框
$('.searc_room_text').val(init_keyword);


//初始化第一类搜索条件  /*********************************需要改动********************/
switch(init_search_index_1){
    case '101':$('.search_wrap .search_1').val('自动创建巡检工单');break;
    case '102':$('.search_wrap .search_1').val('自动创建异常处理工单');break;
    case '103':$('.search_wrap .search_1').val('循环创建工单');break;
    case '201':$('.search_wrap .search_1').val('物业人员创建工单');break;
    case '202':$('.search_wrap .search_1').val('住户/商户创建工单');break;
    default:$('.search_wrap .search_1').val('创建类型');break;
}

//初始化第二类搜索条件
switch(init_search_index_2){
    case '101':$('.search_wrap .search_2').val('自动工单');break;
    case '201':$('.search_wrap .search_2').val('事事问物业');break;
    case '202':$('.search_wrap .search_2').val('物业帮你办');break;
    case '203':$('.search_wrap .search_2').val('异常报备');break;
    case '204':$('.search_wrap .search_2').val('投诉或建议');break;
    default:$('.search_wrap .search_2').val('工单类型');break;
}


//////////////////////////////////////////////////////////////////////////
///////////////////////////////所有的地址跳转//////////////////////////////
/////////////////////////////////////////////////////////////////////////
////////////////////////////传入参数//////////////////////////////

///*********************************需要改动********************/
var List  =  new platform();
    List.findIndex()
    List.index.method=router.List
    List.index.page=1
    List=List.index

var getList  =  new platform();
getList.findIndex()
getList.index.method=router.getList
getList=getList.index

var PageChangeToList  =  new platform();
PageChangeToList.findUrlParam()
PageChangeToList.index.method=router.List
PageChangeToList=PageChangeToList.index


var getListhref=href(getList);
var PageChangeToListhref=href(PageChangeToList)



///////////搜索框X的href赋值//////////////
$('#clear').attr("href",router.List)




///////////////获取href//////////////
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
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////调用函数/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
///*********************************需要改动********************/
showdata(getListhref)
information(router,rowkeys)
pageChange(PageChangeToListhref)
search(List,'creat_time','building_code','parent_code','create_type','order_type','keyword')


////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////数据展示功能/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////普通模式的数据展示/////////////////////////
    ///////////////////////////////////数据展示///////////////////////

function showdata(getListhref){
        $('#table').bootstrapTable({
            method: "get",
            undefinedText: '/',
            url: getListhref,
            dataType: 'json',
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
/////////////////////////////////////////////分页//////////////////////////////

function pageChange(PageChangeToListhref){
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
}
////////////////////////////////////////////信息管理////////////////////////////////
function information(router,rowkeys){
    window.operateEvents = {
        'click .detail': function (e, value, row, index) {
            $('#person_detail').modal('show');
            var keys=[];
            for (var p in row){ keys.push(p);}
            for(var i=0;i<keys.length;i++){
                for(var n in rowkeys){
                    if(n==keys[i])
                        rowkeys[n]=row[n]
                }
            };

///////////////////////////////////从二维码中获取图片/////////////////////////////////
            var process_pic=rowkeys.process_pic;
          process_pic=JSON.parse(process_pic);
            var html="";
            if(process_pic){
            for (var i=0;i<process_pic.length;i++) {
                html += "<img src=" + process_pic[i] + " width=200px; height=200px >";
            }
            }
            rowkeys.process_pic=html;
///////////////////////////////////调用ajax获取其他信息/////////////////////////////////
            $.ajax({
                data:{
                    team_person_code:rowkeys.team_person_code,
                    property_person_code:rowkeys.property_person_code
                },
                method:'post',
                url:router.getOrderRecordPerson,
                //成功之后,将结果生成
                success:function(data){
                    var data = JSON.parse(data);
                    var team_person_name=data.team_person_last_name+data.team_person_first_name;
                    var property_person_name=data.property_person_last_name+data.property_person_first_name;
                    rowkeys.team_person_name=team_person_name
                    rowkeys.property_person_name=property_person_name

                },
                error:function(){
                }
            })
/////////////////////////////////////////////展示////////////////////////////////////////////
            for(var n in rowkeys){
                $('#person_detail').find('.'+ n ).html(rowkeys[n]);
            }
        }
    }

}




//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////搜索功能////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
function search(){
    var  len=arguments.length
    var List=arguments[0]
    keys=[]
    for (var i=1;i<len;i++){
        keys[i]=arguments[i]
    }

///////////////////////搜索时间//////////////////
$('.search_wrap .create_time').datetimepicker().on('changeDate',function(e){
    var name= keys[1];
    var time=$('input[name='+name+']').val();
    time=time +' 23:59:59';
    List[keys[1]]=time
    window.location.href=href(List)
})



////////////////搜索楼宇///////////////////
//树节点点击后跳转到相应的楼宇列表页面
$('#treeNav>span').on("select_node.jstree", function (e, node) {
    var building_code=node.node.original.code;
    var parent_code=node.node.original.code;
    List[keys[2]]=building_code
    List[keys[3]]=parent_code
    window.location.href=href(List)
})



/////////////////////搜索创建类型////////////////
$(' .search_wrap_1 .ka_drop_list li').click(function(){
    var search_index_1 = $(this).find('a').data('ajax');
    List[keys[4]]=search_index_1
    window.location.href=href(List)

})

/////////////////搜索工单类型////////////
$('.search_wrap_2 .ka_drop_list li').click(function(){
    var search_index_2 =$(this).find('a').data('ajax');
    List[keys[5]]=search_index_2
    window.location.href=href(List)
})

///////////////////输入框搜索不在此处，在初始化的位置///////////////////////
    $('.search_room button[type="submit"]').click(function(e){
        e.preventDefault()
        var keyword = $('.search_room .searc_room_text').val();
        keyword = trim(keyword);
        if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
            openLayer('搜索框只能输入数字、汉字、字母!');
            return;
        }else{
        List[keys[6]]=keyword
            console.log( List[keys[6]])
        window.location.href=href(List)
        }
    })
    //清除搜索条件
    $('.search_room #clear').click(function(){
        window.location.href=href(List);
    })
}




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





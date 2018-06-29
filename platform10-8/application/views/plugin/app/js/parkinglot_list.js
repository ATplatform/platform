///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////初始化//////////////////////////////
///////////////////////////////////////////////////////////////////////////////

/*
must:是否必填
method:填入的内容（show：不可修改，time：时间，select：下拉列表,input:输入，radio:单选，other:独立html）
input:中文含义
ajax: (当method为select时独有，表示下拉框的data-ajax值与中文)
option:(当method为radio时独有，表示单选的内容与中文)
 */



var platform_index={
    a_code:{
        must:'yes',
       //search:'no',
        must:'yes',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'车位编号',
        method:'show',

    },
    a_name:{
        must:'yes',
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'生效日期',
        method:'time'
    },
    begin_date_name:{
        must:'yes',
       // search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'状态',
        method:'radio',
        option:{true:'有效',false:'无效'}
    },
    lot_parkcode:{
        must:'yes',
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'停车场',
        method:'select',
        ajax:{}
    },
    lot_floor: {
        must:'yes',
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'所属车库楼层',
        method:'select',
        ajax:{101:'地面',102:'地下一层'}
    },
    lot_biz_type: {
        must:'yes',
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'住宅/商业',
        method:'select',
        ajax:{101:'住宅',102:'商业'}
    },
    lot_begin_date:{
       // search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'占用开始时间',
        method:'time'
    },
    lot_end_date:{
       // search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'占用结束时间',
        method:'time'
    },

    lot_biz_status:{
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'车位状态',
        method:'select',
        ajax:{101:'已占用',102:'公共车位'}
    },
    lot_biz_reason:{
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'占位原因',
        method:'select',
        ajax:{101:'已出售',102:'租赁中',103:'被占用'}
    },

    lot_linked_lot_code:{
        //search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'关联车位',
        method:'input'
    },

    lot_area:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'车位面积',
        method:'input'
    },
    lot_monthly_rent:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'车位租金',
        method:'input'
    },
    lot_owner:{
        //search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'占用人',
        method:'select',
        ajax:''
    },
    lot_remark:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'备注',
        method:'input'
    },
    keyword:{
        search:'yes',
        show:'no',
        detail:'no',
        update:'no',
        input:'可输入车位编码、占用人进行搜索',
        method:'keyword'
    },
    update_info:{
        title:'车位详情',
        small_title:'车位信息'
    },
    detail_info:{
        detail:{title:'详情',img:' fa-file-text-o'},
        rewrite:{title:'更新授权信息',img:' fa-pencil-square-o'}
        },
    username:{method:'username'},
    pagechange:{
        urlparam:{route:'',page:''},
        pagesize:'',
        total:'',
    },
    router:{
       /* List:'activityList',
        getList:'getList',
        insert:'insert',
        getservice_code:'getservice_code',
        getOrderRecordPerson: getRootPath()+'/index.php/Contract/getOrderRecordPerson',
        getLatestCode:getRootPath()+'/index.php/Activity/getLatestCode',
        getadditionalUrl:getRootPath()+'/index.php/Contract/getadditionalUrl',*/



        root:getRootPath()+'/index.php/Activity/activityList',
        get:getRootPath()+'/index.php/Activity/getList',
        insert:getRootPath()+'/index.php/Activity/insert',
        updateParkinglot:'updateParkinglot',
        updateAuz:'updateAuz',
        getparkingcode:'getservice_code',
        getservice_code:'getservice_code',
        getpresentCodeforauz:'getpresentCodeforauz',
        getauzbyMax_begin_date:'getauzbyMax_begin_date',
        getOrderRecordPerson: getRootPath()+'/index.php/Contract/getOrderRecordPerson',
        getLatestCode:getRootPath()+'/index.php/Vehicle/getLatestCode',
        getLatestCodeforauz:getRootPath()+'/index.php/Vehicle/getLatestCodeforauz',
        getadditionalUrl:getRootPath()+'/index.php/Contract/getadditionalUrl',
    }



}

//html 与后台数据无关
var render=new html_render(platform_index)
$('#search_wrap').append(render.search_html)
$('#person_detail .model_content').append(render.detail_html)
$('#rewrite .rewrite').append(render.update_html)


function operateFormatter(render){
    var html=''
    for(var n in render.detail_info)
    {
        html+='<a class="'+n+'" href="javascript:void(0)" style="margin-left: 10px;" title="'+render.detail_info[n]['title']+'">',
            '<i class=" fa   '+render.detail_info[n]['img']+' fa-lg"></i>',
            '</a>';
    }

    return html

     /*[
        '<a class="rewrite" href="javascript:void(0)" style="margin-left: 10px;"   title="更新授权信息">',
        '<i class="fa  fa-pencil-square-o fa-lg "></i>',
        '</a>',
    ].join('')*/;
}


function information(location,router,rowkeys) {

    window.operateEvents = {
        'click .detail': function (e, value, row, index) {

            $(location).modal('show');
            var keys = [];
            for (var p in row) {
                keys.push(p);
            }
            /*for (var i = 0; i < keys.length; i++) {
                for (var n in rowkeys) {
                    if (n == keys[i])
                        rowkeys[n] = row[n]
                }
            }*/
            console.log(rowkeys)

/////////////////////////////////////////////展示////////////////////////////////////////////
            for (var n in rowkeys) {
                // if(!rowkeys[n]) {rowkeys[n]='无'}
                $(location).find('.' + n).html(rowkeys[n]);
            }
////////////////////////////////////////附件处理//////////////////////////////////////////////////
            var code = rowkeys.v_code

            console.log(code)
            $("#getauz").bootstrapTable('destroy');
            $('#getauz').bootstrapTable({
                method: "get",
                undefinedText: '/',
                cache: false,
                url: router.getauz,
                queryParams: {
                    code: code
                }
                ,
                contentType: "application/x-www-form-urlencoded",
                responseHandler: function (res) {
                    //用于处理后端返回数据
                    console.log('1');
                    console.log(res);
                    return res;
                },
                onLoadSuccess: function (data) {  //加载成功时执行
                    console.log('2');
                    console.log(data);
                },
                onLoadError: function () {  //加载失败时执行
                    console.info("加载数据失败");
                }
            })
        },

        'click .rewrite': function (e, value, row, index) {

            $('#rewrite').modal('show');
            var keys = [];
            for (var p in row) {
                keys.push(p);
            }
            for (var i = 0; i < keys.length; i++) {
                for (var n in rowkeys) {
                    if (n == keys[i])
                        rowkeys[n] = row[n]
                }
            }
            console.log(rowkeys)


/////////////////////////////////////////////展示////////////////////////////////////////////
            $('#rewrite .lot_code').html(rowkeys['lot_code']);
            var update = new platform();
            update = update.showupdate()
            console.log(update)
            for(var n in update){
                if(update[n].method=="input"||update[n].method=="time"){
                    $('#rewrite').find('input[name=' + n + ']').val(rowkeys[n]);
                }
                if(update[n].method=="select"){
                    $('#rewrite').find('.' + n).data('ajax', rowkeys[n]);
                    $('#rewrite').find('.' + n).val(rowkeys[n + '_name']);
                }
                if(update[n].method=="radio"){
                    if (rowkeys[n] === 't') {
                        $('#rewrite').find('.' + n + ' input[type="radio"]').eq(0).prop("checked", true)
                        $('#rewrite').find('.' + n + ' input[type="radio"]').eq(1).prop("checked", false)
                    }
                    else {
                        $('#rewrite').find('.' + n + ' input[type="radio"]').eq(0).prop("checked", false)
                        $('#rewrite').find('.' + n + ' input[type="radio"]').eq(1).prop("checked", true)
                    }
                }
            }


            $('#rewrite .lot_code').html(rowkeys['lot_code']);
            $('#rewrite .lot_parkcode').val(rowkeys['par_parkname']);
            $('#rewrite .lot_parkcode').data('ajax', rowkeys['lot_parkcode']);
            $('#rewrite .lot_owner').val(rowkeys['lot_owner_fullname']);
            $('#rewrite .lot_owner').data('ajax', rowkeys['lot_owner_name']);


            $('#rewrite').find('input[name=lot_effective_date]').val(rowkeys['lot_effective_date_name']);
            /*  $('#rewrite').find('.lot_owner').val(rowkeys['lot_owner_fullname']);
              $('#rewrite').find('.lot_').val(rowkeys['vehicle_type_name']);*/

        }

    }
//url查询参数 与后台数据无关
pageChange(render)

//获取详情后台数据，并展示


getdata('.rewrite',render)





//初始化信息管理参数
var rowkeys={
    lot_code_name:null,
    lot_effective_date_name:null,
    lot_remark_name:null,
    lot_linked_lot_code_name:null,
    lot_begin_date_name:null,
    lot_end_date_name:null,
    lot_area_name:null,
    lot_monthly_rent_name:null,


    par_parkname:null,
    lot_floor_name: null,
    lot_biz_type_name: null,
    lot_biz_status_name:null,
    lot_biz_reason_name:null,
    lot_owner_fullname:null,
    lot_owner_name:null,

    lot_effective_status_name:null,

    lot_code:null,
    lot_effective_date:null,
    lot_remark:null,
    lot_linked_lot_code:null,
    lot_begin_date:null,
    lot_end_date:null,
    lot_area:null,
    lot_monthly_rent:null,

    lot_parkcode:null,
    par_parkname:null,
    lot_floor: null,
    lot_biz_type: null,
    lot_biz_status:null,
    lot_biz_reason:null,
    lot_owner_fullname:null,
    lot_owner:null,

    lot_effective_status:null,

}



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
/////////////////////////////////////参数与内容初始化赋值/////////////////////////
///////////////////////////////////////////////////////////////////////////////
//初始化参数       /*********************************需要改动********************/
function platform() {
    return   {
        urlParam:{
            method: '',
            page: '',
            keyword: '',
            lot_effective_date: '',
            lot_parkcode: '',
            lot_floor: '',
            lot_biz_type:'',
            lot_biz_status:'',
            lot_biz_reason:''
        },
        insert:{
            input:{

                },
            select:{

                },
            radio:{

            }  ,
            must:{

            }
        },
        update:{
            lot_code:{must:'yes',method:'show',input:'车位编号'},
            lot_effective_date:{must:'yes',method:'time',input:'生效时间'},
            lot_effective_status:{must:'yes',input:'状态',method:'radio',option:{true:'有效',false:'无效'}},
            lot_parkcode:{must:'yes',method:'select',input:'停车场',ajax:''},
            lot_floor:{must:'yes',method:'select',input:'车库楼层',ajax:{101:'地面',102:'地下一层'}},
            lot_owner:{must:'yes',method:'select',input:'占用人',ajax:''},
            lot_begin_date:{must:'yes',method:'time',input:'占用开始时间'},
            lot_end_date:{must:'yes',method:'time',input:'占用结束时间'},
            lot_biz_type:{must:'yes',method:'select',input:'住宅/商业',ajax:{101:'住宅',102:'商业'}},
            lot_biz_status:{must:'yes',method:'select',input:'车位状态',ajax:{101:'已占用',102:'公共车位'}},
            lot_biz_reason:{must:'',method:'select',input:'占位原因',ajax:{101:'已出售',102:'租赁中',103:'被占用'}},
            lot_linked_lot_code:{must:'',method:'input',input:'关联车位'},
            lot_monthly_rent:{must:'',method:'input',input:'车位租金'},
            lot_area:{must:'',method:'input',input:'车位面积'},
            lot_remark:{must:'',method:'input',input:'备注'}
        },
        pagechange:{
            page:'',
            pagesize:'',
            total:''
        }
       ,
        findUrlParam:function () {
            for (var n in this.urlParam) {
                this.urlParam[n] =  getUrlParam(n);
            }
            return this.urlParam
        },
        /*findinsert:function(){
            for (var n in this.insert.input) {
                this.insert.input[n] = $('.add_Item').find('input[name='+n+']').val();
                this.insert.input[n]?this.insert.input[n]:null;

            }
            for (var n in this.insert.select) {
                this.insert.select[n] = $('.add_Item').find('input[name='+n+']').data('ajax');
                this.insert.select[n]? this.insert.select[n]:null;
            }
            for (var n in this.insert.radio) {

                if($('.add_Item .'+n+' input[type="radio"]').eq(0).is(':checked')){
                    this.insert.radio[n] = 'true';
                }
                else {
                    this.insert.radio[n] = 'false';
                }

            }

            for (var n in this.insert.must) {
                var must=null;
                if(this.insert.input[n]){    must= this.insert.input[n]}
                if(this.insert.select[n]){   must= this.insert.select[n]}
                if(this.insert.radio[n]){    must= this.insert.radio[n]}
                this.insert.must[n]['value'] = must

            }
            console.log(this)
            for(var n in this.insert.must){
                if(this.insert.must[n]['method'] ){
                    this.insert.must[n]['value']=$('.add_Item .'+n).html()
                    this.insert.input[n]=$('.add_Item .'+n).html()
                }else{
                    if(!this.insert.must[n]['value'] ) {openLayer(this.insert.must[n]['input']);return;}
                }
            }


            return this.insert
        },*/
        showupdate:function(){
            for(var n in this.update) {
                if (this.update[n].method == "input" || this.update[n].method == "time") {
                    this.update[n].value = $('.rewrite').find('input[name=' + n + ']').val();
                    this.update[n].value ? this.update[n].value : null;

                }
                if (this.update[n].method == "select") {
                    this.update[n].value = $('.rewrite').find('input[name=' + n + ']').data('ajax');
                    this.update[n] ? this.update[n] : null;
                }
                if (this.update[n].method == "radio") {
                    if ($('.rewrite .' + n + ' input[type="radio"]').eq(0).is(':checked')) {
                        this.update[n].value = 'true';
                    }
                    else {
                        this.update[n].value = 'false';
                    }
                }
            }
            return this.update
        },
        findpage:function () {
            for (var n in this.pagechange) {
                this.pagechange[n] = $('input[name=' + n + ']').val();
            }
            return this.pagechange
        }
    }
}





//初始化路径  /*********************************需要改动********************/
var router={
    List:getRootPath()+'/index.php/Activity/activityList',
    getList:getRootPath()+'/index.php/Activity/getList',
    insert:'insert',
    updateParkinglot:'updateParkinglot',
    updateAuz:'updateAuz',
    getparkingcode:'getservice_code',
    getservice_code:'getservice_code',
    getpresentCodeforauz:'getpresentCodeforauz',
    getauzbyMax_begin_date:'getauzbyMax_begin_date',
    getOrderRecordPerson: getRootPath()+'/index.php/Contract/getOrderRecordPerson',
    getLatestCode:getRootPath()+'/index.php/Vehicle/getLatestCode',
    getLatestCodeforauz:getRootPath()+'/index.php/Vehicle/getLatestCodeforauz',
    getadditionalUrl:getRootPath()+'/index.php/Contract/getadditionalUrl',
}




//////////////////////////////////////////////////////////////////////////
///////////////////////////////所有的地址跳转//////////////////////////////
/////////////////////////////////////////////////////////////////////////
////////////////////////////传入参数//////////////////////////////

///*********************************需要改动********************/
var List  =  new platform();
List.findUrlParam()
List.urlParam.method=router.List
List.urlParam.page=1
List=List.urlParam

var getList  =  new platform();
getList.findUrlParam()
getList.urlParam.method=router.getList
getList=getList.urlParam

var PageChangeToList  =  new platform();
PageChangeToList.findUrlParam()
PageChangeToList.urlParam.method=router.List
PageChangeToList=PageChangeToList.urlParam

var Listhref=href(List);
var getListhref=href(getList);
var PageChangeToListhref=href(PageChangeToList)







////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////调用函数/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
///*********************************需要改动********************/
    getListhref=getRootPath()+'/index.php/Activity/getList'
showdata(getListhref)
information(router,rowkeys)
pageChange(PageChangeToListhref)

search(List,'lot_effective_date','lot_parkcode','lot_floor','lot_biz_type','lot_biz_status','lot_biz_reason','keyword')
insert(router.getLatestCode,router.getLatestCodeforauz,router.insert,router.getservice_code,List)

////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////数据展示功能/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////普通模式的数据展示/////////////////////////
///////////////////////////////////数据展示///////////////////////

function showdata(getListhref){
    console.log('1')
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


////////////////////////////////////////////信息管理////////////////////////////////






    var updateinsert=function (){

        return updateinsert
    }


    $('#rewrite .confirm').click(function (){
        var update = new platform();
        update = update.showupdate()

        var updateinsert = {}
        for (var n in update.input) {
            updateinsert = update[n].value
            }




        updateinsert.lot_code = $('#rewrite .lot_code').html();
        console.log('updateinsert')
        console.log(updateinsert)

                $.ajax({
                    url: router.updateParkinglot,
                    method: 'post',
                    data: updateinsert,
                    success: function (data) {
                        //var data = JSON.parse(data);
                        //成功之后自动刷新页面
                        $('#rewrite').modal('hide');
                        layer.open({
                            type: 1,
                            title: false,
                            //打开关闭按钮
                            closeBtn: 1,
                            shadeClose: false,
                            skin: 'tanhcuang',
                            content: '更新车位信息成功',
                            cancel: function () {
                                window.location.href = href(List);
                            }
                        });
                    },
                    error: function () {
                        console.log('更新车位信息出错');
                    }
                })
    //传数据
    })

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
    $('.search_wrap .select_time').datetimepicker().on('changeDate',function(e){
        var name= keys[1];
        var time=$('input[name='+name+']').val();
        List[keys[1]]=time
        window.location.href=href(List)
    })
/*
///////////////////////搜索地点//////////////////
    $('#treeNav>span').on("select_node.jstree", function (e, node) {
        var building_code=node.node.original.code;
        var parent_code=node.node.original.code;
        List[keys[2]]=building_code
        List[keys[3]]=parent_code
        window.location.href=href(List)
    })
*/



/////////////////////搜索创建类型////////////////
    $(' .search_wrap_1 .ka_drop_list').click(function(){
        var search_index = $(this).find('a').data('ajax');
        List[keys[2]]=search_index
        console.log(List)
        window.location.href=href(List)

    })

/////////////////搜索工单类型////////////
    $('.search_wrap_2 .ka_drop_list li').click(function(){
        var search_index =$(this).find('a').data('ajax');
        List[keys[3]]=search_index
        window.location.href=href(List)
    })


    $('.search_wrap_3 .ka_drop_list li').click(function(){
        var search_index =$(this).find('a').data('ajax');
        List[keys[4]]=search_index
        window.location.href=href(List)
    })
    $('.search_wrap_4 .ka_drop_list li').click(function(){
        var search_index =$(this).find('a').data('ajax');
        List[keys[5]]=search_index
        window.location.href=href(List)
    })
    $('.search_wrap_5 .ka_drop_list li').click(function(){
        var search_index =$(this).find('a').data('ajax');
        List[keys[6]]=search_index
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
            List[keys[7]]=keyword
            console.log( List[keys[7]])
            window.location.href=href(List)
        }
    })
    //清除搜索条件
    $('.search_room #clear').click(function(){
        window.location.href=href(List);
    })

}


///动态获取物业负责人
    $.ajax({
        type: "POST",
        url: platform_index.router.getparkingcode,
        dataType: "text",
        success: function (message) {
            var data = JSON.parse(message);
            console.log(message)
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                var par_parkname = d['par_parkname'];
                var lot_parkcode = d['lot_parkcode']
                if ($("#rewrite .lot_parkcode  #" + lot_parkcode).length == 0) {
                    $('#rewrite .lot_parkcode  ul').append('<li><a href="javascript:;" id=' + lot_parkcode + ' data-ajax=' + lot_parkcode + '>' + par_parkname + '</a></li>');
                }
                if ($("#search_wrap .lot_parkcode  #" + lot_parkcode).length == 0) {
                    $('#search_wrap .lot_parkcode  ul').append('<li><a href="javascript:;" id=' + lot_parkcode + ' data-ajax=' + lot_parkcode + '>' + par_parkname + '</a></li>');
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    })


//////////////////////////////////////////新增功能////////////////////////////////////////
//点击新增按钮,从后端取得楼宇编号信息
function insert(){
   var getLatestCodeUrl=arguments[0];
   var getLatestCodeforauzUrl=arguments[1]
   var insertUrl=arguments[2];
   var getservice_codeUrl=arguments[3];
   var ListUrl=arguments[4];


$('.add_btn').click(function(){
    $.ajax({
        url:getLatestCodeUrl,
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


    $('.add_btn').click(function(){
        $.ajax({
            url:getLatestCodeforauzUrl,
            success:function(data){
                if(parseInt(data)){
                    var code = parseInt(data) + 1;
                }else{
                    var code = 1000001;
                }
                $('.add_Item .auz_code').html(code);
            }
        })
    })


///动态获取物业负责人
    $.ajax({
        type:"POST",
        url:getservice_codeUrl,
        dataType:"text",
        success:function(message){
            var data=JSON.parse(message);
            for(var i=0;i<data.length;i++){
                var d = data[i];
                var pp_name =d['pp_name'];
                var pp_code=d['pp_code']
                if($("#rewrite .lot_owner #"+pp_code).length==0){
                    $('#rewrite .lot_owner ul').append('<li><a href="javascript:;" id='+pp_code+' data-ajax='+pp_code+'>'+pp_name+'</a></li>');
                }
            }
        },
        error:function(jqXHR,textStatus,errorThrown){
        }
    })



//点击保存新增
$('#add_Item .confirm').click(function(){

var insert=new platform();
    insert=insert.findinsert()
    console.log(insert)
var findinsert={}
    for (var n in insert.input){
        findinsert[n]=insert.input[n]
        if(findinsert[n]=='' ){findinsert[n]=undefined;}
    }
    for (var n in insert.select){
        findinsert[n]=insert.select[n]
        if(findinsert[n]=='' ){findinsert[n]=undefined;}
    }
    for (var n in insert.radio){
        findinsert[n]=insert.radio[n]
        if(findinsert[n]=='' ){findinsert[n]=undefined;}
    }

    //findinsert.lot_parkcode=$('.add_Item .code').html();
    //传数据
	$.ajax({
		url:insertUrl,
		method:'post',
		data:findinsert,
		success:function(data){
			//var data = JSON.parse(data);
			//成功之后自动刷新页面
            $('#add_Item').modal('hide');
			layer.open({
				  type: 1,
				  title: false,
				  //打开关闭按钮
				  closeBtn: 1,
				  shadeClose: false,
				  skin: 'tanhcuang',
				  content: '新增车辆及授权成功',
				  cancel: function(){
                      window.location.href=href(ListUrl);
				  }
			});
		},
		error:function(){
			console.log('新增活动出错');
		}
	})

})


}


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
                for(var i=0;i<3;i++){
                    var d = data[i];

                    var html = '<div class="single_person" data-last_name="'+d['last_name']+'" data-first_name="'+d['first_name']+'" data-code="'+d['code']+'"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a>'
                        +'<div class="fl">'
                        +'<span class="name">'+d['full_name']+'</span>'
                        +'<span class="code">'+d['code']+'</span>'
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
$(document).on('click','.search_person_results .single_person .add',function() {
    var single_person = $(this).closest('.single_person');
    var full_name = single_person.find('.name').html();
    var id_number = single_person.find('.id_number').html();
    var last_name = single_person.data('last_name');
    var first_name = single_person.data('first_name');

    var last_name = single_person.data('last_name');
    var first_name = single_person.data('first_name');
    var code = single_person.data('code');


    var html = '<li data-last_name="' + last_name + '" data-first_name="' + first_name + '" data-code="' + code + '" id="' + code + '"><span class="full_name">' + full_name + '</span><span class="code">' + code + '</span> <i class="fa fa-close"></i></li>';
    //不重复添加
    if($(this).closest('.modal-body').find(".person_building_data #"+code).length==0){
        $(this).closest('.modal-body').find('.person_building_data ul').append(html);
    }
})

    //点击删除当前节点
    $('.search_person_wrap').on('click', '.person_building_data ul li', function () {
        $(this).remove();
    })



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





function viewAll(value, row, index){
    if(value.length>20) {
        return "<div style=\"\" title=''><p onclick=openLayer('"+value+"')>内容较多,请点击查看详情</p></div>";
    }
    else{
        return "<div style=\"\">" +value+ "</div>";
    }
}



function html_render(index){
    //this.platform=index
    this.detail_html='\n'+
        '<div class="building_header">' +
        '    <h4 class="modal-title tac">'+index.update_info.title+'</h4>' +
        '</div>' +
        '<div class="modal-body building oh">'
        '<div class=" person_wrap person_detail ">' +
        '<p><i class="icon_circle"></i>'+index.update_info.small_title+'</p>';

    this.search_html=' <span class="col_37A fl">筛选条件</span>';
    this.update_html='';
    this.search_all=function(name,num,index){
        var final_html='';
        if(index['method']=='time'){
            var html ='\n'+ '<input type="text" class="select_time date col_37A fl form-control" name="'+name+'"  value="">';
            final_html+= html
        }
        if(index['method']=='building'){
            var html = '<a href="javascript:;" id="treeNav" class="treeWrap treeWrapSearch"><span></span></a>';
            final_html+= html
        }
        if(index['method']=='select'){
            var html='';
            var choice_html='';
            for(var n in index['ajax'])
            {
                choice_html +='<li><a href="javascript:;" data-ajax="' + n + '">' + index['ajax'][n] + '</a></li>';
            }
            html +='\n'+
                '<div class="Search_Item_wrap search_wrap_'+num+' select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">' +
                '<div >' +
                '<input type="text"  class="model_input search_'+num+' ka_input3" placeholder="'+index['input']+'" name="'+name+'" data-ajax="" value="" readonly style="width:100px;" >' +
                '</div>' +
                '<div class="ka_drop"  style="display: none;width:100px;">' +
                '<div class="ka_drop_list '+name+'" >' +
                '<ul >' +
                choice_html	+
                '</ul>' +
                '</div>' +
                '</div>' +
                '</div>';
            final_html+= html
        }
        if(index['method']=='keyword'){
            var html= '\n' +
                '<form class="search_room" action="" method="get">' +
                '       <p>' +
                '            <input type="text" class="searc_room_text" name="keyword" placeholder="'+index['input']+'"><a id="clear" href="">X</a>' +
                '       </p>' +
                '       <button type="submit"><i class="fa fa-search"></i></button>' +
                '</form>';
            final_html+= html
        }
        return final_html
    }


    this.detail_all=function(name,index){
        var html='\n'+' <p><span class="des">'+index['input']+':</span>' +
            '<span class="'+name+'_name col_37A"></span>' +
            '</p>';
        '  </div>' +
        '</div>';
        return html
    }


    this.update_all=function(n,index){
        var  final_html='';
        var must_html='&nbsp;&nbsp;&nbsp;&nbsp;';
        if(index.must=='yes') {must_html='<span class="red_star">*</span>'}
        if(index.method=='show'){
            var html=' <p>'+must_html+index.input+':<span class="'+n+'" style="margin-left:45px;"></span></p>';
            final_html+=html
        }
        if(index.method=='input'){
            var html='<p>'+must_html+index.input+':'+
                ' <input type="text" class="model_input '+index.input+'" placeholder="请输入'+index.input+'"  name="'+n+'" />' +
                '</p>';
            final_html+=html
        }
        if(index.method=='select'){
            var choice_html='';

            for(var i in index.ajax)
            {
                choice_html +='<li><a href="javascript:;" data-ajax="' + i + '">' + index.ajax[i] + '</a></li>';
            }
            if(index.ajax==''){
                choice_html='';
            }
            var html=
                ' <div class="select_wrap select_pull_down ">' +
                '    <div>' +
                must_html+index.input+':' +
                '       <input type="text" class="model_input '+n+' ka_input3" placeholder="请输入'+index.input+'"  name="'+n+'" data-ajax="" readonly />' +
                '    </div>' +
                '    <div class="ka_drop" style="margin-left:20px;width: 300px;">' +
                '       <div class="ka_drop_list '+n+'" style="width: 300px;">' +
                '           <ul>'+choice_html+'</ul>' +
                '       </div>' +
                '    </div>' +
                ' </div>'
            final_html+=html
        }
        if(index.method=='radio'){
            var num=0;
            var radio_html='';
            for(var m in index.option){
                num +=1;
                radio_html += '       <span style="margin-left:95px;">' +
                    '           <input type="radio" id="radio-'+n+'-'+num+'" name="radio-'+n+'" class="regular-radio" >' +
                    '           <label for="radio-'+n+'-'+num+'"></label>'+index.option[m]+
                    '       </span>'
            }
            var html=
                '<p class="'+n+'">' +
                must_html +index.input+':' +
                radio_html+
                '</p>';
            final_html+=html;
        }
        if(index.method=='time'){
            var html=
                ' <p>'+must_html+index.input+':' +
                '       <input type="text" class="'+n+' date form-control" name="'+n+'" value=""/>' +
                '</p>';
            final_html+=html
        }
        if(index.method=='other'){
            var html=index.content
            final_html+=html
        }

        return final_html
    }


    this.initial_all=function(n,index) {
        ///////////搜索框X的href赋值//////////////
       // $('#clear').attr("href",index.router.root)

        var param = getUrlParam(n); //从url获取的参数
        var index_num = 0;
        if (index['method'] == 'time') {
            var now = getDate();
            param = param ? param : now;
            $('.search_wrap .select_time').val(param);
            $('.add_Item').find('input[name="' + n + '"]').val(param);
        }
        if (index['method'] == 'building') {
        }
        if (index['method'] == 'keyword') {
            $('.searc_room_text').val(param);
        }
        if (index['method'] == 'username') {
            var username=$('input[name="username"]').val();
            username=JSON.parse(username)
            $('.user span').html(username.name)
        }
        if (index['method'] == 'select') {
                    for (var m in index['ajax']) {
                        if (m == param) {
                            $('.search_wrap .search_' + index_num).val(index['ajax'][m])
                            break;
                        }
                        else {
                            $('.search_wrap .search_' + index_num).val(index['input'])
                        }
                    }

        }
    }

    this.init_pagechange = (n,index)=>{
        for(var n in index) {
            if (index[n]['search'] == 'yes') {
                console.log(index)
                this.pagechange.urlparam.route = this.pagechange.router.root
                this.pagechange.urlparam[n] = ''
            }
        }
    }

    for(var n in index){
        var select_num=0;
        if(index[n]['search']=='yes'){
            if(index[n]['method']=='select'){select_num=select_num+1;}
            this.search_html +=  this.search_all(n,select_num,index[n])

        }

        if(index[n]['detail']=='yes'){
            this.detail_html +=  this.detail_all(n,index[n])
        }

        if(index[n]['update']=='yes'){
            this.update_html +=  this.update_all(n,index[n])
        }

        if(index[n]['search']=='yes' || index[n]['method']=='time' ||index[n]['method']=='username'){
            this.initial_all(n,index[n])
        }

        }

    this.init_pagechange(index)
}



function pageChange(index){

    for (var n in index.pagechange.urlparam) {
        pagechange[n] = $('input[name=' + n + ']').val();
    }


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
        pagechange.page=page
        window.location.href=href(pagechange);
    })



    var page=index.pagechange.urlparam.page
    var total=index.pagechange.total
    var urlParam= index.pagechange.urlparam

    urlParam.page=1
    firsthref=href(urlParam)

    urlParam.page=page
    currenthref=href(urlParam)

    urlParam.page=page-1
    prevhref=href(urlParam)

    urlParam.page=page+1
    nexthref=href(urlParam)

    urlParam.page=total
    Lasthref=href(urlParam)


    $('.pager ').attr("page",page)
    $('.pager #first').attr("href",firsthref)
    $('.pager #current').html(page+'/'+total)
    $('.pager #last').attr("href",Lasthref)
    if(page>1){
        $('.pager #prev').removeClass('disabled')
        $('.pager #prev').addClass('active')
        $('.pager #prev ').attr("href",prevhref)
    } else {
        $('.pager #prev').removeClass('active')
        $('.pager #prev').addClass('disabled')
        $('.pager #prev ').attr("href",'javascript:void(0);')
    }
    if(page<total){
        $('.pager #next').removeClass('disabled')
        $('.pager #next').addClass('active')
        $('.pager #next ').attr("href",nexthref)
    } else{
        $('.pager #next').removeClass('active')
        $('.pager #next').addClass('disabled')
        $('.pager #next ').attr("href",'javascript:void(0);')
    }

}




function getdata(element,index){
    for(var n in index){
        if(index[n]['update']=='yes'||index[n]['insert']=='yes'){
            if (index[n].method == "input" || index[n].method == "time") {
                index[n].value = $(element).find('input[name=' + n + ']').val();
                index[n].value ?  index[n].value : null;

            }
            if (index[n].method == "select") {
                index[n].value = $(element).find('input[name=' + n + ']').data('ajax');
                index[n].value ?  index[n].value : null;
            }
            if (index[n].method == "radio") {
                var num=0;
                for(var m in index[n]['radio']){
                    if ($(element+'.' + n + ' input[type="radio"]').eq(num).is(':checked')) {
                        index[n].value =  m ;
                    }
                    num++;
                }

            }
        }
    }
}



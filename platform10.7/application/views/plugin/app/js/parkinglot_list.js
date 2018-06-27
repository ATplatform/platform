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
/*
<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
    <th data-title="车位编号" data-align="center" data-field="lot_code"></th>
    <th data-title="生效日期" data-align="center" data-field="lot_effective_date"></th>
    <th data-title="停车场" data-align="center" data-field="lot_parkcode"></th>
    <th  data-title="楼层" data-align="center" data-field="lot_floor"></th>
    <th data-title="车位区域" data-align="center" data-formatter="viewAll" data-field="lot_biz_type"></th>
    <th  data-title="车位状态" data-align="center" data-field="lot_biz_status"></th>
    <th  data-title="占用原因" data-align="center" data-field="lot_biz_reason"></th>
    <th  data-title="占用人" data-align="center" data-field="lot_owner"></th>
    <th  data-title="占用开始日期" data-align="center" data-field=" lot_begin_date"></th>
    <th  data-title="占用结束日期" data-align="center" data-field="lot_end_date"></th>
    <th  data-title="车位租金" data-align="center" data-field="lot_monthly_rent"></th>
    <th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>*/

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
            input:{
                lot_code:null,
                lot_remark:null,
                lot_parkcode:null,
                lot_begin_date:null,
                lot_end_date:null,
                lot_area:null,
                lot_monthly_rent:null,
                lot_linked_lot_code:null,
                lot_effective_date:null
            },
            select:{
                lot_parkcode:null,
                lot_floor: null,
                lot_biz_type: null,
                lot_biz_status:null,
                lot_biz_reason:null,
                lot_owner:null,
            },
            radio:{
                lot_effective_status:null,
            }  ,
            must:{
                lot_code:null,
                lot_effective_date:null,
                lot_effective_status:null,
                lot_parkcode:null,
                lot_floor: null,
                lot_biz_type: null,
                lot_biz_status:null,
            }
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
        findinsert:function(){
            for (var n in this.insert.input) {
                this.insert.input[n] = $('.add_Item').find('input[name='+n+']').val();
                this.insert.input[n]?this.insert.input[n]:null;
                if(n=='end_date' &&  !this.insert.input[n]) {this.insert.input[n]='2099-12-31'}


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
                this.insert.must[n] = must

            }
            console.log(this)
            this.insert.input.code=$('.add_Item .code').html()
            this.insert.must.code=$('.add_Item .code').html()
            this.insert.input.auz_code=$('.add_Item .auz_code').html()
            this.insert.must.auz_code=$('.add_Item .auz_code').html()
            if(!this.insert.must.effective_date) {openLayer('请输入生效日期');return;}
            if(!this.insert.must.effective_status) {openLayer('请输入状态');return;}
            if(!this.insert.must.person_code) {openLayer('请输入车辆登记人');return;}
            if(!this.insert.must.vehicle_type) {openLayer('请输入车辆类型');return;}
            if(!this.insert.must.if_resident) {openLayer('请输入是否常驻');return;}
            if(!this.insert.must.licence) {openLayer('请输入车牌号');return;}
            if(!this.insert.must.auz_person_code) {openLayer('请输入授权发起人');return;}
            if(!this.insert.must.begin_date) {openLayer('请输入授权开始日期');return;}


            return this.insert
        },
        showupdate:function(){
            for (var n in this.update.input) {
                this.update.input[n] = $('.rewrite').find('input[name='+n+']').val();
                this.update.input[n]?this.update.input[n]:null;
                if(n=='auz_end_date' &&  !this.update.input[n]) {this.update.input[n]='2099-12-31'}
            }
            for (var n in this.update.select) {
                this.update.select[n] = $('.rewrite').find('input[name='+n+']').data('ajax');
                this.update.select[n]? this.update.select[n]:null;
            }
            for (var n in this.update.radio) {

                if($('.rewrite .'+n+' input[type="radio"]').eq(0).is(':checked')){
                    this.update.radio[n] = 'true';
                }
                else {
                    this.update.radio[n] = 'false';
                }

            }

            for (var n in this.update.must) {
                var must=null;
                if(this.update.input[n]){    must= this.update.input[n]}
                if(this.update.select[n]){   must= this.update.select[n]}
                if(this.update.radio[n]){    must= this.update.radio[n]}
                this.update.must[n] = must

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


//初始化信息管理参数 /*********************************需要改动********************/
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


//初始化路径  /*********************************需要改动********************/
var router={
    List:'parkinglot',
    getList:'getparkinglot',
    insert:'insert',
    updateParkinglot:'updateParkinglot',
    updateAuz:'updateAuz',
    getparkingcode:'getparkingcode',
    getservice_code:'getservice_code',
    getpresentCodeforauz:'getpresentCodeforauz',
    getauzbyMax_begin_date:'getauzbyMax_begin_date',
    getOrderRecordPerson: getRootPath()+'/index.php/Contract/getOrderRecordPerson',
    getLatestCode:getRootPath()+'/index.php/Vehicle/getLatestCode',
    getLatestCodeforauz:getRootPath()+'/index.php/Vehicle/getLatestCodeforauz',
    getadditionalUrl:getRootPath()+'/index.php/Contract/getadditionalUrl',
}



//初始化搜索框的内容以及保存搜索内容  /*********************************需要改动********************/
var urlParam=new platform();
var param=urlParam.findUrlParam();  //从url获取的参数

var init_time=param.lot_effective_date
var init_keyword=param.keyword
var init_search_index_1=param.lot_parkcode
var init_search_index_2=param.lot_floor
var init_search_index_3=param.lot_biz_type
var init_search_index_4=param.lot_biz_status
var init_search_index_5=param.lot_biz_reason
//初始化时间
var now = getDate();
init_time = init_time?init_time:now;
$('.search_wrap .select_time').val(init_time);
$('.add_Item').find('input[name="lot_effective_date"]').val(init_time);
$('.add_Item').find('input[name="begin_date"]').val(init_time);
//$('.add_Item').find('input[name="end_date"]').val(init_time);
//初始化输入框
$('.searc_room_text').val(init_keyword);



//初始化第一类搜索条件  /*********************************需要改动********************/
switch(init_search_index_1){
    case 't':$('.search_wrap .search_1').val('小区车');break;
    case 'f':$('.search_wrap .search_1').val('访客车');break;
    default:$('.search_wrap .search_1').val('停车场');break;
}
switch(init_search_index_2){
    case '101':$('.search_wrap .search_2').val('地面');break;
    case '102':$('.search_wrap .search_2').val('地下一层');break;
    default:$('.search_wrap .search_2').val('车库楼层');break;
}
switch(init_search_index_3){
    case '101':$('.search_wrap .search_3').val('住宅');break;
    case '102':$('.search_wrap .search_3').val('商业');break;
    default:$('.search_wrap .search_3').val('住宅/商业');break;
}
switch(init_search_index_4){
    case '101':$('.search_wrap .search_4').val('已占用');break;
    case '102':$('.search_wrap .search_4').val('公共车位');break;
    default:$('.search_wrap .search_4').val('车位状态');break;
}
switch(init_search_index_5){
    case '101':$('.search_wrap .search_5').val('已出售');break;
    case '102':$('.search_wrap .search_5').val('租赁中');break;
    case '103':$('.search_wrap .search_5').val('被占用');break;
    default:$('.search_wrap .search_5').val('占用原因');break;
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

search(List,'lot_effective_date','lot_parkcode','lot_floor','lot_biz_type','lot_biz_status','lot_biz_reason','keyword')
insert(router.getLatestCode,router.getLatestCodeforauz,router.insert,router.getservice_code,List)

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

var PageChange  =  new platform();
PageChange.findpage()

page=PageChange.pagechange.page
total=PageChange.pagechange.total

PageChange.urlParam.method=router.List
urlParam= PageChange.urlParam

urlParam.page=1
firsthref=href(urlParam)

urlParam.page=page
currenthref=href(urlParam)

urlParam.page=page-1
prevhref=href(urlParam)

urlParam.page=page-1
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


////////////////////////////////////////////信息管理////////////////////////////////
function operateFormatter(value,row,index){
    return [
        '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
        '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
        '</a>',
        '<a class="rewrite" href="javascript:void(0)" style="margin-left: 10px;"   title="更新授权信息">',
        '<i class="fa  fa-pencil-square-o fa-lg "></i>',
        '</a>',
    ].join('');
}


function information(router,rowkeys) {

    window.operateEvents = {
        'click .detail': function (e, value, row, index) {

            $('#person_detail').modal('show');
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
            for (var n in rowkeys) {
                // if(!rowkeys[n]) {rowkeys[n]='无'}
                $('#person_detail').find('.' + n).html(rowkeys[n]);
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
            for (var n in update.input) {
                $('#rewrite').find('input[name=' + n + ']').val(rowkeys[n]);
            }
            for (var n in update.select) {
                $('#rewrite').find('.' + n).data('ajax', rowkeys[n]);
                $('#rewrite').find('.' + n).val(rowkeys[n + '_name']);
            }
            for (var n in update.radio) {
                if (rowkeys[n] === 't') {
                    $('#rewrite').find('.' + n + ' input[type="radio"]').eq(0).prop("checked", true)
                    $('#rewrite').find('.' + n + ' input[type="radio"]').eq(1).prop("checked", false)
                }
                else {
                    $('#rewrite').find('.' + n + ' input[type="radio"]').eq(0).prop("checked", false)
                    $('#rewrite').find('.' + n + ' input[type="radio"]').eq(1).prop("checked", true)
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


    var updateinsert=function (){

        return updateinsert
    }


    $('#rewrite .confirm').click(function (){
        var update = new platform();
        update = update.showupdate()

        var updateinsert = {}
        for (var n in update.input) {
            updateinsert[n] = update.input[n]
            if (updateinsert[n] == '') {
                updateinsert[n] = undefined;
            }
        }
        for (var n in update.select) {
            updateinsert[n] = update.select[n]
            if (updateinsert[n] == '') {
                updateinsert[n] = undefined;
            }
        }
        for (var n in update.radio) {
            updateinsert[n] = update.radio[n]
            if (updateinsert[n] == '') {
                updateinsert[n] = undefined;
            }
        }
        console.log('updateinsert')
        console.log(updateinsert)

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

$('.search_1').click(function() {
///动态获取物业负责人
    $.ajax({
        type: "POST",
        url: router.getparkingcode,
        dataType: "text",
        success: function (message) {
            var data = JSON.parse(message);
            console.log(message)
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                var par_parkname = d['par_parkname'];
                var lot_parkcode = d['lot_parkcode']
                if ($(".search_1 .ka_drop_list #" + lot_parkcode).length == 0) {
                    $('.search_1 .ka_drop_list ul').append('<li><a href="javascript:;" id=' + lot_parkcode + ' data-ajax=' + lot_parkcode + '>' + par_parkname + '</a></li>');
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    })
})
$('.search_wrap_1').click(function() {
///动态获取物业负责人
    $.ajax({
        type: "POST",
        url: router.getparkingcode,
        dataType: "text",
        success: function (message) {
            var data = JSON.parse(message);
            console.log(message)
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                var par_parkname = d['par_parkname'];
                var lot_parkcode = d['lot_parkcode']
                if ($(".search_wrap_1 .ka_drop_list #" + lot_parkcode).length == 0) {
                    $('.search_wrap_1 .ka_drop_list ul').append('<li><a href="javascript:;" id=' + lot_parkcode + ' data-ajax=' + lot_parkcode + '>' + par_parkname + '</a></li>');
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    })
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
                if($(".select_room #"+pp_code).length==0){
                    $('.select_room ul').append('<li><a href="javascript:;" id='+pp_code+' data-ajax='+pp_code+'>'+pp_name+'</a></li>');
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






function viewAll(value, row, index){
    if(value.length>20) {
        return "<div style=\"\" title=''><p onclick=openLayer('"+value+"')>内容较多,请点击查看详情</p></div>";
    }
    else{
        return "<div style=\"\">" +value+ "</div>";
    }
}




///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////用户名初始化//////////////////////////////
///////////////////////////////////////////////////////////////////////////////

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
        urlParam:{
            method: '',
            page: '',
            keyword: '',
            building_code: '',
            parent_code: '',
            if_resident: '',
            vehicle_type: '',
            vehicle_auz: '',
            effective_date:'',
        },
        insert:{
            input:{
                code:null,
                effective_date:null,
                licence:null,
                owner:null,
                color:null,
                model:null,
                remark:null,

                auz_code:null,
                begin_date:null,
                end_date:null,
                auz_remark:null
                },
            select:{
                vehicle_type:null,
                person_code:null,
                auz_person_code:null,
                brand:null
                },
            radio:{
                effective_status:null,
                if_resident:null,
                if_electro:null,
                if_temp:null
            }  ,
            must:{
                code:null,
                vehicle_type:null,
                effective_date:null,
                effective_status:null,
                person_code:null,
                licence:null,
                if_resident:null,
                begin_date:null,
                end_date:null,
                auz_person_code:null
            }
        },
        update:{
            input:{
                v_code:null,
                v_effective_date:null,
                v_licence:null,
                v_owner:null,
                v_color:null,
                v_model:null,
                v_remark:null,
                auz_code:null,
                auz_begin_date:null,
                auz_end_date:null,
                auz_remark:null
            },
            select:{
                v_vehicle_type:null,
                v_person_code:null,
                auz_person_code:null,
                v_brand:null,
            },
            radio:{
                v_effective_status:null,
                v_if_resident:null,
                v_if_electro:null,
                v_if_temp:null
            }  ,
            must:{
                v_code:null,
                v_vehicle_type:null,
                v_effective_date:null,
                v_effective_status:null,
                v_person_code:null,
                v_licence:null,
                v_if_resident:null,
                auz_begin_date:null,
                auz_end_date:null,
                auz_person_code:null
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
            if(!this.insert.must.if_resident) {openLayer('请输入小区车/访客车');return;}
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
    v_code:'',
    v_effective_date_name:'',
    v_effective_status:'',
    v_effective_status_name:'',
    v_person_code:'',
    v_person_name:'',
    v_vehicle_type:'',
    v_vehicle_type_name:'',
    v_if_resident:'',
    v_if_resident_name:'',
    v_if_electro:'',
    v_if_electro_name:'',
    v_licence:'',
    v_if_temp:'',
    v_if_temp_name:'',
    v_owner:'',
    v_brand:'',
    v_brand_name:'',
    v_model:'',
    v_color:'',
    v_remark:'',
    auzfornow_name:'',
    auzforall_name:'',
    auz_code:'',
    auz_vehicle_code:'',
    auz_begin_date:'',
    auz_end_date:'',
    auz_person_code:'',
    auz_person_name:'',
    auz_remark:''
}


//初始化路径  /*********************************需要改动********************/
var router={
    List:'vehicleList',
    getList:'getList',
    insert:'insert',
    updateVehicle:'updateVehicle',
    updateAuz:'updateAuz',
    getauz:'getauz',
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

var init_time=param.effective_date
var init_keyword=param.keyword
var init_search_index_1=param.if_resident
var init_search_index_2=param.vehicle_type
var init_search_index_3=param.vehicle_auz
//初始化时间
var now = getDate();
init_time = init_time?init_time:now;
$('.search_wrap .select_time').val(init_time);
$('.add_Item').find('input[name="effective_date"]').val(init_time);
$('.add_Item').find('input[name="begin_date"]').val(init_time);
//$('.add_Item').find('input[name="end_date"]').val(init_time);
//初始化输入框
$('.searc_room_text').val(init_keyword);


//初始化第一类搜索条件  /*********************************需要改动********************/
switch(init_search_index_1){
    case '101':$('.search_wrap .search_1').val('小区车');break;
    case '102':$('.search_wrap .search_1').val('访客车');break;

    default:$('.search_wrap .search_1').val('小区车 / 访客车');break;
}

switch(init_search_index_2){
    case '101':$('.search_wrap .search_2').val('轿车');break;
    case '102':$('.search_wrap .search_2').val('客车');break;
    case '103':$('.search_wrap .search_2').val('货车');break;
    case '104':$('.search_wrap .search_2').val('专用汽车');break;
    case '105':$('.search_wrap .search_2').val('摩托车');break;
    case '106':$('.search_wrap .search_2').val('电瓶车');break;
    case '107':$('.search_wrap .search_2').val('自行车');break;
    case '999':$('.search_wrap .search_2').val('其他车辆');break;
    default:$('.search_wrap .search_2').val('车辆类型');break;
}


switch(init_search_index_3){
    case '101':$('.search_wrap .search_3').val('无任何记录');break;
    case '102':$('.search_wrap .search_3').val('当前或未来有生效记录');break;
    case '103':$('.search_wrap .search_3').val('所有授权已失效');break;
    default:$('.search_wrap .search_3').val('授权记录有效查询');break;
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
$('#reset').attr("href",router.List)
$('#clear').click(function(){
    $('.search_room ').find('input[name=keyword]').val('')
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
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////调用函数/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
///*********************************需要改动********************/
showdata(getListhref)
information(router,rowkeys)
pageChange(PageChangeToListhref)
search(List,'effective_date','building_code','parent_code','if_resident','vehicle_type','vehicle_auz','keyword')
insert(router.getLatestCode,router.getLatestCodeforauz,router.insert,router.getservice_code,List)

////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////数据展示功能/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////普通模式的数据展示/////////////////////////
///////////////////////////////////数据展示///////////////////////

function showdata(getListhref){
    $('#table').bootstrapTable({
        method: "get",
        undefinedText: ' ',
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
PageChange.findUrlParam()
console.log(PageChange)

page=PageChange.pagechange.page
page=parseInt(page)
total=PageChange.pagechange.total

PageChange.urlParam.method=router.List
urlParam= PageChange.urlParam

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


////////////////////////////////////////////信息管理////////////////////////////////
function operateFormatter(value,row,index){



    return [
        '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
        '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
        '</a>',
        '<a class="rewrite" href="javascript:void(0)" style="margin-left: 10px;"   title="更新车辆信息">',
        '<i class="fa fa-truck fa-lg "></i>',
        '</a>',
        '<a class="auz" href="javascript:void(0)" style="margin-left: 10px;"   title="更新授权信息">',
        '<i class="fa fa-credit-card fa-lg "></i>',
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
            var code=rowkeys.v_code

          console.log(code)
            $("#getauz").bootstrapTable('destroy');
            $('#getauz').bootstrapTable({
                        method: "get",
                        undefinedText: '/',
                        cache: false,
                        url: router.getauz,
                        queryParams:{
                            code:code
                        }
                        ,
                        contentType : "application/x-www-form-urlencoded",
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
        $('#vehicle_rewrite').modal('show');
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
         console.log(row)


/////////////////////////////////////////////展示////////////////////////////////////////////
         $('#vehicle_rewrite .v_code').html(rowkeys['v_code']);
         var update=new platform();
         update=update.showupdate()
         console.log(update)
         console.log(rowkeys)
         for (var n in update.input){
             $('#vehicle_rewrite').find('input[name='+n+']').val(rowkeys[n]);
         }
        for (var n in update.select){
             $('#vehicle_rewrite').find('input[name='+n+']').data('ajax',rowkeys[n]);
            $('#vehicle_rewrite').find('input[name='+n+']').val(rowkeys[n+'_name']);

         }
         for (var n in update.radio){
             if(rowkeys[n]==='t') {
                 $('#vehicle_rewrite').find('.' + n + ' input[type="radio"]').eq(0).prop("checked", true)
                 $('#vehicle_rewrite').find('.' + n + ' input[type="radio"]').eq(1).prop("checked", false)
             }
             else{
                 $('#vehicle_rewrite').find('.' + n + ' input[type="radio"]').eq(0).prop("checked",false)
                 $('#vehicle_rewrite').find('.' + n + ' input[type="radio"]').eq(1).prop("checked",true)
             }
         }

         $('#vehicle_rewrite .v_code').html(rowkeys['v_code']);
         $('#vehicle_rewrite').find('input[name=v_effective_date]').val(rowkeys['v_effective_date_name']);
         $('#vehicle_rewrite').find('.v_person_code').val(rowkeys['v_person_name']);
         $('#vehicle_rewrite').find('.vehicle_type').val(rowkeys['vehicle_type_name']);

    },

        'click .auz': function (e, value, row, index) {
            console.log(rowkeys)
            $('#auz_rewrite').modal('show');
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
                $.ajax({
                    url:router.getLatestCodeforauz,
                    success:function(data){
                        if(parseInt(data)){
                            var code = parseInt(data) + 1;
                        }else{
                            var code = 1000001;
                        }
                        $('#auz_rewrite .auz_code').html(code);
                    }
                })
            $('#auz_rewrite').find('.auz_person_code').data('ajax',rowkeys['auz_person_code']);
            $('#auz_rewrite').find('.auz_person_code').val(rowkeys['auz_person_name']);
            $('#auz_rewrite').find('.auz_begin_date').val(rowkeys['auz_begin_date']);
            $('#auz_rewrite').find('.auz_end_date').val(rowkeys['auz_end_date']);
            $('#auz_rewrite').find('.auz_remark').val(rowkeys['auz_remark']);


        }

    }

function maxdate(date,date1) {
    var  index1 = date.split("-");
    var  index2 = date1.split("-");
    var max=0;
    for (var i=0; i < 3; i++) {
        var  m = parseInt(index1[i])
        var  n = parseInt(index2[i])
        if (m> n) {max = 0;return max;}
        if (m < n) {max = 1;return max;}
    }
    return max
}
    var auz_code=0;
    $('#vehicle_rewrite').on('mouseover',function(){
        console.log('111')
        if($('#vehicle_rewrite .v_effective_status input[type="radio"]').eq(0).is(':checked')){
            $('.effective_status_more').removeClass("effective_status_more_show")
            $('.effective_status_more').css({"display":"none"})
            $('.effective_status_less').css({"display":"none"})

        }
    if($('#vehicle_rewrite .v_effective_status input[type="radio"]').eq(1).is(':checked')){

     var code=$('#vehicle_rewrite .v_code').html();

     $.ajax({
         url: router.getauzbyMax_begin_date,
         method: 'post',
         data: {
             code: code
         },
         success: function (data) {
             var data = JSON.parse(data);
                 var input_date = $('#vehicle_rewrite').find('input[name=v_effective_date]').val();
                 for (var index in data) {
                     if (index = 'end_date') {
                         var max = maxdate(input_date, data[index])
                         auz_code=data['code']
                         if (max === 0) {
                             $('.effective_status_more').addClass("effective_status_more_show")
                             $('.effective_status_more').css({"display":"block"})
                             $('.effective_status_less').css({"display":"none"})

                         }
                         if (max === 1) {
                             $('.effective_status_more').removeClass("effective_status_more_show")
                             $('.effective_status_more').css({"display":"none"})
                             $('.effective_status_less').css({"display":"block"})

                         }
                     }

                 }


         }
     })
    }
})

    $('#vehicle_rewrite .confirm').click(function(){
        console.log(auz_code);
        var update=new platform();
        update=update.showupdate()
        var updateinsert={}
        for (var n in update.input){
            updateinsert[n]=update.input[n]
            if(updateinsert[n]=='' ){updateinsert[n]=undefined;}
        }
        for (var n in update.select){
            updateinsert[n]=update.select[n]
            if(updateinsert[n]=='' ){updateinsert[n]=undefined;}
        }
        for (var n in update.radio){
            updateinsert[n]=update.radio[n]
            if(updateinsert[n]=='' ){updateinsert[n]=undefined;}
        }
        console.log(updateinsert)
        updateinsert['auz_code_latest']=auz_code
       if ( $('.effective_status_more_show').length>0 ){ openLayer('该车辆的新一条变动记录的时间大于授权结束时间，请再次给该车辆授权!');} else {
            updateinsert.v_code=$('#vehicle_rewrite .v_code').html();
            //传数据
            $.ajax({
                url:router.updateVehicle,
                method:'post',
                data:updateinsert,
                success:function(data){
                    //var data = JSON.parse(data);
                    //成功之后自动刷新页面
                    $('#vehicle_rewrite').modal('hide');
                    layer.open({
                        type: 1,
                        title: false,
                        //打开关闭按钮
                        closeBtn: 1,
                        shadeClose: false,
                        skin: 'tanhcuang',
                        content: '更新车辆信息成功',
                        cancel: function(){
                            window.location.href=href(List);
                        }
                    });
                },
                error:function(){
                    console.log('更新车辆信息出错');
                }
            })
        }
    })




$('#auz_rewrite .confirm').click(function(){

    var update=new platform();
    update=update.showupdate()

    var updateinsert={}
    for (var n in update.input){
        updateinsert[n]=update.input[n]
        if(updateinsert[n]=='' ){updateinsert[n]=undefined;}
    }
    for (var n in update.select){
        updateinsert[n]=update.select[n]
        if(updateinsert[n]=='' ){updateinsert[n]=undefined;}
    }
    for (var n in update.radio){
        updateinsert[n]=update.radio[n]
        if(updateinsert[n]=='' ){updateinsert[n]=undefined;}
    }
    updateinsert.auz_code=$('.rewrite .auz_code').html();

    updateinsert.v_code=rowkeys['v_code'];
    console.log('updateinsert')
    console.log(updateinsert)
            //传数据
            $.ajax({
                url:router.updateAuz,
                method:'post',
                data:updateinsert,
                success:function(data){
                    //var data = JSON.parse(data);
                    //成功之后自动刷新页面
                    $('#auz_rewrite').modal('hide');
                    layer.open({
                        type: 1,
                        title: false,
                        //打开关闭按钮
                        closeBtn: 1,
                        shadeClose: false,
                        skin: 'tanhcuang',
                        content: '更新授权信息成功',
                        cancel: function(){
                            window.location.href=href(List);
                        }
                    });
                },
                error:function(){
                    console.log('更新授权信息出错');
                }
            })
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
///////////////////////搜索地点//////////////////
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


    $('.search_wrap_3 .ka_drop_list li').click(function(){
        var search_index_3 =$(this).find('a').data('ajax');
        List[keys[6]]=search_index_3
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

}




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
    //findinsert.code=$('.add_Item .code').html();
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









//新增人员前验证证件号码以及自动赋值
$('#verify_auz .next').click(function() {
    var licence = $(this).closest('.modal-content').find('input[name="licence"]').val();
    console.log(licence)
    $('#add_Item').find('input[name=licence]').val(licence)
    licence = trim(licence);
    if(!licence){
        openLayer('请输入车牌号');
        return;
    }
    $.ajax({
        url: getRootPath() + '/index.php/Vehicle/verifyauz',
        method: 'post',
        data: {
            licence: licence
        },
        success: function (data) {
            var data=JSON.parse(data)
            console.log(data );

            if (data.length>0) {
                layer.open({
                    type: 1,
                    title: false,
                    //打开关闭按钮
                    closeBtn: 1,
                    shadeClose: false,
                    skin: 'tanhcuang',
                    content: "该车辆已经记录，无需重复添加！",
                    cancel: function () {
                        //右上角关闭回调
                        $('#verify_auz').modal('hide');
                    }
                });
            }
            else {

                $('#verify_auz').modal('hide');
                $('#add_Item').modal('show');
                $('#add_Item').css({
                    'overflow-y':'auto'
                })
            }
        }
    })
})
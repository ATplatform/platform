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
            type: '',
            begin_date: '',

        },
        insert:{
            input:{
                code:null,
                name:null,
                begin_date:null,
                end_date:null,
                },
            select:{
                type:null,
                person_code:null,
                service_code:null
                },
            must:{
                code:null,
                name:null,
                type:null,
                service_code:null,
                begin_date:null
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
            }
            for (var n in this.insert.select) {
                this.insert.select[n] = $('.add_Item').find('input[name='+n+']').data('ajax');
                this.insert.select[n]? this.insert.select[n]:null;
            }


            for (var n in this.insert.must) {
                this.insert.must[n] = $('.add_Item').find('input[name='+n+']').val();
            }
            this.insert.input.code=$('.add_Item .code').html()
            this.insert.must.code=$('.add_Item .code').html()
            if(!this.insert.must.code) {openLayer('请输入活动编码');return;}
            if(!this.insert.must.name) {openLayer('请输入活动名称');return;}
            if(!this.insert.must.type) {openLayer('请输入活动类型');return;}
            if(!this.insert.must.begin_date) {openLayer('请输入开始日期');return;}
            if(!this.insert.must.service_code) {openLayer('请输入物业负责人');return;}

            return this.insert
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
    a_code:'',
    a_name:'',
    begin_date_name:'',
    end_date_name:'',
    a_type_name:'',
    person_name:'',
    service_name:'',
    a_qr_code:''

}


//初始化路径  /*********************************需要改动********************/
var router={
    List:'activityList',
    getList:'getList',
    insert:'insert',
    getservice_code:'getservice_code',
    getOrderRecordPerson: getRootPath()+'/index.php/Contract/getOrderRecordPerson',
    getLatestCode:getRootPath()+'/index.php/Activity/getLatestCode',
    getadditionalUrl:getRootPath()+'/index.php/Contract/getadditionalUrl',
}



//初始化搜索框的内容以及保存搜索内容  /*********************************需要改动********************/
var urlParam=new platform();
var param=urlParam.findUrlParam();  //从url获取的参数

var init_time=param.begin_date
var init_keyword=param.keyword
var init_search_index_1=param.type
var init_search_index_2=param.level

//初始化时间
var now = getDate();
init_time = init_time?init_time:now;
$('.search_wrap .select_time').val(init_time);
$('.add_Item').find('input[name="begin_date"]').val(init_time);
$('.add_Item').find('input[name="end_date"]').val(init_time);
//初始化输入框
$('.searc_room_text').val(init_keyword);


//初始化第一类搜索条件  /*********************************需要改动********************/
switch(init_search_index_1){
    case '101':$('.search_wrap .search_1').val('成年人活动');break;
    case '102':$('.search_wrap .search_1').val('长者活动');break;
    case '103':$('.search_wrap .search_1').val('儿童活动');break;
    case '104':$('.search_wrap .search_1').val('其他活动');break;
    default:$('.search_wrap .search_1').val('活动类型');break;
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
pageChange(PageChangeToList)
search(List,'begin_date','type','keyword')
insert(router.getLatestCode,router.getservice_code,router.insert,router.getadditionalUrl,List)

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

function pageChange(PageChangeToList){
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
        PageChangeToList.page=page
        window.location.href=href(PageChangeToList);
    })
}
////////////////////////////////////////////信息管理////////////////////////////////
function operateFormatter(value,row,index){
    return [
        '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
        '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
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
            $('#person_detail').find('.a_qr_code').attr("src", rowkeys.a_qr_code)
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
    $('.search_wrap .select_time').datetimepicker().on('changeDate',function(e){
        var name= keys[1];
        var time=$('input[name='+name+']').val();
        List[keys[1]]=time
        window.location.href=href(List)
    })



/////////////////////搜索创建类型////////////////
    $(' .search_wrap_1 .ka_drop_list li').click(function(){
        var search_index_1 = $(this).find('a').data('ajax');
        List[keys[2]]=search_index_1
        window.location.href=href(List)

    })

/*/////////////////搜索工单类型////////////
    $('.search_wrap_2 .ka_drop_list li').click(function(){
        var search_index_2 =$(this).find('a').data('ajax');
        List[keys[3]]=search_index_2
        window.location.href=href(List)
    })*/

///////////////////输入框搜索不在此处，在初始化的位置///////////////////////
    $('.search_room button[type="submit"]').click(function(e){
        e.preventDefault()
        var keyword = $('.search_room .searc_room_text').val();
        keyword = trim(keyword);
        if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
            openLayer('搜索框只能输入数字、汉字、字母!');
            return;
        }else{
            List[keys[3]]=keyword
            console.log( List[keys[3]])
            window.location.href=href(List)
        }
    })
    //清除搜索条件
    $('.search_room #clear').click(function(){
        window.location.href=href(List);
    })

}




//////////////////////////////////////////新增功能////////////////////////////////////////
//点击新增按钮,从后端取得楼宇编号信息
function insert(){
   var getLatestCodeUrl=arguments[0];
   var getservice_codeUrl=arguments[1]
   var insertUrl=arguments[2];
   var getadditionalUrl=arguments[3];
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

/*
///动态获取附件名
    $.ajax({
        type:"POST",
        url:getadditionalUrl,
        dataType:"text",
        success:function(message){

           /!* var data=JSON.parse(message);
            for(var i=0;i<data.length;i++){
                var d = data[i];
                var position_name = d['p_name'];
                var position_code=d['p_code']
                if($(".select_room #"+position_code).length==0){
                    $('.select_room ul').append('<li><a href="javascript:;" id='+position_code+' data-ajax='+position_code+'>'+position_name+'</a></li>');*!/
                }
            }
        },
        error:function(jqXHR,textStatus,errorThrown){
        };
    })

*/



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

    var p_bs = $(this).closest('.modal-content').find('.person_building_data ul li');
    if(p_bs.length==0){
        var person_codes=[];
        var person_code = {
            person_code: '0',
        }
    }else {
        var person_codes = '{';
        for (var i = 0; i < p_bs.length-1; i++) {
            var p_b = p_bs.eq(i);
            var person_code = p_b.data('code');
          person_codes=  person_codes+person_code+','
        }
        person_codes +=p_bs.eq(p_bs.length-1).data('code')+'}'
    }

    findinsert['person_code']=person_codes;
    console.log(findinsert)
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
				  content: '新增活动成功',
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

function viewAll(value, row, index) {
    if (value) {
        if (value.length > 20) {
            return "<div style=\"\" title=''><p onclick=openLayer('" + value + "')>内容较多,请点击查看详情</p></div>";
        }
        else {
            return "<div style=\"\">" + value + "</div>";
        }
    }
}
var PageChange  =  new platform();
PageChange.findpage()

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
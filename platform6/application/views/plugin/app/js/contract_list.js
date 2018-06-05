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
            keyword: '',
            type: '',
            level: '',
            begin_date: ''
        },
        insert:{
            input:{
                code:null,
                signed_with:null,
                begin_date:null,
                end_date:null,
                amount:null,
                remark:null,
                },
            select:{
                type:null,
                level:null,
                position_code:null
                },
            must:{
                code:null,
                begin_date:null,
                end_date:null,
            }
        }
       ,
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
            if(!this.insert.must.code) {openLayer('请输入合同编码');return;}
            if(!this.insert.must.begin_date) {openLayer('请输入开始日期');return;}
            if(!this.insert.must.end_date) {openLayer('请输入结束日期');return;}
            return this.insert
        }
    }
}


//初始化信息管理参数 /*********************************需要改动********************/
var rowkeys={
    c_code:'',
    signed_with:'',
    begin_date_name:'',
    end_date_name:'',
    type_name:'',
    level_name:'',
    amount:'',
    position_name:'',
    remark:''
}


//初始化路径  /*********************************需要改动********************/
var router={
    List:'contractList',
    getList:'getContractList',
    insert:'insert',
    getposition_code:'getposition_code',
    getOrderRecordPerson: getRootPath()+'/index.php/Contract/getOrderRecordPerson',
    getLatestCode:getRootPath()+'/index.php/Contract/getLatestCode',

}



//初始化搜索框的内容以及保存搜索内容  /*********************************需要改动********************/
var index=new platform();
var indexFromphp=index.findIndex();//从后端获取的参数
var param=index.findUrlParam();  //从url获取的参数

var init_time=param.search_begin_date
var init_keyword=param.search_keyword
var init_search_index_1=param.search_type
var init_search_index_2=param.search_level

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
    case '101':$('.search_wrap .search_1').val('业务外包合同');break;
    case '102':$('.search_wrap .search_1').val('经营性合同');break;
    case '103':$('.search_wrap .search_1').val('与业主的服务协议');break;
    case '104':$('.search_wrap .search_1').val('业主的授权协议');break;
    case '999':$('.search_wrap .search_1').val('其他');break;
    default:$('.search_wrap .search_1').val('合同类别');break;
}

//初始化第二类搜索条件
switch(init_search_index_2){
    case '101':$('.search_wrap .search_2').val('需呈报总部的合同');break;
    case '102':$('.search_wrap .search_2').val('内部管理合同');break;
    default:$('.search_wrap .search_2').val('合同级别');break;
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
search(List,'begin_date','type','level')
insert(router.getLatestCode,router.getposition_code,router.insert,List)

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
function operateFormatter(value,row,index){
    return [
        '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
        '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
        '</a>',

    ].join('');
}


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
/////////////////////////////////////////////展示////////////////////////////////////////////
            for(var n in rowkeys){
               // if(!rowkeys[n]) {rowkeys[n]='无'}
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

/////////////////搜索工单类型////////////
    $('.search_wrap_2 .ka_drop_list li').click(function(){
        var search_index_2 =$(this).find('a').data('ajax');
        List[keys[3]]=search_index_2
        window.location.href=href(List)
    })

///////////////////输入框搜索不在此处，在初始化的位置///////////////////////

}




//////////////////////////////////////////新增功能////////////////////////////////////////
//点击新增按钮,从后端取得楼宇编号信息
function insert(){
   var getLatestCodeUrl=arguments[0];
   var getposition_codeUrl=arguments[1]
   var insertUrl=arguments[2];
   var ListUrl=arguments[3];


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



///动态获取合同维护人
    $.ajax({
        type:"POST",
        url:getposition_codeUrl,
        dataType:"text",
        success:function(message){
            var data=JSON.parse(message);
            for(var i=0;i<data.length;i++){
                var d = data[i];
                var position_name = d['p_name'];
                var position_code=d['p_code']
                if($(".select_room #"+position_code).length==0){
                    $('.select_room ul').append('<li><a href="javascript:;" id='+position_code+' data-ajax='+position_code+'>'+position_name+'</a></li>');
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


    //传数据
	$.ajax({
		url:insertUrl,
		method:'post',
		data:findinsert,
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
				  content: '新增合同成功',
				  cancel: function(){
                      window.location.href=href(ListUrl);
				  }
			});
		},
		error:function(){
			console.log('新增合同出错');
		}
	})

})


}




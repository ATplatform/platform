///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////初始化参数//////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

/*
must:是否必填*          ->yes/no
search:是否可筛选       ->yes/no
show:是否在表格中显示    ->yes/no
detail:是否在详情中显示  ->yes/no
insert:是否可写入       ->yes/no
update:是否可更新       ->yes/no
method:填入的内容-> show:不可修改，time:时间，building：地点.person:人员，select:下拉列表,input:键盘输入，radio:单选，other:独立html）
input:字段的中文含义
ajax: (当method为select时独有，表示下拉框的data-ajax值和对应中文)
option:(当method为radio时独有，表示单选的内容和对应中文)


除了数据库参数之外，还包含了
username:保存用户名
update_info:更新页面框的标题内容
info_manage：信息管理的标题内容和样式 以及对应函数
pagechange：用于页面跳转和搜索
router：路由参数
*/


var platform_index={
    pkg_vehicle_code:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'no',
        must:'yes',
        input:'车辆编码',
        method:'show',
    },
    v_if_temp:{
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'no',
        must:'no',
        input:'小区车/访客车',
        method:'select',
        ajax:{101:'小区车',102:'访客车'}

    },
    v_vehicle_type:{
        search:'yes',
        show:'no',
        detail:'no',
        update:'no',
        must:'no',
        input:'车辆类型',
        method:'select',
        ajax:{101:'轿车',102:'客车',103:'货车',104:'专用汽车',105:'摩托车',106:'电瓶车',107:'自行车',999:'其他车辆'}
    },
    v_person_code:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'no',
        input:'车辆登记人',
        method:'person'
    },
    building_code:{
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'no',
        input:'登记人所在楼栋',
        method:'building'
    },
    parent_code:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        input:'登记人所在楼栋',
        method:'building'
    },
    v_owner:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'no',
        must:'no',
        input:'车主',
        method:'show'
    },
    v_licence:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        input:'车牌号',
        must:'yes',
        method:'select',

    },
    pkg_begin_date:{
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'no',
        must:'yes',
        input:'进入时间',
        method:'time',

    },
    pkg_end_date:{
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'no',
        must:'no',
        input:'离开时间',
        method:'time'
    },
    pkg_charge_type:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'no',
        must:'no',
        input:'收费类型',
        method:'select',
        ajax:{101:'买断车位',102:'租赁车位',103:'计时收费'}
    },

    pkg_if_charged:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'no',
        must:'yes',
        input:'是否缴费',
        method:'radio',
        options:{t:'是',f:'否'}
    },
/*

    pay_person_code:{
        search:'no',
        show:'yes',
        detail:'no',
        update:'no',
        must:'no',
        input:'缴费人',
        method:'show'
    },
*/
    payer_name:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'no',
        must:'no',
        input:'缴费人',
        method:'show'
    }
    ,

        pkg_charge_amount:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'no',
        must:'no',
        input:'缴费金额',
        method:'input'
    },
    pkg_entry_eqp:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        must:'no',
        input:'进入设备',
        method:'select',
        ajax:{101:'买断车位',102:'租赁车位',103:'计时收费'}
    },
    pkg_entry_type:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        must:'no',
        input:'进入方式',
        method:'input'
    },
    pkg_exit_eqp:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        must:'no',
        input:'离开设备',
        method:'select',
        ajax:{101:'买断车位',102:'租赁车位',103:'计时收费'}
    },
    pkg_exit_type:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        must:'no',
        input:'离开方式',
        method:'select',
        ajax:{101:'买断车位',102:'租赁车位',103:'计时收费'}
    },
    pkg_related_id:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        must:'no',
        input:'追加缴费关联记录',
        method:'input'
    },
    pkg_parking_payment_id:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        must:'no',
        input:'关联停车付款订单',
        method:'input'
    },


    keyword:{
        search:'yes',
        show:'no',
        detail:'no',
        update:'no',
        input:'可输入车辆编码、缴费人',
        method:'keyword'
    },
    update_info:{
        title:'车辆进出详情',
        small_title:'车辆进出'
    },
    info_manage:{
        detail:{title:'详情',css:' fa-file-text-o',content:getdetail},
        rewrite:{title:'更新授权信息',css:'fa-pencil-square-o',content:getrewrite}
    },
    pagechange:{urlparam:{route:'',page:''}, pagesize:'', total:'',page:''},
    router:{
        root:getRootPath()+'/index.php/Vehicle/vehiclePkg',
        get:'getvehiclePkg',
        insert:'insert',
        updateParkinglot:'updateParkinglot',
        getparkingcode:'getparkingcode',
        getservice_code:'getservice_code',
        getLatestCode:getRootPath()+'/index.php/Vehicle/getLatestCode',

    }

}




//html 与后台数据无关
var render=new html_render(platform_index)

$('#table tr').prepend(render.data_html)
$('#search_wrap').append(render.search_html)
$('#person_detail .model_content').append(render.detail_html)
$('#rewrite .rewrite').append(render.update_html)
render.initial_all(platform_index)

showdata(platform_index)
pageChange(platform_index)
information(platform_index)
update_data('.rewrite',platform_index)
//insert_data('.rewrite',render)








//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








/*!(function info_init(render){
    var html=''
    for(var n in render.info_manage){
        html+= '<a class="'+n+'" href="javascript:void(0)" title="'+render.info_manage[n]['title']+'">',
        '<i class="fa fa-lg '+render.info_manage[n]['css']+'"></i>',
            '</a>  ';
    }
    return function operateFormatter(value, row, index) {
        return html
    }
})(platform_index)*/


function operateFormatter(value, row, index) {
    return [
        '<a class="detail" href="javascript:void(0)" title="详情">',
        '<i class="fa fa-lg fa-file-text-o"></i>',
        '</a>  ',
    ].join('');
}



function getdetail(location,rowkeys){
    return  function (e, value, row, index) {
        $(location).modal('show');
        for (var n in rowkeys) {
            if (rowkeys[n]['detail'] == 'yes') {
                if(rowkeys[n]['method']=='input'||rowkeys[n]['method']=='show'){
                    $(location).find('.' + n).html(row[n]);
                }else{
                $(location).find('.' + n).html(row[n+'_name']);
                }
            }
        }
        console.log(row)

////////////////////////////////////////额外补充//////////////////////////////////////////////////
     /*   var code = keys.v_code
        console.log(code)
        $("#getauz").bootstrapTable('destroy');
        $('#getauz').bootstrapTable({
            method: "get",
            undefinedText: '/',
            cache: false,
            url: rowkeys.router.getauz,
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
        })*/
    }

}



function getrewrite(location,rowkeys){
    return   function (e, value, row, index) {
        $(location).modal('show');
        console.log(row)
        for(var n in rowkeys){
            if(rowkeys[n]['update']=='yes'){
                if(rowkeys[n]['method']=='show'){
                    $(location+'  .'+n).html(row[n+'_name']);
                }
                if(rowkeys[n]['method']=='input'||rowkeys[n]['method'] == "time"){
                    $(location).find('input[name=' + n + ']').val(row[n+'_name']);
                }
                if(rowkeys[n]['method']=='select'){
                    $(location).find('.' + n).data('ajax', row[n]);
                    $(location).find('.' + n).val(row[n + '_name']);
                }
                if(rowkeys[n]['method']=='radio'){
                    var option_num=0;
                    for(var m in rowkeys[n]['option']){
                        if(row[n]==m){
                            $(location).find('.' + n + ' input[type="radio"]').eq(option_num).prop("checked", true)
                        }else{
                            $(location).find('.' + n + ' input[type="radio"]').eq(option_num).prop("checked", false)
                        }
                        option_num+=1;
                    }

                }

            }
        }

    }
}





//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////ajax////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////车位编号///////////////////////////
$('.add_btn').click(function(){
    $.ajax({
        url:platform_index.router.getLatestCode,
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


////////////////////////////////停车场///////////////////////////
    $.ajax({
        type: "POST",
        url: platform_index.router.getparkingcode,
        dataType: "text",
        success: function (message) {
            var data = JSON.parse(message);
            console.log(message)
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                var lot_parkcode_name = d['lot_parkcode_name'];
                var lot_parkcode = d['lot_parkcode']
                if ($("#rewrite .lot_parkcode  #" + lot_parkcode).length == 0) {
                    $('#rewrite .lot_parkcode  ul').append('<li><a href="javascript:;" id=' + lot_parkcode + ' data-ajax=' + lot_parkcode + '>' + lot_parkcode_name +lot_parkcode+ '</a></li>');
                }
                if ($("#search_wrap .lot_parkcode  #" + lot_parkcode).length == 0) {
                    $('#search_wrap .lot_parkcode  ul').append('<li><a href="javascript:;" id=' + lot_parkcode + ' data-ajax=' + lot_parkcode + '>' + lot_parkcode_name + lot_parkcode+'</a></li>');
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    })



////////////////////////////////占用人///////////////////////////
$.ajax({
    type:"POST",
    url:platform_index.router.getservice_code,
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


//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////点击保存的事件//////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
function insert_data(element,render){
    var index=getdata(element,render)
    //点击保存新增
    $('#add_Item .confirm').click(function(){

        $.ajax({
            url:render.router.insert,
            method:'post',
            data:index,
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
                        window.location.href=render.router.root;
                    }
                });
            },
            error:function(){
                console.log('新增活动出错');
            }
        })

    })


}




function update_data(element,render){
    var index=getdata(element,render)
    $('#rewrite .confirm').click(function (){
        $.ajax({
            url: render.updateParkinglot,
            method: 'post',
            data: index,
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
                        window.location.href = render.router.root;
                    }
                });
            },
            error: function () {
                console.log('更新车位信息出错');
            }
        })
    })
}







////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////插入html//////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

function html_render(index){
    this.data_html='<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>';
    this.detail_html='\n'+
        '<div class="building_header">' +
        '    <h4 class="modal-title tac">'+index.update_info.title+'</h4>' +
        '</div>' +
        '<div class="modal-body building oh">'+
        '<div class=" person_wrap person_detail ">' +
        '<p><i class="icon_circle"></i>'+index.update_info.small_title+'</p>';

    this.search_html=' <span class="col_37A fl">筛选条件</span>';
    this.update_html='';
    this.search_all=function(name,index){
        //控制页面元素的顺序
   /*     var  time_html='';
        var  building_html='';
        var  select_html='';
        var  keyword_html='';*/
        var final_html='';

        if(index['method']=='time'){
            var html ='\n'+ '<input type="text" class="select_time date '+name+' col_37A fl form-control" name="'+name+'"  value="">';
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
                '<div class="Search_Item_wrap search_wrap_'+name+' select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">' +
                '<div >' +
                '<input type="text"  class="model_input search_'+name+' ka_input3" placeholder="'+index['input']+'" name="'+name+'" data-ajax="" value="" readonly style="width:100px;" >' +
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
                '            <input type="text" class="searc_room_text" name="keyword" placeholder="'+index['input']+'"><a id="clear" onclick="return false">X</a>' +
                '       </p>' +
                '       <button type="submit"><i class="fa fa-search"></i></button>' +
                '</form>';
            final_html+= html
        }

        //final_html+=time_html+building_html+select_html+keyword_html
        return final_html
    }

    this.detail_all=function(name,index){
        var html='\n'+' <p><span class="des">'+index['input']+':</span>' +
            '<span class="'+name+' col_37A"></span>' +
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
        if(index.method=='person'){
            var html=
                ' <div class="search_person_wrap">' +
                '          <div class="oh" style="">' +
                '               <div class="fl">' +
                                     +must_html+index.input+
                '               </div>' +
                '               <div class="fl search_person_text "style="margin-left:18px;">\n' +
                '                    <input type="text" class="fl search_person_name" placeholder="请输入姓名查找" style="width:300px;font-size:inherit;" name="'+n+'">' +
                '           <a class="fr search_person_btn"><i class="fa fa-search"></i></a>' +
                '              </div>' +
                '         </div>' +
                '         <div class="search_person_results">' +
                '         </div>' +
                '       <div class="person_building_data">' +
                '           <ul>' +
                '           </ul>' +
                '        </div>' +
                '    </div>'

            final_html+=html
        }
        if(index.method=='other'){
            var html=index.content
            final_html+=html
        }

        return final_html
    }

    this.initial_all=function(index) {

        for(var n in index){

        if(index[n]['search']=='yes' || index[n]['method']=='time' ||index[n]['method']=='building'){

        ////日期控件初始化//////////////
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
            ////地点控件初始化//////////////
            $('#treeNav>span').jstree({
                'core' : {
                    data: treeNav_data
                }
            })


            var param = getUrlParam(n); //从url获取的参数
        if (index[n]['method'] == 'time') {
            var now = getDate();
            param = param ? param : now;
            $('.search_wrap .'+n).val(param);
            $('.add_Item').find('input[name="' + n + '"]').val(param);
        }
        if (index[n]['method'] == 'building') {
        }
        if (index[n]['method'] == 'keyword') {
            $('.searc_room_text').val(param);
        }

        if (index[n]['method'] == 'select') {
                    for (var m in index[n]['ajax']) {
                        if (m == param) {
                            $(' .search_' + n).val(index[n]['ajax'][m])

                            break;
                        }
                        else {
                            $(' .search_' + n).val(index[n]['input'])
                        }
                    }
        }
        }
        }
    }


    this.data_all=function(n,index){
        var html=''
        if (index['method'] == 'input'||index['method'] == 'show') {
            html = '<th data-title="' + index['input'] + '" data-align="center" data-field="' + n + '"></th>'
        } else {
            html = '<th data-title="' + index['input'] + '" data-align="center" data-field="' + n + '_name"></th>'
        }

        return html
        }

    var  time_html='';
    var  building_html='';
    var  select_html='';
    var  keyword_html='';
    var time_num=0;
    for(var n in index){

        if(index[n]['show']=='yes'){
            this.data_html+=this.data_all(n,index[n])

        }
        if(index[n]['search']=='yes'){

            if(index[n]['method']=='time'){
                time_num=time_num+1;
                if(time_num>1){time_html+='<span class="fl col_37A">-</span>'}
                time_html+=this.search_all(n,index[n])
            }
            if(index[n]['method']=='building'){
                building_html+=this.search_all(n,index[n])

            }
            if(index[n]['method']=='select'){
                select_html+=this.search_all(n,index[n])

            }
            if(index[n]['method']=='keyword'){
                keyword_html+=this.search_all(n,index[n])

            }


        }

        if(index[n]['detail']=='yes'){
            this.detail_html +=  this.detail_all(n,index[n])
        }

        if(index[n]['update']=='yes'){
            this.update_html +=  this.update_all(n,index[n])
        }

        }

        this.search_html=time_html+building_html+select_html+keyword_html

}




////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////分页功能//////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
function pageChange(index){

    index.pagechange.urlparam.route = index.router.root

    for(var n in index) {
            if (index[n]['search'] == 'yes') {
                index.pagechange.urlparam[n] =  getUrlParam(n);
            }
    }

    index.pagechange.total =  $('input[name="total"]').val()
    index.pagechange.pagesize =  $('input[name="pagesize"]').val()
    index.pagechange.page =  $('input[name="page"]').val()
   var pagechange= index.pagechange.urlparam


/*    for (var n in index.pagechange.urlparam) {

        index.pagechange.urlparam[n] =  getUrlParam(n);

        }*/



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



    var page=index.pagechange.page
    page=parseInt(page)
    var total=index.pagechange.total
    var urlParam= pagechange
    console.log('page')
console.log(pagechange)
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
  /*  if(!page){
        $('.pager #current').html('1'+'/'+total)
    }else{

    } */

    $('.pager #last').attr("href",Lasthref)
    if(page>1){
        console.log(prevhref)
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

    var search_num=0;
    for(var n in index){
        if(index[n]['search']=='yes'){


         if(index[n]['method']=='time'){
             {
                 let m = n;
                 $('.search_wrap  .'+m).datetimepicker().on('changeDate', function (e) {

                     urlParam[m] = $('input[name=' + m + ']').val();
                     console.log(urlParam[m])
                    window.location.href = href(urlParam)
                 })
             }
         }
         if(index[n]['method']=='building'){

             $('#treeNav>span').on("select_node.jstree", function (e, node) {
                 urlParam['building_code']=node.node.original.code
                 urlParam['parent_code']=node.node.node.original.code

                 window.location.href=href(urlParam)
             })
         }
         if(index[n]['method']=='select'){
             {
             let m=n;
             $(' .search_wrap_'+m+' .ka_drop_list').click(function(e){
                 urlParam[m] = e.target.attributes[1].value
                     console.log(m)
                 console.log(this)
                 console.log(e.target.attributes[1].value)
                 console.log(urlParam)
                 console.log(href(urlParam))
                 window.location.href=href(urlParam)

             })
             }
         }
         if(index[n]['method']=='keyword') {
             {
                 let m = n;
                 $('.search_room button[type="submit"]').click(function (e) {
                     e.preventDefault()
                     var keyword = $('.search_room .searc_room_text').val();
                     keyword = trim(keyword);
                     if (!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))) {
                         openLayer('搜索框只能输入数字、汉字、字母!');
                         return;
                     } else {
                         urlParam['page']=''
                         urlParam[m] = keyword
                         window.location.href = href(urlParam)
                     }
                 })
             }
         }
        }
        $('#reset').attr("href",index.router.root)
        $('#clear').click(function(){
            $('.search_room ').find('input[name=keyword]').val('')
        })



    }



}





////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////获取用户输入的数据/////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
function getdata(element,index){
    var value={}
    for(var n in index){
        if(index[n]['update']=='yes'||index[n]['insert']=='yes'){
            if (index[n].method == "input" || index[n].method == "time") {
                value[n] = $(element).find('input[name=' + n + ']').val();
                value[n] ?  value[n] : null;

            }
            if (index[n].method == "select") {
                value[n] = $(element).find('input[name=' + n + ']').data('ajax');
                value[n] ?  value[n] : null;
            }
            if (index[n].method == "radio") {
                var num=0;
                for(var m in index[n]['radio']){
                    if ($(element+'.' + n + ' input[type="radio"]').eq(num).is(':checked')) {
                        value[n] =  m ;
                    }
                    num++;
                }

            }
        }
    }
    return value
}





////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////数据展示//////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

function showdata(render){
    render.pagechange.urlparam.route = render.router.get
    render.pagechange.urlparam.page = getUrlParam('page')

    for(var n in render) {
        if (render[n]['search'] == 'yes') {
            render.pagechange.urlparam[n] =  getUrlParam(n);
        }
    }

    var datahref=href(render.pagechange.urlparam)
console.log(datahref)
    $('#table').bootstrapTable({
        method: "get",
        undefinedText: ' ',
        url: datahref,
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







////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////信息管理//////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
function information(render) {
  /*  for (var n in render.info_manage){
        window.operateEvents['click' + ' .'+n]=render.info_manage[n]['content']()
    }*/
    window.operateEvents = {
        'click .detail': render.info_manage['detail']['content']('#person_detail',platform_index),
        'click .rewrite': render.info_manage['rewrite']['content']('#rewrite',platform_index)
    }
}





////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////人员查找//////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
!(function add_person(){
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


})()




////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////内容较多，请点击查看详情//////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
function viewAll(value, row, index){
    if(value.length>20) {
        return "<div style=\"\" title=''><p onclick=openLayer('"+value+"')>内容较多,请点击查看详情</p></div>";
    }
    else{
        return "<div style=\"\">" +value+ "</div>";
    }
}



////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////获取href//////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
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


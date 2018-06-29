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
    lot_code:{
        must:'yes',
       //search:'no',
        must:'yes',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'车位编号',
        method:'show',

    },
    lot_effective_date:{
        must:'yes',
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'yes',
        input:'生效日期',
        method:'time'
    },
    lot_effective_status:{
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
    info_manage:{
        detail:{title:'详情',css:' fa-file-text-o',content:getdetail('#person_detail',platform_index)},
        rewrite:{title:'更新授权信息',css:'fa-pencil-square-o',content:getrewrite('#rewrite',platform_index)}
        },
    username:{method:'username'},
    pagechange:{urlparam:{route:'',page:''}, pagesize:'', total:'',},
    router:{
        root:'parkinglot',
        get:'getparkinglot',
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


showdata(render)
pageChange(render)
information(render)
update_data('.rewrite',render)
//insert_data('.rewrite',render)








//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








!(function info_init(render){
    var html=''
    for(var n in render.info_manage){
        html+= '<a class="'+n+'" href="javascript:void(0)" title="'+render.info_manage[n]['title']+'">',
        '<i class="fa fa-lg '+render.info_manage[n]['css']+'"></i>',
            '</a>  ';
    }
    return function operateFormatter(value, row, index) {
        return html
    }
})(render)

/*
function operateFormatter(value, row, index) {
    return [
        '<a class="detail" href="javascript:void(0)" title="详情">',
        '<i class="fa fa-lg "></i>',
        '</a>  ',
        '<a class="rewrite" href="javascript:void(0)" title="更新授权信息">',
        '<i class="fa fa-lg "></i>',
        '</a>'
    ].join('');
}

*/

function getdetail(location,rowkeys){
    return  function (e, value, row, index) {
        $(location).modal('show');
        var keys = [];
        for (var p in row) {
            keys.push(p);
        }

        for (var n in rowkeys) {
            if (rowkeys[n]['detail'] == 'yes') {
                $(location).find('.' + n).html(keys[n+'_name']);
            }
        }

        console.log(rowkeys)

////////////////////////////////////////额外补充//////////////////////////////////////////////////
        var code = keys.v_code
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
        })
    }

}



function getrewrite(location,rowkeys){
    return   function (e, value, row, index) {
        $(location).modal('show');
        var keys = [];
        for (var p in row) {
            keys.push(p);
        }
        for(var n in rowkeys){
            if(rowkeys[n]['update']=='yes'){
                if(rowkeys[n]['method']=='show'){
                    $(location+'  .'+n).html(keys[n+'_name']);
                }
                if(rowkeys[n]['method']=='input'||rowkeys[n]['method'] == "time"){
                    $(location).find('input[name=' + n + ']').val(rowkeys[n+'_name']);
                }
                if(rowkeys[n]['method']=='select'){
                    $(location).find('.' + n).data('ajax', keys[n]);
                    $(location).find('.' + n).val(keys[n + '_name']);
                }
                if(rowkeys[n]['method']=='radio'){
                    var option_num=0;
                    for(var m in rowkeys[n]['option']){
                        if(keys[n]==m){
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
        url:render.router.getLatestCode,
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
        url: render.router.getparkingcode,
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



////////////////////////////////占用人///////////////////////////
$.ajax({
    type:"POST",
    url:render.router.getservice_code,
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
                        window.location.href=href(render.router.root);
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

    this.initial_all=function(n,index) {
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


    this.data_all=function(n,index){
            var html='<th data-title="'+index['input']+'" data-align="center" data-field="'+n+'_name"></th>'

        return html
        }



    for(var n in index){
        var select_num=0;
        if(index[n]['show']=='yes'){
            this.data_html+=this.data_all(n,index[n])

        }
        if(index[n]['search']=='yes'){
            if(index[n]['method']=='select'){select_num=select_num+1;}
            this.search_html +=  this.search_all(n,select_num,index[n])
           // this.init_pagechange(n)
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

}




////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////分页功能//////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
function pageChange(index){
    index.pagechange.urlparam.route = index.pagechange.router.root
    for(var n in index) {
            if (index[n]['search'] == 'yes') {
                index.pagechange.urlparam[n] = ''
            }
    }

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

    var search_num=0;
    for(var n in index){
        if(index[n]['search']=='yes'){

         if(index[n]['method']=='time'){
             $('.search_wrap .select_time').datetimepicker().on('changeDate',function(e){
                 pagechange[n]=$('input[name='+n+']').val();
                 window.location.href=href(pagechange)
             })
         }
         if(index[n]['method']=='building'){
             $('#treeNav>span').on("select_node.jstree", function (e, node) {
                 pagechange['building_code']=node.node.original.code
                 pagechange['parent_code']=node.node.node.original.code

                 window.location.href=href(pagechange)
             })
         }
         if(index[n]['method']=='select'){
             search_num+=1;
             $(' .search_wrap_'+search_num+' .ka_drop_list').click(function(){
                 pagechange[n] = $(this).find('a').data('ajax');
                 window.location.href=href(pagechange)

             })
         }
         if(index[n]['method']=='keyword'){
             $('.search_room button[type="submit"]').click(function(e){
                 e.preventDefault()
                 var keyword = $('.search_room .searc_room_text').val();
                 keyword = trim(keyword);
                 if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
                     openLayer('搜索框只能输入数字、汉字、字母!');
                     return;
                 }else{
                     pagechange[n]=keyword
                     window.location.href=href(pagechange)
                 }
             })
         }
        }


        $('#clear').attr("href",index.router.root)
        $('.search_room #clear').click(function(){
            window.location.href=href(index.router.root);
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
    $('#table').bootstrapTable({
        method: "get",
        undefinedText: '/',
        url: render.router.get,
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
    for (var n in render.info_manage){
        window.operateEvents['click .'+n]=render.info_manage[n]['content']()
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


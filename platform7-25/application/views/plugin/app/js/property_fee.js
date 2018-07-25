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
disabledonly 只可见不可写 ->update/insert/all

除了数据库参数之外，还包含了
username:保存用户名
update_info:更新页面框的标题内容
info_manage：信息管理的标题内容和样式 以及对应函数
pagechange：用于页面跳转和搜索
router：路由参数
*/

var platform_index={
    property_building_effective_date:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        insert:'no',
        must:'no',
        input:'生效时间的楼宇',
        method:'time',
        disabledonly:'update',
    },
    property_building_fullname:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        insert:'no',
        must:'no',
        input:'地址',
        method:'show',
        disabledonly:'update',
    },
    property_building_code:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        insert:'no',
        must:'no',
        input:'楼宇编号',
        method:'building',
        disabledonly:'update',

    },
   building_code:{
        search:'yes',
        show:'no',
        detail:'no',
        update:'no',
        insert:'no',
        must:'no',
        input:'楼宇编号',
        method:'building',
        disabledonly:'update',

    },
    parent_code:{
        search:'yes',
        show:'no',
        detail:'no',
        update:'no',
        insert:'no',
        must:'no',
        input:'楼宇编号',
        method:'other',
        disabledonly:'update',

    },
    property_building_name:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        insert:'no',
        must:'no',
        input:'楼宇名称',
        method:'show',
        disabledonly:'update'
    },
    property_building_type:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        insert:'yes',
        must:'yes',
        input:'物业费类型',
        method:'select',
        ajax:{'101':'住宅物业费','102':'商铺物业费','103':'公寓物业费','104':'写字楼物业费','105':'别墅物业费'
        },
        disabledonly:'update'
    },
    property_building_type_1:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        insert:'no',
        input:'房产类型',
        method:'select',
        ajax:{'101':'住宅','102':'商铺','103':'公寓','104':'写字楼','105':'别墅'
        },
        disabledonly:'update'
    },
    property_floor_area:{
        search:'no',
        show:'no',
        detail:'no',
        insert:'no',
        update:'no',
        input:'建筑面积',
        method:'other',
        ajax:{},
        disabledonly:'update'
    },
    property_floor_area_name:{
        search:'no',
        show:'yes',
        detail:'yes',
        insert:'no',
        update:'yes',
        input:'建筑面积',
        method:'show',
        ajax:{},
        disabledonly:'update'
    },
    property_standard:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        insert:'no',
        must:'no',
        input:'物业费标准',
        method:'input',
        ajax:{},
        disabledonly:'update'
    },
    property_standard_name:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'yes',
        insert:'no',
        must:'yes',
        input:'物业费标准',
        method:'input',
        ajax:{},
        disabledonly:'update'
    },
    property_if_standard:{
        search:'yes',
        show:'yes',
        detail:'yes',
        update:'yes',
        insert:'no',
        must:'no',
        input:'是否特殊收费',
        method:'select',
        ajax:{t:'是',f:'否'},
        disabledonly:'no'
    },
    property_fee_standard_per_month:{
        search:'no',
        show:'no',
        detail:'no',
        update:'yes',
        insert:'no',
        input:'每月应缴纳物业费',
        must:'yes',
        method:'input',
        disabledonly:'no'
    },
    property_fee_standard_per_month_name:{
        search:'no',
        show:'yes',
        detail:'yes',
        update:'no',
        insert:'no',
        input:'每月应缴纳物业费',
        must:'no',
        method:'input',
        disabledonly:'no'
    },

    property_if_standard_date:{
        search:'no',
        show:'no',
        detail:'yes',
        update:'yes',
        insert:'no',
        must:'no',
        input:'特殊收费变更日期',
        method:'show',
        disabledonly:'update'
    },
    property_change_reason:{
        search:'no',
        show:'no',
        detail:'yes',
        update:'yes',
        insert:'no',
        must:'yes',
        input:'特殊收费原因',
        method:'input',
        disabledonly:'no'
    },
    property_fee_standard:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        insert:'yes',
        must:'no',
        input:'当前生效房产物业费',
        method:'show',
        disabledonly:'no'
    },
    property_update_date:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        insert:'yes',
        must:'no',
        input:'更新时间',
        method:'show',
        disabledonly:'update'
    },
    property_update_standard:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        insert:'yes',
        must:'yes',
        input:'更新物业费标准',
        method:'input',
        disabledonly:'update'
    },
    property_update_history:{
        search:'no',
        show:'no',
        detail:'no',
        update:'no',
        insert:'yes',
        must:'no',
        input:'更新历史',
        method:'show',
        disabledonly:'update'
    },
    keyword:{
        search:'yes',
        show:'no',
        detail:'no',
        update:'no',
        input:'可输入楼宇名称',
        method:'keyword'
    },
    update_info:{
        title:'物业费详情',
        small_title:'物业费'
    },
    info_manage:{
        detail:{title:'详情',css:' fa-file-text-o',content:getdetail},
        rewrite:{title:'更新物业费标准',css:'fa-pencil-square-o',content:getrewrite}
    },
    pagechange:{urlparam:{route:'',page:''}, pagesize:'', total:'',page:''},
    router:{
        root:getRootPath()+'/index.php/Moneypay/property_fee',
        get:'getList_property_fee',
        insert:'insert_property',
        getfloor:'getfloor',
        update:'update_property',
        getbuilding_type:'getbuilding_type',
        change_history:'change_history'

    }

}




//html 与后台数据无关
var render=new html_render(platform_index)

$('#table tr').prepend(render.data_html)
$('#search_wrap').append(render.search_html)
$('#person_detail .model_content').append(render.detail_html)
$('#rewrite .rewrite').append(render.update_html)
$('#add_Item .add_item').append(render.insert_html)

render.initial_all(platform_index)
showdata(platform_index)
pageChange(platform_index)
information(platform_index)
update_data('.rewrite',platform_index)
insert_data('.add_item',platform_index)








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
        '<a class="detail" href="javascript:void(0)" title="详情" >',
        '<i class="fa fa-lg fa-file-text-o"></i>',
        '</a>  ',
        '<a class="rewrite" href="javascript:void(0)" title="更新"  style="margin-left:10px">',
        '<i class="fa fa-lg fa-money"></i>',
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

    }

}



function getrewrite(location,rowkeys){
    return   function (e, value, row, index) {
        $(location).modal('show');
        console.log(row)
        for(var n in rowkeys){
            if(rowkeys[n]['update']=='yes'){
                if(rowkeys[n]['disabledonly']!=='update'){
                if(rowkeys[n]['method']=='show'){
                    $(location+'  .'+n).html(row[n]);
                }
                if( rowkeys[n]['method']=='input'){
                    $(location).find('input[name=' + n + ']').val(row[n]);
                }
                if( rowkeys[n]['method'] == "time"){
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
                }else{
                    if(rowkeys[n]['method']=='input'||rowkeys[n]['method']=='show'||rowkeys[n]['method']=='building'||rowkeys[n]['method']=='other'){
                        $(location+'  .'+n).html(row[n]);
                    }
                    if(rowkeys[n]['method'] == "time"){
                        $(location+'  .'+n).html(row[n+ '_name']);
                    }
                    if(rowkeys[n]['method']=='select'){
                        $(location+'  .'+n).html(row[n+ '_name']);
                    }
                    if(rowkeys[n]['method']=='radio'){
                        $(location+'  .'+n).html(row[n+ '_name']);

                    }



                }
            }

            if(n=='property_if_standard'){
                if(row[n]=='t'){
                    $('#rewrite .property_fee_standard_per_month').parent().append( '<input type="text" class="model_input" placeholder="请输入每月应缴纳物业费" name="property_fee_standard_per_month">');
                    $('#rewrite .property_change_reason').parent().append(
                        '<input type="text" class="model_input 特殊收费原因" placeholder="请输入特殊收费原因" name="property_change_reason">');
                    $('#rewrite').find('input[name=property_fee_standard_per_month]').val(row['property_fee_standard_per_month'])
                    $('#rewrite').find('input[name=property_change_reason]').val(row['property_change_reason'])
                    $('#rewrite .property_fee_standard_per_month').remove();
                    $('#rewrite .property_change_reason').remove();
                }
                if(row[n]=='f'){

                    $('#rewrite').find('input[name=property_fee_standard_per_month]').parent().append( '<span class="property_fee_standard_per_month col_37A" style="position:absolute;left:140px;">'+  row['property_fee_standard_per_month'] +' </span>');
                    $('#rewrite').find('input[name=property_change_reason]').parent().append(
                    '<span class=" property_change_reason col_37A" style="position:absolute;left:140px;"></span>');
                    $('#rewrite').find('input[name=property_change_reason]').remove();
                    $('#rewrite').find('input[name=property_fee_standard_per_month]').remove();
                   // $('#rewrite .property_if_standard_date').html(' ');
                }

            }




        }

    }
}





//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////ajax////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////


////////////////////////////////停车场///////////////////////////
$('#add_Item .property_building_type li').click(function(e){
    var type=$(e.target).data('ajax')

    $.ajax({
        type:"POST",
        url:platform_index.router.getbuilding_type,
        data:{
            building_type:type
        },
        dataType:"text",
        success:function(message){
            var data=JSON.parse(message);
           console.log(data)
            var date=new Date;
            var year=date.getFullYear();
            var month=date.getMonth()+1;
            var nextmonth=month+1
            if(month==12){nextmonth=1}
            var now=year+'-'+nextmonth+'-'+'1'
            console.log(now)
            $('#add_Item .property_fee_standard').addClass('col_37A')
            $('#add_Item .property_update_date').addClass('col_37A')
            $('#add_Item .property_fee_standard').html(data['0'].fee_standard+'元/平米')
            $('#add_Item .property_update_date').html(now)
            $("#getauz").bootstrapTable('destroy');
            $('#getauz').bootstrapTable({
                method: "get",
                undefinedText: '/',
                cache: false,
                url: platform_index.router.change_history,
                queryParams:{
                    building_type:type
                },
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
        error:function(jqXHR,textStatus,errorThrown){
        }
    })
})



/*$.ajax({
    type: "POST",
    url: platform_index.router.getparkingcode,
    dataType: "text",
    success: function (message) {
        var data = JSON.parse(message);
        console.log(message)
        for (var i = 0; i < data.length; i++) {
            var d = data[i];
            var parklot_parkcode = d['lot_parkcode'];
            var parklot_parkcode_name = d['lot_parkcode_name']
            if ($("#rewrite .parklot_parkcode  #" + parklot_parkcode).length == 0) {
                $('#rewrite .parklot_parkcode  ul').append('<li><a href="javascript:;" id=' + parklot_parkcode + ' data-ajax=' + parklot_parkcode + '>' + parklot_parkcode_name +parklot_parkcode+ '</a></li>');
            }
            if ($("#search_wrap .parklot_parkcode  #" + parklot_parkcode).length == 0) {
                $('#search_wrap .parklot_parkcode  ul').append('<li><a href="javascript:;" id=' + parklot_parkcode + ' data-ajax=' + parklot_parkcode + '>' + parklot_parkcode_name +'</a></li>');
            }
            if ($("#add_Item .parklot_parkcode  #" + parklot_parkcode).length == 0) {
                $('#add_Item .parklot_parkcode  ul').append('<li><a href="javascript:;" id=' + parklot_parkcode + ' data-ajax=' + parklot_parkcode + '>' + parklot_parkcode_name + '</a></li>');
            }
        }
    },
    error: function (jqXHR, textStatus, errorThrown) {
    }
})

////////////////////////////////车库楼层///////////////////////////
$.ajax({
    type: "POST",
    url: platform_index.router.getfloor,
    dataType: "text",
    success: function (message) {
        var data = JSON.parse(message);
        console.log(message)
        for (var i = 0; i < data.length; i++) {
            var d = data[i];
            var parklot_parkcode = d['lot_parkcode'];
            var parklot_parkcode_name = d['lot_parkcode_name']
            if ($("#rewrite .parklot_parkcode  #" + parklot_parkcode).length == 0) {
                $('#rewrite .parklot_parkcode  ul').append('<li><a href="javascript:;" id=' + parklot_parkcode + ' data-ajax=' + parklot_parkcode + '>' + parklot_parkcode_name +parklot_parkcode+ '</a></li>');
            }
            if ($("#search_wrap .parklot_parkcode  #" + parklot_parkcode).length == 0) {
                $('#search_wrap .parklot_parkcode  ul').append('<li><a href="javascript:;" id=' + parklot_parkcode + ' data-ajax=' + parklot_parkcode + '>' + parklot_parkcode_name + parklot_parkcode+'</a></li>');
            }
            if ($("#add_Item .parklot_parkcode  #" + parklot_parkcode).length == 0) {
                $('#add_Item .parklot_parkcode  ul').append('<li><a href="javascript:;" id=' + parklot_parkcode + ' data-ajax=' + parklot_parkcode + '>' + parklot_parkcode_name + parklot_parkcode+'</a></li>');
            }
        }
    },
    error: function (jqXHR, textStatus, errorThrown) {
    }
})


////////////////////////////////占用人///////////////////////////
$.ajax({
    type:"POST",
    url:platform_index.router.getperson_code,
    dataType:"text",
    success:function(message){
        var data=JSON.parse(message);
        for(var i=0;i<data.length;i++){
            var d = data[i];
            var rent_renter_name =d['full_name'];
            var rent_renter=d['code']
            if($("#add_Item .rent_renter  #"+rent_renter).length==0){
                $('#add_Item .rent_renter  ul').append('<li><a href="javascript:;" id='+rent_renter +' data-ajax='+rent_renter +'>'+rent_renter_name+'</a></li>');
            }
        }
    },
    error:function(jqXHR,textStatus,errorThrown){
    }
})


$('#add_Item .rent_parking_lot_code').click(function() {
    var parkcode_insert = $('#add_Item').find('input[name=parklot_parkcode]').data('ajax')
    var floor_insert = $('#add_Item').find('input[name=parklot_floor]').data('ajax')

        $.ajax({
            type: "POST",
            url: platform_index.router.getparking_lot_code,
            data: {
                parkcode: parkcode_insert,
                floor: floor_insert
            },
            dataType: "text",
            success: function (message) {
                $('#add_Item .rent_parking_lot_code  ul').html('')
                var data = JSON.parse(message);
                console.log(data)

                for (var i = 0; i < data.length; i++) {
                    var d = data[i];
                    var rent_parking_lot_code = d['code'];

                    if ($("#add_Item .rent_parking_lot_code #" + rent_parking_lot_code).length == 0) {
                        $('#add_Item .rent_parking_lot_code  ul').append('<li><a href="javascript:;" id=' + rent_parking_lot_code + ' data-ajax=' + rent_parking_lot_code + '>' + rent_parking_lot_code + '</a></li>');
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        })

})*/
//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////点击保存的事件//////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
function insert_data(element,render){
    //点击保存新增
    $('#add_Item .confirm').click(function(){
      /*  var index=getdata(element,render)*/
        var date=new Date;
        var nowdate=date.getDate();
        nowdate=date.getDate();
        if(nowdate==1 || nowdate==2|| nowdate==3){openLayer('每月的1日~3日不可更新物业费标准');return;}
        var building_type=$('#add_Item').find('input[name=property_building_type]').data('ajax')
        var change_date=$('#add_Item .property_update_date').html()
        var fee_standard=$('#add_Item').find('input[name=property_update_standard]').val()
        console.log(building_type)
        console.log(change_date)
        console.log(fee_standard)
        $.ajax({
            url:render.router.insert,
            method:'post',
            data:{
                building_type:building_type,
                change_date:change_date,
                fee_standard:fee_standard
            },
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
                    content: '系统将按新标准覆盖所有相关物业费，请手工修改个别有区别的房产物业费！',
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
    $('#rewrite .property_if_standard li').click(function (e){

        var property_if_standard=$(e.target).data('ajax')
        console.log(property_if_standard)
        if(property_if_standard=='t'){
            var date=new Date
            now = formatDate(date);
            var property_if_standard_date=$('#rewrite .property_if_standard_date').html(now)
            var property_change_reason=$('#rewrite .property_change_reason').html()
            var property_fee_standard_per_month=$('#rewrite .property_fee_standard_per_month').html()
            $('#rewrite .property_fee_standard_per_month').parent().append( '<input type="text" class="model_input" placeholder="请输入每月应缴纳物业费" name="property_fee_standard_per_month">');
            $('#rewrite .property_change_reason').parent().append(
                '<input type="text" class="model_input 特殊收费原因" placeholder="请输入特殊收费原因" name="property_change_reason">');
            $('#rewrite').find('input[name=property_fee_standard_per_month]').val(property_fee_standard_per_month)
            $('#rewrite').find('input[name=property_change_reason]').val(property_change_reason)
            $('#rewrite .property_fee_standard_per_month').remove();
            $('#rewrite .property_change_reason').remove();
        }
        else {
            var property_change_reason=$('#rewrite').find('input[name=property_change_reason]').val()
            var property_fee_standard_per_month= $('#rewrite').find('input[name=property_fee_standard_per_month]').val()
            var property_floor_area_name = $('#rewrite .property_floor_area_name').html()
            var property_standard_name = $('#rewrite .property_standard_name').html()
            console.log(property_floor_area_name)
            property_floor_area_name=parseInt(property_floor_area_name.split('平米')['0'])
            property_standard_name=parseInt(property_standard_name.split('元/平米/月')['0'])
            property_fee_standard_per_month=property_floor_area_name*property_standard_name

            $('#rewrite').find('input[name=property_fee_standard_per_month]').parent().append( '<span class="property_fee_standard_per_month col_37A" style="position:absolute;left:140px;">'+ property_fee_standard_per_month +' </span>');
            var property_if_standard_date=$('#rewrite .property_if_standard_date').html('')

            $('#rewrite').find('input[name=property_change_reason]').parent().append(
                '<span class=" property_change_reason col_37A" style="position:absolute;left:140px;"></span>');
            $('#rewrite').find('input[name=property_change_reason]').remove();
            $('#rewrite').find('input[name=property_fee_standard_per_month]').remove();
        }

    })

    $('#rewrite .confirm').click(function (){
        var property_building_code=$('#rewrite .property_building_code').html()
        var property_if_standard=$('#rewrite').find('input[name=property_if_standard]').data('ajax')

        if(property_if_standard=='t'){
            var property_if_standard_date=$('#rewrite .property_if_standard_date').html()
            var property_change_reason=$('#rewrite').find('input[name=property_change_reason]').val()
            var property_fee_standard_per_month= $('#rewrite').find('input[name=property_fee_standard_per_month]').val()
            if(!property_fee_standard_per_month){openLayer('请输入每月应缴纳物业费');return}
            if(!property_change_reason){openLayer('请输入变更原因');return}
        }
        else {
            var property_fee_standard_per_month= $('#rewrite .property_fee_standard_per_month').html()
            var property_change_reason=undefined
            var property_if_standard_date=undefined
        }

        $.ajax({
            url: render.router.update,
            method: 'post',
            data: {
                building_code:property_building_code,
                ppe_payable:property_fee_standard_per_month,
                change_reason:property_change_reason,
                if_standard_date:property_if_standard_date,
                if_standard:property_if_standard
            },
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
                    content: '更新物业费成功',
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

    this.search_html=' <span class="col_37A fl ">筛选条件</span>';
    this.update_html='';
    this.insert_html='';
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
                '<input type="text"  class="model_input search_'+name+' ka_input3" placeholder="'+index['input']+'" name="'+name+'" data-ajax="" value="" readonly style="width:120px;" >' +
                '</div>' +
                '<div class="ka_drop"  style="display: none;width:120px;">' +
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

        return html
    }

    this.update_all=function(n,index){

        var  final_html='';
        var must_html='&nbsp;&nbsp;&nbsp;&nbsp;';
        if(index.must=='yes') {must_html='<span class="red_star">*</span>'}
        if(index.disabledonly=='update'){must_html='&nbsp;&nbsp;&nbsp;&nbsp;';}
        if(index.disabledonly=='update') {
            var html='\n'+' <p>'+ must_html+ index.input +
                ':<span class=" '+n+' col_37A" style="position:absolute;left:140px;"></span>' +
                '</p>';

         /*   var html = ' <p>' + must_html + index.input + ':<span class="' + n + '" style="margin-left:45px;"></span></p>';*/
            final_html += html
        }
        if(!index.disabledonly||index.disabledonly!=='update'){
            if (index.method == 'show') {
                var html = ' <p>' + must_html + index.input + ':<span class="' + n + '" style="margin-left:70px;"></span></p>';
                final_html += html
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
        }
        return final_html
    }


    this.insert_all=function(n,index){

        var  final_html='';
        var must_html='&nbsp;&nbsp;&nbsp;&nbsp;';
        if(index.must=='yes') {must_html='<span class="red_star">*</span>'}
        if(index.disabledonly=='insert') {
            var html = ' <p>' + must_html + index.input + ':<span class="' + n + '" style="margin-left:45px;"></span></p>';
            final_html += html
        }
        if(!index.disabledonly||index.disabledonly!=='insert'){
            if (index.method == 'show') {
                var html = ' <p>' + must_html + index.input + ':<span class="' + n + '" style="margin-left:45px;"></span></p>';
                final_html += html
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
        }
        return final_html
    }
    this.initial_all=function(index) {
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
        for(var n in index){

            if(index[n]['search']=='yes' || index[n]['method']=='time' ||index[n]['method']=='building'){


                var param = getUrlParam(n); //从url获取的参数
                if (index[n]['method'] == 'time') {
                    var now = getDate();
                    param = param ? param : now;
                    $('.search_wrap .'+n).val(param);
                    $('.add_item').find('input[name="' + n + '"]').val(param);
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

        if(index[n]['insert']=='yes'){
            this.insert_html +=  this.insert_all(n,index[n])
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
                    console.log(node)
                    urlParam['building_code']=node.node.original.code
                    urlParam['parent_code']=node.node.original.code

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
            if (index[n].method == "show" ) {
                value[n] = $(element+' .'+n).html();
                value[n] ?  value[n] : null;

            }
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


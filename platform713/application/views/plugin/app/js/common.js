function getRootPath(){
    //获取当前网址，如： http://localhost:8083/proj/meun.jsp
    var curWwwPath = window.document.location.href;
    //获取主机地址之后的目录，如： proj/meun.jsp
    var pathName = window.document.location.pathname;
    var pos = curWwwPath.indexOf(pathName);
    //获取主机地址，如： http://localhost:8083
    var localhostPath = curWwwPath.substring(0, pos);
    //获取带"/"的项目名，如：/proj
    var projectName = pathName.substring(0, pathName.substr(1).indexOf('/')+1);
    return(localhostPath + projectName);
}

function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return decodeURIComponent(r[2]); return ""; //返回参数值
}
function openLayer(title){
    layer.open({
      type: 1,
      title: false,
      closeBtn: 0,
      shadeClose: true,
      skin: 'tanhcuang',
      content: title
    });
}
//扩展 ajaxUtil
(function ($) {
    $.extend({
        ajaxUtil :function (url, type, data, success, error, complete) {
            $.ajax({
                url: url,
                type: type,
                dataType: "text",
                data: data,
                success: function (data) {
                    if ($.isFunction(success))
                        success(data);
                    else
                        console.error('success:' + data);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // 通常 textStatus 和 errorThrown 之中
                    // 只有一个会包含信息
                    // 调用本次AJAX请求时传递的options参数
                    if($.isFunction(error)) {
                        //error(XMLHttpRequest, textStatus, errorThrown);
                        error(errorThrown);
                    }
                },
                complete: function (XMLHttpRequest, textStatus) {
                    if($.isFunction(complete))
                        complete(XMLHttpRequest, textStatus);
                }
            });
        }
    });
    $.extend({
        ajaxAsync:function(url, type, data, success, error, complete){
            $.ajax({
                url: url,
                type: type,
                dataType: "text",
                data: data,
                async: false,
                success: function (data) {
                    if ($.isFunction(success))
                        success(data);
                    else
                        console.error('success:' + data);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // 通常 textStatus 和 errorThrown 之中
                    // 只有一个会包含信息
                    // 调用本次AJAX请求时传递的options参数
                    if($.isFunction(error)) {
                        //error(XMLHttpRequest, textStatus, errorThrown);
                        error(errorThrown);
                    }
                },
                complete: function (XMLHttpRequest, textStatus) {
                    if($.isFunction(complete))
                        complete(XMLHttpRequest, textStatus);
                }
            });
        }
    });
    $.extend({
       loadUtil: function(scripts,callback){
           eachSeries = function (script, iterator, callback) {
               callback = callback || function () {};
               if (!script.length) {
                   return callback();
               }
               var completed = 0;
               var iterate = function () {
                   iterator(script[completed], function (err) {
                       if (err) {
                           callback(err);
                           callback = function () {};
                       }
                       else {
                           completed += 1;
                           if (completed >= script.length) {
                               callback(null);
                           }
                           else {
                               iterate();
                           }
                       }
                   });
               };
               iterate();
           };
           function getScript(url, callback) {
               var head = document.getElementsByTagName('head')[0];
               var script = document.createElement('script');
               script.src = url;
               var done = false;
               // Attach handlers for all browsers
               script.onload = script.onreadystatechange = function() {
                   if (!done && (!this.readyState ||
                       this.readyState == 'loaded' || this.readyState == 'complete')) {
                       done = true;
                       if (callback)
                           callback();

                       // Handle memory leak in IE
                       script.onload = script.onreadystatechange = null;
                   }
               };
               head.appendChild(script);
               // We handle everything using the script element injection
               return undefined;
           }
           eachSeries(scripts, getScript, callback);
       }
    });
    $.extend({openModal:function(message,callBack){
        $('.result-message').modal('show').find('.modal-body').text(message);
        if($(document.body).hasClass('modal-open'))
            $(document.body).removeClass('modal-open');
        if($('.modal-backdrop').hasClass('in'))
               $('.modal-backdrop').removeClass('in');
        if($.isFunction(callBack)){
             // callBack;
           $('.result-message').on('hidden.bs.modal',function(){
               callBack();
           });
        }
    }});
})(jQuery);
//局部刷新删除数据
function asynRefreshPage(pageUrl,modal,table,total,param){
    var cur=$("#current").text();
    var page=cur.split("/");
    var current = page[0];
    var newpage;
    if(Number(total)<=1){
        current = total;
        newpage = current+'/'+total;
        $('#next').parent().addClass('disabled');
        $('#prev').parent().addClass('disabled');
        $('#next').removeAttr('url');
        $('#prev').removeAttr('url');
        $("#current").text(newpage);
        refreshPage(modal,table,total,param);
        return;
     }

    if(Number(current)>=Number(total)&&Number(total)!=0){
        current = total;
        newpage = current+"/"+total;
        $('#next').parent().addClass('disabled');
        $('#next').attr("href","javascript:void(0);");
        $('#prev').parent().removeClass('disabled');
        if(param!=undefined)
        {
            $('#prev').attr({href:pageUrl+"?page="+(Number(current)-1)+param});
        }
        else
        {
            $('#prev').attr({href:pageUrl+"?page="+(Number(current)-1)});   
        }
        $('#next').removeAttr('url');
        $("#current").text(newpage);
        refreshPage(modal,table,current,param);
        return;
    }else{
        newpage = current+"/"+total;
        $('#next').parent().removeClass('disabled');
        $('#prev').parent().removeClass('disabled');
        if(param!=undefined)
        {
            $('#next').attr({href:pageUrl+"?page="+(Number(current)+1)+param});
        }
        else
        {
            $('#next').attr({href:pageUrl+"?page="+(Number(current)+1)});   
        }
        if(current<=1){
            $('#prev').removeAttr('url');
        }else{
            if(param!=undefined)
            {
                $('#prev').attr({href:pageUrl+"?page="+(Number(current)-1)+param});
            }
            else
            {
                $('#prev').attr({href:pageUrl+"?page="+(Number(current)-1)});   
            }
        }
        $("#current").text(newpage);
        refreshPage(modal,table,current,param);
        return;
    }
}
//刷新 table
function refreshPage(action,target,current,param) {
    var myCurrent = $('#current').text().split('/')[0];
    var myTotal = $('#current').text().split('/')[1];
    if(current!=null||current!=undefined)
        myCurrent = current;
    if(param==null)
        param = '';
    if(Number(myCurrent)>Number(myTotal))
    {
        newpage=myTotal+"/"+myTotal;
        myCurrent = myTotal;
        $("#current").text(newpage);
        $("#next").parent().attr("disabled",true);
        $("#next").removeAttr('url');
    }
    $.ajaxUtil(getRootPath() + '/index.php/'+action+'?page=' + myCurrent+param, 'get', null,
    function (result) {
        console.log(target);
        if(result!='') {
            var data = JSON.parse(result);
            target.bootstrapTable('load', data);
        }else{
            target.bootstrapTable('removeAll');
        }
    },
    function (error) {
        console.log(error);
    });
}
//表格id格式化操作
function idFormatter(value,row,index){
  var page = $('input[name="page"]').val();
  //后端设置的分页参数
  var pagesize = $('input[name="pagesize"]').val();
  return [
    index+1+(page-1)*pagesize
  ];
}
//格式化时间为 年-月-日-小时:分钟 的形式
function formatDate(date){
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    if(hours >= 0 && hours <= 9){
        hours = "0" + hours;
    }
    if(minutes >= 0 && minutes <= 9){
        minutes = "0" + minutes;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate;
    return currentdate;
}
//获得当前的年-月-日信息
function getDate(){
    var nowDate = new Date();
    var year = nowDate.getFullYear();
    var month = nowDate.getMonth() + 1 < 10 ? "0" + (nowDate.getMonth() + 1)
    : nowDate.getMonth() + 1;
    var day = nowDate.getDate() < 10 ? "0" + nowDate.getDate() : nowDate
    .getDate();
    var dateStr = year + "-" + month + "-" + day;
    return dateStr;
}
//获取当日上个月的年-月-日信息
function getLastMonthYestdy(){
    var now=new Date();  
    var year = now.getFullYear();//getYear()+1900=getFullYear()  
    var month = now.getMonth() +1;//0-11表示1-12月  
    var day = now.getDate();  
    if(parseInt(month)<10){  
        month="0"+month;  
    }  
    if(parseInt(day)<10){  
        day="0"+day;  
    }  

    now =year + '-'+ month + '-' + day;  

    if (parseInt(month) ==1) {//如果是1月份，则取上一年的12月份  
        return (parseInt(year) - 1) + '-12-' + day;  
    }  

    var  preSize= new Date(year, parseInt(month)-1, 0).getDate();//上月总天数  
    if (preSize < parseInt(day)) {//上月总天数<本月日期，比如3月的30日，在2月中没有30  
        return year + '-' + month + '-01';  
    }  

    if(parseInt(month) <=10){  
        return year + '-0' + (parseInt(month)-1) + '-' + day;  
    }else{  
        return year + '-' + (parseInt(month)-1) + '-' + day;  
    }  
}
//获取当天的下个月对应日期
function getNextMonth(date) {  
    var arr = date.split('-');  
    var year = arr[0]; //获取当前日期的年份  
    var month = arr[1]; //获取当前日期的月份  
    var day = arr[2]; //获取当前日期的日  
    var days = new Date(year, month, 0);  
    days = days.getDate(); //获取当前日期中的月的天数  
    var year2 = year;  
    var month2 = parseInt(month) + 1;  
    if (month2 == 13) {  
        year2 = parseInt(year2) + 1;  
        month2 = 1;  
    }  
    var day2 = day;  
    var days2 = new Date(year2, month2, 0);  
    days2 = days2.getDate();  
    if (day2 > days2) {  
        day2 = days2;  
    }  
    if (month2 < 10) {  
        month2 = '0' + month2;  
    }  
  
    var t2 = year2 + '-' + month2 + '-' + day2;  
    return t2;  
}
$(function(){
    $('.building>p').click(function(e){
        e.stopPropagation();
        $(this).closest('.building').find('.ka_drop').hide();
    })
    //下拉框选项
    $(document).on('click','.select_pull_down',function(){
        $(this).find('.ka_drop').slideToggle();
        $(this).find('.sub_ka_drop').slideToggle();
    })
    
    //下拉框赋值
    $(document).on('click','.ka_drop li',function(){
        var data_ajax = $(this).find('a').data('ajax');
        $(this).parents('.select_pull_down').find('.ka_input3').val($(this).text());
        $(this).parents('.select_pull_down').find('.ka_input3').data('ajax',data_ajax);
    })
    //鼠标移开下拉框时,下拉框自动隐藏
    $(document).on('mouseleave','.select_pull_down',function(){
        $(this).find('.ka_drop').hide();
        $(this).find('.sub_ka_drop').hide();
    })
    //二级下拉框第一级赋值
    $(document).on('click','.sub_ka_drop .first_nav',function(){
        var data_ajax = $(this).find('a').data('ajax');
        $(this).parents('.select_pull_down').find('.ka_input3').val($(this).text());
        $(this).parents('.select_pull_down').find('.ka_input3').data('ajax',data_ajax);
    })
    //点击显示二级菜单
    $(document).on('click','.sub_ka_drop .subNavWrap',function(e){
        e.stopPropagation();
        $(this).find('.subNav').slideToggle();
    })
    //第二级下拉框赋值
    $(document).on('click','.sub_ka_drop .subNav li',function(){
        var data_ajax = $(this).find('a').data('ajax');
        $(this).closest('.select_pull_down').find('.ka_input3').val($(this).text());
        $(this).closest('.select_pull_down').find('.ka_input3').data('ajax',data_ajax);
        //赋值之后隐藏下拉框
        $(this).closest('.sub_ka_drop').hide();
    })
})
//去掉字符串首尾空格
function trim(m){
 while((m.length>0)&&(m.charAt(0)==' '))
    m  =  m.substring(1, m.length);
 while((m.length>0)&&(m.charAt(m.length-1)==' '))
    m = m.substring(0, m.length-1);
 return m;
}
function viewAll(value, row, index){
    if(value){
        if(value.length>20) {
           return "<div style=\"\" title=''><p onclick=openLayer('"+value+"')>内容较多,请点击查看详情</p></div>";
        }
        else{
           return "<div style=\"\">" +value+ "</div>";
        }
    }
    else{
       return "<div style=\"\">" +value+ "</div>";
    }
}
function viewMore(value, row, index){
    if(value){
        //如果有逗号(多个地址),则隐藏
        if(value.indexOf("3") != -1){
           return "<div style=\"\" title=''><p onclick=openLayer('"+value+"')>内容较多,请点击查看详情</p></div>";
        }
        else{
           return "<div style=\"\">" +value+ "</div>";
        }
    }
    else{
       return "<div style=\"\">" +value+ "</div>";
    }
}
$(function(){
  //给有楼宇层级筛选的列表赋值楼宇名称
    if($('.search_wrap #treeNav').length>0){
        $("#treeNav>span").on('ready.jstree',function(){
            var building_code = getUrlParam('parent_code')?getUrlParam('parent_code'):getUrlParam('building_code');
            if(building_code){
                $.ajax({
                    method:'post',
                    url : getRootPath()+'/index.php/Building/getBuilding',
                    data:{
                        building_code:building_code
                    },
                    success:function(message){
                        var data=JSON.parse(message);
                        var building_name = data.name;
                           $('#treeNav>span .jstree-children a.jstree-anchor').html('<i class="jstree-icon jstree-themeicon" role="presentation"></i>'+building_name);
                        ;
                    },
                    error:function(jqXHR,textStatus,errorThrown){
                        // console.log(jqXHR);
                    }   
                })
            }
        })
    }
    $('#treeNav>span,#treeNavAdd>span,#treeNavWrite>span').on(" before_open.jstree", function (e, data) {
        $('.jstree-container-ul').css({
            "width":"300px"
        })
        $(this).css({
            "height": "340px",
            "width":"200px",
            "overflow": "auto"
        })
        $(this).closest('a').css({
            'width':'200px'
        })
    })

    $('#treeNav>span,#treeNavAdd>span,#treeNavWrite>span').on(" after_close.jstree", function (e, data) {
        if(data.node.parents.length==1){
            $(this).css({
                "width":"100%",
                "height": "100%",
            })
            $(this).closest('a').css({
                'width':'120px'
            })
            $('.jstree-container-ul').css({
                "width":"100%"
            })
        }
    })

    //去除下拉框光标
    $('input[readonly]').on('focus', function() {
        $(this).trigger('blur');
    });
})
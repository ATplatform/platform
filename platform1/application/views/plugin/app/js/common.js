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
$(function(){
    $('.building>p').click(function(e){
        e.stopPropagation();
        $(this).closest('.building').find('.ka_drop').hide();
    })
    //下拉框选项
    $(document).on('click','.select_pull_down',function(){
        $(this).find('.ka_drop').slideToggle();
    })
    
    //下拉框赋值
    $(document).on('click','.ka_drop li',function(){
        var data_ajax = $(this).find('a').data('ajax');
        $(this).parents('.select_pull_down').find('.ka_input3').val($(this).text());
        $(this).parents('.select_pull_down').find('.ka_input3').data('ajax',data_ajax);
    })
    $(document).on('mouseleave','.select_pull_down',function(){
        // $(this).find('.ka_drop').hide();
    })
})
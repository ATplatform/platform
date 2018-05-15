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

function openModelById(id){
    $(id).modal('show');
}
function closeModelById(id){
    $(id).modal('hide');
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

//id格式化操作
function idFormatter(value,row,index){
    var page = $('input[name="page"]').val();
    //后端设置的分页参数
    var pagesize = $('input[name="pagesize"]').val();
    return [
        index+1+(page-1)*pagesize
    ];
}
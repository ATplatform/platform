
var path_view=getRootPath()+'/application/views/app/'

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




    function wechat_pay_click(e) {
        if (wechat_pay_result==true && ali_pay_result==true)
        {
            console.log(e)
            wechat_pay_result=false;
            $('.wechat_pay_new_radio').css({"visibility":"visible"})
        }
        else if(wechat_pay_result==true && ali_pay_result==false)
        {
            $('.wechat_pay_new_radio').css({"visibility":"visible"})
            $('.ali_pay_new_radio').css({"visibility":"hidden"})
            wechat_pay_result=false;
            ali_pay_result=true;
        }

    }

    function ali_pay_click(e) {
        if (ali_pay_result==true && wechat_pay_result==true )
        {
            $('.ali_pay_new_radio').css({"visibility":"visible"})
            ali_pay_result=false;

        }
        else if(ali_pay_result==true &&   wechat_pay_result==false)
        {
            $('.wechat_pay_new_radio').css({"visibility":"hidden"})
            $('.ali_pay_new_radio').css({"visibility":"visible"})
            wechat_pay_result=true;
            ali_pay_result=false;
        }

    }





    function checkbox(e) {
        if (!$(e).attr("checked")) {
            e.src =path_view+'online_chose_dark.png'
            $(e).attr("checked", "true")
        }
        else if ($(e).attr("checked")) {
            $(e).removeAttr("checked")
            e.src =path_view+'/online_chose_light.png'
        }
    }




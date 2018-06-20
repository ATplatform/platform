<?php
	require 'top.php'
?>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-table/css/bootstrap-table.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/jstree/dist/themes/default/style.min.css'?>'/>
<!--<script src='<?/*=base_url().'application/views/plugin/jquery-bdmap/js/jquery.baiduMap.min'*/?>'></script>-->
<script src='<?='http://api.map.baidu.com/getscript?v=2.0&ak=aRMXU5OVYpSZCqXlS0zL1K3OepYKZhr4&services=&t=20180529182003,'?>'></script>
<style>
    *{
        font-size: 14px;
    }
    p{
        margin:10px;
    }
    .villageimg{
        width:100%;
        height:100%;
        max-width:100%;
        max-height:100%;

        margin-left:auto;
        margin-right:auto;

    }
    #container{
        height:275px;width:70%;
    }
    .show{
        float:left;
        width:40%;margin-left:40px;
    }

    .imgwrap{
        float:left;
        width:50%;height:100%;
    }


    @media screen and (max-width: 768px) {
        .imgwrap{

            width:100%;height:100%;
        }
        #container{
            height:275px;width:70%;
        }
        .show{
            width:100%;margin-left:40px;
        }

    }



</style>
<div class="header oh">
	<div class="fl logo">
		<i></i>艾特智能AI社区云平台
	</div>
	<div class="top_login_wrap fr">
        <span class="user"><i></i> <span></span></span>
		|<a class="login_out" href="<?=base_url().'index.php/Login/logout'?>">退出登录</a>
	</div>
</div>
<style>


</style>
<div class="oh pt10">

<?php
	require 'menus.php'
?>
    <div class=" col-sm-12 main_wrap">
<!--<?php echo 'x'; ?>-->


        <div class="show " >
         <!--   <p class=" add_btn update">更新数据</p>-->
   <p > 当前所在社区: <input type="text"  name="name" value="" class="col_37A "></p>

    <p >社区编号:<input type="text"  name="id" value="" class="col_37A "></p>
    <p >社区全称:<input type="text"  name="full_name" value="" class="col_37A "></p>
    <p >社区简称:<input type="text"  name="name" value="" class="col_37A "></p>
    <p >社区简介:<input type="text"  name="brief" value=""  style="width:50%;word-break:break-all" class="col_37A "></p>      <!--  <textarea class="col_37A " cols="5"></textarea>-->
    <p >所在城市:<input type="text"  name="city" value="" class="col_37A "></p>
            <p >社区位置:<input type="text"  name="location" value="" class="col_37A " style="width:30%;"> </p>
            <p>经度:<input type="text"  name="longitude" value="" class="col_37A " style="width:100px;">
            纬度:<input type="text"  name="latitude" value="" class="col_37A " style="width:100px;">
                <a  class="col_37A situation">点击查看地图位置:</a>
            </p>

    <p >社区户数:<input type="text"  name="households" value="" class="col_37A "></p>
    <p >总车位数:<input type="text"  name="parking_lots" value="" class="col_37A "></p>
            <div id="container" style="">

            </div>
    </div>

        <div  class="imgwrap"  >
            <div >
                <img   class="villageimg " src="" alt="#" >
            </div>
        </div>
    </div>
</div>
<input type="hidden" value='<?php echo $username;?>' name="username" />
<script>



    /* var map = new BaiduMap({
         id: "container3",
         level: 16, //  选填--地图级别--(默认15)
         zoom: true, // 选填--是否启用鼠标滚轮缩放功能--(默认false)
         type: ["地图", "卫星", "三维"], // 选填--显示地图类型--(默认不显示)
         width: 320, // 选填--信息窗口width--(默认自动调整)
         height: 70, // 选填--信息窗口height--(默认自动调整)
         titleClass: "title",
         contentClass: "content",
         showPanorama: true, // 是否显示全景控件(默认false)
         showMarkPanorama: true, // 是否显示标注点全景图(默认false)
         showLabel: false, // 是否显示文本标注(默认false)
         mapStyle: "normal", // 默认normal,可选dark,light
         icon: { // 选填--自定义icon图标
             url: "img/marker2.png",
             width: 34,
             height: 94
         },
         centerPoint: { // 中心点经纬度
             lng: 118.106586,
             lat: 24.467207
         },
         index: 3, // 开启对应的信息窗口，默认-1不开启
         animate: true, // 是否开启坠落动画，默认false
         points: points, // 标注点--id(唯一标识)
         callback: function(id) { // 点击标注点回调
             $(".list").find("li").eq(id - 1).addClass("active").siblings().removeClass("active");
         }
     });

    map.getPosition(id)// 获取位置信息，不传id获取当前开启信息窗口位置信息，传入id获取指定位置信息（id--标注点唯一标识）；

    map.openInfoWindow(id)// 开启指定位置信息窗口（id必须） */
</script>

<script src='<?=base_url().'application/views/plugin/app/js/villageInfo_list.js'?>'></script>
</body>
</html>
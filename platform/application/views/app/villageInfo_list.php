<?php
	require 'top.php'
?>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-table/css/bootstrap-table.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/jstree/dist/themes/default/style.min.css'?>'/>
<!--<script src='<?/*=base_url().'application/views/plugin/jquery-bdmap/js/jquery.baiduMap.min'*/?>'></script>-->
<!-- <script src='http://api.map.baidu.com/getscript?v=2.0&ak=aRMXU5OVYpSZCqXlS0zL1K3OepYKZhr4&services=&t=20180529182003'></script> -->
<style>
p{
    margin:10px;
}
.title{
    position:relative;
    font-size:16px;
    margin-left:10px;
}
.content{
    font-size:14px;
}
.show{
    float:left;
    font-size: 14px;
    width:50%;

}
.brief{
    width:70%;
    height:200px;
    resize:none;
    margin-left:8px;
}
#container{
    margin-top:10px;
    width: 520px;
    height:350px;
}

.imgwrap{
    width: 600px;
    height:100%;
}

.villageimg{
    width: 100%;
    height:100%;
}


.right{
    float:left;
}

.icon_circle {
    display: inline-block;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: #37ACFF;
    margin-right:10px;
    vertical-align: middle;
    position: absolute;
    left: -10px;
    top: 6px;
}
.add_btn{
    width:10%;
    float:right;
    font-size: 14px;
}
.update{
    position:absolute;
    right:20px;
}
/*

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
*/



</style>
<div class="oh pt10">
<?php
	require 'menus.php'
?>
    <div class="col-sm-12 main_wrap">
        <div class="left show" >
            <div class="title">
                <p class="col_37A"><i class="icon_circle" ></i>社区基本信息</p>
              <!-- <button class=" add_btn update"  >编辑</button>-->
                <div class=" fl" style="width:30%;">
                    <div class="content">
                         <p>当前所在社区:</p>
                         <p>社区编号:</p>
                         <p>社区全称:</p>
                         <p>社区简称:</p>
                         <p>所在城市:</p>
                         <p>社区位置:</p>
                         <p>经度:</p>
                         <p> 纬度: <p>
                         <p>社区户数:</p>
                         <p>总车位数:</p>
                         <p>社区简介:</p>
                    </div>
                </div>
                <div class=" fl content" style="width:70%; position:relative;">
                    <p  class="name "></p>
                    <p  class="id"></p>
                    <p  class="full_name "></p>
                    <p  class="name "></p>
                    <p  class="city "></p>
                    <p  class="location "></p>
                    <p  class="longitude "></p>
                    <p  class="latitude "><p>
                    <p  class="households "></p>
                    <p  class="parking_lots "></p>
                    <textarea class="brief" id="brief" title="可修改社区简介" readonly></textarea>
                    <!-- <i class="fa  fa-pencil-square-o fa-lg update"></i> -->
                </div>
                <div class="clear"></div>
            </div>
            <div class="tac"><span><i class="icon fa fa-pencil-square-o" data-target="#update" data-toggle="modal"></i></span></div>
        </div>
    </div>
    <div class="modal fade" id="update"  tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog"  style="width: 630px;">
            <div class="modal-content model_wrap">
                <div class="model_content">
                    <div class="building_header">
                        <h4 class="modal-title tac">编辑社区信息</h4>
                    </div>
                    <div class="modal-body building write_building">
                        <p style="line-height: 24px;"><span class="des" style="margin-left:20px;">当前所在社区：</span>
                            <span class="code col_37A name"></span>
                        </p>
                        <p style="line-height: 24px;">
                            <span class="des" style="margin-left:20px;">社区编号：</span>
                            <span class="effective_date col_37A id" style="margin-left:23px;"></span>
                        </p>
                        <p style="line-height: 24px;">
                            <span class="des" style="margin-left:20px;">社区全称：</span>
                            <span class="effective_status col_37A full_name"  style="margin-left:23px;"></span>
                        </p>
                        <p style="line-height: 24px;"><span class="des" style="margin-left: 20px;">社区简称：</span>
                            <span class="code col_37A name" style="margin-left:23px;"></span>
                        </p>
                        <p style="line-height: 24px;">
                            <span class="des" style="margin-left:20px;">所在城市：</span>
                            <span class="level_name col_37A city"  style="margin-left:23px;"></span>
                        </p>
                        <p style="line-height: 24px;">
                            <span class="des" style="margin-left:20px;">社区位置：</span>
                            <span class="parent_code_name col_37A location" style="margin-left:23px;"></span>
                        </p>
                        <p style="line-height: 24px;"><span class="des" style="margin-left:20px;">经度：</span>
                            <span class="rank col_37A location" style="margin-left:46px;"></span>
                        </p>
                        <p style="line-height: 24px;"><span class="des" style="margin-left:20px;">纬度：</span>
                            <span class="rank col_37A latitude" style="margin-left:46px;"></span>
                        </p>
                        <p  style="line-height: 24px;"><span class="des" style="margin-left:20px;">社区户数：</span>
                            <span class="rank col_37A households" style="margin-left:23px;"></span>
                        </p>
                        <p style="line-height: 24px;"><span class="des" style="margin-left:20px;">总车位数：</span>
                            <span class="rank col_37A parking_lots" style="margin-left:23px;"></span>
                        </p>
                        <p style="line-height: 24px;"><span class="des" style="margin-left:20px;">社区简介：</span>
                            <textarea class="brief" title="可修改社区简介" style="vertical-align: top;border:1px solid #999;"></textarea>
                        </p>
                        
                    </div>
                </div>
                <div class="modal_footer bg_eee oh">
                    <p class="fr pt17" style="margin:0">
                        <span class="col_37A fl confirm">保存</span>
                        <span class="col_C45 fl"  data-dismiss="modal">取消</span>
                    </p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
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
<script>
//修改社区简介
$('#update .confirm').click(function(){
    var id = $('#update .id').html();
    var brief = $('#update .brief').val();
    console.log(id);
    console.log(brief);
    $.ajax({
        url: getRootPath() + '/index.php/Building/updatevillageInfo',
        method: 'post',
        data: {
            id:id,
            brief: brief
        },
        success:function(data){
            window.location.href=getRootPath() + '/index.php/Building/villageInfo'
        },
        error:function () {
            console.log('编辑出错了');
        }
    })
})
</script>
</body>
</html>
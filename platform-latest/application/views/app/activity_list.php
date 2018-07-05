<?php
	require 'top.php'
?>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-table/css/bootstrap-table.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/jstree/dist/themes/default/style.min.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-fileinput/css/fileinput.min.css'?>'/>

<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table-zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/moment-with-locales.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/jstree/dist/jstree.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-fileinput/js/fileinput.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-fileinput/js/zh.js'?>'></script>


<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->
    <div class="col-sm-12 main_wrap">
    <!-- 筛选条件 -->
    <div class="searc_bar search_wrap " id="search_wrap" >

        <span class="col_37A fl">筛选条件</span>
        <!-- 筛选条件 时间-->
        <input type="text" class="select_time date col_37A fl form-control" name="begin_date"  value="">

        <!--筛选地点-->
      <!--  <a href="javascript:;" id="treeNav" class="treeWrap treeWrapSearch"><span></span></a>-->



        <!-- 筛选条件 创建类型-->
        <div class="Search_Item_wrap search_wrap_1 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input search_1 ka_input3" placeholder="活动类型" name="type" data-ajax="" value="" readonly style="width:150px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:150px;">
                <div class="ka_drop_list" >
                    <ul >
                        <li><a href="javascript:;" data-ajax="101">成年人活动</a></li>
                        <li><a href="javascript:;" data-ajax="102">长者活动</a></li>
                        <li><a href="javascript:;" data-ajax="103">儿童活动</a></li>
                        <li><a href="javascript:;" data-ajax="104">其他活动</a></li>
                    </ul>
                </div>
            </div>
        </div>




        <!-- 筛选条件 查找-->
        <form class="search_room" action="" method="get">
            <p>
                <input type="text" class="searc_room_text" name="keyword" placeholder="请输入活动名称、物业负责人..." value="" title="请输入活动名称、物业负责人进行查找">  <a id="clear" onclick="return false">X</a>
            </p>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

     </div>

    <!-- 物资数据-->
        <div class="table_wrap">
           <div class="oh pt10">
                <span class="fr add_btn" data-target="#add_Item" data-toggle="modal">新增活动圈</span>
               <a class="fr add_btn" id="reset" >重置</a>
            </div>
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>
                    <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                    <th data-title="活动编号" data-align="center" data-field="a_code"></th>
                    <th data-title="活动名称" data-align="center" data-field="a_name"></th>
                    <th data-title="活动类型" data-align="center" data-field="a_type_name"></th>
                    <th  data-title="物业负责人" data-align="center" data-field="service_name"></th>
                    <th data-title="有兴趣的业主" data-align="center" data-formatter="viewAll" data-field="person_name"></th>
                    <th  data-title="活动开始日期" data-align="center" data-field="begin_date_name"></th>
                    <th  data-title="活动结束日期" data-align="center" data-field="end_date_name"></th>
                    <th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
                </tr>
                </thead>

            </table>
        </div>


        <!--物资数据分页处理-->
        <ul class="pager" page=''>
            <li><a href='' id='first'>首 页</a></li>
            <li class=""><a href='' id='prev' >上一页</a></li>
            <li class="disabled"><a href='javascript:void(0);' id='current'></a></li>
            <li class=""  ><a  id='next' href=''>下一页</a></li>
            <li><a href='' id='last'>尾 页</a></li>
            <li><input type='text' class='fenye_input' name='fenye_input'/> </li>
            <li><a href='#'  class='fenye_btn'>GO</a></li>
        </ul>



        <!-- 增加物资 -->
        <div class="modal fade" id="add_Item" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog"  style="width:638px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">新增活动圈</h4>
                        </div>
                        <div class="modal-body building add_Item">
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;活动编号：<span class="code" style="margin-left:45px;"></span></p>
                            <p><span class="red_star">*</span>活动名称：
                                <input type="text" class="model_input supplier" placeholder="请输入活动名称"  name="name" />
                            </p>

                            <div class="select_wrap select_pull_down">
                                <div>
                                    <span class="red_star">*</span>活动类型：
                                    <input type="text" class="model_input type ka_input3" placeholder="请输入活动类型"  name="type" data-ajax="" readonly />
                                </div>

                                <div class="ka_drop" style="margin-left:20px;width: 300px;">
                                    <div class="ka_drop_list" style="width: 300px;">
                                        <ul>
                                            <li><a href="javascript:;" data-ajax="101">成年人活动</a></li>
                                            <li><a href="javascript:;" data-ajax="102">长者活动</a></li>
                                            <li><a href="javascript:;" data-ajax="103">儿童活动</a></li>
                                            <li><a href="javascript:;" data-ajax="104">其他活动</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <p><span class="red_star">*</span>活动开始日期：
                                <input type="text" class="begin_date date form-control" name="begin_date" value=""/>
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;活动结束日期：
                                <input type="text" class="end_date date form-control" name="end_date" value=""/>
                            </p>
                            <div class="select_pull_down select_wrap select_room">
                                <div>
                                    <span class="red_star">*</span>物业负责人：
                                    <input type="text" class="model_input service_code ka_input3" placeholder="请输入物业负责人" name="service_code" data-ajax="" readonly="">
                                </div>
                                <div class="ka_drop "   style="width:200px;">
                                    <div class="ka_drop_list"  >
                                        <ul  >

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="search_person_wrap">
                                <div class="oh" style="">
                                    <div class="fl">
                                        &nbsp;&nbsp;&nbsp;&nbsp;感兴趣的业主：
                                    </div>
                                    <div class="fl search_person_text "style="margin-left:18px;">
                                        <input type="text" class="fl search_person_name" placeholder="请输入姓名查找" style="width:300px;font-size:inherit;" name="search_person_code">
                                        <a class="fr search_person_btn"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="search_person_results">

                                </div>
                                <div class="person_building_data">
                                    <ul>

                                    </ul>
                                </div>
                            </div>


                    </div>
                    </div>
                    <div class="modal_footer bg_eee oh">
                        <p class="fr pt17">
                            <span class="col_37A fl confirm">保存</span>
                            <span class="col_C45 fl"  data-dismiss="modal">取消</span>
                        </p>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>



        <!--详细信息 -->
        <div class="modal fade" id="person_detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 700px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">活动圈详情</h4>
                        </div>
                        <div class="modal-body building oh">
                            <div class=" person_wrap person_detail" style="width:600px;">

                                <p><span class="des">活动编号:</span>
                                    <span class="a_code col_37A"></span>
                                </p>
                                <p><span class="des">活动名称:</span>
                                    <span class="a_name col_37A"></span>
                                </p>
                                <p><span class="des">开始日期:</span>
                                    <span class="begin_date_name    col_37A"></span>
                                </p>
                                <p><span class="des">结束日期:</span>
                                    <span class="end_date_name col_37A"></span>
                                </p>
                                <p><span class="des">活动类型:</span>
                                    <span class="a_type_name col_37A"></span>
                                </p>
                                <p><span class="des">有兴趣的住户:</span>
                                    <span class="person_name col_37A"></span>
                                </p>
                                <p><span class="des">物业负责人:</span>
                                    <span class="service_name col_37A"></span>
                                </p>
                                <img src="" alt="#" class="a_qr_code">
                            </div>

                        </div>
                    </div>
                    <div class="modal_footer bg_eee">
                        <p class="tac pb17">
                            <span class="col_37A cancle"  data-dismiss="modal">关闭</span>
                        </p>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </div>

    </div>
</div>





<input type="hidden" value='<?php echo $username;?>' name="username" />
<input type="hidden" value='<?php echo $page;?>' name="page" />
<input type="hidden" value='<?php echo $pagesize;?>' name="pagesize" />
<input type="hidden" value='<?php echo $total;?>' name="total" />
<script>

     /*  $('.additionalurl').click(function(e){

        var $eleForm = $("<form method='get'></form>");

           $eleForm.attr("action",'platform/upload/Contracts/152825652050461');

           $(document.body).append($eleForm);

           //提交表单，实现下载
           $eleForm.submit();
    });
*/

    $(function() {
        //初始化fileinput
        var fileInput = new FileInput();
        fileInput.Init("cardnumber", getRootPath()+'/index.php/Contract/upload');
    });

    //初始化fileinput
    var FileInput = function() {
        var oFile = new Object();

        //初始化fileinput控件（第一次初始化）
        oFile.Init = function(ctrlName, uploadUrl) {
            var control = $('#' + ctrlName);
            //初始化上传控件的样式
            control.fileinput({
                language: 'zh', //设置语言
                uploadUrl: uploadUrl, //上传的地址
             //   allowedFileExtensions: ['jpg', 'png'], //接收的文件后缀
                uploadAsync: true, //默认异步上传
                showUpload: true, //是否显示上传按钮
                showRemove: false, //显示移除按钮
                showCaption: true, //是否显示标题
                dropZoneEnabled: false, //是否显示拖拽区域
                minFileCount: 1,
                maxFileCount: 1, //表示允许同时上传的最大文件个数
              /*  maxImageWidth:'',
                maxImageHeight:'',*/
                maxFileSize:10240,
                enctype: 'multipart/form-data',
                browseClass: "btn btn-primary", //按钮样式: btn-default、btn-primary、btn-danger、btn-info、btn-warning
                previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            });

            //文件上传完成之后发生的事件
            control.on("fileuploaded", function(event, data, previewId, index) {
                //成功后隐藏上传按钮
                // $("#cardnumber").hide();
                //传递图片地址给后端
                response = data.response;
                url = response[2].filepath;
                $('input[name="additionals"]').val(url)
                console.log($('input[name="additionals"]').val())
                picReady = true;
                $('.btn-file,.fileinput-upload-button').hide();
            });
            //图片上传成功后点击删除图片事件
            control.on("filesuccessremove", function(event, data, previewId, index) {
                picReady = false;
                $('.btn-file,.fileinput-upload-button').show();
            });
            //点击右上角关闭按钮后的事件
            control.on("filecleared", function(event, data, previewId, index) {
                picReady = false;
                $('.btn-file,.fileinput-upload-button').show();
            });
        }
        return oFile; //这里必须返回oFile对象，否则FileInput组件初始化不成功
    };




</script>
<script src='<?=base_url().'application/views/plugin/app/js/activity_list.js'?>'></script>
</body>
</html>
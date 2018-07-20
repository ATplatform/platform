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
    <iv class="col-sm-12 main_wrap">
    <!-- 筛选条件 -->
    <div class="searc_bar search_wrap " id="search_wrap" >

     </div>


    <!-- 物资数据-->
        <div class="table_wrap">
         <div class="oh pt10">

         <span class="fr add_btn " data-target="#add_Item" data-toggle="modal">统一更新住宅物业费</span>

             <a class="fr add_btn" id="reset" >清除筛选</a>
            </div>
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>

                   <!-- <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                    <th data-title="车位编号" data-align="center" data-field="lot_code_name"></th>
                    <th data-title="生效日期" data-align="center" data-field="lot_effective_date_name"></th>
                    <th data-title="停车场" data-align="center" data-field="par_parkname"></th>
                    <th  data-title="楼层" data-align="center" data-field="lot_floor_name"></th>
                    <th data-title="车位区域" data-align="center" data-field="lot_biz_type_name"></th>
                    <th  data-title="车位状态" data-align="center" data-field="lot_biz_status_name"></th>
                    <th  data-title="占用原因" data-align="center" data-field="lot_biz_reason_name"></th>
                    <th  data-title="占用人" data-align="center" data-field="lot_owner_fullname"></th>
                    <th  data-title="占用开始日期" data-align="center" data-field="lot_begin_date_name"></th>
                    <th  data-title="占用结束日期" data-align="center" data-field="lot_end_date_name"></th>
                    <th  data-title="车位租金" data-align="center" data-field="lot_monthly_rent_name"></th>
                    <th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>-->

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


        <!--详细信息 -->
        <div class="modal fade" id="person_detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 600px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">

                    </div>

                    <div class="modal_footer bg_eee">
                        <p class="tac pb17">
                            <span class="col_37A cancle"  data-dismiss="modal">关闭</span>
                        </p>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>



        <!--修改 -->
        <div class="modal fade" id="rewrite" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog"  style="width:650px;">
                <div class="modal-content model_wrap" style="width:650px;">
                    <div class="model_content" style="width:650px;position:relative;">
                        <div class="building_header">
                            <h4 class="modal-title tac">统一更新物业费</h4>
                        </div>
                        <div class=" modal-body building  oh">
                            <div class="rewrite">
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer bg_eee">
                        <p class="tac pb17">
                            <span class="col_37A confirm">保存</span>
                            <span class="col_FFA cancle"  data-dismiss="modal">取消</span>
                        </p>
                    </div>
                </div>

            </div>
        </div><!-- /.modal-content -->
        <!-- /.modal -->


        <!-- 增加物资 -->
        <div class="modal fade" id="add_Item" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 630px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">统一更新物业费</h4>
                        </div>
                        <div class=" modal-body building  oh">
                            <div class="add_item">
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer bg_eee">
                        <p class="tac pb17">
                            <span class="col_37A confirm">保存</span>
                            <span class="col_FFA cancle"  data-dismiss="modal">取消</span>
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
    //////////////////////////////搜索模块的树形地点///////////////////////////////////
    var treeNav_data = <?php echo $treeNav_data?>;
    //搜索框楼宇层级树形菜单
    $('#treeNav>span').jstree({
        'core' : {
            data: treeNav_data
        }
    })


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
<script src='<?=base_url().'application/views/plugin/app/js/property_fee.js'?>'></script>
</body>
</html>
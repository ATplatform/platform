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

        <span class="col_37A fl">筛选条件</span>
        <!-- 筛选条件 时间-->
        <input type="text" class="select_time date col_37A fl form-control" name="effective_date"  value="">

        <!--筛选地点-->
        <!-- <a href="javascript:;" id="treeNav" class="treeWrap treeWrapSearch"><span></span></a>-->



        <!-- 筛选条件 创建类型-->
        <div class="Search_Item_wrap search_wrap_1 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input search_1 ka_input3" placeholder="小区车/访客车" name="if_resident" data-ajax="" value="" readonly style="width:100px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:100px;">
                <div class="ka_drop_list" >
                    <ul >
                        <li><a href="javascript:;" data-ajax="t">小区车</a></li>
                        <li><a href="javascript:;" data-ajax="f">访客车</a></li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="Search_Item_wrap search_wrap_2 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input search_2 ka_input3" placeholder="当前授权/未来授权" name="auz_2" data-ajax="" value="" readonly style="width:150px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:150px;">
                <div class="ka_drop_list" >
                    <ul >

                        <li><a href="javascript:;" data-ajax="101">当前授权</a></li>
                        <li><a href="javascript:;" data-ajax="102">未来授权</a></li>

                    </ul>
                </div>
            </div>
        </div>

       <!-- <div class="Search_Item_wrap search_wrap_3 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input search_3 ka_input3" placeholder="授权记录有效查询" name="vehicle_auz" data-ajax="" value="" readonly style="width:150px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:150px;">
                <div class="ka_drop_list" >
                    <ul >

                        <li><a href="javascript:;" data-ajax="101">无任何记录</a></li>
                        <li><a href="javascript:;" data-ajax="102">当前或未来有生效记录</a></li>
                        <li><a href="javascript:;" data-ajax="103">所有授权已失效</a></li>
                    </ul>
                </div>
            </div>
        </div>-->

        <!-- 筛选条件 查找-->
        <form class="search_room" action="" method="get">
            <p>
                <input type="text" class="searc_room_text" name="keyword" placeholder="可输入授权编号、车牌号、授权人发起..." value="" title="可输入授权编号、车牌号、授权人发起人、车辆使用人进行搜索"><a id="clear" onclick="return false">X</a>
            </p>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

     </div>

    <!-- 物资数据-->
        <div class="table_wrap">
           <div class="oh pt10">
               <span class="fr add_btn" data-target="#vehicle_auz" data-toggle="modal">新增授权</span>
                <a class="fr add_btn" href="<?=base_url().'index.php/Vehicle/vehicleAuz'?>">清除筛选</a>
            </div>
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>
                    <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                    <th data-title="小区车/访客车" data-align="center" data-field="v_if_resident_name"></th>
                    <th data-title="授权编号" data-align="center" data-field="auz_code"></th>
                    <th  data-title="车牌号" data-align="center" data-field="v_licence"></th>
                    <th data-title="授权发起人" data-align="center" data-field="auz_person_name"></th>
                    <th data-title="车辆使用人" data-align="center" data-field="v_person_name"></th>
                    <th data-title="授权开始时间" data-align="center" data-field="auz_begin_date_name"></th>
                    <th data-title="授权结束时间" data-align="center" data-field="auz_end_date_name"></th>
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
            <div class="modal-dialog"  style="width: 700px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">车辆详情</h4>
                        </div>
                        <div class="modal-body building oh">
                            <div class="fl person_wrap person_detail ">
                                <p><i class="icon_circle"></i>车辆信息</p>
                                <p><span class="des">车辆编号:</span>
                                    <span class="v_code col_37A"></span>
                                </p>
                                <p><span class="des">生效日期:</span>
                                    <span class="v_effective_date_name col_37A"></span>
                                </p>
                                <p><span class="des">状态:</span>
                                    <span class="v_effective_status_name    col_37A"></span>
                                </p>
                                <p><span class="des">车辆登记人:</span>
                                    <span class="v_person_name col_37A"></span>
                                </p>
                                <p><span class="des">车辆类型:</span>
                                    <span class="v_vehicle_type_name col_37A"></span>
                                </p>
                                <p><span class="des">小区车/访客车:</span>
                                    <span class="v_if_resident_name col_37A"></span>
                                </p>
                                <p><span class="des">是否电动汽车:</span>
                                    <span class="v_if_electro_name col_37A"></span>
                                </p>
                                <p><span class="des">车牌号:</span>
                                    <span class="v_licence col_37A"></span>
                                </p>
                                <p><span class="des">是否临时车牌:</span>
                                    <span class="v_if_temp_name col_37A"></span>
                                </p>
                                <p><span class="des">车主:</span>
                                    <span class="v_owner col_37A"></span>
                                </p>
                                <p><span class="des">品牌:</span>
                                    <span class="v_brand_name col_37A"></span>
                                </p>
                                <p><span class="des">型号:</span>
                                    <span class="v_model col_37A"></span>
                                </p>
                                <p><span class="des">颜色:</span>
                                    <span class="v_color col_37A"></span>
                                </p>
                                <p><span class="des">备注:</span>
                                    <span class="v_remark col_37A"></span>
                                </p>

                            </div>
                            <div class="fl person_wrap person_detail ">
                                <p><i class="icon_circle"></i>授权信息</p>
                                <p><span class="des">当前授权:</span>
                                    <span class="auzfornow_name col_37A"></span>
                                </p>
                                <p><span class="des">授权记录有效查询:</span>
                                    <span class="auzforall_name col_37A"></span>
                                </p>
                                <p><span class="des">授权记录:</span>
                                    <span class="team_person_name col_37A"></span>
                                </p>
                                <table id="getauz"
                                       data-toolbar="#toolbar">
                                    <thead>
                                    <tr>
                                        <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                                        <th data-title="授权编号" data-align="center" data-field="auz_code"></th>
                                        <th data-title="授权发起人" data-align="center" data-field="auz_person_name"></th>
                                        <th data-title="开始日期" data-align="center" data-field="auz_begin_date_name"></th>
                                        <th  data-title="结束日期" data-align="center" data-field="auz_end_date_name"></th>
                                        <th  data-title="备注" data-align="center" data-field="auz_remark"></th>
                                    </tr>
                                    </thead>

                                </table>
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


        <!--修改 -->
        <div class="modal fade" id="vehicle_auz" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog"  style="width:630px;">
                <div class="modal-content model_wrap" style="width:630px;">
                    <div class="model_content" style="width:630px;">
                        <div class="building_header">
                            <h4 class="modal-title tac">新增授权信息</h4>
                        </div>
                        <div class=" modal-body building  oh">


                            <div class=" add_item  ">
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;授权编号：<span class="auz_code" style="margin-left:45px;"></span></p>
                                <div class="select_pull_down select_wrap select_room">
                                    <div>
                                        <span class="red_star">*</span>授权发起人：
                                        <input type="text" class="model_input auz_person_code ka_input3" placeholder="请输入授权发起人" name="auz_person_code" data-ajax="" readonly="">
                                    </div>
                                    <div class="ka_drop "   style="width:200px;">
                                        <div class="ka_drop_list"  >
                                            <ul  >

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p><span class="red_star">*</span>开始日期：
                                    <input type="text" class="auz_begin_date date form-control" name="auz_begin_date" value=""/>
                                </p>
                                <p><span class="red_star">*</span>结束日期：
                                    <input type="text" class="auz_end_date date form-control" name="auz_end_date" value=""/>
                                </p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;备注：
                                    <input type="text" class="model_input auz_remark" placeholder="请输入备注"  name="auz_remark" />
                                </p>

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


        <!--修改 -->
        <div class="modal fade" id="auz_rewrite" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog"  style="width:630px;">
                <div class="modal-content model_wrap" style="width:630px;">
                    <div class="model_content" style="width:630px;">
                        <div class="building_header">
                            <h4 class="modal-title tac">更新授权信息</h4>
                        </div>
                        <div class=" modal-body building  oh">


                                                        <div class=" rewrite  ">
                                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;授权编号：<span class="auz_code" style="margin-left:45px;"></span></p>
                                                            <div class="select_pull_down select_wrap select_room">
                                                                <div>
                                                                    <span class="red_star">*</span>授权发起人：
                                                                    <input type="text" class="model_input auz_person_code ka_input3" placeholder="请输入授权发起人" name="auz_person_code" data-ajax="" readonly="">
                                                                </div>
                                                                <div class="ka_drop "   style="width:200px;">
                                                                    <div class="ka_drop_list"  >
                                                                        <ul  >

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p><span class="red_star">*</span>开始日期：
                                                                <input type="text" class="auz_begin_date date form-control" name="auz_begin_date" value=""/>
                                                            </p>
                                                            <p><span class="red_star">*</span>结束日期：
                                                                <input type="text" class="auz_end_date date form-control" name="auz_end_date" value=""/>
                                                            </p>
                                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;备注：
                                                                <input type="text" class="model_input auz_remark" placeholder="请输入备注"  name="auz_remark" />
                                                            </p>

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
<script src='<?=base_url().'application/views/plugin/app/js/vehicle_auz.js'?>'></script>
</body>
</html>
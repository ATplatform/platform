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
<script src='<?=base_url().'application/views/plugin/jstree/dist/jstree.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-fileinput/js/fileinput.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-fileinput/js/zh.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.zh-CN.js'?>'></script>
<div class="header oh">
	<div class="fl logo">
		<i></i>艾特智能AI社区云平台
	</div>
	<div class="top_login_wrap fr">
		<span class="user"><i></i> <span></span></span>
		|<a class="login_out" href="<?=base_url().'index.php/Login/logout'?>">退出登录</a>
	</div>
</div>	

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
                <input type="text"  class="model_input search_1 ka_input3" placeholder="合同类别" name="type" data-ajax="" value="" readonly style="width:150px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:150px;">
                <div class="ka_drop_list" >
                    <ul >
                        <li><a href="javascript:;" data-ajax="101">业务外包合同</a></li>
                        <li><a href="javascript:;" data-ajax="102">经营性合同</a></li>
                        <li><a href="javascript:;" data-ajax="103">与业主的服务协议</a></li>
                        <li><a href="javascript:;" data-ajax="104">业主的授权协议</a></li>
                        <li><a href="javascript:;" data-ajax="999">其他</a></li>
                    </ul>
                </div>
            </div>
        </div>




            <!--筛选工单类型-->
        <div class="Search_Item_wrap search_wrap_2 select_pull_down query_wrap col_37A fl">
            <div >
                <input type="text"  class="model_input search_2 ka_input3" placeholder="合同级别" name="level" data-ajax="" value="" readonly style="width:150px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:150px;">
                <div class="ka_drop_list" >
                    <ul >
                        <li><a href="javascript:;" data-ajax="101">需呈报总部的合同</a></li>
                        <li><a href="javascript:;" data-ajax="102">内部管理合同</a></li>


                    </ul>
                </div>
            </div>
        </div>


        <!-- 筛选条件 查找-->
        <form class="search_room" action="" method="get">
            <p>
                <input type="text" class="searc_room_text" name="keyword" placeholder="请输入合同编号、签订对象" value=""><a id="clear" href="">X</a>
            </p>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

     </div>

    <!-- 物资数据-->
        <div class="table_wrap">
           <div class="oh pt10">
                <span class="fr add_btn" data-target="#add_Item" data-toggle="modal">新增合同信息</span>
            </div>
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>
                    <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                    <th data-title="合同编号" data-align="center" data-field="c_code"></th>
                    <th data-title="签订对象" data-align="center" data-field="signed_with"></th>
                    <th  data-title="开始日期" data-align="center" data-field="begin_date_name"></th>
                    <th data-title="结束日期" data-align="center" data-field="end_date_name"></th>
                    <th  data-title="合同类别" data-align="center" data-field="type_name"></th>
                    <th  data-title="合同级别" data-align="center" data-field="level_name"></th>
                    <th data-title="合同单价" data-align="center" data-field="amount" ></th>
                    <th  data-title="合同维护人" data-align="center" data-field="position_name"></th>
                    <th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
                </tr>
                </thead>

            </table>
        </div>


        <!--物资数据分页处理-->
        <ul class="pager" page='<? $page ?>'>
            <?php
            $first=base_url().'index.php/Contract/contractList?page=1&type='.$type.'&keyword='.$keyword.'&begin_date='.$begin_date.'&level='.$level;
            echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
            if($page>1) {
                $url=base_url().'index.php/Contract/contractList?page='.($page-1).'&type='.$type.'&keyword='.$keyword.'&begin_date='.$begin_date.'&level='.$level;
                echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
            }else{
                echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
            }
            echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
            if($page<$total) {
                $url=base_url().'index.php/Contract/contractList?page='.($page+1).'&type='.$type.'&keyword='.$keyword.'&begin_date='.$begin_date.'&level='.$level;
                echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
            }else{
                echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
            }
            $last=base_url().'index.php/Contract/contractList?page='.$total.'&type='.$type.'&keyword='.$keyword.'&begin_date='.$begin_date.'&level='.$level;
            echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
            echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
            echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
            ?>
        </ul>



        <!-- 增加物资 -->
        <div class="modal fade" id="add_Item" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 638px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">新增合同信息</h4>
                        </div>
                        <div class="modal-body building add_Item">
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;合同编码：<span class="code" style="margin-left:26px;"></span></p>
                            <p><span class="red_star">*</span>开始日期：
                                <input type="text" class="begin_date date form-control" name="begin_date" value=""/ >
                            </p>
                            <p><span class="red_star">*</span>结束日期：
                                <input type="text" class="end_date date form-control" name="end_date" value=""/ >
                            </p>
                            <div class="select_wrap select_pull_down">
                                <div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;合同类别：
                                    <input type="text" class="model_input material_type ka_input3" placeholder="请输入合同类别"  name="type" data-ajax="" readonly />
                                </div>
                                <div class="ka_drop" style="margin-left:10px;width: 300px;">
                                    <div class="ka_drop_list" style="width: 300px;">
                                        <ul>
                                            <li><a href="javascript:;" data-ajax="101">业务外包合同</a></li>
                                            <li><a href="javascript:;" data-ajax="102">经营性合同</a></li>
                                            <li><a href="javascript:;" data-ajax="103">与业主的服务协议</a></li>
                                            <li><a href="javascript:;" data-ajax="104">业主的授权协议</a></li>
                                            <li><a href="javascript:;" data-ajax="999">其他</a></li>


                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="select_wrap select_pull_down">
                                <div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;合同级别：
                                    <input type="text" class="model_input level ka_input3" placeholder="请输入合同级别"  name="level" data-ajax="" readonly />
                                </div>
                                <div class="ka_drop" style="margin-left:10px;width: 300px;">
                                    <div class="ka_drop_list" style="width: 300px;">
                                        <ul>
                                            <li><a href="javascript:;" data-ajax="101">需呈报总部的合同</a></li>
                                            <li><a href="javascript:;" data-ajax="102">内部管理合同</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;合同单价：
                                <input type="text" class="model_input amount" placeholder="请输入合同单价"  name="amount" />
                            </p>
                            <div class="select_pull_down select_wrap select_room">
                                <div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;合同维护人：
                                    <input type="text" class="model_input position_code ka_input3" placeholder="请输入合同维护人" name="position_code" data-ajax="" readonly="">
                                </div>
                                <div class="ka_drop "   style="margin-left:10px;width: 300px;">
                                    <div class="ka_drop_list"  >
                                        <ul  >

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;签订对象：
                                <input type="text" class="model_input signed_with" placeholder="请输入签订对象"  name="signed_with" />
                            </p>

                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;备注：<input type="text" class="model_input remark" placeholder="请输入备注内容" name="remark" /></p>
                        </div>
                    </div>
                    <form role="form" method="post" style="margin-left:60px;width:535px;margin-bottom: 20px;"
                          　　enctype="multipart/form-data" style="margin-bottom: 20px;">
                        <input type="file" class="ka_input fileloading" id="cardnumber" name="cardnumber" >
                    </form>
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
                            <h4 class="modal-title tac">合同详情</h4>
                        </div>
                        <div class="modal-body building oh">
                            <div class=" person_wrap person_detail" style="width:600px;">

                                <p><span class="des">合同编号：</span>
                                    <span class="c_code col_37A"></span>
                                </p>
                                <p><span class="des">签订对象：</span>
                                    <span class="signed_with col_37A"></span>
                                </p>
                                <p><span class="des">开始日期：</span>
                                    <span class="begin_date_name    col_37A"></span>
                                </p>
                                <p><span class="des">结束日期：</span>
                                    <span class="end_date_name col_37A"></span>
                                </p>
                                <p><span class="des">合同类别：</span>
                                    <span class="type_name col_37A"></span>
                                </p>
                                <p><span class="des">合同级别：</span>
                                    <span class="level_name col_37A"></span>
                                </p>
                                <p><span class="des">合同单价：</span>
                                    <span class="amount col_37A"></span>
                                </p>

                                <p><span class="des">合同维护人：</span>
                                    <span class="position_name col_37A"></span>
                                </p>
                                <p><span class="des">备注：</span>
                                    <span class="remark col_37A"></span>
                                </p>


                                <p >
                                    <span class="des" style="float:left">附件:</span>
                                    <span class="additional"> </span>


                                </p>

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
<input type="hidden" value='<?php echo $page;?>' name="pages" />
<input type="hidden" value='<?php echo $page;?>' name="page" />
<input type="hidden" value='<?php echo $pagesize;?>' name="pagesize" />
<input type="hidden" value='<?php echo $pagesize;?>' name="pagesizes" />
<input type="hidden" value='<?php echo $keyword;?>' name="keywords" />
<input type="hidden" value='<?php echo $begin_date;?>' name="begin_dates" />
<input type="hidden" value='<?php echo $type;?>' name="types" />
<input type="hidden" value='<?php echo $level;?>' name="levels"/>
<input type="hidden" value='' name="additionals"/>
<input type="hidden" value='' name="additionalnames"/>
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
<script src='<?=base_url().'application/views/plugin/app/js/contract_list.js'?>'></script>
</body>
</html>
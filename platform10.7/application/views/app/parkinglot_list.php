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
    <iv class="col-sm-12 main_wrap">
    <!-- 筛选条件 -->
    <div class="searc_bar search_wrap " id="search_wrap" >

        <span class="col_37A fl">筛选条件</span>
        <!-- 筛选条件 时间-->
        <input type="text" class="select_time date col_37A fl form-control" name="lot_effective_date"  value="">

        <!--筛选地点-->
        <!-- <a href="javascript:;" id="treeNav" class="treeWrap treeWrapSearch"><span></span></a>-->



        <!-- 筛选条件 创建类型-->
        <div class="Search_Item_wrap search_wrap_1 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div>
                <input type="text"  class="model_input search_1 ka_input3" placeholder="停车场" name="lot_parkcode" data-ajax="" value="" readonly style="width:100px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:100px;">
                <div class="ka_drop_list" >
                    <ul >

                    </ul>
                </div>
            </div>
        </div>

        <div class="Search_Item_wrap search_wrap_2 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input search_2 ka_input3" placeholder="车库楼层" name="lot_floor" data-ajax="" value="" readonly style="width:100px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:100px;">
                <div class="ka_drop_list" >
                    <ul >

                        <li><a href="javascript:;" data-ajax="101">地面</a></li>
                        <li><a href="javascript:;" data-ajax="102">地下一层</a></li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="Search_Item_wrap search_wrap_3 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input search_3 ka_input3" placeholder="住宅/商业" name="lot_bit_type" data-ajax="" value="" readonly style="width:150px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:150px;">
                <div class="ka_drop_list" >
                    <ul >

                        <li><a href="javascript:;" data-ajax="101">住宅</a></li>
                        <li><a href="javascript:;" data-ajax="102">商业</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="Search_Item_wrap search_wrap_4 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input search_4 ka_input3" placeholder="车位状态" name="lot_bit_status" data-ajax="" value="" readonly style="width:150px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:150px;">
                <div class="ka_drop_list" >
                    <ul >

                        <li><a href="javascript:;" data-ajax="101">已占用</a></li>
                        <li><a href="javascript:;" data-ajax="102">公共车位</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="Search_Item_wrap search_wrap_5 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input search_5 ka_input3" placeholder="占位原因" name="lot_bit_reason" data-ajax="" value="" readonly style="width:150px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:150px;">
                <div class="ka_drop_list" >
                    <ul >

                        <li><a href="javascript:;" data-ajax="101">已出售</a></li>
                        <li><a href="javascript:;" data-ajax="102">租赁中</a></li>
                        <li><a href="javascript:;" data-ajax="103">被占用</a></li>
                    </ul>
                </div>
            </div>
        </div>


        <!-- 筛选条件 查找-->
        <form class="search_room" action="" method="get">
            <p>
                <input type="text" class="searc_room_text" name="keyword" placeholder="可输入车位编码、占用人进行搜索"><a id="clear" href="">X</a>
            </p>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

     </div>

    <!-- 物资数据-->
        <div class="table_wrap">
           <<!--div class="oh pt10">
                <span class="fr add_btn" data-target="#verify_auz" data-toggle="modal">新增车辆及授权</span>
            </div>-->
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>


                    <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
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

        <!-- 验证身份证 -->
        <div class="modal fade" id="verify_auz" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 630px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">新增人员信息</h4>
                        </div>
                        <div class="modal-body building">
                            <p class="col_7DA">为保证录入车辆信息唯一性，请输入车牌号进行验证(若是无牌电瓶车请输入机身可识别唯一编号)</p>
                            <div class="id_card_wrap">
                                <input type="text" class="col_37A" name="licence" placeholder="请输入车牌号" />
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer bg_eee oh">
                        <p class="tac pb17">
                            <span class="col_37A next">下一步</span>
                        </p>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>



        <!--详细信息 -->
        <div class="modal fade" id="person_detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 600px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">车位详情</h4>
                        </div>
                        <div class="modal-body building oh">
                            <div class=" person_wrap person_detail ">
                                <p><i class="icon_circle"></i>车位信息</p>
                                <p><span class="des">车位编号:</span>
                                    <span class="lot_code_name col_37A"></span>
                                </p>
                                <p><span class="des">生效日期:</span>
                                    <span class="lot_effective_date_name col_37A"></span>
                                </p>
                                <p><span class="des">状态:</span>
                                    <span class="lot_effective_status_name    col_37A"></span>
                                </p>
                                <p><span class="des">停车场:</span>
                                    <span class="par_parkname col_37A"></span>
                                </p>
                                <p><span class="des">所属车库楼层:</span>
                                    <span class="lot_floor_name col_37A"></span>
                                </p>
                                <p><span class="des">车位区域:</span>
                                    <span class="lot_biz_type_name col_37A"></span>
                                </p>
                                <p><span class="des">车位状态:</span>
                                    <span class="lot_biz_status_name col_37A"></span>
                                </p>
                                <p><span class="des">占用原因:</span>
                                    <span class="lot_biz_reason_name col_37A"></span>
                                </p>
                                <p><span class="des">占用人:</span>
                                    <span class="lot_owner_fullname col_37A"></span>
                                </p>
                                <p><span class="des">占用开始时间:</span>
                                    <span class="lot_begin_date_name col_37A"></span>
                                </p>
                                <p><span class="des">占用结束时间:</span>
                                    <span class="lot_end_date_name col_37A"></span>
                                </p>
                                <p><span class="des">关联车位:</span>
                                    <span class="lot_linked_lot_code_name col_37A"></span>
                                </p>
                                <p><span class="des">车位面积:</span>
                                    <span class="lot_area_name col_37A"></span>
                                </p>
                                <p><span class="des">车位租金:</span>
                                    <span class="lot_monthly_rent_name col_37A"></span>
                                </p>
                                <p><span class="des">  备注:</span>
                                    <span class="lot_remark_name col_37A"></span>
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


        <!--  input:{
                lot_code:null,
                lot_effective_date:null,

                lot_begin_date:null,
                lot_end_date:null,
                lot_area:null,
                lot_monthly_rent:null
                },
                select:{
                lot_parkcode:null,
                lot_floor: null,
                lot_biz_type: null,
                lot_biz_status:null,
                lot_biz_reason:null,
                lot_owner:null,
                },
                radio:{
                lot_effective_status:null,
                }  ,
                车位编号
                生效日期
                状态
                停车场编号
                所属车库楼层
                车位区域
                车位状态
                占用原因
                占用人
                占用开始时间
                占用结束时间
                关联车位
                车位面积
                车位租金
                车位所属探头的蓝牙地址
                备注-->
        <!--修改 -->
        <div class="modal fade" id="rewrite" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog"  style="width:650px;">
                <div class="modal-content model_wrap" style="width:650px;">
                    <div class="model_content" style="width:650px;">
                        <div class="building_header">
                            <h4 class="modal-title tac">更新车位信息</h4>
                        </div>
                        <div class=" modal-body building  oh">
                            <div class="rewrite">
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;车位编号：<span class="lot_code" style="margin-left:45px;"></span></p>
                                <p><span class="red_star">*</span>生效日期：
                                    <input type="text" class="lot_effective_date date form-control" name="lot_effective_date" value=""/>
                                </p>

                                <p class="lot_effective_status"><span class="red_star">*</span>状态：
                                    <span style="margin-left:95px;">
							<input type="radio" id="radio-5-1" name="radio-5-set" class="regular-radio" >
							<label for="radio-5-1"></label>
							有效
						</span>

                                    <span style="margin-left:82px;">
							<input type="radio" id="radio-5-2" name="radio-5-set" class="regular-radio">
							<label for="radio-5-2"></label>
							无效
						</span>
                                </p>

                                <div class="select_pull_down select_wrap search_1">
                                    <div>
                                        <span class="red_star">*</span>停车场：
                                        <input type="text" class="model_input lot_parkcode ka_input3" placeholder="请输入停车场" name="lot_parkcode" data-ajax="" readonly="">
                                    </div>
                                    <div class="ka_drop "   style="width:200px;margin-left:20px;">
                                        <div class="ka_drop_list"  >
                                            <ul  >

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="select_wrap select_pull_down">
                                    <div>
                                        <span class="red_star">*</span>所属车库楼层：
                                        <input type="text" class="model_input lot_floor ka_input3" placeholder="请输入所属车库楼层"  name="lot_floor" data-ajax="" readonly />
                                    </div>

                                    <div class="ka_drop" style="margin-left:20px;width: 300px;">
                                        <div class="ka_drop_list" style="width: 300px;">
                                            <ul>
                                                <li><a href="javascript:;" data-ajax="101">地面</a></li>
                                                <li><a href="javascript:;" data-ajax="102">地下一层</a></li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="select_wrap select_pull_down">
                                    <div>
                                        <span class="red_star">*</span>车位区域：
                                        <input type="text" class="model_input lot_biz_type ka_input3" placeholder="请输入车位区域"  name="lot_biz_type" data-ajax="" readonly />
                                    </div>

                                    <div class="ka_drop" style="margin-left:20px;width: 300px;">
                                        <div class="ka_drop_list" style="width: 300px;">
                                            <ul>
                                                <li><a href="javascript:;" data-ajax="101">住宅区停车位</a></li>
                                                <li><a href="javascript:;" data-ajax="102">商业区停车位</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="select_wrap select_pull_down">
                                    <div>
                                        <span class="red_star">*</span>车位状态：
                                        <input type="text" class="model_input lot_biz_status ka_input3" placeholder="请输入车位状态"  name="lot_biz_status" data-ajax="" readonly />
                                    </div>

                                    <div class="ka_drop" style="margin-left:20px;width: 300px;">
                                        <div class="ka_drop_list" style="width: 300px;">
                                            <ul>
                                                <li><a href="javascript:;" data-ajax="101">已占用</a></li>
                                                <li><a href="javascript:;" data-ajax="102">公共车位</a></li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="select_wrap select_pull_down">
                                    <div>
                                        <span class="red_star">*</span>占用原因：
                                        <input type="text" class="model_input lot_biz_reason ka_input3" placeholder="请输入占用原因"  name="lot_biz_reason" data-ajax="" readonly />
                                    </div>

                                    <div class="ka_drop" style="margin-left:20px;width: 300px;">
                                        <div class="ka_drop_list" style="width: 300px;">
                                            <ul>
                                                <li><a href="javascript:;" data-ajax="101">已出售</a></li>
                                                <li><a href="javascript:;" data-ajax="102">租赁中</a></li>
                                                <li><a href="javascript:;" data-ajax="103">被占用</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="select_pull_down select_wrap select_room">
                                    <div>
                                        <span class="red_star">*</span>占用人：
                                        <input type="text" class="model_input lot_owner ka_input3" placeholder="请输入占用人" name="lot_owner" data-ajax="" readonly="">
                                    </div>
                                    <div class="ka_drop "   style="width:200px;">
                                        <div class="ka_drop_list"  >
                                            <ul  >

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p><span class="red_star">*</span>占用开始时间：
                                    <input type="text" class="lot_begin_date date form-control" name="lot_begin_date" value=""/>
                                </p>

                                <p><span class="red_star">*</span>占用结束时间：
                                    <input type="text" class="lot_end_date date form-control" name="lot_end_date" value=""/>
                                </p>

                                <p><span class="red_star">*</span>关联车位：
                                    <input type="text" class="model_input lot_linked_lot_code" placeholder="请输入关联车位"  name="lot_linked_lot_code" />
                                </p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;车位面积：
                                    <input type="text" class="model_input lot_area" placeholder="请输入车位面积"  name="lot_area" />
                                </p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;车位租金：
                                    <input type="text" class="model_input lot_monthly_rent" placeholder="请输入车位租金"  name="lot_monthly_rent" />
                                </p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;备注：
                                    <input type="text" class="model_input lot_remark" placeholder="请输入备注"  name="lot_remark" />
                                </p>
                            </div>
<!--
                            <div class="fr rewrite  ">
                                <p><i class="icon_circle"></i>授权信息</p>
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
                                    <input type="text" class="begin_date date form-control" name="begin_date" value=""/>
                                </p>
                                <p><span class="red_star">*</span>结束日期：
                                    <input type="text" class="end_date date form-control" name="end_date" value=""/>
                                </p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;备注：
                                    <input type="text" class="model_input auz_remark" placeholder="请输入车主"  name="auz_remark" />
                                </p>

                            </div>-->
                        </div>
                    </div>
                    <div class="modal_footer bg_eee oh">
                        <p class="fr pt17">
                            <span class="col_37A fl confirm">保存</span>
                            <span class="col_C45 fl"  data-dismiss="modal">取消</span>
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
<script src='<?=base_url().'application/views/plugin/app/js/parkinglot_list.js'?>'></script>
</body>
</html>
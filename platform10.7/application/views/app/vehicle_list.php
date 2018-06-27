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
        <input type="text" class="select_time date col_37A fl form-control" name="effective_date"  value="">

        <!--筛选地点-->
       <a href="javascript:;" id="treeNav" class="treeWrap treeWrapSearch"><span></span></a>



        <!-- 筛选条件 创建类型-->
        <div class="Search_Item_wrap search_wrap_1 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input search_1 ka_input3" placeholder="小区车/访客车" name="if_temp" data-ajax="" value="" readonly style="width:100px;" >
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
                <input type="text"  class="model_input search_2 ka_input3" placeholder="车辆类型" name="vehicle_type" data-ajax="" value="" readonly style="width:100px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:100px;">
                <div class="ka_drop_list" >
                    <ul >

                        <li><a href="javascript:;" data-ajax="101">轿车</a></li>
                        <li><a href="javascript:;" data-ajax="102">客车</a></li>
                        <li><a href="javascript:;" data-ajax="103">货车</a></li>
                        <li><a href="javascript:;" data-ajax="104">专用汽车</a></li>
                        <li><a href="javascript:;" data-ajax="105">摩托车</a></li>
                        <li><a href="javascript:;" data-ajax="106">电瓶车</a></li>
                        <li><a href="javascript:;" data-ajax="107">自行车</a></li>
                        <li><a href="javascript:;" data-ajax="999">其他车辆</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="Search_Item_wrap search_wrap_3 select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
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
        </div>

        <!-- 筛选条件 查找-->
        <form class="search_room" action="" method="get">
            <p>
                <input type="text" class="searc_room_text" name="keyword" placeholder="可输入车辆编号、车牌号、登记人姓名..." value="" title="可输入车辆编号、车牌号、登记人姓名、车主姓名、型号进行搜索"><a id="clear" href="">X</a>
            </p>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

     </div>

    <!-- 物资数据-->
        <div class="table_wrap">
           <div class="oh pt10">
                <span class="fr add_btn" data-target="#verify_auz" data-toggle="modal">新增车辆及授权</span>
            </div>
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>
                    <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                    <th data-title="车辆编号" data-align="center" data-field="v_code"></th>
                    <th data-title="生效日期" data-align="center" data-field="v_effective_date_name"></th>
                    <th data-title="车辆登记人" data-align="center" data-field="v_person_name"></th>
                    <th  data-title="小区车/访客车" data-align="center" data-field="v_if_temp_name"></th>
                    <th data-title="车辆类型" data-align="center" data-formatter="viewAll" data-field="v_vehicle_type_name"></th>
                    <th  data-title="车牌号" data-align="center" data-field="v_licence"></th>
                    <th  data-title="车主" data-align="center" data-field="v_owner"></th>
                    <th  data-title="品牌" data-align="center" data-field="v_brand"></th>
                    <th  data-title="型号" data-align="center" data-field="v_model"></th>
                    <th  data-title="颜色" data-align="center" data-field="v_color"></th>
                    <th  data-title="备注" data-align="center" data-field="v_remark"></th>
                    <th  data-title="当前授权状态" data-align="center" data-field="auzfornow_name"></th>
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

        <!-- 增加物资 -->
        <div class="modal fade" id="add_Item" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog"  style="width:1200px;">
                <div class="modal-content model_wrap" style="width:1200px;">
                    <div class="model_content" style="width:1200px;">
                        <div class="building_header">
                            <h4 class="modal-title tac">新增车辆及授权</h4>
                        </div>
                        <div class=" modal-body building  oh">
                            <div class="fl add_Item  ">
                            <p><i class="icon_circle"></i>车辆信息</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;车辆编号：<span class="code" style="margin-left:45px;"></span></p>
                            <p><span class="red_star">*</span>生效日期：
                                <input type="text" class="effective_date date form-control" name="effective_date" value=""/>
                            </p>

                            <p class="effective_status"><span class="red_star">*</span>状态：
                                <span style="margin-left:95px;">
							<input type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked="">
							<label for="radio-1-1"></label>
							有效
						</span>

                                <span style="margin-left:82px;">
							<input type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio">
							<label for="radio-1-2"></label>
							无效
						</span>
                            </p>
                            <div class="select_pull_down select_wrap select_room">
                                <div>
                                    <span class="red_star">*</span>车辆登记人：
                                    <input type="text" class="model_input person_code ka_input3" placeholder="请输入车辆登记人" name="person_code" data-ajax="" readonly="">
                                </div>
                                <div class="ka_drop "   style="width:200px;">
                                    <div class="ka_drop_list"  >
                                        <ul  >

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="select_wrap select_pull_down">
                                <div>
                                    <span class="red_star">*</span>车辆类型：
                                    <input type="text" class="model_input vehicle_type ka_input3" placeholder="请输入车辆类型"  name="vehicle_type" data-ajax="" readonly />
                                </div>

                                <div class="ka_drop" style="margin-left:20px;width: 300px;">
                                    <div class="ka_drop_list" style="width: 300px;">
                                        <ul>
                                            <li><a href="javascript:;" data-ajax="101">轿车</a></li>
                                            <li><a href="javascript:;" data-ajax="102">客车</a></li>
                                            <li><a href="javascript:;" data-ajax="103">货车</a></li>
                                            <li><a href="javascript:;" data-ajax="104">专用汽车</a></li>
                                            <li><a href="javascript:;" data-ajax="105">摩托车</a></li>
                                            <li><a href="javascript:;" data-ajax="106">电瓶车</a></li>
                                            <li><a href="javascript:;" data-ajax="107">自行车</a></li>
                                            <li><a href="javascript:;" data-ajax="999">其他车辆</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <p class="if_temp"> <span class="red_star">*</span>小区车/访客车：
                                <span style="margin-left:44px;">
							<input type="radio" id="radio-2-1" name="radio-2-set" class="regular-radio" checked="">
							<label for="radio-2-1"></label>
							小区车
						</span>

                                <span style="margin-left:70px;">
							<input type="radio" id="radio-2-2" name="radio-2-set" class="regular-radio">
							<label for="radio-2-2"></label>
							访客车
						</span>
                            </p>
                            <p class="if_eletro">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否是电动车：
                                <span style="margin-left:45px;">
							<input type="radio" id="radio-3-1" name="radio-3-set" class="regular-radio" checked="">
							<label for="radio-3-1"></label>
							是
						</span>

                                <span style="margin-left:95px;">
							<input type="radio" id="radio-3-2" name="radio-3-set" class="regular-radio">
							<label for="radio-3-2"></label>
							否
						</span>
                            </p>

                            <p class="if_temp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否临时车牌：
                                <span style="margin-left:45px;">
							<input type="radio" id="radio-4-1" name="radio-4-set" class="regular-radio" checked="">
							<label for="radio-4-1"></label>
							是
						</span>

                                <span style="margin-left:95px;">
							<input type="radio" id="radio-4-2" name="radio-4-set" class="regular-radio">
							<label for="radio-4-2"></label>
							否
						</span>
                            </p>
                            <p><span class="red_star">*</span>车牌号：
                                <input type="text" class="model_input licence" placeholder="请输入车牌号"  name="licence" />
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;车主：
                                <input type="text" class="model_input owner" placeholder="请输入车主"  name="owner" />
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;品牌：
                                <input type="text" class="model_input brand" placeholder="请输入品牌"  name="brand" />
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;型号：
                                <input type="text" class="model_input model" placeholder="请输入型号"  name="model" />
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;颜色：
                                <input type="text" class="model_input color" placeholder="请输入颜色"  name="color" />
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;备注：
                                <input type="text" class="model_input remark" placeholder="请输入备注"  name="remark" />
                            </p>
                        </div>

                            <div class="fr add_Item  ">
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
                                    <input type="text" class="model_input auz_remark" placeholder="请输入备注"  name="auz_remark" />
                                </p>

                            </div>
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
                                <p><span class="des">是否常驻:</span>
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
                                    <span class="v_brand col_37A"></span>
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
        <div class="modal fade" id="vehicle_rewrite" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog"  style="width:650px;">
                <div class="modal-content model_wrap" style="width:650px;">
                    <div class="model_content" style="width:650px;">
                        <div class="building_header">
                            <h4 class="modal-title tac">更新车辆信息</h4>
                        </div>
                        <div class=" modal-body building  oh">
                            <div class="rewrite">
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;车辆编号：<span class="v_code" style="margin-left:45px;"></span></p>
                                <p><span class="red_star">*</span>生效日期：
                                    <input type="text" class="v_effective_date date form-control" name="v_effective_date" value=""/>
                                </p>

                                <p class="v_effective_status"><span class="red_star">*</span>状态：
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
                                <div class="select_pull_down select_wrap select_room">
                                    <div>
                                        <span class="red_star">*</span>车辆登记人：
                                        <input type="text" class="model_input v_person_code ka_input3" placeholder="请输入车辆登记人" name="v_person_code" data-ajax="" readonly="">
                                    </div>
                                    <div class="ka_drop "   style="width:200px;">
                                        <div class="ka_drop_list"  >
                                            <ul  >

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="select_wrap select_pull_down">
                                    <div>
                                        <span class="red_star">*</span>车辆类型：
                                        <input type="text" class="model_input vehicle_type ka_input3" placeholder="请输入车辆类型"  name="vehicle_type" data-ajax="" readonly />
                                    </div>

                                    <div class="ka_drop" style="margin-left:20px;width: 300px;">
                                        <div class="ka_drop_list" style="width: 300px;">
                                            <ul>
                                                <li><a href="javascript:;" data-ajax="101">轿车</a></li>
                                                <li><a href="javascript:;" data-ajax="102">客车</a></li>
                                                <li><a href="javascript:;" data-ajax="103">货车</a></li>
                                                <li><a href="javascript:;" data-ajax="104">专用汽车</a></li>
                                                <li><a href="javascript:;" data-ajax="105">摩托车</a></li>
                                                <li><a href="javascript:;" data-ajax="106">电瓶车</a></li>
                                                <li><a href="javascript:;" data-ajax="107">自行车</a></li>
                                                <li><a href="javascript:;" data-ajax="999">其他车辆</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <p class="if_resident"> <span class="red_star">*</span>是否常驻：
                                    <span style="margin-left:70px;">
							<input type="radio" id="radio-6-1" name="radio-6-set" class="regular-radio" >
							<label for="radio-6-1"></label>
							是
						</span>

                                    <span style="margin-left:95px;">
							<input type="radio" id="radio-6-2" name="radio-6-set" class="regular-radio">
							<label for="radio-6-2"></label>
							否
						</span>
                                </p>
                                <p class="if_electro">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否是电动车：
                                    <span style="margin-left:45px;">
							<input type="radio" id="radio-7-1" name="radio-7-set" class="regular-radio" >
							<label for="radio-7-1"></label>
							是
						</span>

                                    <span style="margin-left:95px;">
							<input type="radio" id="radio-7-2" name="radio-7-set" class="regular-radio">
							<label for="radio-7-2"></label>
							否
						</span>
                                </p>

                                <p class="if_temp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否临时车牌：
                                    <span style="margin-left:45px;">
							<input type="radio" id="radio-8-1" name="radio-8-set" class="regular-radio" >
							<label for="radio-8-1"></label>
							是
						</span>

                                    <span style="margin-left:95px;">
							<input type="radio" id="radio-8-2" name="radio-8-set" class="regular-radio">
							<label for="radio-8-2"></label>
							否
						</span>
                                </p>
                                <p><span class="red_star">*</span>车牌号：
                                    <input type="text" class="model_input licence" placeholder="请输入车牌号"  name="licence" />
                                </p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;车主：
                                    <input type="text" class="model_input owner" placeholder="请输入车主"  name="owner" />
                                </p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;品牌：
                                    <input type="text" class="model_input brand" placeholder="请输入品牌"  name="brand" />
                                </p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;型号：
                                    <input type="text" class="model_input model" placeholder="请输入型号"  name="model" />
                                </p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;颜色：
                                    <input type="text" class="model_input color" placeholder="请输入颜色"  name="color" />
                                </p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;备注：
                                    <input type="text" class="model_input remark" placeholder="请输入备注"  name="remark" />
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
<script src='<?=base_url().'application/views/plugin/app/js/vehicle_list.js'?>'></script>
</body>
</html>
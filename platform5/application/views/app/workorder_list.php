<?php
	require 'top.php'
?>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-table/css/bootstrap-table.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/jstree/dist/themes/default/style.min.css'?>'/>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table-zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/moment-with-locales.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/jstree/dist/jstree.min.js'?>'></script>


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
    <div class="col-md-10 col-xm-12 pl0 pr0">
    <!-- 筛选条件 -->
    <div class="searc_bar search_wrap " id="search_wrap" >

        <span class="col_37A fl">筛选条件</span>
        <!-- 筛选条件 时间-->
        <input type="text" class="create_time date col_37A fl form-control" name="create_time"  value="">

        <!--筛选地点-->
        <a href="javascript:;" id="treeNav" class="treeWrap treeWrapSearch"><span></span></a>


        <!-- 筛选条件 创建类型-->
        <div class="Search_Item_wrap create_type_search_wrap select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input create_type ka_input3" placeholder="创建类型" name="create_type" data-ajax="" value="" readonly style="width:150px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:150px;">
                <div class="ka_drop_list" >
                    <ul >
                        <li><a href="javascript:;" data-ajax="101">自动创建巡检工单</a></li>
                        <li><a href="javascript:;" data-ajax="102">自动创建异常处理工单</a></li>
                        <li><a href="javascript:;" data-ajax="103">循环创建工单</a></li>
                        <li><a href="javascript:;" data-ajax="201">物业人员创建工单</a></li>
                        <li><a href="javascript:;" data-ajax="202">住户/商户创建工单</a></li>
                    </ul>
                </div>
            </div>
        </div>




            <!--筛选工单类型-->
        <div class="Search_Item_wrap order_type_search_wrap select_pull_down query_wrap col_37A fl">
            <div >
                <input type="text"  class="model_input order_type ka_input3" placeholder="工单类型" name="order_type" data-ajax="" value="" readonly style="width:100px;" >
            </div>
            <div class="ka_drop"  style="display: none;width:100px;">
                <div class="ka_drop_list" >
                    <ul >
                        <li><a href="javascript:;" data-ajax="101">自动工单</a></li>
                        <li><a href="javascript:;" data-ajax="201">事事问物业</a></li>
                        <li><a href="javascript:;" data-ajax="202">物业帮你办</a></li>
                        <li><a href="javascript:;" data-ajax="203">异常报备</a></li>
                        <li><a href="javascript:;" data-ajax="204">投诉或建议</a></li>

                    </ul>
                </div>
            </div>
        </div>


        <!-- 筛选条件 查找-->
        <form class="search_room" action="" method="get">
            <p>
                <input type="text" class="searc_room_text" name="keyword" placeholder="可输入工单编号、创建人、接单人" value=""><a id="clear" href="">X</a>
            </p>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

     </div>

    <!-- 物资数据-->
        <div class="table_wrap">
          <!--  <div class="oh pt10">
                <span class="fr add_btn" data-target="#add_Item" data-toggle="modal">新增物资</span>
            </div>-->
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>
                    <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                    <th data-title="工单编号" data-align="center" data-field="work_code"></th>
                    <th  data-title="创建类型" data-align="center" data-field="create_type_name"></th>
                    <th data-title="创建时间" data-align="center" data-field="create_time_name"></th>
                    <th  data-title="创建人" data-align="center" data-field="create_person_name"></th>
                    <th  data-title="对应设备" data-align="center" data-field="e_name"></th>
                    <th data-title="工单对象" data-align="center" data-field="object" ></th>
                    <th  data-title="工单类型" data-align="center" data-field="order_type_name"></th>
                    <th  data-title="发生地点" data-align="center" data-field=""></th>
                    <th  data-title="接单人" data-align="center" data-field="accept_person_name"></th>
                    <th  data-title="接单时间" data-align="center" data-field="accept_time_name"></th>
                    <th  data-title="工作状态" data-align="center" data-field="work_state_name"></th>
                    <th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
                </tr>
                </thead>

            </table>
        </div>


        <!--物资数据分页处理-->
        <ul class="pager" page='<? $page ?>'>
            <?php
            $first=base_url().'index.php/Workorder/workorderList?page=1&parent_code='.$parent_code.'&building_code='.$building_code.'&create_type='.$create_type.'&keyword='.$keyword.'&create_time='.$create_time.'&order_type='.$order_type;
            echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
            if($page>1) {
                $url=base_url().'index.php/Workorder/workorderList?page='.($page-1).'&parent_code='.$parent_code.'&building_code='.$building_code.'&create_type='.$create_type.'&keyword='.$keyword.'&create_time='.$create_time.'&order_type='.$order_type;
                echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
            }else{
                echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
            }
            echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
            if($page<$total) {
                $url=base_url().'index.php/Workorder/workorderList?page='.($page+1).'&parent_code='.$parent_code.'&building_code='.$building_code.'&create_type='.$create_type.'&keyword='.$keyword.'&create_time='.$create_time.'&order_type='.$order_type;
                echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
            }else{
                echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
            }
            $last=base_url().'index.php/Workorder/workorderList?page='.$total.'&parent_code='.$parent_code.'&building_code='.$building_code.'&create_type='.$create_type.'&keyword='.$keyword.'&create_time='.$create_time.'&order_type='.$order_type;
            echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
            echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
            echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
            ?>
        </ul>

        <!--详细信息 -->
        <div class="modal fade" id="person_detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 700px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">工单详情</h4>
                        </div>
                        <div class="modal-body building oh">
                            <div class="fl person_wrap person_detail">
                                <p><i class="icon_circle"></i>工单创建信息</p>
                                <p><span class="des">工单编号：</span>
                                    <span class="work_code col_37A"></span>
                                </p>
                                <p><span class="des">创建类型：</span>
                                    <span class="create_type_name col_37A"></span>
                                </p>
                                <p><span class="des">创建时间：</span>
                                    <span class="create_time    col_37A"></span>
                                </p>
                                <p><span class="des">创建人：</span>
                                    <span class="create_person_name col_37A"></span>
                                </p>
                                <p><span class="des">对应设备：</span>
                                    <span class="e_name col_37A"></span>
                                </p>
                                <p><span class="des">工单对象：</span>
                                    <span class="object col_37A"></span>
                                </p>
                                <p><span class="des">工单类型：</span>
                                    <span class="order_type_name col_37A"></span>
                                </p>

                                <p><span class="des">发生地点：</span>
                                    <span class="building_code col_37A"></span>
                                </p>
                            </div>
                                <div class="fr person_wrap person_detail">
                                    <p><i class="icon_circle"></i>工单处理信息</p>
                                <p><span class="des">接单人：</span>
                                    <span class="accept_person_name col_37A"></span>
                                </p>
                                <p><span class="des">接单时间：</span>
                                    <span class="accept_time col_37A"></span>
                                </p>
                                <p><span class="des">协同处理人：</span>
                                    <span class="team_person_name col_37A"></span>
                                </p>
                                <p><span class="des">到场时间：</span>
                                    <span class="onsite_time col_37A"></span>
                                </p>
                                <p><span class="des">是否误报：</span>
                                    <span class="if_false_name col_37A"></span>
                                </p>
                                <p><span class="des">处理完成时间：</span>
                                    <span class="complete_time col_37A"></span>
                                </p>
                                <p><span class="des" >处理完成图片：</span>
                                    <span class="process_pic col_37A" style="float:left;"></span>
                                </p>
                                <p><span class="des">对应管家：</span>
                                    <span class="property_person_name col_37A"></span>
                                </p>
                                <p><span class="des">管家确认时间：</span>
                                    <span class="confirm_time col_37A"></span>
                                </p>
                                <p><span class="des">业主点评时间：</span>
                                    <span class="comment_time col_37A"></span>
                                </p>
                                <p><span class="des">业主点评分数：</span>
                                    <span class="comment_score_name col_37A"></span>
                                </p>
                                <p><span class="des">业主点评意见：</span>
                                    <span class="comment col_37A"></span>
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
<input type="hidden" value='<?php echo $page;?>' name="page" />
<input type="hidden" value='<?php echo $pagesize;?>' name="pagesize" />
<input type="hidden" value='<?php echo $building_code;?>' name="building_codes" />
<input type="hidden" value='<?php echo $parent_code;?>' name="parent_codes" />
<input type="hidden" value='<?php echo $keyword;?>' name="keywords" />
<input type="hidden" value='<?php echo $create_time;?>' name="create_times" />
<input type="hidden" value='<?php echo $create_type;?>' name="create_types" />
<input type="hidden" value='<?php echo $order_type;?>' name="order_types" />

<script>
    //////////////////////////////搜索模块的树形地点///////////////////////////////////
    var treeNav_data = <?php echo $treeNav_data?>;
    //搜索框楼宇层级树形菜单
    $('#treeNav>span').jstree({
        'core' : {
            data: treeNav_data
        }
    })
    //新增框楼宇层级树形菜单展示
    $('#treeNavAdd>span,#treeNavWrite>span').jstree({
        'core': {
            data: treeNav_data
        }
    })


    function operateFormatter(value,row,index){
        return [
            '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
            '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
            '</a>',

        ].join('');
    }

</script>
<script src='<?=base_url().'application/views/plugin/app/js/workorder_list.js'?>'></script>
</body>
</html>
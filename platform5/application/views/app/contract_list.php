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
      <!--  <a href="javascript:;" id="treeNav" class="treeWrap treeWrapSearch"><span></span></a>-->



        <!-- 筛选条件 创建类型-->
        <div class="Search_Item_wrap create_type_search_wrap select_pull_down query_wrap col_37A fl"  style="margin-right:10px;">
            <div >
                <input type="text"  class="model_input create_type ka_input3" placeholder="合同类别" name="type" data-ajax="" value="" readonly style="width:150px;" >
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
        <div class="Search_Item_wrap order_type_search_wrap select_pull_down query_wrap col_37A fl">
            <div >
                <input type="text"  class="model_input order_type ka_input3" placeholder="合同级别" name="level" data-ajax="" value="" readonly style="width:150px;" >
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
                <input type="text" class="searc_room_text" name="keyword" placeholder="可输入合同编号等" value=""><a id="clear" href="">X</a>
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
            $first=base_url().'index.php/Contract/contractList?page=1&parent_code='.$parent_code.'&building_code='.$building_code.'&create_type='.$type.'&keyword='.$keyword.'&create_time='.$begin_date.'&order_type='.$level;
            echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
            if($page>1) {
                $url=base_url().'index.php/Contract/contractList?page='.($page-1).'&parent_code='.$parent_code.'&building_code='.$building_code.'&create_type='.$type.'&keyword='.$keyword.'&create_time='.$begin_date.'&order_type='.$level;
                echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
            }else{
                echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
            }
            echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
            if($page<$total) {
                $url=base_url().'index.php/Contract/contractList?page='.($page+1).'&parent_code='.$parent_code.'&building_code='.$building_code.'&create_type='.$type.'&keyword='.$keyword.'&create_time='.$begin_date.'&order_type='.$level;
                echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
            }else{
                echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
            }
            $last=base_url().'index.php/Contract/contractList?page='.$total.'&parent_code='.$parent_code.'&building_code='.$building_code.'&create_type='.$type.'&keyword='.$keyword.'&create_time='.$begin_date.'&order_type='.$level;
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
                            <h4 class="modal-title tac">合同详情</h4>
                        </div>
                        <div class="modal-body building oh">
                            <div class=" person_wrap person_detail">

                                <p><span class="des">合同编号：</span>
                                    <span class="code col_37A"></span>
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
<input type="hidden" value='<?php echo $begin_date;?>' name="create_times" />
<input type="hidden" value='<?php echo $type;?>' name="create_types" />
<input type="hidden" value='<?php echo $level;?>' name="order_types" />

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
<script src='<?=base_url().'application/views/plugin/app/js/contract_list.js'?>'></script>
</body>
</html>
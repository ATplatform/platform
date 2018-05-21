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
<input type="hidden" value='<?php echo $page;?>' name="page" />
<input type="hidden" value='<?php echo $keyword;?>' name="keywords" />
<input type="hidden" value='<?php echo $pagesize;?>' name="pagesize" />
<input type="hidden" value='<?php echo $material_type;?>' name="material_types" />
<input type="hidden" value='<?php echo $building_code;?>' name="building_codes" />
<!--<input type="hidden" value='<?php /*echo $material_type_name;*/?>' name="material_type_name" />-->
<div class="header oh">
	<div class="fl logo">
		<i></i>艾特智汇谷云平台
	</div>
	<div class="top_login_wrap fr">
		<span class="user"><i></i>180940320</span>
		|<a class="login_out" href="<?=base_url().'index.php/Login/logout'?>">退出登录</a>
	</div>
</div>	

<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->
    <div class="col-md-10 col-xm-9">
    <!-- 筛选条件 -->
    <div class="searc_bar search_wrap" id="search_wrap" >

        <span class="col_37A fl">筛选条件</span>
        <input type="text" class="begin_date date col_37A fl" name="begin_date" id="datetimeStart" >

        <!-- 筛选条件 物资类别-->
        <div class="material_type_wrap  selectMaterial select_pull_down query_wrap col_37A fl">
            <div >
                <input type="text" id="material_type_select" class="model_input material_type ka_input3" placeholder="物资类别" name="material_type" data-ajax="" value="<?php echo $material_type_name; ?>" readonly>
            </div>
            <div class="ka_drop"  style="display: none;">
                <div class="ka_drop_list">
                    <ul>
                        <li><a href="javascript:;" data-ajax="101">工程物资</a></li>
                        <li><a href="javascript:;" data-ajax="102">安防物资</a></li>
                        <li><a href="javascript:;" data-ajax="103">消防物资</a></li>
                        <li><a href="javascript:;" data-ajax="104">保洁物资</a></li>
                        <li><a href="javascript:;" data-ajax="105">办公物资</a></li>
                        <li><a href="javascript:;" data-ajax="">取消</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 筛选条件 地点-->
       <!-- <div class="select_pull_down query_wrap col_37A fl select_parent_code building_code_wrap">
            <div>
                <input type="text" class="model_input building_code_select ka_input3" placeholder="地点" name="building_code_select" data-ajax="" value="" readonly>
            </div>
            <div class="ka_drop " style="display: none;">
                <div class="ka_drop_list buildings" >
                    <ul>
                        <!--<li><a href="javascript:;" data-ajax="101">栋</a></li>
                        <li><a href="javascript:;" data-ajax="102">室</a></li>

                    </ul>
                </div>
            </div>
        </div>-->
     <a href="javascript:;" id="treeNav" class="treeWrap"><span></span></a>

     <!--   <a id="sendSelect" href="javascript:;">yes</a>-->
        <!-- 筛选条件 查找-->
        <form class="search_room" action="" method="get">
            <p>
                <input type="text" class="searc_room_text" name="keyword" placeholder="可输入物资类别或地点" value="<?php echo $keyword ?>">
                <a id="clear" href="<?=base_url().'index.php/Material/materialList'?>">X</a>
            </p>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

     </div>

    <!-- 物资数据-->
        <div class="table_wrap">
            <div class="oh pt10">
                <span class="fr add_btn" data-target="#add_material" data-toggle="modal">新增</span>
            </div>
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>
                    <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                    <th  data-title="物资类型" data-align="center" data-field="material_type_name"></th>
                    <th data-title="物资编号" data-align="center" data-field="code"></th>
                    <th data-title="物资名称" data-align="center" data-field="name" ></th>
                    <th  data-title="地点" data-align="center" data-field="room_name"></th>
                    <th  data-title="数量" data-align="center" data-field="pcs"></th>
                    <th data-title="启用时间" data-align="center" data-field="effective_date"></th>
                    <th  data-title="用途" data-align="center" data-field="function"></th>
                    <th  data-title="供应商" data-align="center" data-field="supplier"></th>
                    <th  data-title="内部编号" data-align="center" data-field="internal_no"></th>
                    <th  data-title="出厂编号" data-align="center" data-field="initial_no"></th>
                    <th  data-title="备注" data-align="center" data-field="remark"></th>
                </tr>
                </thead>

            </table>
        </div>


        <!--物资数据分页处理-->
        <ul class="pager" page='<? $page ?>'>
            <?php
            $first=base_url().'index.php/Material/materialList?page=1&keyword='.$keyword;
            echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
            if($page>1) {
                $url=base_url().'index.php/Material/materialList?page='.($page-1).'&keyword='.$keyword;
                echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
            }else{
                echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
            }
            echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
            if($page<$total) {
                $url=base_url().'index.php/Material/materialList?page='.($page+1).'&keyword='.$keyword;
                echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
            }else{
                echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
            }
            $last=base_url().'index.php/Material/materialList?page='.$total.'&keyword='.$keyword;
            echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
            echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
            echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
            ?>
        </ul>

        <!-- 增加物资 -->
        <div class="modal fade" id="add_material" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 630px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">新增物资信息</h4>
                        </div>
                        <div class="modal-body building add_material">
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;物资编号：<span class="code" style="margin-left:26px;"></span>
                            </p>
                            <p><span class="red_star">*</span>生效日期：
                                <input type="text" class="effective_date date" name="effective_date" />
                            </p>
                            <p class="effective_status"><span class="red_star">*</span>状态：
                                <span style="margin-left:45px;">
							<input type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked="">
							<label for="radio-1-1"></label>
							有效
						</span>

                                <span class="fr">
							<input type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio">
							<label for="radio-1-2"></label>
							无效
						</span>
                            </p>
                            <p><span class="red_star">*</span>物资名称：
                                <input type="text" class="model_input name" placeholder="请输入物资名称"  name="name" />
                            </p>
                            <p><span class="red_star">*</span>数量：<input type="text" class="model_input pcs" placeholder="请输入数量" name="pcs" /></p>
                            <div class="select_wrap select_pull_down">
                                <div>
                                    <span class="red_star">*</span>物资类型：
                                    <input type="text" class="model_input material_type ka_input3" placeholder="请输入物资类型"  name="material_type" data-ajax="" readonly />
                                </div>
                                <div class="ka_drop">
                                    <div class="ka_drop_list">
                                        <ul>
                                            <li><a href="javascript:;" data-ajax="101">工程物资</a></li>
                                            <li><a href="javascript:;" data-ajax="102">安防物资</a></li>
                                            <li><a href="javascript:;" data-ajax="103">消防物资</a></li>
                                            <li><a href="javascript:;" data-ajax="104">保洁物资</a></li>
                                            <li><a href="javascript:;" data-ajax="105">办公物资</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                      <!--      <div class="select_wrap select_pull_down">
                                <div>
                                    <span class="red_star">*</span>楼宇层级：
                                    <input type="text" class="model_input level ka_input3" placeholder="请输入楼宇层级"  name="level" data-ajax="" readonly />
                                </div>
                                <div class="ka_drop">
                                    <div class="ka_drop_list">
                                        <ul>
                                            <li><a href="javascript:;" data-ajax="100">小区</a></li>
                                            <li><a href="javascript:;" data-ajax="101">期</a></li>
                                            <li><a href="javascript:;" data-ajax="102">区</a></li>
                                            <li><a href="javascript:;" data-ajax="103">栋</a></li>
                                            <li><a href="javascript:;" data-ajax="104">单元</a></li>
                                            <li><a href="javascript:;" data-ajax="105">层</a></li>
                                            <li><a href="javascript:;" data-ajax="106">室</a></li>
                                            <li><a href="javascript:;" data-ajax="107">公共设施</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>-->

                            <p class="select_buliding_wrap">
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;地点：</span>
                                <a href="javascript:;" id="treeNavWrite" class="treeWrap"><span></span></a>
                                <span class="select_buliding">

						</span>
                            </p>

                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;供应商：
                                <input type="text" class="model_input supplier" placeholder="请输入供应商"  name="supplier" />
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;内部编号：
                                <input type="text" class="model_input internal_no" placeholder="请输入内部编号"  name="internal_no" />
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;出厂编号：
                                <input type="text" class="model_input initial_no" placeholder="请输入出厂编号"  name="initial_no" />
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;备注：<input type="text" class="model_input remark" placeholder="请输入备注内容" name="remark" /></p>
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

    </div>

    </div>
</div>

<script>
    var treeNav_data = <?php echo $treeNav_data?>;
    console.log(treeNav_data);
    //楼宇层级树形菜单
    $('#treeNav>span').jstree({
        'core' : {
            data: treeNav_data
        }
    })
    //树节点点击后跳转到相应的楼宇列表页面
    $('#treeNav>span').on("select_node.jstree", function (e, node) {
        var arr=node.node.id.split("_");
        var parent_code=arr[0];
        var id=arr[1];
        console.log(node.node);
        window.location.href="buildinglist?id="+id+"&parent_code="+parent_code+"&page=1";
    })


    var treeNav_data = <?php echo $treeNav_data?>;
    console.log(treeNav_data);
    //编辑物业关系和新增物业关系楼宇层级树形菜单
    $('#treeNavAdd>span,#treeNavWrite>span').jstree({
        'core' : {
            data: treeNav_data
        }
    })
    //树节点点击后将节点赋值
    $('#treeNavAdd>span,#treeNavWrite>span').on("select_node.jstree", function (e, node) {
        var arr=node.node.id.split("_");
        var parent_code=arr[0];
        //当前节点的id
        var id=arr[1];
        //当前节点的文本值
        var name = node.node.text;
        //当前节点的房号code
        var room_code = node.node.original.code;
        console.log(room_code);
        console.log(node.node);
        // console.log($(this));
        //当前对象为包裹层元素(这里是span)
        var that = $(this);

        //父节点数组
        var parents_arr = node.node.parents;
        if(parents_arr.length==3){
            //表示到了室这一层级,需要获取到父节点,把父节点的名称拼接
            var imm_id = parents_arr[0];
            var imm_node = that.jstree("get_node", imm_id);
            var imm_name = imm_node.text;
            console.log(imm_node);
        }
        //表示是栋这一层级
        else if(parents_arr.length==2){

        }

        imm_name = imm_name?imm_name:'';
        var html_tmp = "<em id="+id+" data-room_code="+room_code+">"+imm_name+name+"<i class='fa fa-close'></i></em>";
        console.log(html_tmp);
        if(that.closest('.model_content').find('.select_buliding #'+id).length==0){
            that.closest('.model_content').find('.select_buliding').append(html_tmp);
        }

    })

    $(function(){
        //点击删除当前节点
        $('.select_buliding_wrap').on('click','.select_buliding em i',function(){
            $(this).closest('em').remove();
        })
    })
</script>





<script src='<?=base_url().'application/views/plugin/app/js/material_list.js'?>'></script>
</body>
</html>
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
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.zh-CN.js'?>'></script>

<div class="header oh">
	<div class="fl logo">
		<i></i>艾特智汇谷云平台
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
    <div class="searc_bar search_wrap materialsearch_wrap" id="search_wrap" >

        <span class="col_37A fl">筛选条件</span>
       <input type="text" class="effective_date date col_37A fl form-control" name="effective_date"  value="<?php echo $now=date('Y-m-d H:i:s',time()); ?>">

        <!-- 筛选条件 物资类别-->
        <div class="Search_Item_wrap  selectMaterial select_pull_down query_wrap col_37A fl">
            <div >
                <input type="text" id="material_type_select" class="model_input material_type ka_input3" placeholder="物资类型" name="material_type" data-ajax="" value="<?php echo $material_type_name; ?>" readonly>
            </div>
            <div class="ka_drop"  style="display: none;">
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

            <a href="javascript:;" id="treeNav" class="treeWrap treeWrapSearch"><span></span></a>


     <!--   <a id="sendSelect" href="javascript:;">yes</a>-->
        <!-- 筛选条件 查找-->
        <form class="search_room" action="" method="get">
            <p>
                <input type="text" class="searc_room_text" name="keyword" placeholder="可输入物资编号、物资名称等" value="<?php echo $keyword ?>">

                <input type="hidden" value='<?php echo $material_type;?>' name="material_type" />
                <input type="hidden" value='<?php echo $building_code;?>' name="building_code" />
                <input type="hidden" value='<?php echo $parent_code;?>' name="parent_code" />
                <a id="clear" href="<?=base_url().'index.php/Material/materialUsage'?>">X</a>
            </p>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

     </div>

    <!-- 物资数据-->
        <div class="table_wrap">
            <div class="oh pt10">
                <span class="fr add_btn" data-target="#add_Item" data-toggle="modal">新增物资状态</span>
            </div>
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>
                    <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                    <th  data-title="物资类型" data-align="center" data-field="material_type_name"></th>
                    <th data-title="物资编号" data-align="center" data-field="material_code"></th>
                    <th data-title="物资名称" data-align="center" data-field="name" ></th>
                    <th  data-title="地点" data-align="center" data-field="room_name"></th>
                    <th  data-title="数量" data-align="center" data-field="pcs"></th>
                    <th  data-title="生效日期" data-align="center" data-field="effective_date_name"></th>
                    <th  data-title="物资使用人" data-align="center" data-field="person_name"></th>
                    <th  data-title="当前状态" data-align="center" data-field="mgt_status_name"></th>
                    <th  data-title="备注" data-align="center" data-field="remark"></th>
                    <th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
                </tr>
                </thead>

            </table>
        </div>


        <!--物资数据分页处理-->
        <ul class="pager" page='<? $page ?>'>
            <?php
            $first=base_url().'index.php/Material/materialUsage?page=1&parent_code='.$parent_code.'&building_code='.$building_code.'&material_type='.$material_type.'&keyword='.$keyword.'&effective_date='.$effective_date;
            echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
            if($page>1) {
                $url=base_url().'index.php/Material/materialUsage?page='.($page-1).'&parent_code='.$parent_code.'&building_code='.$building_code.'&material_type='.$material_type.'&keyword='.$keyword.'&effective_date='.$effective_date;
                echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
            }else{
                echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
            }
            echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
            if($page<$total) {
                $url=base_url().'index.php/Material/materialUsage?page='.($page+1).'&parent_code='.$parent_code.'&building_code='.$building_code.'&material_type='.$material_type.'&keyword='.$keyword.'&effective_date='.$effective_date;
                echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
            }else{
                echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
            }
            $last=base_url().'index.php/Material/materialUsage?page='.$total.'&parent_code='.$parent_code.'&building_code='.$building_code.'&material_type='.$material_type.'&keyword='.$keyword.'&effective_date='.$effective_date;
            echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
            echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
            echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
            ?>
        </ul>

        <!-- 增加物资 -->
        <div class="modal fade" id="add_Item" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 630px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">新增物资状态</h4>
                        </div>
                        <div class="modal-body building add_Item">

                            <div class="select_pull_down select_wrap select_room">
                            <div>
                                <span class="red_star">*</span>物资编号：
                                <input type="text" class="model_input material_code ka_input3" placeholder="请输入物资编号" name="material_code" data-ajax="" readonly="">
                            </div>
                            <div class="ka_drop "   style="width:300px;">
                                <div class="ka_drop_list"  >
                                    <ul  >

                                    </ul>
                                </div>
                            </div>
                        </div>

                            <p><span class="red_star">*</span>生效日期：
                                <input type="text" class="effective_date date" name="effective_date" value=""/>
                            </p>

                            <p class="mgt_status"><span class="red_star">*</span>状态：
                                <span style="margin-left:45px;">
							<input type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked="" value="101">
							<label for="radio-1-1"></label>
							在库保管
						</span>

                                <span style="margin-left:10px;">
							<input type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio" value="102">
							<label for="radio-1-2"></label>
							使用中
						</span>
                                <span style="margin-left:10px;">
							<input type="radio" id="radio-1-3" name="radio-1-set" class="regular-radio" value="103">
							<label for="radio-1-3"></label>
							外借/外调
						</span>
                                <span style="margin-left:10px;">
							<input type="radio" id="radio-1-4" name="radio-1-set" class="regular-radio" value="104">
							<label for="radio-1-4"></label>
							已报废
						</span>
                                <span style="margin-left:10px;">
							<input type="radio" id="radio-1-5" name="radio-1-set" class="regular-radio" value="105">
							<label for="radio-1-5"></label>
							已消耗
						</span>


                            </p>
                            <!--<p><span class="red_star">*</span>物资名称：
                                <input type="text" class="model_input name" placeholder="请输入物资名称"  name="name" />
                            </p>-->
                            <div class="search_person_wrap">
                                <div class="oh" style="margin-bottom:10px;">
                                    <div class="fl">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;物资使用人：
                                    </div>
                                    <div class="fl search_person_text" >
                                        <input  style="width:344px;height:35px;font-size:14px;" type="text" class="fl search_person_name" placeholder="请输入姓名查找" >
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
                         <!--   <p><span class="red_star">*</span>物资使用人：<input type="text" class="model_input person_code" placeholder="请输入物资使用人" name="person_code" /></p>-->

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



        <div class="modal fade" id="person_detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 630px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">物资状态信息</h4>
                        </div>
                        <div class="modal-body building oh">
                            <div class="fl person_wrap person_detail">

                                <!-- <p><span class="des">序号：</span>
                                     <span class="full_name col_37A"></span>
                                 </p>-->
                                <p><span class="des">物资编号：</span>
                                    <span class="material_code col_37A"></span>
                                </p>
                                <p><span class="des">生效日期：</span>
                                    <span class="effective_date_name id_number col_37A"></span>
                                </p>
                                <p><span class="des">物资名称：</span>
                                    <span class="name col_37A"></span>
                                </p>
                                <p><span class="des">数量：</span>
                                    <span class="pcs col_37A"></span>
                                </p>
                                <p><span class="des">物资类型：</span>
                                    <span class="material_type_name col_37A"></span>
                                </p>
                                <p><span class="des">地点：</span>
                                    <span class="room_name col_37A"></span>
                                </p>
                                <p><span class="des">物资使用人</span>
                                    <span class="person_name col_37A"></span>
                                </p>
                                <p><span class="des">当前状态：</span>
                                    <span class="mgt_status_name col_37A"></span>
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
<input type="hidden" value='<?php echo $keyword;?>' name="keywords" />
<input type="hidden" value='<?php echo $material_type;?>' name="material_types" />
<input type="hidden" value='<?php echo $building_code;?>' name="building_codes" />
<input type="hidden" value='<?php echo $parent_code;?>' name="parent_codes" />
<input type="hidden" value='<?php echo $effective_date;?>' name="effective_dates" />
<script>
    var page = $('input[name="page"]').val();
    var keyword = $('input[name="keywords"]').val()
    var material_type = $('input[name="material_types"]').val();
    var building_code = $('input[name="building_codes"]').val();
    var parent_code = $('input[name="parent_codes"]').val();
    var effective_date = $('input[name="effective_dates"]').val();
    $('.date').datetimepicker({
        language:  'zh-CN',
        format: 'yyyy-mm-dd',
        weekStart: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 1
    });

    $('.search_wrap .effective_date').datetimepicker().on('changeDate',function(e){
        var effective_date=$('input[name="effective_date"]').val();
        console.log(effective_date)

        window.location.href="materialUsage?keyword="+keyword+"&page=1"+'&material_type='+material_type+"&building_code="+building_code+"&parent_code="+parent_code+"&effective_date="+effective_date;

    })
</script>
<script>
    //////////////////////////////搜索模块的树形地点///////////////////////////////////
        var treeNav_data =<?php echo $treeNav_data?>;
       // console.log(treeNav_data);
        //楼宇层级树形菜单
        $('#treeNav>span').jstree({
            'core' : {
                data: treeNav_data
            }
        })
        //树节点点击后跳转到相应的楼宇列表页面
        $('#treeNav>span').on("select_node.jstree", function (e, node) {
           // var arr=node.node.id.split("_");
            var building_code=node.node.original.code;
            var parent_code=node.node.original.code;
            var page = $('input[name="page"]').val();
            var keyword = $('input[name="keywords"]').val()
            var material_type = $('input[name="material_types"]').val();

            console.log(111);
            console.log(node);
            console.log(building_code);
            console.log(parent_code);
           window.location.href="materialUsage?building_code="+building_code+"&parent_code="+parent_code+"&page="+page+'&material_type='+material_type+'&keyword='+keyword;
        })





//////////////////////////////新增模块的树形地点///////////////////////////////////
        var treeNav_data = <?php echo $treeNav_data?>;
        //编辑物业关系和新增物业关系楼宇层级树形菜单
        $('#treeNavAdd>span,#treeNavWrite>span').jstree({
            'core': {
                data: treeNav_data
            }
        })

        //树节点点击后将节点赋值
        $('#treeNavAdd>span,#treeNavWrite>span').on("select_node.jstree", function (e, node) {
            $('#treeNavWrite>span').jstree("close_all")

            var arr = node.node.id.split("_");
            var parent_code = arr[0];
            //当前节点的id
            var id = arr[1];
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
            if (parents_arr.length == 3) {
                //表示到了室这一层级,需要获取到父节点,把父节点的名称拼接
                var imm_id = parents_arr[0];
                var imm_node = that.jstree("get_node", imm_id);
                var imm_name = imm_node.text;
                console.log(imm_node);
            }
            //表示是栋这一层级
            else if (parents_arr.length == 2) {

            }

            imm_name = imm_name ? imm_name : '';
            var html_tmp = "<em id=" + id + " data-room_code=" + room_code + ">" + imm_name + name + "<i class='fa fa-close'></i></em>";
            console.log(html_tmp);
            if (that.closest('.model_content').find('.select_buliding #' + id).length == 0) {
                that.closest('.model_content').find('.select_buliding').append(html_tmp);
            }

        })

        $(function () {
            //点击删除当前节点
            $('.select_buliding_wrap').on('click', '.select_buliding em i', function () {
                $(this).closest('em').remove();
            })
        })
</script>
<script>
    //信息管理操作
    function operateFormatter(value,row,index){
        return [
            '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
            '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
            '</a>',

        ].join('');
    }

    /* <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
         <th  data-title="物资类型" data-align="center" data-field="material_type_name"></th>
         <th data-title="物资编号" data-align="center" data-field="code"></th>
         <th data-title="物资名称" data-align="center" data-field="name" ></th>
         <th  data-title="地点" data-align="center" data-field="room_name"></th>
         <th  data-title="数量" data-align="center" data-field="pcs"></th>
         <th data-title="启用时间" data-align="center" data-field="effective_date_name"></th>
         <th  data-title="用途" data-align="center" data-field="function"></th>
         <th  data-title="供应商" data-align="center" data-field="supplier"></th>
         <th  data-title="内部编号" data-align="center" data-field="internal_no"></th>
         <th  data-title="出厂编号" data-align="center" data-field="initial_no"></th>
         <th  data-title="备注" data-align="center" data-field="remark"></th>
         <th  data-title="详情" data-align="center" data-formatter="operateFormatter"*/


/*
    <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
        <th  data-title="物资类型" data-align="center" data-field="material_type_name"></th>
        <th data-title="物资编号" data-align="center" data-field="material_code"></th>
        <th data-title="物资名称" data-align="center" data-field="name" ></th>
        <th  data-title="地点" data-align="center" data-field="room_name"></th>
        <th  data-title="数量" data-align="center" data-field="pcs"></th>
        <th  data-title="生效日期" data-align="center" data-field="effective_date_name"></th>
        <th  data-title="物资使用人" data-align="center" data-field="person_name"></th>
        <th  data-title="当前状态" data-align="center" data-field="mgt_status_name"></th>
        <th  data-title="备注" data-align="center" data-field="remark"></th>*/

    window.operateEvents = {
        //点击详情时,弹出住户详情框
        'click .detail': function (e, value, row, index) {
            $('#person_detail').modal('show');
            var material_type_name = row.material_type_name;
            var material_code = row.material_code;
            var name = row.name;
            var room_name = row.room_name;
            var pcs = row.pcs;
            var effective_date_name = row.effective_date_name;
            var person_name = row.person_name;
            var mgt_status_name = row.mgt_status_name;
            var remark = row.remark;



            $('#person_detail').find('.material_type_name').html(material_type_name);
            $('#person_detail').find('.material_code').html(material_code);
            $('#person_detail').find('.material_code').html(material_code);
            $('#person_detail').find('.name').html(name);
            $('#person_detail').find('.room_name').html(room_name);
            $('#person_detail').find('.pcs').html(pcs);
            $('#person_detail').find('.effective_date_name').html(effective_date_name);
            $('#person_detail').find('.person_name').html(person_name);
            $('#person_detail').find('.mgt_status_name').html(mgt_status_name);
            $('#person_detail').find('.remark').html(remark);

        }
    }

</script>

<script src='<?=base_url().'application/views/plugin/app/js/material_usage.js'?>'></script>
</body>
</html>
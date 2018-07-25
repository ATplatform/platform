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



<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->
    <div class="col-sm-12 main_wrap">
    <!-- 筛选条件 -->
    <div class="searc_bar search_wrap materialsearch_wrap" id="search_wrap" >

        <span class="col_37A fl">筛选条件</span>
        <input type="text" class="effective_date date col_37A fl form-control" name="effective_date"  value="<?php echo $now=date('Y-m-d H:i:s',time()); ?>" >

        <a href="javascript:;" id="treeNav" class="treeWrap treeWrapSearch" style=""><span></span></a>


        <!-- 筛选条件 物资类别-->
        <div class="Search_Item_wrap  selectMaterial select_pull_down query_wrap col_37A fl">
            <div >
                <input type="button" id="material_type_select" class="model_input material_type ka_input3" placeholder="物资类型" name="material_type" data-ajax="" value="<?php echo $material_type_name; ?>" readonly>
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


     <!--   <a id="sendSelect" href="javascript:;">yes</a>-->
        <!-- 筛选条件 查找-->
        <form class="search_room" action="" method="get">
            <p>
                <input type="text" class="searc_room_text" name="keyword" placeholder="可输入物资编号、物资名称、用..." value="<?php echo $keyword ?>" title="可输入物资编号、物资名称、用途
供应商、备注">

                <input type="hidden" value='<?php echo $material_type;?>' name="material_type" />
                <input type="hidden" value='<?php echo $building_code;?>' name="building_code" />
                <input type="hidden" value='<?php echo $parent_code;?>' name="parent_code" />
                <a id="clear" onclick="return false">X</a>
            </p>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

     </div>

    <!-- 物资数据-->
        <div class="table_wrap">
            <div class="oh pt10">

                <span class="fr add_btn" data-target="#add_Item" data-toggle="modal">新增物资</span>
                <a class="fr add_btn" href="<?=base_url().'index.php/Material/materialList'?>">清除筛选</a>
            </div>
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>
                    <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                    <th  data-title="物资类型" data-align="center" data-field="material_type_name"></th>
                    <th data-title="物资编号" data-align="center" data-field="m_code"></th>
                    <th data-title="物资名称" data-align="center" data-field="m_name" ></th>
                    <th  data-title="地点" data-align="center" data-field="building_name"></th>
                    <th  data-title="数量" data-align="center" data-field="pcs"></th>
                    <th  data-title="状态" data-align="center" data-field="effective_status_name"></th>
                    <th data-title="生效日期" data-align="center" data-field="effective_date_name"></th>
                    <th  data-title="用途" data-align="center" data-field="function"></th>
                    <th  data-title="供应商" data-align="center" data-field="supplier"></th>
                    <th  data-title="内部编号" data-align="center" data-field="internal_no"></th>
                    <th  data-title="出厂编号" data-align="center" data-field="initial_no"></th>
                    <th  data-title="备注" data-align="center" data-field="remark"></th>
                    <th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
                </tr>
                </thead>

            </table>
        </div>


        <!--物资数据分页处理-->
        <ul class="pager" page='<? $page ?>'>
            <?php
            $first=base_url().'index.php/Material/materialList?page=1&parent_code='.$parent_code.'&building_code='.$building_code.'&material_type='.$material_type.'&keyword='.$keyword.'&effective_date='.$effective_date;
            echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
            if($page>1) {
                $url=base_url().'index.php/Material/materialList?page='.($page-1).'&parent_code='.$parent_code.'&building_code='.$building_code.'&material_type='.$material_type.'&keyword='.$keyword.'&effective_date='.$effective_date;
                echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
            }else{
                echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
            }
            echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
            if($page<$total) {
                $url=base_url().'index.php/Material/materialList?page='.($page+1).'&parent_code='.$parent_code.'&building_code='.$building_code.'&material_type='.$material_type.'&keyword='.$keyword.'&effective_date='.$effective_date;
                echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
            }else{
                echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
            }
            $last=base_url().'index.php/Material/materialList?page='.$total.'&parent_code='.$parent_code.'&building_code='.$building_code.'&material_type='.$material_type.'&keyword='.$keyword.'&effective_date='.$effective_date;
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
                            <h4 class="modal-title tac">新增物资信息</h4>
                        </div>
                        <div class="modal-body building add_Item">
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;物资编号：<span class="code" style="margin-left:26px;"></span>
                            </p>
                            <p><span class="red_star">*</span>生效日期：
                                <input type="text" class="effective_date date form-control" name="effective_date" value=""/ >
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
                                <span class="red_star">*</span><span>地点：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <a href="javascript:;" id="treeNavWrite" class="treeWrap"><span></span></a>
                                <span class="select_buliding"></span>
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用途：
                                <input type="text" class="model_input function" placeholder="请输入用途"  name="function" />
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









        <div class="modal fade" id="person_detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog"  style="width: 630px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">物资详情</h4>
                        </div>
                        <div class="modal-body building oh">
                                <p style="line-height: 30px;"><span class="des">物资编号：</span>
                                    <span class="code col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">物资状态：</span>
                                    <span class="effective_status_name col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">生效日期：</span>
                                    <span class="effective_date_name id_number col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">物资名称：</span>
                                    <span class="name col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">数量：</span>
                                    <span class="pcs col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">物资类型：</span>
                                    <span class="material_type_name col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">地点：</span>
                                    <span class="room_name col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">用途：</span>
                                    <span class="materialfunction col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">供应商：</span>
                                    <span class="supplier col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">内部编号：</span>
                                    <span class="internal_no col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">出厂编号：</span>
                                    <span class="initial_no col_37A"></span>
                                </p>
                                <p style="line-height: 30px;"><span class="des">备注：</span>
                                    <span class="remark col_37A"></span>
                                </p>
                                <p style="line-height: 30px;" class="oh">
                                    <span class="des fl">二&nbsp;&nbsp;维&nbsp;&nbsp;码：</span>
                                    <span class="qr_code fl">
                                            <img src="" />
                                    </span>
                                </p>
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
            var effective_date=$('input[name="effective_dates"]').val();

            console.log(111);
            console.log(node);
            console.log(building_code);
            console.log(parent_code);
           window.location.href="materialList?building_code="+building_code+"&parent_code="+parent_code+"&page="+page+'&material_type='+material_type+'&keyword='+keyword+'&effective_date='+effective_date;
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
         /*   if (that.closest('.model_content').find('.select_buliding #' + id).length == 0) {
                that.closest('.model_content').find('.select_buliding').append(html_tmp);
            }
*/
            if($('.model_content').find('.select_buliding em i').length==0){
                $('.model_content').find('.select_buliding').append(html_tmp);
            }

       /*     if($(".person_building_data ul #"+code).length==0){
                $('.person_building_data ul').append(html);
            }*/


        })

        $(function () {
            //点击删除当前节点
            $('.select_buliding_wrap').on('click', '.select_buliding em i', function () {
                $(this).closest('em').remove();
            })
        })
</script>
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
            window.location.href="materialList?keyword="+keyword+"&page=1"+'&material_type='+material_type+"&building_code="+building_code+"&parent_code="+parent_code+"&effective_date="+effective_date;

    })
</script>
<script>
    //信息管理操作
    function operateFormatter(value,row,index){
        return [
            '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="信息管理">',
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


    window.operateEvents = {
        //点击详情时,弹出住户详情框
        'click .detail': function (e, value, row, index) {
            $('#person_detail').modal('show');
            var code = row.code;
            var material_type_name = row.material_type_name;
            var name = row.m_name;
            var effective_date_name = row.effective_date_name;
            var room_name = row.building_name;
            var pcs = row.pcs;
            var materialfunction = row.function;
            var supplier = row.supplier;
            var internal_no = row.internal_no;
            var initial_no = row.initial_no;
            var remark = row.remark;
            var effective_status_name= row.effective_status_name;
            var qr_code=row.qr_code;


            $('#person_detail').find('.code').html(code);
            $('#person_detail').find('.effective_status_name').html(effective_status_name);
            $('#person_detail').find('.material_type_name').html(material_type_name);
            $('#person_detail').find('.name').html(name);
            $('#person_detail').find('.effective_date_name').html(effective_date_name);
            $('#person_detail').find('.room_name').html(room_name);
            $('#person_detail').find('.pcs').html(pcs);
            $('#person_detail').find('.materialfunction').html(materialfunction);
            $('#person_detail').find('.remark').html(remark);
            $('#person_detail').find('.supplier').html(supplier);
            $('#person_detail').find('.initial_no').html(initial_no);
            $('#person_detail').find('.internal_no').html(internal_no);
            $('#person_detail').find('.pcs').html(pcs);
            if(qr_code){
                var qr_code = JSON.parse(qr_code);
                var img_url = qr_code.img_url;
                img_url = getRootPath() +"/"+ img_url;
                $('#person_detail').find('.qr_code').find('img').attr('src',img_url);
            }
        }
    }

</script>

<script src='<?=base_url().'application/views/plugin/app/js/material_list.js'?>'></script>
</body>
</html>
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
<script src="http://vuejs.org/js/vue.js"></script>


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
                <input type="text" id="material_type_select" class="model_input material_type ka_input3" placeholder="物资类型" name="material_type" data-ajax="" value="<?php echo $material_type_name; ?>" readonly>
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
                    <th  data-title="地址" data-align="center" data-field="building_name"></th>
                    <th  data-title="数量" data-align="center" data-field="pcs"></th>
                    <th  data-title="状态" data-align="center" data-field="effective_status_name"></th>
                    <th data-title="生效日期" data-align="center" data-field="effective_date_name"></th>
                    <th  data-title="用途" data-align="center" data-field="materialfunction"></th>
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

           <additem
                    title="新增物资信息"
                    :inserts=inserts
                    v-on:confirminsert="confirminsert"
           > </additem>
                            <!--<div v-for="insert in inserts">
                                <p v-if="insert.method=='time'"><span v-if="insert.must" class="red_star">*</span>
                                    <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    {{insert.text}}：
                                    <input  v-model="insert.value" type="text" class=" date form-control"   value=""/>
                                </p>

                                <p  v-if="insert.method=='building'" class="select_buliding_wrap" >
                                    <span v-if="insert.must" class="red_star">*</span>
                                    <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <span>{{insert.text}}：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <a v-on:click="onClick_building_code" href="javascript:;" id="treeNavWrite" class="treeWrap"><span v-on:click="onClick_building_code"></span></a>
                                    <span class="select_buliding"></span>
                                </p>


                            <p  v-if="insert.method=='radio'" >
                                <span v-if="insert.must" class="red_star">*</span>
                                <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                {{insert.text}}：
                                <span style="margin-left:45px;">
							<input v-model="insert.value" type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked="" value="true">
							<label for="radio-1-1"></label>
							有效
						</span>

                                <span class="fr">
							<input v-model="insert.value"  type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio" value="false">
							<label for="radio-1-2"></label>
							无效
						</span>
                            </p>
                            </p>

                                <p v-if="insert.method=='input'" >
                                    <span v-if="insert.must" class="red_star">*</span>
                                    <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    {{insert.text}}：
                                    <input v-model="insert.value" type="text" class="model_input " :placeholder=textplaceholder(insert.text) />
                                </p>



                                <div v-if="insert.method=='select'" class="select_wrap select_pull_down" >
                                    <div>
                                        <span v-if="insert.must" class="red_star">*</span>
                                        <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        {{insert.text}}：
                                        <input v-bind:data-ajax="insert.value" type="text" class="model_input  ka_input3" :placeholder=textplaceholder(insert.text)   readonly />
                                    </div>
                                    <div class="ka_drop">
                                        <div class="ka_drop_list">
                                            <ul>
                                                <li v-for="(item,index) in material_types"><a href="javascript:;"  v-bind:data-ajax="item.ajax" v-on:click="onClick_material_type(item)">{{item.text}}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>-->
                            <!--                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;物资编号：<span class="code" style="margin-left:26px;"></span>
                                                        </p>
                                                        <p  ><span class="red_star">*</span>{{effective_date.text}}：
                                                            <input  v-model="effective_date.value" type="text" class=" date form-control"   value=""/>
                                                        </p>
                                                       <p><span class="red_star">*</span>{{effective_status.text}}：
                                                            <span style="margin-left:45px;">
                                                        <input v-model="effective_status.value" type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked="" value="true">
                                                        <label for="radio-1-1"></label>
                                                        有效
                                                    </span>

                                                            <span class="fr">
                                                        <input v-model="effective_status.value"  type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio" value="false">
                                                        <label for="radio-1-2"></label>
                                                        无效
                                                    </span>
                                                        </p>
                                                        <p><span class="red_star">*</span>{{name.text}}：
                                                            <input v-model="name.value"  type="text" class="model_input name" :placeholder=textplaceholder(name.text)  name="name" />
                                                        </p>
                                                        <p><span class="red_star">*</span>{{pcs.text}}：<input v-model="pcs.value"  type="text" class="model_input pcs" :placeholder=textplaceholder(pcs.text)  /></p>
                                                        <div class="select_wrap select_pull_down">
                                                            <div>
                                                                <span class="red_star">*</span>{{material_type.text}}：
                                                                <input v-bind:data-ajax="material_type.value" type="text" class="model_input  ka_input3" :placeholder=textplaceholder(material_type.text)   readonly />
                                                            </div>
                                                            <div class="ka_drop">
                                                                <div class="ka_drop_list">
                                                                    <ul>
                                                                        <li v-for="(item,index) in material_types"><a href="javascript:;"  v-bind:data-ajax="item.ajax" v-on:click="onClick_material_type(item)">{{item.text}}</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <p class="select_buliding_wrap">
                                                            <span class="red_star">*</span><span>{{building_code.text}}：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                            <a v-on:click="onClick_building_code" href="javascript:;" id="treeNavWrite" class="treeWrap"><span v-on:click="onClick_building_code"></span></a>
                                                            <span class="select_buliding"></span>
                                                        </p>
                                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{materialfunction.text}}：
                                                            <input v-model="materialfunction.value"   type="text" class="model_input " :placeholder=textplaceholder(materialfunction.text)  />
                                                        </p>
                                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{supplier.text}}：
                                                            <input v-model="supplier.value" type="text" class="model_input " :placeholder=textplaceholder(supplier.text)  />
                                                        </p>
                                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{internal_no.text}}：
                                                            <input v-model="internal_no.value" type="text" class="model_input " :placeholder=textplaceholder(internal_no.text)   />
                                                        </p>
                                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{initial_no.text}}：
                                                            <input v-model="initial_no.value" type="text" class="model_input " :placeholder=textplaceholder(initial_no.text) />
                                                        </p>
                                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{remark.text}}：<input v-model="remark.value" type="text" class="model_input " :placeholder=textplaceholder(remark.text) /></p>-->



        <div class="modal fade" id="person_detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width: 630px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">物资详情</h4>
                        </div>
                        <div class="modal-body building oh">
                            <div class="fl person_wrap person_detail">

                                <!-- <p><span class="des">序号：</span>
                                     <span class="full_name col_37A"></span>
                                 </p>-->
                                <detailitem
                                :inserts=inserts

                                ></detailitem>
                                <img src="" alt="#" class="qr_code">
                            </div>


                        </div>
                    </div>
                    <div class="modal_footer bg_eee">
                        <p class="tac pb17">
                            <span class="col_37A cancle" data-dismiss="modal">关闭</span>
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
    Vue.component('additem', {
        template: `
        <div class="modal fade" id="add_Item" tabindex="-1" role="dialog" aria-hidden="true">
             <div class="modal-dialog"  style="width: 630px;">
              <div class="modal-content model_wrap">
                    <div class="model_content">
                        <div class="building_header">
                            <h4 class="modal-title tac">{{title}}</h4>
                        </div>

                        <div class="modal-body building add_Item" >
 <div v-for="(insert,key) in inserts" >


   <p v-if="insert.method=='show'">
    <span v-if="insert.must" class="red_star">*</span>
    <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                {{insert.text}}：
   <span :class="key" style="margin-left:26px;">1111111 {{insert.value}}</span>
   </p>


         <p v-if="insert.method=='time'">
         <span v-if="insert.must" class="red_star">*</span>
         <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                {{insert.text}}：
         <input  v-model="insert.value" type="text" class=" date form-control"   value=""/>
         </p>

        <p  v-if="insert.method=='building'" class="select_buliding_wrap" >
              <span v-if="insert.must" class="red_star">*</span>
              <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              <span>{{insert.text}}：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              <a v-on:click="onClick_building_code" href="javascript:;" id="treeNavWrite" class="treeWrap"><span v-on:click="onClick_building_code"></span></a>
              <span class="select_buliding"></span>
        </p>


        <p  v-if="insert.method=='radio'" >
             <span v-if="insert.must" class="red_star">*</span>
             <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
             {{insert.text}}：
             <span style="margin-left:45px;">
						<input v-model="insert.value" type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked="" value="true">
						<label for="radio-1-1"></label>
							有效
			</span>
            <span class="fr">
						<input v-model="insert.value"  type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio" value="false">
						<label for="radio-1-2"></label>
							无效
			</span>
       </p>


         <p v-if="insert.method=='input'" >
            <span v-if="insert.must" class="red_star">*</span>
            <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              {{insert.text}}：
            <input v-model="insert.value" type="text" class="model_input " v-bind:placeholder="textplaceholder(insert.text)" />
         </p>

       <div v-if="insert.method=='select'" class="select_wrap select_pull_down" >
                                    <div>
                                        <span v-if="insert.must" class="red_star">*</span>
                                        <span v-else>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        {{insert.text}}：
                                        <input v-bind:data-ajax="insert.value" type="text" class="model_input  ka_input3" :placeholder="textplaceholder(insert.text)" :data-ajax="insert.material_type"  readonly />
                                    </div>
                                    <div class="ka_drop">
                                        <div class="ka_drop_list">
                                            <ul>
                                                <li v-for="(text,ajax) in insert.ajax"><a href="javascript:;"  v-bind:data-ajax="ajax" @click="onClick_select_ajax(ajax,key)">{{text}}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
</div>
     </div>
                    </div>
                    <div class="modal_footer bg_eee">
                        <p class="tac pb17">
                            <span class="col_37A confirm  " v-on:click="confirminsert">保存</span>
                            <span class="col_FFA cancle"  data-dismiss="modal">取消</span>
                        </p>
                    </div>
                </div>
            </div>
</div>
      </div>
`,
        props: [ 'title','inserts'],
        data() {
            return {
                message: 'hello world',
            }
        },
        methods: {
            dateDefind:function() {
                var self = this;
                var now = new Date();
                now = formatDate(now);
                self.inserts.effective_date.value = now;
                //初始化
                $('#add_Item .effective_date').datetimepicker({
                    language:  'zh-CN',
                    format: 'yyyy-mm-dd',
                    weekStart: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    forceParse: 1
                });
                //当选择器隐藏时，讲选择框只赋值给data里面的time
                $('#add_Item .effective_date').datetimepicker().on('hide', function (ev) {
                    var value = $("#add_Item .effective_date").val();
                    self.inserts.effective_date.value = value;
                });
            },
            textplaceholder(insert) {
                return "请输入" + insert
            },
            onClick_select_ajax(item,key) {
                console.log(key)
                this.inserts[key].value = item
                console.log(  this.inserts[key].value)
            },
            onClick_building_code: function () {
                var self = this
                $('#treeNavWrite>span').on("select_node.jstree", function (e, node) {
                    // var arr=node.node.id.split("_");

                    var building_code = node.node.original.code;
                    var parent_code = node.node.original.code;
                    self.inserts.building_code.value = building_code
                    self.inserts.parent_code.value = parent_code
                })
            },
            confirminsert() {
                this.$emit('confirminsert')
            }
        },
        mounted: function() {
            this.dateDefind();
        }
    })

    Vue.component('detailitem', {
        template: `
        <div>
        <p v-for="(detail,key) in inserts" v-if="detail.text">
             <span class="des">{{detail.text}}：</span>

             <span class="col_37A" :class="getclass(key)" v-if="detail.method!=='input' &&  detail.method!=='show'"></span>
               <span class="col_37A" :class="key" v-else></span>
        </p>



</div>
        `,
        props: [ 'inserts'],
        data() {
            return {
                message: 'hello world',
            }
        },
        methods:{
            getclass:function(key){
                return key+'_name'
            }
        }
      })


    //初始化新增楼宇信息 && 点击保存新增楼宇信息
    var vm= new Vue({
        el:'.main_wrap',
        data:{
            inserts:{
                code:{method:"show",value:"",text:"物资编码",must:true},
                effective_date:{method:"time",value:"",text:"生效日期",must:true},
                effective_status:{method:"radio",value:true,text:"物资状态"},
                name:{method:"input",value:"",text:'物资名称',must:true},
                pcs:{method:"input",value:"",text:"数量",must:true},
                material_type:{method:"select",value:"",text:"物资类型",must:true,
                    ajax:{'101':"工程物资",'102':"安防物资",'103':"消防物资",'104':"保洁物资",'105':"办公物资"}
                },
                building_code:{method:"building",value:"",text:"地址",must:true},
                parent_code:{method:"",value:"",text:""},
                materialfunction:{method:"input",value:"",text:"用途"},
                supplier:{method:"input",value:"",text:"供应商"},
                internal_no:{method:"input",value:"",text:"内部编号"},
                initial_no:{method:"input",value:"",text:"出厂编号"},
                remark:{method:"input",value:"",text:"备注"}
            }
        }
        ,
        computed:{


        },
        methods : {
            getlatestcode:function(){
                var self=this
                $.ajax({
                    url:'getMaterialLatestCode',
                    success:function(data){
                        if(parseInt(data)){
                            var code = parseInt(data) + 1;
                        }else{
                            var code = 1000001;
                        }
                        self.inserts.code.value=code
                    }
                })
            }
            ,

            confirminsert:function(){
                var vm=this
                var insertdata = {}
                for (var n in vm._data['inserts']) {
                    insertdata[n] = vm._data['inserts'][n]['value']
                }
                console.log(insertdata)
                if (!insertdata.effective_date) {
                    openLayer('请输入生效日期');
                    return;
                }
                if (!insertdata.name) {
                    openLayer('请输入物资名称');
                    return;
                }
                if (!insertdata.pcs) {
                    openLayer('请输入物资数量');

                    return;
                }
                if (!/^[0-9]*$/.test(insertdata.pcs)) {
                    openLayer('物资数量请输入数字');
                    return;
                }
                if (!insertdata.material_type) {
                    openLayer('请选择物资类型');
                    return;
                }
                if (!insertdata.building_code) {
                    openLayer('请选择至少一个地点!');
                    return;
                }

                //传数据
                $.ajax({
                    url: 'insertMaterial',
                    method: 'post',
                    data: insertdata,
                    success: function (data) {
                        //var data = JSON.parse(data);
                        $('#add_Item').modal('hide');
                        //成功之后自动刷新页面
                        layer.open({
                            type: 1,
                            title: false,
                            //打开关闭按钮
                            closeBtn: 1,
                            shadeClose: false,
                            skin: 'tanhcuang',
                            content: '新增物资成功',
                            cancel: function () {
                                materialList();
                            }
                        });
                    },
                    error: function () {
                        console.log('新增物资出错');
                    }
                })
            }

        },
        mounted: function(){
            this.getlatestcode()
        }
    })

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
            var code = row.m_code;
            var material_type_name = row.material_type_name;
            var name = row.m_name;
            var effective_date_name = row.effective_date_name;
            var building_code_name = row.building_code_name;
            var pcs = row.pcs;
            var materialfunction = row.materialfunction;
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
            $('#person_detail').find('.building_code_name').html(building_code_name);
            $('#person_detail').find('.pcs').html(pcs);
            $('#person_detail').find('.materialfunction').html(materialfunction);
            $('#person_detail').find('.remark').html(remark);
            $('#person_detail').find('.supplier').html(supplier);
            $('#person_detail').find('.initial_no').html(initial_no);
            $('#person_detail').find('.internal_no').html(internal_no);
            $('#person_detail').find('.pcs').html(pcs);
            $('#person_detail').find('.qr_code').attr("src",qr_code);
        }
    }

</script>

<script src='<?=base_url().'application/views/plugin/app/js/material_list.js'?>'></script>
</body>
</html>
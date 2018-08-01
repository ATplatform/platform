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
<script src='<?=base_url().'application/views/plugin/jquery-wordexport/FileSaver.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/jquery-wordexport/wordexport.js'?>'></script>

<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->
    <iv class="col-sm-12 main_wrap">
    <!-- 筛选条件 -->
    <div class="searc_bar search_wrap " id="search_wrap" >

     </div>


    <!-- 物资数据-->
        <div class="table_wrap">
         <div class="oh pt10">
             <span class="fr add_btn add_btn_notify" data-target="#notify" data-toggle="modal">催交</span>
             <span class="fr add_btn add_btn_getmoney" data-target="#notify" data-toggle="modal">现场收费</span>

             <span class="fr add_btn" data-target="#add_other" data-toggle="modal">新增其他收费项</span>
             <a class="fr add_btn" id="reset" >清除筛选</a>
            </div>
            <table id="table"
                   data-toolbar="#toolbar">
                <thead>
                <tr>
                 <!--   <th data-checkbox=true ></th>-->
                   <!-- <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
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
                    <th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>-->

                    <th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
                </tr>
                </thead>

            </table>
        </div>


<!--<button id="message_notify">notify</button>-->




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
            <div class="modal-dialog"  style="width: 600px;">
                <div class="modal-content model_wrap">
                    <div class="model_content">

                        <table id="getauz" data-toolbar="#toolbar" >
                            <thead >
                            <tr>
                                <th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
                                <th data-title="催交时间" data-align="center" data-field="date"></th>
                                <th data-title="催交人" data-align="center" data-field="person_code"></th>
                            </tr>
                            </thead>
                        </table>
                    </div>


                    <div class="modal_footer bg_eee">
                        <p class="tac pb17">
                            <span class="col_37A present">现场缴费</span>
                            <span class="col_37A print" id="word">打印收费凭证</span>
                            <span class="col_FFA cancle"  data-dismiss="modal">取消</span>
                        </p>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>

        <!-- 增加物资 -->
        <!--    <div class="modal fade" id="getmoney" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog"  style="width: 630px;">
                  <div class="modal-content model_wrap">
                      <div class="model_content">
                          <div class="building_header">
                              <h4 class="modal-title tac">现场收费</h4>
                          </div>
                          <div class=" modal-body building  oh">
                              <div class="getmoney">
                              </div>
                              <div style=" overflow:auto; width: 550px;height:400px;">
                              <table id="getmoney_table" data-toolbar="#toolbar" >
                                  <thead >
                                  </thead>
                              </table>
                              </div>
                          </div>
                      </div>
                      <div class="modal_footer bg_eee">
                          <p class="tac pb17">
                              <span class="col_37A confirm" id="getmoney_word">现场缴费</span>
                              <span class="col_37A confirm" id="message_notify">催交</span>
                              <span class="col_FFA cancle"  data-dismiss="modal">取消</span>
                          </p>
                      </div>
                  </div>
            </div>
        </div>-->


        <!--催交 -->
      <div class="modal fade" id="notify" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog"  style="width:850px;">
                <div class="modal-content model_wrap" style="width:850px;">
                    <div class="model_content" style="width:850px;position:relative;">
                        <div class="building_header">
                            <h4 class="modal-title tac add_btn_notify_h4">催交信息</h4>
                            <h4 class="modal-title tac add_btn_getmoney_h4">现场收费</h4>
                        </div>
                        <div class=" modal-body building  oh">
                            <div class="notify">
                                <button class=" btn notify_search" style="margin-left:500px;margin-bottom:180px;margin-top:20px;width:100px;">搜索账单</button>
                              <!--  <button class=" btn getmoney_search" style="margin-left:500px;margin-bottom:180px;margin-top:20px;width:100px;">搜索账单</button>-->
                            </div>

                            <div class="notify_table_wrap" style="overflow:auto; width:inherit; height:300px;margin-top:-180px;display:none">
                            <table id="notify_table" data-toolbar="#toolbar" >
                                <thead >
                                <tr>


                            </tr>
                            </thead >
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer bg_eee">
                        <p class="tac pb17">
                            <span class="col_37A confirm add_btn_notify_confirm" id="message_notify">催交</span>
                            <span class="col_37A confirm add_btn_getmoney_confirm" id="getmoney_word">现场缴费</span>

                            <span class="col_FFA cancle"  data-dismiss="modal">取消</span>
                        </p>
                    </div>
                </div>

            </div>
        </div>


        <div id="word-content" style="display:none">
            <div><p style="margin:0pt; text-align:center"><span class="village_name" style="color:#00b0f0; font-family:宋体; font-size:16pt; font-weight:bold; text-decoration:underline">小区名称 </span><span style="font-family:宋体; font-size:16pt; font-weight:bold">收款凭据</span></p><p style="margin:0pt; text-align:justify"><span style="font-family:宋体; font-size:10.5pt">缴费人姓名：</span><span style="color:#00b0f0; font-family:宋体; font-size:10.5pt; text-decoration:underline" class="bill_payer_name">张三</span><span style="color:#00b0f0; font-family:宋体; font-size:10.5pt"> </span></p><div style="text-align:center"><table cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin:0 auto; width:110.22%"><tbody><tr style="height:22.7pt"><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:8.74%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">序号</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:25.7%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">账单编号</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:31.84%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">账单类型</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:16.86%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">对应期数</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:16.86%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">应缴纳金额</span></p></td></tr>



                <tr id='word_content_html' style="display:none"></tr>


                        <tr style="height:22.7pt"><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:8.74%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:25.7%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:31.84%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:16.86%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:16.86%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span></p></td></tr><tr style="height:22.7pt"><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:8.74%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">合计</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:25.7%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">大写</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:31.84%"><p style="margin:0pt; text-align:center"><span style="color:#00b0f0; font-family:宋体; font-size:10.5pt; text-decoration:underline" class="bill_amount_big">壹佰元</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:16.86%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">小写</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:16.86%"><p style="margin:0pt; text-align:center"><span style="color:#00b0f0; font-family:宋体; font-size:10.5pt; text-decoration:underline">¥<span class="bill_amount_small">100.00</span></span></p></td></tr></tbody></table></div><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt">收款时间：</span><span style="color:#00b0f0; font-family:宋体; font-size:10.5pt; text-decoration:underline" class="now_time">2018-09-01</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt">&nbsp;</span><span style="font-family:宋体; font-size:10.5pt"> 收款人：</span><span style="color:#00b0f0; font-family:宋体; font-size:10.5pt; text-decoration:underline">财务-李晓琼</span></p><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:12pt">&nbsp;</span></p><p style="margin:0pt"><span style="font-family:宋体; font-size:12pt">&nbsp;</span></p></div>
        </div>


</div>
    </div>
</div>
<style>

    #person_detail .des{
        width:130px;
    }

    #person_detail .model_content p{
        width:500px;

    }
/*#person_detail .bootstrap-table{
    width:550px;
}*/
    #person_detail .bootstrap-table {
        margin-bottom: 20px;
    }
</style>



<input type="hidden" value='<?php echo $village_name;?>' name="village_name" />
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


<script>
    function word_export(index) {
        var word_name_tmp=0
        var html='';
        var all_amount=0;
        $("#word,#getmoney_word").click(function (e) {
            word_name_tmp++
               html='';
               all_amount=0;
            if(index['length']==null){
                var index_wrap={};
                for(var n in index){
                    index_wrap[n]=(index[n])
                }
                index['length']=1;
                index['0']=index_wrap
            }
            console.log(index)
           for(var n=0;n<index['length'];n++){
                console.log(index[n])
            var id=n+1;
            var bill_code=index[n].bill_code
            var bill_amount_name=index[n].bill_amount_name
            var bill_type_name=index[n].bill_type_name
            var bill_month=index[n].bill_month
            var bill_amount_name=index[n].bill_amount_name
            var bill_amount=parseFloat(index[n].bill_amount)
            all_amount=all_amount+bill_amount

                html +='<tr class="word_html_render" style="height:22.7pt"><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:8.74%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt" class="idformatter">'+id+'</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:25.7%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt" class="bill_code">'+bill_code+'</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:31.84%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt" class="bill_type_name">'+bill_type_name +'</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:16.86%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt" class="bill_month">'+bill_month+'</span></p></td><td style="border-bottom-color:#000000; border-bottom-style:solid; border-bottom-width:0.75pt; border-left-color:#000000; border-left-style:solid; border-left-width:0.75pt; border-right-color:#000000; border-right-style:solid; border-right-width:0.75pt; border-top-color:#000000; border-top-style:solid; border-top-width:0.75pt; padding-left:4.68pt; padding-right:4.68pt; vertical-align:middle; width:16.86%"><p style="margin:0pt; text-align:center"><span style="font-family:宋体; font-size:10.5pt" class="bill_amount_name">'+bill_amount+'元'+'</span></p></td></tr>';

 }
         index.bill_amount=parseFloat(index.bill_amount).toFixed(2)
            var bill_amount_small= all_amount
            var bill_amount_big=convertCurrency( all_amount)
            var village_name=$('input[name=village_name]').val()
            var now = getDate();
            $("#word-content .village_name").html(village_name)
            $("#word-content .bill_payer_name").html(index.bill_payer_name)
            $("#word-content .bill_amount_big").html(bill_amount_big)
            $("#word-content .bill_amount_small").html(bill_amount_small)
            $("#word-content .now_time").html(now);

            $('.word_html_render').remove()
            $(html).insertAfter("#word_content_html");

            $("#word-content").wordExport(now+'_'+word_name_tmp);   //fileName为导出的word文件的命名,content为要导出的html内容容器
            html2canvas(document.getElementById("content"), {
                onrendered: function (canvas) {
                    //通过html2canvas将html渲染成canvas，然后获取图片数据
                    var imgData = canvas.toDataURL('image/jpeg');

                    //初始化pdf，设置相应格式
                    var doc = new jsPDF("p", "mm", "a4");

                    doc.setFillColor(0, 0, 0);

                    //这里设置的是a4纸张尺寸
                    doc.addImage(imgData, 'JPEG', 0, 0, 210, 297);

                    //输出保存命名为content的pdf
                    doc.save('content.pdf');
                }
            });
        })
        $('.word_html_render').remove()
    }

    function convertCurrency(money) {
        //汉字的数字
        var cnNums = new Array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
        //基本单位
        var cnIntRadice = new Array('', '拾', '佰', '仟');
        //对应整数部分扩展单位
        var cnIntUnits = new Array('', '万', '亿', '兆');
        //对应小数部分单位
        var cnDecUnits = new Array('角', '分', '毫', '厘');
        //整数金额时后面跟的字符
        var cnInteger = '整';
        //整型完以后的单位
        var cnIntLast = '元';
        //最大处理的数字
        var maxNum = 999999999999999.9999;
        //金额整数部分
        var integerNum;
        //金额小数部分
        var decimalNum;
        //输出的中文金额字符串
        var chineseStr = '';
        //分离金额后用的数组，预定义
        var parts;
        if (money == '') { return ''; }
        money = parseFloat(money);
        if (money >= maxNum) {
            //超出最大处理数字
            return '';
        }
        if (money == 0) {
            chineseStr = cnNums[0] + cnIntLast + cnInteger;
            return chineseStr;
        }
        //转换为字符串
        money = money.toString();
        if (money.indexOf('.') == -1) {
            integerNum = money;
            decimalNum = '';
        } else {
            parts = money.split('.');
            integerNum = parts[0];
            decimalNum = parts[1].substr(0, 4);
        }
        //获取整型部分转换
        if (parseInt(integerNum, 10) > 0) {
            var zeroCount = 0;
            var IntLen = integerNum.length;
            for (var i = 0; i < IntLen; i++) {
                var n = integerNum.substr(i, 1);
                var p = IntLen - i - 1;
                var q = p / 4;
                var m = p % 4;
                if (n == '0') {
                    zeroCount++;
                } else {
                    if (zeroCount > 0) {
                        chineseStr += cnNums[0];
                    }
                    //归零
                    zeroCount = 0;
                    chineseStr += cnNums[parseInt(n)] + cnIntRadice[m];
                }
                if (m == 0 && zeroCount < 4) {
                    chineseStr += cnIntUnits[q];
                }
            }
            chineseStr += cnIntLast;
        }
        //小数部分
        if (decimalNum != '') {
            var decLen = decimalNum.length;
            for (var i = 0; i < decLen; i++) {
                var n = decimalNum.substr(i, 1);
                if (n != '0') {
                    chineseStr += cnNums[Number(n)] + cnDecUnits[i];
                }
            }
        }
        if (chineseStr == '') {
            chineseStr += cnNums[0] + cnIntLast + cnInteger;
        } else if (decimalNum == '') {
            chineseStr += cnInteger;
        }
        return chineseStr;
    }
</script>
<script src='<?=base_url().'application/views/plugin/app/js/bill_list.js'?>'></script>
</body>
</html>
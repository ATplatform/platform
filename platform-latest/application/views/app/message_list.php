<?php
	require 'top.php'
?>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-table/css/bootstrap-table.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/jstree/dist/themes/default/style.min.css'?>'/>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table-zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/jstree/dist/jstree.min.js'?>'></script>
<!--引入编辑器-->
<script src='<?=base_url().'application/views/plugin/utf8-php/ueditor.config.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/utf8-php/ueditor.all.min.js'?>'></script>
<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->
	<div class="col-sm-12 main_wrap">
		<div class="searc_bar search_wrap" id="search_wrap">
			<span class="col_37A fl">筛选条件</span>
			<input type="text" class="push_start_date date col_37A fl form-control" name="push_start_date"> 
			<span class="fl col_37A">-</span>
			<input type="text" class="push_end_date date col_37A fl form-control" name="push_end_date"> 
		
			<div class="msg_type_wrap select_pull_down query_wrap col_37A fl">
				<div>
					<input type="text" class="model_input msg_type ka_input3" placeholder="消息类型" name="msg_type" data-ajax="" readonly>
				</div>
				<div class="ka_drop">
					<div class="ka_drop_list">
					<ul>
						<li><a href="javascript:;" data-ajax="101">社区公告</a></li>
						<li><a href="javascript:;" data-ajax="102">住户通知</a></li>
						<li><a href="javascript:;" data-ajax="103">社区新闻</a></li>
					</ul>
					</div>
				</div>
			</div>

			<div class="cycle_type_wrap select_pull_down query_wrap col_37A fl" style="margin-left: 10px;">
				<div>
					<input type="text" class="model_input cycle_type ka_input3" placeholder="循环类型" name="cycle_type" data-ajax="" readonly>
				</div>
				<div class="ka_drop">
					<div class="ka_drop_list">
					<ul>
						<li><a href="javascript:;" data-ajax="101">一次性立即消息</a></li>
						<li><a href="javascript:;" data-ajax="102">一次性定时消息</a></li>
						<li><a href="javascript:;" data-ajax="103">循环消息</a></li>
					</ul>
					</div>
				</div>
			</div>
			
			<div class="search_room msg_search_room">
				<p>
					<input type="text" class="searc_room_text" name="keyword" placeholder="可输入信息标题" value="">
					<a id="clear" href="javascript:;">X</a>
				</p>
				<button type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>
		
		<div class="table_wrap">
			<div class="oh pt10">
				<span class="fr add_btn" data-target="#add_message" data-toggle="modal">新增信息</span>
			</div>
			
			<table id="table"
					data-toolbar="#toolbar"	
			>
			<thead>
				<tr>
					<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
					<th data-title="数据id"  data-field="id" data-visible="false"></th>

					<th data-field="code" data-title="信息编号" data-align="center"></th>
					<th data-field="push_start_date" data-title="信息推送时间" data-align="center"></th>
					<th data-field="msg_type_name" data-title="信息类型" data-align="center"></th>
					<th data-field="if_cycle_name" data-title="循环类型" data-align="center"></th>
					<th data-field="msg_title" data-title="推送标题" data-align="center" data-formatter="viewAll"></th>
					<th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>

		</div>

		<!--分页-->
		<ul class="pager" page='<? $page ?>'>
		    <?php
		       $first=base_url().'index.php/Message/messagelist?page=1&keyword='.$keyword.'&msg_type='.$msg_type.'&cycle_type='.$cycle_type.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/Message/messagelist?page='.($page-1).'&keyword='.$keyword.'&msg_type='.$msg_type.'&cycle_type='.$cycle_type.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/Message/messagelist?page='.($page+1).'&keyword='.$keyword.'&msg_type='.$msg_type.'&cycle_type='.$cycle_type.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/Message/messagelist?page='.$total.'&keyword='.$keyword.'&msg_type='.$msg_type.'&cycle_type='.$cycle_type.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date;
		    echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
		    echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
		    echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
		    ?>
		</ul>

	</div>

</div>

<!--新增信息-->
<div class="modal fade" id="add_message" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">新增信息</h4>
	            </div>
	            <div class="modal-body building">
					<p>&nbsp;&nbsp;&nbsp;&nbsp;信息编号：
						<span class="code" style="margin-left:26px;"></span>
					</p>
					<div class="select_wrap target_wrap">
						<div><span class="red_star">*</span>推送对象：
							<span style="margin-left:36px;">
								<input type="radio" id="radio-1-1" name="target" class="regular-radio" checked>
								<label for="radio-1-1"></label>全体小区
							</span>
						</div>
						<div>
							<span style="margin-left: 115px;">
								<input type="radio" id="radio-1-2" name="target" class="regular-radio">
								<label for="radio-1-2"></label>指定住户
							</span>
							<span class="select_buliding_wrap" style="display: none;">
								<a href="javascript:;" id="treeNavAdd" class="treeWrap"><span></span></a>
								<span class="select_buliding">
								</span>
							</span>
						</div>
						<div>
							<span style="margin-left: 115px;">
								<input type="radio" id="radio-1-3" name="target" class="regular-radio">
								<label for="radio-1-3"></label>指定设备
							</span>
							<div style="margin-left: 115px;display: none;" class="msg_target_equipment search_equipment_wrap">
								<div class="search_person_text">
									<input type="text" class="fl search_person_name" placeholder="请输入设备名称查找" style="width: 340px;">
									<a class="fr search_person_btn"><i class="fa fa-search"></i></a>
								</div>
								<div class="search_person_results" style="padding-left: 0px;"></div>
								<div class="person_building_data" style="padding-left: 0px;">
									<ul></ul>
								</div>
							</div>
						</div>
					</div>
					<p class="msg_type_wrap"><span class="red_star">*</span>信息类型：
						<span style="margin-left:36px;">
							<input type="radio" id="radio-2-1" name="msg_type" class="regular-radio" checked="">
							<label for="radio-2-1"></label>社区公告
						</span>

						<span style="margin-left:47px;">
							<input type="radio" id="radio-2-2" name="msg_type" class="regular-radio">
							<label for="radio-2-2"></label>住户通知
						</span>

						<span style="margin-left:48px;">
							<input type="radio" id="radio-2-3" name="msg_type" class="regular-radio">
							<label for="radio-2-3"></label>社区新闻
						</span>
					</p>

					<div class="if_bill_wrap">
						<span class="red_star">*</span>是否为缴费通知：
						<span>
							<input type="radio" id="radio-3-2" name="if_bill" class="regular-radio if_bill" checked="">
							<label for="radio-3-2"></label>否

							<input type="radio" id="radio-3-1" name="if_bill" class="regular-radio if_bill">
							<label for="radio-3-1" style="margin-left: 84px;"></label>是
							
							<span class="bill_amount_wrap" style="display: none;">
								<span style="margin-left: 10px;">缴费金额：</span>
								<input type="text" value="" class="bill_amount" name="bill_amount" />元
							</span>
						</span>
					</div>
					
					<p class="if_cycle_wrap"><span class="red_star">*</span>循环类型：
						<span style="margin-left:36px;">
							<input type="radio" id="radio-4-1" name="if_cycle" class="regular-radio" checked="">
							<label for="radio-4-1"></label>一次性立即消息
						</span>
						<span style="margin-left:12px;">
							<input type="radio" id="radio-4-2" name="if_cycle" class="regular-radio">
							<label for="radio-4-2"></label>一次性定时消息
						</span>
						<span style="margin-left:12px;">
							<input type="radio" id="radio-4-3" name="if_cycle" class="regular-radio">
							<label for="radio-4-3"></label>循环消息
						</span>
					</p>

					<div class="select_wrap">
						<p class="push_start_date_wrap" style="display: none;float: left;"><span class="red_star">*</span>推送时间：
							<input style="display: inline-block;width: 140px;margin-left: 33px;" type="text" class="push_start_date form-control" name="push_start_date">
						</p>

						<p class="push_end_date_wrap fr"  style="display: none;">
							<span style="margin-left: 10px;margin-right: 10px;">截止日期：</span>
							<input style="display: inline-block;width: 140px;" type="text" value="" class="date form-control push_end_date" name="push_end_date"  />
						</p>
						<div class="clear"></div>
					</div>
					
					<div class="select_pull_down select_wrap select_cycle_type_wrap" style="display: none;">
						<div>
							<span class="red_star">*</span>循环周期: 
							<input type="text" class="model_input cycle_type ka_input3" placeholder="请选择循环周期" name="level" style="margin-bottom: 20px;" data-ajax="" readonly="">
						</div>
						<div class="ka_drop" style="">
							<div class="ka_drop_list">
							<ul>
								<li><a href="javascript:;" data-ajax="101">每天一次</a></li>
								<li><a href="javascript:;" data-ajax="102">每周一次</a></li>
								<li><a href="javascript:;" data-ajax="103">双周一次</a></li>
								<li><a href="javascript:;" data-ajax="104">每月一次</a></li>
							</ul>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<p class="if_receipt_wrap"><span class="red_star">*</span>是否需要回执：
						<span style="margin-left: 11px;">
							<input type="radio" id="if_receipt-1" name="if_receipt" class="regular-radio" checked="">
							<label for="if_receipt-1"></label>
							不需要
						</span>

						<span  style="margin-left: 57px;">
							<input type="radio" id="if_receipt-2" name="if_receipt" class="regular-radio">
							<label for="if_receipt-2"></label>
							需要
						</span>
					</p>
					
					<ul class="msg_img_wrap">

					</ul>


					<p class="select_wrap">
						<span class="red_star">*</span>信息标题：
						<input type="text" class="msg_title" name="msg_title" maxlength="32">
					</p>
					
					<!--编辑器-->
					<script id="editor" type="text/plain" style="width:568px;height:500px;margin-left: -14px;"></script>	

	            </div>
	            <input type="hidden" value="<?php echo $village_id ?>" class="village_id" />
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_37A view">预览</span>
                	<span class="col_FFA cancle" data-dismiss="modal">取消</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!--预览信息-->
<div class="modal fade" id="confirm_message" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="modal-body building">
					<iframe  class="msg_html" src="" width="320" height="568" scrolling="auto" align="center">   
					</iframe>
	            </div>
	            <div class="switch_screen">
					<span class="col_37A active stand">竖屏效果</span>
					<span class="col_37A lie">横屏效果</span>
	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_37A add">推送</span>
                	<span class="col_FFA cancle" data-dismiss="modal">返回</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!--信息详细-->
<div class="modal fade" id="message_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">消息详情</h4>
	            </div>
	            <div class="modal-body building oh">
					<p style="line-height: 30px;">信息编号：
						<span class="code" style="margin-left: 34px;"></span>
					</p>
					<p style="line-height: 30px;">信息类型：
						<span class="msg_type_name col_37A" style="margin-left: 36px;"></span>
					</p>
					<p style="line-height: 30px;">是否为缴费通知：
						<span class="if_bill_name col_37A"></span>
						<span class="bill_amount" style="margin-left: 20px;">缴费金额：
						<span class="col_37A"></span></span>
					</p>
					<p style="line-height: 30px;">循环类型：
						<span class="cycle_type_name col_37A" style="margin-left: 36px;"></span>
					</p>
					<p style="line-height: 30px;">是否需要回执：
						<span class="if_receipt_name col_37A" style="margin-left: 10px;"></span>
					</p>
					<p style="line-height: 30px;">
						<span>推送对象：</span>
						<span class="target_wrap col_37A" style="margin-left: 36px;">
							
						</span>
					</p>
					<p style="line-height: 30px;">推送时间：
						<span class="push_start_date col_37A" style="margin-left: 36px;"></span>
					</p>
					<p style="line-height: 30px;" class="push_end_date_wrap">截止时间：
						<span class="push_end_date col_37A" style="margin-left: 36px;"></span>
					</p>
					<p style="line-height: 30px;">信息标题：
						<span class="msg_title col_37A" style="margin-left: 36px;"></span>
					</p>
					<div class="tac">
						<iframe  class="msg_html" src="" width="320" height="568" scrolling="auto" align="center">   
						</iframe>
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

<!--修改信息-->
<div class="modal fade" id="message_write" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">编辑消息</h4>
	            </div>
	            <div class="modal-body building oh">
					<p style="line-height: 30px;">信息编号：
						<span class="code" style="margin-left: 34px;"></span>
					</p>
					<p style="line-height: 30px;">信息类型：
						<span class="msg_type_name col_37A" style="margin-left: 36px;"></span>
					</p>
					<p style="line-height: 30px;">是否为缴费通知：
						<span class="if_bill_name col_37A"></span>
						<span class="bill_amount " style="margin-left: 20px;">缴费金额：<em class="col_37A"></em></span>
					</p>
					<p style="line-height: 30px;">循环类型：
						<span class="cycle_type_name col_37A" style="margin-left: 36px;"></span>
					</p>
					<p style="line-height: 30px;">是否需要回执：
						<span class="if_receipt_name col_37A" style="margin-left: 10px;"></span>
					</p>
					<p style="line-height: 30px;">
						<span>推送对象：</span>
						<span class="target_wrap col_37A" style="margin-left: 36px;">
							
						</span>
					</p>
					<p style="line-height: 30px;">推送时间：
						<span class="push_start_date col_37A" style="margin-left: 36px;"></span>
					</p>
					<p>截止时间：
						<input style="display: inline-block;width: 200px;float: none;    margin-left: 35px;padding-left: 0;" type="text" value="" class="date form-control end_date" name="end_date"  />
					</p>
					<p style="line-height: 30px;">信息标题：
						<span class="msg_title col_37A" style="margin-left: 36px;"></span>
					</p>
					<div class="tac">
						<iframe  class="msg_html" src="" width="320" height="568" scrolling="auto" align="center">   
						</iframe>
					</div>
	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_37A save">保存</span>
                	<span class="col_C45 cancle" data-dismiss="modal">取消</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<input type="hidden" value='<?php echo $page;?>' name="page" />
<input type="hidden" value='<?php echo $treeNav_data;?>'  id="treeNav_data" />
<input type="hidden" value='<?php echo $keyword;?>' name="keywords" />
<input type="hidden" value='<?php echo $pagesize;?>' name="pagesize" />
<script>
// $('#add_message').modal('show');
</script>
<script>
$(function(){
	var now = getDate();
	//消息的查询开始时间为上个月的今天
	var lastMonthDate = getLastMonthYestdy();
	var today_begin = lastMonthDate + " 00:00";
	var today_end = now + " 23:59";
	var page = getUrlParam('page');
	var search_keyword = getUrlParam('keyword');
	var search_msg_type = getUrlParam('msg_type');
	var search_cycle_type = getUrlParam('cycle_type');
	var search_start_date = getUrlParam('push_start_date');
	var search_end_date = getUrlParam('push_end_date');
	search_start_date = search_start_date?search_start_date:today_begin;
	search_end_date = search_end_date?search_end_date:today_end;
	//根据搜索内容给搜索框和筛选条件赋值
	$('.search_wrap .push_start_date').val(search_start_date);
	$('.search_wrap .push_end_date').val(search_end_date);
	$('.search_room .searc_room_text').val(search_keyword);
	switch(search_msg_type){
		case '101':
			$('.search_wrap .msg_type').val('社区公告');
			break;
		case '102':
			$('.search_wrap .msg_type').val('住户通知');
			break;
		case '103':
			$('.search_wrap .msg_type').val('社区新闻');
			break;
		default:
			$('.search_wrap .msg_type').val('消息类型');
			break;
	}
	switch(search_cycle_type){
		case '101':
			$('.search_wrap .cycle_type').val('一次性立即消息');
			break;
		case '102':
			$('.search_wrap .cycle_type').val('一次性定时消息');
			break;
		case '103':
			$('.search_wrap .cycle_type').val('循环消息');
			break;
		default:
			$('.search_wrap .cycle_type').val('循环类型');
			break;
	}
	$('#table').bootstrapTable({
		method: "get",
		undefinedText:'/',
		url:getRootPath()+'/index.php/Message/getMessageList?page='+page+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&keyword='+search_keyword+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date,
		dataType:'json',
		responseHandler:function(res){
			//用于处理后端返回数据
			return res;
		},
		onLoadSuccess: function(data){  //加载成功时执行
		},
		onLoadError: function(){  //加载失败时执行
		    console.info("加载数据失败");
		},
		formatNoMatches: function(){
		    return "没有相关的匹配结果";
		  },
		  formatLoadingMessage: function(){
		    return "请稍等，正在加载中。。。";
		  }
	})
	//点击分页go,判断页面跳转
	$('.fenye_btn').click(function(){
		var page = $('input[name="fenye_input"]').val();
		if(!/^[0-9]*$/.test(page)){
		    openLayer('请输入数字');
		    $('input[name="fenye_input"]').val('');
		    return;
		}
		var pagenumber=Number(page)+"";
		var myCurrent = $('#current').text().split('/')[0];
		var myTotal = $('#current').text().split('/')[1];
		if(page!=pagenumber)
		{
		    $('input[name="fenye_input"]').val(pagenumber);
		    page=pagenumber;
		}
		if(Number(page)>Number(myTotal))
		{
		    $('input[name="fenye_input"]').val(myTotal);
		    page=myTotal;
		}
		if(Number(page)<1)
		{
			openLayer('请输入合法页数');
			$('input[name="fenye_input"]').val('');
			return;
		}
		var keyword=getUrlParam('keyword');
		window.location.href="messagelist?keyword="+search_keyword+"&page="+page+'&msg_type='+search_msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date;
	})
	//消息类型筛选
	$('.msg_type_wrap .ka_drop_list li').click(function(){
		var msg_type = $(this).find('a').data('ajax');
		window.location.href="messagelist?keyword="+search_keyword+"&page=1"+"&msg_type="+msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date;
	})
	//循环类型筛选
	$('.cycle_type_wrap .ka_drop_list li').click(function(){
		var cycle_type = $(this).find('a').data('ajax');
		window.location.href="messagelist?keyword="+search_keyword+"&page=1"+"&msg_type="+search_msg_type+'&cycle_type='+cycle_type+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date;
	})
	//开始日期筛选
	$('#search_wrap .push_start_date').datetimepicker().on('changeDate',function(e){
		var startDate = $('#search_wrap .push_start_date').val();
		var endDate = $('#search_wrap .push_end_date').val();
		if(startDate>endDate){
			openLayer('开始时间必须小于结束时间!');
			$('#search_wrap .push_end_date').val(' ');
			return;
		}
		else{
		 	window.location.href="messagelist?keyword="+search_keyword+"&page=1"+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+startDate+'&push_end_date='+endDate;
		}
	});
	//结束日期筛选
	$('#search_wrap .push_end_date').datetimepicker().on('changeDate',function(e){
		var startDate = $('#search_wrap .push_start_date').val();
		var endDate = $('#search_wrap .push_end_date').val();
		if(startDate>endDate){
			openLayer('开始时间必须小于结束时间!');
			$('#search_wrap .push_end_date').val(' ');
			return;
		}
		else{
		 	window.location.href="messagelist?keyword="+search_keyword+"&page=1"+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+startDate+'&push_end_date='+endDate;
		}
	});
	//点击搜索按钮,跳转
	$('.search_room button[type="submit"]').click(function(){
		var keyword = $('.search_room .searc_room_text').val();
		keyword = trim(keyword);
		if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
			openLayer('搜索框只能输入数字、汉字、字母!');
			return;
		}
		window.location.href="messagelist?keyword="+keyword+"&page=1"+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date;
	})
	//清除搜索条件
	$('.search_room #clear').click(function(){
		window.location.href="messagelist?page=1"+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date;
	})

})
</script>
<script>
// var treeNav_data = $('#treeNav_data').val();
var treeNav_data = <?php echo $treeNav_data?>;
// console.log(treeNav_data);
//新增信息条目树形菜单
$('#treeNavAdd>span').jstree({
	'core' : {
        data: treeNav_data
    }
})
//树节点点击后将节点赋值
$('#treeNavAdd>span').on("select_node.jstree", function (e, node) {
  //选择节点后自动关闭菜单
  $(this).jstree('close_all');
  var arr=node.node.id.split("_");
  var parent_code=arr[0];
  //当前节点的id
  var id=arr[1];
  //当前节点的文本值
  var name = node.node.text;
  //当前节点的房号code
  var room_code = node.node.original.code;
  console.log(room_code);
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
<script src='<?=base_url().'application/views/plugin/app/js/message_list.js'?>'></script>
</body>
</html>
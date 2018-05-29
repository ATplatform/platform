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
<div class="header oh">
	<div class="fl logo">
		<i></i>艾特智能AI社区云平台
	</div>
	<div class="top_login_wrap fr">
		<span class="user"><i></i><?php echo $username ?></span>
		|<a class="login_out" href="<?=base_url().'index.php/Login/logout'?>">退出登录</a>
	</div>
</div>	

<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->
	<div class="col-md-10 col-sm-12 main_wrap">
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

			<div class="if_has_receipt_wrap select_pull_down query_wrap col_37A fl" style="margin-left: 10px;">
				<div>
					<input type="text" class="model_input if_has_receipt ka_input3" placeholder="是否回执" name="if_has_receipt" data-ajax="" readonly>
				</div>
				<div class="ka_drop">
					<div class="ka_drop_list">
					<ul>
						<li><a href="javascript:;" data-ajax="101">已回执</a></li>
						<li><a href="javascript:;" data-ajax="102">全部</a></li>
					</ul>
					</div>
				</div>
			</div>

			<form class="search_room msg_search_room" action="" method="get">
				<p>
					<input type="text" class="searc_room_text" name="keyword" placeholder="可输入消息标题或者推送对象" value="">
					<a id="clear" href="javascript:;">X</a>
				</p>
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>

		</div>
		
		<div class="table_wrap">
			
			<table id="table"
					data-toolbar="#toolbar"	
			>
			<thead>
				<tr>
					<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
					<th data-title="数据id"  data-field="id" data-visible="false"></th>

					<th data-field="code" data-title="信息编号" data-align="center"></th>
					<th data-field="push_time" data-title="信息推送时间" data-align="center"></th>
					<th data-field="msg_type_name" data-title="信息类型" data-align="center"></th>
					<th data-field="cycle_type_name" data-title="循环类型" data-align="center"></th>
					<th data-field="msg_title" data-title="推送标题" data-align="center"></th>
					<th data-field="push_state_name" data-title="状态" data-align="center"></th>
					<th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>

		</div>

		<!--分页-->
		<ul class="pager" page='<? $page ?>'>
		    <?php
		       $first=base_url().'index.php/Message/messagerecordlist?page=1&keyword='.$keyword.'&msg_type='.$msg_type.'&cycle_type='.$cycle_type.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/Message/messagerecordlist?page='.($page-1).'&keyword='.$keyword.'&msg_type='.$msg_type.'&cycle_type='.$cycle_type.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/Message/messagerecordlist?page='.($page+1).'&keyword='.$keyword.'&msg_type='.$msg_type.'&cycle_type='.$cycle_type;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/Message/messagerecordlist?page='.$total.'&keyword='.$keyword.'&msg_type='.$msg_type.'&cycle_type='.$cycle_type.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date;
		    echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
		    echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
		    echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
		    ?>
		</ul>

	</div>

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
					<p>信息编号：
						<span class="code"></span>
					</p>
					<p>信息类型：
						<span class="msg_type_name col_37A"></span>
					</p>
					<p>是否为缴费通知：
						<span class="if_bill_name col_37A"></span>
						<span class="bill_amount col_37A" style="margin-left: 20px;">缴费金额：<em class="col_37A"></em></span>
					</p>
					<p>循环类型：
						<span class="cycle_type_name col_37A"></span>
					</p>
					<p>是否需要回执：
						<span class="if_receipt_name col_37A"></span>
					</p>
					<p>
						<span>推送对象：</span>
						<span class="target_wrap col_37A">
							
						</span>
					</p>
					<p>推送时间：
						<span class="push_start_date col_37A"></span>
					</p>
					<p>截止时间：
						<span class="push_end_date col_37A"></span>
					</p>
					<p>消息标题：
						<span class="msg_title col_37A"></span>
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
	var today_begin = now + " 00:00";
	var today_end = now + " 23:59";
	var page = getUrlParam('page');
	var search_keyword = getUrlParam('keyword');
	var search_msg_type = getUrlParam('msg_type');
	var search_cycle_type = getUrlParam('cycle_type');
	var search_if_has_receipt = getUrlParam('if_has_receipt');
	var search_start_date = getUrlParam('push_start_date');
	var search_end_date = getUrlParam('push_end_date');
	search_start_date = search_start_date?search_start_date:today_begin;
	search_end_date = search_end_date?search_end_date:today_end;
	//根据搜索内容给搜索框和筛选条件赋值
	$('.push_start_date').val(search_start_date);
	$('.push_end_date').val(search_end_date);
	$('.search_room .searc_room_text').val(search_keyword);
	switch(search_msg_type){
		case '101':
			$('.msg_type').val('社区公告');
			break;
		case '102':
			$('.msg_type').val('住户通知');
			break;
		case '103':
			$('.msg_type').val('社区新闻');
			break;
		default:
			$('.msg_type').val('消息类型');
			break;
	}
	switch(search_cycle_type){
		case '101':
			$('.cycle_type').val('一次性立即消息');
			break;
		case '102':
			$('.cycle_type').val('一次性定时消息');
			break;
		case '103':
			$('.cycle_type').val('循环消息');
			break;
		default:
			$('.cycle_type').val('循环类型');
			break;
	}
	switch(search_if_has_receipt){
		case '101':
			$('.if_has_receipt').val('已回执');
			break;
		case '102':
			$('.if_has_receipt').val('全部');
			break;
		default:
			$('.if_has_receipt').val('是否回执');
			break;
	}
	$('#table').bootstrapTable({
		method: "get",
		undefinedText:'/',
		url:getRootPath()+'/index.php/Message/getmessagerecordlist?page='+page+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&keyword='+search_keyword+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date+'&if_has_receipt='+search_if_has_receipt,
		dataType:'json',
		responseHandler:function(res){
			//用于处理后端返回数据
			return res;
		},
		onLoadSuccess: function(data){  //加载成功时执行
		},
		onLoadError: function(){  //加载失败时执行
		    console.info("加载数据失败");
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
		window.location.href="managementlist?keyword="+search_keyword+"&page="+page+'&msg_type='+search_msg_type;
	})
	//消息类型筛选
	$('.msg_type_wrap .ka_drop_list li').click(function(){
		var msg_type = $(this).find('a').data('ajax');
		window.location.href="messagerecordlist?keyword="+search_keyword+"&page=1"+"&msg_type="+msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date+'&if_has_receipt='+search_if_has_receipt;
	})
	//循环类型筛选
	$('.cycle_type_wrap .ka_drop_list li').click(function(){
		var cycle_type = $(this).find('a').data('ajax');
		window.location.href="messagerecordlist?keyword="+search_keyword+"&page=1"+"&msg_type="+search_msg_type+'&cycle_type='+cycle_type+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date+'&if_has_receipt='+search_if_has_receipt;
	})
	//是否回执筛选
	$('.if_has_receipt_wrap .ka_drop_list li').click(function(){
		var if_has_receipt = $(this).find('a').data('ajax');
		window.location.href="messagerecordlist?keyword="+search_keyword+"&page=1"+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date+'&if_has_receipt='+if_has_receipt;
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
		 	window.location.href="messagerecordlist?keyword="+search_keyword+"&page=1"+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+startDate+'&push_end_date='+endDate+'&if_has_receipt='+search_if_has_receipt;
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
		 	window.location.href="messagerecordlist?keyword="+search_keyword+"&page=1"+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+startDate+'&push_end_date='+endDate+'&if_has_receipt='+search_if_has_receipt;
		}
	});
	//点击搜索按钮,跳转
	$('.search_room button[type="submit"]').click(function(){
		var keyword = $('.search_room .searc_room_text').val();
		keyword = trim(keyword);
		if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
			openLayer('搜索框只能输入数字和汉字!');
			return;
		}
		window.location.href="messagerecordlist?keyword="+keyword+"&page=1"+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date+'&if_has_receipt='+search_if_has_receipt;
	})
	//清除搜索条件
	$('.search_room #clear').click(function(){
		window.location.href="messagerecordlist?page=1"+'&push_start_date='+today_begin+'&push_end_date='+today_end;
	})

})
</script>
<script src='<?=base_url().'application/views/plugin/app/js/messagerecord_list.js'?>'></script>
</body>
</html>
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
			
			<a href="javascript:;" id="treeNav" class="treeWrap" style="margin-left: 10px;"><span></span></a>

			<div class="equipment_type_wrap select_pull_down query_wrap col_37A fl">
				<div>
					<input type="text" class="model_input equipment_type ka_input3" placeholder="设备类型" name="equipment_type" data-ajax="" readonly>
				</div>
				<div class="ka_drop">
					<div class="ka_drop_list">
					<ul>
						<li><a href="javascript:;" data-ajax="301">中心机</a></li>
						<li><a href="javascript:;" data-ajax="302">围墙机</a></li>
						<li><a href="javascript:;" data-ajax="303">单元门口机</a></li>
						<li><a href="javascript:;" data-ajax="304">别墅门口机</a></li>
						<li><a href="javascript:;" data-ajax="305">室内机</a></li>
						<!-- <li><a href="javascript:;" data-ajax="306">独立指纹机</a></li> -->
						<li><a href="javascript:;" data-ajax="307">魔镜</a></li>
					</ul>
					</div>
				</div>
			</div>
			
			<div class="search_room msg_search_room">
				<p>
					<input type="text" class="searc_room_text" name="keyword" placeholder="可输入开门人姓名搜索" value="">
					<a id="clear" href="javascript:;">X</a>
				</p>
				<button type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>
		
		<div class="table_wrap">
			<div class="oh pt10">
				<a class="fr add_btn" href="<?=base_url().'index.php/Permission/dooropenlist'?>">清除筛选</a>
			</div>
			<table id="table"
					data-toolbar="#toolbar"	
			>
			<thead>
				<tr>
					<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
					<th data-field="building_name" data-title="设备地址" data-align="center"></th>
					<th data-field="equipment_name" data-title="设备名称" data-align="center"></th>
					<th data-field="person_type_name" data-title="开门人类型" data-align="center"></th>
					<th data-field="full_name" data-title="开门人姓名" data-align="center"></th>
					<th data-field="entry_type_name" data-title="开门方式" data-align="center"></th>
					<th data-field="entry_time" data-title="开门时间" data-align="center"></th>
					<th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>

		</div>

		<!--分页-->
		<ul class="pager" page='<? $page ?>'>
		    <?php
		       $first=base_url().'index.php/Permission/dooropenlist?page=1&keyword='.$keyword.'&equipment_type='.$equipment_type.'&building_code='.$building_code.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/Permission/dooropenlist?page='.($page-1).'&keyword='.$keyword.'&equipment_type='.$equipment_type.'&building_code='.$building_code.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/Permission/dooropenlist?page='.($page+1).'&keyword='.$keyword.'&equipment_type='.$equipment_type.'&building_code='.$building_code.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/Permission/dooropenlist?page='.$total.'&keyword='.$keyword.'&equipment_type='.$equipment_type.'&building_code='.$building_code.'&push_start_date='.$push_start_date.'&push_end_date='.$push_end_date;
		    echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
		    echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
		    echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
		    ?>
		</ul>

	</div>

</div>


<!--详细-->
<div class="modal fade" id="content_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">开门记录详情</h4>
	            </div>
	            <div class="modal-body building oh">
	            	<p><span class="des">设备名称：&nbsp;&nbsp;</span>
	            		<span class="equipment_name col_37A"></span>
	            	</p>
	            	<p><span class="des">开门人姓名：</span>
	            		<span class="full_name col_37A"></span>
	            	</p>
	            	<p><span class="des">开门人类型：</span>
	            		<span class="person_type_name col_37A"></span>
	            	</p>
	            	<p><span class="des">开门方式：&nbsp;&nbsp;</span>
	            		<span class="entry_type_name col_37A"></span>
	            	</p>
	            	<p><span class="des">设备地址：&nbsp;&nbsp;</span>
	            		<span class="building_name col_37A"></span>
	            	</p>
	            	<p><span class="des">开门时间：&nbsp;&nbsp;</span>
	            		<span class="entry_time col_37A"></span>
	            	</p>
	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_FFA cancle" data-dismiss="modal">关闭</span>
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
// $('#content_write').modal('show');
</script>
<script>
$(function(){
	var treeNav_data = <?php echo $treeNav_data?>;
	//树形菜单
	$('#treeNavAdd>span,#treeNav>span').jstree({
		'core' : {
	        data: treeNav_data
	    }
	})
	var now = getDate();
	var lastMonthDate = getLastMonthYestdy();
	var today_begin = lastMonthDate + " 00:00";
	var today_end = now + " 23:59";
	var page = getUrlParam('page');
	var search_keyword = getUrlParam('keyword');
	var search_effective_date = getUrlParam('effective_date');
	var search_equipment_type = getUrlParam('equipment_type');
	var search_building_code = getUrlParam('building_code');
	var search_start_date = getUrlParam('push_start_date');
	var search_end_date = getUrlParam('push_end_date');
	search_start_date = search_start_date?search_start_date:today_begin;
	search_end_date = search_end_date?search_end_date:today_end;
	search_effective_date = search_effective_date?search_effective_date:now;
	//根据搜索内容给搜索框和筛选条件赋值
	$('.search_wrap .push_start_date').val(search_start_date);
	$('.search_wrap .push_end_date').val(search_end_date);
	$('.effective_date').val(search_effective_date);
	$('.search_room .searc_room_text').val(search_keyword);
	//赋值设备类型
	switch(search_equipment_type){
		case '301':
			$('.search_wrap .equipment_type').val('中心机');
			break;
		case '302':
			$('.search_wrap .equipment_type').val('围墙机');
			break;
		case '303':
			$('.search_wrap .equipment_type').val('单元门口机');
			break;
		case '304':
			$('.search_wrap .equipment_type').val('别墅门口机');
			break;
		case '305':
			$('.search_wrap .equipment_type').val('室内机');
			break;
		/*case '306':
			$('.search_wrap .equipment_type').val('独立指纹机');
			break;*/
		case '307':
			$('.search_wrap .equipment_type').val('魔镜');
			break;
		default:
			$('.search_wrap .equipment_type').val('设备类型');
			break;
	}

	$('#table').bootstrapTable({
		method: "get",
		undefinedText:' ',
		url:getRootPath()+'/index.php/Permission/getDoorOpenList?page='+page+'&keyword='+search_keyword+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date,
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
		window.location.href="dooropenlist?keyword="+search_keyword+"&page="+page+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date;
	})

	//开始日期筛选
	$('#search_wrap .push_start_date,#search_wrap .push_end_date').datetimepicker().on('changeDate',function(e){
		var startDate = $('#search_wrap .push_start_date').val();
		var endDate = $('#search_wrap .push_end_date').val();
		if(startDate>endDate){
			openLayer('开始时间必须小于结束时间!');
			$('#search_wrap .push_end_date').val(' ');
			return;
		}
		else{
		 	window.location.href="dooropenlist?keyword="+search_keyword+"&page=1"+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code+'&push_start_date='+startDate+'&push_end_date='+endDate;
		}
	});

	//设备类型筛选
	$('.search_wrap .equipment_type_wrap .ka_drop_list li').click(function(){
		var equipment_type = $(this).find('a').data('ajax');
		window.location.href="dooropenlist?keyword="+search_keyword+"&page=1"+'&equipment_type='+equipment_type+'&building_code='+search_building_code+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date;
	})
	//树形菜单点击筛选
	$('#treeNav>span').on("select_node.jstree", function (e, node) {
	  var building_code = node.node.original.code;
	  window.location.href="dooropenlist?keyword="+search_keyword+"&page=1"+'&equipment_type='+search_equipment_type+'&building_code='+building_code+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date;
	})
	//点击搜索按钮,跳转
	$('.search_room button[type="submit"]').click(function(){
		var keyword = $('.search_room .searc_room_text').val();
		keyword = trim(keyword);
		if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
			openLayer('搜索框只能输入数字、汉字、字母!');
			return;
		}
		window.location.href="dooropenlist?keyword="+keyword+"&page=1"+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date;
	})
	//清除条件
	$('.search_room #clear').click(function(){
		window.location.href="dooropenlist?keyword=&page=1"+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date;
	})
})
</script>
<script src='<?=base_url().'application/views/plugin/app/js/dooropen_list.js'?>'></script>
</body>
</html>
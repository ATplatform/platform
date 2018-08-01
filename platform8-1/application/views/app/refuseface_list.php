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
			
			<input type="text" class="search_start_date date col_37A fl form-control" name="push_start_date"> 
			<span class="fl col_37A">-</span>
			<input type="text" class="search_end_date date col_37A fl form-control" name="push_end_date"> 

			<a href="javascript:;" id="treeNav" class="treeWrap" style="margin-left: 10px;"><span></span></a>

			<div class="person_type_wrap select_pull_down query_wrap col_37A fl">
				<div>
					<input type="text" class="model_input person_type ka_input3" placeholder="用户类型" name="person_type" data-ajax="" readonly>
				</div>
				<div class="ka_drop">
					<div class="ka_drop_list">
					<ul>
						<li><a href="javascript:;" data-ajax="101">业主</a></li>
						<li><a href="javascript:;" data-ajax="102">商户</a></li>
						<li><a href="javascript:;" data-ajax="103">物业人员</a></li>
					</ul>
					</div>
				</div>
			</div>
			
			<div class="search_room msg_search_room">
				<p>
					<input type="text" class="searc_room_text" name="keyword" placeholder="可输入姓名搜索" value="">
					<a id="clear" href="javascript:;">X</a>
				</p>
				<button type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>
		
		<div class="table_wrap">
			<div class="oh pt10">
				<span class="sub_nav" style="display: block;">
					<a href="<?=base_url().'index.php/Permission/permissionfacelist'?>">人脸识别授权列表</a>
					<a href="<?=base_url().'index.php/Permission/applyfacelist'?>">待处理人脸识别申请(<span class="total"><?php echo $totals ?></span>条)</a>
					<a href="<?=base_url().'index.php/Permission/refusefacelist'?>" class="active">已拒绝人脸识别申请</a>
					<a class="fr add_btn" href="<?=base_url().'index.php/Permission/refusefacelist'?>">清除筛选</a>
				</span>
			</div>
			
			<table id="table"
					data-toolbar="#toolbar"	
			>
			<thead>
				<tr>
					<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
					<th data-field="code" data-title="申请编号" data-align="center"></th>
					<th data-field="full_name" data-title="申请人" data-align="center"></th>
					<th data-field="apply_date" data-title="发起申请时间" data-align="center"></th>
					<th data-field="full_name" data-title="授权用户" data-align="center"></th>
					<th data-field="person_type_name" data-title="用户类型" data-align="center"></th>
					<th data-field="building_name" data-title="申请授权地址" data-align="center" data-formatter="viewMore"></th>
					<th data-field="has_apply" data-title="已申请天数" data-align="center"></th>
					<th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>

		</div>

		<!--分页-->
		<ul class="pager" page='<?php echo $page ?>'>
		    <?php
		       $first=base_url().'index.php/Permission/refusefacelist?page=1&keyword='.$keyword.'&start_date='.$start_date.'&end_date='.$end_date.'&person_type='.$person_type.'&building_code='.$building_code;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/Permission/refusefacelist?page='.($page-1).'&keyword='.$keyword.'&start_date='.$start_date.'&end_date='.$end_date.'&person_type='.$person_type.'&building_code='.$building_code; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/Permission/refusefacelist?page='.($page+1).'&keyword='.$keyword.'&start_date='.$start_date.'&end_date='.$end_date.'&person_type='.$person_type.'&building_code='.$building_code;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/Permission/refusefacelist?page='.$total.'&keyword='.$keyword.'&start_date='.$start_date.'&end_date='.$end_date.'&person_type='.$person_type.'&building_code='.$building_code;
		    echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
		    echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
		    echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
		    ?>
		</ul>

	</div>

</div>

<!--查看详细-->
<div class="modal fade" id="content_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">人脸识别授权详情</h4>
	            </div>
	            <div class="modal-body building oh">
		            <p><span class="des">申请编号：</span>
		            	<span class="code col_37A"></span>
		            </p>
		            <p><span class="des">申&nbsp;&nbsp;请&nbsp;&nbsp;人：</span>
		            	<span class="apply_person_name col_37A" data-code=""></span>
		            </p>
		            <p><span class="des">申请时间：</span>
		            	<span class="apply_date col_37A"></span>
		            </p>
		            <p><span class="des">授权用户：</span>
		            	<span class="person col_37A" data-code=""></span>
		            </p>
		            <div class="oh col_37A img_wrap" style="padding-left: 80px;">
						<div class="fl tac old_img_wrap">
								<span>用户预留照片</span><br />
							    <img src="" width="120" height="130" class="old_img_url" />
						</div>
						<p class="fl tac" style="line-height: 148px;margin:0 40px;">匹配度:<span></span></p>
						<div class="fl tac">
								<span>录入的人脸识别照片</span><br />
								<img src="" width="120" height="130" class="img_url" />
						</div>
		            </div>
		            <p><span class="des">用户类型：</span>
		            	<span class="person_type_name col_37A" data-code=""></span>
		            </p>
		            <p style="line-height: 30px;"><span class="des">授权地址：</span>
		            	<span class="select_buliding" style="vertical-align: top;margin-left: 0px;">
							<!-- <em id="100480" data-room_code="100480">3栋201<i class="fa fa-close"></i></em><em id="100504" data-room_code="100504">2层<i class="fa fa-close"></i></em> -->
						</span>
		            </p>
		            <p><span class="des">开始日期：</span>
		            	<span class="begin_date col_37A"></span>
		            </p>
		            <p><span class="des">结束日期：</span>
		            	<span class="end_date col_37A"></span>
		            </p>
					<p>
						<span class="des">拒绝时间：</span>
		            	<span class="reject_date col_37A"></span>
					</p>
					<p>
						<span class="des">拒&nbsp;&nbsp;绝&nbsp;&nbsp;人：</span>
		            	<span class="reject_person_name col_37A"></span>
					</p>
					<p>
						<span class="des">拒绝原因：</span>
		            	<span class="reason col_37A"></span>
					</p>
	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_FFA refuse"  data-dismiss="modal">关闭</span>
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
// $('#content_detail').modal('show');
</script>
<script>
$(function(){
	var treeNav_data = <?php echo $treeNav_data?>;
	//树形菜单
	$('#treeNav>span').jstree({
		'core' : {
	        data: treeNav_data
	    }
	})
	var now = getDate();
	//上个月的今天--今天的已拒绝
	var lastMonthDate = getLastMonthYestdy();
	var today_begin = lastMonthDate ;
	var today_end = now;
	var page = getUrlParam('page');
	var search_keyword = getUrlParam('keyword');
	var search_start_date = getUrlParam('start_date');
	var search_end_date = getUrlParam('end_date');
	var search_person_type = getUrlParam('person_type');
	var search_building_code = getUrlParam('building_code');

	search_start_date = search_start_date?search_start_date:today_begin;
	search_end_date = search_end_date?search_end_date:today_end;
	//根据搜索内容给搜索框和筛选条件赋值
	$('.search_wrap .search_start_date').val(search_start_date);
	$('.search_wrap .search_end_date').val(search_end_date);
	$('.search_room .searc_room_text').val(search_keyword);
	//赋值用户类型
	switch(search_person_type){
		case '101':
			$('.search_wrap .person_type').val('业主');
			break;
		case '102':
			$('.search_wrap .person_type').val('商户');
			break;
		case '103':
			$('.search_wrap .person_type').val('物业人员');
			break;
		default:
			$('.search_wrap .person_type').val('用户类型');
			break;
	}

	$('#table').bootstrapTable({
		method: "get",
		undefinedText:' ',
		url:getRootPath()+'/index.php/Permission/getRefuseFaceList?page='+page+'&keyword='+search_keyword+"&start_date="+search_start_date+"&end_date="+search_end_date+'&person_type='+search_person_type+'&building_code='+search_building_code,
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
		window.location.href="refusefacelist?keyword="+search_keyword+"&page="+page+"&start_date="+search_start_date+"&end_date="+search_end_date+'&person_type='+search_person_type+'&building_code='+search_building_code;
	})
	//开始日期筛选
	$('#search_wrap .search_start_date').datetimepicker().on('changeDate',function(e){
		var startDate = $('#search_wrap .search_start_date').val();
		var endDate = $('#search_wrap .search_end_date').val();
		if(startDate>endDate){
			openLayer('开始时间必须小于结束时间!');
			$('#search_wrap .push_end_date').val(' ');
			return;
		}
		else{
		 	window.location.href="refusefacelist?keyword="+search_keyword+"&page="+page+"&start_date="+startDate+"&end_date="+endDate+'&person_type='+search_person_type+'&building_code='+search_building_code;
		}
	});
	//结束日期筛选
	$('#search_wrap .search_end_date').datetimepicker().on('changeDate',function(e){
		var startDate = $('#search_wrap .search_start_date').val();
		var endDate = $('#search_wrap .search_end_date').val();
		if(startDate>endDate){
			openLayer('开始时间必须小于结束时间!');
			$('#search_wrap .push_end_date').val(' ');
			return;
		}
		else{
		 	window.location.href="refusefacelist?keyword="+search_keyword+"&page="+page+"&start_date="+startDate+"&end_date="+endDate+'&person_type='+search_person_type+'&building_code='+search_building_code;
		}
	});
	//用户类型筛选
	$('.person_type_wrap .ka_drop_list li').click(function(){
		var person_type = $(this).find('a').data('ajax');
		window.location.href="refusefacelist?keyword="+search_keyword+"&page=1"+"&start_date="+search_start_date+"&end_date="+search_end_date+'&person_type='+person_type+'&building_code='+search_building_code;
	})
	//树形菜单点击筛选
	$('#treeNav>span').on("select_node.jstree", function (e, node) {
	  var building_code = node.node.original.code;
	  window.location.href="refusefacelist?keyword="+search_keyword+"&page=1"+"&start_date="+search_start_date+"&end_date="+search_end_date+'&person_type='+search_person_type+'&building_code='+building_code;
	})
	//点击搜索按钮,跳转
	$('.search_room button[type="submit"]').click(function(){
		var keyword = $('.search_room .searc_room_text').val();
		keyword = trim(keyword);
		if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
			openLayer('搜索框只能输入数字、汉字、字母!');
			return;
		}
		window.location.href="refusefacelist?keyword="+keyword+"&page=1"+"&start_date="+search_start_date+"&end_date="+search_end_date+'&person_type='+search_person_type+'&building_code='+search_building_code;
	})
	//清除条件
	$('.search_room #clear').click(function(){
		window.location.href="refusefacelist?page=1";
		window.location.href="refusefacelist?keyword=&page=1"+"&start_date="+search_start_date+"&end_date="+search_end_date+'&person_type='+search_person_type+'&building_code='+search_building_code;
	})
})
</script>
<script src='<?=base_url().'application/views/plugin/app/js/refuse_face.js'?>'></script>
</body>
</html>
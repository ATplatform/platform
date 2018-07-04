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
			<input type="text" class="effective_date date col_37A fl form-control" name="effective_date"> 
			
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
				<span class="sub_nav">
					<a href="<?=base_url().'index.php/Permission/permissionfacelist'?>">人脸识别授权列表</a>
					<a href="<?=base_url().'index.php/Permission/applyfacelist'?>" class="active">待处理人脸识别申请(29条)</a>
					<a href="<?=base_url().'index.php/Permission/refusefacelist'?>">已拒绝人脸识别申请</a>
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
					<th data-field="building_name" data-title="申请授权地址" data-align="center" data-formatter="viewAll"></th>
					<th data-field="status_name" data-title="状态" data-align="center"></th>
					<th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>

		</div>

		<!--分页-->
		<ul class="pager" page='<? $page ?>'>
		    <?php
		       $first=base_url().'index.php/Equipment/equipmentprivilegelist?page=1&keyword='.$keyword.'&effective_date='.$effective_date.'&person_type='.$person_type.'&building_code='.$building_code;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/Equipment/equipmentprivilegelist?page='.($page-1).'&keyword='.$keyword.'&effective_date='.$effective_date.'&person_type='.$person_type.'&building_code='.$building_code; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/Equipment/equipmentprivilegelist?page='.($page+1).'&keyword='.$keyword.'&effective_date='.$effective_date.'&person_type='.$person_type.'&building_code='.$building_code;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/Equipment/equipmentprivilegelist?page='.$total.'&keyword='.$keyword.'&effective_date='.$effective_date.'&person_type='.$person_type.'&building_code='.$building_code;
		    echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
		    echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
		    echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
		    ?>
		</ul>

	</div>

</div>

<!--查看详细并处理-->
<div class="modal fade" id="content_write" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">一卡通授权详情</h4>
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
						<div class="fl tac">
								<span>用户预留照片</span><br />
							    <img src="http://localhost/platform/upload/face_img/test.jpg" width="120" height="130" />
						</div>
						<p class="fl tac" style="line-height: 148px;margin:0 40px;">匹配度:85%</p>
						<div class="fl tac">
								<span>录入的人脸识别照片</span><br />
								<img src="" width="120" height="130" class="img_url" />
						</div>
		            </div>
		            <p><span class="des">用户类型：</span>
		            	<span class="person_type_name col_37A" data-code=""></span>
		            </p>
		            <p><span class="des">授权地址：</span>
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
					<p>拒绝原因：<input type="text" class="model_input reason" placeholder="如果不通过请输入拒绝原因" style="float: none;" name="reason"></p>
					<input type="hidden" value="" name="pic" class="pic" />
					<input type="hidden" value="" name="pos" class="pos" />
					<input type="hidden" value="" name="feat" class="feat" />
					<input type="hidden" value="" name="subject" class="subject" />
					<input type="hidden" value="" name="source_type" class="source_type" />
					<input type="hidden" value="" name="img_url" class="img_url" />
					<input type="hidden" value="" name="building_code" class="building_code" />
	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
            		<span class="col_37A save">通过</span>
                	<span class="col_FFA refuse">拒绝</span>
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
	var page = getUrlParam('page');
	var search_keyword = getUrlParam('keyword');
	var search_effective_date = getUrlParam('effective_date');
	var search_person_type = getUrlParam('person_type');
	var search_building_code = getUrlParam('building_code');

	search_effective_date = search_effective_date?search_effective_date:now;
	//根据搜索内容给搜索框和筛选条件赋值
	$('.effective_date').val(search_effective_date);
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
		undefinedText:'/',
		url:getRootPath()+'/index.php/Permission/getApplyFaceList?page='+page+'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code,
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
		window.location.href="personequipmentlist?keyword="+search_keyword+"&page="+page+"&effective_date="+search_effective_date+'&person_type='+search_equipment_type+'&building_code='+search_building_code;
	})
	//用户类型筛选
	$('.person_type_wrap .ka_drop_list li').click(function(){
		var person_type = $(this).find('a').data('ajax');
		window.location.href="accesscard?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&person_type='+person_type+'&building_code='+search_building_code;
	})
	//树形菜单点击筛选
	$('#treeNav>span').on("select_node.jstree", function (e, node) {
	  var building_code = node.node.original.code;
	  window.location.href="accesscard?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&person_type='+search_person_type+'&building_code='+building_code;
	})
	//点击搜索按钮,跳转
	$('.search_room button[type="submit"]').click(function(){
		var keyword = $('.search_room .searc_room_text').val();
		keyword = trim(keyword);
		window.location.href="accesscard?keyword="+keyword+"&page=1"+"&effective_date="+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code;
	})
	//清除条件
	$('.search_room #clear').click(function(){
		window.location.href="accesscard?page=1";
		window.location.href="accesscard?keyword=&page=1"+"&effective_date="+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code;
	})
})
</script>
<script>
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
  //当前对象为包裹层元素(这里是span)
  var that = $(this);
  console.log(node);
  //父节点数组
  var parents_arr = node.node.parents;
  if(parents_arr.length==3){
  	//表示到了室这一层级,需要获取到父节点,把父节点的名称拼接
  	var imm_id = parents_arr[0];
  	var imm_node = that.jstree("get_node", imm_id);
  	var imm_name = imm_node.text;
  }
  //表示是栋这一层级
  else if(parents_arr.length==2){

  }

  imm_name = imm_name?imm_name:'';
  var html_tmp = "<em id="+room_code+" data-room_code="+room_code+">"+imm_name+name+"<i class='fa fa-close'></i></em>";
  //选择楼宇赋值时不能重复且不能超过10个
  if(that.closest('.model_content').find('.select_buliding em').length<10){
  	if(that.closest('.model_content').find('.select_buliding #'+room_code).length==0){
  		 that.closest('.model_content').find('.select_buliding').append(html_tmp);
  	}
  }
})

$(function(){
	//点击删除当前节点
	$('.select_buliding_wrap').on('click','.select_buliding em i',function(){
		$(this).closest('em').remove();
	})
})
</script>
<script src='<?=base_url().'application/views/plugin/app/js/apply_face.js'?>'></script>
</body>
</html>
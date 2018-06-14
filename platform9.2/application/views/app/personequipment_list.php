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
	<div class="col-sm-12 main_wrap">
		<div class="searc_bar search_wrap" id="search_wrap">
			<span class="col_37A fl">筛选条件</span>
			<input type="text" class="effective_date date col_37A fl form-control" name="effective_date"> 
			
			<a href="javascript:;" id="treeNav" class="treeWrap" style="margin-left: 10px;"><span></span></a>

			<div class="equipment_type_wrap select_pull_down query_wrap col_37A fl">
				<div>
					<input type="text" class="model_input equipment_type ka_input3" placeholder="设备类型" name="equipment_type" data-ajax="" readonly>
				</div>
				<div class="sub_ka_drop" style="width: 120px;">
					<div class="ka_drop_list">
					<ul>
						<li class="first_nav"><a href="javascript:;" data-ajax="101">供配电系统</a></li>
						<li class="first_nav"><a href="javascript:;" data-ajax="102">电梯系统</a></li>
						<li class="first_nav"><a href="javascript:;" data-ajax="103">空调系统</a></li>
						<li class="first_nav"><a href="javascript:;" data-ajax="104">给排水系统</a></li>
						<li class="first_nav"><a href="javascript:;" data-ajax="105">消防系统</a></li>
						<li class="first_nav"><a href="javascript:;" data-ajax="106">停车场系统</a></li>
						<li class="first_nav"><a href="javascript:;" data-ajax="107">综合布线系统</a></li>
						<li class="subNavWrap"><a href="javascript:;" data-ajax="108">门禁对讲系统</a>
							<ul class="subNav">
								<li><a href="javascript:;" data-ajax="301">中心机</a></li>
								<li><a href="javascript:;" data-ajax="302">围墙机</a></li>
								<li><a href="javascript:;" data-ajax="303">单元门口机</a></li>
								<li><a href="javascript:;" data-ajax="304">别墅门口机</a></li>
								<li><a href="javascript:;" data-ajax="305">室内机</a></li>
								<li><a href="javascript:;" data-ajax="306">独立指纹机</a></li>
								<li><a href="javascript:;" data-ajax="307">魔镜</a></li>
							</ul>
						</li>
						<li class="first_nav"><a href="javascript:;" data-ajax="109">视频监控系统</a></li>
						<li class="first_nav"><a href="javascript:;" data-ajax="110">安防系统</a></li>
					</ul>
					</div>
				</div>
			</div>
			
			<div class="search_room msg_search_room">
				<p>
					<input type="text" class="searc_room_text" name="keyword" placeholder="可输入设备名称、授权住户、授权地址" value="">
					<a id="clear" href="javascript:;">X</a>
				</p>
				<button type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>
		
		<div class="table_wrap">
			<div class="oh pt10">
				<span class="fr add_btn" data-target="#add_content" data-toggle="modal">新增设备授权</span>
			</div>
			
			<table id="table"
					data-toolbar="#toolbar"	
			>
			<thead>
				<tr>
					<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
					<th data-field="equipment_type_name" data-title="设备类型" data-align="center"></th>
					<th data-field="equipment_code" data-title="设备编号" data-align="center"></th>
					<th data-field="name" data-title="设备名称" data-align="center"></th>
					<th data-field="pcs" data-title="数量" data-align="center"></th>
					<th data-field="building_name" data-title="授权楼宇" data-align="center" data-formatter="viewAll"></th>
					<th data-field="person_name" data-title="授权住户" data-align="center" data-formatter="viewAll"></th>
					<th data-field="begin_date" data-title="开始日期" data-align="center"></th>
					<th data-field="end_date" data-title="结束日期" data-align="center"></th>
					<th data-field="pe_remark" data-title="备注" data-align="center"></th>
					<th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>

		</div>

		<!--分页-->
		<ul class="pager" page='<? $page ?>'>
		    <?php
		       $first=base_url().'index.php/Equipment/personequipmentlist?page=1&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&regular_check='.$regular_check.'&building_code='.$building_code;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/Equipment/personequipmentlist?page='.($page-1).'&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&regular_check='.$regular_check.'&building_code='.$building_code; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/Equipment/personequipmentlist?page='.($page+1).'&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&regular_check='.$regular_check.'&building_code='.$building_code;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/Equipment/personequipmentlist?page='.$total.'&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&regular_check='.$regular_check.'&building_code='.$building_code;
		    echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
		    echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
		    echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
		    ?>
		</ul>

	</div>

</div>

<!--新增-->
<div class="modal fade" id="add_content" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">新增授权信息</h4>
	            </div>
	            <div class="modal-body building">

					<div class="search_person_wrap search_equipment_wrap">
						<div class="oh" style="margin-bottom:10px;">
							<div class="fl">
								<span class="red_star">*</span>授权设备：
							</div>
							<div class="fl search_person_text">
								<input type="text" class="fl search_person_name" placeholder="请输入设备名称查找" >
								<a class="fr search_person_btn"><i class="fa fa-search"></i></a>
							</div>
						</div>
						<div class="search_person_results">
								<!-- <div class="single_person" data-code="100007"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a><div class="fl"><span class="name">1000001</span><span class="eqip_name">室内机1211</span><span class="address">栋：3栋；室：201</span></div></div>				 -->
						</div>
						<div class="person_building_data">
							<ul>
								<!-- <li data-last_name="张"><span class="name">1000001</span><span class="eqip_name">室内机1211</span><span class="address">栋：3栋；室：201</span><i class="fa fa-close"></i></li> -->
							</ul>
						</div>
					</div>

					<div class="choose_equip_building">
						<p><span class="red_star">*</span>设备授权使用的住户：</p>
						<div style="padding-left: 90px;margin-bottom:10px;" class="select_buliding_wrap">
							<p>按楼宇选择批量住户：</p>
							<a href="javascript:;" id="treeNavAdd" class="treeWrap"><span></span></a>
							<span class="select_buliding">
							</span>
						</div>
						<div style="padding-left: 90px;" class="search_person_wrap search_person_only">
							<p>授权给单独的住户：</p>
							<div class="oh" style="margin-bottom:10px;">
								<div class="fl search_person_text">
									<input type="text" class="fl search_person_name" placeholder="请输入姓名查找" >
									<a class="fr search_person_btn"><i class="fa fa-search"></i></a>
								</div>
							</div>
							<div class="search_person_results" style="padding-left: 0px;">
									<!-- <div class="single_person" data-last_name="张" data-first_name="某某" data-code="100007"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a><div class="fl"><span class="name">张某某</span><span class="id_number">454444</span></div></div>				 -->
							</div>
							<div class="person_building_data" style="padding-left: 0px;">
								<ul>
									<!-- <li data-last_name="张" data_first_name="三" data-code="1004" data-household_type="101"><span>张三</span><span>421202199030474790</span></li> -->
								</ul>
							</div>
						</div>

					</div>
					
					<p><span class="red_star">*</span>开始日期：
						<input type="text" class="begin_date date form-control" name="begin_date">
					</p>

					<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;结束日期：
						<input type="text" class="end_date date form-control" name="end_date">
					</p>
					
					<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：<input type="text" class="model_input remark" placeholder="请输入备注" name="remark"></p>

	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_37A save">保存</span>
                	<span class="col_FFA cancle" data-dismiss="modal">取消</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!--详细-->
<div class="modal fade" id="content_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">设备授权详情</h4>
	            </div>
	            <div class="modal-body building oh">
		            <div class="fl person_wrap person_detail">
		            	<p><span>设备编号：</span>
		            		<span class="equipment_code col_37A"></span>
		            	</p>
		            	<p><span>设备类型：</span>
		            		<span class="equipment_type_name col_37A"></span>
		            	</p>
		            	<p><span>设备名称：</span>
		            		<span class="name col_37A"></span>
		            	</p>
		            	<p><span>设备数量：</span>
		            		<span class="pcs col_37A"></span>
		            	</p>
		            	<p><span>授权楼宇：</span>
		            		<span class="building_name col_37A"></span>
		            	</p>
		            </div>
		            <div class="fr person_wrap person_detail">
		            	<p><span>开始日期：</span>
		            		<span class="begin_date col_37A"></span>
		            	</p>
		            	<p><span>结束日期：</span>
		            		<span class="end_date col_37A"></span>
		            	</p>
		            	<p><span>备注：</span>
		            		<span class="remark col_37A"></span>
		            	</p>
		            	<p><span>授权住户：</span>
		            		<span class="person_name col_37A"></span>
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

<!--修改-->
<div class="modal fade" id="content_write" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">编辑授权设备</h4>
	            </div>
                <div class="modal-body building">
	                <p><span class="red_star">*</span>授权设备：
	                	<span class="equipment_name"></span>
	                </p>
                	<div class="choose_equip_building">
						<p><span class="red_star">*</span>设备授权使用的住户：</p>
						<div style="padding-left: 90px;margin-bottom:10px;" class="select_buliding_wrap">
							<p>按楼宇选择批量住户：</p>
							<a href="javascript:;" id="treeNavAdd" class="treeWrap"><span></span></a>
							<span class="select_buliding">
							</span>
						</div>
						<div style="padding-left: 90px;" class="search_person_wrap search_person_only">
							<p>授权给单独的住户：</p>
							<div class="oh" style="margin-bottom:10px;">
								<div class="fl search_person_text">
									<input type="text" class="fl search_person_name" placeholder="请输入姓名查找" >
									<a class="fr search_person_btn"><i class="fa fa-search"></i></a>
								</div>
							</div>
							<div class="search_person_results" style="padding-left: 0px;">
									<!-- <div class="single_person" data-last_name="张" data-first_name="某某" data-code="100007"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a><div class="fl"><span class="name">张某某</span><span class="id_number">454444</span></div></div>				 -->
							</div>
							<div class="person_building_data" style="padding-left: 0px;">
								<ul>
									<!-- <li data-last_name="张" data_first_name="三" data-code="1004" data-household_type="101"><span>张三</span><span>421202199030474790</span></li> -->
								</ul>
							</div>
						</div>

                	</div>
                	<p><span class="red_star">*</span>开始日期：
                		<input type="text" class="begin_date date form-control" name="begin_date">
                	</p>

                	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;结束日期：
                		<input type="text" class="end_date date form-control" name="end_date">
                	</p>
                	
                	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：<input type="text" class="model_input remark" placeholder="请输入备注" name="remark"></p>
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
// $('#content_write').modal('show');
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
	var page = getUrlParam('page');
	var search_keyword = getUrlParam('keyword');
	var search_effective_date = getUrlParam('effective_date');
	var search_equipment_type = getUrlParam('equipment_type');
	var search_regular_check = getUrlParam('regular_check');
	var search_building_code = getUrlParam('building_code');

	search_effective_date = search_effective_date?search_effective_date:now;
	var equipment_type_arr = [{'code':'101','name':'供配电系统'},{'code':'102','name':'电梯系统'},{'code':'103','name':'空调系统'},{'code':'104','name':'给排水系统'},{'code':'105','name':'消防系统'},{'code':'106','name':'停车场系统'},{'code':'107','name':'综合布线系统'},{'code':'108','name':'门禁对讲系统'},{'code':'109','name':'视频监控系统'},{'code':'110','name':'安防系统'},{'code':'301','name':'中心机'},{'code':'301','name':'中心机'},{'code':'302','name':'围墙机'},{'code':'303','name':'单元门口机'},{'code':'304','name':'别墅门口机'},{'code':'305','name':'室内机'},{'code':'306','name':'独立指纹机'},{'code':'307','name':'魔镜'}];
	var regular_check_arr = [{'code':'101','name':'不需要巡检'},{'code':'102','name':'每年一次'},{'code':'103','name':'每三个月一次'},{'code':'104','name':'每月一次'},{'code':'105','name':'每两周一次'},{'code':'106','name':'每周一次'},{'code':'107','name':'每三天一次'},{'code':'108','name':'每天一次'},{'code':'109','name':'每12小时一次'}];
	//根据搜索内容给搜索框和筛选条件赋值
	$('.effective_date').val(search_effective_date);
	$('.search_room .searc_room_text').val(search_keyword);
	//赋值设备类型
	for(var i=0;i<equipment_type_arr.length;i++){
		if(search_equipment_type==equipment_type_arr[i]['code']){
			$('.equipment_type').val(equipment_type_arr[i]['name']);
			break;
		}
		else{
			$('.equipment_type').val("设备类型");
		}
	}
	//赋值巡检周期
	for(var j=0;j<regular_check_arr.length;j++){
		if(search_regular_check==regular_check_arr[j]['code']){
			$('.regular_check').val(regular_check_arr[j]['name']);
			break;
		}
		else{
			$('.regular_check').val("巡检周期");
		}
	}


	$('#table').bootstrapTable({
		method: "get",
		undefinedText:'/',
		url:getRootPath()+'/index.php/Equipment/getPersoneEquipmentList?page='+page+'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code,
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
		window.location.href="personequipmentlist?keyword="+search_keyword+"&page="+page+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code;
	})
	//生效日期筛选
	$('.search_wrap .effective_date').datetimepicker().on('changeDate', function(ev){
        var date = $('.effective_date').val();
        window.location.href="personequipmentlist?keyword="+search_keyword+"&page=1"+"&effective_date="+date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code;
    })

    //树节点点击筛选
    $('#treeNav>span').on("select_node.jstree", function (e, node) {
      var building_code = node.node.original.code;
      window.location.href="personequipmentlist?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+building_code;
    })

	//设备类型筛选
	$('.equipment_type_wrap .first_nav,.equipment_type_wrap .subNav li').click(function(){
		var equipment_type = $(this).find('a').data('ajax');
		window.location.href="personequipmentlist?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code;
	})
	//巡检周期筛选
	$('.regular_check_wrap .ka_drop_list li').click(function(){
		var regular_check = $(this).find('a').data('ajax');
		window.location.href="personequipmentlist?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+regular_check+'&building_code='+search_building_code;
	})
	
	//点击搜索按钮,跳转
	$('.search_room button[type="submit"]').click(function(){
		var keyword = $('.search_room .searc_room_text').val();
		keyword = trim(keyword);
		window.location.href="personequipmentlist?keyword="+keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code;
	})
	//清除条件
	$('.search_room #clear').click(function(){
		window.location.href="personequipmentlist?page=1";
	})

})
function viewAll(value, row, index){
	if(value.length>20) {
	   return "<div style=\"\" title=''><p onclick=openLayer('"+value+"')>内容较多,请点击查看详情</p></div>";
	}
	else{
	   return "<div style=\"\">" +value+ "</div>";
	}
}
</script>
<script>
var treeNav_data = <?php echo $treeNav_data?>;
//新增物业关系楼宇层级树形菜单
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
  //当前对象为包裹层元素(这里是span)
  var that = $(this);
  
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
  if(that.closest('.model_content').find('.select_buliding #'+room_code).length==0){
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
<script src='<?=base_url().'application/views/plugin/app/js/personequipment_list.js'?>'></script>
</body>
</html>
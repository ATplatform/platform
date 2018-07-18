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
		
			<div class="equipment_type_wrap select_pull_down query_wrap col_37A fl">
				<div>
					<input type="text" class="model_input equipment_type ka_input3" placeholder="设备类型" name="equipment_type" data-ajax="" readonly>
				</div>
				<div class="sub_ka_drop">
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
					<input type="text" class="searc_room_text" name="keyword" placeholder="可输入设备名称、局域网IP" value="">
					<a id="clear" href="javascript:;">X</a>
				</p>
				<button type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>
		
		<div class="table_wrap">
			<div class="oh pt10">
				<span class="fr add_btn" data-target="#add_content" data-toggle="modal">新增设备通讯配置</span>
				<a class="fr add_btn" href="<?=base_url().'index.php/Equipment/equipmentconfig'?>">清除筛选</a>
			</div>
			
			<table id="table"
					data-toolbar="#toolbar"	
			>
			<thead>
				<tr>
					<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
					<th data-field="code" data-title="设备编号" data-align="center"></th>
					<th data-field="e_name" data-title="设备名称" data-align="center"></th>
					<th data-field="building_name" data-title="安装地点" data-align="center"></th>
					<th data-field="server_ip" data-title="服务器ip" data-align="center"></th>
					<th data-field="ip" data-title="公网ip" data-align="center"></th>
					<th data-field="lan_ip" data-title="局域网ip" data-align="center"></th>
					<th data-field="gateway" data-title="网关" data-align="center"></th>
					<th data-field="netmask" data-title="掩码" data-align="center"></th>
					<th data-field="dns1" data-title="DNS1" data-align="center"></th>
					<th data-field="dns2" data-title="DNS2" data-align="center"></th>
					<th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>

		</div>

		<!--分页-->
		<ul class="pager" page='<? $page ?>'>
		    <?php
		       $first=base_url().'index.php/Equipment/equipmentconfig?page=1&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&building_code='.$building_code;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/Equipment/equipmentconfig?page='.($page-1).'&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&building_code='.$building_code; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/Equipment/equipmentconfig?page='.($page+1).'&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&building_code='.$building_code;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/Equipment/equipmentconfig?page='.$total.'&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&building_code='.$building_code;
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
	                <h4 class="modal-title tac">新增设备网络配置</h4>
	            </div>
	            <div class="modal-body building">
	            	<div class="select_wrap select_pull_down select_equipment_code">
	            		<div><span class="red_star">*</span>设备：
	            			<input type="text" class="model_input equipment_code ka_input3" placeholder="请选择设备"  name="equipment_code"  data-ajax="" readonly />
	            		</div>
	            		<div class="ka_drop">
	            			<div class="ka_drop_list">
		            			<ul>
		            				
		            			</ul>
	            			</div>
	            		</div>
	            	</div>
					<p><span class="red_star">*</span>服务器ip：<input type="text" class="model_input severip" placeholder="请输入服务器ip" name="severip" /></p>
					<p><span class="red_star">*</span>公网ip：<input type="text" class="model_input ip" placeholder="请输入公网ip" name="ip" /></p>
					<p><span class="red_star">*</span>局域网ip：<input type="text" class="model_input lan_ip" placeholder="请输入局域网ip" name="lan_ip" /></p>
					<p><span class="red_star">*</span>网关：<input type="text" class="model_input gatewayip" placeholder="请输入网关" name="gatewayip" /></p>
					<p><span class="red_star">*</span>掩码：<input type="text" class="model_input netmask" placeholder="请输入掩码" name="netmask" /></p>
					<p><span style="margin-left:10px;">DNS1：</span><input type="text" class="model_input dns1" placeholder="请输入DNS1" name="dns1" /></p>
					<p><span style="margin-left:10px;">DNS2：</span><input type="text" class="model_input dns2" placeholder="请输入DNS2" name="dns2" /></p>
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
    <div class="modal-dialog"  style="width: 550px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">设备配置详情</h4>
	            </div>
	            <div class="modal-body building oh">
	            	<p><span class="des">设备编号：</span>
	            		<span class="code col_37A"></span>
	            	</p>
	            	<p><span class="des">服务器ip：&nbsp;</span>
	            		<span class="severip col_37A"></span>
	            	</p>
	            	<p><span class="des">公网ip：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	            		<span class="ip col_37A"></span>
	            	</p>
	            	<p><span class="des">局域网ip：&nbsp;</span>
	            		<span class="lan_ip col_37A"></span>
	            	</p>
	            	<p><span class="des">网关：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	            		<span class="gatewayip col_37A"></span>
	            	</p>
	            	<p><span class="des">掩码：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	            		<span class="netmask col_37A"></span>
	            	</p>
	            	<p><span class="des">DNS1：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	            		<span class="dns1 col_37A"></span>
	            	</p>
	            	<p><span class="des">DNS2：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	            		<span class="dns2 col_37A"></span>
	            	</p>
		            <p class="oh"><span class="des fl">二&nbsp;&nbsp;维&nbsp;&nbsp;码：</span>
		            	<span class="qr_code fl" style="margin-left: 8px;">
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

<!--修改-->
<div class="modal fade" id="content_write" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">编辑设备网络配置</h4>
	            </div>
                <div class="modal-body building">
					<p style="padding-left: 14px;"><span class="des">设备编号：</span>
						<span class="code col_37A" style="margin-left: 39px;"></span>
					</p>
					<p><span class="red_star">*</span>服务器ip：<input type="text" class="model_input severip" placeholder="请输入服务器ip" name="severip" /></p>
					<p><span class="red_star">*</span>公网ip：<input type="text" class="model_input ip" placeholder="请输入公网ip" name="ip" /></p>
					<p><span class="red_star">*</span>局域网ip：<input type="text" class="model_input lan_ip" placeholder="请输入局域网ip" name="lan_ip" /></p>
					<p><span class="red_star">*</span>网关：<input type="text" class="model_input gatewayip" placeholder="请输入网关" name="gatewayip" /></p>
					<p><span class="red_star">*</span>掩码：<input type="text" class="model_input netmask" placeholder="请输入掩码" name="netmask" /></p>
					<p><span style="margin-left:10px;">DNS1：</span><input type="text" class="model_input dns1" placeholder="请输入DNS1" name="dns1" /></p>
					<p><span style="margin-left:10px;">DNS2：</span><input type="text" class="model_input dns2" placeholder="请输入DNS2" name="dns2" /></p>
					<input type="hidden" class="tdcode_url" name="tdcode_url" value="" />
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
// $('#add_content').modal('show');
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
	var search_building_code = getUrlParam('building_code');

	search_effective_date = search_effective_date?search_effective_date:now;
	var equipment_type_arr = [{'code':'101','name':'供配电系统'},{'code':'102','name':'电梯系统'},{'code':'103','name':'空调系统'},{'code':'104','name':'给排水系统'},{'code':'105','name':'消防系统'},{'code':'106','name':'停车场系统'},{'code':'107','name':'综合布线系统'},{'code':'108','name':'门禁对讲系统'},{'code':'109','name':'视频监控系统'},{'code':'110','name':'安防系统'},{'code':'301','name':'中心机'},{'code':'301','name':'中心机'},{'code':'302','name':'围墙机'},{'code':'303','name':'单元门口机'},{'code':'304','name':'别墅门口机'},{'code':'305','name':'室内机'},{'code':'306','name':'独立指纹机'},{'code':'307','name':'魔镜'}];
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

	$('#table').bootstrapTable({
		method: "get",
		undefinedText:' ',
		url:getRootPath()+'/index.php/Equipment/getEquipmentConfig?page='+page+'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code,
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
		window.location.href="equipmentconfig?keyword="+search_keyword+"&page="+page+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code;
	})
	//生效日期筛选
	$('.search_wrap .effective_date').datetimepicker().on('changeDate', function(ev){
        var date = $('.effective_date').val();
        window.location.href="equipmentconfig?keyword="+search_keyword+"&page=1"+"&effective_date="+date+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code;
    })

    //树节点点击筛选
    $('#treeNav>span').on("select_node.jstree", function (e, node) {
      var building_code = node.node.original.code;
      window.location.href="equipmentconfig?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&building_code='+building_code;
    })

	//设备类型筛选
	$('.equipment_type_wrap .first_nav,.equipment_type_wrap .subNav li').click(function(){
		var equipment_type = $(this).find('a').data('ajax');
		window.location.href="equipmentconfig?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+equipment_type+'&building_code='+search_building_code;
	})
	//巡检周期筛选
	$('.regular_check_wrap .ka_drop_list li').click(function(){
		var regular_check = $(this).find('a').data('ajax');
		window.location.href="equipmentconfig?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code;
	})
	
	//点击搜索按钮,跳转
	$('.search_room button[type="submit"]').click(function(){
		var keyword = $('.search_room .searc_room_text').val();
		keyword = trim(keyword);
		if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
			openLayer('搜索框只能输入数字、汉字、字母!');
			return;
		}
		window.location.href="equipmentconfig?keyword="+keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code;
	})
	//清除条件
	$('.search_room #clear').click(function(){
		window.location.href="equipmentconfig?page=1";
	})


})
</script>
<script src='<?=base_url().'application/views/plugin/app/js/equipment_config.js'?>'></script>
</body>
</html>
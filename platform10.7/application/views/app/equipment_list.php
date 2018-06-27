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

			<div class="regular_check_wrap select_pull_down query_wrap col_37A fl" style="margin-left: 10px;">
				<div>
					<input type="text" class="model_input regular_check ka_input3" placeholder="巡检周期" name="regular_check" data-ajax="" readonly>
				</div>
				<div class="ka_drop" style="width: 120px;">
					<div class="ka_drop_list">
					<ul>
						<li><a href="javascript:;" data-ajax="101">不需要巡检</a></li>
						<li><a href="javascript:;" data-ajax="102">每年一次</a></li>
						<li><a href="javascript:;" data-ajax="103">每三个月一次</a></li>
						<li><a href="javascript:;" data-ajax="104">每月一次</a></li>
						<li><a href="javascript:;" data-ajax="105">每两周一次</a></li>
						<li><a href="javascript:;" data-ajax="106">每周一次</a></li>
						<li><a href="javascript:;" data-ajax="107">每三天一次</a></li>
						<li><a href="javascript:;" data-ajax="108">每天一次</a></li>
						<li><a href="javascript:;" data-ajax="109">每12小时一次</a></li>
					</ul>
					</div>
				</div>
			</div>
			
			
			<div class="search_room msg_search_room">
				<p>
					<input type="text" class="searc_room_text" name="keyword" placeholder="可输入设备名称、设备用途、内部编号、出厂编号" value="">
					<a id="clear" href="javascript:;">X</a>
				</p>
				<button type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>
		
		<div class="table_wrap">
			<div class="oh pt10">
				<span class="fr add_btn" data-target="#add_content" data-toggle="modal">新增设备</span>
			</div>
			
			<table id="table"
					data-toolbar="#toolbar"	
			>
			<thead>
				<tr>
					<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
					<th data-field="effective_date" data-title="生效日期" data-align="center"></th>
					<th data-field="e_name" data-title="设备名称" data-align="center"></th>
					<th data-field="pcs" data-title="数量" data-align="center"></th>
					<th data-field="equipment_type_name" data-title="设备类型" data-align="center"></th>
					<th data-field="building_name" data-title="安装地点" data-align="center" data-formatter="viewAll"></th>
					<th data-field="initial_no" data-title="内部编号" data-align="center"></th>
					<th data-field="function" data-title="设备用途" data-align="center"></th>
					<th data-field="production_date" data-title="生产日期" data-align="center"></th>
					<th data-field="regular_check_name" data-title="巡检周期" data-align="center"></th>
					<th data-field="if_se_name" data-title="是否特种设备" data-align="center"></th>
					<th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>

		</div>

		<!--分页-->
		<ul class="pager" page='<? $page ?>'>
		    <?php
		       $first=base_url().'index.php/Equipment/equipmentlist?page=1&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&regular_check='.$regular_check.'&building_code='.$building_code;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/Equipment/equipmentlist?page='.($page-1).'&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&regular_check='.$regular_check.'&building_code='.$building_code; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/Equipment/equipmentlist?page='.($page+1).'&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&regular_check='.$regular_check.'&building_code='.$building_code;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/Equipment/equipmentlist?page='.$total.'&keyword='.$keyword.'&effective_date='.$effective_date.'&equipment_type='.$equipment_type.'&regular_check='.$regular_check.'&building_code='.$building_code;
		    echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
		    echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
		    echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
		    ?>
		</ul>

	</div>

</div>

<!--新增-->
<div class="modal fade" id="add_content" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 890px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">新增设备</h4>
	            </div>
	            <div class="modal-body building">
	            	<div class="fl person_wrap">
						<p>&nbsp;&nbsp;&nbsp;&nbsp;设备编号：
							<span class="code" style="margin-left:26px;"></span>
						</p>
						<p><span class="red_star">*</span>生效日期：
							<input type="text" class="effective_date date form-control" name="effective_date" placeholder="请填写生效日期">
						</p>
						<p class="effective_status"><span class="red_star">*</span>状态：
							<span style="margin-left:45px;">
								<input type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked="">
								<label for="radio-1-1"></label>有效
							</span>

							<span class="fr">
								<input type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio">
								<label for="radio-1-2"></label>无效
							</span>
						</p>
						<p><span class="red_star">*</span>设备名称：
							<input type="text" class="model_input name" placeholder="请填写设备名称" name="name">
						</p>
						<p><span class="red_star">*</span>设备数量：
							<input type="text" class="model_input pcs" placeholder="请填写设备数量" name="pcs" value="1">
						</p>
						<div class="select_pull_down select_wrap select_equipment_type">
							<div>
								<span class="red_star">*</span>设备类型：
								<input type="text" class="model_input equipment_type ka_input3" placeholder="请选择设备类型" name="equipment_type" data-ajax="" readonly="">
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

						<div class="select_wrap select_pull_down select_building_code">
							<div><span class="red_star">*</span>安装地点：
								<input type="text" class="model_input building_code ka_input3" placeholder="请选择安装地点" name="building_code" data-ajax="" readonly>
							</div>
							<div class="ka_drop">
								<div class="ka_drop_list">
								<ul>
									
								</ul>
								</div>
							</div>
						</div>

						<p style="padding-left: 22px;">设备用途：
							<input type="text" class="ka_input3 function" name="function" placeholder="请填写设备用途" >
						</p>
						<p style="padding-left: 22px;">出厂编号：
							<input type="text" class="ka_input3 initial_no" name="initial_no" placeholder="请填写出厂编号" >
						</p>
						<p style="padding-left: 22px;">出厂型号：
							<input type="text" class="ka_input3 initial_model" name="initial_model" placeholder="请填写出厂型号">
						</p>
					</div>
					<div class="fr person_wrap">
						<p style="padding-left: 22px;">技术参数：
							<input type="text" class="ka_input3 tech_spec" name="tech_spec" placeholder="请填写技术参数">
						</p>
						<p style="padding-left: 22px;">生产厂家：
							<input type="text" class="ka_input3 supplier" name="supplier" placeholder="请填写生产厂家">
						</p>
						<p style="padding-left: 22px;">生产日期：
							<input type="text" class="date production_date form-control" name="production_date" placeholder="请填写生产日期">
						</p>
						<div class="select_pull_down select_wrap select_parent_code">
							<div>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;设备父节点：
								<input type="text" class="model_input parent_code ka_input3" placeholder="请选择设备父节点" name="parent_code" data-ajax="" readonly="">
							</div>
							<div class="ka_drop">
								<div class="ka_drop_list">
								<ul>

								</ul>
								</div>
							</div>
						</div>
						<div class="select_pull_down select_wrap select_regular_check">
							<div>
								<span class="red_star">*</span>巡检周期：
								<input type="text" class="model_input regular_check ka_input3" placeholder="请选择巡检周期" name="regular_check" data-ajax="" readonly>
							</div>
							<div class="ka_drop">
								<div class="ka_drop_list">
								<ul>
									<li><a href="javascript:;" data-ajax="101">不需要巡检</a></li>
									<li><a href="javascript:;" data-ajax="102">每年一次</a></li>
									<li><a href="javascript:;" data-ajax="103">每三个月一次</a></li>
									<li><a href="javascript:;" data-ajax="104">每月一次</a></li>
									<li><a href="javascript:;" data-ajax="105">每两周一次</a></li>
									<li><a href="javascript:;" data-ajax="106">每周一次</a></li>
									<li><a href="javascript:;" data-ajax="107">每三天一次</a></li>
									<li><a href="javascript:;" data-ajax="108">每天一次</a></li>
									<li><a href="javascript:;" data-ajax="109">每12小时一次</a></li>
								</ul>
								</div>
							</div>
						</div>
						<p><span class="red_star">*</span>巡检日期点：
							<input type="text" class="date regular_date form-control" name="regular_date" placeholder="请填写巡检日期点">
						</p>
						<div class="select_pull_down select_wrap select_position_name">
							<div>
								<span class="red_star">*</span>巡检人职位：
								<input type="text" class="model_input position_code ka_input3" placeholder="请选择巡检人职位" name="position_code" data-ajax="" readonly="">
							</div>
							<div class="ka_drop">
								<div class="ka_drop_list">
								<ul>

								</ul>
								</div>
							</div>
						</div>

						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>是否特种设备：
								<input type="text" class="model_input if_se ka_input3" name="if_se" data-ajax="false" value="否" readonly="">
							</div>
							<div class="ka_drop">
								<div class="ka_drop_list">
								<ul>
									<li><a href="javascript:;" data-ajax="false">否</a></li>
				                    <li><a href="javascript:;" data-ajax="true">是</a></li>
								</ul>
								</div>
							</div>
						</div>

						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>外审周期：
								<input type="text" class="model_input annual_check ka_input3" name="annual_check" data-ajax="101" value="不需要外审" readonly="">
							</div>
							<div class="ka_drop">
								<div class="ka_drop_list">
								<ul>
									<li><a href="javascript:;" data-ajax="101">不需要外审</a></li>
									<li><a href="javascript:;" data-ajax="102">每年一次</a></li>
								</ul>
								</div>
							</div>
						</div>

						<p><span class="red_star">*</span>外审日期点：
							<input type="text" class="date annual_date form-control" name="annual_date" placeholder="请填写外审日期点">
						</p>

						
					</div>
					<div class="clear"></div>
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
	                <h4 class="modal-title tac">设备详情</h4>
	            </div>
	            <div class="modal-body building oh">
		            <div class="fl person_wrap person_detail">
		            	<p><span class="des">设备编号：</span>
		            		<span class="code col_37A"></span>
		            	</p>
		            	<p><span class="des">生效日期：</span>
		            		<span class="effective_date col_37A"></span>
		            	</p>
		            	<p><span class="des">状态：</span>
		            		<span class="effective_status_name col_37A"></span>
		            	</p>
		            	<p><span class="des">设备名称：</span>
		            		<span class="name col_37A"></span>
		            	</p>
		            	<p><span class="des">设备数量：</span>
		            		<span class="pcs col_37A"></span>
		            	</p>
		            	<p><span class="des">设备类型：</span>
		            		<span class="equipment_type_name col_37A"></span>
		            	</p>
		            	<p><span class="des">安装地点：</span>
		            		<span class="building_name col_37A"></span>
		            	</p>
		            	<p><span class="des">设备用途：</span>
		            		<span class="function col_37A"></span>
		            	</p>
		            	<p><span class="des">出厂编号：</span>
		            		<span class="initial_no col_37A"></span>
		            	</p>
		            	<p><span class="des">出厂型号：</span>
		            		<span class="initial_model col_37A"></span>
		            	</p>
		            </div>
		            <div class="fr person_wrap person_detail">
		            	<p><span class="des">技术参数：</span>
		            		<span class="tech_spec col_37A"></span>
		            	</p>
		            	<p><span class="des">生产厂家：</span>
		            		<span class="supplier col_37A"></span>
		            	</p>
		            	<p><span class="des">生产日期：</span>
		            		<span class="production_date col_37A"></span>
		            	</p>
		            	<p><span class="des">设备父节点：</span>
		            		<span class="parent_code_name col_37A"></span>
		            	</p>
		            	<p><span class="des">巡检周期：</span>
		            		<span class="regular_check_name col_37A"></span>
		            	</p>
		            	<p><span class="des">巡检日期点：</span>
		            		<span class="regular_date col_37A"></span>
		            	</p>
		            	<p><span class="des">巡检人职位：</span>
		            		<span class="position_name col_37A"></span>
		            	</p>
		            	<p><span class="des">是否特种设备：</span>
		            		<span class="if_se_name col_37A"></span>
		            	</p>
		            	<p><span class="des">外审周期：</span>
		            		<span class="annual_check col_37A"></span>
		            	</p>
		            	<p><span class="des">外审日期点：</span>
		            		<span class="annual_date col_37A"></span>
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
    <div class="modal-dialog"  style="width: 890px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">编辑设备</h4>
	            </div>
                <div class="modal-body building">
                	<div class="fl person_wrap">
    					<p style="padding-left: 22px;"><span class="des">设备编号：</span>
    						<span class="code col_37A"></span>
    					</p>
    					<p style="padding-left: 22px;"><span class="des">生效日期：</span>
    						<span class="effective_date col_37A"></span>
    					</p>
    					<p style="padding-left: 22px;"><span class="des">状态：</span>
    						<span class="effective_status_name col_37A"></span>
    					</p>
    					<p><span class="red_star">*</span>设备名称：
    						<input type="text" class="model_input name" placeholder="请填写设备名称" name="name">
    					</p>
    					<p><span class="red_star">*</span>设备数量：
    						<input type="text" class="model_input pcs" placeholder="请填写设备数量" name="pcs" value="1">
    					</p>
    					<div class="select_pull_down select_wrap select_equipment_type">
    						<div>
    							<span class="red_star">*</span>设备类型：
    							<input type="text" class="model_input equipment_type ka_input3" placeholder="请选择设备类型" name="equipment_type" data-ajax="" readonly="">
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

    					<div class="select_wrap select_pull_down select_building_code">
    						<div><span class="red_star">*</span>安装地点：
    							<input type="text" class="model_input building_code ka_input3" placeholder="请选择安装地点" name="building_code" data-ajax="" readonly>
    						</div>
    						<div class="ka_drop">
    							<div class="ka_drop_list">
    							<ul>
    								
    							</ul>
    							</div>
    						</div>
    					</div>

    					<p style="padding-left: 22px;">设备用途：
    						<input type="text" class="ka_input3 function" name="function" placeholder="请填写设备用途" >
    					</p>
    					<p style="padding-left: 22px;">出厂编号：
    						<input type="text" class="ka_input3 initial_no" name="initial_no" placeholder="请填写出厂编号" >
    					</p>
    					<p style="padding-left: 22px;">出厂型号：
    						<input type="text" class="ka_input3 initial_model" name="initial_model" placeholder="请填写出厂型号">
    					</p>
    				</div>
    				<div class="fr person_wrap">
    					<p style="padding-left: 22px;">技术参数：
    						<input type="text" class="ka_input3 tech_spec" name="tech_spec" placeholder="请填写技术参数">
    					</p>
    					<p style="padding-left: 22px;">生产厂家：
    						<input type="text" class="ka_input3 supplier" name="supplier" placeholder="请填写生产厂家">
    					</p>
    					<p style="padding-left: 22px;">生产日期：
    						<input type="text" class="date production_date form-control" name="production_date" placeholder="请填写生产日期">
    					</p>
    					<div class="select_pull_down select_wrap select_parent_code">
    						<div>
    							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;设备父节点：
    							<input type="text" class="model_input parent_code ka_input3" placeholder="请选择设备父节点" name="parent_code" data-ajax="" readonly="">
    						</div>
    						<div class="ka_drop">
    							<div class="ka_drop_list">
    							<ul>

    							</ul>
    							</div>
    						</div>
    					</div>
    					<div class="select_pull_down select_wrap select_regular_check">
    						<div>
    							<span class="red_star">*</span>巡检周期：
    							<input type="text" class="model_input regular_check ka_input3" placeholder="请选择巡检周期" name="regular_check" data-ajax="" readonly>
    						</div>
    						<div class="ka_drop">
    							<div class="ka_drop_list">
    							<ul>
    								<li><a href="javascript:;" data-ajax="101">不需要巡检</a></li>
    								<li><a href="javascript:;" data-ajax="102">每年一次</a></li>
    								<li><a href="javascript:;" data-ajax="103">每三个月一次</a></li>
    								<li><a href="javascript:;" data-ajax="104">每月一次</a></li>
    								<li><a href="javascript:;" data-ajax="105">每两周一次</a></li>
    								<li><a href="javascript:;" data-ajax="106">每周一次</a></li>
    								<li><a href="javascript:;" data-ajax="107">每三天一次</a></li>
    								<li><a href="javascript:;" data-ajax="108">每天一次</a></li>
    								<li><a href="javascript:;" data-ajax="109">每12小时一次</a></li>
    							</ul>
    							</div>
    						</div>
    					</div>
    					<p><span class="red_star">*</span>巡检日期点：
    						<input type="text" class="date regular_date form-control" name="regular_date" placeholder="请填写巡检日期点">
    					</p>
    					<div class="select_pull_down select_wrap select_position_name">
    						<div>
    							<span class="red_star">*</span>巡检人职位：
    							<input type="text" class="model_input position_code ka_input3" placeholder="请选择巡检人职位" name="position_code" data-ajax="" readonly="">
    						</div>
    						<div class="ka_drop">
    							<div class="ka_drop_list">
    							<ul>

    							</ul>
    							</div>
    						</div>
    					</div>

    					<div class="select_wrap select_pull_down">
    						<div>
    							<span class="red_star">*</span>是否特种设备：
    							<input type="text" class="model_input if_se ka_input3" name="if_se" data-ajax="false" value="否" readonly="">
    						</div>
    						<div class="ka_drop">
    							<div class="ka_drop_list">
    							<ul>
    								<li><a href="javascript:;" data-ajax="false">否</a></li>
    			                    <li><a href="javascript:;" data-ajax="true">是</a></li>
    							</ul>
    							</div>
    						</div>
    					</div>

    					<div class="select_wrap select_pull_down">
    						<div>
    							<span class="red_star">*</span>外审周期：
    							<input type="text" class="model_input annual_check ka_input3" name="annual_check" data-ajax="101" value="不需要外审" readonly="">
    						</div>
    						<div class="ka_drop">
    							<div class="ka_drop_list">
    							<ul>
    								<li><a href="javascript:;" data-ajax="101">不需要外审</a></li>
    								<li><a href="javascript:;" data-ajax="102">每年一次</a></li>
    							</ul>
    							</div>
    						</div>
    					</div>

    					<p><span class="red_star">*</span>外审日期点：
    						<input type="text" class="date annual_date form-control" name="annual_date" placeholder="请填写外审日期点">
    					</p>

    					
    				</div>
    				<div class="clear"></div>
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
	var search_regular_check = getUrlParam('regular_check');
	var search_building_code = getUrlParam('building_code');

	search_effective_date = search_effective_date?search_effective_date:now;
	var equipment_type_arr = [{'code':'101','name':'供配电系统'},{'code':'102','name':'电梯系统'},{'code':'103','name':'空调系统'},{'code':'104','name':'给排水系统'},{'code':'105','name':'消防系统'},{'code':'106','name':'停车场系统'},{'code':'107','name':'综合布线系统'},{'code':'108','name':'门禁对讲系统'},{'code':'109','name':'视频监控系统'},{'code':'110','name':'安防系统'},{'code':'301','name':'中心机'},{'code':'301','name':'中心机'},{'code':'302','name':'围墙机'},{'code':'303','name':'单元门口机'},{'code':'304','name':'别墅门口机'},{'code':'305','name':'室内机'},{'code':'306','name':'独立指纹机'},{'code':'307','name':'魔镜'}];
	var regular_check_arr = [{'code':'101','name':'不需要巡检'},{'code':'102','name':'每年一次'},{'code':'103','name':'每三个月一次'},{'code':'104','name':'每月一次'},{'code':'105','name':'每两周一次'},{'code':'106','name':'每周一次'},{'code':'107','name':'每三天一次'},{'code':'108','name':'每天一次'},{'code':'109','name':'每12小时一次'}];
	//树形图筛选状态改变
	/*if(search_building_code){
		$('.treeWrap>span').addClass('active');
	}
	else{
		$('.treeWrap>span').removeClass('active');
	}*/
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
		url:getRootPath()+'/index.php/Equipment/getEquipmentList?page='+page+'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code,
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
		window.location.href="equipmentlist?keyword="+search_keyword+"&page="+page+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code;
	})
	//生效日期筛选
	$('.search_wrap .effective_date').datetimepicker().on('changeDate', function(ev){
        var date = $('.effective_date').val();
        window.location.href="equipmentlist?keyword="+search_keyword+"&page=1"+"&effective_date="+date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code;
    })

    //树节点点击筛选
    $('#treeNav>span').on("select_node.jstree", function (e, node) {
      var building_code = node.node.original.code;
      window.location.href="equipmentlist?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+building_code;
    })

	//设备类型筛选
	$('.equipment_type_wrap .first_nav,.equipment_type_wrap .subNav li').click(function(){
		var equipment_type = $(this).find('a').data('ajax');
		window.location.href="equipmentlist?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code;
	})
	//巡检周期筛选
	$('.regular_check_wrap .ka_drop_list li').click(function(){
		var regular_check = $(this).find('a').data('ajax');
		window.location.href="equipmentlist?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+regular_check+'&building_code='+search_building_code;
	})
	
	//点击搜索按钮,跳转
	$('.search_room button[type="submit"]').click(function(){
		var keyword = $('.search_room .searc_room_text').val();
		keyword = trim(keyword);
		if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
			openLayer('搜索框只能输入数字、汉字、字母!');
			return;
		}
		window.location.href="equipmentlist?keyword="+keyword+"&page=1"+"&effective_date="+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code;
	})
	//清除条件
	$('.search_room #clear').click(function(){
		window.location.href="equipmentlist?page=1";
	})


})
</script>
<script src='<?=base_url().'application/views/plugin/app/js/equipment_list.js'?>'></script>
</body>
</html>
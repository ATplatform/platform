<div class="leftNav col-sm-12 pl0 pr0 ml0 mr0">
	<ul id="main-nav" class="nav nav-tabs nav-stacked" style="">

	<li>
		<a href="#BuildingSetting" class="nav-header " data-toggle="collapse"
			<?php if($nav=="buildingtree"||$nav=="buildinglist") {echo 'aria-expanded="true"';} ?> 
		>
		<i class="icon fa fa-building"></i>
			楼宇管理
			<span class="pull-right fa fa-angle-right"></span> 
		</a>
		<ul id="BuildingSetting" 
			<?php 
				if($nav=="buildingtree"||$nav=="buildinglist"){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>社区信息管理</a></li>
			<li <?php if($nav=="buildingtree"||$nav=="buildinglist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Building/buildingtree'?>"><i class="glyphicon"></i>楼宇关系管理</a></li>
		</ul>
	</li>

	<li>
		<a href="#systemSetting" class="nav-header " data-toggle="collapse"
			<?php if($nav=="residentlist") {echo 'aria-expanded="true"';} ?> 
		>
		<i class="icon fa fa-user-circle"></i>
			人员管理
			<span class="pull-right fa fa-angle-right"></span> 
		</a>
		<ul id="systemSetting" 
			<?php 
				if($nav=="residentlist"||$nav=="managementlist"||$nav=="businesslist"){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li <?php if($nav=="residentlist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/People/residentlist'?>"><i class="glyphicon"></i>住户信息管理</a></li>
			<li <?php if($nav=="managementlist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/People/managementlist'?>"><i class="glyphicon"></i>物业人员管理</a></li>
			<li <?php if($nav=="businesslist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/People/businesslist'?>"><i class="glyphicon"></i>商户人员管理</a></li>
		</ul>
	</li>

	<li>
		<a href="#EquipmentSetting" class="nav-header " data-toggle="collapse"
			<?php if($nav=="equipmentlist"||$nav=="personequipmentlist") {echo 'aria-expanded="true"';} ?> 
		>
		<i class="icon fa fa-archive"></i>
			设备管理
			<span class="pull-right fa fa-angle-right"></span> 
		</a>
		<ul id="EquipmentSetting" 
			<?php 
				if($nav=="equipmentlist"||$nav=="personequipmentlist"){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>设备运营分析</a></li>
			<li <?php if($nav=="equipmentlist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>设备管理列表</a></li>
			<li <?php if($nav=="personequipmentlist") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>设备授权管理</a></li>
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>设备状态管理</a></li>
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>设备维保管理</a></li>
		</ul>
	</li>

	<li>
	    <a href="#Workorder" class="nav-header " data-toggle="collapse"
	        <?php if($nav=="workorderList") {echo 'aria-expanded="true"';} ?>
	    >

	        <i class="icon fa fa-file"></i>
	        工单管理
	        <span class="pull-right fa fa-angle-right"></span>
	    </a>
	    <ul id="Workorder"
	        <?php
	        if($nav=="workorderList"){
	            echo 'class="collapse secondmenu in"';
	        }
	        else{
	            echo 'class="collapse secondmenu"';
	        }
	        ?>
	        aria-expanded="true" >
	        <li <?php if($nav=="workorderList") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>工单记录</a></li>

	    </ul>
	</li>

	<li>
		<a href="#MessageSetting" class="nav-header " data-toggle="collapse"
			<?php if($nav=="messagelist") {echo 'aria-expanded="true"';} ?> 
		>
		<i class="icon fa fa-envelope"></i>
			信息管理
			<span class="pull-right fa fa-angle-right"></span> 
		</a>
		<ul id="MessageSetting" 
			<?php 
				if($nav=="messagelist"||$nav=="messagerecordlist"){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li <?php if($nav=="messagelist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>信息条目管理</a></li>
			<li <?php if($nav=="messagerecordlist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>信息记录管理</a></li>
		</ul>
	</li>

	<li>
		<a href="#VehicleSetting" class="nav-header " data-toggle="collapse"
		>
		<i class="icon fa fa-car"></i>
			停车管理
			<span class="pull-right fa fa-angle-right"></span> 
		</a>
		<ul id="VehicleSetting" 
			<?php 
				if($nav=="vehiclelist"){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li <?php if($nav=="vehiclelist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>车辆信息管理</a></li>
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>车辆进出记录</a></li>
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>车辆缴费记录</a></li>
		</ul>
	</li>

	<li>
		<a href="#FinanceSetting" class="nav-header " data-toggle="collapse"
		>
		<i class="icon fa fa-money"></i>
			财务管理
			<span class="pull-right fa fa-angle-right"></span> 
		</a>
		<ul id="FinanceSetting" 
			<?php 
				if($nav=="vehiclelist"){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>社区经营分析</a></li>
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>车辆缴费管理</a></li>
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>物业费缴费管理</a></li>
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>其他费用缴费管理</a></li>
		</ul>
	</li>

	<li>
	    <a href="#material" class="nav-header " data-toggle="collapse"
	        <?php if($nav=="materialList") {echo 'aria-expanded="true"';} ?>
	    >

	        <i class="icon fa fa-gift"></i>
	        物资管理
	        <span class="pull-right fa fa-angle-right"></span>
	    </a>
	    <ul id="material"
	        <?php
	        if($nav=="materialList"||$nav=="materialUsage"){
	            echo 'class="collapse secondmenu in"';
	        }
	        else{
	            echo 'class="collapse secondmenu"';
	        }
	        ?>
	        aria-expanded="true" >
	        <li <?php if($nav=="materialList") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>物资列表</a></li>
	        <li <?php if($nav=="materialUsage") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>物资使用管理</a></li>
	    </ul>
	</li>

	<li>
	    <a href="#ContractSetting" class="nav-header " data-toggle="collapse"
	        <?php if($nav=="contractList") {echo 'aria-expanded="true"';} ?>
	    >

	        <i class="icon fa fa-reorder"></i>
	        合同管理
	        <span class="pull-right fa fa-angle-right"></span>
	    </a>
	    <ul id="ContractSetting"
	        <?php
	        if($nav=="contractList"){
	            echo 'class="collapse secondmenu in"';
	        }
	        else{
	            echo 'class="collapse secondmenu"';
	        }
	        ?>
	        aria-expanded="true" >
	        <li <?php if($nav=="contractList") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>合同管理列表</a></li>
	    </ul>
	</li>

	<li>
	    <a href="#ActivitySetting" class="nav-header " data-toggle="collapse"
	        <?php if($nav=="activityList") {echo 'aria-expanded="true"';} ?>
	    >

	        <i class="icon fa fa-font-awesome"></i>
	        住户活动管理
	        <span class="pull-right fa fa-angle-right"></span>
	    </a>
	    <ul id="ActivitySetting"
	        <?php
	        if($nav=="activityList"){
	            echo 'class="collapse secondmenu in"';
	        }
	        else{
	            echo 'class="collapse secondmenu"';
	        }
	        ?>
	        aria-expanded="true" >
	        <li <?php if($nav=="activityList") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>住户活动圈</a></li>
	        <li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>住户活动管理</a></li>
	    </ul>
	</li>

	<li>
	    <a href="#FunctionSetting" class="nav-header " data-toggle="collapse"
	        <?php if($nav=="activityList") {echo 'aria-expanded="true"';} ?>
	    >

	        <i class="icon fa fa-shopping-cart"></i>
	        应用管理
	        <span class="pull-right fa fa-angle-right"></span>
	    </a>
	    <ul id="FunctionSetting"
	        <?php
	        if($nav=="functionList"){
	            echo 'class="collapse secondmenu in"';
	        }
	        else{
	            echo 'class="collapse secondmenu"';
	        }
	        ?>
	        aria-expanded="true" >
	        <li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>二维码打印</a></li>
	    </ul>
	</li>

</ul>
</div>
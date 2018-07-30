<div class="leftNav col-sm-12 pl0 pr0 ml0 mr0">
	<ul id="main-nav" class="nav nav-tabs nav-stacked" style="">

	<li>
		<a href="#BuildingSetting" class="nav-header " data-toggle="collapse"
			<?php if($nav=="buildingtree"||$nav=="buildinglist" || $nav=="villageInfo" ) {echo 'aria-expanded="true"';} ?>
		>
		<i class="icon fa fa-building"></i>
			楼宇管理
			<span class="pull-right fa fa-angle-right"></span> 
		</a>
		<ul id="BuildingSetting" 
			<?php 
				if($nav=="buildingtree"||$nav=="buildinglist" || $nav=="villageInfo"){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li <?php if($nav=="villageInfo") {echo 'class="active"';}  ?>><a href="<?=base_url().'index.php/Building/villageInfo'?>"><i class="glyphicon"></i>社区信息管理</a></li>
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
				if($nav=="residentlist"||$nav=="managementlist"||$nav=="businesslist"||$nav=="visitorlist"){
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
			<li <?php if($nav=="visitorlist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/People/visitorlist'?>"><i class="glyphicon"></i>访客管理</a></li>
		</ul>
	</li>

	<li>
		<a href="#EquipmentSetting" class="nav-header " data-toggle="collapse"
			<?php if($nav=="equipmentlist"||$nav=="personequipmentlist"||$nav=="equipmentstatus"||$nav=="equipmentservice") {echo 'aria-expanded="true"';} ?> 
		>
		<i class="icon fa fa-archive"></i>
			设备管理
			<span class="pull-right fa fa-angle-right"></span> 
		</a>
		<ul id="EquipmentSetting" 
			<?php 
				if($nav=="equipmentlist"||$nav=="personequipmentlist"||$nav=="equipmentstatus"||$nav=="equipmentservice"){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li><a href="<?=base_url().'index.php/Building/notfond'?>"><i class="glyphicon"></i>设备运营分析</a></li>
			<li <?php if($nav=="equipmentlist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Equipment/equipmentlist'?>"><i class="glyphicon"></i>设备管理列表</a></li>
			<li <?php if($nav=="personequipmentlist") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Equipment/personequipmentlist'?>"><i class="glyphicon"></i>设备授权管理</a></li>
			<li <?php if($nav=="equipmentstatus") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Equipment/equipmentstatus'?>"><i class="glyphicon"></i>设备工作状态</a></li>
			<li <?php if($nav=="equipmentservice") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Equipment/equipmentservice'?>"><i class="glyphicon"></i>设备维保管理</a></li>
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
	        <li <?php if($nav=="workorderList") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Workorder/workorderList'?>"><i class="glyphicon"></i>工单记录</a></li>

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
			<li <?php if($nav=="messagelist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Message/messagelist'?>"><i class="glyphicon"></i>信息条目管理</a></li>
			<li <?php if($nav=="messagerecordlist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Message/messagerecordlist'?>"><i class="glyphicon"></i>信息记录管理</a></li>
		</ul>
	</li>

	<li>
	    <a href="#PrivilegeSetting" class="nav-header " data-toggle="collapse"
	        <?php if($nav=="equipmentprivilegelist"||$nav=="accesscard"||$nav=="permissionfacelist"||$nav=="dooropenlist"||$nav=="videoitclist"||$nav=="equipmentconfig") {echo 'aria-expanded="true"';} ?>
	    >

	        <i class="icon fa fa-address-card"></i>
	        门禁对讲管理
	        <span class="pull-right fa fa-angle-right"></span>
	    </a>
	    <ul id="PrivilegeSetting"
	        <?php
	        if($nav=="equipmentprivilegelist"||$nav=="accesscard"||$nav=="permissionfacelist"||$nav=="dooropenlist"||$nav=="videoitclist"||$nav=="equipmentconfig"){
	            echo 'class="collapse secondmenu in"';
	        }
	        else{
	            echo 'class="collapse secondmenu"';
	        }
	        ?>
	        aria-expanded="true" >
	        <li <?php if($nav=="equipmentconfig") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Equipment/equipmentconfig'?>"><i class="glyphicon"></i>对讲通讯配置</a></li>
	        <li <?php if($nav=="equipmentprivilegelist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Equipment/equipmentprivilegelist'?>"><i class="glyphicon"></i>门禁对讲授权</a></li>
	        <li <?php if($nav=="accesscard") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Permission/accesscard'?>"><i class="glyphicon"></i>一卡通授权</a></li>
	        <li <?php if($nav=="permissionfacelist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Permission/permissionfacelist'?>"><i class="glyphicon"></i>人脸识别授权</a></li>
	        <li ><a href=""><i class="glyphicon"></i>用户权限列表</a></li>
	        <li <?php if($nav=="dooropenlist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Permission/dooropenlist'?>"><i class="glyphicon"></i>开门记录</a></li>
	        <li <?php if($nav=="videoitclist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Permission/videoitclist'?>"><i class="glyphicon"></i>对讲记录</a></li>
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
				if($nav=="vehicleList" || $nav=="vehicleAuz" || $nav=="parkinglot" || $nav=="vehiclePkg" || $nav=="vehiclePayment" ){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li <?php if($nav=="vehicleList") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Vehicle/vehicleList'?>"><i class="glyphicon"></i>车辆管理列表</a></li>
            <li <?php if($nav=="vehicleAuz") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Vehicle/vehicleAuz'?>"><i class="glyphicon"></i>车辆授权信息</a></li>
            <li <?php if($nav=="parkinglot") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Vehicle/parkinglot'?>"><i class="glyphicon"></i>小区车位管理</a></li>
			<li <?php if($nav=="vehiclePkg") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Vehicle/vehiclePkg'?>"><i class="glyphicon"></i>车辆进出记录</a></li>

		</ul>
	</li>

	<li>
		<a href="#FinanceSetting" class="nav-header " data-toggle="collapse"
		>
		<i class="icon fa fa-money"></i>
			收费管理
			<span class="pull-right fa fa-angle-right"></span> 
		</a>
		<ul id="FinanceSetting" 
			<?php 
				if($nav=="Parkrent"  || $nav=="property_fee" || $nav=="pkg_fee" || $nav=="water_fee" || $nav=="service_fee"||$nav=="order_fee"||$nav=="bill_list"||$nav=="notice_list"){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li <?php if($nav=="Parkrent") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/ParkRent/Parkrent'?>"><i class="glyphicon"></i>车位租赁管理</a></li>
			<li <?php if($nav=="property_fee") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Moneypay/property_fee'?>"><i class="glyphicon"></i>物业费管理</a></li>
            <li <?php if($nav=="pkg_fee") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Moneypay/pkg_fee'?>"><i class="glyphicon"></i>车位服务费管理</a></li>
            <li <?php if($nav=="water_fee") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Moneypay/water_fee'?>"><i class="glyphicon"></i>供水加压费管理</a></li>
            <li <?php if($nav=="order_fee") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Moneypay/order_fee'?>"><i class="glyphicon"></i>物业增值服务管理</a></li>
            <li <?php if($nav=="service_fee") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Moneypay/service_fee'?>"><i class="glyphicon"></i>服务收费标准管理</a></li>
            <li <?php if($nav=="bill_list") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Moneypay/bill_list'?>"><i class="glyphicon"></i>账单管理页面</a></li>
            <li <?php if($nav=="notice_list") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Moneypay/notice_list'?>"><i class="glyphicon"></i>恶意欠费催缴</a></li>
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
	        <li <?php if($nav=="materialList") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Material/materialList'?>"><i class="glyphicon"></i>物资列表</a></li>
	        <li <?php if($nav=="materialUsage") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Material/materialUsage'?>"><i class="glyphicon"></i>物资使用管理</a></li>
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
	        <li <?php if($nav=="contractList") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Contract/contractList'?>"><i class="glyphicon"></i>合同管理列表</a></li>
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
	        if($nav=="activityList"||$nav=="activityRecord"){
	            echo 'class="collapse secondmenu in"';
	        }
	        else{
	            echo 'class="collapse secondmenu"';
	        }
	        ?>
	        aria-expanded="true" >
	        <li <?php if($nav=="activityList") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Activity/activityList'?>"><i class="glyphicon"></i>住户活动圈</a></li>
	        <li <?php if($nav=="activityRecord") {echo 'class="active"';} ?>><a href="<?=base_url().'index.php/Activity/activityRecord'?>"><i class="glyphicon"></i>住户活动管理</a></li>
	    </ul>
	</li>

	<li>
	    <a href="#FunctionSetting" class="nav-header " data-toggle="collapse"
	        <?php if($nav=="tdcodepath"||$nav=="import_data") {echo 'aria-expanded="true"';} ?>
	    >

	        <i class="icon fa fa-shopping-cart"></i>
	        应用管理
	        <span class="pull-right fa fa-angle-right"></span>
	    </a>
	    <ul id="FunctionSetting"
	        <?php
	        if($nav=="tdcodepath"||$nav=="import_data"){
	            echo 'class="collapse secondmenu in"';
	        }
	        else{
	            echo 'class="collapse secondmenu"';
	        }
	        ?>
	        aria-expanded="true" >
	        <li <?php if($nav=="tdcodepath") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Main/tdcodepath'?>"><i class="glyphicon"></i>二维码打印</a></li>
	        <li <?php if($nav=="import_data") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/Import/importData'?>"><i class="glyphicon"></i>数据导入与生成</a></li>
	    </ul>
	</li>

</ul>
</div>
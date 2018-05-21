<div class="col-md-2 col-xm-3 pl0 pr0 ml0 mr0">
	<ul id="main-nav" class="nav nav-tabs nav-stacked" style="">
	<li <?php if($nav=="buildingtree"||$nav=="buildinglist") {echo 'class="active"';} ?> >
		<a href="<?=base_url().'index.php/Building/buildingtree'?>" >
			<i class="icon fa fa-building"></i>
			楼宇管理
			<span class="pull-right fa fa-chevron-right"></span>
		</a>
	</li>
	<li>
		<a href="#systemSetting" class="nav-header " data-toggle="collapse"
			<?php if($nav=="residentlist") {echo 'aria-expanded="true"';} ?> 
		>
		<i class="icon fa fa-user-circle"></i>
			人员管理
			<span class="pull-right fa fa-chevron-down"></span> 
		</a>
		<ul id="systemSetting" 
			<?php 
				if($nav=="residentlist"||$nav=="managementlist"){
					echo 'class="collapse secondmenu in"';
				} 
				else{
					echo 'class="collapse secondmenu"';
				} 
			?>   
		aria-expanded="true" >
			<li <?php if($nav=="residentlist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/People/residentlist'?>"><i class="glyphicon"></i>住户信息管理</a></li>
			<li <?php if($nav=="managementlist") {echo 'class="active"';} ?> ><a href="<?=base_url().'index.php/People/managementlist'?>"><i class="glyphicon"></i>物业人员管理</a></li>
		</ul>
	</li>
	<li>
		<a href="">
		<i class="icon fa fa-archive"></i>
			设备管理 
			<span class="pull-right fa fa-chevron-right"></span> 
		<!-- <span class="label label-warning pull-right">5</span> -->
		</a>
	</li>
	<li>
		<a href="">
			<i class="icon fa fa-gift"></i>
			物资管理
			<span class="pull-right fa fa-chevron-right"></span> 
		</a>
	</li>
	<li>
		<a href="#">
			<i class="icon fa fa-file"></i>
			工单管理
			<span class="pull-right fa fa-chevron-right"></span> 
		</a>
	</li>
	<li>
		<a href="#">
			<i class="icon fa fa-envelope"></i>
			信息管理
			<span class="pull-right fa fa-chevron-right"></span> 
		</a>
	</li>
	<li>
		<a href="#">
			<i class="icon fa fa-car"></i>
			车辆管理
			<span class="pull-right fa fa-chevron-right"></span> 
		</a>
	</li>
	<li>
		<a href="#">
			<i class="icon fa fa-font-awesome"></i>
			业主活动管理
			<span class="pull-right fa fa-chevron-right"></span> 
		</a>
	</li>
	<li>
		<a href="#">
			<i class="icon fa fa-shopping-cart"></i>
			应用管理
			<span class="pull-right fa fa-chevron-right"></span> 
		</a>
	</li>
</ul>
</div>
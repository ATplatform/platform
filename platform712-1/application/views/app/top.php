<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-3.3.5/css/bootstrap.css'?>'/>
	<!-- 新引入字体图标,比bootstrap的更全 -->
	<link rel="stylesheet" href='<?=base_url().'application/views/plugin/font-awesome-4.7.0/css/font-awesome.min.css'?>'/>
	<link rel="stylesheet" href='<?=base_url().'application/views/plugin/app/css/style.css'?>'/>
	<script src='<?=base_url().'application/views/plugin/app/js/jquery2.1.1.js'?>'></script>
	<script src='<?=base_url().'application/views/plugin/bootstrap-3.3.5/js/bootstrap.min.js'?>'></script>
	<script src='<?=base_url().'application/views/plugin/layer/layer.js'?>'></script>
	<script src='<?=base_url().'application/views/plugin/app/js/common.js'?>'></script>
	<title>艾特智能AI社区云平台</title>
</head>
<body>
<div class="header oh">
	<div class="fl logo">
		<i></i>艾特智能AI社区云平台
	</div>
	<div class="top_login_wrap fr">
		<span class="user"><i></i><?php echo $username ?></span>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $at_url ?>Village/selectVillage">切换管理小区</a>&nbsp;&nbsp;|&nbsp;&nbsp;
		<a class="login_out" href="<?=base_url().'index.php/Login/logout'?>">退出登录</a>
	</div>
</div>
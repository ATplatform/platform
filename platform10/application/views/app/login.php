<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href='<?=base_url().'application/views/plugin/app/css/style.css'?>'/>
	<title>用户登录</title>
</head>
<body class="bg_f4f">
<div class="login_wrap">
	<div class="logo fl">
		<span></span>
		<p>欢迎使用</p>
		<p>艾特智能AI社区云平台</p>
	</div>
	<form class="login_form" method="post" action='<?=base_url().'index.php/Login/UserLogin'?>'>
		<p class="title">用户登录</p>
		<p class="username"><i></i><input type="text" name="username" placeholder="用户名" /></p>
		<p class="password"><i></i><input type="password" name="password" placeholder="密码"  /></p>
		<button type="submit" class="submit_btn">登录</button>
	</form>
</div>	
<div class="login_bg"></div>	
</body>
</html>
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
	<form class="login_form" method="post" onsubmit="myFunction()"  action='<?=base_url().'index.php/Main/UserLogin'?>'>
		<p class="title">用户登录</p>
		<p class="username"><i></i><input id="username" type="text" name="username" placeholder="用户名" /></p>
		<p class="password"><i></i><input id="password" type="password" name="password" placeholder="密码"  /></p>
		<button type="submit" class="submit_btn">登录</button>
		<p class="remember oh">
			<input type="checkbox"   id="remember" value="true" class="regular-checkbox">
			<label for="remember"></label>
			<span class="btn">记住密码</span>
			<a class="fr">忘记密码</a>
		</p>
	</form>
</div>	
<div class="login_bg"></div>
<script>
    var usernameLogout=localStorage.getItem("username");
    var passwordLogout=localStorage.getItem("password");
    var rememberLogout=localStorage.getItem("remember");

    if(rememberLogout === 'true'){
        document.getElementById("username").value=usernameLogout;
        document.getElementById("password").value=passwordLogout;
        document.getElementById("remember").checked=rememberLogout;
    }


    function myFunction(){
        var username=document.getElementById("username").value;
        var password=document.getElementById("password").value;
        var remember=document.getElementById("remember").checked;
        localStorage.setItem("username",username);
        localStorage.setItem("password",password);
        localStorage.setItem("remember",remember);
    }
</script>
</body>
</html>
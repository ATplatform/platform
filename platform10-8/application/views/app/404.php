<?php
	require 'top.php'
?>
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

<div class="col-sm-12 main_wrap">	
	<div class="notfondbg">
	</div>
	<p class="tac col_37A">功能正在开发中...</p>
</div>

</div>
</body>
</html>
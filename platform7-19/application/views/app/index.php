<input type="hidden" value="<?php echo $at_url?>" id="url" />
<input type="hidden" value="<?php echo $page_url?>" id="page_url" />
<script type="text/javascript">
	var at_url = document.getElementById('url').value;
	var page_url = document.getElementById('page_url').value;
	if(page_url=="switchVillage"){
		//跳转到艾特平台的切换小区页面
		window.location.href= at_url+'Village/selectVillage'; 
	}
	else {
		//跳转到艾特平台的登录页面
		window.location.href= at_url+'Login/logout';
	}
</script>
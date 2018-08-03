<?php
	require 'top.php'
?>
<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->

	<div class="col-sm-12 main_wrap">
		<div class="down_code_wrap">
			<div class="select_pull_down select_wrap">
				<div>
					<span class="red_star">*</span>选择二维码对象类型：
					<input type="text" class="model_input qr_code_type ka_input3 fl" placeholder="请选择二维码对象类型" name="qr_code_type" data-ajax="" readonly style="width: 160px;">
				</div>
				<div class="ka_drop" style="left: 140px;">
					<div class="ka_drop_list">
					<ul>
						<li><a href="javascript:;" data-ajax="100">设备网络配置</a></li>
						<li><a href="javascript:;" data-ajax="101">设备</a></li>
						<li><a href="javascript:;" data-ajax="102">楼宇</a></li>
						<li><a href="javascript:;" data-ajax="103">社区活动</a></li>
						<li><a href="javascript:;" data-ajax="104">物资</a></li>
					</ul>
					</div>
				</div>
			</div>

			<a class="down">下载二维码</a>
		</div>
	</div>

</div>


	
<script>
$(function(){
	//点击下载二维码
	$('.down').click(function(){
		var qr_code_type = $('.qr_code_type').data('ajax');
		if(!qr_code_type){
			openLayer('请先选择二维码类型!');
		}
		$.ajax({
			url:getRootPath()+'/index.php/Main/downloadTdcode',
			method:'post',
			data:{
				qr_code_type:qr_code_type
			},
			success:function(data){
				if(data.indexOf("http:")!=-1)
				{
				    window.location.href=data;
				}
			},
			error:function(){
				console.log('新增楼宇出错');
			}
		})

	})
})
</script>
</body>
</html>
<?php
	require 'top.php'
?>
<style>
.btn {
	position: relative;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
.load_data_from {
	display: inline-block;
}
.folder_icon {
	margin-right: 10px;
}
.import_data_btn {
	display: inline-block;
	padding: 6px 12px;
	margin-bottom: 0;
	font-size: 14px;
	font-weight: normal;
	line-height: 1.42857143;
	text-align: center;
	white-space: nowrap;
	vertical-align: middle;
	-ms-touch-action: manipulation;
	touch-action: manipulation;
	cursor: pointer;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	background-image: none;
	border: 1px solid transparent;
	border-radius: 4px;
	border:1px solid #37ACFF;
	color:#666;
}
</style>
<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->

	<div class="col-sm-12 main_wrap">
		<div class="">
			<form id="importfile_person" class="load_data_from" style='padding:10px; padding-left:15px;' action='<?=base_url().'index.php/Import/importPerson'?>' method="post" enctype="multipart/form-data">
	              <span class="btn btn-green btn-file">
	                   <i class="glyphicon glyphicon-folder-open folder_icon" href="#"></i> 导入人员信息 
	                   <input type="file" name="file" id="person_file" />
	              </span>
	                   <!-- <input type="submit" value="提交" /> -->
			</form>
		</div>
		<div class="">
			<form id="importfile_person_building" class="load_data_from" style='padding:10px; padding-left:15px;' action='<?=base_url().'index.php/Import/importPersonBuilding'?>' method="post" enctype="multipart/form-data">
	              <span class="btn btn-green btn-file">
	                   <i class="glyphicon glyphicon-folder-open folder_icon" href="#"></i>导入住户关系信息 
	                   <input type="file" name="file" id="person_building_file" />
	              </span>
	                   <!-- <input type="submit" value="提交" /> -->
			</form>
		</div>
		<div class="">
			<form id="importfile_person_biz" class="load_data_from" style='padding:10px; padding-left:15px;' action='<?=base_url().'index.php/Import/importPersonBiz'?>' method="post" enctype="multipart/form-data">
	              <span class="btn btn-green btn-file">
	                   <i class="glyphicon glyphicon-folder-open folder_icon" href="#"></i>导入商户关系信息 
	                   <input type="file" name="file" id="person_biz_file" />
	              </span>
	                   <!-- <input type="submit" value="提交" /> -->
			</form>
		</div>

		<div class="">
			<form id="importfile_building" class="load_data_from" style='padding:10px; padding-left:15px;' action='<?=base_url().'index.php/Import/importBuilding'?>' method="post" enctype="multipart/form-data">
	              <span class="btn btn-green btn-file">
	                   <i class="glyphicon glyphicon-folder-open folder_icon" href="#"></i>导入楼宇信息 
	                   <input type="file" name="file" id="building_file" />
	              </span>
	              <a class="import_data_btn" id="setBuildingQRcode" href="javascript:;">一键生成楼宇二维码</a>
			</form>
		</div>

        <div class="">
            <form id="importfile_water_fee" class="load_data_from" style='padding:10px; padding-left:15px;' action='<?=base_url().'index.php/Import/importWaterFee'?>' method="post" enctype="multipart/form-data">
	              <span class="btn btn-green btn-file">
	                   <i class="glyphicon glyphicon-folder-open folder_icon" href="#"></i>导入月用水量信息
	                   <input type="file" name="file" id="water_fee_file" />
	              </span>
                <!-- <input type="submit" value="提交" /> -->
            </form>
        </div>


	</div>
</div>

<script>
$('#person_file').on('change',function(){
	$('#importfile_person').submit();
})
$('#person_building_file').on('change',function(){
	$('#importfile_person_building').submit();
})
$('#person_biz_file').on('change',function(){
	$('#importfile_person_biz').submit();
})
$('#building_file').on('change',function(){
	$('#importfile_building').submit();
})
$('#water_fee_file').on('change',function(){
    $('#importfile_water_fee').submit();
})
$('#setBuildingQRcode').click(function(){
	$.ajax({
		method:'post',
		url:getRootPath()+'/index.php/Building/setAllBuildingQRcode',
		//成功之后,将结果生成
		success:function(data){
			var data = data;
			var data = JSON.parse(data);
			//成功之后自动刷新页面
			layer.open({
				  type: 1,
				  title: false,
				  //打开关闭按钮
				  closeBtn: 1,
				  shadeClose: false,
				  skin: 'tanhcuang',
				  content: data.message
			});
			
		},
		error:function(){
			console.log('搜索出错');
		}
	})
})
</script>
</body>
</html>
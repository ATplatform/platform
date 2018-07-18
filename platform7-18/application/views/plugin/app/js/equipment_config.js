//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var page = getUrlParam('page');
var search_keyword = getUrlParam('keyword');
var search_effective_date = getUrlParam('effective_date');
var search_equipment_type = getUrlParam('equipment_type');
var search_building_code = getUrlParam('building_code');

var regIp =/(^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])[.](25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)[.](25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)[.](25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$)/;

//后端设置的分页参数
var pagesize = $('input[name="pagesize"]').val();
$('.date').datetimepicker({
    language:  'zh-CN',
    format: 'yyyy-mm-dd',
    weekStart: 1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 1
});

//获取所有设备的编号+名称,并填入页面
$.ajax({
	url : getRootPath()+'/index.php/Equipment/getConfigEquipmentNameCode',
	success:function(message){
		var data=JSON.parse(message);
		for(var i=0;i<data.length;i++){
			var d = data[i];
			var name = d['name'];
			var code = d['code'];
			if($(".select_equipment_code #"+code).length==0){
				$('.select_equipment_code ul').append('<li><a href="javascript:;" id='+code+' data-ajax='+code+'>'+code+'+'+name+'</a></li>');
			}
		}
	},
	error:function(jqXHR,textStatus,errorThrown){
		// console.log(jqXHR);
	}	
})

//新增保存操作
$('#add_content .save').click(function(){
	var that = $(this);
	//必填项
	var content_wrap = $(this).closest('#add_content');
	var code = content_wrap.find('.equipment_code').data('ajax');
	var severip = content_wrap.find('input[name="severip"]').val();
	var ip = content_wrap.find('input[name="ip"]').val();
	var lan_ip = content_wrap.find('input[name="lan_ip"]').val();
	var gatewayip = content_wrap.find('input[name="gatewayip"]').val();
	var netmask = content_wrap.find('input[name="netmask"]').val();
	var dns1 = content_wrap.find('input[name="dns1"]').val();
	var dns2 = content_wrap.find('input[name="dns2"]').val();

	//先验证必填项是否有
	if(!code){
		openLayer('请选择设备!');
		return;
	}
	if(!severip){
		openLayer('请输入服务器IP!');
		return;
	}
	if(!(regIp.test($.trim(severip)))){
		openLayer('输入服务器IP不正确!');
		return;
	}
	if(!ip){
		openLayer('请输入公网IP!');
		return;
	}
	if(!(regIp.test($.trim(ip)))){
		openLayer('输入公网IP不正确!');
		return;
	}
	if(!lan_ip){
		openLayer('请输入局域网IP!');
		return;
	}
	if(!(regIp.test($.trim(lan_ip)))){
		openLayer('输入局域网IP不正确!');
		return;
	}
	if(!gatewayip){
		openLayer('请输入网关IP!');
		return;
	}
	if(!(regIp.test($.trim(gatewayip)))){
		openLayer('输入网关IP不正确!');
		return;
	}
	if(!netmask){
		openLayer('请输入掩码!');
		return;
	}
	if(!(regIp.test($.trim(netmask)))){
		openLayer('输入掩码不正确!');
		return;
	}
	
	/*if(!dns1){
		openLayer('请输入dns1!');
		return;
	}*/
	if(dns1&&!(regIp.test($.trim(dns1)))){
		openLayer('输入dns1不正确!');
		return;
	}
	/*if(!dns2){
		openLayer('请输入dns2!');
		return;
	}*/
	if(dns2&&!(regIp.test($.trim(dns2)))){
		openLayer('输入dns2不正确!');
		return;
	}
	
	//首先验证局域网ip是否已经存在
	$.ajax({
		url:getRootPath()+'/index.php/Equipment/verifyLanip',
		method:'post',
		data:{
			code:code,
			lan_ip:lan_ip
		},
		success:function(data){
				var data = JSON.parse(data);
				console.log(data);
				if(data.message == "局域网ip已存在"){
					openLayer('局域网ip已存在!');
					return;
				}
				else{
					//数据写入库
					$.ajax({
						url:getRootPath()+'/index.php/Equipment/insertEquipmentConfig',
						method:'post',
						data:{
							code:code,
							severip:severip,
							lan_ip:lan_ip,
							ip:ip,
							gatewayip:gatewayip,
							netmask:netmask,
							dns1:dns1,
							dns2:dns2
						},
						success:function(data){
							content_wrap.modal('hide');
							var data = JSON.parse(data);
							//成功之后自动刷新页面
							layer.open({
								  type: 1,
								  title: false,
								  //打开关闭按钮
								  closeBtn: 1,
								  shadeClose: false,
								  skin: 'tanhcuang',
								  content: data.message,
								  cancel: function(){ 
								  	//右上角关闭回调,成功后跳页
							    	window.location = getRootPath() + "/index.php/Equipment/equipmentconfig";

								  }
							});
						},
						error:function(){
							console.log('新增出错');
						}
					})
				}		
		},
		error:function(){
			console.log('查询局域网ip出错');
		}
	})

	

})

//编辑保存
$('#content_write .save').click(function(){
	var that = $(this);
	//必填项
	var content_wrap = $(this).closest('#content_write');
	var code = content_wrap.find('.code').html();
	var severip = content_wrap.find('input[name="severip"]').val();
	var ip = content_wrap.find('input[name="ip"]').val();
	var lan_ip = content_wrap.find('input[name="lan_ip"]').val();
	var gatewayip = content_wrap.find('input[name="gatewayip"]').val();
	var netmask = content_wrap.find('input[name="netmask"]').val();
	var dns1 = content_wrap.find('input[name="dns1"]').val();
	var dns2 = content_wrap.find('input[name="dns2"]').val();
	var old_tdcode_url = content_wrap.find('input[name="tdcode_url"]').val();

	//先验证必填项是否有
	if(!severip){
		openLayer('请输入服务器IP!');
		return;
	}
	if(!(regIp.test($.trim(severip)))){
		openLayer('输入服务器IP不正确!');
		return;
	}
	if(!ip){
		openLayer('请输入公网IP!');
		return;
	}
	if(!(regIp.test($.trim(ip)))){
		openLayer('输入公网IP不正确!');
		return;
	}
	if(!lan_ip){
		openLayer('请输入局域网IP!');
		return;
	}
	if(!(regIp.test($.trim(lan_ip)))){
		openLayer('输入局域网IP不正确!');
		return;
	}
	if(!gatewayip){
		openLayer('请输入网关IP!');
		return;
	}
	if(!(regIp.test($.trim(gatewayip)))){
		openLayer('输入网关IP不正确!');
		return;
	}
	if(!netmask){
		openLayer('请输入掩码!');
		return;
	}
	if(!(regIp.test($.trim(netmask)))){
		openLayer('输入掩码不正确!');
		return;
	}

	if(dns1&&!(regIp.test($.trim(dns1)))){
		openLayer('输入dns1不正确!');
		return;
	}
	
	if(dns2&&!(regIp.test($.trim(dns2)))){
		openLayer('输入dns2不正确!');
		return;
	}

	//首先验证局域网ip是否已经存在
	$.ajax({
		url:getRootPath()+'/index.php/Equipment/verifyLanip',
		method:'post',
		data:{
			code:code,
			lan_ip:lan_ip
		},
		success:function(data){
			var data = JSON.parse(data);
			console.log(data);
			if(data.message == "局域网ip已存在"){
				openLayer('局域网ip已存在!');
				return;
			}
			else{
				//数据写入库
				$.ajax({
					url:getRootPath()+'/index.php/Equipment/updateEquipmentConfig',
					method:'post',
					data:{
						code:code,
						old_tdcode_url:old_tdcode_url,
						severip:severip,
						lan_ip:lan_ip,
						ip:ip,
						gatewayip:gatewayip,
						netmask:netmask,
						dns1:dns1,
						dns2:dns2,
						page:page,
						search_keyword:search_keyword,
						search_effective_date:search_effective_date,
						search_equipment_type:search_equipment_type,
						search_building_code:search_building_code
					},
					success:function(data){
						//先隐藏编辑页
						content_wrap.modal('hide');
						var data = JSON.parse(data);
						//成功之后自动刷新页面
						layer.open({
							  type: 1,
							  title: false,
							  //打开关闭按钮
							  closeBtn: 1,
							  shadeClose: false,
							  skin: 'tanhcuang',
							  content: data.message,
							  cancel: function(){ 
				  		    	//编辑完后异步刷新页面
				  	    		asynRefreshPage(getRootPath()+'/index.php/Equipment/equipmentconfig','Equipment/getEquipmentConfig',table,data.total,'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code);
							  }
						});
					},
					error:function(){
						console.log('新增出错');
					}
				})
			}		
		},
		error:function(){
			console.log('查询局域网ip出错');
		}
	})
})

//信息管理操作
function operateFormatter(value,row,index){
	return [
	    '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
	    '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
	    '</a>',
	    '<a class="rewrite" href="javascript:void(0)" style="margin-left: 10px;" title="编辑">',
	    '<i class="fa fa-id-card"></i>',
	    '</a>'
	].join('');
}

window.operateEvents = {
	//点击详情时,弹出详情框
	'click .detail':function(e,value,row,index){
		var content_wrap = $('#content_detail');
		content_wrap.modal('show');
		var code = row.code;
		var severip = row.server_ip;
		var lan_ip = row.lan_ip;
		var ip = row.ip;
		var gateway = row.gateway;
		var netmask = row.netmask;
		var dns1 = row.dns1;
		var dns2 = row.dns2;
		var tdcode_url = row.tdcode_url;

		content_wrap.find('.code').html(code);
		content_wrap.find('.severip').html(severip);
		content_wrap.find('.lan_ip').html(lan_ip);
		content_wrap.find('.ip').html(ip);
		content_wrap.find('.gatewayip').html(gateway);
		content_wrap.find('.netmask').html(netmask);
		content_wrap.find('.dns1').html(dns1);
		content_wrap.find('.dns2').html(dns2);

		img_url = getRootPath() +"/"+ tdcode_url;
		console.log(img_url);
		content_wrap.find('.qr_code').find('img').attr('src',img_url);
	},

	//点击编辑时,弹出信息编辑框
	'click .rewrite':function(e,value,row,index){
		var content_wrap = $('#content_write');
		content_wrap.modal('show');
		var code = row.code;
		var name = row.e_name;
		var severip = row.server_ip;
		var lan_ip = row.lan_ip;
		var ip = row.ip;
		var gateway = row.gateway;
		var netmask = row.netmask;
		var dns1 = row.dns1;
		var dns2 = row.dns2;
		var qr_code = row.qr_config_code;
		var tdcode_url = row.tdcode_url;

		//赋值
		content_wrap.find('.code').html(code);
		content_wrap.find('.severip').val(severip);
		content_wrap.find('.lan_ip').val(lan_ip);
		content_wrap.find('.ip').val(ip);
		content_wrap.find('.gatewayip').val(gateway);
		content_wrap.find('.netmask').val(netmask);
		content_wrap.find('.dns1').val(dns1);
		content_wrap.find('.dns2').val(dns2);
		content_wrap.find('.tdcode_url').val(tdcode_url);

	}
}
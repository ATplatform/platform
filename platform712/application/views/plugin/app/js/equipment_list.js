//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var page = getUrlParam('page');
var search_keyword = getUrlParam('keyword');
var search_effective_date = getUrlParam('effective_date');
var search_equipment_type = getUrlParam('equipment_type');
var search_regular_check = getUrlParam('regular_check');
var search_building_code = getUrlParam('building_code');

//新增设备生效日期默认为当天
$('#add_content .effective_date').val(now);
$('#add_content .regular_date').attr('disabled',true);
$('#add_content .annual_date').attr('disabled',true);
//选择巡检周期时,如果是不需要巡检,则巡检日期点禁止填写
$(document).on('click','#add_content .select_regular_check .ka_drop li',function(){
    var data_ajax = $(this).find('a').data('ajax');
    if(data_ajax==101){
    	$('#add_content .regular_date').attr('disabled',true);
    	$('#add_content .regular_date_wrap').hide();
    	$('#add_content .select_position_name').hide();
    }
    else {
    	$('#add_content .regular_date').attr('disabled',false);
    	$('#add_content .regular_date_wrap').show();
    	$('#add_content .select_position_name').show();
    }
})
$(document).on('click','#content_write .select_regular_check .ka_drop li',function(){
    var data_ajax = $(this).find('a').data('ajax');
    if(data_ajax==101){
    	$('#content_write .regular_date').attr('disabled',true);
    	$('#content_write .regular_date_wrap').hide();
    	$('#content_write .select_position_name').hide();
    }
    else {
    	$('#content_write .regular_date').attr('disabled',false);
    	$('#content_write .regular_date_wrap').show();
    	$('#content_write .select_position_name').show();
    }
})
//选择外审周期时,不需要外审,则外审日期点禁止填写
$(document).on('click','#add_content .select_annual_check .ka_drop li',function(){
    var data_ajax = $(this).find('a').data('ajax');
    if(data_ajax==101){
    	$('#add_content .annual_date').attr('disabled',true);
    	$('#add_content .annual_date_wrap').hide();
    }
    else {
    	$('#add_content .annual_date').attr('disabled',false);
    	$('#add_content .annual_date_wrap').show();
    }
})
$(document).on('click','#content_write .select_annual_check .ka_drop li',function(){
    var data_ajax = $(this).find('a').data('ajax');
    if(data_ajax==101){
    	$('#content_write .annual_date').attr('disabled',true);
    	$('#content_write .annual_date_wrap').hide();
    }
    else {
    	$('#content_write .annual_date').attr('disabled',false);
    	$('#content_write .annual_date_wrap').show();
    }
})

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
//获取所有的职位名称并填入页面
$.ajax({
	url : getRootPath()+'/index.php/People/getPositionName',
	success:function(message){
		var data=JSON.parse(message);
		for(var i=0;i<data.length;i++){
			var d = data[i];
			var name = d['name'];
			var code = d['code'];
			if($(".select_position_name #"+code).length==0){
				$('.select_position_name ul').append('<li><a href="javascript:;" id='+code+' data-ajax='+code+'>'+name+'</a></li>');
			}
		}
	},
	error:function(jqXHR,textStatus,errorThrown){
		// console.log(jqXHR);
	}	
})

//获取所有设备的编号+名称,并填入页面
$.ajax({
	url : getRootPath()+'/index.php/Equipment/getEquipmentNameCode',
	success:function(message){
		var data=JSON.parse(message);
		for(var i=0;i<data.length;i++){
			var d = data[i];
			var name = d['name'];
			var code = d['code'];
			if($(".select_parent_code #"+code).length==0){
				$('.select_parent_code ul').append('<li><a href="javascript:;" id='+code+' data-ajax='+code+'>'+code+'+'+name+'</a></li>');
			}
		}
	},
	error:function(jqXHR,textStatus,errorThrown){
		// console.log(jqXHR);
	}	
})
//获取所有有效的楼宇信息
$.ajax({
	type:"POST",
	url : getRootPath()+'/index.php/Building/getBuildingNameCode',
	dataType:"json",
	success:function(data){
		// console.log(data);
		for(var i=0;i<data.length;i++){
			var code = data[i]['code'];
			var name = data[i]['name'];
			if($(".select_building_code ul #"+code).length==0) {
			   $('.select_building_code ul').append('<li><a href="javascript:;" id='+code+' data-ajax='+code+'>'+code+'-'+name+'</a></li>');
			}
		}
	}	
})

//点击新增按钮,从后端取得最新的设备编号
$('.add_btn').click(function(){
	$.ajax({
		url:getRootPath()+'/index.php/Equipment/getEquipmentCode',
		success:function(data){
			var code = parseInt(data) + 1;
			$('#add_content .code').html(code);
		}
	})
}) 

//填写生效日期后,自动给外审日期点赋值
$('#add_content .effective_date').datetimepicker().on('changeDate',function(e){
	effective_date = $(this).val();
	$('#add_content .annual_date').val(effective_date);
})
//新增保存操作
$('#add_content .save').click(function(){
	var that = $(this);
	//必填项
	var content_wrap = $(this).closest('#add_content');
	var code = content_wrap.find('.code').html();
	var effective_date = content_wrap.find('input[name="effective_date"]').val();
	var name = content_wrap.find('input[name="name"]').val();
	var pcs = content_wrap.find('input[name="pcs"]').val();
	var sign = content_wrap.find('input[name="sign"]').val();
	var equipment_type = content_wrap.find('input[name="equipment_type"]').data('ajax');
	var regular_check  = content_wrap.find('input[name="regular_check"]').data('ajax');
	var regular_date   = content_wrap.find('input[name="regular_date"]').val();
	var position_code  = content_wrap.find('input[name="position_code"]').data('ajax');
	var if_se = content_wrap.find('input[name="if_se"]').data('ajax');
	var annual_check  = content_wrap.find('input[name="annual_check"]').data('ajax');
	var annual_date = content_wrap.find('input[name="annual_date"]').val();
	var building_code = content_wrap.find('input[name="building_code"]').data('ajax');

	//判断有效无效
	if(content_wrap.find('.effective_status input[type="radio"]').eq(0).is(':checked')){
		effective_status = 'true';
	}
	else {
		effective_status = 'false';
	}

	//非必填项
	var function_name = content_wrap.find('input[name="function"]').val();
	var internal_no = content_wrap.find('input[name="internal_no"]').val();
	var initial_no = content_wrap.find('input[name="initial_no"]').val();
	var initial_model = content_wrap.find('input[name="initial_model"]').val();
	var tech_spec = content_wrap.find('input[name="tech_spec"]').val();
	var supplier = content_wrap.find('input[name="supplier"]').val();
	var production_date = content_wrap.find('input[name="production_date"]').val();
	var parent_code  = content_wrap.find('input[name="parent_code"]').data('ajax');
	//先验证必填项是否有
	if(!effective_date){
		openLayer('请填写生效日期!');
		return;
	}
	if(!name){
		openLayer('请填写设备名称!');
		return;
	}
	if(!pcs){
		openLayer('请填写设备数量!');
		return;
	}
	if(!/^[0-9]+$/.test(pcs)){
		openLayer('设备数量请输入正整数');
		return;
	}
	if(!sign){
		openLayer('请填写设备号!');
		return;
	}
	if(!/^[0-9]+$/.test(sign)){
		openLayer('设备号请输入正整数');
		return;
	}
	if(!equipment_type){
		openLayer('请选择设备类型!');
		return;
	}
	if(!building_code){
		openLayer('请选择安装地点!');
		return;
	}
	if(!regular_check){
		openLayer('请选择巡检周期!');
		return;
	}
	if(regular_check==101){
		regular_date = "";
		position_code = "";
		content_wrap.find('.annual_date').attr('disabled',true);
	}
	else {
		content_wrap.find('.annual_date').attr('disabled',false);
		if(!regular_date){
			openLayer('请填写巡检日期点!');
			return;
		}
		if(!position_code){
			openLayer('请选择巡检人职位!');
			return;
		}
	}
	if(!annual_check){
		openLayer('请填写外审周期!');
		return;
	}	
	if(annual_check==101){
		annual_date = "";
	}
	else {
		if(!annual_date){
			openLayer('请填写外审日期点!');
			return;
		}
	}
	//数据写入库
	$.ajax({
		url:getRootPath()+'/index.php/Equipment/insertEquipment',
		method:'post',
		data:{
			code:code,
			effective_date:effective_date,
			effective_status:effective_status,
			name:name,
			pcs:pcs,
			sign:sign,
			equipment_type:equipment_type,
			building_code:building_code,
			regular_check:regular_check,
			regular_date:regular_date,
			position_code:position_code,
			if_se:if_se,
			annual_check:annual_check,
			annual_date:annual_date,
			function_name:function_name,
			internal_no:internal_no,
			initial_no:initial_no,
			initial_model:initial_model,
			tech_spec:tech_spec,
			supplier:supplier,
			production_date:production_date,
			parent_code:parent_code
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
			    	window.location = getRootPath() + "/index.php/Equipment/equipmentlist";

				  }
			});
		},
		error:function(){
			console.log('新增出错');
		}
	})


})

//编辑保存
$('#content_write .save').click(function(){
	var that = $(this);
	//必填项
	var content_wrap = $(this).closest('#content_write');
	var code = content_wrap.find('.code').html();
	var name = content_wrap.find('input[name="name"]').val();
	var pcs = content_wrap.find('input[name="pcs"]').val();
	var sign = content_wrap.find('input[name="sign"]').val();
	var equipment_type = content_wrap.find('input[name="equipment_type"]').data('ajax');
	var regular_check  = content_wrap.find('input[name="regular_check"]').data('ajax');
	var regular_date   = content_wrap.find('input[name="regular_date"]').val();
	var position_code  = content_wrap.find('input[name="position_code"]').data('ajax');
	var if_se = content_wrap.find('input[name="if_se"]').data('ajax');
	var annual_check  = content_wrap.find('input[name="annual_check"]').data('ajax');
	var annual_date = content_wrap.find('input[name="annual_date"]').val();
	var building_code = content_wrap.find('input[name="building_code"]').data('ajax');

	//非必填项
	var function_name = content_wrap.find('input[name="function"]').val();
	var internal_no = content_wrap.find('input[name="internal_no"]').val();
	var initial_no = content_wrap.find('input[name="initial_no"]').val();
	var initial_model = content_wrap.find('input[name="initial_model"]').val();
	var tech_spec = content_wrap.find('input[name="tech_spec"]').val();
	var supplier = content_wrap.find('input[name="supplier"]').val();
	var production_date = content_wrap.find('input[name="production_date"]').val();
	var parent_code  = content_wrap.find('input[name="parent_code"]').data('ajax');
	//先验证必填项是否有
	if(!name){
		openLayer('请填写设备名称!');
		return;
	}
	if(!pcs){
		openLayer('请填写设备数量!');
		return;
	}
	if(!/^[0-9]+$/.test(pcs)){
		openLayer('设备数量请输入正整数');
		return;
	}
	if(!sign){
		openLayer('请填写设备号!');
		return;
	}
	if(!/^[0-9]+$/.test(sign)){
		openLayer('设备号请输入正整数');
		return;
	}
	if(!equipment_type){
		openLayer('请选择设备类型!');
		return;
	}
	if(!building_code){
		openLayer('请选择安装地点!');
		return;
	}
	if(!regular_check){
		openLayer('请选择巡检周期!');
		return;
	}
	if(regular_check==101){
		regular_date = "";
		position_code = "";
		content_wrap.find('.annual_date').attr('disabled',true);
	}
	else {
		content_wrap.find('.annual_date').attr('disabled',false);
		if(!regular_date){
			openLayer('请填写巡检日期点!');
			return;
		}
		if(!position_code){
			openLayer('请选择巡检人职位!');
			return;
		}
	}
	if(!annual_check){
		openLayer('请填写外审周期!');
		return;
	}	
	if(annual_check==101){
		annual_date = "";
	}
	else {
		if(!annual_date){
			openLayer('请填写外审日期点!');
			return;
		}
	}
	//数据写入库
	$.ajax({
		url:getRootPath()+'/index.php/Equipment/updateEquipment',
		method:'post',
		data:{
			code:code,
			name:name,
			pcs:pcs,
			sign:sign,
			equipment_type:equipment_type,
			building_code:building_code,
			regular_check:regular_check,
			regular_date:regular_date,
			position_code:position_code,
			if_se:if_se,
			annual_check:annual_check,
			annual_date:annual_date,
			function_name:function_name,
			internal_no:internal_no,
			initial_no:initial_no,
			initial_model:initial_model,
			tech_spec:tech_spec,
			supplier:supplier,
			production_date:production_date,
			parent_code:parent_code,
			page:page,
			search_keyword:search_keyword,
			search_effective_date:search_effective_date,
			search_equipment_type:search_equipment_type,
			search_regular_check:search_regular_check,
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
	  	    		asynRefreshPage(getRootPath()+'/index.php/Equipment/equipmentlist','Equipment/getEquipmentList',table,data.total,'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&equipment_type='+search_equipment_type+'&regular_check='+search_regular_check+'&building_code='+search_building_code);
				  }
			});
		},
		error:function(){
			console.log('新增出错');
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
		var effective_date = row.effective_date;
		var effective_status_name = row.effective_status_name;
		var name = row.e_name;
		var pcs = row.pcs;
		var sign = row.sign;
		var equipment_type_name = row.equipment_type_name;
		var building_name = row.building_name;
		var function_name = row.function;
		var internal_no = row.internal_no;
		var initial_no = row.initial_no;
		var initial_model = row.initial_model;

		var tech_spec = row.tech_spec;
		var supplier = row.supplier;
		var production_date = row.production_date;
		var parent_code_name = row.e_parent_code_name;
		var regular_check_name = row.regular_check_name;
		var regular_date = row.regular_date;
		var position_name = row.position_name;
		var if_se_name = row.if_se_name;
		var annual_check_name = row.annual_check_name;
		var annual_date = row.annual_date;
		var qr_code = row.qr_code;

		content_wrap.find('.code').html(code);
		content_wrap.find('.effective_date').html(effective_date);
		content_wrap.find('.effective_status_name').html(effective_status_name);
		content_wrap.find('.name').html(name);
		content_wrap.find('.pcs').html(pcs);
		content_wrap.find('.sign').html(sign);
		content_wrap.find('.equipment_type_name').html(equipment_type_name);
		content_wrap.find('.building_name').html(building_name);
		content_wrap.find('.function').html(function_name);
		content_wrap.find('.internal_no').html(internal_no);
		content_wrap.find('.initial_no').html(initial_no);
		content_wrap.find('.initial_model').html(initial_model);
		content_wrap.find('.tech_spec').html(tech_spec);
		content_wrap.find('.supplier').html(supplier);
		content_wrap.find('.production_date').html(production_date);
		content_wrap.find('.regular_check_name').html(regular_check_name);
		content_wrap.find('.regular_date').html(regular_date);
		content_wrap.find('.position_name').html(position_name);
		content_wrap.find('.if_se_name').html(if_se_name);
		content_wrap.find('.annual_check').html(annual_check_name);
		content_wrap.find('.annual_date').html(annual_date);
		content_wrap.find('.parent_code_name').html(parent_code_name);
		if(qr_code){
			var qr_code = JSON.parse(qr_code);
			var img_url = qr_code.img_url;
			img_url = getRootPath() +"/"+ img_url;
			content_wrap.find('.qr_code').find('img').attr('src',img_url);
		}
	},

	//点击编辑时,弹出信息编辑框
	'click .rewrite':function(e,value,row,index){
		var content_wrap = $('#content_write');
		content_wrap.modal('show');
		var code = row.code;
		var effective_date = row.effective_date;
		var effective_status_name = row.effective_status_name;
		var name = row.e_name;
		var pcs = row.pcs;
		var sign = row.sign;
		var equipment_type_name = row.equipment_type_name;
		var equipment_type = row.equipment_type;
		var building_name = row.building_name;
		var building_code = row.building_code;
		var function_name = row.function;
		var internal_no = row.internal_no;
		var initial_no = row.initial_no;
		var initial_model = row.initial_model;

		var tech_spec = row.tech_spec;
		var supplier = row.supplier;
		var production_date = row.production_date;
		var parent_code_name = row.e_parent_code_name;
		var parent_code = row.e_parent_code;
		var regular_check_name = row.regular_check_name;
		var regular_check = row.regular_check;
		var regular_date = row.regular_date;
		var position_name = row.position_name;
		var position_code = row.position_code;
		var if_se_name = row.if_se_name;
		var if_se = row.if_se;
		var annual_check_name = row.annual_check_name;
		var annual_check = row.annual_check;
		var annual_date = row.annual_date;

		//赋值
		content_wrap.find('.code').html(code);
		content_wrap.find('.effective_date').html(effective_date);
		content_wrap.find('.effective_status_name').html(effective_status_name);
		content_wrap.find('.name').val(name);
		content_wrap.find('.pcs').val(pcs);
		content_wrap.find('.sign').val(sign);
		content_wrap.find('.equipment_type').val(equipment_type_name);
		content_wrap.find('.equipment_type').data('ajax',equipment_type);
		content_wrap.find('.building_code').val(building_name);
		content_wrap.find('.building_code').data('ajax',building_code);
		content_wrap.find('.function').val(function_name);
		content_wrap.find('.internal_no').val(internal_no);
		content_wrap.find('.initial_no').val(initial_no);
		content_wrap.find('.initial_model').val(initial_model);
		content_wrap.find('.tech_spec').val(tech_spec);
		content_wrap.find('.supplier').val(supplier);
		content_wrap.find('.production_date').val(production_date);
		content_wrap.find('.parent_code').val(parent_code_name);
		content_wrap.find('.parent_code').data('ajax',parent_code);
		content_wrap.find('.regular_check').val(regular_check_name);
		content_wrap.find('.regular_check').data('ajax',regular_check);
		content_wrap.find('.regular_date').val(regular_date);
		content_wrap.find('.position_code').val(position_name);
		content_wrap.find('.position_code').data('ajax',position_code);
		content_wrap.find('.if_se').val(if_se_name);
		content_wrap.find('.if_se').data('ajax',if_se);
		content_wrap.find('.annual_check').val(annual_check_name);
		content_wrap.find('.annual_check').data('ajax',annual_check);
		content_wrap.find('.annual_date').val(annual_date);
	}
}
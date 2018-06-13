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

//新增设备授权时,搜索设备
$('#add_content .search_equipment_wrap .search_person_btn').click(function(){
	var name = $(this).closest('.search_equipment_wrap').find('.search_person_name').val();
	var search_person_wrap = $(this).closest('.search_equipment_wrap');
	$.ajax({
		method:'post',
		data:{
			name:name
		},
		url:getRootPath()+'/index.php/Equipment/getEquipmentByName',
		//成功之后,将结果生成
		success:function(data){
			var data = data;
			//先清空之前的值
			search_person_wrap.find('.search_person_results').empty();
			if(data!='false'){
				data = JSON.parse(data);
				for(var i=0;i<data.length;i++){
					var d = data[i];
					var html = '<div class="single_person" data-code="'+d['code']+'"><a class="fl add"><i class="fa fa-trash-o fa-lg fa-plus-circle"></i></a>'
								+'<div class="fl">'
								+'<span class="name">'+d['code']+'</span>'
								+'<span class="eqip_name">'+d['name']+'</span>'
								+'<span class="address">'+d['building_name']+'</span>'
								+'</div>';
					// console.log(html);
					search_person_wrap.find('.search_person_results').append(html);
				}
			}
			else{
				search_person_wrap.find('.search_person_results').append("没有结果");
			}
		},
		error:function(){
			console.log('搜索出错');
		}
	})
})

//搜索人员并添加到结果列表
$('#add_content .search_person_only .search_person_btn').click(function(){
	var name = $(this).closest('.search_person_only').find('.search_person_name').val();
	var search_person_wrap = $(this).closest('.search_person_only');
	$.ajax({
		method:'post',
		data:{
			name:name
		},
		url:getRootPath()+'/index.php/People/getPersonByName',
		//成功之后,将结果生成
		success:function(data){
			var data = data;
			//先清空之前的值
			search_person_wrap.find('.search_person_results').empty();
			if(data){
				data = JSON.parse(data);
				for(var i=0;i<data.length;i++){
					var d = data[i];
					var html = '<div class="single_person" data-last_name="'+d['last_name']+'" data-first_name="'+d['first_name']+'" data-code="'+d['code']+'"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a>'
								+'<div class="fl">'
								+'<span class="name">'+d['full_name']+'</span>'
								+'<span class="id_number">'+d['id_number']+'</span>'
								+'</div>';
					search_person_wrap.find('.search_person_results').append(html);
				}
			}
			else{
				search_person_wrap.find('.search_person_results').append("没有结果");
			}
		},
		error:function(){
			console.log('搜索出错');
		}
	})
})

//将人员搜索的结果添加
$(document).on('click','.search_person_only .single_person .add',function(){
	var single_person = $(this).closest('.single_person');
	var full_name = single_person.find('.name').html();
	var id_number = single_person.find('.id_number').html();
	var last_name = single_person.data('last_name');
	var first_name = single_person.data('first_name');

	var last_name = single_person.data('last_name');
	var first_name = single_person.data('first_name');
	var code = single_person.data('code');

	var html = '<li data-last_name="'+last_name+'" data-first_name="'+first_name+'" data-code="'+code +'" id="'+code+'"><span class="full_name">'+full_name+'</span><span class="id_number">'+id_number+'</span><i class="fa fa-close"></i></li>';
		//最多添加十个且不能重复添加
		if($(this).closest('.search_person_only').find(".person_building_data ul li").length<10){
			if($(this).closest('.search_person_only').find(".person_building_data ul #"+code).length==0){
				$(this).closest('.search_person_only').find('.person_building_data ul').append(html);
			}
		}
})

//将设备搜索的结果添加
$(document).on('click','.search_equipment_wrap .single_person .add',function(){
	var single_person = $(this).closest('.single_person');
	var code = single_person.find('.name').html();
	var eqip_name = single_person.find('.eqip_name').html();
	var address = single_person.find('.address').html();

	var html = '<li data-code="'+code +'" id="'+code+'"><span class="name">'+code+'</span><span class="eqip_name">'+eqip_name+'</span><span class="address">'+address+'</span><i class="fa fa-close"></i></li>';
		//只能添加一个
		if($(this).closest('.search_equipment_wrap').find(".person_building_data ul li").length==0){
			$(this).closest('.search_equipment_wrap').find('.person_building_data ul').append(html);
		}
})
//点击删除节点
$(document).on('click','.person_building_data ul li .fa-close',function(){
	$(this).closest('li').remove();
})


//新增保存操作
$('#add_content .save').click(function(){
	var that = $(this);
	var content_wrap = $(this).closest('#add_content'); 
	//必填项
	var code = content_wrap.find('.search_equipment_wrap .person_building_data li').data('code');
	var begin_date = content_wrap.find('input[name="begin_date"]').val();
	var end_date = content_wrap.find('input[name="end_date"]').val();
	var p_bs = content_wrap.find('.search_person_only .person_building_data ul li');
	var person_code = '';
	var b_bs = content_wrap.find('.choose_equip_building .select_buliding em');
	var building_code = '';

	for(var i=0;i<p_bs.length;i++){
		var p_b = p_bs.eq(i);
		var code = p_b.data('code');	
		person_code += code +',';
	}
	//去掉最后一个逗号
	person_code=person_code.substring(0,person_code.length-1);

	for(var i=0;i<b_bs.length;i++){
		var b_b = b_bs.eq(i);
		var code = b_b.data('room_code');	
		building_code += code +',';
	}
	//去掉最后一个逗号
	building_code=building_code.substring(0,building_code.length-1);

	//非必填项
	var remark = content_wrap.find('input[name="remark"]').val();

	if(!end_date){
		end_date = "2099-12-31";
	}
	
	//先验证必填项是否有
	if(!code){
		openLayer('请选择授权设备!');
	}
	else if(!person_code&&!building_code){
		openLayer('请选择授权设备!');
	}
	else if(!begin_date){
		openLayer('请选择开始日期!');
	}
	else {
		//数据写入库
		$.ajax({
			url:getRootPath()+'/index.php/Equipment/insertPersonEquipment',
			method:'post',
			data:{
				code:code,
				person_code:person_code,
				building_code:building_code,
				begin_date:begin_date,
				end_date:end_date,
				remark:remark
			},
			success:function(data){
				/*add_content.modal('hide');
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
				});*/
			},
			error:function(){
				console.log('新增出错');
			}
		})

	}
})

//编辑保存
$('#content_write .save').click(function(){
	var that = $(this);
	//必填项
	var content_wrap = $(this).closest('#content_write');
	var code = content_wrap.find('.code').html();
	var name = content_wrap.find('input[name="name"]').val();
	var pcs = content_wrap.find('input[name="pcs"]').val();
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
	var initial_no = content_wrap.find('input[name="initial_no"]').val();
	var initial_model = content_wrap.find('input[name="initial_model"]').val();
	var tech_spec = content_wrap.find('input[name="tech_spec"]').val();
	var supplier = content_wrap.find('input[name="supplier"]').val();
	var production_date = content_wrap.find('input[name="production_date"]').val();
	var parent_code  = content_wrap.find('input[name="parent_code"]').data('ajax');
	//先验证必填项是否有
	if(!name){
		openLayer('请填写设备名称!');
	}
	else if(!pcs){
		openLayer('请填写设备数量!');
	}
	else if(!equipment_type){
		openLayer('请选择设备类型!');
	}
	else if(!building_code){
		openLayer('请选择安装地点!');
	}
	else if(!regular_check){
		openLayer('请选择巡检周期!');
	}
	else if(!regular_date){
		openLayer('请填写巡检日期点!');
	}
	else if(!position_code){
		openLayer('请选择巡检人职位!');
	}
	else if(!annual_date){
		openLayer('请填写外审日期点!');
	}
	else {
		//数据写入库
		$.ajax({
			url:getRootPath()+'/index.php/Equipment/updateEquipment',
			method:'post',
			data:{
				code:code,
				name:name,
				pcs:pcs,
				equipment_type:equipment_type,
				building_code:building_code,
				regular_check:regular_check,
				regular_date:regular_date,
				position_code:position_code,
				if_se:if_se,
				annual_check:annual_check,
				annual_date:annual_date,
				function_name:function_name,
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

	}

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
		var equipment_type_name = row.equipment_type_name;
		var building_name = row.building_name;
		var function_name = row.function;
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

		content_wrap.find('.code').html(code);
		content_wrap.find('.effective_date').html(effective_date);
		content_wrap.find('.effective_status_name').html(effective_status_name);
		content_wrap.find('.name').html(name);
		content_wrap.find('.pcs').html(pcs);
		content_wrap.find('.equipment_type_name').html(equipment_type_name);
		content_wrap.find('.building_name').html(building_name);
		content_wrap.find('.function').html(function_name);
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
		var equipment_type_name = row.equipment_type_name;
		var equipment_type = row.equipment_type;
		var building_name = row.building_name;
		var building_code = row.building_code;
		var function_name = row.function;
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
		content_wrap.find('.equipment_type').val(equipment_type_name);
		content_wrap.find('.equipment_type').data('ajax',equipment_type);
		content_wrap.find('.building_code').val(building_name);
		content_wrap.find('.building_code').data('ajax',building_code);
		content_wrap.find('.function').val(function_name);
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
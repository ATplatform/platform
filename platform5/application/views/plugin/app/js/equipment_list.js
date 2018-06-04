//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var search_keyword = getUrlParam('keyword');
var search_effective_date = getUrlParam('effective_date');
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
	var add_content = $(this).closest('#add_content');
	var code = add_content.find('.code').html();
	var effective_date = add_content.find('input[name="effective_date"]').val();
	var name = add_content.find('input[name="name"]').val();
	var pcs = add_content.find('input[name="pcs"]').val();
	var equipment_type = add_content.find('input[name="equipment_type"]').data('ajax');
	var regular_check  = add_content.find('input[name="regular_check"]').data('ajax');
	var regular_date   = add_content.find('input[name="regular_date"]').val();
	var position_code  = add_content.find('input[name="position_code"]').data('ajax');
	var if_se = add_content.find('input[name="if_se"]').data('ajax');
	var annual_check  = add_content.find('input[name="annual_check"]').data('ajax');
	var annual_date = add_content.find('input[name="annual_date"]').val();
	var building_code = add_content.find('input[name="building_code"]').data('ajax');

	//判断有效无效
	if(add_content.find('.effective_status input[type="radio"]').eq(0).is(':checked')){
		effective_status = 'true';
	}
	else {
		effective_status = 'false';
	}

	//非必填项
	var function_name = add_content.find('input[name="function"]').val();
	var initial_no = add_content.find('input[name="initial_no"]').val();
	var initial_model = add_content.find('input[name="initial_model"]').val();
	var tech_spec = add_content.find('input[name="tech_spec"]').val();
	var supplier = add_content.find('input[name="supplier"]').val();
	var production_date = add_content.find('input[name="production_date"]').val();
	var parent_code  = add_content.find('input[name="parent_code"]').data('ajax');
	//先验证必填项是否有
	if(!effective_date){
		openLayer('请输入生效日期!');
	}
	else if(!name){
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
		openLayer('请输入巡检日期点!');
	}
	else if(!position_code){
		openLayer('请选择巡检人职位!');
	}
	else if(!annual_date){
		openLayer('请输入外审日期点!');
	}
	else {
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
				parent_code:parent_code
			},
			success:function(data){
				add_content.modal('hide');
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
		$('#content_detail').modal('show');
		var code = row.code;
		var effective_date = row.effective_date;
		var effective_status_name = row.effective_status_name;
		var name = row.name;
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
		var annual_check = row.annual_check;
		var annual_date = row.annual_date;

		$('#content_detail').find('.code').html(code);
		$('#content_detail').find('.effective_date').html(effective_date);
		$('#content_detail').find('.effective_status_name').html(effective_status_name);
		$('#content_detail').find('.name').html(name);
		$('#content_detail').find('.pcs').html(pcs);
		$('#content_detail').find('.equipment_type_name').html(equipment_type_name);
		$('#content_detail').find('.building_name').html(building_name);
		$('#content_detail').find('.function').html(function_name);
		$('#content_detail').find('.initial_no').html(initial_no);
		$('#content_detail').find('.initial_model').html(initial_model);

		$('#content_detail').find('.tech_spec').html(tech_spec);
		$('#content_detail').find('.supplier').html(supplier);
		$('#content_detail').find('.production_date').html(production_date);
		$('#content_detail').find('.regular_check_name').html(regular_check_name);
		$('#content_detail').find('.regular_date').html(regular_date);
		$('#content_detail').find('.position_name').html(position_name);
		$('#content_detail').find('.if_se_name').html(if_se_name);
		$('#content_detail').find('.annual_check').html(annual_check);
		$('#content_detail').find('.annual_date').html(annual_date);
		$('#content_detail').find('.parent_code_name').html(parent_code_name);

	},

	//点击编辑人员详情时,弹出人员信息编辑框
	'click .rewrite':function(e,value,row,index){
		$('#write_person').modal('show');
		var person_code = row.person_code;
		var full_name = row.full_name;
		var id_type_name = row.id_type_name;
		var id_number = row.id_number;
		var nationality = row.nationality;
		var gender_name = row.gender_name;
		var birth_date = row.birth_date;
		var if_disabled_name = row.if_disabled_name;
		var if_disabled = row.if_disabled;
		var blood_type_name = row.blood_type_name;
		var ethnicity_name = row.ethnicity_name;
		var mobile_number = row.mobile_number;
		var oth_mob_no = row.oth_mob_no;
		var remark = row.person_remark;

		//赋值
		$('#write_person').find('.code').html(person_code);
		$('#write_person').find('.full_name').html(full_name);
		$('#write_person').find('.id_number').html(id_number);
		$('#write_person').find('.gender_name').html(gender_name);
		$('#write_person').find('.birth_date').html(birth_date);
		$('#write_person').find('.ethnicity_name').html(ethnicity_name);
		$('#write_person').find('.blood_type_name').html(blood_type_name);
		$('#write_person').find('.nationality').html(nationality);
		$('#write_person').find('.mobile_number').html(mobile_number);
		$('#write_person').find('.id_type_name').html(id_type_name);
		$('#write_person').find('.birth_date').val(birth_date);
		$('#write_person').find('.if_disabled').val(if_disabled_name);
		$('#write_person').find('.if_disabled').data('ajax',if_disabled);
		$('#write_person').find('.oth_mob_no').val(oth_mob_no);
		$('#write_person').find('.remark').val(remark);
	},

	//点击编辑住户关系时,弹出住户关系编辑框
	'click .relation':function(e,value,row,index){
		$('#relation_detail').modal('show');
		var full_name  = row.full_name;
		var id_number = row.id_number;
		var hire_date  = row.hire_date;
		var begin_date = row.begin_date;
		var end_date = row.end_date;
		var position_name = row.name;
		var position_code = row.position_code;
		var employee_no = row.employee_no;
		var person_code = row.person_code;
		var position_remark = row.position_remark;
		var pp_code = row.pp_code;
		var persons_info = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+full_name+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+id_number;

		//赋值
		$('#relation_detail').find('.person_code').html(persons_info);
		$('#relation_detail').find('.person_code').data('ajax',person_code);
		$('#relation_detail').find('.hire_date').html(hire_date);
		$('#relation_detail').find('.begin_date').html(begin_date);
		$('#relation_detail').find('.end_date').val(end_date);
		$('#relation_detail').find('.employee_no').html(employee_no);
		$('#relation_detail').find('.position_name').val(position_name);
		$('#relation_detail').find('.position_name').data('ajax',position_code);
		$('#relation_detail').find('.remark').val(position_remark);
		$('#relation_detail').find('.pp_code').val(pp_code);

		//获得当前人员的所有管理区域
		$.ajax({
			method:'POST',
			url : getRootPath()+'/index.php/People/getPersonPosition',
			data:{
				person_code:person_code
			},
			success:function(message){
				var data=JSON.parse(message);
				for(var i=0;i<data.length;i++){
					var d = data[i];
					var household = d['household'];
					var id = d['id'];
					var code = d['code'];
					if($("#relation_detail .select_buliding #"+id).length==0){
						$('.select_buliding').append('<em id='+id+' data-room_code='+code+'>'+household+'</em>');
					}
				}
			},
			error:function(jqXHR,textStatus,errorThrown){
				// console.log(jqXHR);
			}	
		})

	}
}
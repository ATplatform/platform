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
	if(!name||/^\s*$/.test(name)){
	    openLayer('请输入设备名称!');
	    return;
	}
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
$('.search_person_only .search_person_btn').click(function(){
	var name = $(this).closest('.search_person_only').find('.search_person_name').val();
	var search_person_wrap = $(this).closest('.search_person_only');
	if(!name||/^\s*$/.test(name)){
	    openLayer('请输入姓名!');
	    return;
	}
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
		else{
			openLayer('授权住户已满10个！');
		}
		//选择授权住户时,就要清空授权楼宇
		$(this).closest('.model_content').find(".select_buliding_wrap .select_buliding").empty();
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
		var b_code = p_b.data('code');	
		person_code += b_code +',';
	}
	//去掉最后一个逗号
	person_code=person_code.substring(0,person_code.length-1);

	for(var i=0;i<b_bs.length;i++){
		var b_b = b_bs.eq(i);
		var p_code = b_b.data('room_code');	
		building_code += p_code +',';
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
		return;
	}
	if(!person_code&&!building_code){
		openLayer('请选择授权楼宇或授权住户!');
		return;
	}
	if(!begin_date){
		openLayer('请选择开始日期!');
		return;
	}
	if(begin_date>end_date){
		openLayer('开始日期必须小于结束日期!');
		return;
	}
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
			    	window.location = getRootPath() + "/index.php/Equipment/equipmentprivilegelist";

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
	var content_wrap = $(this).closest('#content_write'); 
	//必填项
	var data_code = content_wrap.find('.equipment_name .equipment_code').data('code');
	var begin_date = content_wrap.find('input[name="begin_date"]').val();
	var end_date = content_wrap.find('input[name="end_date"]').val();
	var p_bs = content_wrap.find('.search_person_only .person_building_data ul li');
	var person_code = '';
	var b_bs = content_wrap.find('.choose_equip_building .select_buliding em');
	var building_code = '';

	for(var i=0;i<p_bs.length;i++){
		var p_b = p_bs.eq(i);
		var b_code = p_b.data('code');	
		person_code += b_code +',';
	}
	//去掉最后一个逗号
	person_code=person_code.substring(0,person_code.length-1);

	for(var i=0;i<b_bs.length;i++){
		var b_b = b_bs.eq(i);
		var p_code = b_b.data('room_code');	
		building_code += p_code +',';
	}
	//去掉最后一个逗号
	building_code=building_code.substring(0,building_code.length-1);

	//非必填项
	var remark = content_wrap.find('input[name="remark"]').val();

	if(!end_date){
		end_date = "2099-12-31";
	}
	
	//先验证必填项是否有
	if(!person_code&&!building_code){
		openLayer('请选择授权楼宇或授权住户!');
		return;
	}
	if(!begin_date){
		openLayer('请选择开始日期!');
		return;
	}
	if(begin_date>end_date){
		openLayer('开始日期必须小于结束日期!');
		return;
	}
	//数据写入库
	$.ajax({
		url:getRootPath()+'/index.php/Equipment/updatePersonEquipment',
		method:'post',
		data:{
			code:data_code,
			person_code:person_code,
			building_code:building_code,
			begin_date:begin_date,
			end_date:end_date,
			remark:remark,
			search_keyword:search_keyword,
			search_effective_date:search_effective_date,
			search_equipment_type:search_equipment_type,
			search_building_code:search_building_code
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
				    	//编辑完后异步刷新页面
			    		asynRefreshPage(getRootPath()+'/index.php/Equipment/equipmentprivilegelist','Equipment/getPrivilegeEquipmentList',table,data.total,'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&equipment_type='+search_equipment_type+'&building_code='+search_building_code);
				  }
			});
		},
		error:function(){
			console.log('编辑出错');
		}
	})
})

//信息管理操作
function operateFormatter(value,row,index){
	return [
	    '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
	    '<i class=" fa fa-lg fa-file-text-o"></i>',
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
		var equipment_code = row.equipment_code;
		var pcs = row.pcs;
		var name = row.name;
		var equipment_type_name = row.equipment_type_name;
		var building_name = row.building_name;
		var begin_date = row.begin_date;
		var end_date = row.end_date;
		var remark = row.remark;
		var person_name = row.person_name;

		content_wrap.find('.equipment_code').html(equipment_code);
		content_wrap.find('.pcs').html(pcs);
		content_wrap.find('.name').html(name);
		content_wrap.find('.equipment_type_name').html(equipment_type_name);
		content_wrap.find('.building_name').html(building_name);
		content_wrap.find('.begin_date').html(begin_date);
		content_wrap.find('.end_date').html(end_date);
		content_wrap.find('.remark').html(remark);
		content_wrap.find('.person_name').html(person_name);
		
	},

	//点击编辑时,弹出信息编辑框
	'click .rewrite':function(e,value,row,index){
		var content_wrap = $('#content_write');
		content_wrap.modal('show');
		var equipment_code = row.equipment_code;
		var code = row.code;
		var equipment_building = row.equipment_building;
		var pcs = row.pcs;
		var name = row.name;
		var equipment_type_name = row.equipment_type_name;
		var building_name = row.building_name;
		var begin_date = row.begin_date;
		var end_date = row.end_date;
		var remark = row.pe_remark;
		var person_name = row.person_name;
		var building_code_str = row.building_code_str;
		var building_name_arr = row.building_name_arr;
		var person_id_arr = row.person_id_arr;
		var person_code_str = row.person_code_str;
		var person_name_arr = row.person_name_arr;
		// console.log(row);
		//赋值
		var nameHtml = "<span style='width: 80px;display:inline-block;' class='equipment_code' data-code="+code+">"+equipment_code+"</span>"+"<span style='width: 160px;display:inline-block;'>"+name+"</span>"+"<span style='display:inline-block;'>"+equipment_building+"</span>";
		content_wrap.find('.equipment_name').html(nameHtml);
		content_wrap.find('.begin_date').val(begin_date);
		content_wrap.find('.end_date').val(end_date);
		content_wrap.find('.remark').val(remark);
		var building_code_wrap = '';
		//拼接已授权住户
		for(var i=0;i<building_code_str.length;i++){
			building_code_wrap += "<em id="+building_code_str[i]+" data-room_code="+building_code_str[i]+">"+building_name_arr[i]+"<i class='fa fa-close'></i></em>";
		}
		//先清空之前的
		content_wrap.find('.choose_equip_building .select_buliding').empty();
		content_wrap.find('.choose_equip_building .select_buliding').append(building_code_wrap);

		//拼接已授权单独住户
		var person_wrap = '';
		//拼接已授权住户
		for(var i=0;i<person_code_str.length;i++){
			person_wrap += "<li id="+person_code_str[i]+" data-code="+person_code_str[i]+"><span class='full_name'>"+person_name_arr[i]+"</span><span class='id_number'>"+person_id_arr[i]+"</span><i class='fa fa-close'></i></li>";
		}
		//先清空之前的
		content_wrap.find('.search_person_wrap .person_building_data ul').empty();
		content_wrap.find('.search_person_wrap .person_building_data ul').append(person_wrap);

	}
}
//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var search_keyword = getUrlParam('keyword');
var search_effective_date = getUrlParam('effective_date');
var search_household_type = getUrlParam('household_type');
var search_person_type = getUrlParam('person_type');
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
//新增住户操作
$('#add_person .save_add,#add_person .save').click(function(){
	// console.log($(this).hasClass("save"));
	var that = $(this);
	//必填项
	var add_pesron = $(this).closest('#add_person');
	var code = add_pesron.find('.code').html();
	var last_name = add_pesron.find('input[name="last_name"]').val();
	var first_name = add_pesron.find('input[name="first_name"]').val();
	var id_type = add_pesron.find('input[name="id_type"]').val();
	var id_number = add_pesron.find('input[name="id_number"]').val();
	var nationality = add_pesron.find('input[name="nationality"]').val();
	var gender  = add_pesron.find('input[name="gender"]').val();
	var birth  = add_pesron.find('input[name="birth"]').val();
	var bloodtype   = add_pesron.find('input[name="bloodtype"]').val();
	var if_disabled  = "false";
	var ethnicity  = add_pesron.find('input[name="ethnicity"]').val();
	var mobile_number = add_pesron.find('input[name="mobile_number"]').val();
	var tel_country = add_pesron.find('input[name="tel_country"]').val();

	var oth_mob_no  = add_pesron.find('input[name="oth_mob_no"]').val();
	var remark  = add_pesron.find('input[name="remark"]').val();

	//去处空格
	last_name = trim(last_name);
	first_name = trim(first_name);
	mobile_number = trim(mobile_number);
	oth_mob_no = trim(oth_mob_no);
	remark = trim(remark);

	//判断是否残疾
	if(add_pesron.find('input[name="if_disabled"]').val()=="否"){
		if_disabled = 'false';
	}
	else {
		if_disabled = 'true';
	}

	//先验证必填项是否有
	if(!last_name){
		openLayer('请输入姓!');
	}
	else if(!first_name){
		openLayer('请输入名!');
	}
	else if(!id_type){
		openLayer('请选择证件类型!');
	}
	else if(!id_number){
		openLayer('请输入证件号码!');
	}
	else if(!nationality){
		openLayer('请选择国籍或地区!');
	}
	else if(!gender){
		openLayer('请选择性别!');
	}
	else if(!birth){
		openLayer('请选择出生年月!');
	}
	else if(!bloodtype){
		openLayer('请选择血型!');
	}
	else if(!ethnicity){
		openLayer('请选择民族!');
	}
	else if(!mobile_number){
		openLayer('请输入手机号!');
	}
	else {
		//验证身份证号码是否有误
		if(!(/(^1\d{10}$)/.test($.trim(mobile_number)))){
			openLayer('手机号码有误!');
		}
		else {
			//验证通过,进行下一步
			//数据写入库
			$.ajax({
				url:getRootPath()+'/index.php/People/insertPeople',
				method:'post',
				data:{
					code:code,
					last_name:last_name,
					first_name:first_name,
					id_type:add_pesron.find('input[name="id_type"]').data('ajax'),
					id_number:id_number,
					nationality:nationality,
					gender:add_pesron.find('input[name="gender"]').data('ajax'),
					birth_date:birth,
					if_disabled:if_disabled,
					bloodtype:add_pesron.find('input[name="bloodtype"]').data('ajax'),
					ethnicity:add_pesron.find('input[name="bloodtype"]').data('ajax'),
					tel_country:tel_country,
					mobile_number:mobile_number,
					oth_mob_no:oth_mob_no,
					remark:remark
				},
				success:function(data){
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
						    if(that.hasClass('save_add')){
						    	//得到当前住户姓名/身份证号
						    	var person = '<div class="single_person" data-last_name="'+last_name+'" data-first_name="'+first_name+'" data-code="'+code+'"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a><div class="fl"><span class="name">'+last_name+first_name+'</span><span class="id_number">'+id_number+'</span></div><div class="select_pull_down query_wrap col_37A fl"><div><input type="text" class="model_input household_type ka_input3" placeholder="住户类别" name="household_type" data-ajax="" readonly=""></div><div class="ka_drop" style="display: none;"><div class="ka_drop_list"><ul><li><a href="javascript:;" data-ajax="101">户主</a></li><li><a href="javascript:;" data-ajax="102">家庭成员</a></li><li><a href="javascript:;" data-ajax="103">访客</a></li><li><a href="javascript:;" data-ajax="104">租客</a></li></ul></div></div></div></div>';
						    	$('#add_relation .search_person_results').empty();
						    	$('#add_relation .search_person_results').append(person);
						    	//关闭新增住户窗口
						    	$('#add_person').modal('hide');
						    	//开启新增住户关系窗口
						    	$('#add_relation').modal('show');
						    }
						    else {
						    	window.location = getRootPath() + "/index.php/People/residentlist";
						    }
						  }
					});
				},
				error:function(){
					console.log('新增住户出错');
				}
			})
		}
	}

})

//信息管理操作
function operateFormatter(value,row,index){
	return [
	    '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
	    '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
	    '</a>',
	    '<a class="rewrite" href="javascript:void(0)" style="margin-left: 10px;"   title="编辑住户">',
	    '<i class="fa fa-id-card"></i>',
	    '</a>',
	    '<a class="relation" href="javascript:void(0)" style="margin-left: 10px;"   title="编辑住户关系">',
	    '<i class=" fa fa-sitemap"></i>',
	    '</a>'
	].join('');
}

//id格式化操作
function idFormatter(value,row,index){
	var page = $('input[name="page"]').val();
	return [
		index+1+(page-1)*pagesize
	];
}

//获取所有有效的房间号
$.ajax({
	url : getRootPath()+'/index.php/Building/getBuildingLast',
	dataType:"text",
	success:function(message){
		var data=JSON.parse(message);
		// console.log(data);
		for(var i=0;i<data.length;i++){
			var d = data[i];
			var name = d['name'];
			var code = d['code'];
			if($(".select_room #"+code).length==0){
				$('.select_room ul').append('<li><a href="javascript:;" id='+code+' data-ajax='+code+'>'+code+'-'+name+'</a></li>');
			}
		}
	},
	error:function(jqXHR,textStatus,errorThrown){
		// console.log(jqXHR);
	}	
})


//新增住户关系保存操作
$('#add_relation .save').click(function(){
	var that = $(this);
	//必填项
	var add_relation = $(this).closest('#add_relation');
	var building_code = add_relation.find('.building_code').val();
	var begin_date = add_relation.find('.begin_date').val();
	var end_date = add_relation.find('.end_date').val();
	var remark = add_relation.find('.remark').val();
	var p_bs = $(this).closest('.modal-content').find('.person_building_data ul li');
	
	if(!building_code){
		openLayer('请选择房号!');
		return;
	}
	if(p_bs.length==0){
		openLayer('请输入人员信息!');
		return;
	}
	if(!begin_date){
		openLayer('请选择开始日期!');
		return;
	}
	if(!end_date){
		openLayer('请选择结束日期!');
		return;
	}
	if(begin_date>end_date){
		openLayer('开始日期不能晚于结束日期!');
		return;
	}
	var person_building_datas = [];
	for(var i=0;i<p_bs.length;i++){
		var p_b = p_bs.eq(i);
		var id_number = p_b.find('.id_number').html();	
		var full_name = p_b.find('.full_name').html();
		var last_name = p_b.data('last_name');	
		var first_name = p_b.data('first_name');	
		var code = p_b.data('code');	
		var household_type = p_b.data('household_type');
		var person_building_data = '';
		person_building_data = {
			last_name:last_name,
			first_name:first_name,
			code:code,
			household_type:household_type,
			id_number:id_number,
			full_name:full_name
		}
		person_building_datas[i] = person_building_data;
	}
	// console.log(person_building_datas);
	//提交数据到后端
	$.ajax({
		type:"POST",
		url : getRootPath()+'/index.php/People/insertPersonBuilding',
		data:{
			building_code:add_relation.find('.building_code').data('ajax'),
			begin_date:begin_date,
			end_date:end_date,
			remark:remark,
			persons:person_building_datas
		},
		success:function(data){
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
				    //右上角关闭回调
				    window.location = getRootPath() + "/index.php/People/residentlist";
				  }
			});
		},
		error:function(){

		}
	})
})

//编辑住户关系时,搜索住户
$('.search_person_wrap .search_person_btn').click(function(){
	var name = $(this).closest('.search_person_wrap').find('.search_person_name').val();
	var search_person_wrap = $(this).closest('.search_person_wrap');
	//得到住户类型下拉框
	var household_type_wrap = '<div class="select_pull_down query_wrap col_37A fl"><div><input type="text" class="model_input household_type ka_input3" placeholder="住户类别" name="household_type" data-ajax="" readonly=""></div><div class="ka_drop" style="display: none;"><div class="ka_drop_list"><ul><li><a href="javascript:;" data-ajax="101">户主</a></li><li><a href="javascript:;" data-ajax="102">家庭成员</a></li><li><a href="javascript:;" data-ajax="103">访客</a></li><li><a href="javascript:;" data-ajax="104">租客</a></li></ul></div></div></div>';
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
			$('.search_person_results').empty();
			if(data){
				data = JSON.parse(data);
				for(var i=0;i<data.length;i++){
					var d = data[i];
					var html = '<div class="single_person" data-last_name="'+d['last_name']+'" data-first_name="'+d['first_name']+'" data-code="'+d['code']+'"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a>'
								+'<div class="fl">'
								+'<span class="name">'+d['full_name']+'</span>'
								+'<span class="id_number">'+d['id_number']+'</span>'
								+'</div>'
								+household_type_wrap;
					$('.search_person_results').append(html);
				}
			}
			else{
				$('.search_person_results').append("没有结果");
			}
		},
		error:function(){
			console.log('搜索出错');
		}
	})
})

//点击搜索到的住户,添加到结果列表
$(document).on('click','.search_person_results .single_person .add',function(){
	var single_person = $(this).closest('.single_person');
	var full_name = single_person.find('.name').html();
	var id_number = single_person.find('.id_number').html();
	var last_name = single_person.data('last_name');
	var first_name = single_person.data('first_name');
	var household_type = single_person.find('.household_type').data('ajax');

	var last_name = single_person.data('last_name');
	var first_name = single_person.data('first_name');
	var code = single_person.data('code');

	if(!household_type){
		openLayer('请选择住户类别!');
		return;
	}
	var html = '<li data-last_name="'+last_name+'" data-first_name="'+first_name+'" data-code="'+code+'" data-household_type="'+household_type+'" id="'+code+'"><span class="full_name">'+full_name+'</span><span class="id_number">'+id_number+'</span></li>';
		//不重复添加
		if($(".person_building_data ul #"+code).length==0){
			$('.person_building_data ul').append(html);
		}
})

//编辑住户信息操作
$('#write_person .save').click(function(){
	var that = $(this);
	//必填项
	var add_pesron = $(this).closest('#write_person');
	var code = add_pesron.find('.code').html();
	var if_disabled  = "false";
	var oth_mob_no  = add_pesron.find('input[name="oth_mob_no"]').val();
	var remark  = add_pesron.find('input[name="remark"]').val();

	//判断是否残疾
	if(add_pesron.find('input[name="if_disabled"]').val()=="否"){
		if_disabled = 'false';
	}
	else {
		if_disabled = 'true';
	}
	//数据写入库
		$.ajax({
			url:getRootPath()+'/index.php/People/updatePeople',
			method:'post',
			data:{
				code:code,
				oth_mob_no:oth_mob_no,
				remark:remark,
				if_disabled:if_disabled,
				search_keyword:search_keyword,
				search_effective_date:search_effective_date,
				search_household_type:search_household_type,
				search_person_type:search_person_type
			},
			success:function(data){
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
				    		asynRefreshPage(getRootPath()+'/index.php/People/residentlist','People/getResidentList',table,data.residentlist_total,'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&household_type='+search_household_type+'&person_type='+search_person_type);
				    	  $('#write_person').modal('hide');
					  }
				});
			},
			error:function(){
				console.log('编辑人员出错');
			}
		})
})

//编辑住户关系
$('#relation_detail .save').click(function(){
	//必填项
	var add_pesron = $(this).closest('#relation_detail');
	var building_code = add_pesron.find('.building_code').html();
	var begin_date = add_pesron.find('.begin_date').html();
	var end_date = add_pesron.find('.end_date').val();
	var person_code = add_pesron.find('.person_code').html();
	if(!end_date){
		openLayer('请选择结束日期!');
	}
	else {
		//数据写入库
		$.ajax({
			url:getRootPath()+'/index.php/People/updatePersonBuilding',
			method:'post',
			data:{
				building_code:add_pesron.find('.building_code').data('ajax'),
				person_code:person_code,
				begin_date:begin_date,
				end_date:end_date,
				search_keyword:search_keyword,
				search_effective_date:search_effective_date,
				search_household_type:search_household_type,
				search_person_type:search_person_type
			},
			success:function(data){
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
	    	    		asynRefreshPage(getRootPath()+'/index.php/People/residentlist','People/getResidentList',table,data.residentlist_total,'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&household_type='+search_household_type+'&person_type='+search_person_type);
	    	    	  	$('#relation_detail').modal('hide');
					  }
				});
			},
			error:function(){
				console.log('编辑人员出错');
			}
		})
	}

})

window.operateEvents = {
	//点击详情时,弹出住户详情框
	'click .detail':function(e,value,row,index){
		$('#person_detail').modal('show');
		var full_name = row.full_name;
		var id_number = row.id_number;
		var gender_name = row.gender_name;
		var birth_date = row.birth_date;
		var ethnicity_name = row.ethnicity_name;
		var nationality = row.nationality;
		var blood_type_name = row.blood_type_name;
		var mobile_number = row.mobile_number;
		var oth_mob_no = row.oth_mob_no;
		var remark = row.remark;
		var if_disabled_name = row.if_disabled_name;
		var id_type_name = row.id_type_name;
		var begin_date = row.begin_date;
		var end_date = row.end_date;
		var building_code = row.building_code;
		var household_type_name = row.household_type_name;
		var person_code = row.person_code;
		var building_code = row.building_code;
		var room = row.room;
		$('#person_detail').find('.full_name').html(full_name);
		$('#person_detail').find('.id_number').html(id_number);
		$('#person_detail').find('.gender_name').html(gender_name);
		$('#person_detail').find('.birth_date').html(birth_date);
		$('#person_detail').find('.ethnicity_name').html(ethnicity_name);
		$('#person_detail').find('.blood_type_name').html(blood_type_name);
		$('#person_detail').find('.nationality').html(nationality);
		$('#person_detail').find('.mobile_number').html(mobile_number);
		$('#person_detail').find('.remark').html(remark);
		$('#person_detail').find('.if_disabled_name').html(if_disabled_name);
		$('#person_detail').find('.id_type_name').html(id_type_name);
		$('#person_detail').find('.begin_date').html(begin_date);
		$('#person_detail').find('.end_date').html(end_date);
		$('#person_detail').find('.building_code').html(room);
		$('#person_detail').find('.household_type_name').html(household_type_name);
		$('#person_detail').find('.oth_mob_no').html(oth_mob_no);

		//得到该住户在本小区的其它房间
		$.ajax({
			data:{
				person_code:person_code,
				building_code:building_code
			},
			method:'post',
			url:getRootPath()+'/index.php/People/getBuildingByPersonCode',
			//成功之后,将结果生成
			success:function(data){
				var data = JSON.parse(data);
				var message =  "";
				if(data.length==0){
					message = "无"
				}
				else {
					for(var i=0;i<data.length;i++){
						var d = data[i] + " ";
						message += d;
					}
				}
				$('#person_detail').find('.other_building').html(message);
			},
			error:function(){
			}
		})

		//得到该住户的同房间住户
		$.ajax({
			data:{
				person_code:person_code,
				building_code:building_code
			},
			method:'post',
			url:getRootPath()+'/index.php/People/getPersonByPersonCode',
			//成功之后,将结果生成
			success:function(data){
				if(data){
					var data = JSON.parse(data);
					var message =  "";
					for(var i=0;i<data.length;i++){
						var d = data[i]['full_name'] + " ";
						message += d;
					}
					$('#person_detail').find('.other_person').html(message);
				}
				else {
					$('#person_detail').find('.other_person').html('无');
				}
				
			},
			error:function(){
			}
		})

	},

	//点击编辑住户详情时,弹出住户信息编辑框
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
		var remark = row.remark;

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
		var building_code  = row.building_code;
		var person_code = row.person_code;
		var full_name = row.full_name;
		var id_number = row.id_number;
		var begin_date = row.begin_date;
		var end_date = row.end_date;
		var household_type_name = row.household_type_name;
		var room = row.room;
		var pb_remark = row.pb_remark;
		//赋值
		$('#relation_detail').find('.building_code').html(room);
		$('#relation_detail').find('.building_code').data('ajax',building_code);
		$('#relation_detail').find('.person_code').html(person_code);
		$('#relation_detail').find('.full_name').html(full_name);
		$('#relation_detail').find('.id_number').html(id_number);
		$('#relation_detail').find('.begin_date').html(begin_date);
		$('#relation_detail').find('.end_date').val(end_date);
		$('#relation_detail').find('.household_type_name').html(household_type_name);
		$('#relation_detail').find('.remark').html(pb_remark);
	}
}
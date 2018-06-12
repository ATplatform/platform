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
		console.log(data);
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
 
//先验证证件号码
$('#verify_idcard .next').click(function(){
	var that = $(this);
	var id_card = $(this).closest('.modal-content').find('input[name="id_card"]').val();
	if(!id_card){
		openLayer('请输入证件号码');
		return;
	}
	if(!/^[0-9]*$/.test(id_card)){
		openLayer('请输入数字');
		return;
	}
	$.ajax({
		url:getRootPath()+'/index.php/People/verifyIdcard',
		method:'post',
		data:{
			id_card:id_card
		},
		success:function(data){
			console.log(data);
			var data = data;
			if(data=="证件号码已存在"){
				layer.open({
					  type: 1,
					  title: false,
					  //打开关闭按钮
					  closeBtn: 1,
					  shadeClose: false,
					  skin: 'tanhcuang',
					  content: "该人员已经存在，无需重复添加！",
					  cancel: function(){ 
					    //右上角关闭回调
					    $('#verify_idcard').modal('hide');
					  }
				});
			}
			else {
				//证件号码不存在时,验证通过,添加人员信息弹窗显示
				$('#verify_idcard').modal('hide');
				//获得最新的人员编号,加1赋值给当前住户
				$.ajax({
					url:getRootPath()+'/index.php/People/getPeopleCode',
					success:function(data){
						var code = parseInt(data) + 1;
						$('#add_person .code').html(code);
					}
				})
				$('#add_person').modal('show');

			}
			//清空已经填入的证件号码信息
			that.closest('.modal-content').find('input[name="id_card"]').val(' ');
		}
	})
})

//新增人员操作
$('#add_person .save_add,#add_person .save').click(function(){
	console.log($(this).hasClass("save"));
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
		else if(!(/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test($.trim(id_number))) &&(id_type=='身份证') ){
			openLayer('证件号码有误!');
		}
		else {
			// openLayer('全部正确!');
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
						    	var person = '<div class="single_person" data-last_name="'+last_name+'" data-first_name="'+first_name+'" data-code="'+code+'"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a><div class="fl"><span class="name">'+last_name+first_name+'</span><span class="id_number">'+id_number+'</span></div></div>';
						    	$('#add_relation .search_person_results').empty();
						    	$('#add_relation .search_person_results').append(person);
						    	//关闭新增住户窗口
						    	$('#add_person').modal('hide');
						    	//开启新增住户关系窗口
						    	$('#add_relation').modal('show');
						    }
						    else {
						    	window.location = getRootPath() + "/index.php/People/managementlist";
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

//新增物业关系时,点击取消后,清空信息
$('#add_relation .cancle').click(function(){
	$('.search_person_wrap .search_person_name').val('');
	$('.search_person_results').empty();
	$('.person_building_data ul').empty();
	$('#add_relation .hire_date').val('');
	$('#add_relation .begin_date').val('');
	$('#add_relation .end_date').val('');
	$('#add_relation .employee_no').val('');
	$('#add_relation .remark').val('');
	$('#add_relation .position_name').val('');
	$('.select_buliding_wrap .select_buliding').empty();
})
//编辑物业关系,点击取消后,清空信息
$('#relation_detail .cancle').click(function(){
	$('.select_buliding_wrap .select_buliding').empty();
})

//新增物业关系时,搜索人员
$('.search_person_wrap .search_person_btn').click(function(){
	var name = $(this).closest('.search_person_wrap').find('.search_person_name').val();
	var search_person_wrap = $(this).closest('.search_person_wrap');
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
								+'</div>';
					console.log(html);
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

	var last_name = single_person.data('last_name');
	var first_name = single_person.data('first_name');
	var code = single_person.data('code');

	var html = '<li data-last_name="'+last_name+'" data-first_name="'+first_name+'" data-code="'+code +'" id="'+code+'"><span class="full_name">'+full_name+'</span><span class="id_number">'+id_number+'</span></li>';
		//只能添加一个物业人员
		if($(".person_building_data ul li").length==0){
			$('.person_building_data ul').append(html);
		}
})


//新增物业关系保存操作
$('#add_relation .save').click(function(){
	var that = $(this);

	var add_relation = $(this).closest('#add_relation');
	//必填项
	var person_code = add_relation.find('.person_building_data li').data('code');
	var hire_date = add_relation.find('.hire_date').val();
	var position_name = add_relation.find('.position_name').val();
	var begin_date = add_relation.find('.begin_date').val();
	var end_date = add_relation.find('.end_date').val();

	var employee_no = add_relation.find('.employee_no').val();
	var remark = add_relation.find('.remark').val();
	var p_bs = add_relation.find('.select_buliding em');

	//必填项验证
	if(!person_code){
		openLayer('请选择人员编号!');
		return;
	}
	if(!hire_date){
		openLayer('请选择入职日期!');
		return;
	}
	if(!position_name){
		openLayer('请选择职位!');
		return;
	}
	if(p_bs.length==0){
		openLayer('请选择至少一个管理区域!');
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
	
	var person_position_datas = [];
	console.log(p_bs.length);
	for(var i=0;i<p_bs.length;i++){
		var p_b = p_bs.eq(i);
		var code = p_b.data('room_code');	
		var person_position_data = '';
		person_position_data = {
			code:code
		}
		person_position_datas[i] = person_position_data;
	}
	console.log(person_position_datas);
	//提交数据到后端
	$.ajax({
		type:"POST",
		url : getRootPath()+'/index.php/People/insertPersonPosition',
		data:{
			person_code:person_code,
			position_code:add_relation.find('.position_name').data('ajax'),
			hire_date:hire_date,
			begin_date:begin_date,
			end_date:end_date,
			position_name:position_name,
			remark:remark,
			employee_no:employee_no,
			territorys:person_position_datas
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
				    //跳转到列表页
				    window.location = getRootPath() + "/index.php/People/managementlist";
				  }
			});
		},
		error:function(){

		}
	})

})

//编辑人员信息
$('#write_person .save').click(function(){
	var that = $(this);
	//必填项
	var add_pesron = $(this).closest('#write_person');
	var code = add_pesron.find('.code').html();
	var last_name = add_pesron.find('input[name="last_name"]').val();
	var first_name = add_pesron.find('input[name="first_name"]').val();
	var id_type = add_pesron.find('input[name="id_type"]').val();
	var id_number = add_pesron.find('input[name="id_number"]').val();
	var nationality = add_pesron.find('input[name="nationality"]').val();
	var gender  = add_pesron.find('input[name="gender"]').val();
	var birth_date  = add_pesron.find('input[name="birth_date"]').val();
	var blood_type   = add_pesron.find('input[name="blood_type"]').val();
	var if_disabled  = "false";
	var ethnicity  = add_pesron.find('input[name="ethnicity"]').val();
	var mobile_number = add_pesron.find('input[name="mobile_number"]').val();
	var tel_country = add_pesron.find('input[name="tel_country"]').val();

	var oth_mob_no  = add_pesron.find('input[name="oth_mob_no"]').val();
	var remark  = add_pesron.find('input[name="remark"]').val();

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
	else if(!birth_date){
		openLayer('请选择出生年月!');
	}
	else if(!blood_type){
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
		else if(!(/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test($.trim(id_number))) &&(id_type=='身份证') ){
			openLayer('证件号码有误!');
		}
		else {
			// openLayer('全部正确!');
			//验证通过,进行下一步
			//数据写入库
			$.ajax({
				url:getRootPath()+'/index.php/People/updatePeople',
				method:'post',
				data:{
					code:code,
					last_name:last_name,
					first_name:first_name,
					id_type:add_pesron.find('input[name="id_type"]').data('ajax'),
					id_number:id_number,
					nationality:nationality,
					gender:add_pesron.find('input[name="gender"]').data('ajax'),
					birth_date:birth_date,
					if_disabled:if_disabled,
					bloodtype:add_pesron.find('input[name="blood_type"]').data('ajax'),
					ethnicity:add_pesron.find('input[name="ethnicity"]').data('ajax'),
					tel_country:tel_country,
					mobile_number:mobile_number,
					oth_mob_no:oth_mob_no,
					remark:remark,
					//带search的参数用于异步刷新页面时做分页和查询总条数
					search_keyword:search_keyword,
					search_effective_date:search_effective_date
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
					    		asynRefreshPage(getRootPath()+'/index.php/People/managementlist','People/getPeoplePositionList',table,data.managementlist_total,'&keyword='+search_keyword+'&effective_date='+search_effective_date);
					    	  	$('#write_person').modal('hide');
						  }
					});
				},
				error:function(){
					console.log('编辑人员出错');
				}
			})
		}
	}
})

//编辑物业关系保存操作
$('#relation_detail .save').click(function(){
	var that = $(this);
	var add_relation = $(this).closest('#relation_detail');
	var end_date = add_relation.find('.end_date').val();
	var begin_date = add_relation.find('.begin_date').html();
	var remark = add_relation.find('.remark').val();
	var position_name = add_relation.find('.position_name').val();
	var pp_code = add_relation.find('.pp_code').val();

	//必填项
	if(!end_date){
		openLayer('请选择结束日期!');
		return;
	}
	if(begin_date>end_date){
		openLayer('开始日期不能晚于结束日期!');
		return;
	}
	if(!position_name){
		openLayer('请选择职位!');
		return;
	}

	$.ajax({
		url:getRootPath()+'/index.php/People/updatePersonPosition',
		method:'post',
		data:{
			code:pp_code,
			end_date:end_date,
			position_code:add_relation.find('.position_name').data('ajax'),
			remark:remark,
			//带search的参数用于异步刷新页面时做分页和查询总条数
			search_keyword:search_keyword,
			search_effective_date:search_effective_date
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
				  	//编辑完后异步刷新页面
				  	asynRefreshPage(getRootPath()+'/index.php/People/managementlist','People/getPeoplePositionList',table,data.businesslist_total,'&keyword='+search_keyword+'&effective_date='+search_effective_date);
				    $('#relation_detail').modal('hide');
				  }
			});

		},
		error:function(){
			console.log('编辑楼宇出错');
		}
	})

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

window.operateEvents = {
	//点击详情时,弹出物业人员详情框
	'click .detail':function(e,value,row,index){
		$('#person_detail').modal('show');
		console.log(row);
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
		var person_remark = row.person_remark;
		var if_disabled_name = row.if_disabled_name;
		var id_type_name = row.id_type_name;
		var begin_date = row.begin_date;
		var end_date = row.end_date;
		var building_code = row.building_code;
		var household_type_name = row.household_type_name;
		var person_code = row.person_code;
		var building_code = row.building_code;
		var hire_date = row.hire_date;
		var employee_no  = row.employee_no;
		var name  = row.name;
		var position_type_name  = row.position_type_name;
		var position_grade_name  = row.position_grade_name;
		var territory_name  = row.territory_name;
		var parent_code  = row.parent_code;

		$('#person_detail').find('.full_name').html(full_name);
		$('#person_detail').find('.id_number').html(id_number);
		$('#person_detail').find('.gender_name').html(gender_name);
		$('#person_detail').find('.birth_date').html(birth_date);
		$('#person_detail').find('.ethnicity_name').html(ethnicity_name);
		$('#person_detail').find('.blood_type_name').html(blood_type_name);
		$('#person_detail').find('.nationality').html(nationality);
		$('#person_detail').find('.mobile_number').html(mobile_number);
		$('#person_detail').find('.remark').html(person_remark);
		$('#person_detail').find('.if_disabled_name').html(if_disabled_name);
		$('#person_detail').find('.id_type_name').html(id_type_name);
		$('#person_detail').find('.begin_date').html(begin_date);
		$('#person_detail').find('.end_date').html(end_date);
		$('#person_detail').find('.building_code').html(building_code);
		$('#person_detail').find('.household_type_name').html(household_type_name);
		$('#person_detail').find('.oth_mob_no').html(oth_mob_no);
		$('#person_detail').find('.hire_date').html(hire_date);
		$('#person_detail').find('.employee_no').html(employee_no);
		$('#person_detail').find('.name').html(name);
		$('#person_detail').find('.position_type_name').html(position_type_name);
		$('#person_detail').find('.position_grade_name').html(position_grade_name);
		$('#person_detail').find('.territory_name').html(territory_name);

		//得到上级领导姓名及职位
		$.ajax({
			url:getRootPath()+'/index.php/People/getPersonPositionByCode',
			method:'post',
			data:{
				parent_code:parent_code
			},
			success:function(data){
				var data = JSON.parse(data);
				console.log(data);	
				var html_tmp = "<p><span class='des'>"+data.name+"</span><span class='building_code'>"+data.position_name+"</span></p>";
				$('.parent_position_name').empty();			
				$('.parent_position_name').append(html_tmp);			
			},
			error:function(){
				console.log('新增楼宇出错');
			}
		})
		

	},

	//点击编辑人员详情时,弹出人员信息编辑框
	'click .rewrite':function(e,value,row,index){
		$('#write_person').modal('show');
		var person_code = row.person_code;
		var full_name = row.full_name;
		var last_name = row.last_name;
		var first_name = row.first_name;
		var id_type = row.id_type;
		var id_type_name = row.id_type_name;
		var id_number = row.id_number;
		var nationality = row.nationality;
		var gender_name = row.gender_name;
		var gender = row.gender;
		var birth_date = row.birth_date;
		var if_disabled_name = row.if_disabled_name;
		var if_disabled = row.if_disabled;
		var blood_type_name = row.blood_type_name;
		var blood_type = row.blood_type;
		var ethnicity_name = row.ethnicity_name;
		var ethnicity = row.ethnicity;
		var mobile_number = row.mobile_number;
		var oth_mob_no = row.oth_mob_no;
		var remark = row.remark;
		var person_remark = row.person_remark;

		//赋值
		$('#write_person').find('.code').html(person_code);
		$('#write_person').find('.last_name').val(last_name);
		$('#write_person').find('.first_name').val(first_name);
		$('#write_person').find('.id_type').val(id_type_name);
		$('#write_person').find('.id_type').data('ajax',id_type);
		$('#write_person').find('.id_number').val(id_number);
		$('#write_person').find('.nationality').val(nationality);
		$('#write_person').find('.gender').val(gender_name);
		$('#write_person').find('.gender').data('ajax',gender);
		$('#write_person').find('.birth_date').val(birth_date);
		$('#write_person').find('.if_disabled').val(if_disabled_name);
		$('#write_person').find('.if_disabled').data('ajax',if_disabled);
		$('#write_person').find('.blood_type').val(blood_type_name);
		$('#write_person').find('.blood_type').data('ajax',blood_type);
		$('#write_person').find('.ethnicity').val(ethnicity_name);
		$('#write_person').find('.ethnicity').data('ajax',ethnicity);
		$('#write_person').find('.mobile_number').val(mobile_number);
		$('#write_person').find('.oth_mob_no').val(oth_mob_no);
		$('#write_person').find('.remark').val(person_remark);
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
				console.log(data);
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
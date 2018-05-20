//日期控件初始化
var now = new Date();
now = formatDate(now);
//后端设置的分页参数
var pagesize = $('input[name="pagesize"]').val();
$('.date').datetimepicker({
	format: 'YYYY-MM-DD',
});

 

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
						    	var person = '<div class="single_person" data-last_name="'+last_name+'" data-first_name="'+first_name+'" data-code="'+code+'"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a><div class="fl"><span class="name">'+last_name+first_name+'</span><span class="id_number">'+id_number+'</span></div><div class="select_pull_down query_wrap col_37A fl"><div><input type="text" class="model_input household_type ka_input3" placeholder="住户类别" name="household_type" data-ajax="" readonly=""></div><div class="ka_drop" style="display: none;"><div class="ka_drop_list"><ul><li><a href="javascript:;" data-ajax="101">户主</a></li><li><a href="javascript:;" data-ajax="102">家庭成员</a></li><li><a href="javascript:;" data-ajax="103">访客</a></li><li><a href="javascript:;" data-ajax="104">租客</a></li></ul></div></div></div></div>';
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
	$('.search_person_wrap .search_person_name').val(' ');
	$('.search_person_results').empty();
	$('.person_building_data ul').empty();
	$('#add_relation .hire_date').val(' ');
	$('#add_relation .begin_date').val(' ');
	$('#add_relation .end_date').val(' ');
	$('#add_relation .employee_no').val(' ');
	$('#add_relation .remark').val(' ');
	$('#add_relation .position_grade').val(' ');
	$('#add_relation .position_grade').data('ajax',' ');
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
		$('#person_detail').find('.building_code').html(building_code);
		$('#person_detail').find('.household_type_name').html(household_type_name);
		$('#person_detail').find('.oth_mob_no').html(oth_mob_no);

		//得到该住户在本小区的其它房间
		

		//得到该住户的同房间住户
		

	},

	//点击编辑住户详情时,弹出住户信息编辑框
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
		//赋值
		$('#relation_detail').find('.building_code').html(building_code);
		$('#relation_detail').find('.person_code').html(person_code);
		$('#relation_detail').find('.full_name').html(full_name);
		$('#relation_detail').find('.id_number').html(id_number);
		$('#relation_detail').find('.begin_date').html(begin_date);
		$('#relation_detail').find('.end_date').val(end_date);
		$('#relation_detail').find('.household_type_name').html(household_type_name);
	}
}
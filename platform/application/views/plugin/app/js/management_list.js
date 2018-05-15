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
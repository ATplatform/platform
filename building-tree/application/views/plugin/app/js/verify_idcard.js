//新增人员前验证证件号码以及自动赋值
$('#verify_idcard .next').click(function(){
	var that = $(this);
	var id_card = $(this).closest('.modal-content').find('input[name="id_card"]').val();
	id_card = trim(id_card);
	console.log(id_card[16]);
	console.log(id_card.length);
	if(!id_card){
		openLayer('请输入证件号码');
		return;
	}
	if(!/^[0-9]*$/.test(id_card)){
		openLayer('请输入数字');
		return;
	}
	//如果证件号码长度是18位,则验证是否符合二代身份证规则
	if(id_card.length==18){
		if(!(/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(id_card))){
			openLayer('证件号码有误');
			return;
		}
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
				//并且给身份证号码赋值,默认不能修改
				$('#add_person').find('.id_number').val(id_card);
				//根据证件号码的长度来确定证件类型,如果是18位,1默认为二代身份证,不能修改,2国籍默认为中国 3 自动选择性别 4 自动赋值出生日期
				if(id_card.length==18){
					var gender_num = id_card[16];
					var gender_name = '';
					var gender_ajax = '';
					var birth_day = id_card[6]+id_card[7]+id_card[8]+id_card[9]+'-'+ id_card[10]+id_card[11]+'-'+ id_card[12]+id_card[13];

					$('#add_person').find('.id_type').val('身份证');
					$('#add_person').find('.id_type').data('ajax',101);
					$('#add_person').find('.nationality').val('中国');
					$('#add_person').find('.nationality').data('ajax',101);
					//表示偶数,为女性
					if(gender_num%2==0){
						gender_name = '女';
						gender_ajax = '102';
					}
					else{
						gender_name = '男';
						gender_ajax = '101';
					}
					$('#add_person').find('.gender').val(gender_name);
					$('#add_person').find('.gender').data('ajax',gender_ajax);
					$('#add_person').find('.birth').val(birth_day);
					$('#add_person').find('.birth').attr('readonly',true);
				}
				//如果是其它的,1 赋值身份证类型下拉框 2 赋值国籍下拉框 3赋值性别下拉框
				else{
					var id_type_arr = '<li><a href="javascript:;" data-ajax="102">境外护照</a></li><li><a href="javascript:;" data-ajax="103">回乡证</a></li><li><a href="javascript:;" data-ajax="104">台胞证</a></li><li><a href="javascript:;" data-ajax="105">军官证/士兵证</a>';
					var nationality_arr = '<li><a href="javascript:;" data-ajax="102">香港</a></li><li><a href="javascript:;" data-ajax="103">澳门</a></li><li><a href="javascript:;" data-ajax="104">台湾</a></li><li><a href="javascript:;" data-ajax="105">新加坡</a></li><li><a href="javascript:;" data-ajax="106">美国</a></li><li><a href="javascript:;" data-ajax="107">日本</a></li><li><a href="javascript:;" data-ajax="108">韩国</a></li>';
					var gender_arr = '<li><a href="javascript:;" data-ajax="101">男</a></li><li><a href="javascript:;" data-ajax="102">女</a></li>';
					$('#add_person').find('.id_type').closest('.select_pull_down').find('.ka_drop_list ul').append(id_type_arr);
					$('#add_person').find('.nationality').closest('.select_pull_down').find('.ka_drop_list ul').append(nationality_arr);
					$('#add_person').find('.gender').closest('.select_pull_down').find('.ka_drop_list ul').append(gender_arr);
				}
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

//新增人员点击取消时,清空之前填入的信息
$('#add_person .cancle').click(function(){
	$('#add_person').find('.id_type').val(' ');
	$('#add_person').find('.id_type').data('ajax',' ');
	$('#add_person').find('.nationality').val(' ');
	$('#add_person').find('.nationality').data('ajax',' ');

	$('#add_person').find('.gender').val(' ');
	$('#add_person').find('.gender').data('ajax',' ');
	$('#add_person').find('.birth').val(' ');
	$('#add_person').find('.birth').attr('readonly',false);

	$('#add_person').find('.id_type').closest('.select_pull_down').find('.ka_drop_list ul').empty();
	$('#add_person').find('.nationality').closest('.select_pull_down').find('.ka_drop_list ul').empty();
	$('#add_person').find('.gender').closest('.select_pull_down').find('.ka_drop_list ul').empty();
})
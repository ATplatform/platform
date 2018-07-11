//日期控件初始化
var now = new Date();
now = formatDate(now);
var lastMonthDate = getLastMonthYestdy();
var table = $('#table');
var today_time = now +" "+new Date().getHours()+":"+new Date().getMinutes()+":"+new Date().getSeconds();
var nextMonthDay = getNextMonth(now) +" "+new Date().getHours()+":"+new Date().getMinutes()+":"+new Date().getSeconds();
//带search的参数用于异步刷新页面时做分页和查询总条数
var search_keyword = getUrlParam('keyword');
var search_start_date = getUrlParam('push_start_date');
var search_end_date = getUrlParam('push_end_date');
var search_msg_type = getUrlParam('msg_type');
var search_cycle_type = getUrlParam('cycle_type');

$('.add_building input[name="effective_date"]').val(now);
var messagecode = '';
var target = ' ';
var confirm_msg = false;
//推送时间精确到分
$('input[name="push_start_date"],input[name="push_end_date"],.end_date').datetimepicker({
    language:  'zh-CN',
    format: 'yyyy-mm-dd hh:ii',
    weekStart: 1,
    todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	forceParse: 1,
	minView:0,
    showMeridian: 1
});
//获得信息编号
$.ajax({
	url:getRootPath()+'/index.php/Message/getMessageCode',
	success:function(data){
		messagecode = parseInt(data) + 1;
		$('#add_message .building .code').html(messagecode);
	}
})
//获得信息标识图片
$.ajax({
	url:getRootPath()+'/index.php/Message/getMsgImg',
	success:function(data){
		var data = JSON.parse(data);
		for(var i=0;i<data.length;i++){
			var img = data[i];
			var li = "<li><img src='"+img+"' /></li>";
			$('#add_message .msg_img_wrap').append(li);
		}
	}
})

//初始化编辑器
var ue = UE.getEditor('editor',{
	toolbars: [[
		'undo', 'redo', '|',
	    'bold', 'italic', 'underline', 'removeformat', 'formatmatch', '|', 'forecolor', 'cleardoc', '|',
	    'fontsize', '|',
	     'indent', 
	    'justifyleft','justifycenter','justifyright',
	     'insertimage',  'insertvideo'	
    ]]
});
ue.ready(function(){
	var datahtml = ue.getContent();
})


//点击确认信息编辑
$('#confirm_message .view').click(function(){
	confirm_msg = true;
})
//点击删除重新编辑信息
$('#confirm_message .cancle').click(function(){
	confirm_msg = false;
})
//预览时点击返回
$('#confirm_message .cancle').click(function(e){
	$('#confirm_message').modal('hide');
	$('#add_message').modal('show');
	$('body').css({'overflow':'hidden'});
	$('#add_message').css({'overflow-y': 'auto'});
})

//点击选中图片
$(document).on('click','#add_message .msg_img_wrap li',function(){
	$(this).addClass('active').siblings('li').removeClass('active');
})

//编辑信息预览点击横屏和竖屏切换
$('#confirm_message .switch_screen .lie').click(function(){
	$(this).siblings('span').removeClass('active');
	$(this).addClass('active');
	$('.msg_html').css({
		'width':'568',
		'height':'320'
	})
})
$('#confirm_message .switch_screen .stand').click(function(){
	$(this).siblings('span').removeClass('active');
	$(this).addClass('active');
	$('.msg_html').css({
		'width':'320',
		'height':'568'
	})
})

//推送对象元素显示隐藏
$('.target_wrap label').click(function(){
	var that = $(this).prev('input[type="radio"]');
	that.closest('.target_wrap').find('.select_buliding_wrap').hide();
	that.closest('.target_wrap').find('.search_equipment_wrap').hide();
	that.closest('div').find('input[type="radio"]').attr('checked',false);

	that.attr('checked',true);
	that.closest('div').find('.select_buliding_wrap').show();
	that.closest('div').find('.search_equipment_wrap').show();
})

//是否缴费信息元素显示隐藏
$('.if_bill_wrap label').click(function(){
	var that = $(this).prev('input[type="radio"]');
	that.closest('.if_bill_wrap').find('input[type="radio"]').attr('checked',false);
	that.attr('checked',true);
	if($('.if_bill_wrap input[type="radio"]').eq(0).attr('checked')){
		that.closest('.if_bill_wrap').find('.bill_amount_wrap').hide();
		that.closest('.if_bill_wrap').find('.bill_amount').attr("readonly","readonly");
	}
	else{
		that.closest('.if_bill_wrap').find('.bill_amount_wrap').show();
		that.closest('.if_bill_wrap').find('.bill_amount').removeAttr("readonly");
	}
})

//消息循环方式元素显示隐藏
$('.if_cycle_wrap label').click(function(){
	var that = $(this).prev('input[type="radio"]');
	that.closest('.if_cycle_wrap').find('input[type="radio"]').attr('checked',false);
	that.attr('checked',true);
	// alert(that.attr('checked'));
	//一次性立即消息
	if($('.if_cycle_wrap input[type="radio"]').eq(0).attr('checked')){
		$('.select_cycle_type_wrap').hide();
		$('.push_end_date_wrap').hide();
		//一次性立即消息,不需要填推送时间
		$('.push_start_date_wrap').hide();
	}
	//一次性定时消息
	else if($('.if_cycle_wrap input[type="radio"]').eq(1).attr('checked')){
		$('.select_cycle_type_wrap').hide();
		$('.push_end_date_wrap').hide();
		$('.push_start_date_wrap').show();
		$('.push_start_date_wrap .push_start_date').val(today_time);
	}
	//循环消息
	else{
		$('.select_cycle_type_wrap').show();
		$('.push_start_date_wrap').show();
		$('.push_end_date_wrap').show();
		$('.push_start_date_wrap .push_start_date').val(today_time);
		$('.push_end_date_wrap .push_end_date').val(nextMonthDay);
	}
})

//点击预览编辑内容
$('#add_message .view').click(function(){
	msg_link = '';
	ids_datas = [];
	target = '';
	cycle_type = '';
	push_end_date ="";
	push_start_date ="";
	//选择全体小区或者指定住户时,target_type为101,如果选择推送对象为设备,则target_type为102
	if($('.target_wrap input[type="radio"]').eq(0).is(':checked')){
		//整个小区都推送,推送对象为小区id
		target_type = 101;
		target = $('#add_message .village_id').val();
	}
	else if($('.target_wrap input[type="radio"]').eq(1).is(':checked')){
		target_type = 101;
		var p_bs = $('.target_wrap').find('.select_buliding em');
		for(var i=0;i<p_bs.length;i++){
			var p_b = p_bs.eq(i);
			var code = p_b.data('room_code');	
			target += code +',';
		}
		if(!target.length){
			openLayer('请至少选择一个推送住户!');
			return;
		}
		else{
			//去掉最后一个逗号
			target=target.substring(0,target.length-1);
		}
	}
	else if($('.target_wrap input[type="radio"]').eq(2).is(':checked')){
		target_type = 102;

		var bs = $('.target_wrap').find('.person_building_data li');
		for(var i=0;i<bs.length;i++){
			var b = bs.eq(i);
			var code = b.data('code');	
			target += code +',';
		}
		if(!target.length){
			openLayer('请至少选择一个推送设备!');
			return;
		}
		else{
			//去掉最后一个逗号
			target=target.substring(0,target.length-1);
		}
	}

	if($('.msg_type_wrap input[type="radio"]').eq(0).is(':checked')){
		msg_type = 101;
	}
	else if($('.msg_type_wrap input[type="radio"]').eq(1).is(':checked')){
		msg_type = 102;
	}
	else{
		msg_type = 103;
	}

	bill_amount = $('.if_bill_wrap .bill_amount').val();
	if($('.if_bill_wrap input[type="radio"]').eq(0).is(':checked')){
		if_bill = 0;
	}
	else{
		if_bill = 1;
		if(!bill_amount){
			openLayer('请输入缴费金额!');
			return;
		}
		if(!(/^\d+(?:\.\d{1,2})?$/.test(bill_amount))){
			openLayer('金额只能输入整数和最多两位小数!');
			return;
		}
	}

	//循环类型
	if($('.if_cycle_wrap input[type="radio"]').eq(0).is(':checked')){
		if_cycle = 101;
	}
	else if($('.if_cycle_wrap input[type="radio"]').eq(1).is(':checked')){
		if_cycle = 102;
	}
	else{
		if_cycle = 103;
		cycle_type = $('#add_message .cycle_type').data('ajax');
		push_end_date = $('#add_message .push_end_date').val();
		if(!cycle_type){
			openLayer('请选择循环周期!');
			return;
		}
		if(!push_end_date){
			openLayer('请输入截止日期!');
			return;
		}
	}
	push_start_date = $('#add_message .push_start_date').val();
	//不是立即推送的消息,要传入推送时间
	if(if_cycle!=101){
		if(!push_start_date){
			openLayer('请输入推送时间!');
			return;
		}
	}
	//回执
	if($('.if_receipt_wrap input[type="radio"]').eq(0).is(':checked')){
		if_receipt = 0;
	}
	else{
		if_receipt = 1;
	}

	//获得标识图片
	msg_img = $('#add_message .msg_img_wrap .active img').attr('src');
	if(!msg_img){
		openLayer('请选择标识图片!');
		return;
	}

	msg_title = $('#add_message .msg_title').val();

	if(!msg_title){
		openLayer('请输入信息标题!');
		return;
	}

	var content = ue.getContent();
	var push_time = $('#add_message .push_time').val();
	if(!content){
		openLayer('请输入信息内容!');
		return;
	}

	$('#add_message').modal('hide');

	$.ajax({
		url : getRootPath()+'/index.php/Message/addContent',
		type : "POST",
		dataType : "text",
		data : {
		    messagecode:messagecode,
		    content: content
		},
		success:function(message){
			msg_link = JSON.parse(message);
			$('#confirm_message .msg_html').attr('src',msg_link);
			$('#confirm_message').modal('show');
		}
	})
})
//预览界面点击保存\推送按钮
$('#confirm_message .add,#confirm_message .view').click(function(){
	$.ajax({
		url : getRootPath()+'/index.php/Message/addMessage',
		type : "POST",
		dataType : "text",
		data : {
		    messagecode:messagecode,
		    msg_type:msg_type,
		    if_cycle:if_cycle,
		    cycle_type:cycle_type,
		    if_bill:if_bill,
		    bill_amount:bill_amount,
		    if_receipt:if_receipt,
		    msg_title:msg_title,
		    msg_link: msg_link,
		    msg_img:msg_img,
		    target_type:target_type,
		    target:target,
		    push_end_date:push_end_date,
		    push_start_date:push_start_date
		},
		success:function(message){
			var data = JSON.parse(message);
			$('#confirm_message').modal('hide');
			openLayer(data.message);
			//添加完成之后跳转页面
			var now = getDate();
			window.location.href="messagelist?page=1"+'&push_start_date='+lastMonthDate+' 00:00 &push_end_date='+now+" 23:59";
		}
	})

})

//信息管理操作
function operateFormatter(value,row,index){
	return [
	    '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
	    '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
	    '</a>',
	    '<a class="rewrite" href="javascript:void(0)" style="margin-left: 10px;"   title="编辑信息">',
	    '<i class="fa fa-id-card"></i>',
	    '</a>'
	].join('');
}
window.operateEvents = {
	//点击详情时,弹出信息详情框
	'click .detail':function(e,value,row,index){
		$('#message_detail').modal('show');
		console.log(row);
		var code = row.code;
		var cycle_type_name = row.cycle_type_name;
		var if_bill_name = row.if_bill_name;
		var if_bill = row.if_bill;
		var bill_amount = row.bill_amount;
		var if_receipt_name = row.if_receipt_name;
		var msg_type_name = row.msg_type_name;
		var link = row.link;
		var msg_title = row.msg_title;
		var push_start_date = row.push_start_date;
		var push_end_date = row.push_end_date;
		var target = row.target;
		var if_cycle = row.if_cycle;
		var target_type = row.target_type;
		var target_arr = [];
		//传给后端数组,方便查找
		target = target.substr(1);
		target = target.substr(0,target.length-1);
		target_arr = target.split(',');

		//是缴费信息时才显示缴费金额
		if(if_bill==0){
			$('#message_detail').find('span.bill_amount').hide();
		}
		else{
			$('#message_detail').find('span.bill_amount').show();
		}
		//是循环消息才显示消息截止时间
		if(if_cycle==103){
			$('#message_detail').find('.push_end_date_wrap').show();
		}
		else{
			$('#message_detail').find('.push_end_date_wrap').hide();
		}

		$('#message_detail').find('.code').html(code);
		$('#message_detail').find('.cycle_type_name').html(cycle_type_name);
		$('#message_detail').find('.if_bill_name').html(if_bill_name);
		$('#message_detail').find('.bill_amount span').html(bill_amount);
		$('#message_detail').find('.if_receipt_name').html(if_receipt_name);
		$('#message_detail').find('.msg_type_name').html(msg_type_name);
		$('#message_detail').find('.msg_title').html(msg_title);
		$('#message_detail').find('.push_start_date').html(push_start_date);
		$('#message_detail').find('.push_end_date').html(push_end_date);
		$('#message_detail').find('.msg_html').attr('src',link);
		//得到所有的推送对象
		$.ajax({
			url:getRootPath()+'/index.php/Message/getMessageTarget',
			method:'post',
			dataType:'json',
			data:{
				target_type:target_type,
				target:target_arr
			},
			success:function(data){
				console.log(data);
				// var data = JSON.parse(data);
				var html_tmp = "";
				console.log(data);
				for(var i=0;i<data.length;i++){
					html_tmp += "<em >"+data[i]['household']+"</em>";
				}	
				$('#message_detail .target_wrap').empty();			
				$('#message_detail .target_wrap').append(html_tmp);			
			},
			error:function(){
				console.log('数据出错');
			}
		})
		
	},

	//点击编辑时,弹出信息编辑框
	'click .rewrite':function(e,value,row,index){
		$('#message_write').find('.end_date').val(' ');
		var code = row.code;
		var if_cycle = row.if_cycle;
		var cycle_type = row.cycle_type;
		var cycle_type_name = row.cycle_type_name;
		var if_bill = row.if_bill;
		var if_bill_name = row.if_bill_name;
		var bill_amount = row.bill_amount;
		var if_receipt_name = row.if_receipt_name;
		var msg_type_name = row.msg_type_name;
		var link = row.link;
		var msg_title = row.msg_title;
		var push_start_date = row.push_start_date;
		var push_end_date = row.push_end_date;
		var target = row.target;
		var target_arr = [];
		target = target.substr(1);
		target = target.substr(0,target.length-1);
		target_arr = target.split(',');

		//只有循环消息才可以编辑
		if(if_cycle==103){

			//是缴费信息时才显示缴费金额
			if(if_bill==0){
				$('#message_write').find('span.bill_amount').hide();
			}
			else{
				$('#message_write').find('span.bill_amount').show();
			}
			$('#message_write').find('.code').html(code);
			$('#message_write').find('.cycle_type_name').html(cycle_type_name);
			$('#message_write').find('.if_bill_name').html(if_bill_name);
			$('#message_write').find('.bill_amount span').html(bill_amount);
			$('#message_write').find('.if_receipt_name').html(if_receipt_name);
			$('#message_write').find('.msg_type_name').html(msg_type_name);
			$('#message_write').find('.msg_title').html(msg_title);
			$('#message_write').find('.push_start_date').html(push_start_date);
			$('#message_write').find('.msg_html').attr('src',link);
			if(push_end_date){
				$('#message_write').find('.end_date').val(push_end_date);
			}
			else{
				$('#message_write').find('.end_date').attr('disabled',true);
			}

			//得到所有的推送对象
			$.ajax({
				url:getRootPath()+'/index.php/Message/getMessageTarget',
				method:'post',
				dataType:'json',
				data:{
					target:target_arr
				},
				success:function(data){
					console.log(data);
					var html_tmp = "";
					console.log(data);
					for(var i=0;i<data.length;i++){
						html_tmp += "<em>"+data[i]['household']+"</em>";
					}	
					$('#message_write .target_wrap').empty();			
					$('#message_write .target_wrap').append(html_tmp);			
				},
				error:function(){
					console.log('数据出错');
				}
			})

			//点击保存,修改结束日期
			$('#message_write .save').click(function(){
				//之前有结束日期的才能修改
				if(push_end_date){
					var new_end_date = $('#message_write').find('.end_date').val();
					$.ajax({
						url:getRootPath()+'/index.php/Message/updateMessage',
						method:'post',
						data:{
							push_end_date:new_end_date,
							code:code,
							search_push_start_date:search_start_date,
							search_push_end_date:search_end_date,
							search_msg_type:search_msg_type,
							search_cycle_type:search_cycle_type,
							search_keyword:search_keyword
						},
						success:function(data){
							$('#message_write').modal('hide');
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
				    	    		asynRefreshPage(getRootPath()+'/index.php/Message/messagelist','Message/getMessageList',table,data.total,'&keyword='+search_keyword+"&msg_type="+search_msg_type+'&cycle_type='+search_cycle_type+'&push_start_date='+search_start_date+'&push_end_date='+search_end_date);
								  }
							});
						},
						error:function(){
							console.log('数据出错');
						}
					})

				}
				else {
					$('#message_write').modal('hide');
				}
			})
			$('#message_write').modal('show');
		}
		else{
			openLayer('非循环消息不可再编辑!');
		}

		

	}
}
$('#message_write .cancle').click(function(){

})
//新增设备授权时,搜索设备
$('#add_message .search_equipment_wrap .search_person_btn').click(function(){
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
//将设备搜索的结果添加
$(document).on('click','.search_equipment_wrap .single_person .add',function(){
	var single_person = $(this).closest('.single_person');
	var code = single_person.find('.name').html();
	var eqip_name = single_person.find('.eqip_name').html();
	var address = single_person.find('.address').html();

	var html = '<li data-code="'+code +'" id="'+code+'"><span class="name">'+code+'</span><span class="eqip_name">'+eqip_name+'</span><span class="address">'+address+'</span><i class="fa fa-close"></i></li>';
		//只能添加10个内
		if($(this).closest('.search_equipment_wrap').find(".person_building_data ul li").length<10){
			//不能重复添加
			if($(this).closest('.search_equipment_wrap').find("#"+code).length==0){
				$(this).closest('.search_equipment_wrap').find('.person_building_data ul').append(html);
			}
		}
})
//点击删除节点
$(document).on('click','.person_building_data ul li .fa-close',function(){
	$(this).closest('li').remove();
})
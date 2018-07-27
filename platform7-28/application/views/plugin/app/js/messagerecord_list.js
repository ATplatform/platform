//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var search_keyword = getUrlParam('keyword');
var search_start_date = getUrlParam('push_start_date');
var search_end_date = getUrlParam('push_end_date');
var search_msg_type = getUrlParam('msg_type');
var search_cycle_type = getUrlParam('cycle_type');
var search_push_state = getUrlParam('push_state');

//推送时间精确到分
$('.push_start_date,.push_end_date,.end_date').datetimepicker({
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

//信息管理操作
function operateFormatter(value,row,index){
	return [
	    '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
	    '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
	    '</a>'
	].join('');
}
window.operateEvents = {
	//点击详情时,弹出信息详情框
	'click .detail':function(e,value,row,index){
		$('#message_detail').modal('show');
		console.log(row);
		var code = row.code;
		var if_cycle_name = row.if_cycle_name;
		var if_bill_name = row.if_bill_name;
		var bill_amount = row.bill_amount;
		var if_receipt_name = row.if_receipt_name;
		var msg_type_name = row.msg_type_name;
		var link = row.link;
		var msg_title = row.msg_title;
		var push_start_date = row.push_time;
		var push_end_date = row.push_end_date;
		var equipment_name = row.equipment_name;
		var household = row.household;
		var push_household = row.push_household;
		var if_cycle = row.if_cycle;
		var target = row.target;
		var first_read_time = row.first_read_time;
		var last_read_time = row.last_read_time;
		var read_times = row.read_times;
		var target_arr = [];
		//传给后端数组,方便查找
		target = target.substr(1);
		target = target.substr(0,target.length-1);
		target_arr = target.split(',');

		//是循环消息才显示消息截止时间
		if(if_cycle==103){
			$('#message_detail').find('.push_end_date_wrap').show();
		}
		else{
			$('#message_detail').find('.push_end_date_wrap').hide();
		}

		//是缴费消息时,才显示缴费金额
		if(if_bill_name=="是"){
			$('#message_detail').find('.bill_amount').show();
		}
		else{
			$('#message_detail').find('.bill_amount').hide();
		}

		//如果有推送对象(设备),就不显示推送地址
		if(equipment_name){
			$('#message_detail').find('.target_wrap_main').show();
		}
		else {
			$('#message_detail').find('.target_wrap_main').hide();
		}

		$('#message_detail').find('.code').html(code);
		$('#message_detail').find('.cycle_type_name').html(if_cycle_name);
		$('#message_detail').find('.if_bill_name').html(if_bill_name);
		$('#message_detail').find('.bill_amount span').html(bill_amount);
		$('#message_detail').find('.if_receipt_name').html(if_receipt_name);
		$('#message_detail').find('.msg_type_name').html(msg_type_name);
		$('#message_detail').find('.msg_title').html(msg_title);
		$('#message_detail').find('.push_start_date').html(push_start_date);
		$('#message_detail').find('.push_end_date').html(push_end_date);
		$('#message_detail').find('.msg_html').attr('src',link);
		$('#message_detail').find('.target_wrap').html(equipment_name);
		$('#message_detail').find('.push_household').html(push_household);
		$('#message_detail').find('.first_read_time').html(first_read_time);
		$('#message_detail').find('.last_read_time').html(last_read_time);
		$('#message_detail').find('.read_times').html(read_times);
		//得到所有的推送对象
		/*$.ajax({
			url:getRootPath()+'/index.php/Message/getMessageTarget',
			method:'post',
			dataType:'json',
			data:{
				target:target_arr
			},
			success:function(data){
				// console.log(data);
				// var data = JSON.parse(data);
				if(data){
					var html_tmp = "";
					console.log(data);
					for(var i=0;i<data.length;i++){
						html_tmp += "<em data-room_code='"+data[i]['buildings']['room_code']+"'>"+data[i]['household']+"</em>";
					}	
					$('#message_detail .target_wrap').empty();			
					$('#message_detail .target_wrap').append(html_tmp);	
				}
				else{
					$('#message_detail .target_wrap').empty();
				}
			},
			error:function(){
				console.log('数据出错');
			}
		})*/


	}
}
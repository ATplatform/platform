//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var page = getUrlParam('page');
var search_keyword = getUrlParam('keyword');
var search_effective_date = getUrlParam('effective_date');
var search_person_type = getUrlParam('person_type');
var search_building_code = getUrlParam('building_code');

//后端设置的分页参数
var pagesize = $('input[name="pagesize"]').val();
//时间精确到分
$('input[name="push_start_date"],input[name="push_end_date"]').datetimepicker({
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
	    '<i class=" fa fa-lg fa-file-text-o"></i>',
	    '</a>'
	].join('');
}
window.operateEvents = {
	//点击详情时,弹出详情框
	'click .detail':function(e,value,row,index){
		var building_name = row.building_name;
		var call_entry_name = row.call_entry_name;
		var bell_time = row.bell_time;
		var call_eqp_name = row.call_eqp_name;
		var call_duration = row.call_duration;
		var answer_duration = row.answer_duration;
		var full_name = row.full_name;
		var if_open = row.if_open;
		var entry_type_name = row.entry_type_name;
		var entry_time = row.entry_time;
		if(if_open=="是"){
			$('#content_detail .if_open_wrap').show();
		}
		else {
			$('#content_detail .if_open_wrap').hide();
		}

		//赋值
		$('#content_detail .building_name').html(building_name);
		$('#content_detail .call_entry_name').html(call_entry_name);
		$('#content_detail .bell_time').html(bell_time);
		$('#content_detail .call_eqp_name').html(call_eqp_name);
		$('#content_detail .call_duration').html(call_duration);
		$('#content_detail .answer_duration').html(answer_duration);
		$('#content_detail .full_name').html(full_name);
		$('#content_detail .if_open').html(if_open);
		$('#content_detail .entry_type_name').html(entry_type_name);
		$('#content_detail .entry_time').html(entry_time);
		$('#content_detail').modal('show');
		
	}
}
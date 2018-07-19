//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var page = getUrlParam('page');
var search_keyword = getUrlParam('keyword');
var search_effective_date = getUrlParam('effective_date');
var search_equipment_type = getUrlParam('equipment_type');
var search_regular_check = getUrlParam('regular_check');
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
	    '<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
	    '</a>'
	].join('');
}

window.operateEvents = {
	//点击详情时,弹出详情框
	'click .detail':function(e,value,row,index){
		var content_wrap = $('#content_detail');
		var code = row.equipment_code;
		var building_name = row.building_name;
		var name = row.name;
		var regular_check_name = row.regular_check_name;
		var order_type = row.order_type;
		var check_date = row.check_date;
		var complete_time = row.complete_time;
		var person_name = row.person_name;

		content_wrap.find('.code').html(code);
		content_wrap.find('.name').html(name);
		content_wrap.find('.building_name').html(building_name);
		content_wrap.find('.regular_check_name').html(regular_check_name);
		content_wrap.find('.order_type').html(order_type);
		content_wrap.find('.check_date').html(check_date);
		content_wrap.find('.complete_time').html(complete_time);
		content_wrap.find('.person_name').html(person_name);
		
		content_wrap.modal('show');
	}
}
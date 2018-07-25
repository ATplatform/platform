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
		var equipment_name = row.equipment_name;
		var full_name = row.full_name;
		var person_type_name = row.person_type_name;
		var entry_type_name = row.entry_type_name;
		var building_name = row.building_name;
		var entry_time = row.entry_time;

		//赋值
		$('#content_detail .equipment_name').html(equipment_name);
		$('#content_detail .full_name').html(full_name);
		$('#content_detail .person_type_name').html(person_type_name);
		$('#content_detail .entry_type_name').html(entry_type_name);
		$('#content_detail .building_name').html(building_name);
		$('#content_detail .entry_time').html(entry_time);
		$('#content_detail').modal('show');
		
	}
}
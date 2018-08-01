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
		var invite_person = row.invite_person;
		var apply_time = row.apply_time;
		var name = row.name;
		var mobile_number = row.mobile_number;
		var begin_date = row.begin_date;
		var end_date = row.end_date;
		var licence = row.licence;
		var park_name = row.park_name;
		var paid_by_inviter_name = row.paid_by_inviter_name;

		//赋值
		$('#content_detail .invite_person').html(invite_person);
		$('#content_detail .apply_time').html(apply_time);
		$('#content_detail .name').html(name);
		$('#content_detail .mobile_number').html(mobile_number);
		$('#content_detail .begin_date').html(begin_date);
		$('#content_detail .end_date').html(end_date);
		$('#content_detail .licence').html(licence);
		$('#content_detail .park_name').html(park_name);
		$('#content_detail .paid_by_inviter_name').html(paid_by_inviter_name);
		$('#content_detail').modal('show');
		
	}
}
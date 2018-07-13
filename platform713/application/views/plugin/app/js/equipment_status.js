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
		var status_name = row.status_name;
		var equipment_type_name = row.equipment_type_name;
		var building_name = row.building_name;
		var name = row.name;
		var regular_check_name = row.regular_check_name;

		content_wrap.find('.code').html(code);
		content_wrap.find('.name').html(name);
		content_wrap.find('.equipment_type_name').html(equipment_type_name);
		content_wrap.find('.building_name').html(building_name);
		content_wrap.find('.regular_check_name').html(regular_check_name);
		content_wrap.find('.status_name').html(status_name);
		
		content_wrap.modal('show');
	}
}

//每隔10秒更新一次数据
window.localStorage.deivcesList = setInterval(function(){
    var keyword=getUrlParam('keyword');
    var effective_date=getUrlParam('effective_date');
    var equipment_type=getUrlParam('equipment_type');
    var regular_check=getUrlParam('regular_check');
    var building_code=getUrlParam('building_code');
    refreshPage('Equipment/getEquipmentStatus',$('#table'),$('.pager').attr('page'),"&keyword="+keyword+"&effective_date="+effective_date+"&equipment_type="+equipment_type+"&regular_check="+regular_check+"&building_code="+building_code);
},10000);
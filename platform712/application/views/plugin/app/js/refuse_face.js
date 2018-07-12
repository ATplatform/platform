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
var building_code = "";

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
	    '<i class=" fa fa-lg fa-file-text-o"></i>',
	    '</a>'
	].join('');
}
window.operateEvents = {
	//点击详细
	'click .detail':function(e,value,row,index){
		var code = row.code;
		var card_no = row.card_no;
		var full_name = row.full_name;
		var p_id_number = row.p_id_number;
		var p_mobile_number = row.p_mobile_number;
		var apply_person_name = row.apply_person_name;
		var apply_id_number = row.apply_id_number;
		var apply_mobile_number = row.apply_mobile_number;
		var person_type_name = row.person_type_name;
		var person_type = row.person_type;
		var begin_date = row.begin_date;
		var end_date = row.end_date;
		var apply_date = row.apply_date;
		var person_code = row.person_code;
		var apply_person = row.apply_person;
		var pic = row.pic;
		var building_arr = row.building_arr;
		var building_code = row.building_code;
		var source_type = row.source_type;
		var old_img_url = row.old_img_url;
		var reason = row.reason;
		var reject_date = row.reject_date;
		var reject_person_name = row.reject_person_name;
		// alert(apply_person);

		//赋值
		$('#content_detail .code').html(code);
		$('#content_detail .card_no').html(card_no);
		$('#content_detail .person').html(full_name+"--"+p_id_number+"--"+p_mobile_number);
		$('#content_detail .apply_person_name').html(apply_person_name+"--"+apply_id_number+"--"+apply_mobile_number);
		$('#content_detail .person_type_name').html(person_type_name);
		$('#content_detail .begin_date').html(begin_date);
		$('#content_detail .apply_date').html(apply_date);
		$('#content_detail .end_date').html(end_date);
		$('#content_detail .reason').html(reason);
		$('#content_detail .reject_date').html(reject_date);
		$('#content_detail .reject_person_name').html(reject_person_name);
		$('#content_detail .person').data('code',person_code);
		$('#content_detail .apply_person_name').data('code',apply_person);
		$('#content_detail .person_type_name').data('code',person_type);
		$('#content_detail .pic').val(pic);

		var html_tmp = "";
		for(var i=0;i<building_arr.length;i++){
			var building = building_arr[i];
			html_tmp += '<em style="width:440px;" id="'+building['building_code']+'" data-building_code="'+building['building_code']+'">'+building['building_name']+'</em>';
		}

		//根据base64码生成图片
		$.ajax({
			url:getRootPath()+'/index.php/Permission/getFaceUrl',
			method:'post',
			data:{
				person_code:person_code,
				pic:pic
			},
			success:function(data){
				var data = JSON.parse(data);
				var img_url = data.img_url;
				$('#content_detail .img_wrap .img_url').attr('src',getRootPath()+'/'+img_url);
				$('#content_detail input[name="img_url"]').val(img_url);

			},
			error:function(){
				console.log('获取图片出错');
			}
		})

		if(!old_img_url){
			$('#content_detail .img_wrap .old_img_wrap').empty();
			$('#content_detail .img_wrap .old_img_wrap').append('<span>用户预留照片</span><br /><br /><br /><span>缺少预留照片</span>');
		}
		else{
			$('#content_detail .img_wrap .old_img_url').attr('src',getRootPath()+'/'+old_img_url);
		}
		$('#content_detail .select_buliding').empty();
		$('#content_detail .select_buliding').append(html_tmp);
		$('#content_detail').modal('show');
	}
}
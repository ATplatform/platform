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

$(function(){
	//点击删除当前节点
	$('.select_buliding_wrap').on('click','.select_buliding em i',function(){
		$(this).closest('em').remove();
	})
})

//修改
$('#content_write .save').click(function(){
	var content_wrap = $(this).closest('#content_write');
	var code = content_wrap.find('.code').html();

	var b_bs = content_wrap.find('.select_buliding em');
	var building_code = '';
	if(b_bs.length<1){
		openLayer('至少保留一个授权地址!');
		return;
	}
	for(var i=0;i<b_bs.length;i++){
		var b_b = b_bs.eq(i);
		var b_code = b_b.data('code');	
		building_code += b_code +',';
	}
	//去掉最后一个逗号
	building_code=building_code.substring(0,building_code.length-1);

	// alert(building_code);
	$.ajax({
		url:getRootPath()+'/index.php/Permission/updateAccessFace',
		method:'post',
		data:{
			code:code,
			building_code:building_code,
			search_keyword:search_keyword,
			search_effective_date:search_effective_date,
			search_person_type:search_person_type,
			search_building_code:search_building_code
		},
		success:function(data){
			content_wrap.modal('hide');
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
			    		asynRefreshPage(getRootPath()+'/index.php/Permission/permissionfacelist','Permission/getAccessFaceList',table,data.total,'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code);
				  }
			});
			
		},
		error:function(){
			console.log('编辑出错');
		}
	})
})

//信息管理操作
function operateFormatter(value,row,index){
	return [
	    '<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
	    '<i class=" fa fa-lg fa-file-text-o"></i>',
	    '</a>',
	    '<a class="write" href="javascript:void(0)" style="margin-left: 10px;" title="编辑">',
	    '<i class="fa fa-id-card"></i>',
	    '</a>'
	].join('');
}
window.operateEvents = {
	//点击详情时,弹出详情框
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
		var person_code = row.person_code;
		var apply_person = row.apply_person;
		var building_arr = row.building_arr;
		var img_url = row.img_url;
		var source_type = row.source_type;
		var source_type_name = row.source_type_name;
		var old_img_url = row.old_img_url;

		//赋值
		$('#content_detail .code').html(code);
		$('#content_detail .card_no').html(card_no);
		$('#content_detail .person').html(full_name+"--"+p_id_number+"--"+p_mobile_number);
		$('#content_detail .apply_person_name').html(apply_person_name+"--"+apply_id_number+"--"+apply_mobile_number);
		$('#content_detail .person_type_name').html(person_type_name);
		$('#content_detail .begin_date').html(begin_date);
		$('#content_detail .end_date').html(end_date);
		$('#content_detail .source_type_name').html(source_type_name);
		$('#content_detail .person').data('code',person_code);
		$('#content_detail .apply_person_name').data('code',apply_person);
		$('#content_detail .person_type_name').data('code',person_type);

		var html_tmp = "";
		for(var i=0;i<building_arr.length;i++){
			var building = building_arr[i];
			html_tmp += '<em style="width:440px;" id="'+building['building_code']+'" data-code="'+building['building_code']+'">'+building['building_name']+'</em>';
		}
		$('#content_detail .img_wrap .img_url').attr('src',getRootPath()+'/'+img_url);
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
	},
	//点击编辑时,弹出编辑框
	'click .write':function(e,value,row,index){
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
		var person_code = row.person_code;
		var apply_person = row.apply_person;
		var building_arr = row.building_arr;
		var img_url = row.img_url;
		var source_type = row.source_type;
		var source_type_name = row.source_type_name;
		var old_img_url = row.old_img_url;
		// alert(apply_person);

		//赋值
		$('#content_write .code').html(code);
		$('#content_write .card_no').html(card_no);
		$('#content_write .person').html(full_name+"--"+p_id_number+"--"+p_mobile_number);
		$('#content_write .apply_person_name').html(apply_person_name+"--"+apply_id_number+"--"+apply_mobile_number);
		$('#content_write .person_type_name').html(person_type_name);
		$('#content_write .begin_date').html(begin_date);
		$('#content_write .end_date').html(end_date);
		$('#content_write .source_type_name').html(source_type_name);

		$('#content_write .person').data('code',person_code);
		$('#content_write .apply_person_name').data('code',apply_person);
		$('#content_write .person_type_name').data('code',person_type);


		var html_tmp = "";
		for(var i=0;i<building_arr.length;i++){
			var building = building_arr[i];
			html_tmp += '<em style="width:440px;" id="'+building['building_code']+'" data-code="'+building['building_code']+'">'+building['building_name']+'<i class="fa fa-close"></i></em>';
		}

		$('#content_write .img_wrap .img_url').attr('src',getRootPath()+'/'+img_url);
		if(!old_img_url){
			$('#content_write .img_wrap .old_img_url').remove();
			$('#content_write .img_wrap .old_img_wrap').append('<br /><br /><br /><span>缺少预留照片</span>');
		}
		else{
			$('#content_write .img_wrap .old_img_url').attr('src',getRootPath()+'/'+old_img_url);
		}

		$('#content_write .select_buliding').empty();
		$('#content_write .select_buliding').append(html_tmp);
		$('#content_write').modal('show');
	}
}
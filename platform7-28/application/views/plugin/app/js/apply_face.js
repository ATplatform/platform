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

//点击通过
$('#content_write .save').click(function(){
	var content_wrap = $(this).closest('#content_write');
	var face_apply_code = content_wrap.find('.code').html();
	var apply_person = content_wrap.find('.apply_person_name').data('code');
	var person_code = content_wrap.find('.person').data('code');
	var person_type = content_wrap.find('.person_type_name').data('code');
	var begin_date = content_wrap.find('.begin_date').html();
	var end_date = content_wrap.find('.end_date').html();
	var source_type = content_wrap.find('.source_type').val();
	var pic = content_wrap.find('.pic').val();
	var subject = content_wrap.find('.subject').val();
	var pos = content_wrap.find('.pos').val();
	var feat = content_wrap.find('.feat').val();
	var img_url = content_wrap.find('.img_url').val();
	var building_code = content_wrap.find('.building_code').val();
	var img_url = $('#content_write input[name="img_url"]').val();

	// alert(img_url);
	$.ajax({
		url:getRootPath()+'/index.php/Permission/insertAccessFace',
		method:'post',
		data:{
			face_apply_code:face_apply_code,
			apply_person:apply_person,
			person_code:person_code,
			person_type:person_type,
			begin_date:begin_date,
			end_date:end_date,
			building_code:building_code,
			source_type:source_type,
			pic:pic,
			subject:subject,
			pos:pos,
			feat:feat,
			img_url:img_url,
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
			    		asynRefreshPage(getRootPath()+'/index.php/Permission/applyfacelist','Permission/getApplyFaceList',table,data.total,'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code);
			    		//并且重新赋值总条数
			    		$('.table_wrap .sub_nav .total').html(data.totals);
				  }
			});
			
		},
		error:function(){
			console.log('编辑出错');
		}
	})
})

//点击拒绝
$('#content_write .refuse').click(function(){
	var content_wrap = $(this).closest('#content_write');
	var code = content_wrap.find('.code').html();
	var reason = content_wrap.find('.reason').val();
	if(!reason){
		openLayer('请填写拒绝原因!');
		return;
	}
	$.ajax({
		url:getRootPath()+'/index.php/Permission/refuseApplyFace',
		method:'post',
		data:{
			code:code,
			reason:reason,
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
	    	    		asynRefreshPage(getRootPath()+'/index.php/Permission/applyfacelist','Permission/getApplyFaceList',table,data.total,'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code);
	    	    		//并且重新赋值总条数
	    	    		$('.table_wrap .sub_nav .total').html(data.totals);
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
	    '<a class="write" href="javascript:void(0)" style="margin-left: 10px;" title="查看详细并处理">',
	    '<i class="fa fa-id-card"></i>',
	    '</a>'
	].join('');
}
window.operateEvents = {
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
		var apply_date = row.apply_date;
		var person_code = row.person_code;
		var apply_person = row.apply_person;
		var building_arr = row.building_arr;
		var building_code = row.building_code;
		var pic = row.pic;
		var pos = row.pos;
		var feat = row.feat;
		var subject = row.subject;
		var source_type = row.source_type;
		var old_img_url = row.old_img_url;
		// alert(apply_person);

		//赋值
		$('#content_write .code').html(code);
		$('#content_write .card_no').html(card_no);
		$('#content_write .person').html(full_name+"--"+p_id_number+"--"+p_mobile_number);
		$('#content_write .apply_person_name').html(apply_person_name+"--"+apply_id_number+"--"+apply_mobile_number);
		$('#content_write .person_type_name').html(person_type_name);
		$('#content_write .begin_date').html(begin_date);
		$('#content_write .apply_date').html(apply_date);
		$('#content_write .end_date').html(end_date);
		$('#content_write .person').data('code',person_code);
		$('#content_write .apply_person_name').data('code',apply_person);
		$('#content_write .person_type_name').data('code',person_type);

		$('#content_write .pic').val(pic);
		$('#content_write .pos').val(pos);
		$('#content_write .feat').val(feat);
		$('#content_write .subject').val(subject);
		$('#content_write .source_type').val(source_type);
		$('#content_write .building_code').val(building_code);

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
				$('#content_write .img_wrap .img_url').attr('src',getRootPath()+'/'+img_url);
				$('#content_write input[name="img_url"]').val(img_url);

			},
			error:function(){
				console.log('获取图片出错');
			}
		})
		if(!old_img_url){
			$('#content_write .img_wrap .old_img_wrap').empty();
			$('#content_write .img_wrap .old_img_wrap').append('<span>用户预留照片</span><br /><br /><br /><span>缺少预留照片</span>');
		}
		else{
			$('#content_write .img_wrap .old_img_url').attr('src',getRootPath()+'/'+old_img_url);
		}
		$('#content_write .select_buliding').empty();
		$('#content_write .select_buliding').append(html_tmp);
		$('#content_write').modal('show');
	}
}
//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var search_keyword = getUrlParam('keyword');
var search_parent_code = getUrlParam('parent_code');
var search_id = getUrlParam('id');
$('.add_building input[name="effective_date"]').val(now);
//日期控件初始化
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
//新增楼宇,楼宇层级下拉时,隐藏显示楼宇产权类型等
$(document).on('click','.select_building_level .ka_drop li',function(){
    var data_ajax = $(this).find('a').data('ajax');
    if(data_ajax==106){
    	$('#add_building .select_building_type,#add_building .floor_area_wrap,#add_building .inside_area_wrap').show();
    }
    else{
    	$('#add_building .select_building_type,#add_building .floor_area_wrap,#add_building .inside_area_wrap').hide();
    }
    //切换楼宇时,顺序号清空
    $('#add_building input[name="rank"]').val(' ');
    //如果楼宇层级是105(层),顺序号可以是负数
   /* if(data_ajax!==105){
    	var rank = $('#add_building input[name="rank"]').val();
    	rank = Math.abs(rank);
    	$('#add_building input[name="rank"]').val(rank);
    }*/
})
//点击保存新增楼宇信息
$('#add_building .confirm').click(function(){
	var code = $('.add_building .code').html();
	var effective_date = $('.add_building').find('input[name="effective_date"]').val();
	var name = $('.add_building').find('input[name="name"]').val();
	var rank = $('.add_building').find('input[name="rank"]').val();
	var parent_code = $('.add_building').find('input[name="parent_code"]').val();
	var remark = $('.add_building').find('input[name="remark"]').val();
	var level_data = $('.add_building').find('input[name="level"]').data('ajax');
	var parent_code_data = $('.add_building').find('input[name="parent_code"]').data('ajax');
	var building_type = $('.add_building').find('input[name="building_type"]').data('ajax');
	var floor_area = $('.add_building').find('input[name="floor_area"]').val();
	var inside_area = $('.add_building').find('input[name="inside_area"]').val();
	remark = remark?remark:'';
	rank = trim(rank);
	
	if(!effective_date){
		openLayer('请输入生效日期');
		return;
	}
	if(!name){
		openLayer('请输入楼宇名称');
		return;
	}
	if(!level_data){
		openLayer('请选择楼宇层级');
		return;
	}
	if(!parent_code){
		openLayer('请选择上级楼宇');
		return;
	}
	if(!rank){
		openLayer('请输入顺序号');
		return;
	}
	//如果填了顺序号,则要验证不能超过两位小数
	if(!/^(\-?)\d+$/.test(rank)){
		openLayer('顺序号请输入整数');
		return;
	}
	if(level_data==105){
		if(rank<-100 || rank >255){
			openLayer('顺序号只能在-100到255之间');
			return;
		}
	}
	else{
		if(rank<0 || rank >255){
			openLayer('顺序号只能在0-255之间');
			return;
		}
	}
	
	//判断有效无效
	if($('.add_building .effective_status input[type="radio"]').eq(0).is(':checked')){
		effective_status = 'true';
	}
	else {
		effective_status = 'false';
	}
	//楼宇层级为106(室)的时候,必须输入建筑面积\套内面积\产权类型
	if(level_data==106){
		if(!building_type){
			openLayer('请选择产权类型');
			return;
		}
		if(!floor_area){
			openLayer('请输入楼宇建筑面积');
			return;
		}
		if(!inside_area){
			openLayer('请输入楼宇套内面积');
			return;
		}
		//如果填了建筑面积,则要验证是否是数字
		if(!(/^\d+(?:\.\d{1,2})?$/.test(floor_area))){
			openLayer('楼宇建筑面积最多输入两位小数');
			return;
		}
		//如果填了套内面积,则要验证是否是数字
		if(!(/^\d+(?:\.\d{1,2})?$/.test(inside_area))){
			openLayer('楼宇套内面积最多输入两位小数');
			return;
		}
		if(floor_area<0 || inside_area<0){
			openLayer('面积不能小于0');
			return;
		}
	}
	else {
		building_type = '';
		floor_area = '';
		inside_area = '';
	}

	$.ajax({
		url:getRootPath()+'/index.php/Building/insertBuilding',
		method:'post',
		data:{
			code:code,
			effective_date:effective_date,
			effective_status:effective_status,
			name:name,
			level:level_data,
			rank:rank,
			parent_code:parent_code_data,
			remark:remark,
			building_type:building_type,
			floor_area:floor_area,
			inside_area:inside_area
		},
		success:function(data){
			$('#add_building').modal('hide');
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
				    //右上角关闭回调
				    window.location = getRootPath() + "/index.php/Building/buildinglist";
				  }
			});
		},
		error:function(){
			console.log('新增楼宇出错');
		}
	})

})
//点击新增按钮,从后端取得楼宇编号信息
$('.add_btn').click(function(){
	$.ajax({
		url:getRootPath()+'/index.php/Building/getBuildingCode',
		success:function(data){
			var code = parseInt(data) + 1;
			$('.add_building .code').html(code);
		}
	})
})

//点击保存编辑楼宇信息
$('#write_building .confirm').click(function(){
	var code = $('.write_building .code').html();
	var effective_date = $('.write_building').find('input[name="effective_date"]').val();
	var name = $('.write_building').find('input[name="name"]').val();
	var level = $('.write_building').find('input[name="level"]').data('ajax');
	var rank = $('.write_building').find('input[name="rank"]').val();
	var parent_code = $('.write_building').find('input[name="parent_code_name"]').val();
	var remark = $('.write_building').find('.remark').html();
	var level_data = $('.write_building').find('input[name="level"]').data('ajax');
	var parent_code_data = $('.write_building').find('input[name="parent_code"]').data('ajax');
	var data_id = $('.write_building').find('input[name="data_id"]').val();
	var old_name = $('.write_building').find('input[name="old_name"]').val();
	var img_url = $('.write_building').find('input[name="img_url"]').val();
	//如果填了顺序号,则要验证是否是数字
	if(rank){
		if(!/^[0-9]*$/.test(rank)){
			openLayer('顺序号请输入数字');
			return;
		}
	}
	//可以更改楼宇层级
	/*$.ajax({
		url:getRootPath()+'/index.php/Building/updateBuilding',
		method:'post',
		data:{
			id:data_id,
			search_id:search_id,
			code:code,
			effective_date:effective_date,
			effective_status:effective_status,
			name:name,
			level:level_data,
			rank:rank,
			parent_code:parent_code_data,
			search_parent_code:search_parent_code,
			remark:remark
		},
		success:function(data){
			$('#write_building').modal('hide');
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
				  	//右上角关闭回调
				  	//刷新列表
				  	asynRefreshPage(getRootPath()+'/index.php/Building/buildinglist','Building/getBuildingsList',table,data.total,'&keyword='+search_keyword+'&id='+search_id+'&parent_code='+search_parent_code);
				    $('#write_building').modal('hide');
				  }
			});

		},
		error:function(){
			console.log('编辑楼宇出错');
		}
	})*/
	//只能更改名称\备注
	$.ajax({
		url:getRootPath()+'/index.php/Building/updateBuildingName',
		method:'post',
		data:{
			code:code,
			name:name,
			old_name:old_name,
			img_url:img_url,
			rank:rank,
			remark:remark,
			search_id:search_id,
			search_parent_code:search_parent_code,
			keyword:search_keyword
		},
		success:function(data){
			$('#write_building').modal('hide');
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
				  	//右上角关闭回调
				  	//刷新列表
				  	asynRefreshPage(getRootPath()+'/index.php/Building/buildinglist','Building/getBuildingsList',table,data.total,'&keyword='+search_keyword+'&id='+search_id+'&parent_code='+search_parent_code);
				    $('#write_building').modal('hide');
				  }
			});

		},
		error:function(){
			console.log('编辑楼宇出错');
		}
	})
})

//获取所有楼宇信息
$.ajax({
	type:"POST",
	url : getRootPath()+'/index.php/Building/getBuildingNameCode',
	dataType:"json",
	success:function(data){
		// console.log(data);
		for(var i=0;i<data.length;i++){
			var code = data[i]['code'];
			var name = data[i]['name'];
			if($(".buildings #"+code).length==0) {
			   $('.buildings ul').append('<li><a href="javascript:;" id='+code+' data-ajax='+code+'>'+code+'-'+name+'</a></li>');
			}
		}
	}	
})

function write_building_hide(){
	$('#write_building').modal('hide');
}

window.operateEvents = {
	//查看详情
	'click .detail':function(e,value,row,index){
		var code = row.code;
		var effective_date = row.effective_date;
		var effective_status = row.effective_status;
		var name = row.name;
		var level = row.level;
		var level_name = row.level_name;
		var rank = row.rank;
		var parent_code = row.parent_code;
		var parent_code_name = row.parent_code_name;
		var remark = row.remark;
		var qr_code = row.qr_code;
		var building_type_name = row.building_type_name;
		var floor_area = row.floor_area;
		var inside_area = row.inside_area;

		//赋值
		$('#detail_building .code').html(code);
		$('#detail_building .effective_date').html(effective_date);
		$('#detail_building .effective_status').html(effective_status);
		$('#detail_building .level_name').html(level_name);
		$('#detail_building .parent_code_name').html(parent_code_name);
		$('#detail_building').find('.name').html(name);
		$('#detail_building').find('.rank').html(rank);
		$('#detail_building').find('.remark').html(remark);
		if(level=='106'){
			$('#detail_building').find('.building_type_name').html(building_type_name);
			$('#detail_building').find('.floor_area').html(floor_area);
			$('#detail_building').find('.inside_area').html(inside_area);
			$('#detail_building').find('.building_type_name_wrap').show();
			$('#detail_building').find('.floor_area_wrap').show();
			$('#detail_building').find('.inside_area_wrap').show();
		}
		else{
			$('#detail_building').find('.building_type_name_wrap').hide();
			$('#detail_building').find('.floor_area_wrap').hide();
			$('#detail_building').find('.inside_area_wrap').hide();
		}
		
		if(qr_code){
			var qr_code = JSON.parse(qr_code);
			var img_url = qr_code.img_url;
			img_url = getRootPath() +"/"+ img_url;
			// alert(img_url);
			$('#detail_building').find('.qr_code').find('img').attr('src',img_url);
		}
		$('#detail_building').modal('show');
	},
	//点击编辑时,弹出编辑框
	'click .write':function(e,value,row,index){
		var code = row.code;
		var effective_date = row.effective_date;
		var effective_status = row.effective_status;
		var name = row.name;
		var level = row.level;
		var level_name = row.level_name;
		var rank = row.rank;
		var parent_code = row.parent_code;
		var parent_code_name = row.parent_code_name;
		var remark = row.remark;
		var data_id = row.id;
		var old_name = row.name;
		var qr_code = row.qr_code;
		var building_type_name = row.building_type_name;
		var floor_area = row.floor_area;
		var inside_area = row.inside_area;
		
		if(qr_code){
			var qr_code = JSON.parse(qr_code);
			var img_url = qr_code.img_url;
			$('.write_building').find('input[name="img_url"]').val(img_url);
		}

		//赋值
		$('.write_building .code').html(code);
		$('.write_building .effective_date').html(effective_date);
		$('.write_building .effective_status').html(effective_status);
		$('.write_building .level_name').html(level_name);
		$('.write_building .parent_code_name').html(parent_code_name);
		$('.write_building .rank').html(rank);

		$('.write_building').find('input[name="name"]').val(name);
		$('.write_building').find('input[name="remark"]').val(remark);
		$('.write_building').find('input[name="data_id"]').val(data_id);
		$('.write_building').find('input[name="old_name"]').val(old_name);

		if(level=='106'){
			$('.write_building').find('.building_type_name').html(building_type_name);
			$('.write_building').find('.floor_area').html(floor_area);
			$('.write_building').find('.inside_area').html(inside_area);
			$('.write_building').find('.building_type_name_wrap').show();
			$('.write_building').find('.floor_area_wrap').show();
			$('.write_building').find('.inside_area_wrap').show();
		}
		else{
			$('.write_building').find('.building_type_name_wrap').hide();
			$('.write_building').find('.floor_area_wrap').hide();
			$('.write_building').find('.inside_area_wrap').hide();
		}

		$('#write_building').modal('show');
	},
	//点击失效
	'click .invalid':function(e,value,row,index){
		var code = row.code;
		var level = row.level;
		if(level!==106){
			layer.open({
				  type: 1,
				  title: false,
				  //打开关闭按钮
				  closeBtn: 1,
				  shadeClose: false,
				  skin: 'tanhcuang',
				  content: "此房间不允许失效"
			});
			return;
		}
		$.ajax({
			url:getRootPath()+'/index.php/Building/invalidBuilding',
			method:'post',
			data:{
				code:code
			},
			success:function(data){
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
					  		//表示楼宇可以失效,应该刷新页面了
					  		if(data.haslimit == false){
					  			//右上角关闭回调
					  			window.location = getRootPath() + "/index.php/Building/buildinglist";	
					  		} 
					  }
				});

			},
			error:function(){
				console.log('编辑出错');
			}
		})

	}
}

//信息管理操作
function operateFormatter(value,row,index){
	return [
		'<a class="detail" href="javascript:void(0)" style="margin-left: 10px;" title="详情">',
		'<i class=" fa fa-trash-o fa-lg fa-file-text-o"></i>',
		'</a>',
	    '<a class="write" href="javascript:void(0)" style="margin-left: 10px;vertical-align: middle;display: inline-block;width: 16px;height: 16px;"  title="修改">',
	    	'<i class="icon fa fa-pencil-square-o"></i>',
	    '</a>',
	    '<a class="invalid" href="javascript:void(0)" style="margin-left: 10px;vertical-align: middle;display: inline-block;width: 16px;height: 16px;"  title="修改">',
	    	'<i class="icon fa fa-times-rectangle-o"></i>',
	    '</a>'
	].join('');
}
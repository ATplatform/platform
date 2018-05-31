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
	//如果填了顺序号,则要验证是否是数字
	if(rank){
		if(!/^[0-9]*$/.test(rank)){
			openLayer('顺序号请输入数字');
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
			remark:remark
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
	var remark = $('.write_building').find('input[name="remark"]').val();
	var level_data = $('.write_building').find('input[name="level"]').data('ajax');
	var parent_code_data = $('.write_building').find('input[name="parent_code"]').data('ajax');
	var data_id = $('.write_building').find('input[name="data_id"]').val();
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
	if(!level){
		openLayer('请选择楼宇层级');
		return;
	}
	if(!parent_code_data){
		openLayer('请选择上级楼宇');
		return;
	}
	//如果填了顺序号,则要验证是否是数字
	if(rank){
		if(!/^[0-9]*$/.test(rank)){
			openLayer('顺序号请输入数字');
			return;
		}
	}
	//判断有效无效
	if($('#write_building .effective_status input[type="radio"]').eq(0).is(':checked')){
		effective_status = 'true';
	}
	else {
		effective_status = 'false';
	}
	$.ajax({
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
	//点击编辑时,弹出编辑框
	'click .write':function(e,value,row,index){
		var code = row.code;
		var effective_date = row.effective_date;
		var name = row.name;
		var level = row.level;
		var level_name = row.level_name;
		var rank = row.rank;
		var parent_code = row.parent_code;
		var parent_code_name = row.parent_code_name;
		var remark = row.remark;
		var data_id = row.id;
		if(row.effective_status=="有效"){
			$('.write_building .effective_status input[type="radio"]').eq(0).attr('checked',true);
		}
		else{
			$('.write_building .effective_status input[type="radio"]').eq(1).attr('checked',true);
		}
		//赋值
		$('.write_building .code').html(code);
		$('.write_building').find('input[name="effective_date"]').val(effective_date);
		$('.write_building').find('input[name="name"]').val(name);
		$('.write_building').find('input[name="level"]').val(level_name);
		$('.write_building').find('input[name="rank"]').val(rank);
		$('.write_building').find('input[name="parent_code"]').val(parent_code_name);
		$('.write_building').find('input[name="remark"]').val(remark);
		$('.write_building').find('input[name="level"]').data('ajax',level);
		$('.write_building').find('input[name="parent_code"]').data('ajax',parent_code);
		$('.write_building').find('input[name="data_id"]').val(data_id);
		$('#write_building').modal('show');
	}
}

//信息管理操作
function operateFormatter(value,row,index){
	return [
	    '<a class="write" href="javascript:void(0)"  title="修改">',
	    	'<i class="icon fa fa-pencil-square-o"></i>',
	    '</a>'
	].join('');
}
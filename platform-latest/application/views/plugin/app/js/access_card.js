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
//设置串口
for(var i=1;i<=255;i++){
	var value="COM"+i;
	var li = '<li><a href="javascript:;" data-ajax="">'+value+'</a></li>';
    $("#add_content .select_com .ka_drop_list").append(li);
}
//串口赋值
$(document).on('click','#add_content .select_com .ka_drop_list li',function(){
	var comid = $(this).text();
    localStorage.setItem("accesscardcomid", comid);
    // window.location.reload();
})

//搜索人员
$('.search_person_wrap .search_person_btn').click(function(){
	var name = $(this).closest('.search_person_wrap').find('.search_person_name').val();
	var search_person_wrap = $(this).closest('.search_person_wrap');
	$.ajax({
		method:'post',
		data:{
			name:name
		},
		url:getRootPath()+'/index.php/People/getPersonByName',
		//成功之后,将结果生成
		success:function(data){
			var data = data;
			//先清空之前的值
			$('.search_person_results').empty();
			if(data){
				data = JSON.parse(data);
				for(var i=0;i<data.length;i++){
					var d = data[i];
					var html = '<div class="single_person" data-last_name="'+d['last_name']+'" data-first_name="'+d['first_name']+'" data-code="'+d['code']+'"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a>'
								+'<div class="fl">'
								+'<span class="name">'+d['full_name']+'</span>'
								+'<span class="id_number">'+d['id_number']+'</span>'
								+'</div></div>';
					$('.search_person_results').append(html);
				}
			}
			else{
				$('.search_person_results').append("没有结果");
			}
		},
		error:function(){
			console.log('搜索出错');
		}
	})
})

//选择人员
$(document).on('click','.search_person_only .single_person .add',function(){
	var single_person = $(this).closest('.single_person');
	var full_name = single_person.find('.name').html();
	var id_number = single_person.find('.id_number').html();
	var last_name = single_person.data('last_name');
	var first_name = single_person.data('first_name');

	var last_name = single_person.data('last_name');
	var first_name = single_person.data('first_name');
	var code = single_person.data('code');

	var html = '<li data-last_name="'+last_name+'" data-first_name="'+first_name+'" data-code="'+code +'" id="'+code+'"><span class="full_name">'+full_name+'</span><span class="id_number">'+id_number+'</span><i class="fa fa-close"></i></li>';
		//最多添加十个且不能重复添加
		if($(this).closest('.search_person_only').find(".person_building_data ul li").length==0){
				$(this).closest('.search_person_only').find('.person_building_data ul').append(html);
				//选择之后,马上查出这个人的所有用户类型,以及所有的房屋名称
				$.ajax({
					type:"post",
					dataType:"json",
					url:getRootPath()+'/index.php/Permission/getPersonRole',
					data:{
						code:$('#add_content .search_person_only .person_building_data ul li').data('code')
					},
					success:function(data){
						console.log(data);
						var business = data.business;
						var management = data.management;
						var resident = data.resident;
						var html_tmp = "";
						var ka_drop_list = "";
						//拼接地址并赋值
						if(!!resident){
							for(var k=0;k<resident.length;k++){
								var r = resident[k];
								html_tmp += "<li><input type='checkbox' id='"+r['building_code']+"' class='regular-checkbox' /><label for='"+r['building_code']+"'></label><span class='name'>"+r['building_name']+"</span></li>";
							}
							//用户类型下拉
							ka_drop_list += "<li><a href='javascript:;' data-ajax='101'>业主</a></li>";
						}
						if(!!business){
							for(var i=0;i<business.length;i++){
								var b = business[i];
								html_tmp += "<li><input type='checkbox' id='"+b['building_code']+"' class='regular-checkbox' /><label for='"+b['building_code']+"'></label><span class='name'>"+b['building_name']+"</span></li>";
							}
							//用户类型下拉
							ka_drop_list += "<li><a href='javascript:;' data-ajax='102'>商户</a></li>";
						}
						if(!!management&&management.length>0){
							for(var j=0;j<management.length;j++){
								var m = management[j];
								html_tmp += "<li><input type='checkbox' id='"+m['building_code']+"' class='regular-checkbox' /><label for='"+m['building_code']+"'></label><span class='name'>"+m['building_name']+"</span></li>";
							}
							//用户类型下拉
							ka_drop_list += "<li><a href='javascript:;' data-ajax='103'>物业人员</a></li>";
						}
						// console.log(html_tmp);
						$('#add_content .query_building_wrap .query_building').empty();
						$('#add_content .query_building_wrap .query_building').append(html_tmp);

						$('#add_content .select_person_type .ka_drop_list ul').empty();
						$('#add_content .select_person_type .ka_drop_list ul').append(ka_drop_list);
						// alert($('#add_content .select_person_type .ka_drop_list ul li').length);
						//如果人员类型只有一种,则自动赋值person_type
						if($('#add_content .select_person_type .ka_drop_list ul li').length==1){
							var li = $('#add_content .ka_drop .ka_drop_list ul li').eq(0);
							var person_type = li.find('a').data('ajax');
							var person_type_name = li.find('a').html();
							$('#add_content .select_person_type .person_type').val(person_type_name);
							$('#add_content .select_person_type .person_type').data('ajax',person_type);
						}
					}
				})
		}
})
//点击删除节点
$(document).on('click','.person_building_data ul li .fa-close',function(){
	$(this).closest('li').remove();
	//清空已查询出的地址
	$('#add_content .query_building_wrap .query_building').empty();
	//清空下拉菜单
	$('#add_content .ka_drop .ka_drop_list ul').empty();
	//清空用户类型输入框值
	$('#add_content .person_type').val('');
	$('#add_content .person_type').data('ajax','');
})

//获取最新的一卡通授权编号
$.ajax({
	url:getRootPath()+'/index.php/Permission/getLastAccessCardCode',
	success:function(data){
		var code = parseInt(data);
		$('#add_content .code').html(code);
	}
})

//点击保存
$('#add_content .save').click(function(){
	var content_wrap = $(this).closest('.modal-content');
	//必填项
	var code = content_wrap.find('.code').html();
	var card_no = content_wrap.find('input[name="card_no"]').val();
	var person_type = content_wrap.find('input[name="person_type"]').data('ajax');
	var begin_date = content_wrap.find('input[name="begin_date"]').val();
	var end_date = content_wrap.find('input[name="end_date"]').val();
	var b_s = content_wrap.find('.query_building li');
	var building_code_arr = "";
	var b_bs = content_wrap.find('.select_buliding_wrap .select_buliding em');
	var person_code = content_wrap.find('.person_building_data li').data('code');
	for(var i=0;i<b_s.length;i++){
		var li = b_s.eq(i);
		var input_checkbox = li.find('input[type="checkbox"]');
		var b_c = input_checkbox.attr('id');
		if(input_checkbox.is(':checked')){
			building_code_arr += b_c + ",";
		}
	}

	if(b_bs.length>0){
		for(var i=0;i<b_bs.length;i++){
			var b_b = b_bs.eq(i);
			var p_code = b_b.data('room_code');	
			building_code_arr += p_code +',';
		}
	}
	//去掉最后一个逗号
	building_code_arr=building_code_arr.substring(0,building_code_arr.length-1);

	if(!card_no){
		openLayer('请输入一卡通卡号!');
		return;
	}
	if(!person_code){
		openLayer('请选择授权用户!');
		return;
	}
	if(!person_type){
		openLayer('请选择用户类型!');
		return;
	}
	if(!building_code_arr){
		openLayer('请选择授权地址!');
		return;
	}
	if(!begin_date){
		openLayer('请选择开始日期!');
		return;
	}
	if(!end_date){
		end_date = "2099-12-31";
	}
	if(end_date){
		if(begin_date>end_date){
			openLayer('结束日期不能小于开始日期!');
			return;
		}
	}

	//先验证卡号是否存在且授权日期是否重复
	$.ajax({
		url:getRootPath()+'/index.php/Permission/getAccessCardByNo',
		method:'post',
		data:{
			card_no:card_no
		},
		success:function(data){
			var data = JSON.parse(data);
			console.log(data);
			if(data){
				var old_end_date = data.end_date;
				//新增的授权信息大开始日期小于结束日期时提示
				if(old_end_date>begin_date){
					openLayer('该一卡通已经被授权，授权结束日期为'+old_end_date+'，请结束上一条授权记录后再重新授权或者本条授权记录开始日期大于或等于'+old_end_date+'!');
					return;
				}
				else{
					insertAccessCard(code,card_no,person_code,person_type,building_code_arr,begin_date,end_date);
				}
			}
			else {
				insertAccessCard(code,card_no,person_code,person_type,building_code_arr,begin_date,end_date);
			}
		},
		error:function(){
			console.log('新增出错');
		}
	})

})
//编辑保存
$('#content_write .save').click(function(){
	var content_wrap = $(this).closest('#content_write');
	var code = content_wrap.find('.code').html();
	var begin_date = content_wrap.find('.begin_date').html();
	var end_date = content_wrap.find('input[name="end_date"]').val();
	if(begin_date>end_date){
		openLayer('结束日期不能小于开始日期!');
		return;
	}
	$.ajax({
		url:getRootPath()+'/index.php/Permission/updateAccessCard',
		method:'post',
		data:{
			code:code,
			end_date:end_date,
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
			    		asynRefreshPage(getRootPath()+'/index.php/Permission/accesscard','Permission/getAccessCardList',table,data.total,'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code);
				  }
			});
			
		},
		error:function(){
			console.log('编辑出错');
		}
	})
})

//写入数据
function insertAccessCard(code,card_no,person_code,person_type,building_code_arr,begin_date,end_date){
	$.ajax({
		url:getRootPath()+'/index.php/Permission/insertAccessCard',
		method:'post',
		data:{
			code:code,
			card_no:card_no,
			person_code:person_code,
			person_type:person_type,
			building_code:building_code_arr,
			begin_date:begin_date,
			end_date:end_date
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
				    //右上角关闭回调
				    window.location = getRootPath() + "/index.php/Permission/accesscard";
				  }
			});
		},
		error:function(){
			console.log('新增出错');
		}
	})
}
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
	//查看详情
	'click .detail':function(e,value,row,index){
		var code = row.code;
		var card_no = row.card_no;
		var full_name = row.full_name;
		var person_type_name = row.person_type_name;
		var begin_date = row.begin_date;
		var end_date = row.end_date;
		var building_name = row.building_name;

		//赋值
		$('#content_detail .code').html(code);
		$('#content_detail .card_no').html(card_no);
		$('#content_detail .full_name').html(full_name);
		$('#content_detail .person_type_name').html(person_type_name);
		$('#content_detail .building_name').html(building_name);
		$('#content_detail .begin_date').html(begin_date);
		$('#content_detail .end_date').html(end_date);
		$('#content_detail').modal('show');
	},
	//点击编辑时,弹出编辑框
	'click .write':function(e,value,row,index){
		var code = row.code;
		var card_no = row.card_no;
		var full_name = row.full_name;
		var person_type_name = row.person_type_name;
		var begin_date = row.begin_date;
		var end_date = row.end_date;
		var building_name = row.building_name;

		//赋值
		$('#content_write .code').html(code);
		$('#content_write .card_no').html(card_no);
		$('#content_write .full_name').html(full_name);
		$('#content_write .person_type_name').html(person_type_name);
		$('#content_write .building_name').html(building_name);
		$('#content_write .begin_date').html(begin_date);
		$('#content_write .end_date').val(end_date);
		$('#content_write').modal('show');
	}
}
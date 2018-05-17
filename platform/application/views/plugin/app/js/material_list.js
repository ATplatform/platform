//日期控件初始化
var now = new Date();
now = formatDate(now);
var table = $('#table');
//带search的参数用于异步刷新页面时做分页和查询总条数
var search_keyword = getUrlParam('keyword');
var search_parent_code = getUrlParam('parent_code');
var search_id = getUrlParam('id');
$('.add_material input[name="effective_date"]').val(now);
//日期控件初始化
$('.date').datetimepicker({
    format: 'YYYY-MM-DD',
});

var page = $('input[name="page"]').val();

//var c=$("#selectDate").find("input").val();
//console.log(c)
//var c= $("#selectDate").data("datetimepicker").getDate()



    var c=document.getElementById("datetimeStart").value

	console.log(c)

//每次刷新都会读取sessionstorage的keyword值
var keyword =$('input[name="keywords"]').val()


/*
//下拉框赋值
selectValue("keyword");
var keyword=sessionStorage.getItem("keyword");
var keywordSave=""
if (keyword==101){
    keywordSave="工程物资"
}
if (keyword==102){
    keywordSave="安防物资"
}
if (keyword==103){
    keywordSave="消防物资"
}
if (keyword==104){
    keywordSave="保洁物资"
}
if (keyword==105){
    keywordSave="办公物资"
}
console.log(keyword)
console.log(keywordSave)
$('#material_type_select').val(keywordSave);


$(document).on('click','.ka_drop li',function(){
        // var data_ajax = $(this).find('a').data('ajax');
        //$(this).parents('.select_pull_down').find('.ka_input3').val($(this).text());
        //$(this).parents('.select_pull_down').find('.ka_input3').data('ajax',data_ajax);
        $.ajax({
            url:getRootPath()+'/index.php/Material/getMaterialList?page='+page+'&keyword='+keyword,
            method:'get',
            data:{

            },
            success:function(data){
                window.location.href="materialList?keyword="+keyword+"&page="+page;
            },
            error:function(){

            }
        })
    })


*/



//特殊处理搜索框输入物资类型的中文，将它变成数字赋给keyword
var search_text=$('.searc_room_text').val()
console.log(search_text)
if (search_text.indexOf("工程物资") !== -1 ){
        keyword=101;
}
if (search_text.indexOf("安防物资") !== -1  ){
        keyword=102;
}
if (search_text.indexOf("消防物资")!==-1){
        keyword=103;
}
if (search_text.indexOf("保洁物资") !==-1){
        keyword=104;
}
if (search_text.indexOf("办公物资") !==-1){
        keyword=105;
}
console.log(1)
console.log(keyword)

//搜索框赋值
$('#table').bootstrapTable({
    method: "get",
    undefinedText:'/',
    url:getRootPath()+'/index.php/Material/getMaterialList?page='+page+'&keyword='+keyword,
    dataType:'json',
    // pagination:true,
    // pageSize: 15,
    // pageNumber: 1,
    // sortName: 'id',
    // sortOrder: 'desc',
    responseHandler:function(res){
        //用于处理后端返回数据
        console.log(res);
        return res;
    },
    onLoadSuccess: function(data){  //加载成功时执行
        console.log(data);
    },
    onLoadError: function(){  //加载失败时执行
        console.info("加载数据失败");
    }
})

    //点击分页go,判断页面跳转
    $('.fenye_btn').click(function() {
        var page = $('input[name="fenye_input"]').val();
        if (!/^[0-9]*$/.test(page)) {
            openLayer('请输入数字');
            $('input[name="fenye_input"]').val('');
            return;
        }
        var pagenumber = Number(page) + "";
        var myCurrent = $('#current').text().split('/')[0];
        var myTotal = $('#current').text().split('/')[1];
        if (page != pagenumber) {
            $('input[name="fenye_input"]').val(pagenumber);
            page = pagenumber;
        }
        if (Number(page) > Number(myTotal)) {
            $('input[name="fenye_input"]').val(myTotal);
            page = myTotal;
        }
        if (Number(page) < 1) {
            openLayer('请输入合法页数');
            $('input[name="fenye_input"]').val('');
            return;
        }

        var keyword = getUrlParam('keyword');
        window.location.href = "materialList?keyword=" + keyword + "&page=" + page;
    })



//$('.add_material').find('input[name="effective_date"]').val();

//点击保存新增楼宇信息
$('#add_material .confirm').click(function(){
	var code = $('.add_material .code').html();
	var effective_date = $('.add_material').find('input[name="effective_date"]').val();
	var name = $('.add_material').find('input[name="name"]').val();
	var pcs = $('.add_material').find('input[name="pcs"]').val();
    var material_type = $('.add_material').find('input[name="material_type"]').val();
    var building_code = $('.add_material').find('input[name="building_code"]').val();
    var supplier = $('.add_material').find('input[name="supplier"]').val();
    var internal_no = $('.add_material').find('input[name="internal_no"]').val();
    var initial_no = $('.add_material').find('input[name="initial_no"]').val();
	var remark = $('.add_material').find('input[name="remark"]').val();

	remark = remark?remark:'';
	if(!effective_date){
		openLayer('请输入生效日期');
		return;
	}
	if(!name){
		openLayer('请输入物资名称');
		return;
	}
	if(!pcs){
		openLayer('请输入物资数量');
		return;
	}
	if(!material_type){
		openLayer('请选择物资类型');
		return;
	}
	//判断有效无效
	if($('.add_material .effective_status input[type="radio"]').eq(0).is(':checked')){
		effective_status = 'true';
	}
	else {
		effective_status = 'false';
	}

	$.ajax({
		url:getRootPath()+'/index.php/Material/insertMaterial',
		method:'post',
		data:{
			code:code,
			effective_date:effective_date,
			effective_status:effective_status,
			name:name,
			pcs:pcs,
            material_type:$('.add_material').find('input[name="material_type"]').data('ajax'),
            building_code:building_code,
            supplier:supplier,
            internal_no:internal_no,
            initial_no:initial_no,
			remark:remark

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
                      asynRefreshPage(getRootPath()+'/index.php/Material/materialList','Material/getMaterialList',table,data.total,'&keyword='+search_keyword);
				   window.location = getRootPath() + "/index.php/Material/materialList";
				  }
			});
		},
		error:function(){
			console.log('新增物资出错');
		}
	})

})

//点击新增按钮,从后端取得楼宇编号信息
$('.add_btn').click(function(){
	$.ajax({
		url:getRootPath()+'/index.php/Material/getMaterialCode',
		success:function(data){
			var code = parseInt(data) + 1;
			$('.add_material .code').html(code);
		}
	})
})




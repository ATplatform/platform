//////////////////////////////////////日期控件初始化////////////////////////////////
var now = new Date();
now = formatDate(now);
//新增模块的时间赋值
$('.add_Item').find('input[name="effective_date"]').val(now);

///////////搜索框X的href赋值//////////////
$('#reset').attr("href",'materialList')
$('#clear').click(function(){
    $('.search_room ').find('input[name=keyword]').val('')
})


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


///////////////////////////////////////用户名初始化//////////////////////////////


////////////////////////////////////////参数初始化赋值///////////////////////////////////////
var page = $('input[name="page"]').val();
var keyword = $('input[name="keywords"]').val()
var material_type = $('input[name="material_types"]').val();
var building_code = $('input[name="building_codes"]').val();
var parent_code = $('input[name="parent_codes"]').val();
var effective_date = $('input[name="effective_dates"]').val();

//带search的参数用于异步刷新页面时做分页和查询总条数
var search_material_type = getUrlParam('material_type');
var search_building_code = getUrlParam('building_code');
var search_parent_code = getUrlParam('parent_code');
var search_keyword = getUrlParam('keyword');
var search_effective_date = getUrlParam('effective_date');

/*

//初始化第一类搜索条件  /!*********************************需要改动********************!/
switch(material_type){
    case '101':$('.search_wrap #material_type_select').val('工程物资');break;
    case '102':$('.search_wrap #material_type_select').val('安防物资');break;
    case '103':$('.search_wrap #material_type_select').val('消防物资');break;
    case '104':$('.search_wrap #material_type_select').val('保洁物资');break;
    case '105':$('.search_wrap #material_type_select').val('办公物资');break;
    default:$('.search_wrap #material_type_select').val('物资类型');break;
}

*/


init_time=search_effective_date
init_time = init_time?init_time:now;
init_time=init_time.split(' ')['0']
$('.search_wrap .effective_date').val(init_time);


//树形图筛选状态改变
/*if(search_building_code){
    $('.treeWrap>span').addClass('active');
}
else{
    $('.treeWrap>span').removeClass('active');
}*/

//需要变动参数
//搜索模式url
function materialListbySearch(effective_date,page,material_type,building_code,parent_code,keyword){
    window.location.href="materialList?keyword="+keyword+"&page=1"+'&material_type='+material_type+"&building_code="+building_code+"&parent_code="+parent_code+"&effective_date="+effective_date;
}

//对应获得搜索模式数据方法的地址
function getMaterialListbySearch(){
    return getRootPath() + '/index.php/Material/getMaterialListbySearch?page=' + page+'&parent_code='+parent_code+'&building_code='+building_code+'&material_type='+material_type+'&keyword='+keyword+"&effective_date="+effective_date;
}

//搜索模式页面跳转
function PageChangeToMaterialList(page){
    window.location.href = "materialList?keyword=" + search_keyword + "&page=" + page+'&material_type='+search_material_type+'&building_code='+search_building_code+'&parent_code='+search_parent_code+'&effective_date='+search_effective_date;
}


//不需要变动参数
//普通模式页面跳转
function materialList(){
    window.location = getRootPath() + "/index.php/Material/materialList"
}


//对应插入数据方法的地址
function insertMaterial(){
    return getRootPath()+'/index.php/Material/insertMaterial'
}


//对应获得普通模式数据方法的地址
function getMaterialListbyNormal(){
   return getRootPath() + '/index.php/Material/getMaterialListbyNormal?page=' + page
}


//对应获得最新的code方法的地址
function getMaterialLatestCode(){
    return getRootPath()+'/index.php/Material/getMaterialLatestCode'
}

//对应展示楼宇信息方法的地址
function getMaterialBuildingCode(){
	return getRootPath()+'/index.php/Material/getMaterialBuildingCode'
}




/////////////////////////////////////数据展示功能/////////////////////////////////////////

//判断是普通模式还是搜索模式

    //普通模式的数据展示
    if( !$.trim(keyword) && !$.trim(material_type) && !$.trim(building_code) && !$.trim(effective_date)){
        $('#table').bootstrapTable({
            method: "get",
            undefinedText: ' ',
            url: getMaterialListbyNormal(),
            dataType: 'json',
            // pagination:true,
            // pageSize: 15,
            // pageNumber: 1,
            // sortName: 'id',
            // sortOrder: 'desc',
            responseHandler: function (res) {
                //用于处理后端返回数据
                console.log(res);
                return res;
            },
            onLoadSuccess: function (data) {  //加载成功时执行
                console.log(data);
            },
            onLoadError: function () {  //加载失败时执行
                console.info("加载数据失败");
            }
        })
    }

    //搜索模式的数据展示
    else{
        $('#table').bootstrapTable({
            method: "get",
            undefinedText: ' ',
            url: getMaterialListbySearch(),
            dataType: 'json',
            // pagination:true,
            // pageSize: 15,
            // pageNumber: 1,
            // sortName: 'id',
            // sortOrder: 'desc',
            responseHandler: function (res) {
                //用于处理后端返回数据
                console.log(res);
                return res;
            },
            onLoadSuccess: function (data) {  //加载成功时执行
                console.log(data);
            },
            onLoadError: function () {  //加载失败时执行
                console.info("加载数据失败");
            }
        })
    }

    //点击分页go,判断页面跳转
//点击分页go,判断页面跳转
$('.fenye_btn').click(function(){
    var page = $('input[name="fenye_input"]').val();
    if(!/^[0-9]*$/.test(page)){
        openLayer('请输入数字');
        $('input[name="fenye_input"]').val('');
        return;
    }
    var pagenumber=Number(page)+"";
    var myCurrent = $('#current').text().split('/')[0];
    var myTotal = $('#current').text().split('/')[1];
    if(page!=pagenumber)
    {
        $('input[name="fenye_input"]').val(pagenumber);
        page=pagenumber;
    }
    if(Number(page)>Number(myTotal))
    {
        $('input[name="fenye_input"]').val(myTotal);
        page=myTotal;
    }
    if(Number(page)<1)
    {
        openLayer('请输入合法页数');
        $('input[name="fenye_input"]').val('');
        return;
    }

console.log(page)
        PageChangeToMaterialList(page);
    })






///////////////////////////////////////搜索功能////////////////////////////////////////
$('.Search_Item_wrap .ka_drop_list li').click(function(){
    var page = $('input[name="page"]').val();
    var material_type = $(this).find('a').data('ajax');
    var building_code = $('input[name="building_codes"]').val();
    var parent_code = $('input[name="parent_codes"]').val();
    var keyword = $('input[name="keywords"]').val();
    var effective_date=$('input[name="effective_dates"]').val();

    materialListbySearch(effective_date,page,material_type,building_code,parent_code,keyword);

})


$('.search_room button[type="submit"]').click(function(e){
    e.preventDefault()
    var page = $('input[name="page"]').val();
    var material_type = $('input[name="material_types"]').val();
    var building_code = $('input[name="building_codes"]').val();
    var parent_code = $('input[name="parent_codes"]').val();
    var effective_date=$('input[name="effective_dates"]').val();
    var keyword = $('.search_room .searc_room_text').val();
    keyword = trim(keyword);
    if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
        openLayer('搜索框只能输入数字、汉字、字母!');
        return;
    }else{
        materialListbySearch(effective_date,page,material_type,building_code,parent_code,keyword);
    }
})





//////////////////////////////////////////新增功能////////////////////////////////////////
//点击新增按钮,从后端取得最新编号信息
$('.add_btn').click(function(){
    $.ajax({
        url:getMaterialLatestCode(),
        success:function(data){
            if(parseInt(data)){
                var code = parseInt(data) + 1;
            }else{
                var code = 1000001;
            }
            $('.add_Item .code').html(code);
        }
    })
})



//动态获取所有楼宇信息
$('.select_parent_code').click(function(){
    $.ajax({
        type:"POST",
        url : getMaterialBuildingCode(),
        dataType:"json",
        success:function(data){

            for(var i=0;i<data.length;i++){
                var code = data[i]['code'];
                var name = data[i]['name'];
                if($(".buildings #"+code).length==0) {
                    $('.buildings ul').append('<li><a href="javascript:;" id='+code+' data-ajax='+code+'>'+code+'-'+name+'</a></li>');
                }
            }

        }
    })
})



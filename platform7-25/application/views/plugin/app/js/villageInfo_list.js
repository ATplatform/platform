///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////用户名初始化//////////////////////////////
///////////////////////////////////////////////////////////////////////////////
var username=$('input[name="username"]').val();

$('.user span').html(username)


///////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////参数与内容初始化赋值/////////////////////////
///////////////////////////////////////////////////////////////////////////////
//初始化参数       /*********************************需要改动********************/

function platform() {
    return   {
        index:{
            method: '',
            id: '',
            full_name: '',
            name: '',
            brief: '',
            city: '',
            location: '',
            longitude: '',
            latitude: '',
            households: '',
            parking_lots: ''


        },

        showdata:function(data){
            for (var n in this.index) {

                $('.show').find('.'+n).html(data[n]);
                $('#village_rewrite').find('.'+n).val(data[n]);
                $('#village_rewrite').find('.id').html(data['id']);
               // $('.villageimg').attr("src",data['image'])
                this.index[n] = data[n]
            }
            return this.index
        }
    }
}



$.ajax({
    url:getRootPath()+'/index.php/Building/getvillageInfo',
    method:'post',
    data:{

    },
    success:function(data){
    var index=new platform;
        var getdata={};
        data=JSON.parse(data)
        getdata=index.showdata(data)
        /*
             var longitude=getdata.longitude
             var latitude= getdata.latitude

                 console.log(getdata)
                 console.log(longitude)
                 console.log(latitude)

             var map = new BMap.Map("container");
             var point = new BMap.Point(longitude,latitude);
             map.enableScrollWheelZoom(true);
             map.centerAndZoom(point, 18);
             map.addControl(new BMap.NavigationControl());
             var marker = new BMap.Marker(point);        // 创建标注
             map.addOverlay(marker);                     // 将标注添加到地图中
         */


    },
    error:function(){

    }
})

$('#village_rewrite .confirm').click(function(){
    var id = $('#village_rewrite .id').html()
    var brief = $('#village_rewrite .brief').val()
    var full_name = $('#village_rewrite .full_name').val()
    var name = $('#village_rewrite .name').val()
    var city = $('#village_rewrite .city').val()
    var location = $('#village_rewrite .location').val()
    var longitude = $('#village_rewrite .longitude').val()
    var latitude = $('#village_rewrite .latitude').val()
    var households = $('#village_rewrite .households').val()
    var parking_lots = $('#village_rewrite .parking_lots').val()
    $.ajax({
        url: getRootPath() + '/index.php/Building/updatevillageInfo',
        method: 'post',
        data: {
            id:id,
            brief: brief,
            full_name: full_name,
            name: name,
            city: city,
            location: location,
            longitude: longitude,
            latitude: latitude,
            households: households,
            parking_lots: parking_lots
        },
        success:function(data){
            $('#village_rewrite').modal('hide');
            layer.open({
                type: 1,
                title: false,
                //打开关闭按钮
                closeBtn: 1,
                shadeClose: false,
                skin: 'tanhcuang',
                content: '编辑成功',
                cancel: function(){
                    window.location.href=getRootPath() + '/index.php/Building/villageInfo'
                }
            });

        }
        ,
        error:function () {

        }
    })


})





/*
$('.brief').on("keydown",function(e) {
    console.log(e)
    if(e.keyCode===13){
    var id = $('.show .id').html()
    var brief = $('.show .brief').val()
        console.log(id)
    $.ajax({
        url: getRootPath() + '/index.php/Building/updatevillageInfo',
        method: 'post',
        data: {
            id:id,
            brief: brief
        },
    success:function(data){
        window.location.href=getRootPath() + '/index.php/Building/villageInfo'
    }
,
    error:function () {

    }
})
    }
})
*/



/*
$('add_btn').click(function(){
    $('.brief').attr('',)
    onfocus="cc()" style="background: #f0f0f0;"
        <script language="javascript">
        function cc()
        {
            var e = event.srcElement;
            var r =e.createTextRange();
            r.moveStart('character',e.value.length);
            r.collapse(true);
            r.select();
        }
        </script>
})
*/

/*$('.update').click(function(e){
    e.stopPropagation();
    inputlisten()
    brief.removeAttribute('readonly');
    $('.brief').css({
        "background": "#f0efee"
    })
    brief.focus()

})*/

/*function inputlisten(){
var myDiv = document.getElementById("brief");
document.addEventListener("click", function (e) {
    var id = $('.show .id').html()
    var brief = $('.show .brief').val()
    console.log(id)
    $.ajax({
        url: getRootPath() + '/index.php/Building/updatevillageInfo',
        method: 'post',
        data: {
            id:id,
            brief: brief
        },
        success:function(data){
            window.location.href=getRootPath() + '/index.php/Building/villageInfo'
        }
        ,
        error:function () {
        }
    })

});*/

/*
myDiv.addEventListener("click", function (event) {
    event = event || window.event;
    event.stopPropagation();
});}*/

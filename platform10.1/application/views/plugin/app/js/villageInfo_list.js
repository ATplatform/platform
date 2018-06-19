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

                $('.show').find('input[name='+n+']').val(data[n]);
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

        var longitude=getdata.longitude
        var latitude= getdata.latitude

        console.log(getdata)
        console.log(longitude)
        console.log(latitude)
$('.situation').on('click',function(){
    var map = new BMap.Map("container");
    var point = new BMap.Point(113.964336,22.544239);
    map.enableScrollWheelZoom(true);
    map.centerAndZoom(point, 18);
    map.addControl(new BMap.NavigationControl());
    var marker = new BMap.Marker(point);        // 创建标注
    map.addOverlay(marker);                     // 将标注添加到地图中

})

    },
    error:function(){

    }
})

$('.update').on("click",function() {
    var id = $('.show').find('input[name=id]').val()
    $.ajax({
        url: getRootPath() + '/index.php/Building/updatevillageInfo',
        method: 'post',
        data: {
            id: id
        },
    success:function(data){
        var index = new platform;
        var getdata = {};
        data = JSON.parse(data)
        getdata = index.showdata(data)
        var longitude=getdata.longitude
        var latitude= getdata.latitude
        $('.situation').on('click',function(){
            var map = new BMap.Map("container");
            var point = new BMap.Point(113.964336,22.544239);
            map.enableScrollWheelZoom(true);
            map.centerAndZoom(point, 18);
            map.addControl(new BMap.NavigationControl());
            var marker = new BMap.Marker(point);        // 创建标注
            map.addOverlay(marker);                     // 将标注添加到地图中

        })

    }
,
    error:function () {

    }
})

})
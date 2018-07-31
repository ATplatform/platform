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
                $('#update').find('.'+n).html(data[n]);
                $('.villageimg').attr("src",data['image']);
                this.index[n] = data[n];
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

        /*var map = new BMap.Map("container");
        var point = new BMap.Point(longitude,latitude);
        map.enableScrollWheelZoom(true);
        map.centerAndZoom(point, 18);
        map.addControl(new BMap.NavigationControl());
        var marker = new BMap.Marker(point);        // 创建标注
        map.addOverlay(marker);                     // 将标注添加到地图中*/
    },
    error:function(){

    }
})

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
        },
        error:function () {

        }
    })
}
})


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

$('.update').click(function(e){
    e.stopPropagation();
    inputlisten()
    brief.removeAttribute('readonly');
    $('.brief').css({
        "background": "#f0efee"
    })
    brief.focus()

})

function inputlisten(){
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

});

myDiv.addEventListener("click", function (event) {
    event = event || window.event;
    event.stopPropagation();
});}
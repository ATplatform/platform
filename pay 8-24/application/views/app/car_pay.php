<?php
require 'top.php'
?>


<div class="top">
    <div class="top-wrap clearfloat">
        <div class="left fl">
            <img src="" alt="">
            返回
        </div>
        <div class="title fl">
            停车缴费
        </div>
        <div class="right fl">
            缴费记录
        </div>
    </div>
</div>





<div class="main">

    <span class="car_pay_title">车辆信息</span>
    <div class="park_lot_wrap">
        <span class="park_lot_title">停车场</span>
        <select name="park_lot" id="park_lot">
        </select>
        <img src="<?=$basic_url.'online_info_triangle_c.png'?>" alt="" class="park_lot_select">
    </div>
    <div class="car_list">
    </div>



    <div class="footer_wrap">
        <div class="commit">提交</div>
    </div>
    <div class="blank"></div>
</div>



</body>
</html>



<style>
    html,body:before {

        width: 100%;
        height: 100%;
        content: ' ';
        position: fixed;
        z-index: -1;
        top: 0;
        left: 0;
    }

    .footer_wrap{


        border-radius: 5px;
        width:80%;
        height:1rem;
        background: #00BFA3;
        margin-top:1rem;
        margin-bottom:2rem;
        margin-left:auto;
        margin-right:auto;
        display:flex;
        align-items: center;
        justify-content: center;
    }

    body{
        background: #EEEEEE;
        height:100%;
    }
    *{
        box-sizing:border-box;
    }

    .clearfloat:after{
        display:block;
        clear:both;
        content:"";
        visibility:hidden;
        height:0}
    .clearfloat{zoom:1}

    .fl{
        float:left;
    }

    .fr{
        float:right;


    }
    .blank{
        height:3rem;
    }

    .main{
        height:100%;
        overflow-x:hidden;
        overflow-y:auto;
    }
.commit{
    font-size: 0.46rem;
    color:white;

}

    .top{
        width:10rem;

        background: #00BFA3;
        position: relative;
    }
    .top .top-wrap{

        padding:0.41rem 0;
        display:flex;
        align-items:Center;
        justify-content:center;
    }
    .top .left{
        display:flex;
        align-items:Center;
        justify-content:center;
        width: 2.33rem;
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #FFFFFF;
        letter-spacing: -0.29px;
    }
    .top .right{
        display:flex;
        align-items:Center;
        justify-content:center;
        width: 2.33rem;
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #FFFFFF;
        letter-spacing: -0.29px;
    }
    .top .title{
        display:flex;
        align-items:Center;
        justify-content:center;
        width:5.33rem;
        font-family: PingFangSC-Medium;
        font-size: 0.52rem;
        color: #FFFFFF;
        letter-spacing: -0.2px;

    }

    .car_pay_title{
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #808080;
        letter-spacing: -0.21px;
        margin-left:0.40rem;
    }

    .car_list_wrap,
    .park_lot_wrap,
    .car_pay_wrap{
        background: #FFFFFF;
        padding: 0.46rem 0;
        font-size: 0.52rem;
        position:relative;
    }

    .park_lot_wrap
    {
        margin-bottom:0.19rem;
    }

    .car_list_wrap
    {
        border-bottom: 2px solid #ECECEC;

    }
    .car_list_title,
    .park_lot_title{
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #505050;
        letter-spacing: 0;
        margin-left:0.46rem;

    }


    #park_lot{
        font-family: PingFangSC-Regular;
        font-size: 0.4rem;
        color: #808080;
        letter-spacing: 0;
        margin-left:0.5rem;
        width:4rem;
        height:1rem
    }
    .park_lot_select{
        position:absolute;
        left:5.4rem;
        top:0.48rem;
        width:1rem;
        height:1rem;
        pointer-events: none;
    }
    .car_licence_select{
        position:absolute;
        left:1.4rem;
        top:0.45rem;
        width:1rem;
        height:1rem;
        pointer-events: none;
    }
    select{
        background: none;
        appearance:none;
        -moz-appearance:none;
        -webkit-appearance:none;
    }
    select option {
        font-size: 0.07rem;

    }
    /*select {
        font-size: 1rem;
        background: none;
    }
    select option {
        font-size: 0.07rem;

    }
    select{
        width:3rem;
        background-image: none !important;

        height: 1rem; !important;
        line-height: 4rem;
    }*/




    .car_list_licence{
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #808080;
        letter-spacing: 0;
        margin-left:0.7rem;
    }

    .car_list_radio{
        width:0rem;
        height:0rem;
        float:right;


    }

    #car_place{
        font-family: PingFangSC-Regular;
        font-size: 0.37rem;
        color: #505050;
        letter-spacing: 0;
        text-align: justify;
        width:1.85rem;
        height:0.93rem;
        border: 2px solid #B4B4B4;
        border-radius: 5px;
        margin-left:0.46rem;

    }


.licence_mid{
    position:absolute;
    left:2.5rem;
    top:0.6rem;
}

    #car_licence{
        width:4.63rem;
        height:0.93rem;
        font-size: 0.37rem;
        border: 2px solid #B4B4B4;
        border-radius: 5px;
        margin-left:0.5rem;

    }


    .car_list_new_radio{
        position:absolute;
        right:0.8rem;
        background:url("<?=$basic_url.'home_chose_n.png'?>") no-repeat;
        width:0.6rem;
        height:0.6rem;
        background-size:0.6rem;
    }

    input:checked + .car_list_new_radio{
        background:url("<?=$basic_url.'home_chose_c.png'?>") no-repeat;  /*选中后的样式图片*/
        background-size:0.6rem;
    }


</style>


<script>


    $('.top-wrap .left').click(function(){
        window.location.href=getRootPath()+'/index.php/Paycontrol/index';
    })
    $('.top .right').click(function(){
        window.location.href=getRootPath()+'/index.php/Paycontrol/car_pay_record_h5?person_code=100094&village_id=100001';
    })
 /*   input[type="radio"]:checked + label::before {
        background-color: #01cd78;
        background-clip: content-box;
        padding: .2em;
    }*/

  /*  function checkbox(e){
        console.log(e)
    }*/

  console.log($('input:radio[name="car_list"]:checked').val())



   /* $('.commit').click(function(){
        window.location.href=getRootPath()+'/index.php/pay_h5/car_pay_bill_h5'
    })*/
</script>



<script>
    var person_code=getUrlParam('person_code')
    var village_id=getUrlParam('village_id')
    console.log(person_code)
    console.log(village_id)



    $.ajax({
        url: 'get_car_list',
        method: 'post',
        data: {
            person_code:person_code,
            village_id:village_id
        },
        success: function (res) {
            res=JSON.parse(res)
            console.log(res)
            var html='';
            var num=101;
            for(var n in res)
            {
                var licence=res[n]['licence']
                n=parseInt(n)
             html+=`
              <label for="car_list_radio_`+parseInt(n)+`" >
    <div class="car_list_wrap">
        <span class="car_list_title">车辆`+parseInt(n+1)+`</span><span class="car_list_licence"> `+licence+` </span>

        <input type="radio" name="car_list" value="`+licence+`" class="car_list_radio" id="car_list_radio_`+n+`"><i class="car_list_new_radio"></i>
    </div>
    </label>

            `
            }

            html+=`
                    <label for="car_list_radio_write">
        <div class="car_list_wrap">

            <select name="car_place" id="car_place" style="">
                <option value ="粤">粤</option>
                <option value ="湘">湘</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            <input type="text" name="car_licence" id="car_licence">  <img src="<?=$basic_url.'online_info_triangle_c.png'?>" alt="" class="car_licence_select"> <span class="licence_mid">-</span>
            <input type="radio" name="car_list" value="000" class="car_list_radio" id="car_list_radio_write"><i class="car_list_new_radio"></i>

        </div>
    </label>

                `

            $('.car_list').append(html)

            $('#car_list_radio_0').click()


        },
        error: function () {
            console.log('');
        }
    })



    $('.commit').click(function(){
        var  park_lot=$('#park_lot').val()
        var carNo=$('input[name=car_list]:checked').val()
        if(carNo=='000'){
            var licecen_title=$('#car_place').val()
            carNo=$('#car_licence').val()
            var carNo=licecen_title+'-'+carNo
        }
        console.log(park_lot)
        $.ajax({
            url:'park_pay_139',
            method:'post',
            data:
                {
                    park_lot:park_lot,
                    carNo:carNo
                },
            success: function (res) {
                res=JSON.parse(res)
                console.log(res)
                if(res.result=='success') {

                    standardPost('park_pay_bill', {
                        village_id:village_id,
                        park_lot:park_lot,
                        endTime: res.list.endTime,
                        totalFee: res.list.totalFee,
                        bill_code: res.list.bill_code,
                        issued_time:res.issued_time,
                        carNo:res.carNo
                    })
                }

            },
            error:function(e){
                console.log(e);
            }
        })
    })



    $.ajax({
        url:'park_lot',
        method:'post',
        data:{
            village_id:village_id
        },
        success:function(res){
            res=JSON.parse(res)
            console.log(res)
            html=''
            for(var n in res){
                html+=' <option value="'+res[n].parkcode+'">'+res[n].parkname+'</option>'
            }
$('#park_lot').append(html)


        }
    })



    function standardPost (url,args)
    {
        var form = $("<form method='post'></form>");
        form.attr({"action":url});
        for (arg in args)
        {
            var input = $("<input type='hidden'>");
            input.attr({"name":arg});
            input.val(args[arg]);
            form.append(input);
        }
        $("html").append(form);
        form.submit();
    }
</script>
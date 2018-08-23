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
    select {
        font-size: 0.46rem;
        background: white;
    }
    select option {
        font-size: 0.07rem;

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

    select{
        width:3rem;
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
        font-size: 0.39rem;
        color: #808080;
        letter-spacing: 0;
        margin-left:0.5rem;
    }




    .car_list_licence{
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #808080;
        letter-spacing: 0;
        margin-left:0.7rem;
    }

    .car_list_radio{
        width:0.44rem;
        height:0.44rem;
        float:right;
        margin-right:0.74rem;
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


    #car_place select{
        font-family: PingFangSC-Regular;
        font-size: 40px;
        color: #505050;

    }



    #car_licence{
        width:4.63rem;
        height:0.93rem;
        font-size: 0.37rem;
        border: 2px solid #B4B4B4;
        border-radius: 5px;
    }







</style>


<script>

    $('.top-wrap .left').click(function(){
        window.location.href=getRootPath()+'/index.php/Paycontrol/index';
    })
    $('.top .right').click(function(){
        window.location.href=getRootPath()+'/index.php/Paycontrol/car_pay_record_h5?person_code=100094&village_id=100001';
    })


   /* $('.commit').click(function(){
        window.location.href=getRootPath()+'/index.php/pay_h5/car_pay_bill_h5'
    })*/
</script>



<script>
    var basic_url=getRootPath()+'/application/views/app/h5_pay/';



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
              <label for="car_list_radio_`+parseInt(n)+`">
    <div class="car_list_wrap">
        <span class="car_list_title">车辆`+parseInt(n+1)+`</span><span class="car_list_licence"> `+licence+` </span>
        <input type="radio" name="car_list" value="`+parseInt(num+n)+`" class="car_list_radio" id="car_list_radio_`+n+`">
    </div>
    </label>

            `




            }

            html+=`
                    <label for="car_list_radio_write">
        <div class="car_list_wrap">

            <select name="car_place" id="car_place" style="">
                <option value ="101">粤</option>
                <option value ="102">湘</option>
                <option value="103">1</option>
                <option value="104">2</option>
            </select>
            <input type="text" name="car_licence" id="car_licence">
            <input type="radio" name="car_list" value="`+parseInt(num+n+1)+`" class="car_list_radio" id="car_list_radio_write">

        </div>
    </label>

                `

            $('.car_list').append(html)




        },
        error: function () {
            console.log('');
        }
    })



    $('.commit').click(function(){
        var  park_lot=$('#park_lot').val()
        console.log(park_lot)
        $.ajax({
            url:'park_pay_139',
            method:'post',
            data:
                {

                },
            success: function (res) {
                res=JSON.parse(res)
                console.log(res)

                if(res.result=='success') {
                    standardPost('park_pay_bill', {
                        village_id:100001,
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
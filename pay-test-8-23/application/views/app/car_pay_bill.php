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

        </div>
    </div>
</div>





<div class="main">
    <div class="car_bill_wrap">
        <div><span class="car_licence"><?=$carNo?></span><span  class="pay_money">￥<?=$totalFee?></span></div>
        <div class="car_place"><span class="park_lot"><?=$village_name?></span>  <span><?=$park_lot_name?></span> </div>
        <img src="<?=$basic_url.'online_month_card_pic.png'?>" alt="" class="place_img">
        <div class="in_time_wrap"><span class="in_time_title">入场时间：</span><span class="in_time"><?= $issued_time?> </span>  </div>

        <div class="out_time_wrap"><span  class="out_time_title">离场时间：</span><span class="out_time"><?= $endTime?></span> </div>
        <br>

        <div> <div class="attention_title">温馨提示：</div > <div class="attention_word"> 支付后,请于30分钟内离场，否则另起算停车费。</div></div>
    </div>



</div>
<div class="blank"></div>





<div class="footer_wrap">
    <div class="pay_list_footer">
        <div class="footer">
            <div class="title ">支付方式</div>
            <div class="img_wrap clearfloat">
                <div class="img_wechat fl">
                    <input type="radio" name="wechat_pay" id="wechat_pay" class="wechat_pay" style="display:none" checked>
                    <div class="">  <label for="pay" onclick="wechat_pay_click(this)"><img src="<?=$basic_url.'online_chose_dark.png'?>" width="" height=""  class="wechat_pay_new_radio"  /> <img  src="<?=$basic_url.'online_wechat.png'?>" alt="" class="wechat_img"></label></div>
                    <div  class="wechat_word" style="">微信支付</div>
                </div>

                <div class="img_alipay fl">
                    <input type="radio" name="ali_pay" id="ali_pay" class="ali_pay" style="display:none" >
                    <div class="">  <label for="pay" onclick="ali_pay_click(this)"><img src="<?=$basic_url.'online_chose_dark.png'?>" width="" height=""  class="ali_pay_new_radio"  /> <img  src="<?=$basic_url.'online_alipay.png'?>" alt="" class="ali_img"></label></div>
                    <div  class="alipay_word" style="">支付宝支付</div>
                </div>
            </div>
        </div>
        <style>

            .img_wechat,
            .img_alipay{
                position:relative
            }

            .wechat_pay_new_radio,
            .ali_pay_new_radio{
                position:absolute;
                left:110px;
            }

        </style>

        <div class="pay clearfloat">
            <div class="pay_info fl clearfloat">
             <!--   <div class="pay_info_wrap fl">
                    <input type="radio" name="pay_choice" class="pay_choice_radio" id="pay_choice" ><label for="pay_choice"><img src="<?/*=$basic_url.'online_chose_light.png'*/?>" width="" height="" onclick="checkbox(this)" class="pay_choice_new_radio"/><span class="pay_choice">全选</span></label>

                </div>-->
                <div class="total_wrap fl"><span class="total">合计:&nbsp; &nbsp;<span class="total_money">￥<?=$totalFee?></span></span></div>
            </div>
            <div class="pay_now fl"><span>立即支付</span></div>
        </div>
    </div>



</div>


<input type="hidden" value='<?php echo $basic_url;?>' name="basic_url" />
<input type="hidden" value='<?php echo $endTime;?>' name="endTime" />
<input type="hidden" value='<?php echo $totalFee;?>' name="totalFee" />
<input type="hidden" value='<?php echo $bill_code;?>' name="bill_code" />

</body>
</html>
<script>
    var endTime=$('input[name=endTime]').val()
    var totalFee=$('input[name=totalFee]').val()
    var bill_code=$('input[name=bill_code]').val()
    var basic_url=$('input[name=basic_url]').val()
    console.log(endTime)
    console.log(totalFee)
    console.log(bill_code)
    console.log(basic_url)

</script>


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



    body{
        background: #EEEEEE;
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


    .main{
        background: #FFFFFF;
        box-shadow: 0 0 10px 0 rgba(0,150,136,0.10);
        border-radius: 10px;
        margin-top:0.19rem;

        height:9.58rem;
    }
    .blank{
        height:1.85rem;
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




    .footer_wrap{position:absolute;bottom:0;width:100%}




    .footer{
        width:100%;
        background: #FFFFFF;
        box-shadow: 0 -3px 10px 0 rgba(0,0,0,0.10);
        border-radius: 10px;
        margin-top:10px;

        height:2.69rem;

    }

    .footer .title{
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #808080;
        letter-spacing: 0;
        padding-top:0.19rem;
        padding-left:0.28rem;

    }

    .footer .img_wrap{
        margin-top:15px;
        width:100%;
    }

    .footer  .img_wechat{
        position:relative;
        margin-left:24%;
    }
    .footer .img_wechat .wechat_word{
        position:absolute;
        left:-0.19rem;
        top:1rem;
        font-family: PingFangSC-Regular;
        font-size: 0.33rem;
        color: #808080;
        letter-spacing: 0;width:1.85rem;
    }
    .footer  .img_alipay{
        position:relative;
        margin-left:33%;
    }
    .footer .img_alipay .alipay_word{
        position:absolute;
        left:-0.32rem;
        top:1rem;
        font-family: PingFangSC-Regular;
        font-size: 0.33rem;
        color: #808080;
        letter-spacing: 0;
        width:1.85rem;
    }

    .pay{
        background: #F7F7F7;
        width:100%;
    }

    .month_card,
    .pay_info{
        width:65%;
        margin:0.48rem  0;
        font-size: 0.39rem;
    }

    .pay_choice{
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #505050;
        letter-spacing: -0.26px;
        margin-left:0.46rem;
    }

    .pay_now{
        width:35%;
        height:1.52rem;
        background: #00BFA3;
        box-shadow: inset 0 1px 1px 0 #B4B4B4;
        display:flex;
        align-items:center;
        justify-content:center;

    }



    .pay_now span{
        font-family: PingFangSC-Regular;
        font-size: 0.43rem;
        color: #FFFFFF;
        letter-spacing: -0.28px;

    }


    .total{
        font-family: PingFangSC-Regular;
        font-size: 0.43rem;
        color: #505050;
        letter-spacing: -0.28px;

    }

    .total_money{
        color: #00BFA3
    }
    .total_wrap{
        padding-right:0.19rem;
        margin-left:0.3rem;

    }

    .month_card_wrap,
    .pay_info_wrap{
        position:relative;
        padding-left:0.35rem;

    }

    .pay_choice_radio{
        transform: scale(3,3);
        border: 3px solid #B6B6B6;
        position:absolute;
        top:0.19rem;
        visibility: hidden;
    }
    .pay_choice_new_radio{

        position:absolute;
        top:0px;
        left:0.19rem;
        width:0.44rem;
        height:0.44rem;
    }


    .img_wechat,
    .img_alipay{
        position:relative;
        width:0.93rem;
        height:0.93rem;

    }

    .ali_img,
    .wechat_img{
        width:0.93rem;
        height:0.93rem;

    }

    .wechat_pay_new_radio,
    .ali_pay_new_radio{
        position:absolute;
        left:1.02rem;
        width:0.44rem;
        height:0.44rem;
    }









    .car_pay_title{
        font-family: PingFangSC-Regular;
        font-size: 42px;
        color: #808080;
        letter-spacing: -0.21px;

    }

    .car_list_wrap,
    .park_lot_wrap,
    .car_pay_wrap{
        background: #FFFFFF;
        padding: 50px 0;
    }

    .park_lot_wrap
    {
        margin-bottom:20px;
    }

    .car_list_wrap
    {
        border-bottom: 2px solid #ECECEC;

    }

    .park_lot_title{
        font-family: PingFangSC-Regular;
        font-size: 42px;
        color: #505050;
        letter-spacing: 0;
        margin-left:50px;

    }

    #park_lot option,
    #park_lot{
        font-family: PingFangSC-Regular;
        font-size: 42px;
        color: #808080;
        letter-spacing: 0;
    }

    .car_list_title{
        font-family: PingFangSC-Regular;
        font-size: 42px;
        color: #505050;
        letter-spacing: 0;
        margin-left:50px;
    }

    .car_list_licence{
        font-family: PingFangSC-Regular;
        font-size: 42px;
        color: #808080;
        letter-spacing: 0;
    }

    .car_list_radio{
        width:48px;
        height:48px;
        float:right;
    }

    #car_place{
        font-family: PingFangSC-Regular;
        font-size: 40px;
        color: #505050;
        letter-spacing: 0;
        text-align: justify;
        width:200px;
        height:100px;
        border: 2px solid #B4B4B4;
        border-radius: 5px;
        margin-left:50px;
    }


    #car_place select{
        font-family: PingFangSC-Regular;
        font-size: 40px;
        color: #505050;

    }




    #car_licence{
        width:500px;
        height:100px;
        font-size: 40px;
        border: 2px solid #B4B4B4;
        border-radius: 5px;
    }




     .car_licence{
         font-family: PingFangSC-Medium;
         font-size: 0.44rem;
         color: #505050;
         letter-spacing: -0.26px;
         margin-left:0.37rem;
     }

    .pay_money{
        font-family: PingFangSC-Medium;
        font-size: 0.44rem;
        color: #00BFA3;
        letter-spacing: -0.26px;
        margin-left:0.46rem;
    }
    .car_place{
        font-family: PingFangSC-Regular;
        font-size: 0.37rem;
        color: #808080;
        letter-spacing: -0.22px;
        margin-left:0.39rem;
    }

    .place_img{
        width:3.98rem;
        height:2.04rem;
        margin-left:2.82rem;

        margin-top:0.81rem;
    }

    .in_time_wrap,out_time_wrap{
        height: 0.37rem;
        margin-bottom:0.28rem;
    }
    .in_time_title,.out_time_title
    {
        font-family: PingFangSC-Regular;
        font-size: 0.37rem;
        color: #808080;
        letter-spacing: -0.22px;
        margin-left:0.39rem;
    }

    .in_time,.out_time
    {
        font-family: PingFangSC-Regular;
        font-size: 0.37rem;
        color: #505050;
        letter-spacing: -0.22px;

    }

    .attention_title{
        font-family: PingFangSC-Regular;
        font-size: 0.37rem;
        color: #808080;
        letter-spacing: -0.22px;
        margin-left:0.39rem;
    }

    .attention_word{
        font-family: PingFangSC-Regular;
        font-size: 0.37rem;
        color: #505050;
        letter-spacing: -0.22px;
        margin-left:0.39rem;
        padding-bottom:0.56rem;
    }



</style>

<script>
    $('.top-wrap .left').click(function(){
        window.location.href=getRootPath()+'/index.php/Paycontrol/car_pay_h5?person_code=100094&village_id=100001'
    })

    var wechat_pay_result = false;
    var ali_pay_result = true;
    $('.wechat_pay_new_radio').css({"visibility":"visible"})
    $('.ali_pay_new_radio').css({"visibility":"hidden"})
    function wechat_pay_click(e) {
        if (wechat_pay_result==true && ali_pay_result==true)
        {
            console.log(e)
            wechat_pay_result=false;
            $('.wechat_pay_new_radio').css({"visibility":"visible"})
        }
        else if(wechat_pay_result==true && ali_pay_result==false)
        {
            $('.wechat_pay_new_radio').css({"visibility":"visible"})
            $('.ali_pay_new_radio').css({"visibility":"hidden"})
            wechat_pay_result=false;
            ali_pay_result=true;
        }

    }

    function ali_pay_click(e) {
        if (ali_pay_result==true && wechat_pay_result==true )
        {
            $('.ali_pay_new_radio').css({"visibility":"visible"})
            ali_pay_result=false;

        }
        else if(ali_pay_result==true &&   wechat_pay_result==false)
        {
            $('.wechat_pay_new_radio').css({"visibility":"hidden"})
            $('.ali_pay_new_radio').css({"visibility":"visible"})
            wechat_pay_result=true;
            ali_pay_result=false;
        }

    }



</script>


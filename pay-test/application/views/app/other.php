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
            增值服务缴费
        </div>
        <div class="right fl">
            缴费记录
        </div>
    </div>
</div>





<div class="main">

    <div class="blank"></div>
</div>

<div class="footer_wrap">
    <div class="pay_list_footer">
        <div class="footer">
            <div class="title ">支付方式</div>
            <div class="img_wrap clearfloat">
                <div class="img_wechat fl">
                    <input type="radio" name="wechat_pay" id="wechat_pay" class="wechat_pay" style="display:none" checked>
                    <div class="">  <label for="pay" onclick="wechat_pay_click(this)"><img src="<?=$basic_url.'online_chose_dark.png'?>" width="" height=""  class="wechat_pay_new_radio"  /> <img  src="<?=$basic_url.'online_wechat.png'?>" alt="" class="img_wechat"></label></div>
                    <div  class="wechat_word" style="">微信支付</div>
                </div>

                <div class="img_alipay fl">
                    <input type="radio" name="ali_pay" id="ali_pay" class="ali_pay" style="display:none" >
                    <div class="">  <label for="pay" onclick="ali_pay_click(this)"><img src="<?=$basic_url.'online_chose_dark.png'?>" width="" height=""  class="ali_pay_new_radio"  /> <img  src="<?=$basic_url.'online_alipay.png'?>" alt="" class="img_alipay"></label></div>
                    <div  class="alipay_word" style="">支付宝支付</div>
                </div>
            </div>
        </div>


        <div class="pay clearfloat">
            <div class="pay_info fl clearfloat">
                <div class="pay_info_wrap fl">
                    <input type="radio" name="pay_choice" class="pay_choice_radio" id="pay_choice" ><label for="pay_choice"><img src="<?=$basic_url.'online_chose_light.png'?>" width="" height="" onclick="checkbox(this)" class="pay_choice_new_radio"/><span class="pay_choice">全选</span></label>

                </div>
                <div class="total_wrap fr"><span class="total ">合计:&nbsp; &nbsp;<span>￥0</span></span></div>
            </div>
            <div class="pay_now fl"><span>立即支付</span></div>
        </div>
    </div>



</div>



</body>
</html>

<script>
    var person_code=getUrlParam('person_code')
    var village_id=getUrlParam('village_id')
    console.log(person_code)
    console.log(village_id)
    $.ajax({
        url: 'bill_list_other',
        method: 'post',
        data: {
            person_code:person_code
        },
        success: function (res) {
            res=JSON.parse(res)
            var new_res=[]
            var final_res=[]
            var bill_total=0
            for(var n in res){
                //console.log(res[n]['person_code'])
                //console.log(typeof res[n]['person_code'])
                res[n]['person_code']=JSON.parse( res[n]['person_code'])
                // console.log(res[n]['person_code'])
                // console.log(typeof res[n]['person_code'])
            }
            for(var n in res){
                for(var m in res[n]['person_code']){
                    if(person_code==res[n]['person_code'][m])
                    {
                        new_res.push(res[n]['code'])
                        //console.log(res[n]['code'])
                    }
                }
            }
            for(var n in res){
                for(var m in new_res){
                    if(new_res[m]==res[n]['code']){
                        final_res.push(res[n])
                        //res[n]['bill_amount']=parseInt(res[n]['bill_amount'])
                        res[n]['bill_amount']=parseFloat(res[n]['bill_amount'])
                        bill_total=bill_total+res[n]['bill_amount']
                    }
                }
            }

            var html = '';
            for (var n=0 ;n<final_res.length;n++) {
                var code=final_res[n]['code']
                var time = final_res[n]['bill_month'].split('-')['0']+'年'+final_res[n]['bill_month'].split('-')['1'] + '月';
                /*var pay_year=final_res[n]['initial_time'].split('-')['0']

                var pay_month=final_res[n]['initial_time'].split('-')['1']
                var pay_date=final_res[n]['initial_time'].split('-')['2'].split(' ')['0']*/

                var address='';
                /*     var person=final_res[n]['remark'].split('缴费人:')['1']*/
                var initial_time = final_res[n]['initial_time']
                var bill_amount = final_res[n]['bill_amount']
                var bill_source_code = final_res[n]['bill_source_code']
                var bill_type = final_res[n]['bill_type']
                var bill_type_name = final_res[n]['bill_type_name']
                var pay_method= final_res[n]['pay_method_name']
                html +=`
                      <div class="list_other_wrap clearfloat ">

        <div class="list_other fl">
            <div class="list_title ">
                <img class="online_park_rent" src="<?=$basic_url.'online_value_added_service_fee.png'?>" alt="" style="">
                <span class="list_title_word">`+'编号: '+code+`</span>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>

            <div class="list_content clearfloat">
                <div class=" fl">  <input type="checkbox" name="list_other_radio" id="list_other_radio" class="list_other_radio" ><label for="list_other_radio"><img src="<?=$basic_url.'online_chose_light.png'?>" width="" height="" onclick="checkbox(this)" class="list_other_new_radio" /></label></div>
                <div class="fl">
                    <span  class="list_content_word">吊灯维修</span>
                </div>
                <div  class="list_content_money fr">￥`+bill_amount+`</div>
				 <div class="list_content_man fl">处理人: <span>李琦运</span></div>
            </div>

        </div>
    </div>
                `
            }
            $('.main').prepend(html)
            console.log(final_res)
        },
        error: function () {
            console.log('更新车位信息出错');
        }
    })




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
        visibility:
                hidden;
        height:0}
    .clearfloat{zoom:1}

    .fl{
        float:left;
    }

    .fr{
        float:right;


    }


    .main{
        height:11.11rem;
        overflow-x:hidden;
        overflow-y:auto;
    }
    .blank{
        height:1.85rem;
    }

    .top{
        width:10rempx;

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



    .tab_wrap{
        width:100%;
        position:relative;
    }


    .tab1{
        width:50%;
        height:0.93rem;
        font-family: PingFangSC-Regular;
        font-size: 0.37rem;
        color: #505050;
        letter-spacing: 0;
        display:flex;
        align-items:Center;
        justify-content:center;
        background: #F6F6F6;
        box-shadow: 0 2px 0 0 #B4B4B4;
        border-right:2px solid #DCDCDC;
        vertical-align: middle;
    }

    .tab2{
        width:50%;
        height:0.93rem;
        font-family: PingFangSC-Regular;
        font-size: 0.37rem;
        color: #505050;
        letter-spacing: 0;
        display:flex;
        align-items:Center;
        justify-content:center;
        background: #F6F6F6;
        box-shadow: 0 2px 0 0 #B4B4B4;
    }

    .tab_active{
        border-bottom:4px solid #00BFA3;
        background: #FFFFFF;
        color: #00BFA3;
        box-shadow: 0 0 0 0 ;
    }

    .list_other_wrap,
    .list_advance_wrap,
    .list_wrap{
        margin-top:10px;
        width:98%;

        background: #FFFFFF;
        box-shadow: 0 0 10px 0 rgba(0,150,136,0.10);
        border-radius: 10px;
        margin-left:1%;
        margin-right:1%;
        position:relative;
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
        margin-top:0.14rem;
        width:100%;
    }

    .footer  .img_wechat{
        position:relative;
        margin-left:24%;
    }
    .footer .img_wechat .wechat_word{
        position:absolute;
        left:0rem;
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
        font-size: 0.39rem;
    }

    .month_card,
    .pay_info{
        width:65%;
        margin:0.48rem 0;
    }

    .pay_choice{
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #505050;
        letter-spacing: -0.26px;
        margin-left:0.7rem;
    }

    .pay_now{
        width:35%;
        height:1.52rem;
        background: #00BFA3;
        box-shadow: inset 0 1px 1px 0 #B4B4B4;
        display:flex;
        align-items:Center;
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

    .month_card_total_wrap,
    .total_wrap{
        padding-right:0.19rem;
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
        top:-0.05rem;
        left:0.19rem;
    }

    .online_park_rent{
        width:0.67rem;
        height:0.67rem;
        margin-left:0.35rem;

    }
    .list_title{
        margin-top:0.17rem;
        margin-bottom:0.46rem;
        font-size: 0.39rem;
    }
    .list_title_word{
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #808080;
        letter-spacing: 0;
    }

    .list_title_time{
        font-family: PingFangSC-Regular;
        font-size: 0.33rem;
        color: #808080;
        letter-spacing: 0;
    }

    .list_other_radio,
    .list_visitor_radio,
    .list_car_radio{
        position:absolute;
        top:0.21rem;
        left:-0.46rem;
        visibility: hidden;
    }

    .list_other_new_radio,
    .list_car_new_radio{
        position:absolute;
        top:-0.08rem;
        left:0.4rem;
    }

    .list_content{
        margin-bottom:0.28rem;
        position:relative;
        width:inherit;
        font-size: 0.65rem;
    }

    .list_content_person,
    .list_content_word{
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #505050;
        letter-spacing: 0;
        position:absolute;
        top:0rem;
        left:1.2rem;
    }
    .list_content_rent_money,
    .list_content_licence
    {

        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #505050;
        letter-spacing: 0;

    }

    .list_content_man,
    .list_content_time{
        font-family: PingFangSC-Regular;
        font-size: 0.33rem;
        color: #808080;
        letter-spacing: 0;
        width:100%;
        margin-top:0.09rem;
        margin-left:1.18rem;
    }
    .list_content_time_img_{
        width:1.20rem;
        height:1.20rem;
        margin-right:0.74rem;
    }

    .list_content_money{
        font-family: PingFangSC-Regular;
        font-size: 0.39rem;
        color: #505050;
        letter-spacing: 0;
        text-align: right;
        margin-right:0.93rem;
        padding-right:0.09rem;
    }



    .img_wechat,
    .img_alipay{
        position:relative;
        width:0.93rem;
        height:0.93rem
    }



    .wechat_pay_new_radio,
    .ali_pay_new_radio{
        position:absolute;
        left:1.32rem;

    }



</style>

<script>

    $('.top-wrap .left').click(function(){
        window.location.href=getRootPath()+'/index.php/pay_h5/index_h5';
    })
    $('.top-wrap .right').click(function(){
        window.location.href=getRootPath()+'/index.php/pay_h5/other_record_h5?person_code=100004&village_id=100001';
    })


</script>


<script>
    var height=$(window).height()
    height=height*0.6
    $('.main').css({"height":height})


    $('.list_wrap').css({"display":"block"})
    $('.list_advance_wrap').css({"display":"none"})

    $('.tab1').click(function(){
        $('.tab1').addClass('tab_active')
        $('.tab2').removeClass('tab_active')
        $('.list_wrap').css({"display":"block"})
        $('.list_advance_wrap').css({"display":"none"})

    })

    $('.tab2').click(function(){
        $('.tab2').addClass('tab_active')
        $('.tab1').removeClass('tab_active')
        $('.list_advance_wrap').css({"display":"block"})
        $('.list_wrap').css({"display":"none"})
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




    $('.pay_now').click(function(){
        var final_amount=0
        var exact_bill_code=[]

        for(var n=0;n<$('.list_wrap input[name=list_other_radio]')['length'];n++)
        {
            var i=n+1
            console.log($('.list_wrap #list_other_radio'+i)['0']['checked'])
            if( $('.list_wrap #list_other_radio'+i)['0']['checked']){
                exact_bill_code.push($('.list_wrap #list_other_radio'+i).data('code'))
            }
        }
        console.log(exact_bill_code)

        for(var n in amount)
        {
            for(var m in exact_bill_code)
            {
                if(exact_bill_code[m]==n){
                    final_amount+=parseInt(amount[n])
                }
            }
        }
        console.log(final_amount)
    })


    $('.pay_choice_new_radio').click(function(){

        var i=n+1
        for(var n=0;n<$('.list_other_new_radio')['length'];n++)
        {
            /*        $($('.list_car_new_radio')[n]).attr("all-checked","true")*/
            console.log(  $($('.list_other_new_radio')[n]))
            if(   !$($('.list_other_new_radio')[n]).attr("all-checked")){
                console.log($($('.list_other_new_radio')[n]).attr("all-checked"))
                $($('.list_other_new_radio')[n]).attr("all-checked","true")
                $($('.list_other_new_radio')[n]).attr("checked","true")
                $($('.list_other_radio'+i)[n]).attr("checked","true")
                $($('.list_other_new_radio')[n])['0'].src = "<?=$basic_url.'online_chose_dark.png'?>"

            }
            else{
                console.log($($('.list_other_new_radio')[n]).attr("all-checked"))
                $($('.list_other_new_radio')[n]).removeAttr("all-checked")
                $($('.list_other_new_radio')[n]).removeAttr("checked")
                $($('.list_other_radio'+i)[n]).removeAttr("checked","true")
                $($('.list_other_new_radio')[n])['0'].src = "<?=$basic_url.'online_chose_light.png'?>"
                console.log(   $($('.list_other_new_radio')[n]).src)
            }

        }
    })


</script>
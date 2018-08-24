<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>JS Bin</title>
</head>
    <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<body>
<div class="top">
    <div class="top-wrap clearfloat">
        <div class="left fl">
         取消
         </div>
         <div class="title fl">
        续费
         </div>
 
    </div>
</div>
  <div class="main">
    <div class="continue_wrap">
    <div class="continue_title">续费信息</div>
    <div class="continue_info">
      <div class="continue_park_wrap">
        <span class="continue_word">停车场</span>
        <span class="continue_result">1号停车场</span>
      </div>
      <div class="continue_begin_date">
       <span  class="continue_word">开始时间</span>
            <span class="continue_result">2018/10/01</span>
          <div class="time_png"> <img src="./personal_time.png" alt="" width="60px" height="60px" ></div>
      </div>
      <div class="continue_end_date">
      <span class="continue_word">结束时间  </span>
            <span class="continue_result">请选择结束时间</span>
          <div class="time_png"> <img src="./personal_time.png" alt="" width="60px" height="60px" ></div>
      </div>
    </div>
    </div>
	
  </div>
  <div class="footer_wrap">
      <div class="pay_month_footer">
    <div class="pay clearfloat">
        <div class="month_card fl clearfloat">
            <div class="month_card_wrap fl">
              <span class="month_card_buy">共0天 </span>
            </div>
         <div class="total_wrap fr"><span class="total ">合计:&nbsp; &nbsp;<span>￥0</span></span></div>
        </div>
        <div class="pay_now fl"><span>立即支付</span></div>
    </div>
    </div>
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
    .top{
        width:100%;
        background: #00BFA3;
        position: relative;
     }
     .top .top-wrap{
        height:78px;
        padding:44px 0;
    }
    .top .left{
        text-align: center;
        height:100%;
        width:23%;
        font-family: PingFangSC-Regular;
        font-size: 42px;
        color: #FFFFFF;
        letter-spacing: -0.29px;
    }

     .top .title{
        height:100%;
        width:54%;
        font-family: PingFangSC-Medium;
        font-size: 56px;
        color: #FFFFFF;
        letter-spacing: -0.2px;
        text-align: center;
    }
.continue_wrap{
  position:relative;
}
.continue_title{
  font-family: PingFangSC-Regular;
font-size: 42px;
color: #808080;
letter-spacing: -0.21px;
  margin-top:47px;
    margin-left:42px;
  margin-bottom:18px;
}
.continue_info{
  background: #FFFFFF;
  height:484px;
 

}
.continue_park_wrap{
  height:33.3%;
       display:flex;
   align-items:Center;
  border-bottom:2px solid #ECECEC;
 
}
.continue_begin_date{
  height:33.3%;
       display:flex;
   align-items:Center;
    border-bottom:2px solid #ECECEC;
 
}
.continue_end_date{
  height:33.3%;
       display:flex;
   align-items:Center;

}
.continue_word{
font-family: PingFangSC-Regular;
font-size: 42px;
color: #808080;
letter-spacing: 0;
     margin-left:50px;
  
}

.continue_result{
   font-family: PingFangSC-Regular;
font-size: 42px;
color: #505050;
letter-spacing: 0;
margin-left:358px; 
position:absolute;
}

   .pay{
        background: #F7F7F7;
        width:100%;
    }


 .month_card{
        width:65%;
        margin:52px 0;
    }

   .month_card_wrap{
        position:relative;
        padding-left:38px;

    }

 .month_card_buy{
        font-family: PingFangSC-Regular;
        font-size: 42px;
        color: #505050;
        letter-spacing: -0.26px;
    }

.total_wrap{
        padding-right:20px;
    }
   .total{
        font-family: PingFangSC-Regular;
        font-size: 46px;
        color: #505050;
        letter-spacing: -0.28px;
    }
    .month_card_total_wrap{
        font-family: PingFangSC-Regular;
        font-size: 46px;
        color: #00BFA3;
        letter-spacing: -0.28px;
        text-align: right;
    }

 .pay_now{
        width:35%;
        height:164px;
        background: #00BFA3;
        box-shadow: inset 0 1px 1px 0 #B4B4B4;
        display:flex;
        align-items:Center;
        justify-content:center;

    }
   .pay_now span{
        font-family: PingFangSC-Regular;
        font-size: 46px;
        color: #FFFFFF;
        letter-spacing: -0.28px;

    }

    .footer_wrap{position:absolute;bottom:0;width:100%}
.time_png{margin-left:650px;}
</style>

	<script>
	$('.top-wrap .left').click(function(){
	  window.location.href='http://mr-almost.site/h5_pay/h5.html';
	})
	</script>



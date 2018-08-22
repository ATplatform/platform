<?php
require 'top.php'
?>


<div class="top">
    <div class="top-wrap clearfloat">
        <div class="left fl">
         返回
         </div>
         <div class="title fl">
        缴费记录
         </div>

    </div>
</div>

  
  
  <div class="main">
 


       <div class="blank"></div>
   </div>
   

</body>
</html>

<script>
    var basic_url=getRootPath()+'/application/views/app/h5_pay/';
    var person_code=getUrlParam('person_code')
    var village_id=getUrlParam('village_id')
    function getRootPath(){
        //获取当前网址，如： http://localhost:8083/proj/meun.jsp
        var curWwwPath = window.document.location.href;
        //获取主机地址之后的目录，如： proj/meun.jsp
        var pathName = window.document.location.pathname;
        var pos = curWwwPath.indexOf(pathName);
        //获取主机地址，如： http://localhost:8083
        var localhostPath = curWwwPath.substring(0, pos);
        //获取带"/"的项目名，如：/proj
        var projectName = pathName.substring(0, pathName.substr(1).indexOf('/')+1);
        return(localhostPath + projectName);
    }

    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return decodeURIComponent(r[2]); return ""; //返回参数值
    }

    $.ajax({
        url: 'bill_list_other_record',
        method: 'post',
        data: {
            person_code: person_code
        },
        success: function (res) {
            res = JSON.parse(res)
            var new_res = []
            var final_res = []
            var bill_total = 0
            for (var n in res) {
                //console.log(res[n]['person_code'])
                //console.log(typeof res[n]['person_code'])
                res[n]['person_code'] = JSON.parse(res[n]['person_code'])
                // console.log(res[n]['person_code'])
                // console.log(typeof res[n]['person_code'])
            }
            for (var n in res) {
                for (var m in res[n]['person_code']) {
                    if (person_code == res[n]['person_code'][m]) {
                        new_res.push(res[n]['code'])
                        //console.log(res[n]['code'])
                    }
                }
            }
            for (var n in res) {
                for (var m in new_res) {
                    if (new_res[m] == res[n]['code']) {
                        final_res.push(res[n])
                        //res[n]['bill_amount']=parseInt(res[n]['bill_amount'])
                        res[n]['bill_amount'] = parseFloat(res[n]['bill_amount'])
                        bill_total = bill_total + res[n]['bill_amount']
                    }
                }
            }
            console.log(final_res)
            var html = '';
            for (var n=0 ;n<final_res.length;n++) {

                var time = final_res[n]['bill_month'].split('-')['0']+'年'+final_res[n]['bill_month'].split('-')['1'] + '月';
                var pay_year=final_res[n]['initial_time'].split('-')['0']

                var pay_month=final_res[n]['initial_time'].split('-')['1']
                var pay_date=final_res[n]['initial_time'].split('-')['2'].split(' ')['0']
                console.log(pay_date)
                var address='';
             /*   var person=final_res[n]['remark'].split('缴费人:')['1']*/
                var person='测试'
                var initial_time = final_res[n]['initial_time']
                var bill_amount = final_res[n]['bill_amount']
                var bill_source_code = final_res[n]['bill_source_code']
                var bill_type = final_res[n]['bill_type']
                var bill_type_name = final_res[n]['bill_type_name']
                var pay_method= final_res[n]['pay_method_name']

                var title = bill_type_name + address+time
                console.log(title)
                console.log(bill_amount)
                console.log(person)
                if(n==final_res.length-1){
                    html +=`
                    <div class="pay_record clearfloat">
      <div class="pay_record_time fl">
        <div class="year">`+pay_year+`</div>
            <div class="mon_date">`+pay_month+`/`+pay_date+`</div>
      </div>
      <div class="circle fl"></div>

       <div class="pay_record_info fl">
         <div class="word">`+bill_type_name+`</div>
         <div class="pay_record_method fr">`+pay_method+`</div>
                      <div class="word">`+time+'账单'+`</div>


          <div class="value fl">增值费:&nbsp;&nbsp;`+bill_amount +`元<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`+person+`</span></div>
       </div>

    </div>



                `


                }else{

                    html +=`
                        <div class="pay_record clearfloat">
                        <div class="pay_record_time fl">
                        <div class="year">`+pay_year+`</div>
                        <div class="mon_date">`+pay_month+`/`+pay_date+`</div>
                        </div>
                        <div class="circle fl"></div>
                        <div class="line fl"></div>
                        <div class="pay_record_info fl">
                        <div class="word">`+bill_type_name+`</div>
                        <div class="pay_record_method fr">`+pay_method+`</div>
                        <div class="word">`+time+'账单'+`</div>


                        <div class="value fl">物业费:&nbsp;&nbsp;`+bill_amount +`元<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`+person+`</span></div>
                    </div>

                    </div>



                        `
                }
            }
            $('.main').prepend(html)
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
 
.blank{
  height:400px;
}
    .main{
      height:200%;
     overflow-x:hidden; 
      overflow-y:auto;  
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
.pay_record{
   position:relative;
  margin-top:40px;
   margin-left:40px;
}
.pay_record_info{
  margin-left:104px;
    width:70%;
}
.pay_record .circle{
  width: 30px;     
  height: 30px;    
background: #0BB49B;   
  border-radius: 50%;
 position:absolute;
  left:130px;
  top:40px;
}

.pay_record .line{
  width: 2px;     
  height: 238px;
background: #0BB49B;   
 border:1px solid transparent;;
 position:absolute;
  left:143px;
  top:40px;
}



.pay_record_time{
  font-family: PingFangSC-Regular;
font-size: 36px;
color: #0BB49B;
letter-spacing: -0.25px;
text-align: center;
}

.pay_record_time .year{
   margin-bottom:8px;
}

.pay_record_info .word{
  font-family: PingFangSC-Regular;
font-size: 40px;
color: #505050;
letter-spacing: -0.2px;
  margin-bottom:10px;
  width:100%;
}

.pay_record_info .value{
font-family: PingFangSC-Regular;
font-size: 36px;
color: #808080;
letter-spacing: -0.18px;
}
.pay_record_method{
  font-family: PingFangSC-Regular;
font-size: 36px;
color: #808080;
letter-spacing: -0.18px;
text-align: center;
  margin-left:90px;
}




    .footer_wrap{position:absolute;bottom:0;width:100%}

</style>


<script>
 var mobileHeight=window.innerHeight+"px";
 document.getElementsByTagName('html')[0].style.minHeight=mobileHeight;
 
 
var height=$(window).height()
$('.main').css({"height":height})


	$('.top-wrap .left').click(function(){
	  window.location.href=getRootPath()+'/index.php/pay_h5/other_h5?person_code=100004&village_id=100001';
	})
</script>


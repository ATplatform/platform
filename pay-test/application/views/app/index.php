<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>JS Bin</title>
    <meta charset="utf-8">

    <script src='<?=base_url().'application/views/plugin/jquery/jquery2.1.1.js'?>'></script>
</head>
<body>

<button class="car">停车缴费</button>
<button  class="property">物业缴费</button>
<button class="other">增值服务缴费</button>
</body>
</html>

 
<style>

body{

display:flex;
        align-items:Center;
        justify-content:center;
}

button{
font-size:40px;
width:400px;
height:100px;
}
</style>

<script>
$('.car').click(function(){
 window.location.href='http://139.159.224.188/pay-test/index.php/Paycontrol/car_pay_h5?person_code=100094&village_id=100001';
})
$('.property').click(function(){
 window.location.href='http://139.159.224.188/pay-test/index.php/Paycontrol/property_h5?person_code=100094&village_id=100001';
})
$('.other').click(function(){
 window.location.href='http://139.159.224.188/pay-test/index.php/Paycontrol/other_h5?person_code=100004&village_id=100001';
})
</script>
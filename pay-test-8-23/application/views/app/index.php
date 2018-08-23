<?php
require 'top.php'
?>



<button class="car">停车缴费</button>
<button  class="property">物业缴费</button>
<button class="other">增值服务缴费</button>
</body>
</html>

 
<style>

body{

display:flex;
        align-items:center;
        justify-content:center;
}

button{
    font-size:0.37rem;
    width:3.70rem;
    height:0.93rem;
}
</style>

<script>
$('.car').click(function(){
 window.location.href=getRootPath()+'/index.php/Paycontrol/car_pay_h5?person_code=100094&village_id=100001';
})
$('.property').click(function(){
 window.location.href=getRootPath()+'/index.php/Paycontrol/property_h5?person_code=100094&village_id=100001';
})
$('.other').click(function(){
 window.location.href=getRootPath()+'/index.php/Paycontrol/other_h5?person_code=100004&village_id=100001';
})
</script>
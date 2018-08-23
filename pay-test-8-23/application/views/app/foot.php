<div class="footer_wrap">
    <div class="pay_list_footer">
        <div class="footer">
            <div class="title ">支付方式</div>
            <div class="img_wrap clearfloat">
                <div class="img_wechat fl">
                    <input type="radio" name="wechat_pay" id="wechat_pay" class="wechat_pay" style="display:none" checked>
                    <div class="">  <label for="pay" onclick="wechat_pay_click(this)"><img src="<?=$basic_url.'online_chose_dark.png'?>" width="" height=""  class="wechat_pay_new_radio"  /> <img class="wechat_img" src="<?=$basic_url.'online_wechat.png'?>" ></label></div>
                    <div  class="wechat_word" style="">微信支付</div>
                </div>

                <div class="img_alipay fl">
                    <input type="radio" name="ali_pay" id="ali_pay" class="ali_pay" style="display:none" >
                    <div class="">  <label for="pay" onclick="ali_pay_click(this)"><img    src="<?=$basic_url.'online_chose_dark.png'?>" width="" height=""  class="ali_pay_new_radio"  /> <img class="ali_img" src="<?=$basic_url.'online_alipay.png'?>" alt="" ></label></div>
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
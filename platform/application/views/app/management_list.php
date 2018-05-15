<?php
	require 'top.php'
?>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-table/css/bootstrap-table.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'?>'/>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table-zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/moment-with-locales.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'?>'></script>
<div class="header oh">
	<div class="fl logo">
		<i></i>艾特智汇谷云平台
	</div>
	<div class="top_login_wrap fr">
		<span class="user"><i></i>180940320</span>
		|<a class="login_out" href="<?=base_url().'index.php/Login/logout'?>">退出登录</a>
	</div>
</div>	

<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->

	<div class="col-md-10 col-xm-9">
		<div class="searc_bar search_wrap" id="search_wrap">
			<span class="col_37A fl">筛选条件</span>
			<input type="text" class="begin_date date col_37A fl" name="begin_date"> 
			

			<form class="search_room" action="" method="get">
				<p>
					<input type="text" class="searc_room_text" name="keyword" placeholder="可输入姓名、职位名称" value="">
					<a id="clear" href="">X</a>
				</p>
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>

		</div>
		
		<div class="table_wrap">
			<div class="oh pt10">
				<span class="fr add_btn add_relation_btn" data-target="#add_relation" data-toggle="modal">新增物业人员关系</span>
				<span class="fr add_btn add_person_btn " data-target="#add_person" data-toggle="modal">新增人员</span>
			</div>
			
			<table id="table"
					data-toolbar="#toolbar"	
			>
			<thead>
				<tr>
					<th data-title="数据id" data-align="center" data-field="id" data-hidden=true></th>
					<th data-title="住户code" data-align="center" data-field="person_code" data-hidden=true></th>
					<th data-title="住户姓" data-align="center" data-field="lats_name" data-hidden=true></th>
					<th data-title="住户名" data-align="center" data-field="first_name" data-hidden=true></th>
					<th data-title="性别" data-align="center" data-field="gender" data-hidden=true></th>
					<th data-title="出生日期" data-align="center" data-field="birth_date" data-hidden=true></th>
					<th data-title="住户国籍" data-align="center" data-field="nationality" data-hidden=true></th>
					<th data-title="住户血型" data-align="center" data-field="blood_type" data-hidden=true></th>
					<th data-title="住户血型名称" data-align="center" data-field="blood_type_name" data-hidden=true></th>
					<th data-title="住户备注" data-align="center" data-field="remark" data-hidden=true></th>
					<th data-title="是否残疾" data-align="center" data-field="if_disabled" data-hidden=true></th>
					<th data-title="是否残疾名称" data-align="center" data-field="if_disabled_name" data-hidden=true></th>
					<th data-title="身份证件类型" data-align="center" data-field="id_type" data-hidden=true></th>
					<th data-title="身份证件类型名称" data-align="center" data-field="id_type_name" data-hidden=true></th>
					<th data-title="结束日期" data-align="center" data-field="end_date" data-hidden=true></th>
					<th data-title="住户类型号码" data-align="center" data-field="household_type" data-hidden=true></th>
					
					<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
					<th data-field="" data-title="职位" data-align="center"></th>
					<th data-field="" data-title="职能" data-align="center"></th>
					<th data-field="" data-title="职位等级" data-align="center"></th>
					<th data-field="" data-title="上一级职位" data-align="center"></th>

					<th data-field="full_name" data-title="姓名" data-align="center"></th>
					<th data-field="person_code" data-title="员工编号" data-align="center"></th>
					<th data-field="" data-title="入职日期" data-align="center"></th>
					<th data-field="" data-title="管理区域" data-align="center"></th>

					<th data-field="gender_name" data-title="性别" data-align="center"></th>
					<th data-field="age" data-title="年龄" data-align="center"></th>
					<th data-field="mobile_number" data-title="手机号码" data-align="center"></th>
					<th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>

		</div>
		
		<!--分页-->
		<ul class="pager" page='<? $page ?>'>
		    <?php
		       $first=base_url().'index.php/People/managementlist?page=1&keyword='.$keyword;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/People/managementlist?page='.($page-1).'&keyword='.$keyword; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/People/managementlist?page='.($page+1).'&keyword='.$keyword;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/People/managementlist?page='.$total.'&keyword='.$keyword;
		    echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
		    echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
		    echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
		    ?>
		</ul>

	</div>
</div>



<!--添加人员-->
<div class="modal fade" id="add_person" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 890px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">新增人员信息</h4>
	            </div>
	            <div class="modal-body building">
					<div class="fl person_wrap">
						<p>人员编号：
							<span class="code" style="margin-left:58px;">100011</span>
						</p>
						<p><span class="red_star">*</span>姓：
						<input type="text" class="model_input last_name" placeholder="请输入姓" name="last_name">
						<p><span class="red_star">*</span>名：
						<input type="text" class="model_input first_name" placeholder="请输入名" name="first_name">
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>证件类型：
								<input type="text" class="model_input id_type ka_input3" placeholder="请选择证件类型" name="id_type" data-ajax="" readonly="">
							</div>
							<div class="ka_drop" style="display: none;">
								<div class="ka_drop_list">
								<ul>
									<li><a href="javascript:;" data-ajax="101">身份证</a></li>
				                    <li><a href="javascript:;" data-ajax="102">境外护照</a></li>
				                    <li><a href="javascript:;" data-ajax="103">回乡证</a></li>
				                    <li><a href="javascript:;" data-ajax="104">台胞证</a></li>
				                    <li><a href="javascript:;" data-ajax="105">军官证/士兵证</a></li>
								</ul>
								</div>
							</div>
						</div>
						<p><span class="red_star">*</span>证件号码：
						<input type="text" class="model_input id_number" placeholder="请输入证件号码" name="id_number">
						</p>
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>国籍或地区：
								<input type="text" class="model_input nationality ka_input3" placeholder="请选择国籍或地区" name="nationality" data-ajax="" readonly="">
							</div>
							<div class="ka_drop" style="display: none;">
							<div class="ka_drop_list">
							 <ul>
							   <li><a href="javascript:;" data-ajax="101">中国</a></li>
							   <li><a href="javascript:;" data-ajax="102">香港</a></li>
							   <li><a href="javascript:;" data-ajax="103">澳门</a></li>
							   <li><a href="javascript:;" data-ajax="104">台湾</a></li>
							   <li><a href="javascript:;" data-ajax="105">新加坡</a></li>
							   <li><a href="javascript:;" data-ajax="106">美国</a></li>
							   <li><a href="javascript:;" data-ajax="107">日本</a></li>
							   <li><a href="javascript:;" data-ajax="108">韩国</a></li>
							 </ul>
							 </div>
							</div>
						</div>
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>性别：
								<input type="text" class="model_input gender ka_input3" placeholder="请选择性别" name="gender" data-ajax="" readonly="">
							</div>
							<div class="ka_drop" style="display: none;">
							<div class="ka_drop_list">
							 <ul>
							   <li><a href="javascript:;" data-ajax="101">男</a></li>
							   <li><a href="javascript:;" data-ajax="102">女</a></li>
							 </ul>
							 </div>
							</div>
						</div>
						<p>
							<span class="red_star">*</span>出生年月
							<input type="text" class="ka_input3 birth date" name="birth" />
						</p>	
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>是否残疾：
								<input type="text" class="model_input if_disabled ka_input3" name="if_disabled" data-ajax="false" value="否" readonly>
							</div>
							<div class="ka_drop"">
								<div class="ka_drop_list">
								<ul>
									<li><a href="javascript:;" data-ajax="false">否</a></li>
				                    <li><a href="javascript:;" data-ajax="true">是</a></li>
								</ul>
								</div>
							</div>
						</div>

					</div>
					<div class="fr person_wrap">
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>血型：
								<input type="text" class="model_input bloodtype ka_input3" placeholder="请选择血型" name="bloodtype" data-ajax="" readonly="">
							</div>
							<div class="ka_drop" style="display: none;">
								<div class="ka_drop_list">
								<ul>
									<li><a href="javascript:;" data-ajax="101">A型</a></li>
									<li><a href="javascript:;" data-ajax="102">B型</a></li>
									<li><a href="javascript:;" data-ajax="103">AB型</a></li>
									<li><a href="javascript:;" data-ajax="104">O型</a></li>
									<li><a href="javascript:;" data-ajax="105">其他</a></li>
								</ul>
								</div>
							</div>
						</div>
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>民族：
								<input type="text" class="model_input ethnicity ka_input3" placeholder="请选择民族" name="ethnicity" data-ajax="" readonly="">
							</div>
							<div class="ka_drop">
				                 <div class="ka_drop_list ">
					                  <ul>
					                  	<li><a href="javascript:;" data-ajax="101">汉族</a></li>
					                  	<li><a href="javascript:;" data-ajax="102">蒙古族</a></li>
					                  	<li><a href="javascript:;" data-ajax="103">回族</a></li>
					                  	<li><a href="javascript:;" data-ajax="104">藏族</a></li>
					                  	<li><a href="javascript:;" data-ajax="105">维吾尔族</a></li>
					                  	<li><a href="javascript:;" data-ajax="106">苗族</a></li>
					                  	<li><a href="javascript:;" data-ajax="107">彝族</a></li>
					                  	<li><a href="javascript:;" data-ajax="108">壮族</a></li>
					                  	<li><a href="javascript:;" data-ajax="109">布依族</a></li>
					                  	<li><a href="javascript:;" data-ajax="110">朝鲜族</a></li>
					                  	<li><a href="javascript:;" data-ajax="111">满族</a></li>
					                  	<li><a href="javascript:;" data-ajax="112">侗族</a></li>
					                  	<li><a href="javascript:;" data-ajax="113">瑶族</a></li>
					                  	<li><a href="javascript:;" data-ajax="114">白族</a></li>
					                  	<li><a href="javascript:;" data-ajax="115">土家族</a></li>
					                  	<li><a href="javascript:;" data-ajax="116">哈尼族</a></li>
					                  	<li><a href="javascript:;" data-ajax="117">哈萨克族</a></li>
					                  	<li><a href="javascript:;" data-ajax="118">傣族</a></li>
					                  	<li><a href="javascript:;" data-ajax="119">黎族</a></li>
					                  	<li><a href="javascript:;" data-ajax="120">僳僳族</a></li>
					                  	<li><a href="javascript:;" data-ajax="121">佤族</a></li>
					                  	<li><a href="javascript:;" data-ajax="122">畲族</a></li>
					                  	<li><a href="javascript:;" data-ajax="123">高山族</a></li>
					                  	<li><a href="javascript:;" data-ajax="124">拉祜族</a></li>
					                  	<li><a href="javascript:;" data-ajax="125">水族</a></li>
					                  	<li><a href="javascript:;" data-ajax="126">东乡族</a></li>
					                  	<li><a href="javascript:;" data-ajax="127">纳西族</a></li>
					                  	<li><a href="javascript:;" data-ajax="128">景颇族</a></li>
					                  	<li><a href="javascript:;" data-ajax="129">柯尔克孜族</a></li>
					                  	<li><a href="javascript:;" data-ajax="130">土族</a></li>
					                  	<li><a href="javascript:;" data-ajax="131">达斡尔族</a></li>
					                  	<li><a href="javascript:;" data-ajax="132">仫佬族</a></li>
					                  	<li><a href="javascript:;" data-ajax="133">羌族</a></li>
					                  	<li><a href="javascript:;" data-ajax="134">布朗族</a></li>
					                  	<li><a href="javascript:;" data-ajax="135">撒拉族</a></li>
					                  	<li><a href="javascript:;" data-ajax="136">毛南族</a></li>
					                  	<li><a href="javascript:;" data-ajax="137">仡佬族</a></li>
					                  	<li><a href="javascript:;" data-ajax="138">锡伯族</a></li>
					                  	<li><a href="javascript:;" data-ajax="139">阿昌族</a></li>
					                  	<li><a href="javascript:;" data-ajax="140">普米族</a></li>
					                  	<li><a href="javascript:;" data-ajax="141">塔吉克族</a></li>
					                  	<li><a href="javascript:;" data-ajax="142">怒族</a></li>
					                  	<li><a href="javascript:;" data-ajax="143">乌孜别克族</a></li>
					                  	<li><a href="javascript:;" data-ajax="144">俄罗斯族</a></li>
					                  	<li><a href="javascript:;" data-ajax="145">鄂温克族</a></li>
					                  	<li><a href="javascript:;" data-ajax="146">德昂族</a></li>
					                  	<li><a href="javascript:;" data-ajax="147">保安族</a></li>
					                  	<li><a href="javascript:;" data-ajax="148">裕固族</a></li>
					                  	<li><a href="javascript:;" data-ajax="149">京族</a></li>
					                  	<li><a href="javascript:;" data-ajax="150">塔塔尔族</a></li>
					                  	<li><a href="javascript:;" data-ajax="151">独龙族</a></li>
					                  	<li><a href="javascript:;" data-ajax="152">鄂伦春族</a></li>
					                  	<li><a href="javascript:;" data-ajax="153">赫哲族</a></li>
					                  	<li><a href="javascript:;" data-ajax="154">门巴族</a></li>
					                  	<li><a href="javascript:;" data-ajax="155">珞巴族</a></li>
					                  	<li><a href="javascript:;" data-ajax="156">基诺族</a></li>
					                  	<li><a href="javascript:;" data-ajax="160">其他</a></li>
					                  </ul>
				                  </div>
							</div>
						</div>

						<p>
							<span class="red_star">*</span>电话号码国别：
							<input type="text" class="ka_input3 tel_country" name="tel_country"  value="中国"  readonly/>
						</p>
						<p>
							<span class="red_star">*</span>手机号码：
							<input type="text" class="ka_input3 mobile_number" name="mobile_number" placeholder="请输入手机号码" />
						</p>
						<p style="padding-left: 22px;">
							其他电话号码：
							<input type="text" class="ka_input3 oth_mob_no" name="oth_mob_no" placeholder="请输入其他电话号码" maxlength="11" />
						</p>
						<p style="padding-left: 22px;">
							备注：
							<input type="text" class="ka_input3 remark" name="remark" placeholder="备注" />
						</p>
					</div>
					<div class="clear"></div>
	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_37A save_add">保存并添加物业人员关系</span>
                	<span class="col_37A save">保存物业人员信息</span>
                	<span class="col_FFA cancle"  data-dismiss="modal">取消</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!--新增物业人员关系-->
<div class="modal fade" id="add_relation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">新增物业人员关系</h4>
	            </div>
	            <div class="modal-body building">

				<div class="search_person_wrap">
					<div class="oh" style="margin-bottom:10px;">
						<div class="fl">
							<span class="red_star">*</span>人员编号：
						</div>
						<div class="fl search_person_text">
							<input type="text" class="fl search_person_name" placeholder="请输入姓名查找" >
							<a class="fr search_person_btn"><i class="fa fa-search"></i></a>
						</div>
					</div>
					<div class="search_person_results">
							<div class="single_person" data-last_name="张" data-first_name="某某" data-code="100007"><a class="fl add"><i class=" fa fa-trash-o fa-lg fa-plus-circle"></i></a><div class="fl"><span class="name">张某某</span><span class="id_number">454444</span></div><div class="select_pull_down query_wrap col_37A fl"><div><input type="text" class="model_input household_type ka_input3" placeholder="住户类别" name="household_type" data-ajax="" readonly=""></div><div class="ka_drop" style="display: none;"><div class="ka_drop_list"><ul><li><a href="javascript:;" data-ajax="101">户主</a></li><li><a href="javascript:;" data-ajax="102">家庭成员</a></li><li><a href="javascript:;" data-ajax="103">访客</a></li><li><a href="javascript:;" data-ajax="104">租客</a></li></ul></div></div></div></div>				
					</div>
					<div class="person_building_data">
						<ul>
							<!-- <li data-last_name="张" data_first_name="三" data-code="1004" data-household_type="101"><span>张三</span><span>421202199030474790</span></li> -->
						</ul>
					</div>
				</div>
				
				<p><span class="red_star">*</span>入职日期：
					<input type="text" class="hire_date date" name="hire_date">
				</p>

				

				<div class="select_pull_down select_wrap select_room">
					<div>
						<span class="red_star">*</span>职位：
						<input type="text" class="model_input position_code ka_input3" placeholder="请选择职位" name="position_code" data-ajax="" readonly="">
					</div>
					<div class="ka_drop">
						<div class="ka_drop_list">
						<ul>
							
						</ul>
						</div>
					</div>
				</div>


				
				<p><span class="red_star">*</span>开始日期：
					<input type="text" class="begin_date date" name="begin_date">
				</p>

				<p><span class="red_star">*</span>结束日期：
					<input type="text" class="end_date date" name="end_date">
				</p>

				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;员工编号：
					<input type="text" class="employee_no" name="employee_no">
				</p>

				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;备注：<input type="text" class="model_input remark" placeholder="请输入备注内容" name="remark"></p>

	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_37A save">保存</span>
                	<span class="col_FFA cancle"  data-dismiss="modal">取消</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!--人员详情-->
<div class="modal fade" id="person_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">住户详情</h4>
	            </div>
	            <div class="modal-body building oh">
					<div class="fl person_wrap person_detail">
						<p><i class="icon_circle"></i>人员基本信息</p>
						<p><span class="des">姓名：</span>
							<span class="full_name col_37A"></span>
						</p>
						<p><span class="des">证件类型：</span>
							<span class="id_type_name col_37A"></span>
						</p>
						<p><span class="des">证件号码：</span>
							<span class="des id_number col_37A"></span>
						</p>
						<p><span class="des">国籍：</span>
							<span class="nationality col_37A"></span>
						</p>
						<p><span class="des">性别：</span>
							<span class="gender_name col_37A"></span>
						</p>
						<p><span class="des">出生年月：</span>
							<span class="birth_date col_37A"></span>
						</p>
						<p><span class="des">血型：</span>
							<span class="blood_type_name col_37A"></span>
						</p>
						<p><span class="des">民族：</span>
							<span class="ethnicity_name col_37A"></span>
						</p>
						<p><span class="des">是否残疾：</span>
							<span class="if_disabled_name col_37A"></span>
						</p>
						<p><span class="des">电话号码国别：</span>
							<span class="col_37A">中国</span>
						</p>
						<p><span class="des">手机号码：</span>
							<span class="mobile_number col_37A"></span>
						</p>
						<p><span class="des">其它电话号码：</span>
							<span class="oth_mob_no col_37A"></span>
						</p>
						<p><span class="des">备注：</span>
							<span class="remark col_37A">无</span>
						</p>
					</div>
					<div class="fr person_wrap person_detail">
						<p><i class="icon_circle"></i>住户关系</p>
						<p><span class="des">房号：</span>
							<span class="building_code col_37A"></span>
						</p>
						<p><span class="des">开始日期：</span>
							<span class="begin_date col_37A"></span>
						</p>
						<p><span class="des">结束日期：</span>
							<span class="end_date col_37A"></span>
						</p>
						<p><span class="des">住户类型：</span>
							<span class="household_type_name col_37A"></span>
						</p>
						<p style="margin-top: 20px;"><i class="icon_circle"></i>同房间其他住户</p>
						<p style="padding-left: 20px;">
							<span class="other_person"></span>
						</p>
						<p style="margin-top: 20px;"><i class="icon_circle"></i>该住户在本小区其他房间</p>
						<p style="padding-left: 20px;">
							<span class="other_building"></span>
						</p>
					</div>

	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_37A cancle"  data-dismiss="modal">关闭</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!--编辑人员-->
<div class="modal fade" id="write_person" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 890px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">编辑人员信息</h4>
	            </div>
	            <div class="modal-body building">
					<div class="fl person_wrap">
						<p>人员编号：
							<span class="code" style="margin-left:58px;">100011</span>
						</p>
						<p><span class="red_star">*</span>姓：
						<input type="text" class="model_input last_name" placeholder="请输入姓" name="last_name">
						<p><span class="red_star">*</span>名：
						<input type="text" class="model_input first_name" placeholder="请输入名" name="first_name">
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>证件类型：
								<input type="text" class="model_input id_type ka_input3" placeholder="请选择证件类型" name="id_type" data-ajax="" readonly="">
							</div>
							<div class="ka_drop">
								<div class="ka_drop_list">
								<ul>
									<li><a href="javascript:;" data-ajax="101">身份证</a></li>
				                    <li><a href="javascript:;" data-ajax="102">境外护照</a></li>
				                    <li><a href="javascript:;" data-ajax="103">回乡证</a></li>
				                    <li><a href="javascript:;" data-ajax="104">台胞证</a></li>
				                    <li><a href="javascript:;" data-ajax="105">军官证/士兵证</a></li>
								</ul>
								</div>
							</div>
						</div>
						<p><span class="red_star">*</span>证件号码：
						<input type="text" class="model_input id_number" placeholder="请输入证件号码" name="id_number">
						</p>
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>国籍或地区：
								<input type="text" class="model_input nationality ka_input3" placeholder="请选择国籍或地区" name="nationality" data-ajax="" readonly="">
							</div>
							<div class="ka_drop">
							<div class="ka_drop_list">
							 <ul>
							   <li><a href="javascript:;" data-ajax="101">中国</a></li>
							   <li><a href="javascript:;" data-ajax="102">香港</a></li>
							   <li><a href="javascript:;" data-ajax="103">澳门</a></li>
							   <li><a href="javascript:;" data-ajax="104">台湾</a></li>
							   <li><a href="javascript:;" data-ajax="105">新加坡</a></li>
							   <li><a href="javascript:;" data-ajax="106">美国</a></li>
							   <li><a href="javascript:;" data-ajax="107">日本</a></li>
							   <li><a href="javascript:;" data-ajax="108">韩国</a></li>
							 </ul>
							 </div>
							</div>
						</div>
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>性别：
								<input type="text" class="model_input gender ka_input3" placeholder="请选择性别" name="gender" data-ajax="" readonly="">
							</div>
							<div class="ka_drop" style="display: none;">
							<div class="ka_drop_list">
							 <ul>
							   <li><a href="javascript:;" data-ajax="101">男</a></li>
							   <li><a href="javascript:;" data-ajax="102">女</a></li>
							 </ul>
							 </div>
							</div>
						</div>
						<p>
							<span class="red_star">*</span>出生年月
							<input type="text" class="ka_input3 birth_date date" name="birth_date" />
						</p>	
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>是否残疾：
								<input type="text" class="model_input if_disabled ka_input3" name="if_disabled" data-ajax="false" value="否" readonly>
							</div>
							<div class="ka_drop">
								<div class="ka_drop_list">
								<ul>
									<li><a href="javascript:;" data-ajax="false">否</a></li>
				                    <li><a href="javascript:;" data-ajax="true">是</a></li>
								</ul>
								</div>
							</div>
						</div>

					</div>
					<div class="fr person_wrap">
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>血型：
								<input type="text" class="model_input blood_type ka_input3" placeholder="请选择血型" name="blood_type" data-ajax="" readonly="">
							</div>
							<div class="ka_drop" style="display: none;">
								<div class="ka_drop_list">
								<ul>
									<li><a href="javascript:;" data-ajax="101">A型</a></li>
									<li><a href="javascript:;" data-ajax="102">B型</a></li>
									<li><a href="javascript:;" data-ajax="103">AB型</a></li>
									<li><a href="javascript:;" data-ajax="104">O型</a></li>
									<li><a href="javascript:;" data-ajax="105">其他</a></li>
								</ul>
								</div>
							</div>
						</div>
						<div class="select_wrap select_pull_down">
							<div>
								<span class="red_star">*</span>民族：
								<input type="text" class="model_input ethnicity ka_input3" placeholder="请选择民族" name="ethnicity" data-ajax="" readonly="">
							</div>
							<div class="ka_drop">
				                 <div class="ka_drop_list ">
					                  <ul>
					                  	<li><a href="javascript:;" data-ajax="101">汉族</a></li>
					                  	<li><a href="javascript:;" data-ajax="102">蒙古族</a></li>
					                  	<li><a href="javascript:;" data-ajax="103">回族</a></li>
					                  	<li><a href="javascript:;" data-ajax="104">藏族</a></li>
					                  	<li><a href="javascript:;" data-ajax="105">维吾尔族</a></li>
					                  	<li><a href="javascript:;" data-ajax="106">苗族</a></li>
					                  	<li><a href="javascript:;" data-ajax="107">彝族</a></li>
					                  	<li><a href="javascript:;" data-ajax="108">壮族</a></li>
					                  	<li><a href="javascript:;" data-ajax="109">布依族</a></li>
					                  	<li><a href="javascript:;" data-ajax="110">朝鲜族</a></li>
					                  	<li><a href="javascript:;" data-ajax="111">满族</a></li>
					                  	<li><a href="javascript:;" data-ajax="112">侗族</a></li>
					                  	<li><a href="javascript:;" data-ajax="113">瑶族</a></li>
					                  	<li><a href="javascript:;" data-ajax="114">白族</a></li>
					                  	<li><a href="javascript:;" data-ajax="115">土家族</a></li>
					                  	<li><a href="javascript:;" data-ajax="116">哈尼族</a></li>
					                  	<li><a href="javascript:;" data-ajax="117">哈萨克族</a></li>
					                  	<li><a href="javascript:;" data-ajax="118">傣族</a></li>
					                  	<li><a href="javascript:;" data-ajax="119">黎族</a></li>
					                  	<li><a href="javascript:;" data-ajax="120">僳僳族</a></li>
					                  	<li><a href="javascript:;" data-ajax="121">佤族</a></li>
					                  	<li><a href="javascript:;" data-ajax="122">畲族</a></li>
					                  	<li><a href="javascript:;" data-ajax="123">高山族</a></li>
					                  	<li><a href="javascript:;" data-ajax="124">拉祜族</a></li>
					                  	<li><a href="javascript:;" data-ajax="125">水族</a></li>
					                  	<li><a href="javascript:;" data-ajax="126">东乡族</a></li>
					                  	<li><a href="javascript:;" data-ajax="127">纳西族</a></li>
					                  	<li><a href="javascript:;" data-ajax="128">景颇族</a></li>
					                  	<li><a href="javascript:;" data-ajax="129">柯尔克孜族</a></li>
					                  	<li><a href="javascript:;" data-ajax="130">土族</a></li>
					                  	<li><a href="javascript:;" data-ajax="131">达斡尔族</a></li>
					                  	<li><a href="javascript:;" data-ajax="132">仫佬族</a></li>
					                  	<li><a href="javascript:;" data-ajax="133">羌族</a></li>
					                  	<li><a href="javascript:;" data-ajax="134">布朗族</a></li>
					                  	<li><a href="javascript:;" data-ajax="135">撒拉族</a></li>
					                  	<li><a href="javascript:;" data-ajax="136">毛南族</a></li>
					                  	<li><a href="javascript:;" data-ajax="137">仡佬族</a></li>
					                  	<li><a href="javascript:;" data-ajax="138">锡伯族</a></li>
					                  	<li><a href="javascript:;" data-ajax="139">阿昌族</a></li>
					                  	<li><a href="javascript:;" data-ajax="140">普米族</a></li>
					                  	<li><a href="javascript:;" data-ajax="141">塔吉克族</a></li>
					                  	<li><a href="javascript:;" data-ajax="142">怒族</a></li>
					                  	<li><a href="javascript:;" data-ajax="143">乌孜别克族</a></li>
					                  	<li><a href="javascript:;" data-ajax="144">俄罗斯族</a></li>
					                  	<li><a href="javascript:;" data-ajax="145">鄂温克族</a></li>
					                  	<li><a href="javascript:;" data-ajax="146">德昂族</a></li>
					                  	<li><a href="javascript:;" data-ajax="147">保安族</a></li>
					                  	<li><a href="javascript:;" data-ajax="148">裕固族</a></li>
					                  	<li><a href="javascript:;" data-ajax="149">京族</a></li>
					                  	<li><a href="javascript:;" data-ajax="150">塔塔尔族</a></li>
					                  	<li><a href="javascript:;" data-ajax="151">独龙族</a></li>
					                  	<li><a href="javascript:;" data-ajax="152">鄂伦春族</a></li>
					                  	<li><a href="javascript:;" data-ajax="153">赫哲族</a></li>
					                  	<li><a href="javascript:;" data-ajax="154">门巴族</a></li>
					                  	<li><a href="javascript:;" data-ajax="155">珞巴族</a></li>
					                  	<li><a href="javascript:;" data-ajax="156">基诺族</a></li>
					                  	<li><a href="javascript:;" data-ajax="160">其他</a></li>
					                  </ul>
				                  </div>
							</div>
						</div>

						<p>
							<span class="red_star">*</span>电话号码国别：
							<input type="text" class="ka_input3 tel_country" name="tel_country"  value="中国"  readonly/>
						</p>
						<p>
							<span class="red_star">*</span>手机号码：
							<input type="text" class="ka_input3 mobile_number" name="mobile_number" placeholder="请输入手机号码" />
						</p>
						<p style="padding-left: 22px;">
							其他电话号码：
							<input type="text" class="ka_input3 oth_mob_no" name="oth_mob_no" placeholder="请输入其他电话号码" maxlength="11" />
						</p>
						<p style="padding-left: 22px;">
							备注：
							<input type="text" class="ka_input3 remark" name="remark" placeholder="备注" />
						</p>
					</div>
					<div class="clear"></div>
	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_37A save">保存住户</span>
                	<span class="col_FFA cancle"  data-dismiss="modal">取消</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!--编辑物业人员关系-->
<div class="modal fade" id="relation_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">编辑住户关系</h4>
	            </div>
	            <div class="modal-body building oh">
		            <p><span class="des">房号：</span>
		            	<span class="building_code col_37A"></span>
		            </p>
					<p><span class="des">姓名：</span>
						<span class="full_name col_37A"></span>
					</p>
					<p><span class="des">开始日期：</span>
						<span class="begin_date col_37A"></span>
					</p>
					<p><span class="red_star">*</span>
						<span class="des">结束日期：</span>
						<input type="text" class="end_date date" name="end_date">
					</p>
					<p><span class="des">人员编号：</span>
						<span class="person_code col_37A"></span>
					</p>
					<p><span class="des">身份证号：</span>
						<span class="id_number col_37A"></span>
					</p>
					<p><span class="des">住户类型：</span>
						<span class="household_type_name col_37A"></span>
					</p>
					<p><span class="des">备注：</span>
						<span class="remark col_37A"></span>
					</p>
	            </div>
        	</div>
            <div class="modal_footer bg_eee">
            	<p class="tac pb17">
                	<span class="col_37A save">保存</span>
                	<span class="col_C45 cancle" data-dismiss="modal">取消</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>


<input type="hidden" value='<?php echo $page;?>' name="page" />
<input type="hidden" value='<?php echo $keyword;?>' name="keywords" />
<input type="hidden" value='<?php echo $pagesize;?>' name="pagesize" />

<script type="text/javascript">
$(function(){
	$('#add_relation').modal('show');
})
</script>
<script>
$(function(){
	var page = $('input[name="page"]').val();
	var keyword = $('input[name="keywords"]').val();
	$('#table').bootstrapTable({
		method: "get",
		undefinedText:'/',
		url:getRootPath()+'/index.php/People/getPeopleList?page=',
		dataType:'json',
		// pagination:true,
		// pageSize: 15, 
		// pageNumber: 1,
		// sortName: 'id',
		// sortOrder: 'desc',
		responseHandler:function(res){
			//用于处理后端返回数据
			console.log(res);
			return res;
		},
		onLoadSuccess: function(data){  //加载成功时执行
		    console.log(data);
		},
		onLoadError: function(){  //加载失败时执行
		    console.info("加载数据失败");
		}
	})
	$('#table').bootstrapTable('hideColumn', 'id');
	$('#table').bootstrapTable('hideColumn', 'person_code');
	$('#table').bootstrapTable('hideColumn', 'lats_name');
	$('#table').bootstrapTable('hideColumn', 'first_name');
	$('#table').bootstrapTable('hideColumn', 'gender');
	$('#table').bootstrapTable('hideColumn', 'birth_date');
	$('#table').bootstrapTable('hideColumn', 'nationality');
	$('#table').bootstrapTable('hideColumn', 'blood_type');
	$('#table').bootstrapTable('hideColumn', 'blood_type_name');
	$('#table').bootstrapTable('hideColumn', 'if_disabled');
	$('#table').bootstrapTable('hideColumn', 'if_disabled_name');
	$('#table').bootstrapTable('hideColumn', 'remark');
	$('#table').bootstrapTable('hideColumn', 'id_type');
	$('#table').bootstrapTable('hideColumn', 'id_type_name');
	$('#table').bootstrapTable('hideColumn', 'end_date');
	$('#table').bootstrapTable('hideColumn', 'household_type');
	//点击分页go,判断页面跳转
	$('.fenye_btn').click(function(){
		var page = $('input[name="fenye_input"]').val();
		if(!/^[0-9]*$/.test(page)){
		    openLayer('请输入数字');
		    $('input[name="fenye_input"]').val('');
		    return;
		}
		var pagenumber=Number(page)+"";
		var myCurrent = $('#current').text().split('/')[0];
		var myTotal = $('#current').text().split('/')[1];
		if(page!=pagenumber)
		{
		    $('input[name="fenye_input"]').val(pagenumber);
		    page=pagenumber;
		}
		if(Number(page)>Number(myTotal))
		{
		    $('input[name="fenye_input"]').val(myTotal);
		    page=myTotal;
		}
		if(Number(page)<1)
		{
			openLayer('请输入合法页数');
			$('input[name="fenye_input"]').val('');
			return;
		}
		
		var keyword=getUrlParam('keyword');
		window.location.href="managementlist?keyword="+keyword+"&page="+page;
	})
})
</script>	
<script src='<?=base_url().'application/views/plugin/app/js/management_list.js'?>'></script>
</body>
</html>
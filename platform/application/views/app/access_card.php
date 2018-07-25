<?php
	require 'top.php'
?>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-table/css/bootstrap-table.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/jstree/dist/themes/default/style.min.css'?>'/>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table-zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/jstree/dist/jstree.min.js'?>'></script>
<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->
	<div class="col-sm-12 main_wrap">
		<div class="searc_bar search_wrap" id="search_wrap">
			<span class="col_37A fl">筛选条件</span>
			<input type="text" class="effective_date date col_37A fl form-control" name="effective_date"> 
			
			<a href="javascript:;" id="treeNav" class="treeWrap" style="margin-left: 10px;"><span></span></a>

			<div class="person_type_wrap select_pull_down query_wrap col_37A fl">
				<div>
					<input type="text" class="model_input person_type ka_input3" placeholder="用户类型" name="person_type" data-ajax="" readonly>
				</div>
				<div class="ka_drop">
					<div class="ka_drop_list">
					<ul>
						<li><a href="javascript:;" data-ajax="101">业主</a></li>
						<li><a href="javascript:;" data-ajax="102">商户</a></li>
						<li><a href="javascript:;" data-ajax="103">物业人员</a></li>
					</ul>
					</div>
				</div>
			</div>
			
			<div class="search_room msg_search_room">
				<p>
					<input type="text" class="searc_room_text" name="keyword" placeholder="可输入授权用户、一卡通卡号" value="">
					<a id="clear" href="javascript:;">X</a>
				</p>
				<button type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>
		
		<div class="table_wrap">
			<div class="oh pt10">
				<span class="fr add_btn" data-target="#add_content" data-toggle="modal">新增一卡通授权</span>
				<a class="fr add_btn" href="<?=base_url().'index.php/Permission/accesscard'?>">清除筛选</a>
			</div>
			
			<table id="table"
					data-toolbar="#toolbar"	
			>
			<thead>
				<tr>
					<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
					<th data-field="code" data-title="一卡通授权编号" data-align="center"></th>
					<th data-field="card_no" data-title="一卡通卡号" data-align="center"></th>
					<th data-field="full_name" data-title="授权用户" data-align="center"></th>
					<th data-field="person_type_name" data-title="用户类型" data-align="center"></th>
					<th data-field="building_name" data-title="授权地址" data-align="center" data-formatter="viewMore"></th>
					<th data-field="begin_date" data-title="开始日期" data-align="center"></th>
					<th data-field="end_date" data-title="结束日期" data-align="center"></th>
					<th  data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>

		</div>

		<!--分页-->
		<ul class="pager" page='<? $page ?>'>
		    <?php
		       $first=base_url().'index.php/Permission/accesscard?page=1&keyword='.$keyword.'&effective_date='.$effective_date.'&person_type='.$person_type.'&building_code='.$building_code;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/Permission/accesscard?page='.($page-1).'&keyword='.$keyword.'&effective_date='.$effective_date.'&person_type='.$person_type.'&building_code='.$building_code; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/Permission/accesscard?page='.($page+1).'&keyword='.$keyword.'&effective_date='.$effective_date.'&person_type='.$person_type.'&building_code='.$building_code;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/Permission/accesscard?page='.$total.'&keyword='.$keyword.'&effective_date='.$effective_date.'&person_type='.$person_type.'&building_code='.$building_code;
		    echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
		    echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
		    echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
		    ?>
		</ul>

	</div>

</div>

<!--新增-->
<div class="modal fade" id="add_content" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">新增一卡通授权信息</h4>
	            </div>
	            <div class="modal-body building search_person_only">
					<p>一卡通授权编号：
						<span class="code" style="margin-left:18px;"></span>
					</p>

					<div class="select_pull_down select_wrap select_com">
						<div>
							设置串口：
							<input type="text" class="model_input com ka_input3" placeholder="请选择串口" name="com" value="COM1" data-ajax="" readonly="">
						</div>
						<div class="ka_drop">
							<div class="ka_drop_list">
								<ul>
									
								</ul>
							</div>
						</div>
					</div>

					<p><span class="red_star">*</span>一卡通卡号：
						<input type="text" class="model_input card_no" placeholder="请输入一卡通卡号" name="card_no">
					</p>
					
					<div class="search_person_wrap">
						<div class="oh" style="margin-bottom:10px;">
							<div class="fl">
								<span class="red_star">*</span>授权用户：
							</div>
							<div class="fr search_person_text">
								<input type="text" class="fl search_person_name" placeholder="请输入姓名查找">
								<a class="fr search_person_btn"><i class="fa fa-search"></i></a>
							</div>
						</div>
						<div class="search_person_results">
										
						</div>
						<div class="person_building_data">
							<ul>
							
							</ul>
						</div>
					</div>

					<div class="select_pull_down select_wrap select_person_type">
						<div>
							<span class="red_star">*</span>用户类型：
							<input type="text" class="model_input person_type ka_input3" placeholder="请选择用户类型" name="person_type" data-ajax="" readonly="">
						</div>
						<div class="ka_drop" style="display: none;">
							<div class="ka_drop_list">
								<ul>
									<!-- <li><a href="javascript:;" id="101" data-ajax="100001">物业总经理</a></li> -->
								</ul>
							</div>
						</div>
					</div>

					<div class="">
						<div class="fl">
							<span class="red_star">*</span>授权地址：
						</div>
						<div class="fl">
							<div class="query_building_wrap oh" style="margin-left: 20px;line-height: 30px;margin-top:5px;width: 440px;">
								<span class="des fl">查询出地址</span>
								<ul class="query_building fl" style="margin-left: 20px;max-height: 90px;overflow:auto;width: 360px;">
									<!-- <li>
										<input type="checkbox" id="10001" value="true" class="regular-checkbox">
										<label for="10001"></label>
										<span class="name">1期1区1栋301</span>
									</li>
									<li>
										<input type="checkbox" id="10002" value="true" class="regular-checkbox">
										<label for="10002"></label>
										<span class="name">1期1区1栋302</span>
									</li>
									<li>
										<input type="checkbox" id="10003" value="true" class="regular-checkbox">
										<label for="10003"></label>
										<span class="name">1期1区1栋302</span>
									</li> -->
								</ul>
							</div>
							<div class="select_buliding_wrap" style="margin-left: 20px;margin-top: 10px;">
								<span class="des fl" style="line-height: 42px;">新增地址</span>
								<a href="javascript:;" id="treeNavCard" class="treeWrap" style="margin-left: 30px;width: 120px;"><span></span></a>
								<span class="select_buliding" style="width: 210px;overflow: hidden;">
								</span>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				
					<p><span class="red_star">*</span>开始日期：
						<input type="text" class="begin_date date form-control" name="begin_date" placeholder="请选择开始日期" >
					</p>

					<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;结束日期：
						<input type="text" class="end_date date form-control" name="end_date" placeholder="请选择结束日期" >
					</p>
	            </div>
        	</div>
            <div class="modal_footer bg_eee" style="margin-top:110px;">
            	<p class="tac pb17">
                	<span class="col_37A save">保存</span>
                	<span class="col_FFA cancle" data-dismiss="modal">取消</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!--详细-->
<div class="modal fade" id="content_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">一卡通授权详情</h4>
	            </div>
	            <div class="modal-body building oh">
		            <p><span class="des">一卡通授权编号：</span>
		            	<span class="code col_37A"></span>
		            </p>
		            <p><span class="des">一卡通卡号：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		            	<span class="card_no col_37A"></span>
		            </p>
		            <p><span class="des">授权用户：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		            	<span class="full_name col_37A"></span>
		            </p>
		            <p><span class="des">用户类型：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		            	<span class="person_type_name col_37A"></span>
		            </p>
		            <p><span class="des">开始日期：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		            	<span class="begin_date col_37A"></span>
		            </p>
		            <p><span class="des">结束日期：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		            	<span class="end_date col_37A"></span>
		            </p>
		            <p><span class="des">授权地址：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		            	<span class="building_name col_37A"></span>
		            </p>
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

<!--修改-->
<div class="modal fade" id="content_write" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">编辑一卡通授权</h4>
	            </div>
                <div class="modal-body building">
	                <p><span class="des">授权编号：&nbsp;&nbsp;&nbsp;&nbsp;</span>
	                	<span class="code col_37A"></span>
	                </p>
	                <p><span class="des">一卡通卡号：</span>
	                	<span class="card_no col_37A"></span>
	                </p>
	                <p><span class="des">授权用户：&nbsp;&nbsp;&nbsp;&nbsp;</span>
	                	<span class="full_name col_37A"></span>
	                </p>
	                <p><span class="des">用户类型：&nbsp;&nbsp;&nbsp;&nbsp;</span>
	                	<span class="person_type_name col_37A"></span>
	                </p>
	                <p><span class="des">开始日期：&nbsp;&nbsp;&nbsp;&nbsp;</span>
	                	<span class="begin_date col_37A"></span>
	                </p>
	                <p>结束日期：&nbsp;&nbsp;&nbsp;&nbsp;
                		<input type="text" class="end_date date form-control" name="end_date" style="float: none;padding-left: 0px;" />
                	</p>
	                <p><span class="des">授权地址：&nbsp;&nbsp;&nbsp;&nbsp;</span>
	                	<span class="building_name col_37A"></span>
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
<object id="plugin0" type="application/x-juart" width="0" height="0" >
   <param name="onload" value="pluginLoaded"  />
</object>
<input type="hidden" value='<?php echo $page;?>' name="page" />
<input type="hidden" value='<?php echo $treeNav_data;?>'  id="treeNav_data" />
<input type="hidden" value='<?php echo $keyword;?>' name="keywords" />
<input type="hidden" value='<?php echo $pagesize;?>' name="pagesize" />
<script>
// $('#content_write').modal('show');
</script>
<script>
$(function(){
	var treeNav_data = <?php echo $treeNav_data?>;
	//树形菜单
	$('#treeNavCard>span,#treeNav>span').jstree({
		'core' : {
	        data: treeNav_data
	    }
	})
	var now = getDate();
	var page = getUrlParam('page');
	var search_keyword = getUrlParam('keyword');
	var search_effective_date = getUrlParam('effective_date');
	var search_person_type = getUrlParam('person_type');
	var search_building_code = getUrlParam('building_code');

	search_effective_date = search_effective_date?search_effective_date:now;
	//根据搜索内容给搜索框和筛选条件赋值
	$('.effective_date').val(search_effective_date);
	$('.search_room .searc_room_text').val(search_keyword);
	//赋值用户类型
	switch(search_person_type){
		case '101':
			$('.search_wrap .person_type').val('业主');
			break;
		case '102':
			$('.search_wrap .person_type').val('商户');
			break;
		case '103':
			$('.search_wrap .person_type').val('物业人员');
			break;
		default:
			$('.search_wrap .person_type').val('用户类型');
			break;
	}

	$('#table').bootstrapTable({
		method: "get",
		undefinedText:' ',
		url:getRootPath()+'/index.php/Permission/getAccessCardList?page='+page+'&keyword='+search_keyword+'&effective_date='+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code,
		dataType:'json',
		responseHandler:function(res){
			//用于处理后端返回数据
			return res;
		},
		onLoadSuccess: function(data){  //加载成功时执行
		},
		onLoadError: function(){  //加载失败时执行
		    console.info("加载数据失败");
		}
	})
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
		window.location.href="accesscard?keyword="+search_keyword+"&page="+page+"&effective_date="+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code;
	})
	//日期筛选
	$('.search_wrap .effective_date').datetimepicker().on('changeDate', function(ev){
        var date = $('.effective_date').val();
        window.location.href="accesscard?keyword="+search_keyword+"&page=1"+"&effective_date="+date+'&person_type='+search_person_type+'&building_code='+search_building_code;
    })
	//用户类型筛选
	$('.person_type_wrap .ka_drop_list li').click(function(){
		var person_type = $(this).find('a').data('ajax');
		window.location.href="accesscard?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&person_type='+person_type+'&building_code='+search_building_code;
	})
	//树形菜单点击筛选
	$('#treeNav>span').on("select_node.jstree", function (e, node) {
	  var building_code = node.node.original.code;
	  window.location.href="accesscard?keyword="+search_keyword+"&page=1"+"&effective_date="+search_effective_date+'&person_type='+search_person_type+'&building_code='+building_code;
	})
	//点击搜索按钮,跳转
	$('.search_room button[type="submit"]').click(function(){
		var keyword = $('.search_room .searc_room_text').val();
		keyword = trim(keyword);
		if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
			openLayer('搜索框只能输入数字、汉字、字母!');
			return;
		}
		window.location.href="accesscard?keyword="+keyword+"&page=1"+"&effective_date="+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code;
	})
	//清除条件
	$('.search_room #clear').click(function(){
		window.location.href="accesscard?page=1";
		window.location.href="accesscard?keyword=&page=1"+"&effective_date="+search_effective_date+'&person_type='+search_person_type+'&building_code='+search_building_code;
	})
})
</script>
<script>
//树节点点击后将节点赋值
$('#treeNavCard>span').on("select_node.jstree", function (e, node) {
  //选择节点后自动关闭菜单
  $(this).jstree('close_all');
  var arr=node.node.id.split("_");
  var parent_code=arr[0];
  //当前节点的id
  var id=arr[1];
  //当前节点的文本值
  var name = node.node.text;
  //当前节点的房号code
  var room_code = node.node.original.code;
  //当前对象为包裹层元素(这里是span)
  var that = $(this);
  console.log(node);
  //父节点数组
  var parents_arr = node.node.parents;
  var imm_name = "";
  //点击的时候,根据parents数组,找到节点的所有父节点
  if(parents_arr.length>=2){
  	//parents数组的最后一项为#
  		for(var i=parents_arr.length-3;i>=0;i--){
  			var imm_id = parents_arr[i];
  			var imm_node = that.jstree("get_node", imm_id);
  			imm_name += imm_node.text;
  		}
  }
  var html_tmp = "<em id="+room_code+" data-room_code="+room_code+">"+imm_name+name+"<i class='fa fa-close'></i></em>";
  //选择楼宇赋值时不能重复且不能超过10个
  if(that.closest('.model_content').find('.select_buliding em').length<10){
  	if(that.closest('.model_content').find('.select_buliding #'+room_code).length==0){
  		 that.closest('.model_content').find('.select_buliding').append(html_tmp);
  	}
  }
})

$(function(){
	//点击删除当前节点
	$('.select_buliding_wrap').on('click','.select_buliding em i',function(){
		$(this).closest('em').remove();
	})
})
</script>
<script type="text/javascript">
//读取串口数据开始
var ser;
var save=new Array();
var isPush=false;
function plugin0()
{
  return document.getElementById('plugin0');
}
plugin = plugin0;
    
function getCardNum(data)
{
	if(data instanceof Array)
	{
		if(data[0]==0x05&&data[data.length-1]==0x06)
		{
			var len1=String.fromCharCode(data[5]);
			var len2=String.fromCharCode(data[6]);
			var len=Number(len1+len2);
			var cardNum="";
			if(data.length==7+len*2+3)
			{
				for(var i=7;i<7+len*2;i++)
				{
					cardNum+=String.fromCharCode(data[i]);
				}
				$("#add_content .card_no").val(cardNum);
			}
		}
	}
}

function recv(bytes, size)
{
  for(var i=0;i<size;++i)
  {
	if(bytes[i]==0x05)
	{
		isPush=true;
	}
	else if(bytes[i]==0x06)
	{
		save.push(bytes[i]);
		getCardNum(save);
		save.splice(0,save.length);
		isPush=false;
	}
	if(isPush===true)
	{
		save.push(bytes[i]);
	}
	
  }
}
    
function pluginLoaded() 
{
	var comid=localStorage.getItem("accesscardcomid");
	//设置默认串口
	if(!comid){
		comid = "COM1";
	}
	ser = plugin().Serial;// Get a Serial object
	//ser.open("COM4");// Open a port
	if(comid==null||comid==undefined)
	{
		ser.open("COM1");// Open a port
	}
	else
	{
		$("#comid").val(comid);
		ser.open(comid);// Open a port
	}
	ser.set_option(9600,0,8,0,0);// Set port options 
	ser.recv_callback(recv); // Callback function for recieve data
}

function pluginValid()
{
  if(plugin().valid){
    alert(plugin().echo("This plugin seems to be working!"));
  } else {
    alert("Plugin is not working :(");
  }
}
//读取串口数据结束

</script>
<script>
$('#treeNavCard>span').on(" before_open.jstree", function (e, data) {
    $('.jstree-container-ul').css({
        "width":"300px"
    })
    $(this).css({
        "height": "340px",
        "width":"120px",
        "overflow": "auto"
    })
    $(this).closest('a').css({
        'width':'120px'
    })
})

$('#treeNavCard>span').on(" after_close.jstree", function (e, data) {
    if(data.node.parents.length==1){
        $(this).css({
            "width":"120px",
            "height": "100%",
        })
        $(this).closest('a').css({
            'width':'120px'
        })
        $('.jstree-container-ul').css({
            "width":"100%"
        })
    }
})
</script>
<script src='<?=base_url().'application/views/plugin/app/js/access_card.js'?>'></script>
</body>
</html>
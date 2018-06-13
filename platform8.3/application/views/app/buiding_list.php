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
<div class="header oh">
	<div class="fl logo">
		<i></i>艾特智能AI社区云平台
	</div>
	<div class="top_login_wrap fr">
		<span class="user"><i></i><?php echo $username ?></span>
		|<a class="login_out" href="<?=base_url().'index.php/Login/logout'?>">退出登录</a>
	</div>
</div>	

<div class="oh pt10">

<?php
	require 'menus.php'
?>

<!--<?php echo 'x'; ?>-->

	<div class=" col-sm-12 main_wrap">
		<div class="searc_bar search_wrap">
			<a href="<?=base_url().'index.php/Building/buildingtree'?>">树状图模式</a>
			<a class="active" href="<?=base_url().'index.php/Building/buildinglist'?>">列表模式</a>
			<a href="javascript:;" id="treeNav" class="treeWrap"><span></span></a>
			<div class="search_room">
				<p>
					<input type="text" class="searc_room_text" name="keyword" placeholder="可输入楼宇名称" value="<?php echo $keyword;?>" />
					<a id="clear" href="javascript:;">X</a>
				</p>
				<button type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>

		
		<div class="table_wrap">
			<div class="oh pt10">
				<span class="fr add_btn" data-target="#add_building" data-toggle="modal">新增</span>
				<a class="fr add_btn" href="<?=base_url().'index.php/Building/buildinglist'?>">重置</a>
			</div>
			<table id="table"
					data-toolbar="#toolbar"
			>
			<thead>
				<tr>
					<th data-title="序号" data-align="center" data-formatter="idFormatter"></th>
					<th data-field="code" data-title="楼宇编号" data-align="center"></th>
					<th data-field="effective_date" data-title="生效日期" data-align="center"></th>
					<th data-field="effective_status" data-title="状态" data-align="center"></th>
					<th data-field="name" data-title="楼宇名称" data-align="center"></th>
					<th data-field="level_name" data-title="楼宇层级" data-align="center"></th>
					<th data-field="rank" data-title="顺序号" data-align="center"></th>
					<th data-field="parent_code_name" data-title="上一级楼宇" data-align="center"></th>
					<th data-field="remark" data-title="备注" data-align="center"></th>
					<th data-title="信息管理" data-align="center" data-formatter="operateFormatter" data-events="operateEvents"></th>
				</tr>
			</thead>

			</table>	
		</div>
		
		<!--分页-->
		<ul class="pager" page='<? $page ?>'>
		    <?php
		       $first=base_url().'index.php/Building/buildinglist?page=1&keyword='.$keyword.'&id='.$id.'&parent_code='.$parent_code;	
		       echo  " <li><a href='".$first."' id='first'>首 页</a></li>";
		    if($page>1) {
					$url=base_url().'index.php/Building/buildinglist?page='.($page-1).'&keyword='.$keyword.'&id='.$id.'&parent_code='.$parent_code; 
		        echo "<li class=\"active\"><a href='".$url."' id='prev' >上一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\" ><a id='prev' href='javascript:void(0);'>上一页</a></li>";
		    }
		    echo "<li class=\"disabled\"><a href='javascript:void(0);' id='current'>".$page."/".$total."</a></li>";
		    if($page<$total) {
					$url=base_url().'index.php/Building/buildinglist?page='.($page+1).'&keyword='.$keyword.'&id='.$id.'&parent_code='.$parent_code;	
		        echo "<li class=\"active\"><a href='".$url."' id='next' >下一页</a></li>";
		    }else{
		        echo "<li class=\"disabled\"  ><a  id='next' href='javascript:void(0);'>下一页</a></li>";
		    }
		    $last=base_url().'index.php/Building/buildinglist?page='.$total.'&keyword='.$keyword.'&id='.$id.'&parent_code='.$parent_code;
		    echo  " <li><a href='".$last."' id='last'>尾 页</a></li>";
		    echo  " <li><input type='text' class='fenye_input' name='fenye_input'  /> </li>";
		    echo  "<li><a href='#'  class='fenye_btn'>GO</a></li>";
		    ?>
		</ul>

	</div>
</div>

<!-- 增加楼宇 -->
<div class="modal fade" id="add_building" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">新增楼宇信息</h4>
	            </div>
	            <div class="modal-body building add_building">
					<p>&nbsp;&nbsp;&nbsp;&nbsp;楼宇编号：
						<span class="code" style="margin-left:26px;"></span>
					</p>
					<p><span class="red_star">*</span>生效日期：
						<input type="text" class="effective_date date form-control" name="effective_date" />
					</p>
					<p class="effective_status"><span class="red_star">*</span>状态：
						<span style="margin-left:45px;">
							<input type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked="">
							<label for="radio-1-1"></label>有效
						</span>

						<span class="fr">
							<input type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio">
							<label for="radio-1-2"></label>无效
						</span>
					</p>
					<p><span class="red_star">*</span>楼宇名称：
						<input type="text" class="model_input name" placeholder="请输入楼宇名称"  name="name" />
					</p>
					<div class="select_wrap select_pull_down">
						<div>
							<span class="red_star">*</span>楼宇层级：
							<input type="text" class="model_input level ka_input3" placeholder="请选择楼宇层级"  name="level" data-ajax="" readonly />
						</div>
						<div class="ka_drop">
							<div class="ka_drop_list">
							<ul>
								<li><a href="javascript:;" data-ajax="100">小区</a></li>
								<li><a href="javascript:;" data-ajax="101">期</a></li>
								<li><a href="javascript:;" data-ajax="102">区</a></li>
								<li><a href="javascript:;" data-ajax="103">栋</a></li>
								<li><a href="javascript:;" data-ajax="104">单元</a></li>
								<li><a href="javascript:;" data-ajax="105">层</a></li>
								<li><a href="javascript:;" data-ajax="106">室</a></li>
								<li><a href="javascript:;" data-ajax="107">公共设施</a></li>
							</ul>
							</div>
						</div>
					</div>
					<div class="select_wrap select_pull_down select_parent_code">
						<div><span class="red_star">*</span>上级楼宇：
							<input type="text" class="model_input parent_code ka_input3" placeholder="请选择上级楼宇"  name="parent_code"  data-ajax="" readonly />
						</div>
						<div class="ka_drop">
							<div class="ka_drop_list buildings">
							<ul>
								
							</ul>
							</div>
						</div>
					</div>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;顺序号：<input type="text" class="model_input rank" placeholder="请输入顺序号" name="rank" /></p>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;备注：<input type="text" class="model_input remark" placeholder="请输入备注内容" name="remark" /></p>
	            </div>
        	</div>
            <div class="modal_footer bg_eee oh">
            	<p class="fr pt17">
                	<span class="col_37A fl confirm">保存</span>
                	<span class="col_C45 fl"  data-dismiss="modal">取消</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!--编辑楼宇-->
<div  class="modal fade"  id="write_building" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 630px;">
        <div class="modal-content model_wrap">
        	<div class="model_content">
	            <div class="building_header">
	                <h4 class="modal-title tac">编辑楼宇信息</h4>
	            </div>
	            <div class="modal-body building write_building">
					<p><span class="des" style="margin-left:20px;">楼宇编号：</span>
						<span class="code" style="margin-left:22px;"></span>
					</p>
					<p>
						<span class="des" style="margin-left:20px;">生效日期：</span>
						<span class="effective_date col_37A" style="margin-left:22px;"></span>
					</p>
					<p>
						<span class="des" style="margin-left:20px;">状&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态：</span>
						<span class="effective_status col_37A"  style="margin-left:22px;"></span>
					</p>
					<p><span class="red_star">*</span>楼宇名称：
						<input type="text" class="model_input name" placeholder="请输入楼宇名称"  name="name" />
					</p>
					<p>
						<span class="des" style="margin-left:20px;">楼宇层级：</span>
						<span class="level_name col_37A"  style="margin-left:22px;"></span>
					</p>
					<p>
						<span class="des" style="margin-left:20px;">上级楼宇：</span>
						<span class="parent_code_name col_37A"  style="margin-left:22px;"></span>
					</p>
					
					<p><span class="des" style="margin-left:20px;">顺&nbsp;&nbsp;序&nbsp;&nbsp;号：</span>
						<input type="text" class="model_input rank" placeholder="请输入顺序号" name="rank" /></p>
					<p>
					<span class="des" style="margin-left:20px;">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</span>
					<input type="text" class="model_input remark" placeholder="请输入备注内容" name="remark" /></p>
					<input type="hidden" name="data_id" />
	            </div>
        	</div>
            <div class="modal_footer bg_eee oh">
            	<p class="fr pt17">
                	<span class="col_37A fl confirm">保存</span>
                	<span class="col_C45 fl"  data-dismiss="modal">取消</span>
            	</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<input type="hidden" value='<?php echo $page;?>' name="page" />
<input type="hidden" value='<?php echo $keyword;?>' name="keyword" />
<input type="hidden" value='<?php echo $id;?>' name="id" />
<input type="hidden" value='<?php echo $parent_code;?>' name="parentcode" />
<input type="hidden" value='<?php echo $pagesize;?>' name="pagesize" />
<script>
$(function(){
	var page = getUrlParam('page');
	var keyword = getUrlParam('keyword');
	var id = getUrlParam('id');
	var parent_code = getUrlParam('parent_code');
	$('#table').bootstrapTable({
		method: "get",
		undefinedText:'/',
		url:getRootPath()+'/index.php/Building/getBuildingsList?page='+page+'&keyword='+keyword+'&id='+id+"&parent_code="+parent_code,
		dataType:'json',
		responseHandler:function(res){
			//用于处理后端返回数据
			// console.log(res);
			return res;
		},
		onLoadSuccess: function(data){  //加载成功时执行
		    // console.log(data);
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
		window.location.href="buildinglist?keyword="+keyword+"&page="+page+"&id="+id+"&parent_code="+parent_code;
	})
	//点击搜索按钮,跳转
    $('.search_room button[type="submit"]').click(function(){
    	var keyword = $('.search_room .searc_room_text').val();
    	keyword = trim(keyword);
    	if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
    		openLayer('搜索框只能输入数字、汉字、字母!');
    		return;
    	}
    	window.location.href="buildinglist?keyword="+keyword+"&page=1"+'&id='+id+"&parent_code="+parent_code;
    })
    //清除搜索条件
    $('.search_room #clear').click(function(){
    	window.location.href="buildinglist?page=1"+'&id='+id+"&parent_code="+parent_code;
    })
})

</script>
<script>
var treeNav_data = <?php echo $treeNav_data?>;
// console.log(treeNav_data);
//楼宇层级树形菜单
$('#treeNav>span').jstree({
	'core' : {
        data: treeNav_data
    }
})


//树节点点击后跳转到相应的楼宇列表页面
$('#treeNav>span').on("select_node.jstree", function (e, node) {
  var arr=node.node.id.split("_");
  var parent_code=arr[0];
  var id=arr[1];
  var keyword = getUrlParam('keyword');
  console.log(node.node);
  window.location.href="buildinglist?id="+id+"&parent_code="+parent_code+"&page=1"+"&keyword="+keyword;
})
/*$('#treeNav>span').jstree({
	'core' : {
        'data' : [
            { "text" : "和正·智汇谷", "children" : [
                { "text" : "3栋" ,"children" : [{'text':'201'},{'text':'202'}]},
                { "text" : "5栋" }
            ]
            },
        ]
    }
})*/
</script>	
<script src='<?=base_url().'application/views/plugin/app/js/buildinglist.js'?>'></script>	
</body>
</html>
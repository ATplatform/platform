<?php
	require 'top.php'
?>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-table/css/bootstrap-table.css'?>'/>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'?>'/>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table-zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/moment-with-locales.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/d3/d3.min.js'?>'></script>
<script src="//at.alicdn.com/t/font_693062_g03gik4c0dn7y14i.js"></script>
<style>
.node circle {
  cursor: pointer;
  fill: #fff;
  stroke: steelblue;
  stroke-width: 1.5px;
}
.node text {
  font-size: 16px;
}
.node text a {
    cursor: pointer;
    display: block;
    width: 100%;
    height: 100%;
}
path.link {
  fill: none;
  stroke: #ccc;
  stroke-width: 1.5px;
}
.icon {
    width: 1em; height: 1em;
    vertical-align: -0.15em;
    fill: currentColor;
    overflow: hidden;
}

</style>
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

	<div class="col-sm-12 main_wrap">
		<div class="oh">
			<div class="searc_bar search_wrap">
				<a class="active" href="<?=base_url().'index.php/Building/buildingtree'?>">树状图模式</a>
				<a href="<?=base_url().'index.php/Building/buildinglist'?>">列表模式</a>
				<div class="search_room">
					<p>
						<input type="text" class="searc_room_text" name="keyword" placeholder="可输入楼宇名称" value="" />
						<a id="clear" href="javascript:;">X</a>
					</p>
					<button type="submit"><i class="fa fa-search"></i></button>
				</div>
			</div>
		</div>
		<!--绘制树状图容器-->
		<div id="tree">
		  
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
                                <input type="text" class="effective_date date" name="effective_date" />
                            </p>
                            <p class="effective_status"><span class="red_star">*</span>状态：
                                <span style="margin-left:45px;">
							<input type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked="">
							<label for="radio-1-1"></label>
							有效
						</span>

                                <span class="fr">
							<input type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio">
							<label for="radio-1-2"></label>
							无效
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
                               <!-- <div class="ka_drop">
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
                                </div>-->
                            </div>
                            <div class="select_wrap select_pull_down select_parent_code">
                                <div><span class="red_star">*</span>上级楼宇：
                                    <input type="text" class="model_input parent_code ka_input3" placeholder="请选择上级楼宇"  name="parent_code"  data-ajax="" readonly />
                                </div>
                                <!--<div class="ka_drop">
                                    <div class="ka_drop_list buildings">
                                        <ul>

                                        </ul>
                                    </div>
                                </div>-->
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


    </div>
</div>
<script>
    //日期控件初始化
    var now = new Date();
    now = formatDate(now);
    $('.date').datetimepicker({
        language:  'zh-CN',
        format: 'yyyy-mm-dd',
        weekStart: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 1
    });
    $('.add_building').find('input[name="effective_date"]').val(now);

</script>





<script type="text/javascript">
var w = 1280,
    h = 800,
    i = 0,
    root;
// var data = getRootPath()+'/application/views/plugin/app/building.json';
var data = getRootPath()+'/index.php/Building/getBuildingTreeData';
console.log(data);

var tree = d3.layout.tree()
    .size([h, w]);

var diagonal = d3.svg.diagonal()
    .projection(function(d) { return [d.y, d.x]; });

var vis = d3.select("#tree").append("svg:svg")
    .attr("width", w )
    .attr("height", h)
    .append("svg:g")
    .attr("transform", "translate(" + 140 + "," + 10 + ")");

d3.json(data, function(json) {
  root = json;
  root.x0 = h / 2;
  root.y0 = 0;

  console.log(root);

  function toggleAll(d) {
    if (d.children) {
      d.children.forEach(toggleAll);
      toggle(d);
    }
  }

  // Initialize the display to show a few nodes.
  root.children.forEach(toggleAll);
  //默认打开第2个子节点
  // toggle(root.children[1]);
  update(root);
});

function update(source) {
  var duration = d3.event && d3.event.altKey ? 5000 : 500;

  // Compute the new tree layout.
  var nodes = tree.nodes(root).reverse();

  // Normalize for fixed-depth.
  nodes.forEach(function(d) { d.y = d.depth * 180; });

  // Update the nodes…
  var node = vis.selectAll("g.node")
      .data(nodes, function(d) { return d.real_id || (d.real_id = ++i); });

  // 生成g
  var nodeEnter = node.enter().append("svg:g")
      .attr("class", "node")
      .style("position", "relative")
      .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
      .on('mouseover', function(d) {
          $(this).children('.option1').show()
          $(this).children('.option2').show()
      })
      .on('mouseout', function (d) {$(this).children('.option1').hide(); $(this).children('.option2').hide()})


    nodeEnter.append("svg:rect")
        .attr("class", "wrap")
        .attr("x", -10)
        .attr("y", -20)
        .attr("width", 80)
        .attr("height", 33)
        .attr("r", 8.5)
        .style("position", "absolute")
        .style("z-index", -1)
        .style("fill", function(d) { return  "transparent"; })
        .style("border", function(d) { return  "#500000"; })


    //绘制空心圆
    nodeEnter.append("svg:circle")
        .attr("class", "main")
        .attr("r", 8.5)
        .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; })
        .on("click", function(d) { toggle(d); update(d); })



    // .on("hover", function(d) { toggle(d); update(d); });



    nodeEnter.append("svg")
        .attr("class", "option1 icon fa fa-pencil-square-o")
        .attr("width",17)
        .attr("height",17)
        .attr("x",8)
        .attr("y",-25)
        .attr("data-target","#add_building")
        .attr("data-toggle","modal")
        .style("position", "absolute")
        .style("z-index", 99)
        .style("display", "none")
     //   .style("fill", function(d) { return  "#E10803"; })
        //.on('mouseover', function (d) { $(this).show(); $(this).siblings('.option2').show()})
        .on('click', function(d) {
            console.log(d);
            addbuilding(d);
        })
        .append("svg:use")
        .attr("xlink:href",'#icon-new')
        . append("svg:title")
        . text(function(d) { return "新增"; })




    nodeEnter.append("svg")
        .attr("class", "option2")
        .attr("width",17)
        .attr("height",17)
        .attr("x",30)
        .attr("y",-25)
        //.attr("data-target","#add_building")
        // .attr("data-toggle","modal")
        .attr("data-events","operateEvents")
        .style("position", "absolute")
        .style("z-index", 99)
        .style("display", "none")
       // .style("fill", function(d) { return  "#E10803"; })
       // .on('mouseover', function (d) { $(this).siblings('.option1').show(); $(this).show()})
        .on('click', function(d) {
            updatebuilding(d);
        })
        .append("svg:use")
        .attr("xlink:href",'#icon-bianji')
        . append("svg:title")
        . text(function(d) { return "修正"; })

    //绘制文字
    nodeEnter.append("svg:text")
        .attr("class", "text")
        .attr("x", function(d) { return d.children || d._children ? -18 : 18; })
        .attr("dy", "6")
        .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
        .style("fill-opacity", 1e-6)
      //  .on('mouseover', function (d) { $(this).siblings('.option1').show(); $(this).siblings('.option2').show()})
        .append('a')
        .attr("target",function(d){ return "_blank" })
        .attr("xlink:href",function(d){ return getRootPath()+'/index.php/Building/buildinglist?page=1&id='+d.real_id+"&parent_code="+d.code })
        // .attr("xlink:href",function(d){ return d.id })
        // .attr("xlink:href",function(d){ return "#" })
        .text(function(d) { return d.text; })


    // Transition nodes to their new position.
    var nodeUpdate = node.transition()
        .duration(duration)
        .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

    nodeUpdate.select("text")
      .style("fill-opacity", 1);

  // Transition exiting nodes to the parent's new position.
  var nodeExit = node.exit().transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
      .remove();

  nodeExit.select("circle")
      .attr("r", 1e-6);

  nodeExit.select("text")
      .style("fill-opacity", 1e-6);

  // Update the links…
  var link = vis.selectAll("path.link")
      .data(tree.links(nodes), function(d) { return d.target.id; });

  // Enter any new links at the parent's previous position.
  link.enter().insert("svg:path", "g")
      .attr("class", "link")
      .attr("d", function(d) {
        var o = {x: source.x0, y: source.y0};
        return diagonal({source: o, target: o});
      })
    .transition()
      .duration(duration)
      .attr("d", diagonal);

  // Transition links to their new position.
  link.transition()
      .duration(duration)
      .attr("d", diagonal);

  // Transition exiting nodes to the parent's new position.
  link.exit().transition()
      .duration(duration)
      .attr("d", function(d) {
        var o = {x: source.x, y: source.y};
        return diagonal({source: o, target: o});
      })
      .remove();

  // Stash the old positions for transition.
  nodes.forEach(function(d) {
    d.x0 = d.x;
    d.y0 = d.y;
  });
}
//切换开关，d 为被点击的节点
function toggle(d) {
    if (d.children) {　//如果有子节点
        d._children = d.children; //将该子节点保存到 _children
        d.children = null;  //将子节点设置为null
    } else {
        //如果没有子节点
        d.children = d._children; //从 _children 取回原来的子节点
        d._children = null; //将 _children 设置为 null
    }
}

function addbuilding(d){
    $.ajax({
        url:getRootPath()+'/index.php/Building/getBuildingCode',
        success:function(data){
            var code = parseInt(data) + 1;
            $('.add_building .code').html(code);
        }
    })

 /*   $('.select_parent_code').click(function(){
        $.ajax({
            type:"POST",
            url : getRootPath()+'/index.php/Building/getBuildingNameCode',
            dataType:"json",
            success:function(data){
                console.log(data);
                for(var i=0;i<data.length;i++){
                    var code = data[i]['code'];
                    var name = data[i]['name'];
                    if($(".buildings #"+code).length==0) {
                        $('.buildings ul').append('<li><a href="javascript:;" id='+code+' data-ajax='+code+'>'+code+'-'+name+'</a></li>');
                    }
                }
            }
        })
    })*/

    $.ajax({
        url:getRootPath()+'/index.php/Building/getBuilding',
        method:'post',
        data:{
            building_code:d.code
        },
        success:function(data){
            var data = JSON.parse(data);
/*
            data.level=parseInt(data.level)+1;
            data.level=data.level.toString();*/
           $('.add_building').find('input[name="parent_code"]').val(data.code)
           $('.add_building').find('input[name="level"]').val(data.level);
        }

    })




    $('#add_building .confirm').click(function(){
        var code = $('.add_building .code').html();
        var effective_date = $('.add_building').find('input[name="effective_date"]').val();
        var name = $('.add_building').find('input[name="name"]').val();
        var rank = $('.add_building').find('input[name="rank"]').val();
        var parent_code = $('.add_building').find('input[name="parent_code"]').val();
        var remark = $('.add_building').find('input[name="remark"]').val();
        var level_data = $('.add_building').find('input[name="level"]').val();
        var parent_code_data = $('.add_building').find('input[name="parent_code"]').val();
        remark = remark?remark:'';
        rank = trim(rank);
        if(!effective_date){
            openLayer('请输入生效日期');
            return;
        }
        if(!name){
            openLayer('请输入楼宇名称');
            return;
        }
        if(!level_data){
            openLayer('请选择楼宇层级');
            return;
        }
        if(!parent_code){
            openLayer('请选择上级楼宇');
            return;
        }
        //如果填了顺序号,则要验证是否是数字
        if(rank){
            if(!/^[0-9]*$/.test(rank)){
                openLayer('顺序号请输入数字');
                return;
            }
        }
        //判断有效无效
        if($('.add_building .effective_status input[type="radio"]').eq(0).is(':checked')){
            effective_status = 'true';
        }
        else {
            effective_status = 'false';
        }
        $.ajax({
            url:getRootPath()+'/index.php/Building/insertBuilding',
            method:'post',
            data:{
                code:code,
                effective_date:effective_date,
                effective_status:effective_status,
                name:name,
                level:level_data,
                rank:rank,
                parent_code:parent_code_data,
                remark:remark
            },
            success:function(data){
                var data = JSON.parse(data);
                //成功之后自动刷新页面
                layer.open({
                    type: 1,
                    title: false,
                    //打开关闭按钮
                    closeBtn: 1,
                    shadeClose: false,
                    skin: 'tanhcuang',
                    content: data.message,
                    cancel: function(){
                        //右上角关闭回调
                        window.location = getRootPath() + "/index.php/Building/buildingtree";
                    }
                });
            },
            error:function(){
                console.log('新增楼宇出错');
            }
        })

    })
}


/*window.operateEvents = {
    //点击编辑时,弹出编辑框
    'click .write':function(e,value,row,index){
        var code = row.code;
        var effective_date = row.effective_date;
        var effective_status = row.effective_status;
        var name = row.name;
        var level = row.level;
        var level_name = row.level_name;
        var rank = row.rank;
        var parent_code = row.parent_code;
        var parent_code_name = row.parent_code_name;
        var remark = row.remark;
        var data_id = row.id;

        //赋值
        $('.write_building .code').html(code);
        $('.write_building .effective_date').html(effective_date);
        $('.write_building .effective_status').html(effective_status);
        $('.write_building .level_name').html(level_name);
        $('.write_building .parent_code_name').html(parent_code_name);

        $('.write_building').find('input[name="name"]').val(name);
        $('.write_building').find('input[name="rank"]').val(rank);
        $('.write_building').find('input[name="remark"]').val(remark);
        $('.write_building').find('input[name="data_id"]').val(data_id);
        $('#write_building').modal('show');
    }
}*/

function updatebuilding(d){



    $.ajax({
        url:getRootPath()+'/index.php/Building/getBuildingbyTree',
        method:'post',
        data:{
            building_code:d.code
        },
        success:function(data) {
            var row = JSON.parse(data);
            row=row[0]
            var code = row.code;
            var effective_date = row.effective_date;
            var effective_status = row.effective_status;
            var name = row.name;
            var level = row.level;
            var level_name = row.level_name;
            var rank = row.rank;
            var parent_code = row.parent_code;
            var parent_code_name = row.parent_code_name;
            var remark = row.remark;
            var data_id = row.id;

            //赋值
            $('.write_building .code').html(code);
            $('.write_building .effective_date').html(effective_date);
            $('.write_building .effective_status').html(effective_status);
            $('.write_building .level_name').html(level_name);
            $('.write_building .parent_code_name').html(parent_code_name);

            $('.write_building').find('input[name="name"]').val(name);
            $('.write_building').find('input[name="rank"]').val(rank);
            $('.write_building').find('input[name="remark"]').val(remark);
            $('.write_building').find('input[name="data_id"]').val(data_id);
            $('#write_building').modal('show');
        }
        })



//点击保存编辑楼宇信息
    $('#write_building .confirm').click(function(){
        var code = $('.write_building .code').html();
        var effective_date = $('.write_building').find('input[name="effective_date"]').val();
        var name = $('.write_building').find('input[name="name"]').val();
        var level = $('.write_building').find('input[name="level"]').data('ajax');
        var rank = $('.write_building').find('input[name="rank"]').val();
        var parent_code = $('.write_building').find('input[name="parent_code_name"]').val();
        var remark = $('.write_building').find('input[name="remark"]').val();
        var level_data = $('.write_building').find('input[name="level"]').data('ajax');
        var parent_code_data = $('.write_building').find('input[name="parent_code"]').data('ajax');
        var data_id = $('.write_building').find('input[name="data_id"]').val();
        remark = remark?remark:'';
        rank = trim(rank);
        //如果填了顺序号,则要验证是否是数字
        if(rank){
            if(!/^[0-9]*$/.test(rank)){
                openLayer('顺序号请输入数字');
                return;
            }
        }
        console.log(code)
        console.log(name)
        console.log(rank)
        console.log(remark)
        //只能更改名称\顺序号\备注
        $.ajax({
            url:getRootPath()+'/index.php/Building/updateBuildbyTree',
            method:'post',
            data:{
                code:code,
                name:name,
                rank:rank,
                remark:remark
            },
            success:function(data){
                $('#write_building').modal('hide');
                var data = JSON.parse(data);
                //成功之后自动刷新页面
                layer.open({
                    type: 1,
                    title: false,
                    //打开关闭按钮
                    closeBtn: 1,
                    shadeClose: false,
                    skin: 'tanhcuang',
                    content: data.message,
                    cancel: function(){
                        //右上角关闭回调
                        //刷新列表
                        window.location = getRootPath() + "/index.php/Building/buildingtree"
                        $('#write_building').modal('hide');
                    }
                });

            },
            error:function(){
                console.log('编辑楼宇出错');
            }
        })
    })
}
</script>
<script>
//点击搜索按钮,跳转
$('.search_room button[type="submit"]').click(function(){
  var keyword = $('.search_room .searc_room_text').val();
  keyword = trim(keyword);
  if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(keyword))){
    openLayer('搜索框只能输入数字、汉字、字母!');
    return;
  }
  window.location.href="buildinglist?keyword="+keyword+"&page=1";
})
//清除搜索条件
$('.search_room #clear').click(function(){
  window.location.href="buildinglist?page=1";
})
</script>	
</body>
</html>
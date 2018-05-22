<?php
	require 'top.php'
?>
<link rel="stylesheet" href='<?=base_url().'application/views/plugin/bootstrap-table/css/bootstrap-table.css'?>'/>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/bootstrap-table/js/bootstrap-table-zh-CN.js'?>'></script>
<script src='<?=base_url().'application/views/plugin/d3/d3.min.js'?>'></script>
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
</style>
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

	<div class="col-md-10 col-sm-12 main_wrap">
		<div class="oh">
			<div class="searc_bar oh">
				<a class="active" href="<?=base_url().'index.php/Building/buildingtree'?>">树状图模式</a>
				<a href="<?=base_url().'index.php/Building/buildinglist'?>">列表模式</a>
				<form class="search_room" action="<?=base_url().'index.php/Building/buildinglist'?>" method="get">
					<p>
						<input type="text" class="searc_room_text" name="keyword" placeholder="请输入楼宇名称" value="" />
						<a id="clear" href="<?=base_url().'index.php/Building/buildingtree'?>">X</a>
					</p>
					<button type="submit"><i class="fa fa-search"></i></button>
				</form>
			</div>
		</div>
		<!--绘制树状图容器-->
		<div id="tree">
		  
		</div>
	</div>
</div>	
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
      .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
      

  //绘制空心圆
  nodeEnter.append("svg:circle")
      .attr("r", 8.5)
      .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; })
      .on("click", function(d) { toggle(d); update(d); });

  //绘制文字
  nodeEnter.append("svg:text")
      .attr("x", function(d) { return d.children || d._children ? -18 : 18; })
      .attr("dy", "6")
      .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
      .style("fill-opacity", 1e-6)
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

  nodeUpdate.select("circle")
      .attr("r", 8.5)
      .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });

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
</script>	
</body>
</html>
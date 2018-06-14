<?php
class Building_model extends CI_Model {

    public function __construct()
    {
    	parent::__construct();
        $this->load->database();
    }

    public function insertBuilding($code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$remark,$create_time){
        // echo $code;exit;
        if(is_null($rank)||empty($rank)){
            $sql = "INSERT INTO village_building (code,effective_date,effective_status,name,level,rank,parent_code,remark,create_time) values ($code,'$effective_date',$effective_status,'$name',$level,null,$parent_code,'$remark','$create_time')";
        }
        else{
            $sql = "INSERT INTO village_building (code,effective_date,effective_status,name,level,rank,parent_code,remark,create_time) values ($code,'$effective_date',$effective_status,'$name',$level,$rank,$parent_code,'$remark','$create_time')";
        }
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function updateBuilding($id,$code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$remark,$create_time){
        if(is_null($rank)||empty($rank)){
            $sql = "update village_building set effective_date = '$effective_date',effective_status = $effective_status,name = '$name',level = $level,rank = null,parent_code = $parent_code,remark = '$remark',create_time = '$create_time' where id = $id";
        }
        else{
            $sql = "update village_building set effective_date = '$effective_date',effective_status = $effective_status,name = '$name',level = $level,rank = $rank,parent_code = $parent_code,remark = '$remark',create_time = '$create_time' where id = $id";
        }
        // echo $sql;exit;
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function updateBuildingName($code,$name,$rank,$remark){
        if(empty($rank)){
            $rank = null;
        }
        $sql = "update village_building set name= ".
        $this->db->escape($name).", rank=".
        $this->db->escape($rank).", remark=".
        $this->db->escape($remark)." where code =".
        $this->db->escape($code);
        // echo $sql;exit;
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function getBuildingCode(){
    	$sql = "select code from village_building order by code desc limit 1";
    	$query = $this->db->query($sql);
    	$row = $query->row_array();
    	return $row['code'];
    }

    public function getBuildingsList($level,$keyword,$id,$parent_code,$page,$rows){
        $start=($page-1) * $rows;
    	$sql = "select b.id,b.code,b.effective_date,b.effective_status,b.name,b.level,b.rank,b.parent_code,b.remark from village_building as b left join village_tmp_building tb on b.code = tb.code  ";
        $limit = false;
        if(isset($keyword)&&$keyword!=''){
            if($limit){
                $sql .= " and b.name like '%$keyword%'";
            }
            else{
                $sql .= " where b.name like '%$keyword%'";
                $limit = true;
            }
        }
        if(!empty($id)||!empty($parent_code)){
            if(isset($keyword)&&$keyword!=''){
                //根据level来判断
                //表示是室,此时应该使用parent_code查询
                if($level=='106'){
                    $sql .= "  and b.id = $id or b.parent_code = $parent_code ";
                }
                //期
                else if($level == '101'){
                    $sql .= " and tb.stage = $parent_code ";
                }
                //区
                else if($level == '102'){
                    $sql .= " and tb.area = $parent_code ";
                }
                //栋
                else if($level == '103'){
                    $sql .= " and tb.immeuble = $parent_code ";
                }
                //单元
                else if($level == '104'){
                    $sql .= " and tb.stage = $parent_code ";
                }
                //层
                else if($level == '105'){
                    $sql .= " and tb.floor = $parent_code ";
                }
                //公共设施
                else if($level == '107'){
                    $sql .= " and tb.public = $parent_code ";
                }
            }
            else{
              if($limit){
                  $sql .= " and b.id = $id or b.parent_code = $parent_code";
              }
              else{
                  $sql .= " where b.id = $id or b.parent_code = $parent_code";
                  $limit = true;
              }  
            }
        }
        $sql=$sql." order by code asc limit ".$rows." offset ".$start;
        // echo $sql;exit;
    	$query = $this->db->query($sql);
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$this->buildingsListArray($q->result_array());
			$json=json_encode($arr);
			return $json;
		}
		return false;
    }


    public function getBuildingListById($id){
        $sql = "select id,code,effective_date,effective_status,name,level,rank,parent_code,remark from village_building where id = $id";
        $query = $this->db->query($sql);
        $arr=$this->buildingsListArray($query->result_array());
        $json=json_encode($arr);
        return $json;
    }

    public function buildingsListArray($data){
        $level_name_arr = array(array('code'=>'100','name'=>'小区'),array('code'=>'101','name'=>'期'),array('code'=>'102','name'=>'区'),array('code'=>'103','name'=>'栋'),array('code'=>'104','name'=>'单元'),array('code'=>'105','name'=>'层'),array('code'=>'106','name'=>'室'),array('code'=>'107','name'=>'公共设施'));
    	$arr = array();
    	foreach ( $data as $row) {
    		$item=array();
    		foreach ( $row as $key => $value) {
    			if($key=='code')
    			{
    				$item["code"]=intval($value,10);
    			}
    			elseif($key=='effective_date')
    			{
    				$item["effective_date"]=substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
    				// $item["effective_date"]=$value;
    			}
    			elseif($key=='effective_status')
    			{
    				if($value=='t')
    				{
    					$item["effective_status"]="有效";	
    				}
    				elseif($value=='f') {
    					$item["effective_status"]="无效";
    				}
    				else {
    					$item["effective_status"]="未知";
    				}				
    			}
    			elseif($key=='name')
    			{
    				$item["name"]=$value;
    			}
    			elseif($key=='level')
    			{
    				$item["level"]=intval($value,10);
                    foreach($level_name_arr as $key => $v){
                        if($value == $v['code']){
                            $item["level_name"] = $v['name'];
                            break;
                        }
                    }
    			}
    			elseif($key=='rank')
    			{
                    if(!empty($item["rank"])){
                        $item["rank"]=intval($value,10);

                    }
    				else {
                        $item["rank"]= $value;
                    }
    			}
    			elseif($key=='parent_code')
    			{
    				$item["parent_code"]=intval($value,10);
                    $item['parent_code_name'] = $this->getBuildingByCode($value)['name'];
    			}
    			elseif($key=='remark')
    			{
    				$item["remark"]=$value?$value:'无';
    			}
                elseif($key=='id')
                {
                    $item["id"]=intval($value,10);
                }
                elseif($key=='level_type')
                {
                    $item["level_type"]=intval($value,10);
                }
                $item["household"]=$this->getHouseholdInfo($row);
    		}
    		$arr[]=$item;
    	}
    	return $arr;
    }

    public function getHouseholdInfo($row){
        $result="";
        if(!empty($row['stage_name']))
        {
            $result=$result.$row['stage_name']."(期)";
        }
        if(!empty($row['area_name']))
        {
            $result=$result.$row['area_name']."(区)";
        }       
        if(!empty($row['immeuble_name']))
        {
            $result=$result.$row['immeuble_name']."(栋)";
        }
        if(!empty($row['unit_name']))
        {
            $result=$result.$row['unit_name']."(单元)";
        }       
        if(!empty($row['floor_name']))
        {
            $result=$result.$row['floor_name']."(层)";
        }       
        if(!empty($row['room_name']))
        {
            $result=$result.$row['room_name']."(室)";
        }
        if(!empty($row['public_name']))
        {
            $result=$result.$row['public_name']."(公共设施)";
        }             
        return $result;
    }

    public function getBuildingTotal($level,$keyword,$id,$parent_code,$rows){
        $sql = "select count(b.id) as count from village_building as b left join village_tmp_building tb on b.code = tb.code  ";
        $limit = false;
        if(isset($keyword)&&$keyword!=''){
            if($limit){
                $sql .= " and b.name like '%$keyword%'";
            }
            else{
                $sql .= " where b.name like '%$keyword%'";
                $limit = true;
            }
        }
        if(!empty($id)||!empty($parent_code)){
            if(isset($keyword)&&$keyword!=''){
                //根据level来判断
                //表示是室,此时应该使用parent_code查询
                if($level=='106'){
                    $sql .= "  and b.parent_code = $parent_code ";
                }
                //期
                else if($level == '101'){
                    $sql .= " and tb.stage = $parent_code ";
                }
                //区
                else if($level == '102'){
                    $sql .= " and tb.area = $parent_code ";
                }
                //栋
                else if($level == '103'){
                    $sql .= " and tb.immeuble = $parent_code ";
                }
                //单元
                else if($level == '104'){
                    $sql .= " and tb.stage = $parent_code ";
                }
                //层
                else if($level == '105'){
                    $sql .= " and tb.floor = $parent_code ";
                }
                //公共设施
                else if($level == '107'){
                    $sql .= " and tb.public = $parent_code ";
                }
            }
            else{
              if($limit){
                  $sql .= " and b.id = $id or b.parent_code = $parent_code";
              }
              else{
                  $sql .= " where b.id = $id or b.parent_code = $parent_code";
                  $limit = true;
              }  
            }
        }
        // echo $sql;exit;
        $q = $this->db->query($sql); //自动转义
        if ( $q->num_rows() > 0 ) {
            $row = $q->row_array();
            $items=$row["count"];
            
            if($items%$rows!=0)
            {
                $total=(int)((int)$items/$rows)+1;
            }
            else {
                $total=$items/$rows;
            }
            return $total;
        } 
        return 0;
    }

    public function getBuildingNameCode(){
        $sql = "select code,concat(stage_name,area_name,immeuble_name,unit_name,floor_name,room_name,public_name) as name from village_tmp_building ORDER BY code,name";
        $q = $this->db->query($sql);
        if ( $q->num_rows() > 0 ) {
            $arr=$q->result_array();
            $json=json_encode($arr);
            return $json;
        }
        return false;
    }

    public function getBuildingById($id){
        $sql = "select id,code,name,effective_date from village_building where id = $id limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $res = array();
        $res[0] = $row;
        $arr=$this->buildingsListArray($res);
        $result = $arr[0];
        return $result;
    }

    public function getBuildingByCode($code){
        $sql = "select id,village_building.code,village_building.name,effective_date,stage,area,immeuble,unit,floor,room  from village_building   LEFT JOIN village_tmp_building  on village_building.code = village_tmp_building.room where village_building.code = $code limit 1";
        // echo $sql;
        // echo "<br />";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $res = array();
        $res[0] = $row;
        $arr=$this->buildingsListArray($res);
        $result = $arr[0];
        return $result;
    }

    public function getBuildingTreeData(){
        //查到最顶级节点
        $sql = "select concat(code,'_',id) as id,code,parent_code,name as text,id as real_id,level from village_building a where effective_date =(select max(effective_date) from village_building b where a.name = b.name and a.parent_code = b.parent_code and b.effective_status = true and b.effective_date <= now()) and effective_status = true and code = parent_code";
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $root_tree = $query->row_array();
        if(!empty($root_tree)){
            //得到第二级节点
            $first_tree = $this->getTreeNodeByPcode($root_tree['code']);
            //得到第三级节点
            //找到每个一级节点的二级节点,智汇谷只有两级节点,所以这里只用做一次循环
            foreach($first_tree as $k => $v){
                // echo $v['level'];
                // echo "<br />";
                //如果楼宇层级不是106(室)或者107(公共设施),则继续往下查
                if($v['level']!=106 || $v['level'] !=107){
                   $second_node = $this->getTreeNodeByPcode($v['code']);
                   if(!empty($second_node)){
                        //得到第四级节点
                        foreach($second_node as $k4 => $v4){
                            if($v4['level']!=106 || $v4['level'] !=107){
                                $third_node = $this->getTreeNodeByPcode($v4['code']);
                            }
                            if(!empty($third_node)){
                                //得到第五级节点
                                foreach($third_node as $k5 => $v5){
                                    if($v5['level']!=106 || $v5['level'] !=107){
                                        $fourth_node = $this->getTreeNodeByPcode($v5['code']);
                                    }
                                    if(!empty($fourth_node)){
                                        //得到第六级节点
                                        foreach($fourth_node as $k6 => $v6){
                                            if($v6['level']!=106 || $v6['level'] !=107){
                                                $fifth_node = $this->getTreeNodeByPcode($v6['code']);
                                                if(!empty($fifth_node)){
                                                    //得到第7级节点
                                                    foreach($fifth_node as $k7 => $v7){
                                                        if($v7['level']!=106 || $v7['level'] !=107){
                                                            $sixth_node = $this->getTreeNodeByPcode($v7['code']);
                                                            if(!empty($sixth_node)){
                                                                $fifth_node[$k7]['children'] = $sixth_node;
                                                            }
                                                        }
                                                    }
                                                    $fourth_node[$k6]['children'] = $fifth_node;
                                                }
                                            }
                                        }
                                        $third_node[$k5]['children'] = $fourth_node;
                                    }
                                }
                                $second_node[$k4]['children'] = $third_node;
                            }
                        }
                        $first_tree[$k]['children'] = $second_node;
                   } 
                }
                
            }
            $root_tree['children'] = $first_tree;
            return json_encode($root_tree);
        }
        return false;
    }

    public function getTreeNodeByPcode($parent_code){
        $sql = "select concat(code,'_',id) as id,code,parent_code,name as text,id as real_id,level from village_building a where effective_date =(select max(effective_date) from village_building b where a.name = b.name and a.parent_code = b.parent_code and b.effective_status = true and b.effective_date <= now() ) and a.parent_code = $parent_code and a.code != $parent_code and a.effective_status = true  order by a.code,a.id";
        // echo $sql;
        // echo '<br />';
        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }

    public function getTopNode(){
        $sql = "select * from village_building where parent_code = code limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function getBuilding($code){
        $sql = "select * from village_tmp_building where code = $code limit 1";
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
        // print_r(json_encode($row));
    }

    public function getQrcodeData($type,$village,$code){
        $data=array();
        $data['type']=$type;
        $data['village']=$village;
        $data['code']=$code;
        $json=json_encode($data);
        return $json;
    }

    public function setQRcode($qrcodeData,$temp_path,$fileName){
        if (!file_exists(iconv('utf-8', 'gbk', $temp_path)))
        {
            mkdir(iconv('utf-8', 'gbk', $temp_path), 0700, true);
        }
        $pngAbsoluteFilePath = $temp_path.$fileName;
        $pngAbsoluteFilePath = iconv('utf-8', 'gbk', $pngAbsoluteFilePath);
        if (!file_exists($pngAbsoluteFilePath)) { 
            QRcode::png($qrcodeData, $pngAbsoluteFilePath); 
        } else { 
            QRcode::png($qrcodeData, $pngAbsoluteFilePath);
        } 
    }
    
    
        public function getBuildingbyTree($code){
        $sql = "select * from village_building where code = $code limit 1";
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $arr=$this->buildingsListArray($query->result_array());

        print_r(json_encode($arr));
    }

    public function updateBuildbyTree($code,$name,$rank,$remark){
        if(empty($rank)){
            $rank = null;
        }
        $sql = "update village_building set name= ".
            $this->db->escape($name).", rank=".
            $this->db->escape($rank).", remark=".
            $this->db->escape($remark)." where code =".
            $this->db->escape($code);
        // echo $sql;exit;
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

}
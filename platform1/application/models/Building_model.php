<?php
class Building_model extends CI_Model {

    public function __construct()
    {
    	parent::__construct();
        $this->load->database();
    }

    public function insertBuilding($code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$remark,$create_time,$level_type){
        if(is_null($rank)||empty($rank)){
            $sql = "INSERT INTO village_building (code,effective_date,effective_status,name,level,rank,parent_code,remark,create_time,level_type) values ($code,'$effective_date',$effective_status,'$name',$level,null,$parent_code,'$remark','$create_time',$level_type)";
        }
        else{
            $sql = "INSERT INTO village_building (code,effective_date,effective_status,name,level,rank,parent_code,remark,create_time,level_type) values ($code,'$effective_date',$effective_status,'$name',$level,$rank,$parent_code,'$remark','$create_time',$level_type)";
        }
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function updateBuilding($id,$code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$remark,$create_time,$level_type){
        if(is_null($rank)||empty($rank)){
            $sql = "update village_building set effective_date = '$effective_date',effective_status = $effective_status,name = '$name',level = $level,rank = null,parent_code = $parent_code,remark = '$remark',create_time = '$create_time',level_type = $level_type where id = $id";
        }
        else{
            $sql = "update village_building set effective_date = '$effective_date',effective_status = $effective_status,name = '$name',level = $level,rank = $rank,parent_code = $parent_code,remark = '$remark',create_time = '$create_time' where id = $id";
        }
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

    public function getBuildingsList($keyword,$page,$rows){
        $start=($page-1) * $rows;
    	$sql = "select id,code,effective_date,effective_status,name,level,rank,parent_code,remark from village_building";
        if(!empty($keyword)){
            $sql .= " where name like '%$keyword%'"; 
        }
        $sql=$sql." order by rank,code asc limit ".$rows." offset ".$start;
    	$query = $this->db->query($sql);
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$this->buildingsListArray($q->result_array());
			$json=json_encode($arr);
			return $json;
		}
		return false;
    }

    public function getBuildingTreeList($id,$parent_code,$page,$rows){
        $start=($page-1) * $rows;
        $sql = "select id,code,effective_date,effective_status,name,level,rank,parent_code,remark from village_building";
        $sql .= " where id = $id or parent_code = $parent_code"; 
        $sql=$sql." order by rank,code asc limit ".$rows." offset ".$start;
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

    public function getHouseholdInfo($row)
    {
        $result="";
        if(!empty($row['stage']))
        {
            $result=$result.$row['stage'].'期';
        }
        if(!empty($row['area']))
        {
            $result=$result.$row['area'].'区';
        }       
        if(!empty($row['immeuble']))
        {
            $result=$result.$row['immeuble'].'栋';
        }
        if(!empty($row['unit']))
        {
            $result=$result.$row['unit'].'单元';
        }       
        if(!empty($row['floor']))
        {
            $result=$result.$row['floor'].'层';
        }       
        if(!empty($row['room']))
        {
            $result=$result.$row['room'].'室';
        }            
        return $result;
    }

    public function getBuildingTotal($keyword,$rows){
        $sql = "select count(*) as count from village_building";
        $limit = false;
        if(!empty($keyword)){
            $sql .= " where name like '%$keyword%' ";
            $limit = true;
        }
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

    public function getBuildingTreeTotal($id,$parent_code,$rows){
        $sql = "select count(*) as count from village_building";
        $limit = false;
        if(!empty($id)||!empty($parent_code)){
            $sql .= " where id = $id or parent_code = $parent_code";
        }
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
        $sql = "select code,name from village_building GROUP BY code,name order by code";
        $q = $this->db->query($sql);
        if ( $q->num_rows() > 0 ) {
            $arr=$q->result_array();
            $json=json_encode($arr);
            return $json;
        }
        return false;
    }

    public function getBuildingById($id){
        $sql = "select id,code,name,effective_date,level_type from village_building where id = $id limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $res = array();
        $res[0] = $row;
        $arr=$this->buildingsListArray($res);
        $result = $arr[0];
        return $result;
    }

    public function getBuildingByCode($code){
        $sql = "select id,code,name,effective_date,level_type,stage,area,immeuble,unit,floor,room  from village_building LEFT JOIN village_building_stage on village_building.code = village_building_stage.room_code where code = $code limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $res = array();
        $res[0] = $row;
        $arr=$this->buildingsListArray($res);
        $result = $arr[0];
        return $result;
    }

    public function getBuildingLast(){
        // $sql = "select code,effective_date,parent_code,name from village_building where effective_status = true and effective_date = (SELECT effective_date from village_building ORDER BY effective_date desc LIMIT 1) GROUP BY code,effective_date,parent_code,name  ORDER BY code,effective_date desc";
        $sql = "SELECT code,parent_code,effective_date,NAME FROM village_building WHERE effective_status = TRUE and effective_date < now() GROUP BY name,code,parent_code,effective_date ORDER BY code DESC";
        
        $q = $this->db->query($sql);
        if ( $q->num_rows() > 0 ) {
            $arr=$q->result_array();
            $json=json_encode($arr);
            return $json;
        }
        return false;
    }

    public function getBuildingTreeData(){
        //查到最顶级节点
        $sql = "select concat(code,'_',id) as id,code,parent_code,name as text,id as real_id from village_building where effective_status = true and code = parent_code";
        $query = $this->db->query($sql);
        $root_tree = $query->row_array();
        if(!empty($root_tree)){
            $first_tree = $this->getTreeNodeByPcode($root_tree['code']);
            //找到每个一级节点的二级节点,智汇谷只有两级节点,所以这里只用做一次循环
            foreach($first_tree as $k => $v){
                $res = $this->getTreeNodeByPcode($v['code']);
                if(!empty($res)){
                    $first_tree[$k]['children'] = $res;
                }
            }
            $root_tree['children'] = $first_tree;
            return json_encode($root_tree);
        }
        return false;
    }

    public function getTreeNodeByPcode($parent_code){
        $sql = "select concat(code,'_',id) as id,code,parent_code,name as text,id as real_id from village_building a where effective_date =(select max(effective_date) from village_building b where a.name = b.name and a.parent_code = b.parent_code and b.effective_status = true ) and a.parent_code = $parent_code and a.code != $parent_code and a.effective_status = true  order by a.code,a.id";
         //echo $sql;
        // echo '<br />';
        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }
}
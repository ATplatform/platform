<?php
class TmpBuilding_model extends CI_Model {

    public function __construct()
    {
    	parent::__construct();
        $this->load->database();
    }

    public function getVillageBuilding()
    {
    	$sql = "select id,code,effective_date,effective_status,name,level,rank,parent_code,remark from village_building";
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$this->buildingsListArray($q->result_array());
			return $arr;
		}
		return false;
    }

    public function delTmpBuilding()
    {
    	$sql = "delete from village_tmp_building";
    	$query = $this->db->query($sql);
    	return true;
    }
    public function getVillage()
    {
    	$sql = "select village_building.village_id,code,village_building.name,level,village_building_level.name as levelname from village_building left join village_building_level on village_building.level=village_building_level.level_code where village_building.level=100 and village_building.effective_status='t'";
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			return $arr;
		}
		return false;
    }
    public function insertTmpVillage($village_id,$levelname,$code,$level,$name)
    {
    	if(is_null($village_id))
    	{
    		$village_id="NULL";
    	}
        $sql = "INSERT INTO village_tmp_building (village_id,$levelname,$levelname"."_name,level,name) values ($village_id,$code,'$name',$level,'$name')";
        $query = $this->db->query($sql);
        return true;
    }
    
	public function insertNextLevel($upper_level,$own)
	{
		$village_id=$own['village_id'];
    	if(is_null($own['village_id']))
    	{
    		$village_id="NULL";
    	}
        $sql = "INSERT INTO village_tmp_building (village_id,";
        $key="";
        $value="";
        foreach ($upper_level as $item)
        {
        	$key=$key.$item['levelname'].",".$item['levelname']."_name".",";
        	$value=$value.$item['code'].",'".$item['name']."',";
        }
        $key=$key.$own['levelname'].",".$own['levelname']."_name".",";
        $value=$value.$own['code'].",'".$own['name']."',";
        $sql=$sql.$key."level,name) values ($village_id,".$value."'".$own['level']."','".$own['name']."')";
        $query = $this->db->query($sql);
        return true;
	}   
	 
    public function getNextLevel($upper_level,$upper_code)
    {
    	$sql = "select village_building.village_id,code,village_building.name,level,village_building_level.name as levelname from village_building left join village_building_level on village_building.level=village_building_level.level_code where village_building.parent_code=$upper_code and village_building.code!=$upper_code";
    	$query = $this->db->query($sql);
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach ($arr as $item)
			{
				$temp=array_merge($upper_level);
				$this->insertNextLevel($upper_level,$item);
				$node['levelname']=$item['levelname'];
    			$node['code']=$item['code'];
    			$node['name']=$item['name'];
    			$temp[]=$node;
				$this->getNextLevel($temp, $item['code']);
			}
			return $arr;
		}
		return false;
    }
    
    public function getTmpBuilding()
    {
    	$this->delTmpBuilding();
    	$village=$this->getVillage();
    	if($village===false)
    	{
    		return false;
    	}
    	foreach($village as $item)
    	{
    		$this->insertTmpVillage($item['village_id'],$item['levelname'],$item['code'],$item['level'],$item['name']);
    		$upper=array();
    		$node=array();
    		$node['levelname']=$item['levelname'];
    		$node['code']=$item['code'];
    		$node['name']=$item['name'];
    		$upper[]=$node;
    		$this->getNextLevel($upper,$node['code']);	
    	}
    }
    

}
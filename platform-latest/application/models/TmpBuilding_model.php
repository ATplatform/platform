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
    	$sql = "select vb.village_id,vb.code,vb.name,vb.parent_code,vb.level,vl.name as levelname from (select max(effective_date) as effective_date,code from village_building where effective_date<now() and effective_status='t' and level=100 group by code) as t left join village_building vb on t.effective_date=vb.effective_date and t.code=vb.code left join village_building_level vl on vb.level=vl.level_code where vb.effective_status='t'";
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			return $arr;
		}
		return false;
    }
    public function insertTmpVillage($village_id,$levelname,$code,$level,$name,$parent_code)
    {
    	if(is_null($village_id))
    	{
    		$village_id="NULL";
    	}
        $sql = "INSERT INTO village_tmp_building (village_id,$levelname,$levelname"."_name,level,name,code,parent_code) values ($village_id,$code,'$name',$level,'$name',$code,$parent_code)";
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
        $temp=array();
        foreach ($upper_level as $item)
        {
        	if(in_array($item['levelname'],$temp))
        	{
        		return true;
        	}
        	$temp[]=$item['levelname'];
        	if($item['levelname']==$own['levelname'])
        	{
        		return true;
        	}
        	$key=$key.$item['levelname'].",".$item['levelname']."_name".",";
        	$value=$value.$item['code'].",'".$item['name']."',";
        }
        $key=$key.$own['levelname'].",".$own['levelname']."_name".",";
        $value=$value.$own['code'].",'".$own['name']."',";
        $sql=$sql.$key."level,name,code,parent_code) values ($village_id,".$value."'".$own['level']."','".$own['name']."',".$own['code'].",".$own['parent_code'].")";
        $query = $this->db->query($sql);
        return true;
	}   
	 
    public function getNextLevel($upper_level,$upper_code)
    {
    	$sql = "select vb.village_id,vb.code,vb.name,vb.parent_code,vb.level,vl.name as levelname from (select max(effective_date) as effective_date,code from village_building where effective_date<now() and effective_status='t' group by code) as t left join village_building vb on t.effective_date=vb.effective_date and t.code=vb.code left join village_building_level vl on vb.level=vl.level_code where vb.effective_status='t' and vb.parent_code=$upper_code and vb.code!=$upper_code";
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
    		$this->insertTmpVillage($item['village_id'],$item['levelname'],$item['code'],$item['level'],$item['name'],$item['parent_code']);
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
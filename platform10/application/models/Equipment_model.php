<?php
class Equipment_model extends CI_model {
	public function __construct()
	{
		parent::__construct();
	    $this->load->database();
	    $this->equipment_type_arr=$this->config->item('equipment_type_arr');
	    $this->regular_check_arr=$this->config->item('regular_check_arr');
	    $this->if_se_arr=$this->config->item('if_se_arr');
	    $this->effective_status_arr=$this->config->item('effective_status_arr');
	    $this->annual_check_arr=$this->config->item('annual_check_arr');
	}

	public function getEquipmentNameCode(){
		$sql = "select code,name from village_equipment GROUP BY code,name order by code";
		$q = $this->db->query($sql);
		if ( $q->num_rows() > 0 ) {
		    $arr=$q->result_array();
		    $json=json_encode($arr);
		    return $json;
		}
		return false;
	}

	public function getEquipmentCode(){
		$sql = "select code from village_equipment order by code desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['code'];
	}

	public function insertEquipment($code,$effective_date,$effective_status,$name,$pcs,$equipment_type,$building_code,$function,$initial_no,$initial_model,$tech_spec,$supplier,$production_date,$parent_code,$regular_check,$regular_date,$position_code,$if_se,$annual_check,$annual_date){
		$now="'".date('Y-m-d H:i:s',time())."'";
		if(empty($regular_date)){
			$regular_date = null;
		}
		if(empty($production_date)){
			$production_date = null;
		}
		if(empty($parent_code)){
			$parent_code = null;
		}
		$sql = "INSERT INTO village_equipment (code,effective_date,effective_status,name,pcs,equipment_type,building_code,function,initial_no,initial_model,tech_spec,supplier,production_date,parent_code,regular_check,regular_date,position_code,if_se,annual_check,annual_date,create_time) values (".
			$this->db->escape($code).", ".
			$this->db->escape($effective_date).", ".
			$this->db->escape($effective_status).", ".
			$this->db->escape($name).", ".
			$this->db->escape($pcs).", ".
			$this->db->escape($equipment_type).",".
			$this->db->escape($building_code).", ".
			$this->db->escape($function).", ".
			$this->db->escape($initial_no).", ".
			$this->db->escape($initial_model).", ".
			$this->db->escape($tech_spec).", ".
			$this->db->escape($supplier).", ".
			$this->db->escape($production_date).", ".
			$this->db->escape($parent_code).", ".
			$this->db->escape($regular_check).", ".
			$this->db->escape($regular_date).", ".
			$this->db->escape($position_code).", ".
			$this->db->escape($if_se).", ".
			$this->db->escape($annual_check).", ".
			$this->db->escape($annual_date).", ".$now.")"
		;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getEquipmentList($page,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$rows){
		$start=($page-1) * $rows;
		$equipment_type_arr=$this->equipment_type_arr;
		$regular_check_arr=$this->regular_check_arr;
		$if_se_arr=$this->if_se_arr;
		$effective_status_arr=$this->effective_status_arr;
		$annual_check_arr=$this->annual_check_arr;
		$sql = "select *,bd.parent_code as building_parent_code,e.name as e_name,e.parent_code as e_parent_code,e.code as code from village_equipment as e LEFT JOIN village_tmp_building as b on e.building_code = room left join village_building as bd on e.building_code = bd.code ";
		$sql=$sql." where bd.effective_date = (select max(effective_date) from village_building b_i where bd.name = b_i.name and bd.parent_code = b_i.parent_code and b_i.effective_status = true  and b_i.effective_date <= now() ) ";
		$sql=$sql." and e.effective_status = true ";
		if(!empty($effective_date)){
			$sql=$sql." and e.effective_date <= '$effective_date' ";
		}
		if(!empty($equipment_type)){
			$sql=$sql." and equipment_type = $equipment_type ";
		}
		if(!empty($regular_check)){
			$sql=$sql." and regular_check = $regular_check ";
		}
		if(isset($keyword)&&$keyword!=''){
			$sql=$sql." and concat(e.name,function,internal_no,initial_no) like '%$keyword%' ";
		}

		//树形菜单点击筛选
		if(!empty($building_code)){
			$sql .= " and bd.parent_code = $building_code or bd.code = $building_code ";
		}

		$sql=$sql." order by e.code asc limit ".$rows." offset ".$start;
		// echo $sql;exit;
		$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					//设备类型
					if($k1=="equipment_type"){
						foreach($equipment_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["equipment_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//巡检周期
					if($k1=="regular_check"){
						foreach($regular_check_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["regular_check_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//生效日期
					if($k1=="effective_date"){
						$arr[$key]["effective_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					//生厂日期
					if($k1=="production_date"){
						if(!empty($value)){
							$arr[$key]["production_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
						}
					}
					//巡检日期
					if($k1=="regular_date"){
						if(!empty($value)){
							$arr[$key]["regular_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
						}
					}
					//外审日期
					if($k1=="annual_date"){
						if(!empty($value)){
							$arr[$key]["annual_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
						}
					}
					//是否特种设备
					if($k1=="if_se"){
						foreach($if_se_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["if_se_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//是否有效
					if($k1=="effective_status"){
						foreach($effective_status_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["effective_status_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//外审周期
					if($k1=="annual_check"){
						foreach($annual_check_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["annual_check_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//得到职位名称
					if($k1=="position_code"){
						$position_retail = $this->getPositionByCode($value);
						$arr[$key]["position_name"] = $position_retail['name'];	
					}
					//得到上级设备名称
					if($k1=="e_parent_code"){
						if(!empty($value)){
							$parent_equipment = $this->getEquipmentByCode($value);
							$arr[$key]["e_parent_code_name"] = $parent_equipment['name'];
						}
					}

				}
				//得到安装地点名称
				$arr[$key]["building_name"] = $this->getHouseholdInfo($row);
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;

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

	//根据职位code查到职位信息
	public function getPositionByCode($code){
		//查出最近的有效记录
		$sql = "select * from village_position where code = '$code' order by effective_date desc limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function getEquipmentListTotal($page,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$rows){
		$sql = "select count(*) as count from village_equipment as e LEFT JOIN village_tmp_building as b on e.building_code = room left join village_building as bd on e.building_code = bd.code ";
		$sql=$sql." where bd.effective_date = (select max(effective_date) from village_building b_i where bd.name = b_i.name and bd.parent_code = b_i.parent_code and b_i.effective_status = true and b_i.effective_date <= now() ) ";
		$sql=$sql." and e.effective_status = true ";
		if(!empty($effective_date)){
			$sql=$sql." and e.effective_date <= '$effective_date' ";
		}
		if(!empty($equipment_type)){
			$sql=$sql." and equipment_type = $equipment_type ";
		}
		if(!empty($regular_check)){
			$sql=$sql." and regular_check = $regular_check ";
		}
		if(isset($keyword)&&$keyword!=''){
			$sql=$sql." and concat(e.name,function,internal_no,initial_no) like '%$keyword%' ";
		}
		//树形菜单点击筛选
		if(!empty($building_code)){
			$sql .= " and bd.parent_code = $building_code or bd.code = $building_code ";
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

	public function getEquipmentByCode($code){
		//查出最近的有效记录
		$sql = "select * from village_equipment where code = '$code' and effective_status = true limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function updateEquipment($code,$name,$pcs,$equipment_type,$building_code,$function,$initial_no,$initial_model,$tech_spec,$supplier,$production_date,$parent_code,$regular_check,$regular_date,$position_code,$if_se,$annual_check,$annual_date){
		if(empty($regular_date)){
			$regular_date = null;
		}
		if(empty($production_date)){
			$production_date = null;
		}
		if(empty($parent_code)){
			$parent_code = null;
		}
		$sql = " update village_equipment set name=".
		$this->db->escape($name).", pcs=".
		$this->db->escape($pcs).", equipment_type=".
		$this->db->escape($equipment_type).", building_code=".
		$this->db->escape($building_code).", function=".
		$this->db->escape($function).", initial_no=".
		$this->db->escape($initial_no).", initial_model=".
		$this->db->escape($initial_model).", tech_spec=".
		$this->db->escape($tech_spec).", supplier=".
		$this->db->escape($supplier).", production_date=".
		$this->db->escape($production_date).", parent_code=".
		$this->db->escape($parent_code).", regular_check=".
		$this->db->escape($regular_check).", regular_date=".
		$this->db->escape($regular_date).", position_code=".
		$this->db->escape($position_code).", if_se=".
		$this->db->escape($if_se).", annual_check=".
		$this->db->escape($annual_check).", annual_date=".
		$this->db->escape($annual_date)." where code =".
		$this->db->escape($code);
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getEquipmentByName($name){
		$sql = "select e.code,e.name,e.building_code,b.stage_name,b.area_name,b.immeuble_name,b.unit_name,b.floor_name,b.room_name,b.public_name,b.room from village_equipment as e LEFT JOIN village_tmp_building as b on e.building_code = b.room where e.name like '%$name%'  and e.effective_status = true ";
		$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//得到安装地点名称
				$arr[$key]["building_name"] = $this->getHouseholdInfo($row);
			}
			return $arr;
		}
		return false;
	}

	public function insertPersonEquipment($code,$equipment_code,$person_code,$building_code,$begin_date,$end_date,$remark){
		$now="'".date('Y-m-d H:i:s',time())."'";
		if(empty($regular_date)){
			$regular_date = null;
		}
		if(empty($production_date)){
			$production_date = null;
		}
		$sql = "INSERT INTO village_person_equipment (code,equipment_code,person_code,building_code,begin_date,end_date,remark,create_time) values (".
			$this->db->escape($code).", ".
			$this->db->escape($equipment_code).", ".
			$this->db->escape($person_code).", ".
			$this->db->escape($building_code).", ".
			$this->db->escape($begin_date).", ".
			$this->db->escape($end_date).", ".
			$this->db->escape($remark).", ".$now.")"
		;
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getLastPersonEquipment(){
		$sql = "select * from village_person_equipment order by code desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function getPersoneEquipmentList($person_code,$building_code,$page,$keyword,$effective_date,$equipment_type,$building_code_single,$row){
		$equipment_type_arr=$this->equipment_type_arr;
		$sql = "select pe.equipment_code,pe.building_code,pe.person_code,pe.begin_date,pe.end_date,pe.remark as pe_remark, e.name,e.equipment_type,e.initial_no,e.pcs,e.building_code as equipment_building_code,pe.code as code from village_person_equipment as pe left join village_equipment as e on pe.equipment_code = e.code where	e.effective_status = true and e.effective_date <= now()";
		if(!empty($equipment_type)){
			$sql .= " and e.equipment_type = '$equipment_type' ";
		}
		//树形图菜单筛选
		if(!empty($building_code_single)){
			$sql .= " and $building_code_single = any(pe.building_code) ";
		}
		//设备名称
		if(isset($keyword)&&$keyword!=""){
			if(!$building_code&&!$person_code){
				$sql .= " and e.name like '%$keyword%' ";
			}
		}
		//楼宇搜索
		if(!empty($building_code)){
			//转化成 array[1001,1002]的形式
			$building_code = implode(',',$building_code);
			$building_code = "array[".$building_code."]";
			$sql .= " and pe.building_code &&  $building_code";
		}
		//住户名字搜索
		if(!empty($person_code)){
			//转化成 array[1001,1002]的形式
			$person_code = implode(',',$person_code);
			$person_code = "array[".$person_code."]";
			$sql .= " and pe.person_code &&  $person_code";
		}	
		$sql .= " order by  pe.code ";
		// print_r($building_code);exit;
		// echo $sql;exit;
		$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					//设备类型
					if($k1=="equipment_type"){
						foreach($equipment_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["equipment_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//开始日期
					if($k1=="begin_date"){
						$arr[$key]["begin_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					//结束日期
					if($k1=="end_date"){
						if(!empty($value)){
							$arr[$key]["end_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
						}
					}
					//赋值设备安装地点中文名称
					if($k1=="equipment_building_code"){
						if(!empty($value)){
							$building = $this->getBuildingByCode($value);
							$household = $this->getHouseholdInfo($building);
							$arr[$key]["equipment_building"] = $household;
						}
					}
				}
				//对每一条数据循环,查出安装地点
				if(!empty($row['building_code'])){
					$building_code_str = $row['building_code'];
					//去掉building_code前的括号
					$building_code_str = substr($building_code_str,1); 
					$building_code_str = substr($building_code_str,0,strlen($building_code_str)-1);
					//前端调用
					$building_code_arr = explode(",", $building_code_str);
					$arr[$key]['building_code_str'] = $building_code_arr;
					//转化成字符串(1001,1002)形式,查询名字使用
					$building_code_str = "(".$building_code_str.")";
					$buildings = $this->getBuildingByCodeArray($building_code_str);
					$arr[$key]['building_name'] = "";
					$arr[$key]['building_name_arr'] = array();
					//根据拼接成的结果查出所有的地点信息
					foreach($buildings as $k2 => $v2){
						// print_r($v2);
						// echo "<br />";
						$household = $this->getHouseholdInfo($v2);
						$arr[$key]['building_name'] .= $household."，";
						array_push($arr[$key]['building_name_arr'],$household);
					}
				}
				//对每一条数据循环,查出这条数据的所有授权住户
				if(!empty($row['person_code'])){
					$person_code_str = $row['person_code'];

					//去掉person_code前的括号
					$person_code_str = substr($person_code_str,1); 
					$person_code_str = substr($person_code_str,0,strlen($person_code_str)-1);
					//前端调用
					$person_code_arr = explode(",", $building_code_str);
					$arr[$key]['person_code_str'] = $person_code_arr;
					//转化成字符串(1001,1002)形式,查询名字使用
					$person_code_str = "(".$person_code_str.")";
					$person = $this->getPersonByCodeArray($person_code_str);
					$arr[$key]['person_name'] = "";
					$arr[$key]['person_id_arr'] = array();
					$arr[$key]['person_name_arr'] = array();
					foreach($person as $k2 => $v2){
						array_push($arr[$key]['person_id_arr'],$v2['id_number']);
						array_push($arr[$key]['person_name_arr'],$v2['full_name']);
						$arr[$key]['person_name'] .= $v2['full_name']."，";
					}
				}
			}
			// print_r($arr);exit;
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function getBuildingByCode($code){
		$sql = "select * from village_tmp_building where code = $code limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function getBuildingByCodeArray($code){
		$sql = "select * from village_tmp_building where code in $code ";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
	}

	public function getPersonByCodeArray($code){
		$sql = "select id_number,code,concat(last_name,first_name) as full_name from village_person where code in $code";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
	}

	public function getPersoneEquipmentListTotal($person_code_arr,$building_code_arr,$keyword,$effective_date,$equipment_type,$building_code_single,$rows){
		$sql = "select count(pe.code) as count from village_person_equipment as pe left join village_equipment as e on pe.equipment_code = e.code where	e.effective_status = true and e.effective_date <= now()";
		if(!empty($equipment_type)){
			$sql .= " and e.equipment_type = '$equipment_type' ";
		}
		//树形图菜单筛选
		if(!empty($building_code_single)){
			$sql .= " and $building_code_single = any(pe.building_code) ";
		}
		//设备名称
		if(isset($keyword)&&$keyword!=""){
			if(!$building_code&&!$person_code){
				$sql .= " and e.name like '%$keyword%' ";
			}
		}
		//楼宇搜索
		if(!empty($building_code_arr)){
			//转化成 array[1001,1002]的形式
			$building_code_arr = implode(',',$building_code_arr);
			$building_code_arr = "array[".$building_code_arr."]";
			$sql .= " and pe.building_code &&  $building_code_arr";
		}
		//住户名字搜索
		if(!empty($person_code_arr)){
			//转化成 array[1001,1002]的形式
			$person_code_arr = implode(',',$person_code_arr);
			$person_code_arr = "array[".$person_code_arr."]";
			$sql .= " and pe.person_code &&  $person_code_arr";
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

	public function updatePersonEquipment($code,$person_code,$building_code,$begin_date,$end_date,$remark){
		$sql = "UPDATE village_person_equipment SET person_code = '$person_code',building_code = '$building_code',begin_date = '$begin_date',end_date = '$end_date',remark = '$remark' WHERE code = '$code' ";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getBuildingByName($name){
		$sql = "select code from village_tmp_building where name like '%$name%' ";
		// echo $sql;exit;
		$q = $this->db->query($sql);
		if ( $q->num_rows() > 0 ){
			$arr=$q->result_array();
			return $arr;
		}
		return false;
	}

	public function getPersonByName($name){
		$sql = "select code from village_person where concat(last_name,first_name) like '%$name%' ";
		$q = $this->db->query($sql);
		if ( $q->num_rows() > 0 ){
			$arr=$q->result_array();
			return $arr;
		}
		return false;
	}
}
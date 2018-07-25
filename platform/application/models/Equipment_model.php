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

	public function getEquipmentNameCode($village_id){
		$sql = "select code,name from village_equipment where village_id = $village_id GROUP BY code,name order by code";
		$q = $this->db->query($sql);
		if ( $q->num_rows() > 0 ) {
		    $arr=$q->result_array();
		    $json=json_encode($arr);
		    return $json;
		}
		return false;
	}

	public function getEquipmentCode($village_id){
		$sql = "select code from village_equipment where village_id = $village_id order by code desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['code'];
	}

	public function insertEquipment($village_id,$qr_code,$code,$effective_date,$effective_status,$name,$pcs,$sign,$equipment_type,$building_code,$function,$internal_no,$initial_no,$initial_model,$tech_spec,$supplier,$production_date,$parent_code,$regular_check,$regular_date,$position_code,$if_se,$annual_check,$annual_date){
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
		if(empty($annual_date)){
			$annual_date = null;
		}
		if(empty($regular_date)){
			$regular_date = null;
		}
		if(empty($position_code)){
			$position_code = null;
		}
		$sql = "INSERT INTO village_equipment (village_id,qr_code,code,effective_date,effective_status,name,pcs,sign,equipment_type,building_code,function,internal_no,initial_no,initial_model,tech_spec,supplier,production_date,parent_code,regular_check,regular_date,position_code,if_se,annual_check,annual_date,create_time) values (".
			$this->db->escape($village_id).", ".
			$this->db->escape($qr_code).", ".
			$this->db->escape($code).", ".
			$this->db->escape($effective_date).", ".
			$this->db->escape($effective_status).", ".
			$this->db->escape($name).", ".
			$this->db->escape($pcs).", ".
			$this->db->escape($sign).", ".
			$this->db->escape($equipment_type).",".
			$this->db->escape($building_code).", ".
			$this->db->escape($function).", ".
			$this->db->escape($internal_no).", ".
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
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getEquipmentList($village_id,$page,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$level,$rows){
		$start=($page-1) * $rows;
		$equipment_type_arr=$this->equipment_type_arr;
		$regular_check_arr=$this->regular_check_arr;
		$if_se_arr=$this->if_se_arr;
		$effective_status_arr=$this->effective_status_arr;
		$annual_check_arr=$this->annual_check_arr;
		$sql = "select e.effective_date,e.effective_status,e.pcs,e.equipment_type,e.building_code,e.function,e.internal_no,e.initial_no,e.initial_model,e.tech_spec,e.supplier,e.production_date,e.production_date,e.regular_check,e.regular_date,e.position_code,e.if_se,e.annual_check,e.annual_date,e.private,e.sign,b.stage_name,b.area_name,b.immeuble_name,b.unit_name,b.floor_name,b.room_name,b.public_name,bd.parent_code as building_parent_code,e.name as e_name,e.parent_code as e_parent_code,e.code as code,e.village_id,e.qr_code,b.level,b.name from village_equipment as e LEFT JOIN village_tmp_building as b on e.building_code = b.code and e.village_id = b.village_id left join village_building as bd on e.building_code = bd.code and e.village_id = bd.village_id ";
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
			$sql=$sql." and concat(e.name,function,internal_no) like '%$keyword%' ";
		}
		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and b.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and b.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and b.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and b.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and b.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and b.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and b.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and b.public = $building_code ";
			}
		}
		$sql=$sql." and e.village_id = $village_id ";
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
						if(!empty($value)){
							$position_retail = $this->getPositionByCode($value);
							$arr[$key]["position_name"] = $position_retail['name'];	
						}
						
					}
					//得到上级设备名称
					if($k1=="e_parent_code"){
						if(!empty($value)){
							$parent_equipment = $this->getEquipmentByCode($value,$village_id);
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
	        $result=$result.$row['stage_name'];
	    }
	    if(!empty($row['area_name']))
	    {
	        $result=$result.$row['area_name'];
	    }       
	    if(!empty($row['immeuble_name']))
	    {
	        $result=$result.$row['immeuble_name'];
	    }
	    if(!empty($row['unit_name']))
	    {
	        $result=$result.$row['unit_name'];
	    }       
	    if(!empty($row['floor_name']))
	    {
	        $result=$result.$row['floor_name'];
	    }       
	    if(!empty($row['room_name']))
	    {
	        $result=$result.$row['room_name'];
	    }
	    if(!empty($row['public_name']))
	    {
	        $result=$result.$row['public_name'];
	    }
	    if(!empty($row['level'])&&$row['level']==100){
	        $result=$result.$row['name'];
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

	public function getEquipmentListTotal($village_id,$page,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$level,$rows){
		$sql = "select count(e.code) as count from village_equipment as e LEFT JOIN village_tmp_building as b on e.building_code = b.code AND e.village_id = b.village_id left join village_building as bd on e.building_code = bd.code AND e.village_id = bd.village_id ";
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
			$sql=$sql." and concat(e.name,function,internal_no) like '%$keyword%' ";
		}
		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and b.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and b.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and b.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and b.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and b.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and b.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and b.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and b.public = $building_code ";
			}
		}
		$sql=$sql." and e.village_id = $village_id ";
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

	public function getEquipmentByCode($code,$village_id){
		//查出最近的有效记录
		$sql = "select * from village_equipment where code = '$code' and effective_status = true and village_id = $village_id limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function updateEquipment($code,$village_id,$name,$qrcodeData,$sign,$pcs,$equipment_type,$building_code,$function,$internal_no,$initial_no,$initial_model,$tech_spec,$supplier,$production_date,$parent_code,$regular_check,$regular_date,$position_code,$if_se,$annual_check,$annual_date){
		if(empty($regular_date)){
			$regular_date = null;
		}
		if(empty($production_date)){
			$production_date = null;
		}
		if(empty($parent_code)){
			$parent_code = null;
		}
		if(empty($annual_date)){
			$annual_date = null;
		}
		if(empty($regular_date)){
			$regular_date = null;
		}
		if(empty($position_code)){
			$position_code = null;
		}
		$sql = " update village_equipment set name=".
		$this->db->escape($name).", qr_code=".
		$this->db->escape($qrcodeData).", sign=".
		$this->db->escape($sign).", pcs=".
		$this->db->escape($pcs).", equipment_type=".
		$this->db->escape($equipment_type).", building_code=".
		$this->db->escape($building_code).", function=".
		$this->db->escape($function).", internal_no=".
		$this->db->escape($internal_no).", initial_no=".
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
		$this->db->escape($code)." and village_id = ".
		$this->db->escape($village_id);
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getEquipmentByName($name,$village_id){
		$sql = "select e.code,e.name,e.building_code,b.stage_name,b.area_name,b.immeuble_name,b.unit_name,b.floor_name,b.room_name,b.public_name,b.room,b.level from village_equipment as e LEFT JOIN village_tmp_building as b on e.building_code = b.code and e.village_id = b.village_id  where e.name like '%$name%'  and e.effective_status = true and e.village_id = $village_id ";
		// echo $sql;exit;
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

	public function insertPersonEquipment($code,$village_id,$equipment_code,$person_code,$building_code,$begin_date,$end_date,$remark){
		$now="'".date('Y-m-d H:i:s',time())."'";
		if(empty($regular_date)){
			$regular_date = null;
		}
		if(empty($production_date)){
			$production_date = null;
		}
		$sql = "INSERT INTO village_person_equipment (code,village_id,equipment_code,person_code,building_code,begin_date,end_date,remark,create_time) values (".
			$this->db->escape($code).", ".
			$this->db->escape($village_id).", ".
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

	public function getLastPersonEquipment($village_id){
		$sql = "select * from village_person_equipment where village_id = $village_id order by code desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function getPersoneEquipmentList($village_id,$person_code,$has_search_person,$building_code,$page,$keyword,$effective_date,$equipment_type,$building_code_single,$rows){
		//如果搜索了人名,并且搜索人名结果为空,表示没有这个人,应该退出
		if($has_search_person == true && empty($person_code)){
			return false;
		}
		$start=($page-1) * $rows;
		$equipment_type_arr=$this->equipment_type_arr;
		$sql = "select pe.equipment_code,pe.building_code,pe.person_code,pe.begin_date,pe.end_date,pe.remark as pe_remark, e.name,e.equipment_type,e.initial_no,e.pcs,e.building_code as equipment_building_code,pe.code as code from village_person_equipment as pe left join village_equipment as e on pe.equipment_code = e.code  and pe.village_id = e.village_id where	e.effective_status = true and pe.begin_date <= '$effective_date' and pe.end_date >= '$effective_date' ";
		if(!empty($equipment_type)){
			$sql .= " and e.equipment_type = '$equipment_type' ";
		}
		//树形图菜单筛选
		if(!empty($building_code_single)){
			$sql .= " and $building_code_single = any(pe.building_code) ";
		}
		//楼宇搜索
		/*if(!empty($building_code)){
			//转化成 array[1001,1002]的形式
			$building_code = implode(',',$building_code);
			$building_code = "array[".$building_code."]";
			$sql .= " and pe.building_code &&  $building_code";
		}*/
		//住户名字搜索
		if(!empty($person_code)){
			//转化成 array[1001,1002]的形式
			$person_code = implode(',',$person_code);
			$person_code = "array[".$person_code."]";
			$sql .= " and pe.person_code &&  $person_code";
		}	
		$sql .= " and pe.village_id = $village_id ";
		$sql .=" order by pe.code asc limit ".$rows." offset ".$start;
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
							$building = $this->getBuildingByCode($value,$village_id);
							$household = $this->getHouseholdInfo($building);
							$arr[$key]["equipment_building"] = $household;
						}
					}
				}
				//对每一条数据循环,查出安装地点
				if(!empty($row['building_code'])){
					$building_code_str = $row['building_code'];

					//去掉building_code前后的{}括号
					$building_code_str = substr($building_code_str,1); 
					$building_code_str = substr($building_code_str,0,strlen($building_code_str)-1);
					$arr[$key]['building_name'] = "";
					$arr[$key]['building_name_arr'] = array();
					$arr[$key]['building_code_str'] = array();
					if(!empty($building_code_str)){
						//前端调用
						$building_code_arr = explode(",", $building_code_str);
						$arr[$key]['building_code_str'] = $building_code_arr;
						//转化成字符串(1001,1002)形式,查询名字使用
						$building_code_str = "(".$building_code_str.")";
						$buildings = $this->getBuildingByCodeArray($building_code_str,$village_id);
						//根据拼接成的结果查出所有的地点信息
						foreach($buildings as $k2 => $v2){
							$household = $this->getHouseholdInfo($v2);
							$arr[$key]['building_name'] .= $household.",";
							array_push($arr[$key]['building_name_arr'],$household);
						}
						//去掉最后一个逗号
						$arr[$key]['building_name'] = substr($arr[$key]['building_name'],0,-1);
					}
				}
				//对每一条数据循环,查出这条数据的所有授权住户
				if(!empty($row['person_code'])){
					$person_code_str = $row['person_code'];
					//去掉person_code前后的{}括号
					$person_code_str = substr($person_code_str,1); 
					$person_code_str = substr($person_code_str,0,strlen($person_code_str)-1);
					$arr[$key]['person_name'] = "";
					$arr[$key]['person_id_arr'] = array();
					$arr[$key]['person_code_str'] = array();
					$arr[$key]['person_name_arr'] = array();
					//前端调用
					if(!empty($person_code_str)){
						// echo $person_code_str;exit;
						$person_code_arr = explode(",", $person_code_str);
						$arr[$key]['person_code_str'] = $person_code_arr;
						//转化成字符串(1001,1002)形式,查询名字使用
						$person_code_str = "(".$person_code_str.")";
						$person = $this->getPersonByCodeArray($person_code_str,$village_id);
						foreach($person as $k2 => $v2){
							array_push($arr[$key]['person_id_arr'],$v2['id_number']);
							array_push($arr[$key]['person_name_arr'],$v2['full_name']);
							$arr[$key]['person_name'] .= $v2['full_name'].",";
						}
						//去掉最后一个逗号
						$arr[$key]['person_name'] = substr($arr[$key]['person_name'],0,-1);
					}
					
				}
			}
			// print_r($arr);exit;
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function getPrivilegeEquipmentList($village_id,$person_code,$has_search_person,$building_code,$page,$keyword,$effective_date,$equipment_type,$building_code_single,$rows){
		//如果搜索了人名,并且搜索人名结果为空,表示没有这个人,应该退出
		if($has_search_person == true && empty($person_code)){
			return false;
		}
		$start=($page-1) * $rows;
		$equipment_type_arr=$this->equipment_type_arr;
		$sql = "select pe.equipment_code,pe.building_code,pe.person_code,pe.begin_date,pe.end_date,pe.remark as pe_remark, e.name,e.equipment_type,e.initial_no,e.pcs,e.building_code as equipment_building_code,pe.code as code from village_person_equipment as pe left join village_equipment as e on pe.equipment_code = e.code  and pe.village_id = e.village_id where	e.effective_status = true and pe.begin_date <= '$effective_date' and pe.end_date >= '$effective_date' ";
		if(!empty($equipment_type)){
			$sql .= " and e.equipment_type = '$equipment_type' ";
		}
		//树形图菜单筛选
		if(!empty($building_code_single)){
			$sql .= " and $building_code_single = any(pe.building_code) ";
		}
		//住户名字搜索
		if(!empty($person_code)){
			//转化成 array[1001,1002]的形式
			$person_code = implode(',',$person_code);
			$person_code = "array[".$person_code."]";
			$sql .= " and pe.person_code &&  $person_code";
		}
		//只查出门禁对讲的设备
		$sql .= " and e.equipment_type in (301,302,303,304,305,306,307) ";	
		$sql .= " and pe.village_id = $village_id ";
		$sql .=" order by pe.code asc limit ".$rows." offset ".$start;
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
							$building = $this->getBuildingByCode($value,$village_id);
							$household = $this->getHouseholdInfo($building);
							$arr[$key]["equipment_building"] = $household;
						}
					}
				}
				//对每一条数据循环,查出安装地点
				if(!empty($row['building_code'])){
					$building_code_str = $row['building_code'];

					//去掉building_code前后的{}括号
					$building_code_str = substr($building_code_str,1); 
					$building_code_str = substr($building_code_str,0,strlen($building_code_str)-1);
					$arr[$key]['building_name'] = "";
					$arr[$key]['building_name_arr'] = array();
					$arr[$key]['building_code_str'] = array();
					if(!empty($building_code_str)){
						//前端调用
						$building_code_arr = explode(",", $building_code_str);
						$arr[$key]['building_code_str'] = $building_code_arr;
						//转化成字符串(1001,1002)形式,查询名字使用
						$building_code_str = "(".$building_code_str.")";
						$buildings = $this->getBuildingByCodeArray($building_code_str,$village_id);
						//根据拼接成的结果查出所有的地点信息
						foreach($buildings as $k2 => $v2){
							$household = $this->getHouseholdInfo($v2);
							$arr[$key]['building_name'] .= $household.",";
							array_push($arr[$key]['building_name_arr'],$household);
						}
						//去掉最后一个逗号
						$arr[$key]['building_name'] = substr($arr[$key]['building_name'],0,-1);
					}
				}
				//对每一条数据循环,查出这条数据的所有授权住户
				if(!empty($row['person_code'])){
					$person_code_str = $row['person_code'];
					//去掉person_code前后的{}括号
					$person_code_str = substr($person_code_str,1); 
					$person_code_str = substr($person_code_str,0,strlen($person_code_str)-1);
					$arr[$key]['person_name'] = "";
					$arr[$key]['person_id_arr'] = array();
					$arr[$key]['person_code_str'] = array();
					$arr[$key]['person_name_arr'] = array();
					//前端调用
					if(!empty($person_code_str)){
						// echo $person_code_str;exit;
						$person_code_arr = explode(",", $person_code_str);
						$arr[$key]['person_code_str'] = $person_code_arr;
						//转化成字符串(1001,1002)形式,查询名字使用
						$person_code_str = "(".$person_code_str.")";
						$person = $this->getPersonByCodeArray($person_code_str,$village_id);
						foreach($person as $k2 => $v2){
							array_push($arr[$key]['person_id_arr'],$v2['id_number']);
							array_push($arr[$key]['person_name_arr'],$v2['full_name']);
							$arr[$key]['person_name'] .= $v2['full_name'].",";
						}
						//去掉最后一个逗号
						$arr[$key]['person_name'] = substr($arr[$key]['person_name'],0,-1);
					}
					
				}
			}
			// print_r($arr);exit;
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function getBuildingByCode($code,$village_id){
		$sql = "select * from village_tmp_building where code = $code and village_id = $village_id limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function getBuildingByCodeArray($code,$village_id){
		$sql = "select * from village_tmp_building where code in $code and village_id = $village_id ";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
	}

	public function getPersonByCodeArray($code,$village_id){
		$sql = "select id_number,code,concat(last_name,first_name) as full_name from village_person where code in $code and village_id = $village_id";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
	}

	public function getPersoneEquipmentListTotal($village_id,$person_code_arr,$has_search_person,$building_code_arr,$keyword,$effective_date,$equipment_type,$building_code_single,$rows){
		//如果搜索了人名,并且搜索人名结果为空,表示没有这个人,应该退出
		if($has_search_person == true && empty($person_code)){
			return 0;
		}
		$sql = "select count(pe.code) as count from village_person_equipment as pe left join village_equipment as e on pe.equipment_code = e.code and pe.village_id = e.village_id where e.effective_status = true and pe.begin_date <= '$effective_date' and pe.end_date >= '$effective_date' ";
		if(!empty($equipment_type)){
			$sql .= " and e.equipment_type = '$equipment_type' ";
		}
		//树形图菜单筛选
		if(!empty($building_code_single)){
			$sql .= " and $building_code_single = any(pe.building_code) ";
		}
		//楼宇搜索
		/*if(!empty($building_code_arr)){
			//转化成 array[1001,1002]的形式
			$building_code_arr = implode(',',$building_code_arr);
			$building_code_arr = "array[".$building_code_arr."]";
			$sql .= " and pe.building_code &&  $building_code_arr";
		}*/
		//住户名字搜索
		if(!empty($person_code_arr)){
			//转化成 array[1001,1002]的形式
			$person_code_arr = implode(',',$person_code_arr);
			$person_code_arr = "array[".$person_code_arr."]";
			$sql .= " and pe.person_code &&  $person_code_arr";
		}
		$sql .= " and pe.village_id = '$village_id' ";
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

	public function getPrivilegeEquipmentListTotal($village_id,$person_code_arr,$has_search_person,$building_code_arr,$keyword,$effective_date,$equipment_type,$building_code_single,$rows){
		//如果搜索了人名,并且搜索人名结果为空,表示没有这个人,应该退出
		if($has_search_person == true && empty($person_code)){
			return 0;
		}
		$sql = "select count(pe.code) as count from village_person_equipment as pe left join village_equipment as e on pe.equipment_code = e.code and pe.village_id = e.village_id where e.effective_status = true and pe.begin_date <= '$effective_date' and pe.end_date >= '$effective_date' ";
		if(!empty($equipment_type)){
			$sql .= " and e.equipment_type = '$equipment_type' ";
		}
		//树形图菜单筛选
		if(!empty($building_code_single)){
			$sql .= " and $building_code_single = any(pe.building_code) ";
		}
		//住户名字搜索
		if(!empty($person_code_arr)){
			//转化成 array[1001,1002]的形式
			$person_code_arr = implode(',',$person_code_arr);
			$person_code_arr = "array[".$person_code_arr."]";
			$sql .= " and pe.person_code &&  $person_code_arr";
		}
		//只查出门禁对讲的设备
		$sql .= " and e.equipment_type in (301,302,303,304,305,306,307) ";
		$sql .= " and pe.village_id = '$village_id' ";
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

	public function updatePersonEquipment($village_id,$code,$person_code,$building_code,$begin_date,$end_date,$remark){
		$sql = "UPDATE village_person_equipment SET person_code = '$person_code',building_code = '$building_code',begin_date = '$begin_date',end_date = '$end_date',remark = '$remark' WHERE code = '$code' and village_id = $village_id ";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getBuildingByName($name,$village_id){
		$sql = "select code from village_tmp_building where name like '%$name%' and village_id = $village_id ";
		// echo $sql;exit;
		$q = $this->db->query($sql);
		if ( $q->num_rows() > 0 ){
			$arr=$q->result_array();
			return $arr;
		}
		return false;
	}

	public function getPersonByName($name,$village_id){
		$sql = "select code from village_person where concat(last_name,first_name) like '%$name%' and village_id = $village_id  ";
		$q = $this->db->query($sql);
		if ( $q->num_rows() > 0 ){
			$arr=$q->result_array();
			return $arr;
		}
		return false;
	}

	public function getEquipmentConfig($village_id,$level,$page,$keyword,$effective_date,$equipment_type,$building_code,$rows){
		$start=($page-1) * $rows;
		$equipment_type_arr=$this->equipment_type_arr;
		$regular_check_arr=$this->regular_check_arr;
		$if_se_arr=$this->if_se_arr;
		$effective_status_arr=$this->effective_status_arr;
		$annual_check_arr=$this->annual_check_arr;
		$sql = "select b.stage_name,b.area_name,b.immeuble_name,b.unit_name,b.floor_name,b.room_name,b.public_name,b.name,e.name as e_name,e.code,e.village_id,e.building_code,e.server_ip,e.lan_ip,e.ip,e.gateway,e.netmask,e.dns1,e.dns2,e.sip,e.tdcode_url,b.level from village_equipment as e LEFT JOIN village_tmp_building as b on e.building_code = b.code and e.village_id = b.village_id  ";
		$sql=$sql." where e.effective_status = true ";
		$sql=$sql." and e.equipment_type in (301,302,303,304,305,306,307) ";
		// $sql=$sql." and e.server_ip !='' ";
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
			$sql=$sql." and concat(e.name,e.lan_ip) like '%$keyword%' ";
		}

		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and b.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and b.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and b.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and b.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and b.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and b.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and b.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and b.public = $building_code ";
			}
		}

		$sql .= " and e.village_id = $village_id";
		$sql=$sql." order by e.code asc limit ".$rows." offset ".$start;
		// echo $sql;exit;
		$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					//url转换
					/*if($k1=="tdcode_url"){
						if(!empty($value)){
							$arr[$key]["tdcode_url"] = urlencode($value);
						}
					}*/
				}
				//得到安装地点名称
				$arr[$key]["building_name"] = $this->getHouseholdInfo($row);
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function getEquipmentConfigTotal($village_id,$level,$page,$keyword,$effective_date,$equipment_type,$building_code,$rows){
		$equipment_type_arr=$this->equipment_type_arr;
		$regular_check_arr=$this->regular_check_arr;
		$if_se_arr=$this->if_se_arr;
		$effective_status_arr=$this->effective_status_arr;
		$annual_check_arr=$this->annual_check_arr;
		$sql = "select count(e.code) as count from village_equipment as e LEFT JOIN village_tmp_building as b on e.building_code = b.code and e.village_id = b.village_id  ";
		$sql=$sql." where e.effective_status = true ";
		$sql=$sql." and e.equipment_type in (301,302,303,304,305,306,307) ";
		// $sql=$sql." and e.server_ip !='' ";
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
			$sql=$sql." and concat(e.name,e.lan_ip) like '%$keyword%' ";
		}

		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and b.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and b.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and b.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and b.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and b.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and b.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and b.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and b.public = $building_code ";
			}
		}
		$sql .= " and e.village_id = $village_id";
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


	public function getConfigEquipmentNameCode($village_id){
		$sql = "select code,name from village_equipment where equipment_type in (301,302,303,304,305,306,307) and effective_status = true and village_id = $village_id GROUP BY code,name order by code";
		$q = $this->db->query($sql);
		if ( $q->num_rows() > 0 ) {
		    $arr=$q->result_array();
		    $json=json_encode($arr);
		    return $json;
		}
		return false;
	}

	public function getConfigData($severip,$pnetworkip,$ip,$gatewayip,$netmask,$dns1,$dns2,$sip){
	    $data=array();
	    //注意这里,之前ip和pnetworkip的写反了
	    $data['serverip']=$severip;
	    $data['pnetworkip']=$ip;
	    $data['ip']=$pnetworkip;
	    $data['gatewayip']=$gatewayip;
	    $data['netmask']=$netmask;
	    // $data['dns1']=$dns1;
	    // $data['dns2']=$dns2;
	    $data['sip']=$sip;
	    $json=json_encode($data);
	    return $json;
	}
	public function updateEquipmentConfig($code,$village_id,$server_ip,$lan_ip,$ip,$gateway,$netmask,$dns1,$dns2,$tdcode_url){
		$sql = "update village_equipment set server_ip = ".
		$this->db->escape($server_ip).", lan_ip=".
		$this->db->escape($lan_ip).", ip=".
		$this->db->escape($ip).", gateway=".
		$this->db->escape($gateway).", netmask=".
		$this->db->escape($netmask).", dns1=".
		$this->db->escape($dns1).", dns2=".
		$this->db->escape($dns2).", tdcode_url=".
		$this->db->escape($tdcode_url)." where code =".
		$this->db->escape($code)." and village_id = ".
		$this->db->escape($village_id);
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function updateEquipmentSip($code,$sip,$village_id){
		$sql = "update village_equipment set sip = ".
		$this->db->escape($sip)." where code =".
		$this->db->escape($code)." and village_id = ".
		$this->db->escape($village_id);
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function updateEquipmentQrCode($code,$qr_code,$village_id){
		$sql = "update village_equipment set qr_code = ".
		$this->db->escape($qr_code)." where code =".
		$this->db->escape($code)." and village_id = ".
		$this->db->escape($village_id);
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function updateEquipmentTdCodeUrl($code,$tdcode_url,$village_id){
		$sql = "update village_equipment set tdcode_url = ".
		$this->db->escape($tdcode_url)." where code =".
		$this->db->escape($code)." and village_id = ".
		$this->db->escape($village_id);
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getEquipmentStatus($village_id,$page,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$level,$rows){
		$start=($page-1) * $rows;
		$equipment_type_arr=$this->equipment_type_arr;
		$regular_check_arr=$this->regular_check_arr;
		$if_se_arr=$this->if_se_arr;
		$effective_status_arr=$this->effective_status_arr;
		$annual_check_arr=$this->annual_check_arr;
		$sql = "select e_r.equipment_code,e_r.rtm_status,e_r.reason,e_r.frequency,e_r.if_atte,e.name,e.equipment_type,e.regular_check,b.stage_name,b.area_name,b.immeuble_name,b.unit_name,b.floor_name,b.room_name,b.public_name from village_equipment_rtm as e_r left join village_equipment as e on e_r.equipment_code = e.code and e_r.village_id = e.village_id left join village_tmp_building as b on b.code = e.building_code and b.village_id = e.village_id where e_r.village_id = $village_id  ";
		if(!empty($equipment_type)){
			$sql=$sql." and e.equipment_type = $equipment_type ";
		}
		if(!empty($regular_check)){
			$sql=$sql." and e.regular_check = $regular_check ";
		}
		if(isset($keyword)&&$keyword!=''){
			$sql=$sql." and concat(e.name,e_r.equipment_code) like '%$keyword%' ";
		}
		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and b.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and b.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and b.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and b.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and b.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and b.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and b.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and b.public = $building_code ";
			}
		}
		$sql=$sql." order by e.code asc limit ".$rows." offset ".$start;
		// echo $sql;exit；
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
					//设备状态
					if($k1=="rtm_status"){
						if($value==101){
							$arr[$key]["status_name"] = "在线";
						}
						if($value==102){
							$arr[$key]["status_name"] = "离线";
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

	public function getEquipmentStatusTotal($village_id,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$level,$rows){
		$sql = "select count(e_r.equipment_code) as count from village_equipment_rtm as e_r left join village_equipment as e on e_r.equipment_code = e.code and e_r.village_id = e.village_id left join village_tmp_building as b on b.code = e.building_code and b.village_id = e.village_id where e_r.village_id = $village_id  ";
		if(!empty($equipment_type)){
			$sql=$sql." and e.equipment_type = $equipment_type ";
		}
		if(!empty($regular_check)){
			$sql=$sql." and e.regular_check = $regular_check ";
		}
		if(isset($keyword)&&$keyword!=''){
			$sql=$sql." and concat(e.name,e_r.equipment_code) like '%$keyword%' ";
		}
		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and b.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and b.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and b.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and b.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and b.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and b.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and b.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and b.public = $building_code ";
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

	public function verifyLanip($village_id,$lan_ip,$code){
		$sql = "select lan_ip from village_equipment where village_id = '$village_id' and lan_ip = '$lan_ip' and code != $code limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		if($query->num_rows() > 0 ){
			$res=$query->row_array();
			return $res['lan_ip'];
		}
		return false;
	}

	public function getEquipmentService($village_id,$page,$keyword,$effective_date,$push_start_date,$push_end_date,$equipment_type,$regular_check,$building_code,$level,$rows){
		$start=($page-1) * $rows;
		$equipment_type_arr=$this->equipment_type_arr;
		$regular_check_arr=$this->regular_check_arr;
		$if_se_arr=$this->if_se_arr;
		$effective_status_arr=$this->effective_status_arr;
		$annual_check_arr=$this->annual_check_arr;
		$sql = "select e.code as equipment_code,e.name,e.equipment_type,e.regular_check,e.regular_date,r.accept_person_code as person_code,r.work_code,r.complete_time,b.stage_name,b.area_name,b.immeuble_name,b.unit_name,b.floor_name,b.room_name,b.public_name from village_order_record as r left join village_equipment as e on r.equipment_code = e.code and r.village_id = e.village_id LEFT JOIN village_tmp_building as b on b.code = e.building_code and b.village_id = e.village_id where r.equipment_code is not null and r.village_id = $village_id  ";
		//开始日期筛选
		if(!empty($push_start_date)){
			$sql=$sql." and r.complete_time >= '$push_start_date' ";
		}
		if(!empty($push_end_date)){
			$sql=$sql." and r.complete_time <= '$push_end_date' ";
		}
		if(isset($keyword)&&$keyword!=''){
			$sql=$sql." and e.name like '%$keyword%' ";
		}
		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and b.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and b.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and b.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and b.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and b.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and b.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and b.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and b.public = $building_code ";
			}
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
					//得到维保人姓名
					if($k1=="person_code"){
						$person = $this->getPersonByCode($value,$village_id);
						$arr[$key]["person_name"] = $person['full_name'];
					}
					//得到实际维保时间
					if($k1=="complete_time"){
						$push_time = $value;
						if(!empty($value)){
							$push_time = explode('.',$value);
							$push_time = $push_time[0];
						}
						$arr[$key]["complete_time"] = $push_time;
					}
					//得到计划维保时间和维保类型
					if($k1=="work_code"){
						$workorder = $this->getWorkOrder($value,$village_id);
						$arr[$key]["check_date"] = $workorder['regular_date'];
						$create_type = $workorder['create_type'];
						$first = substr($create_type,0,1);
						if($first==1){
							$arr[$key]["order_type"] = "自动工单";
						}
						if($first==2){
							$arr[$key]["order_type"] = "手动工单";
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

	public function getEquipmentServiceTotal($village_id,$keyword,$effective_date,$push_start_date,$push_end_date,$equipment_type,$regular_check,$building_code,$level,$rows){
		$sql = "select count(e.code) as count from village_order_record as r left join village_equipment as e on r.equipment_code = e.code and r.village_id = e.village_id LEFT JOIN village_tmp_building as b on b.code = e.building_code and b.village_id = e.village_id where r.equipment_code is not null and r.village_id = $village_id  ";
		//开始日期筛选
		if(!empty($push_start_date)){
			$sql=$sql." and r.complete_time >= '$push_start_date' ";
		}
		if(!empty($push_end_date)){
			$sql=$sql." and r.complete_time <= '$push_end_date' ";
		}
		if(isset($keyword)&&$keyword!=''){
			$sql=$sql." and e.name like '%$keyword%' ";
		}
		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and b.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and b.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and b.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and b.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and b.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and b.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and b.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and b.public = $building_code ";
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

	public function getPersonByCode($code,$village_id){
		$sql = "select *,concat(last_name,first_name) as full_name from village_person where code = $code and village_id = $village_id limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function getWorkOrder($code,$village_id){
		$sql = "select * from village_work_order where code = $code and village_id = $village_id limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

}
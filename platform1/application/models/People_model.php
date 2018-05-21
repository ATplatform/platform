<?php
class People_model extends CI_model {
	public function __construct()
	{
		parent::__construct();
	    $this->load->database();
		$this->position_type_arr=$this->config->item('position_type_arr');
	    $this->position_grade_arr=$this->config->item('position_grade_arr');
	    $this->gender_arr=$this->config->item('gender_arr');
	    $this->ethnicity_name_arr=$this->config->item('ethnicity_name_arr');
	    $this->blood_type_arr=$this->config->item('blood_type_arr');
	    $this->id_type_arr=$this->config->item('id_type_arr');
	    $this->household_type_arr=$this->config->item('household_type_arr');
	    $this->if_disabled_arr=$this->config->item('if_disabled_arr');
	}

	public function getPeopleCode(){
		$sql = "select code from village_person order by code desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['code'];
	}

	public function verifyIdcard($id_card){
		$sql = "select id_number from village_person where id_number = '$id_card' limit 1";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0 ){
			$res=$query->row_array();
			return $res['id_number'];
		}
		return false;
	}

	public function insertPeople($code,$last_name,$first_name,$id_type,$id_number,$nationality,$gender,$birth_date,$if_disabled,$bloodtype,$ethnicity,$tel_country,$mobile_number,$oth_mob_no,$remark,$create_time){
		if(is_null($oth_mob_no)||empty($oth_mob_no)){
			$oth_mob_no = 'null';
		}
		$sql = "INSERT INTO village_person (code,last_name,first_name,id_type,id_number,nationality,gender,birth_date,if_disabled,blood_type,ethnicity,tel_country,mobile_number,oth_mob_no,remark,create_time) values ($code,'$last_name','$first_name',$id_type,'$id_number','$nationality',$gender,'$birth_date',$if_disabled,$bloodtype,$ethnicity,'$tel_country','$mobile_number',$oth_mob_no,'$remark','$create_time')";
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function updatePeople($code,$last_name,$first_name,$id_type,$id_number,$nationality,$gender,$birth_date,$if_disabled,$blood_type,$ethnicity,$tel_country,$mobile_number,$oth_mob_no,$remark){
		if(is_null($oth_mob_no)||empty($oth_mob_no)){
			$oth_mob_no = 'null';
		}
		$sql = "UPDATE village_person SET last_name = '$last_name',first_name = '$first_name',id_type = '$id_type',id_number = '$id_number',nationality = '$nationality',gender = '$gender',birth_date = '$birth_date',if_disabled = '$if_disabled',blood_type = '$blood_type',ethnicity = '$ethnicity',tel_country = '$tel_country',mobile_number = '$mobile_number',oth_mob_no = '$oth_mob_no',remark = '$remark'  WHERE code = '$code' ";
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function updatePersonBuilding($building_code,$person_code,$begin_date,$end_date){
		$sql = "UPDATE village_person_building SET end_date = '$end_date'  WHERE building_code = '$building_code' and person_code = '$person_code' and begin_date = '$begin_date' ";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getResidentList($if_disabled,$birth_begin,$birth_end,$household_type,$effective_date,$keyword,$page,$rows){
		$gender_arr=$this->gender_arr;
		$id_type_arr=$this->id_type_arr;
		$blood_type_arr=$this->blood_type_arr;
		$ethnicity_name_arr=$this->ethnicity_name_arr;
		$if_disabled_arr=$this->if_disabled_arr;
		$household_type_arr=$this->household_type_arr;
		$start=($page-1) * $rows;
		//关联person_building\person\building_stage表查出所有住户\楼栋信息
		$sql = "select *,concat(p.last_name,p.first_name) as full_name,pb.remark as pb_remark from village_person_building as pb LEFT JOIN village_person as p on pb.person_code = p.code  LEFT JOIN village_building_stage as bs on pb.building_code = bs.room_code where  ";
		//筛选条件,有筛选日期
		if(!empty($effective_date)){
			$sql .= " pb.begin_date < '$effective_date' and pb.end_date > '$effective_date' ";
		}
		else{
			$sql .= " pb.begin_date < now() and pb.end_date > now() ";
		}
		//筛选残疾人
		if(!empty($if_disabled)){
			$sql .= " and p.if_disabled = true ";
		}
		//筛选出特殊年龄层次的人
		if(!empty($birth_begin)){
			$sql .= " and p.birth_date >= '$birth_begin' ";
		}
		if(!empty($birth_end)){
			$sql .= " and p.birth_date <= '$birth_end' ";
		}
		//筛选住户类型
		if(!empty($household_type)){
			$sql .= " and pb.household_type = $household_type ";
		}
		//搜索条件 1楼宇名称 2姓名 3 身份证号 4 手机号
		if(!empty($keyword)){
			$sql .= " and concat(room,immeuble,last_name,first_name,id_number,mobile_number) like '%$keyword%' ";
		}

		$sql=$sql." order by p.code asc limit ".$rows." offset ".$start;

		// echo $sql;exit;
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					if($k1=="gender"){
						foreach($gender_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["gender_name"] = $v2['name'];
						        break;
						    }
						}
					}
					if($k1=="begin_date"){
						$arr[$key]["begin_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					if($k1=="end_date"){
						$arr[$key]["end_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					if($k1=="birth_date"){
						$arr[$key]["birth_date"]=substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
						$arr[$key]["age"] = $this->calcAge($value);
					}
					if($k1=="household_type"){
						foreach($household_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["household_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//证件类型
					if($k1=="id_type"){
						foreach($id_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["id_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//血型
					if($k1=="blood_type"){
						foreach($blood_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["blood_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//民族
					if($k1=="ethnicity"){
						foreach($ethnicity_name_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["ethnicity_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//是否残疾
					if($k1=="if_disabled"){
						foreach($if_disabled_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["if_disabled_name"] = $v2['name'];
						        break;
						    }
						}
					}
				}
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;

	}

	public function getResidentListTotal($if_disabled,$birth_begin,$birth_end,$household_type,$effective_date,$keyword,$rows){
		$sql = "select count(*) as count from village_person_building as pb LEFT JOIN village_person as p on pb.person_code = p.code  LEFT JOIN village_building_stage as bs on pb.building_code = bs.room_code  where ";
		//筛选条件,有筛选日期
		if(!empty($effective_date)){
			$sql .= " pb.begin_date < '$effective_date' and pb.end_date > '$effective_date' ";
		}
		else{
			$sql .= " pb.begin_date < now() and pb.end_date > now() ";
		}
		//筛选残疾人
		if(!empty($if_disabled)){
			$sql .= " and p.if_disabled = true ";
		}
		//筛选出特殊年龄层次的人
		if(!empty($birth_begin)){
			$sql .= " and p.birth_date >= '$birth_begin' ";
		}
		if(!empty($birth_end)){
			$sql .= " and p.birth_date <= '$birth_end' ";
		}
		//筛选住户类型
		if(!empty($household_type)){
			$sql .= " and pb.household_type = $household_type ";
		}
		//搜索条件 1楼宇名称 2姓名 3 身份证号 4 手机号
		if(!empty($keyword)){
			$sql .= " and concat(room,immeuble,last_name,first_name,id_number,mobile_number) like '%$keyword%' ";
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

	public function getPeopleTotal($rows){
		$sql = "select count(*) as count from village_person";
		$limit = false;
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

	public function peopleListArray($data){
		$now = date('Y-m-d',time());
		$arr = array();
		$ethnicity_name_arr = $this->ethnicity_name_arr;
		$blood_type_arr = $this->blood_type_arr;
		$id_type_arr = $this->id_type_arr;
		$household_type_arr = $this->household_type_arr;
    	foreach ($data as $row) {
    		$item=array();
    		$item['full_name'] = $row['last_name'].$row['first_name'];
    		foreach ( $row as $key => $value){
    			if($key=='code')
    			{
    				$item["code"]=intval($value,10);
    			}
    			if($key=='id_number')
    			{
    				$item["id_number"]=$value;
    			}
    			if($key=='oth_mob_no')
    			{
    			    $item["oth_mob_no"]=$value;
    			}
    			if($key=='mobile_number')
    			{
    				$item["mobile_number"]=$value;
    			}
    			if($key=='building_code')
    			{
    			    $item["building_code"]=intval($value,10);
    			}
    			if($key=='person_code')
    			{
    			    $item["person_code"]=intval($value,10);
    			}
    			if($key=='gender')
    			{
    				$item['gender'] = intval($value,10);
    				if($value=='101'){
    					$item["gender_name"]="男";
    				}
    				else{
    					$item["gender_name"]="女";
    				}
    			}
    			if($key=='if_disabled')
    			{
    			    $item["if_disabled"]=$value;
    			    if($value=='f'){
    			    	$item["if_disabled_name"]="否";
    			    }
    			    else{
    			    	$item["if_disabled_name"]="是";
    			    }
    			}
    			if($key=='birth_date')
    			{
    				$item["birth_date"]= $value;
    				$item["age"] = $this->calcAge($value);
    			}
    			if($key=='begin_date')
    			{
    				$item["begin_date"]= substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
    			}
    			if($key=='end_date')
    			{
    			    $item["end_date"]= substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
    			}
    			if($key=='last_name')
    			{
    				$item["last_name"]= $value;
    			}
    			if($key=='first_name')
    			{
    				$item["first_name"]= $value;
    			}
    			if($key=='household_type')
    			{
    				$item["household_type"]= $value;
    			}
    			if($key=='nationality')
    			{
    				$item["nationality"]= $value;
    			}
    			if($key=='nationality')
    			{
    				$item["nationality"]= $value;
    			}
    			if($key=='remark')
    			{
    			    $item["remark"]= $value;
    			}
    			if($key=='ethnicity')
    			{
    				$item["ethnicity"]= intval($value,10);
    				foreach($ethnicity_name_arr as $key => $v){
    					if($value == $v['code']){
    						$item["ethnicity_name"] = $v['ethnicity_name'];
    						break;
    					}
    				}
    			}
    			if($key=='blood_type')
    			{
    				$item["blood_type"]= intval($value,10);
    				foreach($blood_type_arr as $key => $v){
    					if($value == $v['code']){
    						$item["blood_type_name"] = $v['name'];
    						break;
    					}
    				}
    			}
    			if($key=='id_type')
    			{
    				$item["id_type"]= intval($value,10);
    				foreach($id_type_arr as $key => $v){
    					if($value == $v['code']){
    						$item["id_type_name"] = $v['name'];
    						break;
    					}
    				}
    			}
    			if($key=='household_type')
    			{
    				$item["household_type"]= intval($value,10);
    				foreach($household_type_arr as $key => $v){
    					if($value == $v['code']){
    						$item["household_type_name"] = $v['name'];
    						break;
    					}
    				}
    			}

    		}
    		$arr[]=$item;
    	}
    	return $arr;
	}

	public function calcAge($birthday){
		$iage = 0;  
		if (!empty($birthday)) {  
		   $year = date('Y',strtotime($birthday));  
		   $month = date('m',strtotime($birthday));  
		   $day = date('d',strtotime($birthday));  
		     
		   $now_year = date('Y');  
		   $now_month = date('m');  
		   $now_day = date('d');  

		   if ($now_year > $year) {  
		       $iage = $now_year - $year - 1;  
		       if ($now_month > $month) {  
		           $iage++;  
		       } else if ($now_month == $month) {  
		           if ($now_day >= $day) {  
		               $iage++;  
		           }  
		       }  
		   }  
		}  
		return $iage; 
	}

	public function getPersonByName($name){
		$sql = "select last_name,first_name,id_number,code from village_person where concat(last_name,first_name) like '%$name%' order by code limit 10";
		$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$this->peopleListArray($q->result_array());
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function insertPersonBuilding($building_code,$begin_date,$end_date,$remark,$person_code,$household_type,$create_time){
		//先查出最新的code;
		$sql = " select code from village_person_building order by code desc";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if(empty($row['code'])){
			$code = '1000001';
		}
		else {
			$code = $row['code'] +1;
		}
		$insert_sql = "INSERT INTO village_person_building (code,building_code,person_code,begin_date,end_date,household_type,remark,create_time) values ($code,$building_code,$person_code,'$begin_date','$end_date',$household_type,'$remark','$create_time')";
		$this->db->query($insert_sql);
		return $this->db->affected_rows();
	}

	public function getBuildingByPersonCode($person_code,$building_code,$end_date){
		$result = array();
		$sql = "select building_code from village_person_building where person_code = $person_code and building_code != $building_code and end_date > '$end_date'";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getAllBuildingByPersonCode($person_code,$building_code,$end_date){
		$result = array();
		$sql = "select building_code from village_person_building where person_code = $person_code and  end_date > '$end_date'";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getBuildingNameByCode($code){
		$sql = "select code,name from village_building where code = $code limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if (isset($row)){
			return $row;
		}
		return false;
	}

	public function getPersonCodeByBuildingCode($building_code,$person_code){
		$sql = "select person_code from village_person_building where building_code = $building_code and person_code != $person_code";
		// echo $sql;
		// echo "<br />";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getPersonByCode($code){
		$sql = "select concat(last_name,first_name) as full_name,first_name,last_name,code from village_person where code = $code limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if (isset($row)){
			return $row;
		}
		return false;
	}

	public function getPositionName(){
		$sql = "select * from village_position a where effective_date = (SELECT MAX (effective_date) FROM village_position b WHERE A . NAME = b. NAME and b.effective_status = true) and a.effective_status = true ORDER BY a.code";
		$query = $this->db->query($sql);
		$row = $query->result_array();
		return $row;
	}

	public function insertPersonPosition($position_code,$person_code,$begin_date,$end_date,$employee_no,$hire_date,$territory,$remark){
		$now="'".date('Y-m-d H:i:s',time())."'";
		//先查出最新的code;
		$sql = " select code from village_person_position order by code desc";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if(empty($row['code'])){
			$code = '1000001';
		}
		else {
			$code = $row['code'] +1;
		}
		$insert_sql = "INSERT INTO village_person_position (code,position_code,person_code,begin_date,end_date,employee_no,hire_date,territory,remark,create_time) values (".
			$this->db->escape($code).", ".
			$this->db->escape($position_code).", ".
			$this->db->escape($person_code).", ".
			$this->db->escape($begin_date).", ".
			$this->db->escape($end_date).", ".
			$this->db->escape($employee_no).",".
			$this->db->escape($hire_date).", ".
			$this->db->escape($territory).", ".
			$this->db->escape($remark).", ".$now.")"
		;
		$this->db->query($insert_sql);
		return $this->db->affected_rows();
	}

	public function getPeoplePositionList($page,$rows,$keyword,$effective_date){
		$result = array();
		$start=($page-1) * $rows;
		$position_type_arr = $this->position_type_arr;
		$position_grade_arr = $this->position_grade_arr;
		$gender_arr=$this->gender_arr;
		$id_type_arr=$this->id_type_arr;
		$blood_type_arr=$this->blood_type_arr;
		$ethnicity_name_arr=$this->ethnicity_name_arr;
		$if_disabled_arr=$this->if_disabled_arr;
		//关联village_person_position和village_person两表,查出物业人员相关
		$sql = "select pp.position_code,pp.person_code,pp.hire_date,pp.employee_no,pp.territory,pp.begin_date,pp.end_date,pp.remark as position_remark,p.last_name,p.first_name,concat(p.last_name,p.first_name) as full_name,p.id_type,p.id_number,p.nationality,p.gender,P.birth_date,P.mobile_number,p.blood_type,p.oth_mob_no,p.if_disabled,p.ethnicity,p.remark as person_remark,ps.name,ps.effective_date,ps.position_type,ps.position_grade,ps.parent_code from village_person_position pp left join village_person p on pp.person_code = p.code";
		$sql .= " LEFT JOIN village_position ps on pp.position_code = ps.code";
		$sql .= " where ps.effective_date =(select max(effective_date) from village_position b where ps.name = b.name and ps.parent_code = b.parent_code and ps.position_grade = b.position_grade and ps.position_type = b.position_type and b.effective_status = true ) and ps.effective_status = true";
		//搜索条件
		if(!empty($keyword)){
			$sql .= " and concat (P .last_name, P .first_name,ps.name) like '%$keyword%' ";
		}
		//有日期传入的时候,表示入职日期应该小于当前日期
		if(!empty($effective_date)){
			$sql .= " and pp.hire_date < '$effective_date' ";
		}
		$sql=$sql." order by pp.create_time asc limit ".$rows." offset ".$start;
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//根据parent_code获得上一级职位的名称
				$parent_position = $this->getPositionByCode($row['parent_code']);
				$arr[$key]['position_parent_name'] = $parent_position['name'];
				//得到管理区域
				$this->load->model('Building_model');
				$territory_name = $this->Building_model->getBuildingByCode($row['territory']);
				$arr[$key]['territory_name'] = $territory_name['household'];
				//赋值中文名称
				foreach($row as $k1 => $value){
					if($k1=="gender"){
						foreach($gender_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["gender_name"] = $v2['name'];
						        break;
						    }
						}
					}
					if($k1=="hire_date"){
						$arr[$key]["hire_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					if($k1=="begin_date"){
						$arr[$key]["begin_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					if($k1=="end_date"){
						$arr[$key]["end_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					if($k1=="birth_date"){
						$arr[$key]["birth_date"]=substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
						$arr[$key]["age"] = $this->calcAge($value);
					}
					if($k1=="position_type"){
						foreach($position_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["position_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					if($k1=="position_grade"){
						foreach($position_grade_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["position_grade_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//证件类型
					if($k1=="id_type"){
						foreach($id_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["id_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//血型
					if($k1=="blood_type"){
						foreach($blood_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["blood_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//民族
					if($k1=="ethnicity"){
						foreach($ethnicity_name_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["ethnicity_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//是否残疾
					if($k1=="if_disabled"){
						foreach($if_disabled_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["if_disabled_name"] = $v2['name'];
						        break;
						    }
						}
					}
				}
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function getPeoplePositionListTotal($effective_date,$keyword,$rows){
		$sql = "select count(*) as count from village_person_position pp left join village_person p on pp.person_code = p.code";
		$sql .= " LEFT JOIN village_position ps on pp.position_code = ps.code";
		$sql .= " where ps.effective_date =(select max(effective_date) from village_position b where ps.name = b.name and ps.parent_code = b.parent_code and ps.position_grade = b.position_grade and ps.position_type = b.position_type and b.effective_status = true ) and ps.effective_status = true";
		//搜索条件
		if(!empty($keyword)){
			$sql .= " and concat (P .last_name, P .first_name,ps.name) like '%$keyword%' ";
		}
		//有日期传入的时候,表示入职日期应该小于当前日期
		if(!empty($effective_date)){
			$sql .= " and pp.hire_date < '$effective_date' ";
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

	public function getPositionByCode($code){
		//查出最近的有效记录
		$sql = "select * from village_position where code = '$code' order by effective_date desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		$res = $this->positionArray($row);
		return $res;
	}

	public function positionArray($data){
		$arr = array();
		$position_type_arr = $this->position_type_arr;
		$position_grade_arr = $this->position_grade_arr;
		$item=array();
		foreach ( $data as $key => $value) {
			if($key=='code')
			{
				$item["position_code"]=intval($value,10);
			}
			elseif($key=='effective_date')
			{
				$item["effective_date"]=substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
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
			}
			elseif($key=='name')
			{
				$item["name"]=$value;
			}
			elseif($key=='parent_code')
			{
				$item["parent_code"]=intval($value,10);
			}
            elseif($key=='id')
            {
                $item["id"]=intval($value,10);
            }
			elseif($key=='position_type')
			{
				$item["position_type"]=intval($value,10);
                foreach($position_type_arr as $key => $v){
                    if($value == $v['code']){
                        $item["position_type_name"] = $v['name'];
                        break;
                    }
                }
			}
			elseif($key=='position_grade')
			{
				$item["position_grade"]=intval($value,10);
                foreach($position_grade_arr as $key => $v){
                    if($value == $v['code']){
                        $item["position_grade_name"] = $v['name'];
                        break;
                    }
                }
			}
            
		}
		$arr=$item;
		return $arr;
	}

	public function getPersonPositionByCode($position_code){
		$sql = "select concat(p.last_name,p.first_name) as name,ps.name as position_name from village_person_position as pp left JOIN village_person as p on pp.person_code = p.code left JOIN village_position as ps on ps.code = pp.position_code where position_code = '$position_code' limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function getPersonPosition($person_code){
		$sql = "select * from village_person_position where person_code = '$person_code' and hire_date < now() and begin_date < now() and end_date > now()";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
	}
}
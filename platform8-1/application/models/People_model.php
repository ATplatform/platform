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
	    $this->business_type_arr=$this->config->item('business_type_arr');
	    $this->nationality_name_arr=$this->config->item('nationality_name_arr');
	}

	public function getPeopleCode($village_id){
		$sql = "select code from village_person where village_id = $village_id order by code desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['code'];
	}

	public function verifyIdcard($id_card,$village_id){
		$sql = "select id_number from village_person where id_number = '$id_card' and village_id = '$village_id' limit 1";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0 ){
			$res=$query->row_array();
			return $res['id_number'];
		}
		return false;
	}

	public function verifyPersonIdCard($code,$id_number,$village_id){
		$sql = "select id_number from village_person where id_number = '$id_number' and code != '$code' and village_id = '$village_id' limit 1";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0 ){
			$res=$query->row_array();
			return $res['id_number'];
		}
		return false;
	}

	public function verifyPersonMobile($code,$mobile_number,$village_id){
		$sql = "select mobile_number from village_person where mobile_number = '$mobile_number' and code != '$code' and village_id = '$village_id' limit 1";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0 ){
			$res=$query->row_array();
			return $res['mobile_number'];
		}
		return false;
	}

	public function insertPeople($code,$last_name,$first_name,$id_type,$id_number,$nationality,$gender,$birth_date,$if_disabled,$bloodtype,$ethnicity,$tel_country,$mobile_number,$oth_mob_no,$remark,$create_time,$village_id){
		if(is_null($if_disabled)||empty($if_disabled)){
			$if_disabled = 'false';
		}
		if(is_null($oth_mob_no)||empty($oth_mob_no)){
			$oth_mob_no = 'null';
		}
		$sql = "INSERT INTO village_person (code,last_name,first_name,id_type,id_number,nationality,gender,birth_date,if_disabled,blood_type,ethnicity,tel_country,mobile_number,oth_mob_no,remark,create_time,village_id) values ($code,'$last_name','$first_name',$id_type,'$id_number','$nationality',$gender,'$birth_date',$if_disabled,$bloodtype,$ethnicity,'$tel_country','$mobile_number',$oth_mob_no,'$remark','$create_time','$village_id')";
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function updatePeople($code,$last_name,$first_name,$id_type,$id_number,$nationality,$gender,$birth_date,$if_disabled,$bloodtype,$ethnicity,$tel_country,$mobile_number,$oth_mob_no,$remark,$village_id){
		if(is_null($if_disabled)||empty($if_disabled)){
			$if_disabled = 'false';
		}
		if(is_null($oth_mob_no)||empty($oth_mob_no)){
			$oth_mob_no = ' ';
		}
		$sql = "UPDATE village_person SET last_name = '$last_name',first_name = '$first_name',id_type = '$id_type',id_number = '$id_number',nationality = '$nationality',gender = '$gender',birth_date = '$birth_date',if_disabled = '$if_disabled',blood_type = '$bloodtype', ethnicity = '$ethnicity',tel_country = '$tel_country',mobile_number = '$mobile_number',oth_mob_no = '$oth_mob_no',remark = '$remark'  WHERE code = '$code' and village_id = '$village_id' ";
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function updatePersonBuilding($building_code,$person_code,$begin_date,$end_date){
		$sql = "UPDATE village_person_building SET end_date = '$end_date'  WHERE building_code = '$building_code' and person_code = '$person_code' and begin_date = '$begin_date' ";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getResidentList($building_code,$level,$if_disabled,$birth_begin,$birth_end,$household_type,$effective_date,$keyword,$page,$rows,$village_id){
		$gender_arr=$this->gender_arr;
		$id_type_arr=$this->id_type_arr;
		$blood_type_arr=$this->blood_type_arr;
		$ethnicity_name_arr=$this->ethnicity_name_arr;
		$if_disabled_arr=$this->if_disabled_arr;
		$household_type_arr=$this->household_type_arr;
		$nationality_name_arr=$this->nationality_name_arr;
		$start=($page-1) * $rows;
		//关联person_building\person\tmp_building表查出所有住户\楼栋信息
		$sql = "select *,concat(p.last_name,p.first_name) as full_name,pb.remark as pb_remark,bs.code as room_code from village_person_building as pb LEFT JOIN village_person as p on pb.person_code = p.code and pb.village_id = p.village_id LEFT JOIN village_tmp_building as bs on pb.building_code = bs.code and bs.village_id = pb.village_id  where pb.begin_date = (select max(begin_date) from village_person_building as b where  pb.building_code = b.building_code and pb.person_code = b.person_code  and b.begin_date <= now() ) ";
		//筛选条件,有筛选日期
		if(!empty($effective_date)){
			$sql .= " and pb.begin_date <= '$effective_date' and pb.end_date >= '$effective_date' ";
		}
		else{
			$sql .= "and pb.begin_date <= now() and pb.end_date >= now() ";
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
		//搜索条件 2姓名 3 身份证号 4 手机号
		if(isset($keyword)&&$keyword!=''){
			$sql .= " and concat(last_name,first_name,id_number,mobile_number) like '%$keyword%' ";
		}

		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and bs.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and bs.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and bs.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and bs.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and bs.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and bs.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and bs.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and bs.public = $building_code ";
			}
		}
		$sql .= " and pb.village_id = $village_id ";
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
					//国家
					if($k1=="nationality"){
						foreach($nationality_name_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["nationality_name"] = $v2['name'];
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
				//得到地点名称
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
	    if($row['level']==100){
	        $result=$result.$row['name'];
	    }              
	    return $result;
	}

	public function getResidentListTotal($building_code,$level,$if_disabled,$birth_begin,$birth_end,$household_type,$effective_date,$keyword,$rows,$village_id){
		$sql = "select count(*) as count from village_person_building as pb LEFT JOIN village_person as p on pb.person_code = p.code and pb.village_id = p.village_id  LEFT JOIN village_tmp_building as bs on pb.building_code = bs.code and pb.village_id = bs.village_id  where pb.begin_date = (select max(begin_date) from village_person_building as b where  pb.building_code = b.building_code and pb.person_code = b.person_code  and b.begin_date <= now() )  ";
		//筛选条件,有筛选日期
		if(!empty($effective_date)){
			$sql .= " and pb.begin_date <= '$effective_date' and pb.end_date >= '$effective_date' ";
		}
		else{
			$sql .= "and pb.begin_date <= now() and pb.end_date >= now() ";
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
		//搜索条件  2姓名 3 身份证号 4 手机号
		if(isset($keyword)&&$keyword!=''){
			$sql .= " and concat(last_name,first_name,id_number,mobile_number) like '%$keyword%' ";
		}

		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and bs.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and bs.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and bs.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and bs.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and bs.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and bs.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and bs.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and bs.public = $building_code ";
			}
		}
		$sql .= " and pb.village_id = $village_id ";
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

	public function getPersonByName($name,$village_id){
		$sql = "select last_name,first_name,id_number,code from village_person where concat(last_name,first_name) like '%$name%' and village_id = $village_id order by code limit 10";
		// echo $sql;exit;
		$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$this->peopleListArray($q->result_array());
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function insertPersonBuilding($village_id,$building_code,$begin_date,$end_date,$remark,$person_code,$household_type,$create_time){
		$today = date('Y-m-d',time());
		//先查出最新的code;
		$sql = " select code from village_person_building where village_id = $village_id order by code desc";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if(empty($row['code'])){
			$code = '1000001';
		}
		else {
			$code = $row['code'] +1;
		}
		if($end_date<=$today){
			$insert_sql = "INSERT INTO village_person_building_bak (village_id,code,building_code,person_code,begin_date,end_date,household_type,remark,create_time) values ($village_id,$code,$building_code,$person_code,'$begin_date','$end_date',$household_type,'$remark','$create_time')";
		}
		else{
			$insert_sql = "INSERT INTO village_person_building (village_id,code,building_code,person_code,begin_date,end_date,household_type,remark,create_time) values ($village_id,$code,$building_code,$person_code,'$begin_date','$end_date',$household_type,'$remark','$create_time')";
		}
		$this->db->query($insert_sql);
		return $this->db->affected_rows();
	}

	public function getBuildingByPersonCode($village_id,$person_code,$building_code,$end_date){
		$result = array();
		$sql = "select building_code from village_person_building a where begin_date = (select max(begin_date) from village_person_building b where a.building_code = b.building_code and a.person_code = b.person_code and a.household_type = b.household_type and b.begin_date <= now() ) and person_code = $person_code and building_code != $building_code and end_date >= '$end_date' and a.village_id = $village_id ";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getAllBuildingByPersonCode($village_id,$person_code,$building_code,$end_date){
		$result = array();
		$sql = "select building_code from village_person_building where person_code = $person_code and end_date >= '$end_date' and village_id = $village_id ";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getBuildingNameByCode($village_id,$code){
		$sql = "select * from village_tmp_building where code = $code and village_id = $village_id limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if (isset($row)){
			//得到地点名称
			$row["building_name"] = $this->getHouseholdInfo($row);
			return $row;
		}
		return false;
	}

	public function getPersonCodeByBuildingCode($village_id,$building_code,$person_code){
		$sql = "select person_code from village_person_building where building_code = $building_code and person_code != $person_code and village_id = $village_id ";
		// echo $sql;
		// echo "<br />";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getPersonByCode($code,$village_id){
		$sql = "select concat(last_name,first_name) as full_name,first_name,last_name,code from village_person where code = $code and village_id = $village_id limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if (isset($row)){
			return $row;
		}
		return false;
	}

	public function getPositionName($village_id){
		$sql = "select * from village_position a where effective_date = (SELECT MAX (effective_date) FROM village_position b WHERE A . NAME = b. NAME and b.effective_status = true and A.village_id = b. village_id ) and a.effective_status = true and a.village_id = $village_id ORDER BY a.code";
		$query = $this->db->query($sql);
		$row = $query->result_array();
		return $row;
	}

	public function insertPersonPosition($position_code,$village_id,$person_code,$begin_date,$end_date,$employee_no,$hire_date,$territory,$remark){
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
		$today = date('Y-m-d',time());
		if($end_date<=$today){
			$table_name = "village_person_position_bak"; 
		}
		else{
			$table_name = "village_person_position"; 
		}
		$insert_sql = "INSERT INTO $table_name (code,position_code,village_id,person_code,begin_date,end_date,employee_no,hire_date,territory,remark,create_time) values (".
			$this->db->escape($code).", ".
			$this->db->escape($position_code).", ".
			$this->db->escape($village_id).", ".
			$this->db->escape($person_code).", ".
			$this->db->escape($begin_date).", ".
			$this->db->escape($end_date).", ".
			$this->db->escape($employee_no).",".
			$this->db->escape($hire_date).", ".
			$this->db->escape($territory).", ".
			$this->db->escape($remark).", ".$now.")"
		;
		// echo $insert_sql;exit;
		$this->db->query($insert_sql);
		return $this->db->affected_rows();
	}

	public function getPeoplePositionList($page,$rows,$keyword,$effective_date,$village_id){
		$result = array();
		$start=($page-1) * $rows;
		$position_type_arr = $this->position_type_arr;
		$position_grade_arr = $this->position_grade_arr;
		$gender_arr=$this->gender_arr;
		$id_type_arr=$this->id_type_arr;
		$blood_type_arr=$this->blood_type_arr;
		$ethnicity_name_arr=$this->ethnicity_name_arr;
		$if_disabled_arr=$this->if_disabled_arr;
		$nationality_name_arr=$this->nationality_name_arr;
		//关联village_person_position和village_person两表,查出物业人员相关
		$sql = "select pp.code as pp_code,pp.position_code,pp.person_code,pp.hire_date,pp.employee_no,pp.territory,pp.begin_date,pp.end_date,pp.remark as position_remark,p.last_name,p.first_name,concat(p.last_name,p.first_name) as full_name,p.id_type,p.id_number,p.nationality,p.gender,P.birth_date,P.mobile_number,p.blood_type,p.oth_mob_no,p.if_disabled,p.ethnicity,p.remark as person_remark,ps.name,ps.effective_date,ps.position_type,ps.position_grade,ps.parent_code from village_person_position pp left join village_person p on pp.person_code = p.code and pp.village_id = p.village_id";
		$sql .= " LEFT JOIN village_position ps on pp.position_code = ps.code and pp.village_id = ps.village_id";
		$sql .= " where ps.effective_date =(select max(effective_date) from village_position b where ps.name = b.name and ps.parent_code = b.parent_code and ps.position_grade = b.position_grade and ps.position_type = b.position_type and b.effective_status = true and b.effective_date < now()) and ps.effective_status = true";
		//搜索条件
		if(isset($keyword)&&$keyword!=''){
			$sql .= " and concat (P .last_name, P .first_name,ps.name) like '%$keyword%' ";
		}
		//有日期传入的时候,表示入职日期应该小于当前日期
		if(!empty($effective_date)){
			$sql .= " and pp.village_id = '$village_id' ";
		}
		$sql .= " and pp.hire_date <= '$effective_date' ";
		$sql=$sql." order by pp.create_time asc limit ".$rows." offset ".$start;
		// echo $sql;exit;
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//根据parent_code获得上一级职位的名称
				$parent_position = $this->getPositionByCode($row['parent_code']);
				$arr[$key]['position_parent_name'] = $parent_position['name'];
				//得到管理区域
				$this->load->model('Building_model');
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
					//国家
					if($k1=="nationality"){
						foreach($nationality_name_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["nationality_name"] = $v2['name'];
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

	public function getPeoplePositionListTotal($effective_date,$keyword,$rows,$village_id){
		$sql = "select count(*) as count from village_person_position pp left join village_person p on pp.person_code = p.code  and p.village_id = pp.village_id ";
		$sql .= " LEFT JOIN village_position ps on pp.position_code = ps.code  and ps.village_id = pp.village_id ";
		$sql .= " where ps.effective_date =(select max(effective_date) from village_position b where ps.name = b.name and ps.parent_code = b.parent_code and ps.position_grade = b.position_grade and ps.position_type = b.position_type and b.effective_status = true and b.effective_date < now()) and ps.effective_status = true";
		//搜索条件
		if(isset($keyword)&&$keyword!=''){
			$sql .= " and concat (P .last_name, P .first_name,ps.name) like '%$keyword%' ";
		}
		// echo $sql;exit;
		//有日期传入的时候,表示入职日期应该小于当前日期
		if(!empty($effective_date)){
			$sql .= " and pp.hire_date <= '$effective_date' ";
		}
		$sql .= " and pp.village_id = '$village_id' ";
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
		// echo $sql;exit;
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

	public function getPersonPositionByCode($position_code,$village_id){
		$sql = "select concat(p.last_name,p.first_name) as name,ps.name as position_name from village_person_position as pp left JOIN village_person as p on pp.person_code = p.code and pp.village_id = p.village_id left JOIN village_position as ps on ps.code = pp.position_code and ps.village_id = pp.village_id where pp.position_code = '$position_code' and pp.village_id = $village_id limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function getPersonPosition($person_code){
		$sql = "select * from village_person_position p where begin_date = ( select max(begin_date) from village_person_position b where p.person_code = b.person_code and b.begin_date <= now()) and person_code = '$person_code' and hire_date <= now() and begin_date <= now() and end_date >= now() limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
	}

	public function insertPersonBiz($village_id,$building_code,$begin_date,$end_date,$biz_info,$remark,$person_code,$household_type,$create_time){
		$today = date('Y-m-d',time());
		//先查出最新的code;
		$sql = " select code from village_person_biz order by code desc";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if(empty($row['code'])){
			$code = '1000001';
		}
		else {
			$code = $row['code'] +1;
		}
		if($end_date<=$today){
			$insert_sql = "INSERT INTO village_person_biz_bak (village_id,code,building_code,person_code,begin_date,end_date,biz_type,biz_info,remark,create_time) values ($village_id,$code,$building_code,$person_code,'$begin_date','$end_date',$household_type,'$biz_info','$remark','$create_time')";
		}
		else{
			$insert_sql = "INSERT INTO village_person_biz (village_id,code,building_code,person_code,begin_date,end_date,biz_type,biz_info,remark,create_time) values ($village_id,$code,$building_code,$person_code,'$begin_date','$end_date',$household_type,'$biz_info','$remark','$create_time')";
		}
		// echo $insert_sql;exit;
		$this->db->query($insert_sql);
		return $this->db->affected_rows();
	}

	public function getBusinessList($village_id,$effective_date,$building_code,$level,$biz_type,$keyword,$page,$rows){
		$gender_arr=$this->gender_arr;
		$id_type_arr=$this->id_type_arr;
		$blood_type_arr=$this->blood_type_arr;
		$ethnicity_name_arr=$this->ethnicity_name_arr;
		$if_disabled_arr=$this->if_disabled_arr;
		$household_type_arr=$this->household_type_arr;
		$business_type_arr=$this->business_type_arr;
		$nationality_name_arr=$this->nationality_name_arr;
		$start=($page-1) * $rows;
		//关联person_biz\person\building_stage表查出所有商户\楼栋信息
		$sql = "SELECT *, concat (P .last_name, P .first_name) AS full_name,pb.remark AS pb_remark,p.remark as p_remark,pb.code as biz_code FROM village_person_biz AS pb LEFT JOIN village_person AS P ON pb.person_code = P .code and pb.village_id = p.village_id LEFT JOIN village_tmp_building AS bs ON pb.building_code = bs.code and pb.village_id = bs.village_id  WHERE ";
		//筛选条件,有筛选日期
		if(!empty($effective_date)){
			$sql .= " pb.begin_date <= '$effective_date' and pb.end_date >= '$effective_date' ";
		}
		else{
			$sql .= " pb.begin_date <= now() and pb.end_date >= now() ";
		}
		//筛选商户类型
		if(!empty($biz_type)){
			$sql .= " and pb.biz_type = $biz_type ";
		}

		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and bs.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and bs.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and bs.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and bs.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and bs.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and bs.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and bs.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and bs.public = $building_code ";
			}
		}

		//搜索条件 1楼宇名称 2姓名 3经营内容
		if(isset($keyword)&&$keyword!=''){
			$sql .= " and concat(bs.name,last_name,first_name,pb.biz_info) like '%$keyword%' ";
		}
		$sql=$sql." and pb.village_id = $village_id ";
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
					if($k1=="biz_type"){
						foreach($business_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["biz_type_name"] = $v2['name'];
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
					//国家
					if($k1=="nationality"){
						foreach($nationality_name_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["nationality_name"] = $v2['name'];
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
				//得到地点名称
				$arr[$key]["building_name"] = $this->getHouseholdInfo($row);
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}


	public function getBusinessListTotal($village_id,$effective_date,$biz_type,$building_code,$level,$keyword,$rows){
		$sql = "select count(*) as count FROM village_person_biz AS pb LEFT JOIN village_person AS P ON pb.person_code = P.code and p.village_id = pb.village_id LEFT JOIN village_tmp_building AS bs ON pb.building_code = bs.code and bs.village_id = pb.village_id  WHERE  ";

		//筛选条件,有筛选日期
		if(!empty($effective_date)){
			$sql .= " pb.begin_date <= '$effective_date' and pb.end_date >= '$effective_date' ";
		}
		else{
			$sql .= " pb.begin_date <= now() and pb.end_date >= now() ";
		}
		//筛选商户类型
		if(!empty($biz_type)){
			$sql .= " and pb.biz_type = $biz_type ";
		}

		//树形图筛选楼宇
		if(!empty($building_code)){
			if($level=='106'){
				$sql .= "  and bs.code = $building_code ";
			}
			// else if($level = '100') {
			// 	$sql .= " and bs.code = $building_code ";
			// }
			//期
			else if($level == '101'){
				$sql .= " and bs.stage = $building_code ";
			}
			//区
			else if($level == '102'){
				$sql .= " and bs.area = $building_code ";
			}
			//栋
			else if($level == '103'){
				$sql .= " and bs.immeuble = $building_code ";
			}
			//单元
			else if($level == '104'){
				$sql .= " and bs.unit = $building_code ";
			}
			//层
			else if($level == '105'){
				$sql .= " and bs.floor = $building_code ";
			}
			//公共设施
			else if($level == '107'){
				$sql .= " and bs.public = $building_code ";
			}
		}

		//搜索条件 1楼宇名称 2姓名 3经营内容
		if(isset($keyword)&&$keyword!=''){
			$sql .= " and concat(bs.name,last_name,first_name,pb.biz_info) like '%$keyword%' ";
		}
		$sql .= " and pb.village_id = $village_id ";
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

	public function updatePersonBiz($village_id,$biz_code,$end_date,$remark,$biz_info){
		$sql = "UPDATE village_person_biz SET end_date = '$end_date',biz_info = '$biz_info',remark = '$remark'  WHERE code = '$biz_code' and village_id = $village_id ";
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function updatePersonPosition($code,$end_date,$remark,$position_code,$village_id){
		$sql = "UPDATE village_person_position SET end_date = '$end_date',position_code = '$position_code',remark = '$remark'  WHERE code = '$code' and village_id = $village_id ";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getBizByPersonCode($person_code,$building_code,$end_date){
		$result = array();
		$sql = "select building_code from village_person_biz where person_code = $person_code and building_code != $building_code and end_date >= '$end_date'";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getAllBizByPersonCode($person_code,$building_code,$end_date){
		$result = array();
		$sql = "select building_code from village_person_biz where person_code = $person_code and  end_date >= '$end_date'";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getPersonCodeByBizCode($building_code,$person_code){
		$sql = "select person_code from village_person_biz where building_code = $building_code and person_code != $person_code";
		// echo $sql;
		// echo "<br />";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getBuildingByCode($code,$village_id){
	    $sql = "select * from village_tmp_building where code = '$code' and village_id = $village_id ";
	    // echo $sql;
	    // echo "<br />";
	    $query = $this->db->query($sql);
	    $row = $query->row_array();
	    return $row;
	}

	public function getVisitorList($village_id,$level,$push_start_date,$push_end_date,$equipment_type,$building_code,$keyword,$page,$rows){
		$start=($page-1) * $rows;
		$sql = " select b.stage_name,b.area_name,b.immeuble_name,b.unit_name,b.floor_name,b.room_name,b.public_name,v.name,v.mobile_number,v.person_code,v.apply_time,v.begin_date,v.end_date,v.licence,v.park_code,v.paid_by_inviter,concat(p.last_name,p.first_name) as full_name from village_visitor as v LEFT JOIN village_tmp_building as b on v.building_code = b.code and v.village_id = b.village_id left join village_person as p on v.person_code = p.code and v.village_id = p.village_id ";
		$sql .= " where v.village_id = '$village_id' and v.begin_date >= '$push_start_date' and end_date < '$push_end_date' ";
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
		//设备类型
		/*if(!empty($equipment_type)){
			$sql .= " and e.equipment_type = '$equipment_type' ";
		}*/
		if(!empty($keyword)){
			$sql .= " and concat(p.last_name,p.first_name,v.name) like '%$keyword%' ";
		}
		$sql=$sql." order by v.apply_time asc limit ".$rows." offset ".$start;
		// echo $sql;exit;
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					//得到邀约人姓名
					if($k1=="full_name"){
						if(!empty($value)){
							$arr[$key]["invite_person"] = $value;
						}
						else{
							$arr[$key]["invite_person"] = '';
						}
					}
					//得到停车场名称
					if($k1=="park_code"){
						$park = $this->getParkByCode($value,$village_id);
						if(!empty($park)){
							$arr[$key]["park_name"] = $park['parkname'];
						}
						else{
							$arr[$key]["park_name"] = '';
						}
					}
					//是否代缴车费
					if($k1=="paid_by_inviter"){
						if($value=='t'){
							$arr[$key]["paid_by_inviter_name"] = "是";
						}
						else{
							$arr[$key]["paid_by_inviter_name"] = "否";
						}
					}
				}
				//得到地点名称
				$arr[$key]["building_name"] = $this->getHouseholdInfo($row);
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function getVisitorListTotal($village_id,$level,$push_start_date,$push_end_date,$equipment_type,$building_code,$keyword,$rows){
		$sql = " select count(v.code) as count from village_visitor as v LEFT JOIN village_tmp_building as b on v.building_code = b.code and v.village_id = b.village_id left join village_person as p on v.person_code = p.code and v.village_id = p.village_id ";
		$sql .= " where v.village_id = '$village_id' and v.begin_date >= '$push_start_date' and end_date < '$push_end_date' ";
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
		//设备类型
		/*if(!empty($equipment_type)){
			$sql .= " and e.equipment_type = '$equipment_type' ";
		}*/
		if(!empty($keyword)){
			$sql .= " and concat(p.last_name,p.first_name,v.name) like '%$keyword%' ";
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

	public function getParkByCode($code,$village_id){
		$sql = "select * from village_park where parkcode = $code and village_code = $village_id limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if (isset($row)){
			return $row;
		}
		return false;
	}

	public function getPersonEquipment($person_code,$village_id,$end_date){
	    $sql = "select * from village_person_equipment where $person_code = any(person_code) and village_id = '$village_id' and end_date <= '$end_date' limit 1 ";
	    $query = $this->db->query($sql);
	    $row = $query->row_array();
	    return $row;
	}

	public function getPersonCard($person_code,$village_id,$end_date){
	    $sql = "select * from village_card_auz where person_code = '$person_code' and village_id = '$village_id' and end_date <= '$end_date' limit 1 ";
	    $query = $this->db->query($sql);
	    $row = $query->row_array();
	    return $row;
	}

	public function getPersonMaterial($person_code,$village_id,$end_date){
	    $sql = "select * from village_mtr_mgt where person_code = '$person_code' and mgt_status in (102,103) and village_id = '$village_id' and effective_date >= '$end_date' limit 1 ";
	    // echo $sql;exit;
	    $query = $this->db->query($sql);
	    $row = $query->row_array();
	    return $row;
	}


}
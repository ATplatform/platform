<?php
class People_model extends CI_model {
	public function __construct()
	{
		parent::__construct();
	    $this->load->database();
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
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getPeopleList($page,$rows){
		$start=($page-1) * $rows;
		//先从person_building表中查到所有数据
		$sql = "SELECT p_b.code,p_b.building_code,p_b.person_code,p_b.begin_date,p_b.end_date,p_b.household_type,p_b.remark,ps.last_name,ps.first_name,concat(ps.last_name,ps.first_name) as fullname,ps.id_type,ps.id_number,ps.mobile_number,ps.oth_mob_no,ps.birth_date,ps.if_disabled,ps.ethnicity,ps.gender,ps.nationality,ps.blood_type,bd. LEVEL as building_level,bd. NAME as building_name FROM village_person_building AS p_b LEFT JOIN village_person AS ps ON p_b.person_code = ps.code LEFT JOIN village_building AS bd ON p_b.building_code = bd.code";
		$sql=$sql." order by ps.code asc limit ".$rows." offset ".$start;

		// echo $sql;exit;
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			// $arr=$q->result_array();
			// //对数据循环,查到对应的房号\住户类别以及期\区\栋信息
			// foreach($arr as $key => $v){
			// 	print_r($v)."<br />";
			// 	echo "<br />";
			// }
			// exit;
			$arr=$this->peopleListArray($q->result_array());
			$json=json_encode($arr);
			return $json;
		}
		return false;

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
		$ethnicity_name_arr = array(array('code'=>'101','ethnicity_name'=>'汉族'),array('code'=>'102','ethnicity_name'=>'蒙古族'),array('code'=>'103','ethnicity_name'=>'回族'),array('code'=>'104','ethnicity_name'=>'藏族'),array('code'=>'105','ethnicity_name'=>'维吾尔族'),array('code'=>'106','ethnicity_name'=>'苗族'),array('code'=>'107','ethnicity_name'=>'彝族'),array('code'=>'108','ethnicity_name'=>'壮族'),array('code'=>'109','ethnicity_name'=>'布依族'),array('code'=>'110','ethnicity_name'=>'朝鲜族'),array('code'=>'111','ethnicity_name'=>'满族'),array('code'=>'112','ethnicity_name'=>'侗族'),array('code'=>'113','ethnicity_name'=>'瑶族'),array('code'=>'114','ethnicity_name'=>'白族'),array('code'=>'115','ethnicity_name'=>'土家族'),array('code'=>'116','ethnicity_name'=>'哈尼族'),array('code'=>'117','ethnicity_name'=>'哈萨克族'),array('code'=>'118','ethnicity_name'=>'傣族'),array('code'=>'119','ethnicity_name'=>'黎族'),array('code'=>'120','ethnicity_name'=>'僳僳族'),array('code'=>'121','ethnicity_name'=>'佤族'),array('code'=>'122','ethnicity_name'=>'畲族'),array('code'=>'123','ethnicity_name'=>'高山族'),array('code'=>'124','ethnicity_name'=>'拉祜族'),array('code'=>'125','ethnicity_name'=>'水族'),array('code'=>'126','ethnicity_name'=>'东乡族'),array('code'=>'127','ethnicity_name'=>'纳西族'),array('code'=>'128','ethnicity_name'=>'景颇族'),array('code'=>'129','ethnicity_name'=>'柯尔克孜族'),array('code'=>'130','ethnicity_name'=>'土族'),array('code'=>'131','ethnicity_name'=>'达斡尔族'),array('code'=>'132','ethnicity_name'=>'仫佬族'),array('code'=>'133','ethnicity_name'=>'羌族'),array('code'=>'134','ethnicity_name'=>'布朗族'),array('code'=>'135','ethnicity_name'=>'撒拉族'),array('code'=>'136','ethnicity_name'=>'毛南族'),array('code'=>'137','ethnicity_name'=>'仡佬族'),array('code'=>'138','ethnicity_name'=>'锡伯族'),array('code'=>'139','ethnicity_name'=>'阿昌族'),array('code'=>'140','ethnicity_name'=>'普米族'),array('code'=>'141','ethnicity_name'=>'塔吉克族'),array('code'=>'142','ethnicity_name'=>'怒族'),array('code'=>'143','ethnicity_name'=>'乌孜别克族'),array('code'=>'144','ethnicity_name'=>'俄罗斯族'),array('code'=>'145','ethnicity_name'=>'鄂温克族'),array('code'=>'146','ethnicity_name'=>'德昂族'),array('code'=>'147','ethnicity_name'=>'保安族'),array('code'=>'148','ethnicity_name'=>'裕固族'),array('code'=>'149','ethnicity_name'=>'京族'),array('code'=>'150','ethnicity_name'=>'塔塔尔族'),array('code'=>'151','ethnicity_name'=>'独龙族'),array('code'=>'152','ethnicity_name'=>'鄂伦春族'),array('code'=>'153','ethnicity_name'=>'赫哲族'),array('code'=>'154','ethnicity_name'=>'门巴族'),array('code'=>'155','ethnicity_name'=>'珞巴族'),array('code'=>'156','ethnicity_name'=>'基诺族'),array('code'=>'160','ethnicity_name'=>'其他'));
		$blood_type_arr = array(array('code'=>'101','name'=>'A型'),array('code'=>'102','name'=>'B型'),array('code'=>'103','name'=>'AB型'),array('code'=>'104','name'=>'O型'),array('code'=>'105','name'=>'其他'));
		$id_type_arr = array(array('code'=>'101','name'=>'身份证'),array('code'=>'102','name'=>'境外护照'),array('code'=>'103','name'=>'回乡证'),array('code'=>'104','name'=>'台胞证'),array('code'=>'105','name'=>'军官证/士兵证'));
		$household_type_arr = array(array('code'=>'101','name'=>'户主'),array('code'=>'102','name'=>'家庭成员'),array('code'=>'103','name'=>'访客'),array('code'=>'104','name'=>'租客'));
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
    				$item["id_number"]=intval($value,10);
    			}
    			if($key=='oth_mob_no')
    			{
    			    $item["oth_mob_no"]=intval($value,10);
    			}
    			if($key=='mobile_number')
    			{
    				$item["mobile_number"]=intval($value,10);
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
		// $sql = "select building_code from village_person_building where person_code = $person_code and  end_date > '$end_date'";
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

}
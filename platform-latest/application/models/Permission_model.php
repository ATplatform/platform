<?php
class Permission_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	    $this->load->database();
	}

	public function getLastAccessCardCode($village_id){
		$sql = "select code from village_card_auz where village_id = $village_id order by code desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['code'];
	}

	public function getLastAccessFaceidCode($village_id){
		$sql = "select code from village_faceid_auz where village_id = $village_id order by code desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['code'];
	}

	public function getPersonBuilding($code,$village_id){
		$sql = "select building_code from village_person_building where village_id = $village_id and person_code = $code and begin_date <= now() and end_date >= now() order by code desc";
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					if($k1=="building_code"){
						//根据building_code查出楼宇名称
						$building = $this->getBuilding($value,$village_id);
						//得到地点名称
						$arr[$key]["building_name"] = $this->getHouseholdInfo($building);
					}
				}
			}
			return $arr;
		}
		return false;
	}

	public function getPersonBiz($code,$village_id){
		$sql = "select building_code from village_person_biz where village_id = $village_id and person_code = $code and begin_date <= now() and end_date >= now() order by code desc";
		// echo $sql;exit;
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					if($k1=="building_code"){
						//根据building_code查出楼宇名称
						$building = $this->getBuilding($value,$village_id);
						//得到地点名称
						$arr[$key]["building_name"] = $this->getHouseholdInfo($building);
					}
				}
			}
			return $arr;
		}
		return false;
	}

	public function getPersonPositionTerritory($code,$village_id){
		$sql = "select territory from village_person_position where village_id = $village_id and person_code = $code and begin_date <= now() and end_date >= now() and hire_date <= now() order by code desc limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['territory'];

	}

	public function getBuilding($code,$village_id){
	    $sql = "select * from village_tmp_building where code = $code and village_id = $village_id limit 1";
	    $query = $this->db->query($sql);
	    $row = $query->row_array();
	    return $row;
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
	    if(!empty($row['level'])){
	    	if($row['level']==100){
	    		$result=$result.$row['name'];
	    	} 
	    }
	    return $result;
	}

	public function insertAccessCard($village_id,$code,$card_no,$person_code,$person_type,$building_code,$begin_date,$end_date){
		$now="'".date('Y-m-d H:i:s',time())."'";
		$insert_sql = "INSERT INTO village_card_auz (code,village_id,card_no,person_code,person_type,building_code,begin_date,end_date,create_time) values (".
			$this->db->escape($code).", ".
			$this->db->escape($village_id).", ".
			$this->db->escape($card_no).", ".
			$this->db->escape($person_code).", ".
			$this->db->escape($person_type).", ".
			$this->db->escape($building_code).", ".
			$this->db->escape($begin_date).",".
			$this->db->escape($end_date).", ".$now.")"
		;
		// echo $insert_sql;exit;
		$this->db->query($insert_sql);
		return $this->db->affected_rows();
	}

	public function getAccessCardByNo($village_id,$card_no){
		$sql = " select * from village_card_auz where village_id = $village_id and card_no = '$card_no' and begin_date <= now() and end_date > now() order by end_date desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if(!empty($row)){
			$row['end_date'] = substr($row['end_date'],0,4)."-".substr($row['end_date'],5,2)."-".substr($row['end_date'],8,2);
		}
		return $row;
	}

	public function getAccessCardList($village_id,$effective_date,$person_type,$building_code,$keyword,$page,$rows){
		$start=($page-1) * $rows;
		$sql = " select c.code,c.card_no,c.begin_date,c.end_date,c.person_code,c.building_code,c.person_type,concat(p.last_name,p.first_name) as full_name from village_card_auz as c left JOIN village_person as p on c.person_code = p.code and c.village_id = p.village_id where c.village_id = $village_id ";
		if(!empty($effective_date)){
			$sql .= " and c.begin_date <= '$effective_date' and c.end_date > '$effective_date' ";
		}
		else {
			$sql .= " and c.begin_date <= now() and c.end_date > now() ";
		}
		if(!empty($person_type)){
			$sql .= " and c.person_type = $person_type ";
		}
		//楼宇搜索
		if(!empty($building_code)){
			//转化成 array[1001]的形式
			$building_code = "array[".$building_code."]";
			$sql .= " and c.building_code &&  $building_code";
		}
		if(!empty($keyword)){
			$sql .= " and concat(c.card_no,p.last_name,p.first_name) like '%$keyword%' ";
		}
		$sql=$sql." order by c.code asc limit ".$rows." offset ".$start;
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
					//赋值用户类型中文名称
					if($k1=="person_type"){
						if($value=="101"){
							$arr[$key]["person_type_name"] = '业主';
						}
						if($value=="102"){
							$arr[$key]["person_type_name"] = '商户';
						}
						if($value=="103"){
							$arr[$key]["person_type_name"] = '物业人员';
						}
					}
					//根据building_code查出所有的楼宇地址
					if($k1=="building_code"){
						//去掉前后的大括号,并转换成数组形式
						$building_code = substr($value,0,strlen($value)-1);
						$building_code = substr($building_code,1);
						$building_code = explode(',',$building_code);
						$building_name = "";
						//查出中文名称
						foreach($building_code as $k2 => $v2){
							$building = $this->getBuilding($v2,$village_id);
							$household = $this->getHouseholdInfo($building);
							$building_name .= $household.",";
						}
						// echo $building_name;exit;
						$building_name = substr($building_name,0,strlen($building_name)-1);
						$arr[$key]['building_name'] = $building_name;
					}
				}
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;

	}

	public function getAccessCardListTotal($village_id,$effective_date,$person_type,$building_code,$keyword,$rows){
		$sql = " select count(c.code) as count from village_card_auz as c left JOIN village_person as p on c.person_code = p.code and c.village_id = p.village_id where c.village_id = $village_id ";
		if(!empty($effective_date)){
			$sql .= " and c.begin_date <= '$effective_date' and c.end_date > '$effective_date' ";
		}
		else {
			$sql .= " and c.begin_date <= now() and c.end_date > now() ";
		}
		if(!empty($person_type)){
			$sql .= " and c.person_type = $person_type ";
		}
		//楼宇搜索
		if(!empty($building_code)){
			//转化成 array[1001]的形式
			$building_code = "array[".$building_code."]";
			// echo $building_code;exit;
			$sql .= " and c.building_code &&  $building_code";
		}
		if(!empty($keyword)){
			$sql .= " and concat(c.card_no,p.last_name,p.first_name) like '%$keyword%' ";
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

	public function updateAccessCard($village_id,$code,$end_date){
		$sql = "update village_card_auz set end_date=".
		$this->db->escape($end_date)." where code =".
		$this->db->escape($code)." and village_id = ".
		$this->db->escape($village_id);
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getApplyFaceList($village_id,$effective_date,$person_type,$building_code,$keyword,$page,$rows){
		$start=($page-1) * $rows;
		$sql = " select f.code,f.person_code,f.source_type,f.building_code,f.person_type,f.begin_date,f.end_date,f.apply_date,f.pic,f.img_url,f.status,f.subject,f.pos,f.feat,concat(p.last_name,p.first_name) as full_name,p.id_number as p_id_number,p.mobile_number as p_mobile_number,concat (pp .last_name, pp .first_name) AS apply_person_name,pp.id_number AS apply_id_number,pp.mobile_number AS apply_mobile_number,f.apply_person from village_faceid_apply as f left JOIN village_person as p on p.code = f.person_code and p.village_id = f.village_id left join village_person as pp on pp.code = f.apply_person and pp.village_id = f.village_id where f.status = 101 ";
		if(!empty($effective_date)){
			$sql .= " and f.begin_date <= '$effective_date' and f.end_date > '$effective_date' ";
		}
		//楼宇搜索
		if(!empty($building_code)){
			//转化成 array[1001]的形式
			$building_code = "array[".$building_code."]";
			$sql .= " and f.building_code &&  $building_code";
		}
		if(!empty($keyword)){
			$sql .= " and concat(p.last_name,p.first_name) like '%$keyword%' ";
		}
		$sql=$sql." order by f.code asc limit ".$rows." offset ".$start;
		// echo $sql;exit;
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					if($k1=="begin_date"){
						$arr[$key]["begin_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					if($k1=="end_date"){
						$arr[$key]["end_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					if($k1=="apply_date"){
						$arr[$key]["apply_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					//赋值用户类型中文名称
					if($k1=="person_type"){
						if($value=="101"){
							$arr[$key]["person_type_name"] = '业主';
						}
						if($value=="102"){
							$arr[$key]["person_type_name"] = '商户';
						}
						if($value=="103"){
							$arr[$key]["person_type_name"] = '物业人员';
						}
					}
					//赋值状态名称
					if($k1=="status"){
						if($value=="101"){
							$arr[$key]["status_name"] = '申请中';
						}
						if($value=="102"){
							$arr[$key]["status_name"] = '已拒绝';
						}
						if($value=="103"){
							$arr[$key]["status_name"] = '已通过';
						}
					}
					//根据building_code查出所有的楼宇地址
					if($k1=="building_code"){
						//去掉前后的大括号,并转换成数组形式
						$building_code = substr($value,0,strlen($value)-1);
						$building_code = substr($building_code,1);
						$building_code = explode(',',$building_code);
						$building_name = "";
						$building_arr = array();
						//查出中文名称
						foreach($building_code as $k2 => $v2){
							$building = $this->getBuilding($v2,$village_id);
							$household = $this->getHouseholdInfo($building);
							$building_name .= $household.",";
							$building_single = array();
							$building_single = array('building_code'=>$v2,'building_name'=>$household);
							array_push($building_arr,$building_single);
						}
						// echo $building_name;exit;
						$building_name = substr($building_name,0,strlen($building_name)-1);
						$arr[$key]['building_name'] = $building_name;
						$arr[$key]['building_arr'] = $building_arr;
					}
				}
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;

	}

	public function getAccessFaceList($village_id,$effective_date,$person_type,$building_code,$keyword,$page,$rows){
		$start=($page-1) * $rows;
		$sql = " select f.code,f.person_code,f.source_type,f.building_code,f.person_type,f.begin_date,f.end_date,f.pic,f.img_url,f.subject,f.pos,f.feat,concat(p.last_name,p.first_name) as full_name,p.id_number as p_id_number,p.mobile_number as p_mobile_number,concat (pp .last_name, pp .first_name) AS apply_person_name,pp.id_number AS apply_id_number,pp.mobile_number AS apply_mobile_number,f.apply_person from village_faceid_auz as f left JOIN village_person as p on p.code = f.person_code and p.village_id = f.village_id left join village_person as pp on pp.code = f.apply_person and pp.village_id = f.village_id";
			$sql .= " where f.begin_date <= '$effective_date' and f.end_date > '$effective_date' ";
		//楼宇搜索
		if(!empty($building_code)){
			//转化成 array[1001]的形式
			$building_code = "array[".$building_code."]";
			$sql .= " and f.building_code &&  $building_code";
		}
		if(!empty($keyword)){
			$sql .= " and concat(p.last_name,p.first_name) like '%$keyword%' ";
		}
		$sql=$sql." order by f.code asc limit ".$rows." offset ".$start;
		// echo $sql;exit;
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					if($k1=="begin_date"){
						$arr[$key]["begin_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					if($k1=="end_date"){
						$arr[$key]["end_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					if($k1=="apply_date"){
						$arr[$key]["apply_date"] = substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
					}
					//赋值用户类型中文名称
					if($k1=="person_type"){
						if($value=="101"){
							$arr[$key]["person_type_name"] = '业主';
						}
						if($value=="102"){
							$arr[$key]["person_type_name"] = '商户';
						}
						if($value=="103"){
							$arr[$key]["person_type_name"] = '物业人员';
						}
					}
					//赋值状态名称
					if($k1=="source_type"){
						if($value=="101"){
							$arr[$key]["source_type_name"] = '用户手机申请';
						}
						if($value=="102"){
							$arr[$key]["source_type_name"] = '门口机集中录入';
						}
					}
					//根据building_code查出所有的楼宇地址
					if($k1=="building_code"){
						//去掉前后的大括号,并转换成数组形式
						$building_code = substr($value,0,strlen($value)-1);
						$building_code = substr($building_code,1);
						$building_code = explode(',',$building_code);
						$building_name = "";
						$building_arr = array();
						//查出中文名称
						foreach($building_code as $k2 => $v2){
							$building = $this->getBuilding($v2,$village_id);
							$household = $this->getHouseholdInfo($building);
							$building_name .= $household.",";
							$building_single = array();
							$building_single = array('building_code'=>$v2,'building_name'=>$household);
							array_push($building_arr,$building_single);
						}
						// echo $building_name;exit;
						$building_name = substr($building_name,0,strlen($building_name)-1);
						$arr[$key]['building_name'] = $building_name;
						$arr[$key]['building_arr'] = $building_arr;
					}
				}
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function insertAccessFace($village_id,$code,$face_apply_code,$apply_person,$person_code,$person_type,$building_code,$begin_date,$end_date,$source_type,$pic,$subject,$pos,$feat,$img_url){
		$now="'".date('Y-m-d H:i:s',time())."'";
		$insert_sql = "INSERT INTO village_faceid_auz (village_id,code,face_apply_code,apply_person,person_code,person_type,building_code,begin_date,end_date,source_type,pic,subject,pos,feat,img_url,create_time) values (".
			$this->db->escape($village_id).", ".
			$this->db->escape($code).", ".
			$this->db->escape($face_apply_code).", ".
			$this->db->escape($apply_person).", ".
			$this->db->escape($person_code).", ".
			$this->db->escape($person_type).", ".
			$this->db->escape($building_code).", ".
			$this->db->escape($begin_date).",".
			$this->db->escape($end_date).",".
			$this->db->escape($source_type).",".
			$this->db->escape($pic).",".
			$this->db->escape($subject).",".
			$this->db->escape($pos).",".
			$this->db->escape($feat).",".
			$this->db->escape($img_url).", ".$now.")"
		;
		// echo $insert_sql;exit;
		$this->db->query($insert_sql);
		return $this->db->affected_rows();
	}

	public function refuseApplyFace($village_id,$code,$reason,$status){
		$sql = " update village_faceid_apply set reason=".
		$this->db->escape($reason).", status=".
		$this->db->escape($status)." where code =".
		$this->db->escape($code)." and village_id = ".
		$this->db->escape($village_id);
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function updateAccessFace($village_id,$code,$building_code){
		$sql = " update village_faceid_auz set building_code=".
		$this->db->escape($building_code)." where code =".
		$this->db->escape($code)." and village_id = ".
		$this->db->escape($village_id);
		echo $sql;exit;
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

}
?>
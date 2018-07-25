<?php
class Message_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	    $this->load->database();
	    $this->msg_type_arr=$this->config->item('msg_type_arr');
	    $this->cycle_type_arr=$this->config->item('cycle_type_arr');
	    $this->push_state_arr=$this->config->item('msg_push_state');
	    $this->if_cycle_arr=$this->config->item('if_cycle_arr');
	}

	public function getMessageCode($village_id){
		$sql = "select code from village_Message where village_id = $village_id order by code desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['code'];
	}

	public function getUser($name){
		$sql = "select * from village_web_login where usr = '$name' limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}
	public function insertMessage($msg_type,$village_id,$target_type,$target,$if_cycle,$cycle_type,$if_bill,$bill_amount,$person_code,$if_receipt,$create_type,$create_ip,$msg_img,$msg_title,$link,$code,$push_end_date,$push_start_date){
		$now="'".date('Y-m-d H:i:s',time())."'";

		$insert_sql = "INSERT INTO village_message (msg_type,village_id,target_type,target,if_cycle,cycle_type,if_bill,bill_amount,person_code,if_receipt,create_type,create_ip,msg_img,msg_title,link,code,push_end_date,push_start_date,create_time) values (".
			$this->db->escape($msg_type).", ".
			$this->db->escape($village_id).", ".
			$this->db->escape($target_type).", ".
			$this->db->escape($target).", ".
			$this->db->escape($if_cycle).", ".
			$this->db->escape($cycle_type).", ".
			$this->db->escape($if_bill).",".
			$this->db->escape($bill_amount).", ".
			$this->db->escape($person_code).", ".
			$this->db->escape($if_receipt).", ".
			$this->db->escape($create_type).", ".
			$this->db->escape($create_ip).", ".
			$this->db->escape($msg_img).", ".
			$this->db->escape($msg_title).", ".
			$this->db->escape($link).", ".
			$this->db->escape($code).", ".
			$this->db->escape($push_end_date).", ".
			$this->db->escape($push_start_date).", ".$now.")"
		;
		// echo $insert_sql;exit;
		$this->db->query($insert_sql);
		return $this->db->affected_rows();
	}

	public function getMessageList($village_id,$push_start_date,$push_end_date,$msg_type,$cycle_type,$keyword,$page,$rows){
		$msg_type_arr=$this->msg_type_arr;
		$cycle_type_arr=$this->cycle_type_arr;
		$if_cycle_arr=$this->if_cycle_arr;
		$start=($page-1) * $rows;
		$sql = "SELECT msg.code,msg.village_id,msg_type,target_type,target,if_cycle,cycle_type,if_bill,bill_amount,person_code,if_receipt,create_type,create_ip,msg_img,msg_title,link,push_end_date,push_start_date FROM village_message as msg LEFT JOIN  village_tmp_building as b on b.code = any(msg.target)  and b.village_id = msg.village_id ";

		if(!empty($msg_type))
		{
			$sql=$sql." where msg_type=".$msg_type;
			$limit=true;
		}
		if($limit===true)
		{
			if(!empty($cycle_type))
			{
				$sql=$sql." and if_cycle=".$cycle_type;
				$limit=true;
			}
		}
		else 
		{
			if(!empty($cycle_type))
			{
				$sql=$sql." where if_cycle=".$cycle_type;
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(isset($keyword)&&$keyword!='')
			{
				$sql=$sql." and msg_title like '%$keyword%'";
				$limit=true;
			}
		}
		else 
		{
			if(isset($keyword)&&$keyword!='')
			{
				$sql=$sql." where msg_title like '%$keyword%'";
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(!empty($push_start_date))
			{
				$sql=$sql." and push_start_date  >= '$push_start_date' ";
				$limit=true;
			}
		}
		else 
		{
			if(!empty($push_start_date))
			{
				$sql=$sql." where push_start_date  >= '$push_start_date'";
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(!empty($push_end_date))
			{
				$sql=$sql." and push_start_date  <= '$push_end_date' ";
				$limit=true;
			}
		}
		else 
		{
			if(!empty($push_end_date))
			{
				$sql=$sql." where push_start_date  <= '$push_end_date'";
				$limit=true;
			}
		}
		if($limit===true)
		{
			$sql=$sql." and msg.village_id = '$village_id' ";
			$limit=true;
		}
		else 
		{
			$sql=$sql." where msg.village_id = '$village_id' ";
			$limit=true;
		}

		$sql=$sql." GROUP BY msg.code,msg.village_id,msg_type,target_type,target,if_cycle,cycle_type,if_bill,bill_amount,person_code,if_receipt,create_type,create_ip,msg_img,msg_title,link,push_end_date,push_start_date ";

		$sql=$sql." order by msg.code asc limit ".$rows." offset ".$start;
		// echo $sql;exit;
		$q = $this->db->query($sql); //自动转义
		if($q->num_rows() > 0 ){
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					//循环类型
					if($k1=="cycle_type"){
						foreach($cycle_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["cycle_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//消息类型
					if($k1=="msg_type"){
						foreach($msg_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["msg_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					if($k1=="if_bill"){
						if($value=="0"){
							$arr[$key]["if_bill_name"] = '否';
						}
						else{
							$arr[$key]["if_bill_name"] = '是';
						}
					}
					if($k1=="if_receipt"){
						if($value=="0"){
							$arr[$key]["if_receipt_name"] = '不需要';
						}
						else{
							$arr[$key]["if_receipt_name"] = '需要';
						}
					}
					//消息循环类型
					if($k1=="if_cycle"){
						foreach($if_cycle_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["if_cycle_name"] = $v2['name'];
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

	public function getMessageListTotal($village_id,$push_start_date,$push_end_date,$msg_type,$cycle_type,$keyword,$rows){
		$sql = "select count(msg.code) as count from village_message as msg LEFT JOIN  village_tmp_building as b on b.code = any(msg.target)  and b.village_id = msg.village_id  ";
		if(!empty($msg_type))
		{
			$sql=$sql." where msg_type=".$msg_type;
			$limit=true;
		}
		if($limit===true)
		{
			if(!empty($cycle_type))
			{
				$sql=$sql." and if_cycle=".$cycle_type;
				$limit=true;
			}
		}
		else 
		{
			if(!empty($cycle_type))
			{
				$sql=$sql." where if_cycle=".$cycle_type;
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(isset($keyword)&&$keyword!='')
			{
				$sql=$sql." and msg_title like '%$keyword%'";
				$limit=true;
			}
		}
		else 
		{
			if(isset($keyword)&&$keyword!='')
			{
				$sql=$sql." where msg_title like '%$keyword%'";
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(!empty($push_start_date))
			{
				$sql=$sql." and push_start_date  >= '$push_start_date' ";
				$limit=true;
			}
		}
		else 
		{
			if(!empty($push_start_date))
			{
				$sql=$sql." where push_start_date  >= '$push_start_date'";
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(!empty($push_end_date))
			{
				$sql=$sql." and push_start_date  <= '$push_end_date' ";
				$limit=true;
			}
		}
		else 
		{
			if(!empty($push_end_date))
			{
				$sql=$sql." where push_start_date  <= '$push_end_date'";
				$limit=true;
			}
		}
		if($limit===true)
		{

			$sql=$sql." and msg.village_id = '$village_id' ";
			$limit=true;
		}
		else 
		{
			$sql=$sql." where msg.village_id = '$village_id'";
			$limit=true;
		}
		$sql=$sql." GROUP BY msg.code ";
		// echo $sql;exit;
		$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
		    $row = $q->result_array();
		    $i=0;
		    //根据结果得到实际的条数
		    foreach($row as $key => $v){
		    	$i++;
		    }
		    $items=$i;
		    
		    if($items%$rows!=0)
		    {
		        $total=(int)((int)$items/$rows)+1;
		    }
		    else {
		        $total=$items/$rows;
		    }
		    // echo $total;exit;
		    return $total;
		} 
		return 0;
	}

	public function updateMessage($code,$push_end_date,$village_id){
		$sql = "UPDATE village_message SET push_end_date = '$push_end_date' WHERE code = '$code' and village_id = $village_id ";
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getMessageRecordList($village_id,$if_has_receipt,$push_state,$push_start_date,$push_end_date,$msg_type,$if_cycle,$keyword,$page,$rows){
		$msg_type_arr=$this->msg_type_arr;
		$cycle_type_arr=$this->cycle_type_arr;
		$if_cycle_arr=$this->if_cycle_arr;
		$push_state_arr=$this->push_state_arr;
		$start=($page-1) * $rows;
		$sql = "select msg_r.code,msg_r.village_id,msg_code,msg_r.target_type,equipment_id,mobile,push_time,push_state,receipt_time,first_read_time,last_read_time,read_times,msg_r.create_time,msg_type,msg_r.target_type AS r_target_type,target,if_cycle,cycle_type,if_bill,bill_amount,person_code,if_receipt,create_type,create_ip,msg_img,msg_title,msg_txt,link,push_end_date,push_start_date,b.code as building_code,msg_r.building_code as push_building_code from village_msg_record as msg_r LEFT JOIN village_message as msg on msg_r.msg_code = msg.code  and msg_r.village_id = msg.village_id LEFT JOIN village_tmp_building AS b ON b.code = ANY (msg.target) and msg_r.village_id = b.village_id LEFT JOIN village_equipment AS e ON e.code = msg_r.equipment_id AND msg_r.village_id = e.village_id ";
		$sql .= " where msg_r.push_time >= '$push_start_date' and msg_r.push_time <= '$push_end_date' ";
		if(!empty($msg_type)){
			$sql .= " and msg.msg_type =".$msg_type;
		}
		if(!empty($if_cycle)){
			$sql .= " and msg.if_cycle =".$if_cycle;
		}
		if(isset($keyword)&&$keyword!=''){
			$sql .= " and msg_title like '%$keyword%' ";
		}
		if(!empty($push_state)){
			$sql .= " and msg_r.push_state =".$push_state;
		}
		//表示已经回执
		if($if_has_receipt=="101"){
			$sql .= " and msg_r.receipt_time is not null ";
		}
		$sql .= " and msg_r.village_id =".$village_id;
		$sql=$sql." GROUP BY msg_r.code,msg_r.village_id,msg_code,msg_r.target_type,equipment_id,mobile,push_time,push_state,receipt_time,first_read_time,last_read_time,read_times,msg_r.create_time,msg_type,msg_r.target_type,target,if_cycle,cycle_type,if_bill,bill_amount,person_code,if_receipt,create_type,create_ip,msg_img,msg_title,msg_txt,link,push_end_date,push_start_date,b.code";
		$sql=$sql." order by msg_code asc limit ".$rows." offset ".$start;
		// echo $sql;exit;
		$q = $this->db->query($sql); //自动转义
		if($q->num_rows() > 0 ){
			$arr=$q->result_array();
			foreach($arr as $key => $row){
				//赋值中文名称
				foreach($row as $k1 => $value){
					//分割出推送时间
					if($k1=="push_time"){
						$push_time = $value;
						if(!empty($value)){
							$push_time = explode('.',$value);
							$push_time = $push_time[0];
						}
						$arr[$key]["push_time"] = $push_time;
					}
					//分割出首次阅读时间
					if($k1=="first_read_time"){
						$first_read_time = $value;
						if(!empty($value)){
							$first_read_time = explode('.',$value);
							$first_read_time = $first_read_time[0];
						}
						$arr[$key]["first_read_time"] = $first_read_time;
					}
					//分割出上次阅读时间
					if($k1=="last_read_time"){
						$last_read_time = $value;
						if(!empty($value)){
							$last_read_time = explode('.',$last_read_time);
							$last_read_time = $last_read_time[0];
						}
						$arr[$key]["last_read_time"] = $last_read_time;
					}
					//消息循环类型
					if($k1=="if_cycle"){
						foreach($if_cycle_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["if_cycle_name"] = $v2['name'];
						        break;
						    }
						}
					}
					//消息类型
					if($k1=="msg_type"){
						foreach($msg_type_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["msg_type_name"] = $v2['name'];
						        break;
						    }
						}
					}
					if($k1=="if_bill"){
						if($value=="0"){
							$arr[$key]["if_bill_name"] = '否';
						}
						else{
							$arr[$key]["if_bill_name"] = '是';
						}
					}
					if($k1=="if_receipt"){
						if($value=="0"){
							$arr[$key]["if_receipt_name"] = '不需要';
						}
						else{
							$arr[$key]["if_receipt_name"] = '需要';
						}
					}
					//推送状态
					if($k1=="push_state"){
						foreach($push_state_arr as $k2 => $v2){
						    if($value == $v2['code']){
						        $arr[$key]["push_state_name"] = $v2['name'];
						        break;
						    }
						}
					}
				}
				//根据每条数据的equipment_id\mobile查出对应的设备\人员
				if(!empty($row['equipment_id'])){
					//根据equipment_id查出设备名称
					$equipment = $this->getEquipmentByCode($row['equipment_id'],$village_id);
					$equipment_name = $equipment['name'];
					$arr[$key]['equipment_name']=$equipment_name;
				}
				if(!empty($row['mobile'])){
					//根据手机号查出人员信息
					$person = $this->getPersonByMobile($row['mobile'],$village_id);
					$equipment_name = $person['full_name'];
					$arr[$key]['equipment_name']=$equipment_name;
				}
				//根据每条数据的building_code查出推送地址(期/区/栋/单元/层/室)
				if(!empty($row['building_code'])){
					$buildings =$this->getBuildingByCode($row['building_code'],$village_id);
					$household = $this->getHouseholdInfo($buildings);
					$arr[$key]['household']=$household;
				}
				//根据push_building_code查出设备关联的楼宇地址
				if(!empty($row['push_building_code'])){
					$push_building =$this->getBuildingByCode($row['push_building_code'],$village_id);
					$push_household = $this->getHouseholdInfo($push_building);
					$arr[$key]['push_household']=$push_household;
				}
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function getEquipmentByCode($code,$village_id){
		$sql = " select name,village_id,building_code from village_equipment e where e.code = '$code' and effective_status = true  and village_id = $village_id limit 1";
		$query = $this->db->query($sql); //自动转义
		$row = $query->row_array();
		return $row;
	}

	public function getBuildingByCode($code,$village_id){
		$sql = "select * from village_tmp_building where code = $code and village_id = $village_id limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function getPersonByMobile($mobile,$village_id){
		$sql = "select code,concat(last_name,first_name) as full_name from village_person where mobile_number = '$mobile' and village_id = $village_id limit 1";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
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

	public function getMessageRecordListTotal($village_id,$if_has_receipt,$push_state,$push_start_date,$push_end_date,$msg_type,$if_cycle,$keyword,$rows){
		$sql = "select count(msg_r.code) as count from village_msg_record as msg_r LEFT JOIN village_message as msg on msg_r.msg_code = msg.code AND msg_r.village_id = msg.village_id LEFT JOIN village_tmp_building AS b ON b.code = ANY (msg.target) AND msg_r.village_id = b.village_id LEFT JOIN village_equipment AS e ON e.code = msg_r.equipment_id AND msg_r.village_id = e.village_id ";
		$sql .= " where msg_r.push_time >= '$push_start_date' and msg_r.push_time <= '$push_end_date' ";

		if(!empty($msg_type)){
			$sql .= " and msg.msg_type =".$msg_type;
		}
		if(!empty($if_cycle)){
			$sql .= " and msg.if_cycle =".$if_cycle;
		}
		if(isset($keyword)&&$keyword!=''){
			$sql .= " and msg_title like '%$keyword%' ";
		}
		if(!empty($push_state)){
			$sql .= " and msg_r.push_state =".$push_state;
		}
		//表示已经回执
		if($if_has_receipt=="101"){
			$sql .= " and msg_r.receipt_time is not null ";
		}
		$sql .= " and msg_r.village_id =".$village_id;
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
}
?>
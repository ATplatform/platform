<?php
class Message_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	    $this->load->database();
	    $this->msg_type_arr=$this->config->item('msg_type_arr');
	    $this->cycle_type_arr=$this->config->item('cycle_type_arr');
	    $this->push_state_arr=$this->config->item('msg_push_state');
	}

	public function getMessageCode(){
		$sql = "select code from village_Message order by code desc limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['code'];
	}

	public function getUser($name){
		$sql = "select * from admin_login where name = '$name' limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}
	public function insertMessage($msg_type,$target_type,$target,$if_cycle,$cycle_type,$if_bill,$bill_amount,$person_code,$if_receipt,$create_type,$create_ip,$msg_img,$msg_title,$link,$code,$push_end_date,$push_start_date){
		$now="'".date('Y-m-d H:i:s',time())."'";

		$insert_sql = "INSERT INTO village_message (msg_type,target_type,target,if_cycle,cycle_type,if_bill,bill_amount,person_code,if_receipt,create_type,create_ip,msg_img,msg_title,link,code,push_end_date,push_start_date,create_time) values (".
			$this->db->escape($msg_type).", ".
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

	public function getMessageList($push_start_date,$push_end_date,$msg_type,$cycle_type,$keyword,$page,$rows){
		$msg_type_arr=$this->msg_type_arr;
		$cycle_type_arr=$this->cycle_type_arr;
		$start=($page-1) * $rows;
		$sql = "SELECT code,msg_type,target_type,target,if_cycle,cycle_type,if_bill,bill_amount,person_code,if_receipt,create_type,create_ip,msg_img,msg_title,link,push_end_date,push_start_date FROM village_message as msg LEFT JOIN  village_tmp_building as b on b.room_code = any(msg.target) ";

		if(!empty($msg_type)>0)
		{
			$sql=$sql." where msg_type=".$msg_type;
			$limit=true;
		}
		if($limit===true)
		{
			if(!empty($cycle_type)>0)
			{
				$sql=$sql." and cycle_type=".$cycle_type;
				$limit=true;
			}
		}
		else 
		{
			if(!empty($cycle_type)>0)
			{
				$sql=$sql." where cycle_type=".$cycle_type;
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(!empty($keyword)>0)
			{
				$sql=$sql." and concat(msg_title,stage,area,immeuble,unit,floor,room) like '%$keyword%'";
				$limit=true;
			}
		}
		else 
		{
			if(!empty($keyword)>0)
			{
				$sql=$sql." where concat(msg_title,stage,area,immeuble,unit,floor,room) like '%$keyword%'";
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(!empty($push_start_date)>0)
			{
				$sql=$sql." and push_start_date  >= '$push_start_date' ";
				$limit=true;
			}
		}
		else 
		{
			if(!empty($push_start_date)>0)
			{
				$sql=$sql." where push_start_date  >= '$push_start_date'";
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(!empty($push_end_date)>0)
			{
				$sql=$sql." and push_start_date  <= '$push_end_date' ";
				$limit=true;
			}
		}
		else 
		{
			if(!empty($push_end_date)>0)
			{
				$sql=$sql." where push_start_date  <= '$push_end_date'";
				$limit=true;
			}
		}

		$sql=$sql." GROUP BY code ";

		$sql=$sql." order by code asc limit ".$rows." offset ".$start;
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
				}
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function getMessageListTotal($push_start_date,$push_end_date,$msg_type,$cycle_type,$keyword,$rows){
		$sql = "select count(code) as count from village_message as msg LEFT JOIN  village_tmp_building as b on b.room_code = any(msg.target)   ";
		if(!empty($msg_type)>0)
		{
			$sql=$sql." where msg_type=".$msg_type;
			$limit=true;
		}
		if($limit===true)
		{
			if(!empty($cycle_type)>0)
			{
				$sql=$sql." and cycle_type=".$cycle_type;
				$limit=true;
			}
		}
		else 
		{
			if(!empty($cycle_type)>0)
			{
				$sql=$sql." where cycle_type=".$cycle_type;
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(!empty($keyword)>0)
			{
				$sql=$sql." and concat(msg_title,stage,area,immeuble,unit,floor,room) like '%$keyword%'";
				$limit=true;
			}
		}
		else 
		{
			if(!empty($keyword)>0)
			{
				$sql=$sql." where concat(msg_title,stage,area,immeuble,unit,floor,room) like '%$keyword%'";
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(!empty($push_start_date)>0)
			{
				$sql=$sql." and push_start_date  >= '$push_start_date' ";
				$limit=true;
			}
		}
		else 
		{
			if(!empty($push_start_date)>0)
			{
				$sql=$sql." where push_start_date  >= '$push_start_date'";
				$limit=true;
			}
		}
		if($limit===true)
		{
			if(!empty($push_end_date)>0)
			{
				$sql=$sql." and push_start_date  <= '$push_end_date' ";
				$limit=true;
			}
		}
		else 
		{
			if(!empty($push_end_date)>0)
			{
				$sql=$sql." where push_start_date  <= '$push_end_date'";
				$limit=true;
			}
		}
		$sql=$sql." GROUP BY code ";
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

	public function updateMessage($code,$push_end_date){
		$sql = "UPDATE village_message SET push_end_date = '$push_end_date' WHERE code = '$code' ";
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getMessageRecordList($if_has_receipt,$push_state,$push_start_date,$push_end_date,$msg_type,$cycle_type,$keyword,$page,$rows){
		$msg_type_arr=$this->msg_type_arr;
		$cycle_type_arr=$this->cycle_type_arr;
		$push_state_arr=$this->push_state_arr;
		$start=($page-1) * $rows;
		$sql = "select * from village_msg_record as msg_r LEFT JOIN village_message as msg on msg_r.msg_code = msg.code ";
		$sql .= " where msg_r.push_time >= '$push_start_date' and msg_r.push_time <= '$push_end_date' ";
		if(!empty($msg_type)){
			$sql .= " and msg.msg_type =".$msg_type;
		}
		if(!empty($cycle_type)){
			$sql .= " and msg.cycle_type =".$cycle_type;
		}
		if(!empty($keyword)){
			$sql .= " and msg.msg_title like '%$keyword%' ";
		}
		if(!empty($push_state)){
			$sql .= " and msg_r.push_state =".$push_state;
		}
		//表示已经回执
		if($if_has_receipt=="101"){
			$sql .= " and msg_r.receipt_time != null and msg.if_receipt = 1 ";
		}
		$sql=$sql." order by msg_code asc limit ".$rows." offset ".$start;
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
			}
			$json=json_encode($arr);
			return $json;
		}
		return false;
	}

	public function getMessageRecordListTotal($if_has_receipt,$push_state,$push_start_date,$push_end_date,$msg_type,$cycle_type,$keyword,$rows){
		$sql = "select count(*) as count from village_msg_record as msg_r LEFT JOIN village_message as msg on msg_r.msg_code = msg.code ";
		$sql .= " where msg_r.push_time >= '$push_start_date' and msg_r.push_time <= '$push_end_date' ";

		if(!empty($msg_type)){
			$sql .= " and msg.msg_type =".$msg_type;
		}
		if(!empty($cycle_type)){
			$sql .= " and msg.cycle_type =".$cycle_type;
		}
		if(!empty($keyword)){
			$sql .= " and msg.msg_title like '%$keyword%' ";
		}
		if(!empty($push_state)){
			$sql .= " and msg_r.push_state =".$push_state;
		}
		//表示已经回执
		if($if_has_receipt=="101"){
			$sql .= " and msg_r.receipt_time != null and msg.if_receipt = 1 ";
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
}
?>
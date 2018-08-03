<?php
//require_once './include/Overtrue/Pinyin/Pinyin.php';
// require_once APPPATH.'/libraries/include/Overtrue/Pinyin/Pinyin.php';
include(APPPATH.'/libraries/include/phpqrcode/qrlib.php'); 

// use \Overtrue\Pinyin\Pinyin;
// Pinyin::set('delimiter', '');//全局
// Pinyin::set('accent', false);//全局


class Import_model extends CI_Model {
	function __construct(){

	}
	
	
	public function importPersonData($data){
		// print_r($data);exit;
		$i=0;
		$res = '';
		$has_insert_data = false;
		foreach ($data as $row){
			$i++;
			//先检验这条数据的合法性
			$judge = $this->judgePersonLegal($row);
			//有一个字段不符合,就退出,不写入数据
			if($judge==true){
				$res .= "第".$i."条数据有误"."<br />";
			}
			else {
				$if_has_person=$this->getAllperson($row['code'],$row['id_number'],$row['mobile_number'],$_SESSION['village_id']);
				//表示数据表里已经有这条数据,则退出,不再写入数据
				if(!empty($if_has_person)){
					$res .= "第".$i."条数据有误"."<br />";
				}
				//表示写入数据
				else {
					$now = date('Y-m-d H:i:s',time());
					// print_r($row);exit; 
					//将出生日期转换格式
					//写入数据
					$if_insert = $this->insertPeople($row['code'],$row['last_name'],$row['first_name'],$row['id_type'],$row['id_number'],$row['nationality'],$row['gender'],$row['birth_date'],$row['if_disabled'],$row['blood_type'],$row['ethnicity'],$row['tel_country'],$row['mobile_number'],$row['oth_mob_no'],$row['remark'],$now,$_SESSION['village_id']);
					if($if_insert==true){
						$has_insert_data = true;
					}
				}
			}
		}
		if($has_insert_data == true){
			$res .= "数据写入成功"."<br />";
		}
		return $res; 
	}

	public function getAllperson($code,$id_number,$mobile_number,$village_id){
		$sql="select * from village_person where code = '$code' or id_number = '$id_number' or mobile_number = '$mobile_number' and village_id = $village_id limit 1";
    	$query = $this->db->query($sql);
    	$row = $query->row_array();
    	return $row;
	}

	public function judgePersonLegal($row){
		if(empty($row['code'])||empty($row['last_name'])||empty($row['first_name'])||empty($row['last_name'])||empty($row['id_type'])||empty($row['id_number'])||empty($row['nationality'])||empty($row['gender'])||empty($row['birth_date'])||empty($row['blood_type'])||empty($row['ethnicity'])||empty($row['tel_country'])||empty($row['mobile_number'])){
			return true;
		}
		if(strlen($row['id_number'])>18||strlen($row['mobile_number'])>11){
			return true;
		}
		if(!is_numeric($row['code'])||!is_numeric($row['id_type'])||!is_numeric($row['nationality'])||!is_numeric($row['gender'])||!is_numeric($row['blood_type'])||!is_numeric($row['ethnicity'])||!is_numeric($row['mobile_number'])){
			return true;
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

	public function importPersonBuildingData($data){
		// print_r($data);exit;
		$i=0;
		$res = '';
		$has_insert_data = false;
		foreach ($data as $row){
			$i++;
			//先检验这条数据的合法性
			$judge = $this->judgePersonBuildingLegal($row);
			//有一个字段不符合,就退出,不写入数据
			if($judge==true){
				$res .= "第".$i."条数据有误"."<br />";
			}
			else {
				$if_has_person=$this->getAllpersonBuilding($row['code'],$_SESSION['village_id'],$row['end_date']);
				//表示数据表里已经有这条数据,则退出,不再写入数据
				if(!empty($if_has_person)){
					$res .= "第".$i."条数据有误"."<br />";
				}
				//写入数据
				else {
					$now = date('Y-m-d H:i:s',time());
					//写入数据
					$if_insert = $this->insertPersonBuilding($_SESSION['village_id'],$row['code'],$row['building_code'],$row['person_code'],$row['begin_date'],$row['end_date'],$row['remark'],$row['household_type'],$now);
					if($if_insert==true){
						$has_insert_data = true;
					}
				}
			}
		}
		if($has_insert_data == true){
			$res .= "数据写入成功"."<br />";
		}
		return $res; 
	}

	public function judgePersonBuildingLegal($row){
		if(empty($row['code'])||empty($row['building_code'])||empty($row['person_code'])||empty($row['begin_date'])||empty($row['end_date'])||empty($row['household_type'])){
			return true;
		}
		if($row['begin_date']>$row['end_date']){
			return true;
		}
		if(!is_numeric($row['code'])||!is_numeric($row['building_code'])||!is_numeric($row['person_code'])||!is_numeric($row['household_type'])){
			return true;
		}
		return false;
	}

	public function getAllpersonBuilding($code,$village_id,$end_date){
		$today = date('Y-m-d',time());
		$if_today_b_enddate = $this->dateBDate($today, $end_date);
		if($if_today_b_enddate==true){
			$sql="select * from village_person_building_bak where code = '$code' and village_id = $village_id limit 1";
		}
		else{
			$sql="select * from village_person_building where code = '$code' and village_id = $village_id limit 1";
		}
    	$query = $this->db->query($sql);
    	$row = $query->row_array();
    	return $row;
	}

	public function insertPersonBuilding($village_id,$code,$building_code,$person_code,$begin_date,$end_date,$remark,$household_type,$create_time){
		$today = date('Y-m-d',time());
		$if_today_b_enddate = $this->dateBDate($today, $end_date);
		if($if_today_b_enddate==true){
			$insert_sql = "INSERT INTO village_person_building_bak (village_id,code,building_code,person_code,begin_date,end_date,household_type,remark,create_time) values ($village_id,$code,$building_code,$person_code,'$begin_date','$end_date',$household_type,'$remark','$create_time')";
		}
		else{
			$insert_sql = "INSERT INTO village_person_building (village_id,code,building_code,person_code,begin_date,end_date,household_type,remark,create_time) values ($village_id,$code,$building_code,$person_code,'$begin_date','$end_date',$household_type,'$remark','$create_time')";
		}
		$this->db->query($insert_sql);
		return $this->db->affected_rows();
	}

	// 日期1是否大于等于日期2
	function dateBDate($date1, $date2){
		$month1 = date("m", strtotime($date1));
		$month2 = date("m", strtotime($date2));
		$day1 = date("d", strtotime($date1));
		$day2 = date("d", strtotime($date2));
		$year1 = date("Y", strtotime($date1));
		$year2 = date("Y", strtotime($date2));
		$from = mktime(0, 0, 0, $month1, $day1, $year1);
		$to = mktime(0, 0, 0, $month2, $day2, $year2);
		if($from >= $to){
			return true;
		} 
		else{
			return false;
		} 
	} 

	public function importPersonBizData($data){
		// print_r($data);exit;
		$i=0;
		$res = '';
		$has_insert_data = false;
		foreach ($data as $row){
			$i++;
			//先检验这条数据的合法性
			$judge = $this->judgePersonBizLegal($row);
			//有一个字段不符合,就退出,不写入数据
			if($judge==true){
				$res .= "第".$i."条数据有误"."<br />";
			}
			else {
				$if_has_person=$this->getAllpersonBiz($row['code'],$_SESSION['village_id'],$row['end_date']);
				//表示数据表里已经有这条数据,则退出,不再写入数据
				if(!empty($if_has_person)){
					$res .= "第".$i."条数据有误"."<br />";
				}
				//写入数据
				else {
					$now = date('Y-m-d H:i:s',time());
					//写入数据
					$if_insert = $this->insertPersonBiz($_SESSION['village_id'],$row['code'],$row['building_code'],$row['person_code'],$row['begin_date'],$row['end_date'],$row['remark'],$row['biz_type'],$row['biz_info'],$now);
					if($if_insert==true){
						$has_insert_data = true;
					}
				}
			}
		}
		if($has_insert_data == true){
			$res .= "数据写入成功"."<br />";
		}
		return $res; 
	}

	public function judgePersonBizLegal($row){
		if(empty($row['code'])||empty($row['building_code'])||empty($row['person_code'])||empty($row['begin_date'])||empty($row['end_date'])||empty($row['biz_type'])){
			return true;
		}
		if($row['begin_date']>$row['end_date']){
			return true;
		}
		if(!is_numeric($row['code'])||!is_numeric($row['building_code'])||!is_numeric($row['person_code'])||!is_numeric($row['biz_type'])){
			return true;
		}
		return false;
	}

	public function getAllpersonBiz($code,$village_id,$end_date){
		$today = date('Y-m-d',time());
		$if_today_b_enddate = $this->dateBDate($today, $end_date);
		if($if_today_b_enddate==true){
			$sql="select * from village_person_biz_bak where code = '$code' and village_id = $village_id limit 1";
		}
		else{
			$sql="select * from village_person_biz where code = '$code' and village_id = $village_id limit 1";
		}
		// echo $sql;exit;
    	$query = $this->db->query($sql);
    	$row = $query->row_array();
    	return $row;
	}

	public function insertPersonBiz($village_id,$code,$building_code,$person_code,$begin_date,$end_date,$remark,$biz_type,$biz_info,$create_time){
		$today = date('Y-m-d',time());
		$if_today_b_enddate = $this->dateBDate($today, $end_date);
		if($if_today_b_enddate==true){
			$insert_sql = "INSERT INTO village_person_biz_bak (village_id,code,building_code,person_code,begin_date,end_date,biz_type,biz_info,remark,create_time) values ($village_id,$code,$building_code,$person_code,'$begin_date','$end_date',$biz_type,'$biz_info','$remark','$create_time')";
		}
		else{
			$insert_sql = "INSERT INTO village_person_biz (village_id,code,building_code,person_code,begin_date,end_date,biz_type,biz_info,remark,create_time) values ($village_id,$code,$building_code,$person_code,'$begin_date','$end_date',$biz_type,'$biz_info','$remark','$create_time')";
		}
		// echo $insert_sql;exit;
		$this->db->query($insert_sql);
		return $this->db->affected_rows();
	}


	public function importBuildingData($data){
		// print_r($data);exit;
		$i=0;
		$res = '';
		$has_insert_data = false;
		foreach ($data as $row){
			$i++;
			//先检验这条数据的合法性
			$judge = $this->judgeBuildingLegal($row);
			//有一个字段不符合,就退出,不写入数据
			if($judge==true){
				$res .= "第".$i."条数据有误"."<br />";
			}
			else {
				$if_has_person=$this->getValidBuilding($row['code'],$_SESSION['village_id'],$row['effective_date'],$row['effective_status']);
				//表示数据表里已经有这条数据,则退出,不再写入数据
				if(!empty($if_has_person)){
					$res .= "第".$i."条数据有误"."<br />";
				}
				//写入数据
				else {
					// print_r($row);exit;
					// echo $_SESSION['person_code'];exit;
					$now = date('Y-m-d H:i:s',time());
					//写入数据
					$if_insert = $this->insertBuilding($_SESSION['village_id'],$row['code'],$row['effective_date'],$row['effective_status'],$row['name'],$row['level'],$row['rank'],$row['parent_code'],$row['building_type'],$row['floor_area'],$row['inside_area'],$row['remark'],$now);
					if($if_insert==true){
						$has_insert_data = true;
					}
				}

			}
		}
		if($has_insert_data == true){
			$res .= "数据写入成功";
		}
		return $res; 
	}

	public function judgeBuildingLegal($row){
		if(empty($row['code'])||empty($row['name'])||empty($row['effective_status'])||empty($row['effective_date'])||empty($row['level'])||empty($row['rank'])||empty($row['parent_code'])){
			return true;
		}
		//楼宇层级只能是100-107之间的数字
		if($row['level']<100||$row['level']>107){
			return true;
		}
		//如果楼宇层级是106(室),则必须填写楼宇建筑面积\楼宇套内面积\产权类型
		if($row['level']=='106'){
			if(empty($row['floor_area'])||empty($row['inside_area'])||empty($row['building_type'])){
				return true;
			}
			//面积最多两位小数
			if(!preg_match('/^[0-9]+(.[0-9]{1,2})?$/',$row['floor_area'])){
				return true;
			}
			if(!preg_match('/^[0-9]+(.[0-9]{1,2})?$/',$row['inside_area'])){
				return true;
			}
			if($row['floor_area']<$row['inside_area']){
				return true;
			}
		}
		//楼宇层级是105(层),顺序号可以是负数,其它情况下不能是负数
		if($row['level']!=='105'){
			if($row['rank']<0){
				return true;
			}
		}
		if(!is_numeric($row['code'])||!is_numeric($row['level'])||!is_numeric($row['parent_code'])){
			return true;
		}
		return false;
	}

	public function getValidBuilding($code,$village_id,$effective_date,$effective_status){
		if($effective_status==101){
			$effective_status='true';
		}
		else{
			$effective_status='false';
		}
		$sql="select * from village_building where code = '$code' and effective_date = '$effective_date' and effective_status = $effective_status and village_id = $village_id limit 1";
		// echo $sql;exit;
    	$query = $this->db->query($sql);
    	$row = $query->row_array();
    	return $row;
	}

	public function insertBuilding($village_id,$code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$building_type,$floor_area,$inside_area,$remark,$now){
		$create_person = $_SESSION['person_code'];
		$update_person = $_SESSION['person_code'];
		$create_time = $now;
		$update_time = $now;
		if($effective_status==101){
			$effective_status='true';
		}
		else{
			$effective_status='false';
		}
		if($level!==106){
			$building_type = 'null';
			$floor_area = 'null';
			$inside_area = 'null';
		}
        $sql = "INSERT INTO village_building (village_id,code,effective_date,effective_status,name,level,rank,parent_code,building_type,floor_area,inside_area,remark,create_time,update_time,create_person,update_person) values ($village_id,$code,'$effective_date',$effective_status,'$name',$level,$rank,$parent_code,$building_type,$floor_area,$inside_area,'$remark','$create_time','$update_time','$create_person','$update_person')";
        // echo $sql;exit;
	    $query = $this->db->query($sql);
	    return $this->db->affected_rows();
	}


    public function importWaterFeeData($data){
        // print_r($data);exit;
        $i=0;
        $res = '';
        $has_insert_data = false;
        foreach ($data as $row){
            $i++;
            //先检验这条数据的合法性
            $judge = $this->judgeWaterFeeLegal($row);
            //有一个字段不符合,就退出,不写入数据
            if($judge==true){
                $res .= "第".$i."条数据有误"."<br />";
            }
            else {
           /*     $if_has_person=$this->getAllWaterFee($row['code'],$_SESSION['village_id'],$row['end_date']);
                //表示数据表里已经有这条数据,则退出,不再写入数据
                if(!empty($if_has_person)){
                    $res .= "第".$i."条数据有误"."<br />";
                }
                //写入数据
                else {*/
               $code=$this->getlatestwatercode($_SESSION['village_id']);
               $code=intval($code['code'], 10)+1;
               $building_name=$this->getbuilding_name($row['building_code'],$_SESSION['village_id']);
               $rank=$this->getrank($row['building_code'],$_SESSION['village_id']);
               $standard=$this->getstandard($_SESSION['village_id']);



                    //写入数据
                    $if_insert = $this->insertWaterFee($_SESSION['village_id'],$code,$row['building_code'],$building_name,$rank['rank'],$row['month'],$row['water_csp'],$standard['fee_standard']);
                    if($if_insert==true){
                        $has_insert_data = true;
                    }
             /*   }*/
            }
        }
        if($has_insert_data == true){
            $res .= "数据写入成功"."<br />";
        }
        return $res;
    }




    public function getlatestwatercode($village_id){
	    $sql="select code  from village_water_list  where village_id=$village_id order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function getstandard($village_id){
        $sql="select fee_standard  from village_water_fee  where change_date=(select max(change_date) from village_water_fee where change_date<now()) and village_id=$village_id";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function getrank($building_code,$village_id){
        $sql="select rank from village_building where code=$building_code and village_id=$village_id and id=(select max(id) from village_building A where A.code=$building_code and A.village_id=$village_id)";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function getbuilding_name($building_code,$village_id){
        $sql="select * from village_tmp_building where village_id=$village_id and code=$building_code";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $arr = $query->result_array();
            foreach ($arr as $key => $value) {
                $res = $this->getHouseholdInfo($value);
            }
        }
        return $res;
    }






    public function judgeWaterFeeLegal($row){
        if(empty($row['building_code'])){
            return true;
        }

     /*   if(!is_numeric($row['code'])||!is_numeric($row['building_code'])||!is_numeric($row['rank'])||!is_numeric($row['water_csp'])){
            return true;
        }*/
        return false;
    }

    public function getAllWaterFee($code,$village_id,$end_date){
        $today = date('Y-m-d',time());
        $if_today_b_enddate = $this->dateBDate($today, $end_date);
        if($if_today_b_enddate==true){
            $sql="select * from village_person_biz_bak where code = '$code' and village_id = $village_id limit 1";
        }
        else{
            $sql="select * from village_person_biz where code = '$code' and village_id = $village_id limit 1";
        }
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
}
/*$_SESSION['village_id'],$row['code'],$row['building_code'],$row['building_name'],$row['rank'],$row['month'],$row['water_csp']*/
    public function insertWaterFee($village_id,$code,$building_code,$building_name,$rank,$month,$water_csp,$standard){
        $n = intval(($month - 25569) * 3600 * 24); //转换成1970年以来的秒数
        $month= gmdate('Y-m-d H:i:s', $n);//格式化时间

        $insert_sql = " INSERT INTO village_water_list (village_id,code,building_code,building_name,rank,month,water_csp,standard) values (".
            $this->db->escape($village_id).", ".
            $this->db->escape($code).", ".
            $this->db->escape($building_code).", ".
            $this->db->escape($building_name).", ".
            $this->db->escape($rank).", ".
            $this->db->escape($month).", ".
            $this->db->escape($water_csp).",".
            $this->db->escape($standard).") ";


        $this->db->query($insert_sql);


        return $this->db->affected_rows();
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
}


<?php
class Parkrent_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->brand_arr=$this->config->item('brand_arr');
    }


    ///////////////////////////////////获取数据////////////////////////////////////
    /////////////数据内容////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    /////////////数据数目////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    public function sqlTogetList($rent_end_date,$parklot_parkcode,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());

         /////////////////判断为普通查询或搜索查询////////////////////////////
         if (empty($rent_end_date) && empty($parklot_parkcode) &&  empty($keyword))

         /////////////////////////普通查询sql语句/////////////////////////
         {
             $sql = "  select 
  rent.id as rent_iD,
  parklot.parkcode as parklot_parkcode,
  park.parkname as parklot_parkcode_name,
  parklot.floor as parklot_floor,
  rent.parking_lot_code as rent_parking_lot_code,
  rent.renter as rent_renter,
  rent.rent as rent_rent,
  rent.pay_type as rent_pay_type,
  rent.begin_date as rent_begin_date,
  rent.end_date as rent_end_date,
  p.first_name,
  p.last_name
 from village_park_rent as rent
 left join village_parking_lot as parklot on rent.parking_lot_code=parklot.code
 left join village_park as park on parklot.parkcode=park.parkcode
 left join village_person as p on rent.renter=p.code
  where rent.renter=p.code
";}



         /////////////////////////搜索查询sql语句/////////////////////////
         else {
             $sql = "
             select 
  rent.id as rent_iD,
  parklot.parkcode as parklot_parkcode,
  park.parkname as parklot_parkcode_name,
  parklot.floor as parklot_floor,
  rent.parking_lot_code as rent_parking_lot_code,
  rent.renter as rent_renter,
  rent.rent as rent_rent,
  rent.pay_type as rent_pay_type,
  rent.begin_date as rent_begin_date,
  rent.end_date as rent_end_date,
  p.first_name,
  p.last_name
 from village_park_rent as rent
 left join village_parking_lot as parklot on rent.parking_lot_code=parklot.code
 left join village_park as park on parklot.parkcode=park.parkcode
 left join village_person as p on rent.renter=p.code
 where rent.renter=p.code
";
         }
             if(empty($rent_end_date)){
                 $sql .= " and rent.end_date >= '$now' ";
             }
            if(!empty($rent_end_date)){
                 $sql .= " and rent.end_date>='$rent_end_date' ";
             }

          /*   if(!empty($building_code)){
                 $sql .= " and (pb.building_code=$building_code or tmp.parent_code=$parent_code) ";
             }*/

             if(!empty($parklot_parkcode)){
                 $sql .= " and parklot.parkcode='$parklot_parkcode' ";
             }



               if (!empty($keyword)) {
                   if (preg_match('/^[\x7f-\xff]*\w*\d*$/', $keyword)) {
                       $sql .= " and concat (p.last_name,p.first_name,rent.parking_lot_code) like '%$keyword%'";
                   }

               }




        $sqlshow = $sql . " ORDER BY rent.id ASC limit ".$rows." offset ".$start;
        $arrayres=array($sql,$sqlshow);
        return $arrayres;
    }


    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getList( $sql){
        $brand_arr = $this->brand_arr;
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "rent_pay_type") {
                        if ($value2 == "101") {$arr[$key]['rent_pay_type_name'] = '年缴';}
                        if ($value2 == "102") {$arr[$key]['rent_pay_type_name'] = '半年缴';}
                        if ($value2 == "103") {$arr[$key]['rent_pay_type_name'] = '月缴';}
                    }
                    if ($key2 == 'parklot_floor') {
                        if ($value2 == "101") {
                            $arr[$key]['parklot_floor_name'] = '地面';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['parklot_floor_name'] = '地下一层';
                        }
                    }
                    if ($key2 == 'rent_parking_lot_code') {
                        $arr[$key]['rent_parking_lot_code_name'] =$value2;
                    }

                /*    if ($key2 == "parklot_parkcode") {
                        $arr[$key]['parklot_parkcode_name'] = '地下一层';
                    }*/
                    if ($key2 == 'rent_begin_date') {
                        $arr[$key]["rent_begin_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                    }
                    if ($key2 == 'rent_end_date') {
                        $arr[$key]["rent_end_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                    }

                    if($key2 == 'rent_renter'){
                        if(!empty($value['rent_renter']) ) {

                            $arr[$key]['rent_renter_name'] = "";

                            $person = $this->getPersonByCode($value2);
                            $name = $person['full_name'];
                            $arr[$key]['rent_renter_name'] = $name;
                        }

                    }

                }
            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }


    //////////////////////搜索查询数据数目的数据总条数/////////////
    public function getTotal($sqlorigin, $rows)
    {
        $sql="select count(*) as count from (";
        $sql.=$sqlorigin;
        $sql.=" ) as sss";
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $row = $q->row_array();
            $items = $row["count"];

            if ($items % $rows != 0) {
                $total = (int)((int)$items / $rows) + 1;
            } else {
                $total = $items / $rows;
            }
            return $total;
        }
        return 0;
    }



    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getRecord( $sql){
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "a_code") {
                        $arr[$key][$key2] = intval($value2, 10);
                    }
                    if ($key2 == "a_type") {
                        if ($value2 == "101") {$arr[$key]['a_type_name'] = '成年人活动';}
                        if ($value2 == "102") {$arr[$key]['a_type_name'] = '长者活动';}
                        if ($value2 == "103") {$arr[$key]['a_type_name'] = '儿童活动';}
                        if ($value2 == "104") {$arr[$key]['a_type_name'] = '其他活动';}
                    }
                    if ($key2 == "a_name") {
                        $arr[$key][$key2]=$value2;
                    }
                    if ($key2 == 'date') {
                        $arr[$key]["date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }

                    if ($key2 == 'rcd_service_code'){
                        $person= $this->getPersonByCode($value2);
                        $arr[$key]["rcd_service_name"]=$person['full_name'];
                    }
                    if($key2 == 'rcd_person_code'){
                        if(!empty($value['rcd_person_code']) ){
                            $person_code_str = $value['rcd_person_code'];
                            //去掉person_code前的括号并转化成数组形式
                            $person_code_str = substr($person_code_str,1);
                            $person_code_str = substr($person_code_str,0,strlen($person_code_str)-1);
                            $person_code_arr = explode(",", $person_code_str);
                            $arr[$key]['person_code_str'] = $person_code_arr;
                            $arr[$key]['rcd_person_name'] = "";
                            $arr[$key]['person_name_arr'] = array();

                            //根据拼接成的结果查出所有的人名
                            foreach($person_code_arr as $k2 => $v2){
                                $person = $this->getPersonByCode($v2);
                                $name = $person['full_name'];
                                $arr[$key]['rcd_person_name'] .= $name.";";
                            }
                        }

                    }
                    /* if ($key2 == 'process_pic'){
                         $value2=json_decode($value2,true);
                         var_dump($value2);
                       //  $arr[$key]['process_pic_http']=$value2[0];
                     }*/
                }
            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }




    //////////////////////////////////一些辅助功能///////////////////////////////////
public function getparking_lot_code($floor,$parkcode){
    $sql = "select code,floor from village_parking_lot where parkcode=$parkcode and floor=$floor ";
    $query = $this->db->query($sql);
    $row = $query->result_array();
    return $row;
}



    //动态获取所有楼宇信息
    public function getMaterialBuildingCode()
    {
        $sql = "select code,name from village_building GROUP BY code,name order by code";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }


  ///////////////////获取用户名/////////////
    public function getUserName($username)
  {
        $sql = "select name from admin_login where name='$username'";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            $arr = $q->row_array();
            $json = json_encode($arr);
            return $json;
        }
    }

  /////////获得协同人与管家信息/////////////
public function getOrderRecordPerson($team_person_code,$property_person_code)
{
        $sql="select p1.code as team_person_code,p2.code as property_person_code,p1.first_name as team_person_first_name,p1.last_name as team_person_last_name,p2.first_name as property_person_first_name,p2.last_name as property_person_last_name from  village_person as p1,village_person as p2 
        where p1.code=$team_person_code and p2.code=$property_person_code
        ";
         $query = $this->db->query($sql);
         $result = $query->row_array();
         return $result;
}


    public function getLatestCode()
    {
        $sql = "select id from village_park_rent order by id desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['id'];
    }

    public function getLatestCodeforauz()
    {
        $sql = "select code from village_vehicle_auz order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['code'];
    }


public function insert($village_id,$rent_id,$rent_begin_date,$rent_end_date,$rent_pay_type,$rent_rent, $rent_renter,$rent_parking_lot_code,$create_time)
{

    $sql = " INSERT INTO village_park_rent (id,begin_date,end_date,pay_type,rent, renter,parking_lot_code) values (".
        $this->db->escape($rent_id).", ".
        $this->db->escape($rent_begin_date).", ".
        $this->db->escape($rent_end_date).", ".
        $this->db->escape($rent_pay_type).", ".
        $this->db->escape($rent_rent).", ".
        $this->db->escape($rent_renter).", ".
        $this->db->escape($rent_parking_lot_code).")";

    $this->db->query($sql);


}




    public function insertRecord($code,$person_code,$service_code, $date,$create_time)
    {

        $sql = " INSERT INTO village_activity_rcd (activity_code,person_code,service_code, date,create_time) values (".
            $this->db->escape($code).", ".
            $this->db->escape($person_code).", ".
            $this->db->escape($service_code).", ".
            $this->db->escape($date).", ".
            $this->db->escape($create_time).")";
        $this->db->query($sql);
        return $this->db->affected_rows();
    }


    public function getPersonByCode($code){
        $sql = "select *,concat(last_name,first_name) as full_name from village_person where code=$code limit 1";

        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }
    public function getperson_code(){
        $sql = "select code,concat(last_name,first_name) as full_name from village_person";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }

    public function getservice_code(){
        $sql = "select 
pp.person_code as pp_code,
p.first_name,
p.last_name
from village_person_position as pp
left join village_person as p on p.code=pp.person_code
";
        $query = $this->db->query($sql);
          $arr = $query->result_array();
            foreach ($arr as $key => $value) {

                    $arr[$key]['pp_name'] = $arr[$key]['last_name'] . $arr[$key]['first_name'] ;

            }

        return $arr;

    }








public function verifyauz($licence)
{
    $sql="select licence from village_vehicle where licence='$licence'";
    $q = $this->db->query($sql);
    $q=$q->result_array();
 // $res=$res->row_array();
    return $q;
}







public function getparkingcode()
{
    $sql="SELECT

	par.parkcode as lot_parkcode,
	par.parkname as lot_parkcode_name
FROM
	village_park AS par
";
    $res = $this->db->query($sql); //自动转义
    $res=$res->result_array();
    return $res;
}

    public function update($village_id,$rent_id,$rent_begin_date,$rent_end_date,$rent_pay_type,$rent_rent, $rent_renter,$rent_parking_lot_code,$create_time)
    {
        $sql = " update village_park_rent
         set 
            end_date=".$this->db->escape($rent_end_date)." ".

            "where id=$rent_id";

        $this->db->query($sql);
    }



    public function getfloor()
    {
        $sql="SELECT

	par.parkcode as lot_parkcode,
	par.parkname as lot_parkcode_name
FROM
	village_park AS par
";
        $res = $this->db->query($sql); //自动转义
        $res=$res->result_array();
        return $res;
    }



    public function getBuildingnamebyCode($code)
    {
        $sql = "select code,concat(stage_name,area_name,immeuble_name,unit_name,floor_name,room_name,public_name) as full_name from village_tmp_building where $code=code";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row;
    }



}

?>


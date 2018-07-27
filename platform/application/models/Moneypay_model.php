

<?php
class Moneypay_model extends CI_Model
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
                       $sql .= " and concat (p.last_name,p.first_name) like '%$keyword%'";
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


    public function sqlTogetList_property_fee($if_standard,$building_code, $parent_code,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());

        /////////////////判断为普通查询或搜索查询////////////////////////////
        if (empty($if_standard) && empty($building_code) &&  empty($keyword))

            /////////////////////////普通查询sql语句/////////////////////////
        {

            $sql = "  select 
  property.standard as property_standard,
  property.ppe_payable as property_fee_standard_per_month,
  property.if_standard as property_if_standard,
  property.if_standard_date as property_if_standard_date,
  property.change_reason as property_change_reason,
  b.code as property_building_code,
  b.name as property_building_name,
  b.building_type as property_building_type,
  b.parent_code,
  b.floor_area as property_floor_area,
  tmp.*
  from village_dtl_ppe_fee as property
    left join village_building as b on b.code=property.building_code
  left join village_tmp_building as tmp on tmp.code=b.code
    where tmp.code=b.code
";}



        /////////////////////////搜索查询sql语句/////////////////////////
        else {
            $sql = "
          select 
  property.standard as property_standard,
  property.ppe_payable as property_fee_standard_per_month,
  property.if_standard as property_if_standard,
  property.if_standard_date as property_if_standard_date,
  property.change_reason as property_change_reason,
  b.code as property_building_code,
  b.name as property_building_name,
  b.building_type as property_building_type,
   b.parent_code,
  b.floor_area as property_floor_area,
  tmp.*
  from village_dtl_ppe_fee as property
  left join village_building as b on b.code=property.building_code
  left join village_tmp_building as tmp on tmp.code=b.code
  where tmp.code=b.code
";
        }
     /*   if(empty($rent_end_date)){
            $sql .= " and rent.end_date >= '$now' ";
        }*/

        if(!empty($if_standard)){
            $sql .= " and   property.if_standard='$if_standard' ";
        }

         if(!empty($building_code)){
               $sql .= " and (b.code=$building_code or b.parent_code=$parent_code) ";
           }


        if (!empty($keyword)) {
            if (preg_match('/^\d*\w*[\x7f-\xff]*$/', $keyword)) {
                $sql .= " and concat (b.name) like '%$keyword%'";
            }

        }




        $sqlshow = $sql . " ORDER BY property.building_code ASC limit ".$rows." offset ".$start;
        $arrayres=array($sql,$sqlshow);
        return $arrayres;
    }


    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getList_property_fee( $sql){

        $brand_arr = $this->brand_arr;
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "property_building_type") {
                        if ($value2 == "101") {
                            $arr[$key]['property_building_type_name'] = '住宅';
                            $arr[$key]['property_building_type_1_name'] = '住宅';}
                        if ($value2 == "102") {
                            $arr[$key]['property_building_type_name'] = '商铺';
                            $arr[$key]['property_building_type_1_name'] = '商铺';}
                        if ($value2 == "103") {
                            $arr[$key]['property_building_type_name'] = '公寓';
                            $arr[$key]['property_building_type_1_name'] = '公寓';}
                        if ($value2 == "104") {
                            $arr[$key]['property_building_type_name'] = '写字楼';
                            $arr[$key]['property_building_type_1_name'] = '写字楼';
                        }
                        if ($value2 == "105") {
                            $arr[$key]['property_building_type_name'] = '别墅';
                            $arr[$key]['property_building_type_1_name'] = '写字楼';
                        }
                    }

                    if ($key2 == 'property_building_code') {
                        $arr[$key]['property_building_code_name'] = $value2;
                    }
                       if ($key2 == 'property_floor_area') {
                           $arr[$key]['property_floor_area_name'] = $value2.'平米';
                       }

                    if ($key2 == 'property_fee_standard_per_month') {
                            $arr[$key]['property_fee_standard_per_month_name'] = $value2.'元';
                    }
                    if ($key2 == 'property_standard') {
                        $arr[$key]['property_standard_name'] = $value2.'元/平米/月';
                    }
                    if ($key2 == 'property_if_standard') {
                        if ($value2 == "t") {
                            $arr[$key]['property_if_standard_name'] = '是';
                        }
                        if ($value2 == "f") {
                            $arr[$key]['property_if_standard_name'] = '否';
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
                $arr[$key]["property_building_fullname"] = $this->getHouseholdInfo($value);

            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }

    //////////////////////////////////////////////////////////////////////////////////
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

    public function update_property($building_code,$ppe_payable,$change_reason,$if_standard_date,$if_standard)
    {
        $sql = " update village_dtl_ppe_fee
         set 
            ppe_payable=".$this->db->escape($ppe_payable).",".
            "change_reason=".$this->db->escape($change_reason).",".
            "if_standard_date=".$this->db->escape($if_standard_date).",".
            "if_standard=".$this->db->escape($if_standard)." ".
            "where building_code=$building_code";

        $this->db->query($sql);
    }

    public function getbuilding_type($building_type)
    {
        $sql = " 
        select * from village_type_ppe_fee where building_type=$building_type
        and change_date=(select max(change_date) from village_type_ppe_fee where building_type=$building_type and change_date<now())
        
        ";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }

    public function getbiz_type($biz_type)
    {
        $sql = " 
        select * from village_pkg_s_fee where biz_type=$biz_type
        and change_date=(select max(change_date) from village_pkg_s_fee where biz_type=$biz_type and change_date<now())
        
        ";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }

    public function getwater()
    {
        $sql = " 
        select * from village_water_fee 
        where change_date=(select max(change_date) from village_water_fee where change_date<now())
        
        ";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }

    public function change_history($building_type)
    {
        $sql = " 
        select change_date,fee_standard from village_type_ppe_fee where building_type=$building_type
        
        ";

        $query = $this->db->query($sql);
        $row = $query->result_array();
          foreach ($row as $key => $value) {
              foreach ($value as $key2 => $value2) {
                  if ($key2 == "fee_standard") {
                      $row[$key][$key2] = $value2 . "元/平米";
                  }
              }
          }
        return $row;
    }


    public function change_history_pkg_fee($biz_type)
    {
        $sql = " 
        select change_date,fee_standard from village_pkg_s_fee where biz_type=$biz_type
        
        ";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        foreach ($row as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 == "fee_standard") {
                    $row[$key][$key2] = $value2 . "元/月";
                }
            }
        }
        return $row;
    }

    public function change_history_water_fee()
    {
        $sql = " 
        select change_date,fee_standard from village_water_fee
        
        ";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        foreach ($row as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 == "fee_standard") {
                    $row[$key][$key2] = $value2 . "元/吨";
                }
            }
        }
        return $row;
    }

    public function change_history_bill_list($code)
    {
        $sql = " 
        select notify_info from village_bill_list
        where code='$code'
        ";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        foreach ($row as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 == "fee_standard") {
                    $row[$key][$key2] = $value2 . "元/吨";
                }
            }
        }
        return $row;
    }

    public function insert_property($code,$building_type,$change_date,$fee_standard)
    {
        $sql = " select 
      change_date
      from  village_type_ppe_fee where change_date='$change_date'
     ";
        $query = $this->db->query($sql);
          if ($query->num_rows() > 0) {
          $sql = " update village_type_ppe_fee
         set fee_standard=".$this->db->escape($fee_standard)." ".
         "where change_date='$change_date'";

              $this->db->query($sql);

          }
else{
        $sql=" INSERT INTO village_type_ppe_fee (code,building_type,change_date,fee_standard) values (".
            $this->db->escape($code).", ".
            $this->db->escape($building_type).", ".
            $this->db->escape($change_date).", ".
            $this->db->escape($fee_standard).")";
        $this->db->query($sql);

 /*       $sql = " select
        property.building_code,
        b.floor_area,
        b.building_type
      from  village_dtl_ppe_fee as property
      left join village_building as b on b.code=property.building_code
            ";
        $query = $this->db->query($sql);
        $row = $query->result_array();
        foreach ($row as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 == "building_type") {
                   if( $row[$key][$key2]==$building_type && $row[$key]['building_type']==$building_type){
                       $floor=$row[$key]['floor_area'];
                       $building_code=$row[$key]['building_code'];
                       $this->change_standard_fee($change_date,$building_code,$floor,$building_type,$fee_standard);
                   }
                }
            }
        }*/
}
    }

    public function insert_pkg_fee($code,$biz_type,$change_date,$fee_standard)
    {

        $sql = " select 
      change_date
      from  village_pkg_s_fee where change_date='$change_date'
     ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $sql = " update village_pkg_s_fee
         set fee_standard=" . $this->db->escape($fee_standard) . " " .
                "where change_date='$change_date'";

            $this->db->query($sql);

        }
        else {
            $sql = " INSERT INTO village_pkg_s_fee (code,biz_type,change_date,fee_standard) values (" .
                $this->db->escape($code) . ", " .
                $this->db->escape($biz_type) . ", " .
                $this->db->escape($change_date) . ", " .
                $this->db->escape($fee_standard) . ")";
            $this->db->query($sql);
        }
    }

    public function insert_water_fee($code,$change_date,$fee_standard)
    {

        $sql = " select 
      change_date
      from  village_water_fee where change_date='$change_date'
     ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $sql = " update village_water_fee
         set fee_standard=" . $this->db->escape($fee_standard) . " " .
                "where change_date='$change_date'";

            $this->db->query($sql);

        }
        else {
            $sql = " INSERT INTO village_water_fee (code,change_date,fee_standard) values (" .
                $this->db->escape($code) . ", " .
                $this->db->escape($change_date) . ", " .
                $this->db->escape($fee_standard) . ")";
            $this->db->query($sql);
        }
    }

    public function change_standard_fee($change_date,$building_code,$floor,$building_type,$fee_standard)
    {
        $floor=intval($floor, 10);
        $fee_standard=intval($fee_standard, 10);
        $update_standard=$floor*$fee_standard;
   /*     $sql = " update village_dtl_ppe_fee
         set  standard=".$this->db->escape($fee_standard).",".
            "ppe_payable=".$this->db->escape($update_standard)." ".
            "where building_code=$building_code";*/
        $sql=" INSERT INTO village_dtl_ppe_fee (change_date,standard,ppe_payable,building_code) values (".
            $this->db->escape($change_date).", ".
            $this->db->escape($fee_standard).", ".
            $this->db->escape($update_standard).",".
            $this->db->escape($building_code).")";
        $this->db->query($sql);

    }


    public function getLatestCode($database)
    {
        $sql = "select code from $database order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['code'];
    }


    public function sqlTogetList_pkg_fee($effective_date,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());

        /////////////////判断为普通查询或搜索查询////////////////////////////
        if (empty($effective_date)  &&  empty($keyword))

            /////////////////////////普通查询sql语句/////////////////////////
        {

            $sql = "  select 
  parking_lot.effective_date as pkg_effective_date,
  parking_lot.effective_status as pkg_effective_status,
  parking_lot.parkcode as pkg_park_code,
  parking_lot.floor as pkg_floor,
  parking_lot.code as pkg_parklot_code,
  parking_lot.biz_reason as pkg_biz_reason,
  parking_lot.owner as pkg_fee_person,
  pkg.fee_standard as pkg_fee_per_month,
  pkg.change_date as  pkg_change_date,
  pkg.biz_type as  pkg_biz_type,
  p.first_name ,
  p.last_name
   from village_parking_lot as parking_lot
     left join village_pkg_s_fee as pkg on pkg.biz_type= parking_lot.biz_type
     left join village_person as p on p.code=parking_lot.owner
 where parking_lot.biz_status=101 and (parking_lot.biz_reason=101 or parking_lot.biz_reason=102)
    and (pkg.change_date=(select max(change_date) from village_pkg_s_fee where change_date<now() and biz_type=101) or pkg.change_date=(select max(change_date) from village_pkg_s_fee where change_date<now() and biz_type=102))
";}



        /////////////////////////搜索查询sql语句/////////////////////////
        else {
            $sql = "
 select 
  parking_lot.effective_date as pkg_effective_date,
  parking_lot.parkcode as pkg_park_code,
  parking_lot.floor as pkg_floor,
  parking_lot.code as pkg_parklot_code,
  parking_lot.biz_reason as pkg_biz_reason,
  parking_lot.owner as pkg_fee_person,
  pkg.fee_standard as pkg_fee_per_month,
  pkg.change_date as  pkg_change_date,
  pkg.biz_type as  pkg_biz_type,
  p.first_name ,
  p.last_name
   from village_parking_lot as parking_lot
    left join village_pkg_s_fee as pkg on pkg.biz_type= parking_lot.biz_type
    left join village_person as p on p.code=parking_lot.owner
 where parking_lot.biz_status=101 and (parking_lot.biz_reason=101 or parking_lot.biz_reason=102)
 and (pkg.change_date=(select max(change_date) from village_pkg_s_fee where change_date<now() and pkg.biz_type=101) or pkg.change_date=(select max(change_date) from village_pkg_s_fee where change_date<now() and pkg.biz_type=102))
";
        }
         if(empty($pkg_effective_date)){
               $sql .= " and parking_lot.effective_date <= '$now' and  parking_lot.effective_status =true ";
          }


        if(!empty($pkg_effective_date)){
            $sql .= " and  parking_lot.effective_date <= '$pkg_effective_date' and  parking_lot.effective_status =true ";
        }


        if (!empty($keyword)) {
            if (preg_match('/^\d*\w*[\x7f-\xff]*$/', $keyword)) {
                $sql .= " and concat (parking_lot.code,p.last_name,p.first_name) like '%$keyword%'";
            }

        }

        $sqlshow = $sql . " ORDER BY parking_lot.code ASC limit ".$rows." offset ".$start;
        $arrayres=array($sql,$sqlshow);
        return $arrayres;
    }

    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getList_pkg_fee( $sql){

        $brand_arr = $this->brand_arr;
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "pkg_floor") {
                        if ($value2 == "101") {
                            $arr[$key]['pkg_floor'] = '地面';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['pkg_floor'] = '地下一层';
                          }
                    }

                    if ($key2 == "pkg_biz_reason") {
                        if ($value2 == "101") {
                            $arr[$key]['pkg_biz_reason'] = '已出售';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['pkg_biz_reason'] = '租赁中';
                        }
                        if ($value2 == "103") {
                            $arr[$key]['pkg_biz_reason'] = '被占用';
                        }
                    }

                    if ($key2 == "pkg_fee_per_month") {
                        $arr[$key]['pkg_fee_per_month_name'] =$value2.'元/月';
                        $arr[$key]['pkg_fee_per_month_name_1'] =$value2.'元/月';
                    }
                    if($key2 == 'pkg_fee_person'){
                        if(!empty($value['pkg_fee_person']) ) {

                            $arr[$key]['pkg_fee_person_name'] = "";

                            $person = $this->getPersonByCode($value2);
                            $name = $person['full_name'];
                            $arr[$key]['pkg_fee_person_name'] = $name;
                        }

                    }

                }
                $arr[$key]["property_building_fullname"] = $this->getHouseholdInfo($value);

            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }


    public function sqlTogetList_water_fee($effective_date,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());

        /////////////////判断为普通查询或搜索查询////////////////////////////
        if (empty($effective_date)  &&  empty($keyword))

            /////////////////////////普通查询sql语句/////////////////////////
        {

            $sql = "select 
water.code as water_code,
water.building_code as water_building_code,
water.building_name as water_building_name,
water.rank as water_building_rank,
water.Water_csp as water_thismonth_usage,
tmp.*,
water_fee.change_date as water_fee_change_date,
water_fee.fee_standard as water_fee_standard
 from village_water_list as water  left join village_tmp_building as tmp on tmp.code=water.building_code, 
 village_water_fee as water_fee
 
";}



        /////////////////////////搜索查询sql语句/////////////////////////
        else {
            $sql = "
select 
water.code as water_code,
water.building_code as water_building_code,
water.building_name as water_building_name,
water.rank as water_building_rank,
water.water_csp as water_thismonth_usage,
tmp.*,
water_fee.change_date as water_fee_change_date,
water_fee.fee_standard as water_fee_standard
 from village_water_list as water  left join village_tmp_building as tmp on tmp.code=water.building_code, 
 village_water_fee as water_fee

";
        }
      /*  if(empty($pkg_effective_date)){
            $sql .= " and parking_lot.effective_date <= '$now' and  parking_lot.effective_status =true ";
        }


        if(!empty($pkg_effective_date)){
            $sql .= " and  parking_lot.effective_date <= '$pkg_effective_date' and  parking_lot.effective_status =true ";
        }


        if (!empty($keyword)) {
            if (preg_match('/^\d*\w*[\x7f-\xff]*$/', $keyword)) {
                $sql .= " and concat (parking_lot.code,p.last_name,p.first_name) like '%$keyword%'";
            }

        }*/

        $sqlshow = $sql . " ORDER BY water.code ASC limit ".$rows." offset ".$start;
        $arrayres=array($sql,$sqlshow);
        return $arrayres;
    }

    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getList_water_fee( $sql){

        $brand_arr = $this->brand_arr;
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "pkg_floor") {
                        if ($value2 == "101") {
                            $arr[$key]['pkg_floor'] = '地面';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['pkg_floor'] = '地下一层';
                        }
                    }

                    if ($key2 == "pkg_biz_reason") {
                        if ($value2 == "101") {
                            $arr[$key]['pkg_biz_reason'] = '已出售';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['pkg_biz_reason'] = '租赁中';
                        }
                        if ($value2 == "103") {
                            $arr[$key]['pkg_biz_reason'] = '被占用';
                        }
                    }

                    if ($key2 == "water_fee_standard") {
                        $arr[$key]['water_fee_standard_name']= $value2.'元/吨';
                        $arr[$key]['water_fee_per_month'] =intval($value2, 10)*intval($arr[$key]['water_thismonth_usage'], 10) ;
                        $arr[$key]['water_fee_per_month_name']= $arr[$key]['water_fee_per_month'].'元/吨';
                    }
                    if($key2 == 'pkg_fee_person'){
                        if(!empty($value['pkg_fee_person']) ) {

                            $arr[$key]['pkg_fee_person_name'] = "";

                            $person = $this->getPersonByCode($value2);
                            $name = $person['full_name'];
                            $arr[$key]['pkg_fee_person_name'] = $name;
                        }

                    }

                }
                $arr[$key]["water_building_fullname"] = $this->getHouseholdInfo($value);

            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }



    public function sqlTogetList_service_fee($service_type,$effective_date,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());

        /////////////////判断为普通查询或搜索查询////////////////////////////
        if (empty($service_type)  &&  empty($effective_date) &&  empty($keyword))

            /////////////////////////普通查询sql语句/////////////////////////
        {

            $sql = "select 
service.code as service_code,
service.name as service_name,
service.service_type as service_type,
service.change_date as service_change_date,
service.fee_standard as service_fee_standard,
service.remark as service_remark
from village_service_fee as service
 where service.change_date=(select max(change_date) from village_service_fee where change_date<now() ) 
";}



        /////////////////////////搜索查询sql语句/////////////////////////
        else {
            $sql = "
select 
service.code as service_code,
service.name as service_name,
service.service_type as service_type,
service.change_date as service_change_date,
service.fee_standard as service_fee_standard,
service.remark as service_remark
from village_service_fee as service
where service.change_date=(select max(change_date) from village_service_fee where change_date<now() ) 
";
        }
      /*    if(empty($pkg_effective_date)){
              $sql .= " and parking_lot.effective_date <= '$now' and  parking_lot.effective_status =true ";
          }


          if(!empty($pkg_effective_date)){
              $sql .= " and  parking_lot.effective_date <= '$pkg_effective_date' and  parking_lot.effective_status =true ";
          }*/

        if(!empty($service_type)){
            $sql .= " and service.service_type=$service_type ";
        }
        if(!empty($effective_date)){
            $sql .= " and service.change_date<='$effective_date' ";
        }
          if (!empty($keyword)) {
              if (preg_match('/^\d*\w*[\x7f-\xff]*$/', $keyword)) {
                  $sql .= " and concat (service.name) like '%$keyword%'";
              }

          }

        $sqlshow = $sql . " ORDER BY service.code ASC limit ".$rows." offset ".$start;
        $arrayres=array($sql,$sqlshow);
        return $arrayres;
    }

    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getList_service_fee( $sql){

        $brand_arr = $this->brand_arr;
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "service_type") {
                        if ($value2 == "101") {
                            $arr[$key]['service_type_name'] = '公共服务';
                        }
                        if ($value2 == "201") {
                            $arr[$key]['service_type_name'] = '家政维修-墙体天花玻璃类';
                        }
                        if ($value2 == "202") {
                            $arr[$key]['service_type_name'] = '家政维修-门锁类';
                        }
                        if ($value2 == "203") {
                            $arr[$key]['service_type_name'] = '家政维修-给排水类';
                        }
                        if ($value2 == "204") {
                            $arr[$key]['service_type_name'] = '家政维修-照明类';
                        }
                        if ($value2 == "205") {
                            $arr[$key]['service_type_name'] = '家政维修-线路类';
                        }
                        if ($value2 == "206") {
                            $arr[$key]['service_type_name'] = '家政维修-家电';
                        }
                        if ($value2 == "301") {
                            $arr[$key]['service_type_name'] = '家政清洁-大面积清洁';
                        }
                        if ($value2 == "302") {
                            $arr[$key]['service_type_name'] = '家政清洁-常规清洁';
                        }
                        if ($value2 == "401") {
                            $arr[$key]['service_type_name'] = '家政服务-桶装水业务';
                        }
                        if ($value2 == "402") {
                            $arr[$key]['service_type_name'] = '家政服务-定向钟点工';
                        }
                        if ($value2 == "403") {
                            $arr[$key]['service_type_name'] = '家政服务-代寄收快递/包裹';
                        }
                        if ($value2 == "404") {
                            $arr[$key]['service_type_name'] = '家政服务-代购业务';
                        }
                        if ($value2 == "405") {
                            $arr[$key]['service_type_name'] = '家政服务-跑腿业务';
                        }
                        if ($value2 == "501") {
                            $arr[$key]['service_type_name'] = '租借服务';
                        }
                        if ($value2 == "502") {
                            $arr[$key]['service_type_name'] = '绿化服务';
                        }
                        if ($value2 == "503") {
                            $arr[$key]['service_type_name'] = '车辆服务';
                        }
                        if ($value2 == "999") {
                            $arr[$key]['service_type_name'] = '其他';
                        }
                    }

                    if ($key2 == "pkg_biz_reason") {
                        if ($value2 == "101") {
                            $arr[$key]['pkg_biz_reason'] = '已出售';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['pkg_biz_reason'] = '租赁中';
                        }
                        if ($value2 == "103") {
                            $arr[$key]['pkg_biz_reason'] = '被占用';
                        }
                    }

                    if ($key2 == "service_change_date") {
                        $arr[$key]["service_change_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                    }

                    if ($key2 == "service_fee_standard") {
                        $arr[$key]['service_fee_standard_name']= $value2.'元';
                    }
                    if($key2 == 'pkg_fee_person'){
                        if(!empty($value['pkg_fee_person']) ) {

                            $arr[$key]['pkg_fee_person_name'] = "";

                            $person = $this->getPersonByCode($value2);
                            $name = $person['full_name'];
                            $arr[$key]['pkg_fee_person_name'] = $name;
                        }

                    }

                }
                $arr[$key]["water_building_fullname"] = $this->getHouseholdInfo($value);

            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }

    public function sqlTogetList_order_fee($begin_date,$end_date,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());


        /////////////////判断为普通查询或搜索查询////////////////////////////
        if (empty($begin_date)  &&  empty($end_date) &&  empty($keyword))

            /////////////////////////普通查询sql语句/////////////////////////
        {

            $sql = " 
select 
work_order.code as order_code,
work_order.create_time as order_create_time,
work_order.create_time as order_create_time,
work_order.person_code as order_create_person,
work_order.equipment_code as order_equipment,
work_order.building_code as order_building_code,
work_order.if_charged as order_if_charged,
work_order.toller as order_toller,
work_order.amount as order_amount,
record.accept_person_code as order_accept_person,
tmp.*,
p.last_name,
p.first_name,
equipment.name as  order_equipment_name
from village_work_order as work_order
left join village_order_record as record on record.work_code=work_order.code
left join village_equipment as equipment on equipment.code=work_order.equipment_code
left join village_tmp_building as tmp on tmp.code=work_order.building_code
left join village_person as p on p.code=work_order.person_code
where record.work_code=work_order.code
";}



        /////////////////////////搜索查询sql语句/////////////////////////
        else {
            $sql = "
select 
work_order.code as order_code,
work_order.create_time as order_create_time,
work_order.create_time as order_create_time,
work_order.person_code as order_create_person,
work_order.equipment_code as order_equipment,
work_order.building_code as order_building_code,
work_order.if_charged as order_if_charged,
work_order.toller as order_toller,
work_order.amount as order_amount,
record.accept_person_code as order_accept_person,
tmp.*,
p.last_name,
p.first_name,
equipment.name as  order_equipment_name
from village_work_order as work_order
left join village_order_record as record on record.work_code=work_order.code
left join village_equipment as equipment on equipment.code=work_order.equipment_code
left join village_tmp_building as tmp on tmp.code=work_order.building_code
left join village_person as p on p.code=work_order.person_code
where record.work_code=work_order.code
";
        }
        /*    if(empty($pkg_effective_date)){
                $sql .= " and parking_lot.effective_date <= '$now' and  parking_lot.effective_status =true ";
            }


            if(!empty($pkg_effective_date)){
                $sql .= " and  parking_lot.effective_date <= '$pkg_effective_date' and  parking_lot.effective_status =true ";
            }*/
       /*if(empty($begin_date)){
           $sql .= " and work_order.create_time>='now()' ";
            }
        if(empty($end_date)){
            $sql .= " and work_order.create_time<='now()' ";
        }
        if(!empty($begin_date)){
            $sql .= " and work_order.create_time>='$begin_date' ";
        }
        if(!empty($end_date)){
            $sql .= " and work_order.create_time<='$end_date' ";
        }*/
        if (!empty($keyword)) {
            if (preg_match('/^\d*\w*[\x7f-\xff]*$/', $keyword)) {
                $sql .= " and concat (p.last_name,p.first_name) like '%$keyword%'";
            }

        }

        $sqlshow = $sql . " ORDER BY work_order.code ASC limit ".$rows." offset ".$start;
        $arrayres=array($sql,$sqlshow);
        return $arrayres;
    }

    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getList_order_fee($sql){

        $brand_arr = $this->brand_arr;
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "order_if_charged") {
                        if ($value2 == "t") {
                            $arr[$key]['order_if_charged_name'] = '是';
                        }
                        if ($value2 == "f") {
                            $arr[$key]['order_if_charged_name'] = '否';
                        }
                    }

                    if ($key2 == "order_amount") {
                        if(!empty($value2)){
                            $arr[$key]['order_amount_name'] = $value2.'元';
                        }

                    }

                    if ($key2 == "service_change_date") {
                        $arr[$key]["service_change_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                    }

                    if ($key2 == "service_fee_standard") {
                        $arr[$key]['service_fee_standard_name']= $value2.'元';
                    }


                    if($key2 == 'order_create_person'){
                        if(!empty($value['order_create_person']) ) {

                            $arr[$key]['order_create_person_name'] = "";

                            $person = $this->getPersonByCode($value2);
                            $name = $person['full_name'];
                            $arr[$key]['order_create_person_name'] = $name;
                        }

                    }
                    if($key2 == 'order_accept_person'){
                           if(!empty($value['order_accept_person']) ) {

                               $arr[$key]['order_accept_person_name'] = "";

                               $person = $this->getPersonByCode($value2);
                               $name = $person['full_name'];
                               $arr[$key]['order_accept_person_name'] = $name;
                           }

                    }
                    if($key2 == 'order_toller'){
                              if(!empty($value['order_toller']) ) {

                                  $arr[$key]['order_toller_name'] = "";

                                  $person = $this->getPersonByCode($value2);
                                  $name = $person['full_name'];
                                  $arr[$key]['order_toller_name'] = $name;
                              }

                    }

                }
                $arr[$key]["order_building_code_fullname"] = $this->getHouseholdInfo($value);

            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }

    public function sqlTogetList_bill_list($village_id,$begin_date,$end_date,$pay_status,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());
        $date   =   date('Y-m-d',strtotime("$now-1 month"));

        /////////////////判断为普通查询或搜索查询////////////////////////////
        if (empty($begin_date)  &&  empty($end_date) &&  empty($pay_status) && empty($keyword))

            /////////////////////////普通查询sql语句/////////////////////////
        {

            $sql = " 
select 
bill.code as bill_code,
bill.bill_type as bill_type,
bill.pay_status as bill_pay_status,
bill.initial_time as bill_initial_time,
bill.bill_amount as bill_amount,
bill.person_code as bill_person_code,
bill.payer_name as bill_payer_name,
bill.bill_month as bill_month,
bill.notify_info as bill_notify_info,

bill.bill_source_code as bill_source_code,
bill.third_bill_Input as bill_third_bill_Input,
bill.creator as bill_creator,
bill.if_cycle as bill_if_cycle,
bill.pay_req_no as bill_pay_req_no,
bill.pay_method as bill_pay_method,
bill.third_payment_no as bill_third_payment_no,
bill.remark as bill_remark
from village_bill_list as bill
where bill.village_id=$village_id and bill.initial_time<='now()' and (bill.pay_status=101 or bill.pay_status=102)
";}



        /////////////////////////搜索查询sql语句/////////////////////////
        else {
            $sql = "
select 
bill.code as bill_code,
bill.bill_type as bill_type,
bill.pay_status as bill_pay_status,
bill.initial_time as bill_initial_time,
bill.bill_amount as bill_amount,
bill.person_code as bill_person_code,
bill.payer_name as bill_payer_name,
bill.bill_month as bill_month,
bill.notify_info as bill_notify_info,

bill.bill_source_code as bill_source_code,
bill.third_bill_input as bill_third_bill_input,
bill.creator as bill_creator,
bill.if_cycle as bill_if_cycle,
bill.pay_req_no as bill_pay_req_no,
bill.pay_method as bill_pay_method,
bill.third_payment_no as bill_third_payment_no,
bill.remark as bill_remark
from village_bill_list as bill
where bill.village_id=$village_id
";
        }
        /*    if(empty($pkg_effective_date)){
                $sql .= " and parking_lot.effective_date <= '$now' and  parking_lot.effective_status =true ";
            }


            if(!empty($pkg_effective_date)){
                $sql .= " and  parking_lot.effective_date <= '$pkg_effective_date' and  parking_lot.effective_status =true ";
            }*/



         if(!empty($begin_date)){
             $sql .= " and bill.initial_time>='$begin_date' ";
         }
         if(!empty($end_date)){
             $sql .= " and bill.initial_time<='$end_date' ";
         }
        if(!empty($pay_status)){
            $sql .= " and bill.pay_status='$pay_status' ";
        }
        if (!empty($keyword)) {
            if (preg_match('/^\d*\w*[\x7f-\xff]*$/', $keyword)) {
                $sql .= " and concat (bill.payer_name) like '%$keyword%'";
            }

        }

        $sqlshow = $sql . " ORDER BY bill.code ASC limit ".$rows." offset ".$start;
        $arrayres=array($sql,$sqlshow);
        return $arrayres;
    }

    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getList_bill_list($sql){

        $brand_arr = $this->brand_arr;
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "bill_pay_status") {
                        if ($value2 == "101") {
                            $arr[$key]['bill_pay_status_name'] = '未支付';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['bill_pay_status_name'] = '支付失败';
                        }
                        if ($value2 == "103") {
                            $arr[$key]['bill_pay_status_name'] = '支付成功';
                        }
                    }
                    if ($key2 == "bill_type") {

                        if ($value2 == "101") {
                            $arr[$key]['bill_type_name'] = '车位租金账单';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['bill_type_name'] = '临时车缴费账单';
                        }
                        if ($value2 == "103") {
                            $arr[$key]['bill_type_name'] = '物业费缴费账单';
                        }
                           if ($value2 == "104") {
                               $arr[$key]['bill_type_name'] = '二次供水加压缴费账单';
                           }
                              if ($value2 == "105") {
                                  $arr[$key]['bill_type_name'] = '车位服务费账单';
                              }
                                 if ($value2 == "999") {
                                     $arr[$key]['bill_type_name'] = '其他账单';
                                 }
                    }
                    if ($key2 == "bill_amount") {
                        if(!empty($value2)){
                            $arr[$key]['bill_amount_name'] = $value2.'元';
                        }

                    }

                    if ($key2 == "service_change_date") {
                        $arr[$key]["service_change_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                    }

                    if ($key2 == "service_fee_standard") {
                        $arr[$key]['service_fee_standard_name']= $value2.'元';
                    }

                /*  if ($key2 == "notify_info") {
                        $arr[$key]['notify_info']=$this->formate_notify($value2);
                    }*/


                    if($key2 == 'order_create_person'){
                        if(!empty($value['order_create_person']) ) {

                            $arr[$key]['order_create_person_name'] = "";

                            $person = $this->getPersonByCode($value2);
                            $name = $person['full_name'];
                            $arr[$key]['order_create_person_name'] = $name;
                        }

                    }
                    if($key2 == 'order_accept_person'){
                        if(!empty($value['order_accept_person']) ) {

                            $arr[$key]['order_accept_person_name'] = "";

                            $person = $this->getPersonByCode($value2);
                            $name = $person['full_name'];
                            $arr[$key]['order_accept_person_name'] = $name;
                        }

                    }
                    if($key2 == 'order_toller'){
                        if(!empty($value['order_toller']) ) {

                            $arr[$key]['order_toller_name'] = "";

                            $person = $this->getPersonByCode($value2);
                            $name = $person['full_name'];
                            $arr[$key]['order_toller_name'] = $name;
                        }

                    }

                }
                $arr[$key]["order_building_code_fullname"] = $this->getHouseholdInfo($value);

            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }

    public function formate_notify($value)
    {
        return json_encode($value);
    }

}

?>


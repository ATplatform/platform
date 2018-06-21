

<?php
class Vehicle_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    ///////////////////////////////////获取数据////////////////////////////////////
    /////////////数据内容////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    /////////////数据数目////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    public function sqlTogetList($effective_date,$building_code, $parent_code,$if_resident,$vehicle_type,$vehicle_auz,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;


         /////////////////判断为普通查询或搜索查询////////////////////////////
         if (empty($effective_date) && empty($building_code) && empty($parent_code)  && empty($if_resident) && empty($vehicle_type) && empty($vehicle_auz)&& empty($keyword))

         /////////////////////////普通查询sql语句/////////////////////////
         {
             $sql = "select 
*,
v.code as v_code,
v.effective_date as v_effective_date,
v.effective_status as v_effective_status,
v.person_code as v_person_code,
v.remark as v_remark
from village_vehicle as v
left join village_person as p on v.person_code=p.code
left join village_person_building as pb on v.person_code=pb.person_code
left join village_tmp_building as tmp on tmp.code=pb.building_code
where v.person_code=p.code
";}



         /////////////////////////搜索查询sql语句/////////////////////////
         else {
             $sql = "select 
*,
v.code as v_code,
v.effective_date as v_effective_date,
v.effective_status as v_effective_status,
v.person_code as v_person_code,
v.remark as v_remark
from village_vehicle as v
left join village_person as p on v.person_code=p.code
left join village_person_building as pb on v.person_code=pb.person_code
left join village_tmp_building as tmp on tmp.code=pb.building_code
where v.person_code=p.code
";
            if(!empty($effective_date)){
                 $sql .= " and v.effective_date<='$effective_date' ";
             }

             if(!empty($building_code)){
                 $sql .= " and (pb.building_code=$building_code or tmp.parent_code=$parent_code) ";
             }

             if(!empty($if_resident)){
                 $sql .= " and v.if_resident='$if_resident' ";
             }
             if(!empty($vehicle_type)){
                 $sql .= " and v.vehicle_type=$vehicle_type ";
             }

             if(!empty($vehicle_auz)){
                 $sql .= " and v.effective_status='$vehicle_auz' ";
             }

               if (!empty($keyword)) {
                   if (preg_match('/^[\x7f-\xff]*\w*\d*$/', $keyword)) {
                       $sql .= " and concat (v_code,v.licence, owner,p.last_name,p.first_name) like '%$keyword%'";
                   }

               }



         }
        $sql = $sql . " ORDER BY v.code ASC limit ".$rows." offset ".$start;
        return $sql;
    }


    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getList( $sql){
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "v_code") {
                        $arr[$key][$key2] = intval($value2, 10);
                        $auzforall=$this->vehicle_auzForall($arr[$key][$key2]);
                        $arr[$key]['auzforall']=$auzforall;
                        if($auzforall==101){
                            $arr[$key]['auzforall_name'] = "无任何记录";
                        }
                        if($auzforall==102){
                            $arr[$key]['auzforall_name'] = "当前或未来有生效记录";
                        }
                        if($auzforall==103){
                            $arr[$key]['auzforall_name'] = "所有授权已失效";
                        }

                    }
                    if ($key2 == "vehicle_type") {
                        if ($value2 == "101") {$arr[$key]['vehicle_type_name'] = '轿车';}
                        if ($value2 == "102") {$arr[$key]['vehicle_type_name'] = '客车';}
                        if ($value2 == "103") {$arr[$key]['vehicle_type_name'] = '货车';}
                        if ($value2 == "104") {$arr[$key]['vehicle_type_name'] = '专用汽车';}
                        if ($value2 == "105") {$arr[$key]['vehicle_type_name'] = '摩托车';}
                        if ($value2 == "106") {$arr[$key]['vehicle_type_name'] = '电瓶车';}
                        if ($value2 == "107") {$arr[$key]['vehicle_type_name'] = '自行车';}
                        if ($value2 == "999") {$arr[$key]['vehicle_type_name'] = '其他车辆';}
                    }

                    if ($key2 == 'v_effective_date') {
                        $arr[$key]["v_effective_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                   /* if ($key2 == 'a_end_date') {
                        $arr[$key]["end_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }*/
                    /*if ($key2 == 'service_code'){
                          $person= $this->getPersonByCode($value2);
                        $arr[$key]["service_name"]=$person['full_name'];
                    }*/
                    if($key2 == 'v_person_code'){
                        if(!empty($value['v_person_code']) ) {

                            $arr[$key]['v_person_name'] = "";

                            $person = $this->getPersonByCode($value['v_person_code']);
                            $name = $person['full_name'];
                            $arr[$key]['v_person_name'] = $name;
                        }
                        else{
                            $arr[$key]['v_person_name']='无';
                        }
                    }
                    if ($key2 == 'v_effective_status') {
                        if ($arr[$key]['v_effective_status'] == 't') {
                            $arr[$key]['v_effective_status_name'] = "有效";
                        }
                        if ($arr[$key]['v_effective_status'] == 'f') {
                            $arr[$key]['v_effective_status_name'] = "无效";
                        }
                    }
                    if ($key2 == 'if_resident') {
                        if ($arr[$key]['if_resident'] == 't') {
                            $arr[$key]['if_resident_name'] = "是";
                        }
                        if ($arr[$key]['if_resident'] == 'f') {
                            $arr[$key]['if_resident_name'] = "否";
                        }
                    }
                    if ($key2 == 'if_temp') {
                        if ($arr[$key]['if_temp'] == 't') {
                            $arr[$key]['if_temp_name'] = "是";
                        }
                        if ($arr[$key]['if_temp'] == 'f') {
                            $arr[$key]['if_temp_name'] = "否";
                        }
                    }
                    if ($key2 == 'if_electro') {
                        if ($arr[$key]['if_electro'] == 't') {
                            $arr[$key]['if_electro_name'] = "是";
                        }
                        if ($arr[$key]['if_electro'] == 'f') {
                            $arr[$key]['if_electro_name'] = "否";
                        }
                    }
                    if ($key2 == "a_name") {
                        $arr[$key][$key2]=$value2 ? $value2: '无';
                    }
                    if ($key2 == "a_name") {
                        $arr[$key][$key2]=$value2 ? $value2: '无';
                    }
                    if ($key2 == "a_name") {
                        $arr[$key][$key2]=$value2 ? $value2: '无';
                    }
                    if ($key2 == "a_name") {
                        $arr[$key][$key2]=$value2 ? $value2: '无';
                    }

                    $auzfornow=$this->vehicle_auzForNow();
                    $arr[$key]['auzfornow']=$auzfornow;
                    if($auzfornow==true){
                        $arr[$key]['auzfornow_name'] = "有效";
                    }
                    if($auzfornow==false){
                        $arr[$key]['auzfornow_name'] = "无效";
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


    //////////////////////搜索查询数据数目的数据总条数/////////////
    public function getListTotal($sqlorigin, $rows)
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


    public function sqlTogetRecord($date,$type, $keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;


        /////////////////判断为普通查询或搜索查询////////////////////////////
        if (empty($date) && empty($type) && empty($keyword) )

            /////////////////////////普通查询sql语句/////////////////////////
        {
            $sql = "select 
a.*,
a_rcd.*,
a.code as a_code,
a.type as a_type,
a.name as a_name,
a.begin_date as a_begin_date,
a.end_date as a_end_date,
a.person_code as a_person_code,
a_rcd.person_code as rcd_person_code,
a_rcd.service_code as rcd_service_code
FROM village_activity_rcd as a_rcd
left join village_activity as a on a.code=a_rcd.activity_code
left join village_person as p on a_rcd.service_code=p.code 


";}



        /////////////////////////搜索查询sql语句/////////////////////////
        else {
            $sql = "select 
a.*,
a_rcd.*,
a.code as a_code,
a.type as a_type,
a.name as a_name,
a.begin_date as a_begin_date,
a.end_date as a_end_date,
a.person_code as a_person_code,
a_rcd.person_code as rcd_person_code,
a_rcd.service_code as rcd_service_code
FROM village_activity_rcd as a_rcd
left join village_activity as a on a.code=a_rcd.activity_code
left join village_person as p on a_rcd.service_code=p.code 
where a_rcd.service_code=p.code 

";
            if(!empty($date)){
                $sql .= " and a_rcd.date<='$date' ";

            }

            if(!empty($type)){
                $sql .= " and a.type=$type ";
            }



            if (!empty($keyword)) {
                if (preg_match('/^[\x7f-\xff]*\w*\d*$/', $keyword)) {
                    $sql .= " and concat (a.code, a.name,p.last_name,p.first_name,a_rcd.remark) like '%$keyword%'";
                }
                /*if (preg_match("/^\d*$/", $keyword)) {
                    $sql .= " and a.code = $keyword ";
                }*/
            }

            /* if(!empty($building_code)){
             $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code) ";
           }*/

        }
        $sql = $sql . " ORDER BY a.code ASC limit ".$rows." offset ".$start;
        return $sql;
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
                        $arr[$key][$key2]=$value2 ? $value2: '无';
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
                        else{
                            $arr[$key]['rcd_person_name']='无';
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


    //////////////////////搜索查询数据数目的数据总条数/////////////
    public function getRecordTotal($sqlorigin, $rows)
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

    //////////////////////////////////一些辅助功能///////////////////////////////////
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
        $sql = "select code from village_vehicle order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['code'];
    }

    public function getLatestCodeforauz()
    {
        $sql = "select code from village_vehicle_auz order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['code'];
    }


public function insert($code,$effective_date,$licence,$owner,$color, $model,$remark,$vehicle_type,$person_code,$effective_status,$if_resident,$if_electro,$if_temp,$auz_code,$auz_person_code,$begin_date,$end_date,$auz_remark,$create_time)
{

    $sql = " INSERT INTO village_vehicle (code,effective_date,licence,owner,color, model,remark,vehicle_type,person_code,effective_status,if_resident,if_electro,if_temp,create_time) values (".

        $this->db->escape($code).", ".
        $this->db->escape($effective_date).", ".
        $this->db->escape($licence).", ".
        $this->db->escape($owner).", ".
        $this->db->escape($color).", ".
        $this->db->escape($model).", ".
        $this->db->escape($remark).", ".
        $this->db->escape($vehicle_type).", ".
        $this->db->escape($person_code).", ".
        $this->db->escape($effective_status).", ".
        $this->db->escape($if_resident).", ".
        $this->db->escape($if_electro).", ".
        $this->db->escape($if_temp).", ".
        $this->db->escape($create_time).")";
    $this->db->query($sql);

    $sql = " INSERT INTO village_vehicle_auz (code,person_code,begin_date,end_date,remark,create_time) values (".

        $this->db->escape($auz_code).", ".
        $this->db->escape($auz_person_code).", ".
        $this->db->escape($begin_date).", ".
        $this->db->escape($end_date).", ".
        $this->db->escape($auz_remark).", ".
        $this->db->escape($create_time).")";
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

                    $arr[$key]['pp_name'] = $arr[$key]['last_name'] . $arr[$key]['first_name'] ? $arr[$key]['last_name'] . $arr[$key]['first_name'] : '无';

            }

        return $arr;

    }


public function getactivity_codeUrl(){
    $sql = "select code as a_code,name as a_name from village_activity order by code asc ";
    $query = $this->db->query($sql);
    $row = $query->result_array();
    return $row;
}




    public function vehicle_auzForNow(){

        $sql="SELECT
	*
FROM
	village_vehicle AS v,
  village_vehicle_auz AS auz 
WHERE
v.code = auz.vehicle_code and
	auz.begin_date < now()
AND auz.end_date > now()";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {return true;}
             else{return false;}
    }


    public function vehicle_auzForall($code){

        $sql="SELECT
	*
FROM
village_vehicle_auz AS auz 

 left join 	village_vehicle AS v on  auz.vehicle_code=v.code  
WHERE $code = auz.vehicle_code";
        $q1 = $this->db->query($sql);
        if ($q1->num_rows() == 0) {return 101;}
        if ($q1->num_rows() > 0) {
            $sql="SELECT
	*
FROM
village_vehicle_auz AS auz 
 left join 	village_vehicle AS v on  auz.vehicle_code=v.code 
where auz.vehicle_code=$code
AND auz.end_date > now()";
            $q2 = $this->db->query($sql);
            if ($q2->num_rows() > 0) {return 102;}
            else{return 103;}
            }
    }

    public function getauz($code)
    {

        $sql = "SELECT
	*,
	auz.code as auz_code,
	auz.remark as auz_remark,
	auz.begin_date as auz_begin_date,
	auz.end_date as auz_end_date
FROM
village_vehicle_auz AS auz 
 left join 	village_vehicle AS v on auz.vehicle_code=v.code 
WHERE auz.vehicle_code=$code";

        $q = $this->db->query($sql);
         if ($q->num_rows() > 0) {
             $arr = $q->result_array();
             foreach ($arr as $key => $value) {
                 foreach ($value as $key2 => $value2) {
                     if ($key2 == 'auz_begin_date') {
                         $arr[$key]['auz_begin_date_name'] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                     }
                     if ($key2 == 'auz_end_date') {
                         $arr[$key]['auz_end_date_name'] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                     }
                     if ($key2 == 'person_code') {
                         $person = $this->getPersonByCode($value2);
                         $arr[$key]['auz_person_name'] = $person['full_name'];
                     }
                 }
             }
             return $arr;
         }
         else{
             return false;
         }


    }



}

?>


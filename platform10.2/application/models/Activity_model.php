

<?php
class Activity_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    ///////////////////////////////////获取数据////////////////////////////////////
    /////////////数据内容////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    /////////////数据数目////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    public function sqlTogetList($begin_date,$type, $keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;


         /////////////////判断为普通查询或搜索查询////////////////////////////
         if (empty($begin_date) && empty($type) && empty($keyword) )

         /////////////////////////普通查询sql语句/////////////////////////
         {
             $sql = "select 
*,
a.code as a_code,
a.type as a_type,
a.name as a_name,
a.qr_code as a_qr_code,
a.begin_date as a_begin_date,
a.end_date as a_end_date,
a.person_code as a_person_code,
p.code
FROM village_activity as a
left join village_person_position as pp on a.service_code=pp.person_code
left join village_person as p on a.service_code=p.code 
where pp.code= (
SELECT  MAX(A.code)
	FROM
		village_person_position A
where pp.person_code=A.person_code 
)

";}



         /////////////////////////搜索查询sql语句/////////////////////////
         else {
             $sql = "select 
*,
a.code as a_code,
a.type as a_type,
a.name as a_name,
a.qr_code as a_qr_code,
a.begin_date as a_begin_date,
a.end_date as a_end_date,
a.person_code as a_person_code,
p.code
FROM village_activity as a
left join village_person_position as pp on a.service_code=pp.person_code
left join village_person as p on a.service_code=p.code 
where pp.code= (
SELECT  MAX(A.code)
	FROM
		village_person_position A
where pp.person_code=A.person_code 
)
";
             if(!empty($begin_date)){
                 $sql .= " and a.begin_date<='$begin_date' ";
                 $sql .= " and '$begin_date'<=a.end_date ";
             }

             if(!empty($type)){
                 $sql .= " and a.type=$type ";
             }



               if (!empty($keyword)) {
                   if (preg_match('/^[\x7f-\xff]*\w*$/', $keyword)) {
                       $sql .= " and concat ( a.name,p.last_name,p.first_name) like '%$keyword%'";
                   }
                   if (preg_match("/^\d*$/", $keyword)) {
                       $sql .= " and a.code = $keyword ";
                   }
               }

             /* if(!empty($building_code)){
              $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code) ";
            }*/

         }
        $sql = $sql . " ORDER BY a.code ASC limit ".$rows." offset ".$start;
        return $sql;
    }


    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getList( $sql){
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
                    if ($key2 == 'a_begin_date') {
                        $arr[$key]["begin_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'a_end_date') {
                        $arr[$key]["end_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'service_code'){
                          $person= $this->getPersonByCode($value2);
                        $arr[$key]["service_name"]=$person['full_name'];
                    }
                    if($key2 == 'a_person_code'){
                        if(!empty($value['a_person_code']) ){
                        $person_code_str = $value['a_person_code'];
                        //去掉person_code前的括号并转化成数组形式
                        $person_code_str = substr($person_code_str,1);
                        $person_code_str = substr($person_code_str,0,strlen($person_code_str)-1);
                        $person_code_arr = explode(",", $person_code_str);
                        $arr[$key]['person_code_str'] = $person_code_arr;
                        $arr[$key]['person_name'] = "";
                        $arr[$key]['person_name_arr'] = array();

                        //根据拼接成的结果查出所有的人名
                        foreach($person_code_arr as $k2 => $v2){
                            $person = $this->getPersonByCode($v2);
                            $name = $person['full_name'];
                            $arr[$key]['person_name'] .= $name.";";
                        }
                    }
                    else{
                        $arr[$key]['person_name']='无';
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
                if (preg_match('/^[\x7f-\xff]*\w*$/', $keyword)) {
                    $sql .= " and concat ( a.name,p.last_name,p.first_name,a_rcd.remark) like '%$keyword%'";
                }
                if (preg_match("/^\d*$/", $keyword)) {
                    $sql .= " and a.code = $keyword ";
                }
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
        $sql = "select code from village_activity order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['code'];
    }


public function insert($code,$type,$name,$person_code,$service_code, $begin_date,$end_date,$qr_code,$create_time)
{

    $sql = " INSERT INTO village_activity (code,type,name,person_code,service_code, begin_date,end_date,qr_code,create_time) values (".

        $this->db->escape($code).", ".
        $this->db->escape($type).", ".
        $this->db->escape($name).", ".
        $this->db->escape($person_code).", ".
        $this->db->escape($service_code).", ".
        $this->db->escape($begin_date).", ".
        $this->db->escape($end_date).", ".
        $this->db->escape($qr_code).", ".
        $this->db->escape($create_time).")";
    $this->db->query($sql);
    return $this->db->affected_rows();
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

}

?>


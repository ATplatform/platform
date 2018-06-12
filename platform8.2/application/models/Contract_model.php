

<?php
class Contract_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    ///////////////////////////////////获取数据////////////////////////////////////
    /////////////数据内容////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    /////////////数据数目////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    public function sqlTogetContractList($begin_date,$type,$level, $keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;


         /////////////////判断为普通查询或搜索查询////////////////////////////
         if (empty($type) && empty($keyword) && empty($begin_date) && empty($level))

         /////////////////////////普通查询sql语句/////////////////////////
         {
             $sql = "select 
*,
c.code as c_code,
p.name as p_name
 FROM village_contracts as c
left join village_position as p on c.position_code=p.code
";}



         /////////////////////////搜索查询sql语句/////////////////////////
         else {
             $sql = "select 
*,
c.code as c_code,
p.name as p_name 
FROM
village_contracts as c
left join village_position as p on c.position_code=p.code
where c.code=c.code
";
             if(!empty($begin_date)){
                 $sql .= " and c.begin_date<='$begin_date' ";
                 $sql .= " and '$begin_date'<=c.end_date ";
             }

             if(!empty($type)){
                 $sql .= " and c.type=$type ";
             }

             if(!empty($level)){
                 $sql .= " and c.level=$level ";
             }

               if (!empty($keyword)) {
                   if (preg_match('/^\d*[\x7f-\xff]+\d*$/', $keyword)) {
                       $sql .= " and concat ( p.name,c.signed_with,c.remark) like '%$keyword%'";
                   }
                   if (preg_match("/^\d*$/", $keyword)) {
                       $sql .= " and c.code = $keyword ";
                   }
               }

             /* if(!empty($building_code)){
              $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code) ";
            }*/

         }
        $sql = $sql . " ORDER BY c.code ASC limit ".$rows." offset ".$start;
        return $sql;
    }


    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getContractList( $sql){
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == 'c_code') {
                        $arr[$key][$key2] = intval($value2, 10);
                    }
                    if ($key2 == "type") {
                        if ($value2 == "101") {$arr[$key]['type_name'] = '业务外包合同';}
                        if ($value2 == "102") {$arr[$key]['type_name'] = '经营性合同';}
                        if ($value2 == "103") {$arr[$key]['type_name'] = '与业主的服务协议';}
                        if ($value2 == "104") {$arr[$key]['type_name'] = '业主的授权协议';}
                    }
                    if ($key2 == "level") {
                        if ($value2 == "101") {$arr[$key]['level_name'] = '需呈报总部的合同';}
                        if ($value2 == "102") {$arr[$key]['level_name'] = '内部管理合同';}


                    }

                    if ($key2 == 'begin_date') {
                        $arr[$key]["begin_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'end_date') {
                        $arr[$key]["end_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'person_code'){
                        $arr[$key]['create_person_name'] = $value['create_person_last_name'].$value['create_person_first_name']? $value['create_person_last_name'].$value['create_person_first_name'] : '无';
                    }
                    if ($key2 == 'accept_person_code'){
                        $arr[$key]['accept_person_name'] = $value['accept_person_last_name'].$value['accept_person_first_name']? $value['accept_person_last_name'].$value['accept_person_first_name'] : '无';
                    }
                    if ($key2 == 'signed_with'){
                        $arr[$key][$key2]=$value2 ? $value2: '无';
                    }
                    if ($key2 == 'remark'){
                        $arr[$key][$key2]=$value2 ? $value2: '无';
                    }
                    if($key2 == 'position_code'){
                        $arr[$key]['position_name']=$arr[$key]['p_name']?$arr[$key]['p_name']:'无';
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
    public function getContractListTotal($begin_date,$type, $keyword, $level,$rows)
    {
        $sql="select count(*) as count from (";

        if (  empty($type) && empty($keyword) && empty($begin_date) && empty($level))
        {
            $sql.="
select * FROM
village_contracts as c
left join village_position as p on c.position_code=p.code		
"; } else{

    $sql .= "select * FROM
village_contracts as c
left join village_position as p on c.position_code=p.code
where c.code=c.code

";
            if(!empty($begin_date)){
                $sql .= " and c.begin_date<='$begin_date' ";
                $sql .= " and '$begin_date'<=c.end_date ";
            }

            if(!empty($type)){
                $sql .= " and c.type=$type ";
            }

            if(!empty($level)){
                $sql .= " and c.level=$level ";
            }

            if (!empty($keyword)) {
                if (preg_match('/^\d*[\x7f-\xff]+\d*$/', $keyword)) {
                    $sql .= " and concat ( p.name,c.signed_with,c.remark) like '%$keyword%'";
                }
                if (preg_match("/^\d*$/", $keyword)) {
                    $sql .= " and c.code = $keyword ";
                }
            }

    /* if(!empty($building_code)){
     $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code) ";
   }*/
    }
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
        $sql = "select code from village_contracts order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['code'];
    }


public function insert($code,$type,$level,$signed_with,$amount, $position_code,$begin_date,$end_date,$remark,$additional,$create_time)
{

    $sql = " INSERT INTO village_contracts (code,type,level,signed_with,amount, position_code,begin_date,end_date,remark,additional,create_time) values (".

        $this->db->escape($code).", ".
        $this->db->escape($type).", ".
        $this->db->escape($level).", ".
        $this->db->escape($signed_with).", ".
        $this->db->escape($amount).", ".
        $this->db->escape($position_code).", ".
        $this->db->escape($begin_date).", ".
        $this->db->escape($end_date).", ".
        $this->db->escape($remark).", ".
        $this->db->escape($additional).", ".
        $this->db->escape($create_time).")";
    $this->db->query($sql);
    return $this->db->affected_rows();
}


    public function getposition_code()
    {
        $sql = "select 

p.name as p_name,
p.code as p_code
from village_position as p
";
        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }









}

?>


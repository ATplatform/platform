

<?php
class Workorder_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    ///////////////////////////////////获取数据////////////////////////////////////
    /////////////数据内容////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    /////////////数据数目////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    public function sqlTogetWorkorderList($create_time,$create_type,$order_type, $keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now      =  date("Y-m-d",time());

         /////////////////判断为普通查询或搜索查询////////////////////////////
         if (empty($parent_code) && empty($building_code) && empty($create_type) && empty($keyword) && empty($create_time) && empty($order_type))

         /////////////////////////普通查询sql语句/////////////////////////
         {
             $sql = "select *,
w_o.create_time as w_o_create_time,
p1.first_name as create_person_first_name,
p1.last_name  as create_person_last_name,
p2.first_name as accept_person_first_name,
p2.last_name  as accept_person_last_name,
e.name as e_name
FROM village_work_order as w_o
left join village_order_record as o_r on o_r.work_code=w_o.code
left join  village_person_position as pp on pp.person_code=o_r.accept_person_code and pp.code=(select max(code) from village_person_position A where A.person_code=o_r.accept_person_code group by A.person_code)
left join village_person as p1 on p1.code=w_o.person_code 
left join village_person as p2 on p2.code=o_r.accept_person_code
left join village_equipment as e on e.code= w_O.equipment_code
";}



         /////////////////////////搜索查询sql语句/////////////////////////
         else {
             $sql = "select *,
w_o.create_time as w_o_create_time,
p1.first_name as create_person_first_name,
p1.last_name  as create_person_last_name,
p2.first_name as accept_person_first_name,
p2.last_name  as accept_person_last_name,
e.name as e_name
FROM village_work_order as w_o
left join village_order_record as o_r on o_r.work_code=w_o.code
left join  village_person_position as pp on pp.person_code=o_r.accept_person_code and pp.code=(select max(code) from village_person_position A where A.person_code=o_r.accept_person_code group by A.person_code)
left join village_person as p1 on p1.code=w_o.person_code 
left join village_person as p2 on p2.code=o_r.accept_person_code
left join village_equipment as e on e.code= w_O.equipment_code
where o_r.work_code=w_o.code
";
             if(empty($create_time)){
                 $sql .= " and w_o.create_time<='$now'";
             }
             if(!empty($create_time)){
                 $sql .= " and w_o.create_time<='$create_time' ";
             }

             if(!empty($create_type)){
                 $sql .= " and w_o.create_type=$create_type ";
             }

             if(!empty($order_type)){
                 $sql .= " and w_o.order_type=$order_type ";
             }

               if (!empty($keyword)) {
                   if (preg_match('/^[\x7f-\xff]*\w*\d*$/', $keyword)) {
                       $sql .= " and concat ( w_o.code,p1.last_name,p1.first_name,p2.last_name,p2.first_name) like '%$keyword%'";
                   }
                 /*  if (preg_match("/^\d*$/", $keyword)) {
                       $sql .= " and w_o.code = $keyword ";
                   }*/
               }

             /* if(!empty($building_code)){
              $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code) ";
            }*/

         }
        $sql = $sql . " ORDER BY w_o.code ASC limit ".$rows." offset ".$start;
        return $sql;
    }


    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getWorkorderList( $sql){
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "create_type") {
                        if ($value2 == "101") {$arr[$key]['create_type_name'] = '自动创建巡检工单';}
                        if ($value2 == "102") {$arr[$key]['create_type_name'] = '自动创建异常处理工单';}
                        if ($value2 == "103") {$arr[$key]['create_type_name'] = '循环创建工单';}
                        if ($value2 == "201") {$arr[$key]['create_type_name'] = '物业人员创建工单';}
                        if ($value2 == "202") {$arr[$key]['create_type_name'] = '住户/商户创建工单';}

                    }
                    if ($key2 == "order_type") {
                        if ($value2 == "101") {$arr[$key]['order_type_name'] = '自动工单';}
                        if ($value2 == "201") {$arr[$key]['order_type_name'] = '事事问物业';}
                        if ($value2 == "202") {$arr[$key]['order_type_name'] = '物业帮你办';}
                        if ($value2 == "203") {$arr[$key]['order_type_name'] = '异常报备';}
                        if ($value2 == "204") {$arr[$key]['order_type_name'] = '投诉或建议';}

                    }
                    if ($key2 == "work_state") {
                        if ($value2 == "101") {$arr[$key]['work_state_name'] = '待分配';}
                        if ($value2 == "102") {$arr[$key]['work_state_name'] = '待处理';}
                        if ($value2 == "103") {$arr[$key]['work_state_name'] = '已结案';}

                    }
                    if ($key2 == "if_false") {
                        if ($value2 == 't') {$arr[$key]['if_false_name'] = '是';}
                        if ($value2 == 'f') {$arr[$key]['if_false_name'] = '否';}
                    }
                    if ($key2 == "comment_score") {
                        if ($value2 == '101') {$arr[$key]['comment_score_name'] = '5分';}
                        if ($value2 == '102') {$arr[$key]['comment_score_name'] = '4分';}
                        if ($value2 == '103') {$arr[$key]['comment_score_name'] = '3分';}
                        if ($value2 == '104') {$arr[$key]['comment_score_name'] = '2分';}
                        if ($value2 == '105') {$arr[$key]['comment_score_name'] = '1分';}
                        if ($value2 == '106') {$arr[$key]['comment_score_name'] = '0分';}
                    }

                    if ($key2 == 'w_o_create_time') {
                        $arr[$key]["create_time_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'accept_time') {
                        $arr[$key]["accept_time_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'person_code'){
                        $arr[$key]['create_person_name'] = $value['create_person_last_name'].$value['create_person_first_name'];
                    }
                    if ($key2 == 'accept_person_code'){
                        $arr[$key]['accept_person_name'] = $value['accept_person_last_name'].$value['accept_person_first_name'];
                    }
                    if ($key2 == 'e_name'){
                        $arr[$key]['e_name']=$value2;
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
    public function getWorkorderListTotal($create_time,$parent_code, $building_code, $create_type, $keyword, $order_type,$rows)
    {  $now      =  date("Y-m-d",time());
        $sql="select count(*) as count from (";

        if (empty($parent_code) && empty($building_code) && empty($create_type) && empty($keyword) && empty($create_time) && empty($order_type))
        {
            $sql.="
select *,
w_o.create_time as w_o_create_time,
p1.first_name as create_person_first_name,
p1.last_name  as create_person_last_name,
p2.first_name as accept_person_first_name,
p2.last_name  as accept_person_last_name
FROM village_work_order as w_o
left join village_order_record as o_r on o_r.work_code=w_o.code
left join  village_person_position as pp on pp.person_code=o_r.accept_person_code and pp.code=(select max(code) from village_person_position A where A.person_code=o_r.accept_person_code group by A.person_code)
left join village_person as p1 on p1.code=w_o.person_code 
left join village_person as p2 on p2.code=o_r.accept_person_code

		
"; } else{

    $sql .= "select *,
w_o.create_time as w_o_create_time,
p1.first_name as create_person_first_name,
p1.last_name  as create_person_last_name,
p2.first_name as accept_person_first_name,
p2.last_name  as accept_person_last_name
FROM village_work_order as w_o
left join village_order_record as o_r on o_r.work_code=w_o.code
left join  village_person_position as pp on pp.person_code=o_r.accept_person_code and pp.code=(select max(code) from village_person_position A where A.person_code=o_r.accept_person_code group by A.person_code)
left join village_person as p1 on p1.code=w_o.person_code 
left join village_person as p2 on p2.code=o_r.accept_person_code
where o_r.work_code=w_o.code
";
            if(empty($create_time)){
                $sql .= " and w_o.create_time<='$now' ";
            }
    if(!empty($create_time)){
        $sql .= " and w_o.create_time<='$create_time' ";
    }

    if(!empty($create_type)){
        $sql .= " and w_o.create_type=$create_type ";
    }

    if(!empty($order_type)){
        $sql .= " and w_o.order_type=$order_type ";
    }

            if (!empty($keyword)) {
                if (preg_match('/^[\x7f-\xff]*\w*\d*$/', $keyword)) {
                    $sql .= " and concat ( w_o.code,p1.last_name,p1.first_name,p2.last_name,p2.first_name) like '%$keyword%'";
                }
                /*  if (preg_match("/^\d*$/", $keyword)) {
                      $sql .= " and w_o.code = $keyword ";
                  }*/
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



}
?>


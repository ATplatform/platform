

<?php
class Material_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //普通查询的sql语句
    public function getMaterialListbyNormal($page, $rows)
    {
        $start = ($page - 1) * $rows;
        $sql = "select * from village_material M";
        $sql .= " LEFT JOIN village_building_stage AS bs ON M.building_code = bs.room_code";
        $sql = $sql . " ORDER BY code ASC limit ".$rows." offset ".$start;
       // $this->load->getMaterial( $sql);
        return $sql;
    }

    //搜索查询的sql语句
    public function getMaterialListbySearch($parent_code,$building_code, $material_type, $keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $sql = "select * ,M.code as m_code, M.name as m_name,M.effective_date as m_effective_date,M.effective_status as m_effective_status,M.remark as mm_remark from village_material M left join village_building_stage AS bs ON M .building_code = bs.room_code";
        $sql .= " LEFT JOIN village_building AS b ON M.building_code = b.code";
        $sql .= " where b.effective_date =(select max(effective_date) from village_building A where b. name=A.name and b.parent_code=A.parent_code and M.building_code=bs.room_code and bs.room_code=b.code  and A.effective_status=TRUE) and b.effective_status = TRUE";
        /*
               if(!empty($time)){
                    $sql .= " where effective_date < now() ";
                }
        */
        if(!empty($material_type)){
            $sql .= " and M.material_type=$material_type ";
        }
        if(!empty($building_code)){
            $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code) or (M.building_code=$building_code and b.parent_code=$parent_code)";
        }

        if (!empty($keyword)) {
            if (preg_match('/^\d*[\x7f-\xff]+\d*$/', $keyword)) {
                $sql .= " and concat(M.supplier,M.remark,M.function,M.name,M.internal_no,M.initial_no) like '%$keyword%'";
            }
            if (preg_match("/^\d*$/", $keyword)) {
                $sql .= " and M.code=$keyword or M.material_type=$keyword or M.internal_no=$keyword or M.initial_no=$keyword";
            }
        }
        $sql = $sql . " ORDER BY b.code ASC limit ".$rows." offset ".$start;
        return $sql;
    }


  // 根据输入的sql语句参数，得到数据
    public function getMaterialList( $sql){
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();
            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "material_type") {
                        if ($value2 == "101") {$arr[$key]['material_type_name'] = '工程物资';}
                        if ($value2 == "102") {$arr[$key]['material_type_name'] = '安防物资';}
                        if ($value2 == "103") {$arr[$key]['material_type_name'] = '消防物资';}
                        if ($value2 == "104") {$arr[$key]['material_type_name'] = '保洁物资';}
                        if ($value2 == "105") {$arr[$key]['material_type_name'] = '办公物资';}
                        /* else{
                             $arr[$key]['material_type_name'] = '物资类别';
                         }*/
                    }
                    //$arr[$key]['room_name'] = "";
                    if ($key2 == 'room') {
                        if(empty($arr[$key]['room']) && empty($arr[$key]['immeuble'])){
                            $arr[$key]['room_name']='和正·智汇谷';
                        }else{
                            $arr[$key]['room_name'] = $value['immeuble'] . '栋';
                            if (!empty($value2)) {$arr[$key]['room_name'] .= $value['room'];}
                        }
                    }
                    if ($key2 == 'code') {
                        $arr[$key][$key2] = intval($value2, 10);
                    } elseif ($key2 == 'effective_date') {
                        $arr[$key]["effective_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    } elseif ($key2 == 'effective_status') {
                        if ($value2 == 't') {
                            $arr[$key]["effective_status_name"] = "有效";
                        } elseif ($value2 == 'f') {
                            $arr[$key]["effective_status_name"] = "无效";
                        } else {
                            $arr[$key]["effective_status_name"] = "未知";
                        }
                    } elseif ($key2 == 'name') {
                        $arr[$key][$key2] = $value2;
                    } elseif ($key2 == 'pcs') {
                        $arr[$key][$key2] = intval($value2, 10);
                    } elseif ($key2 == 'function') {
                        $arr[$key][$key2] = $value2 ? $value2 : '无';
                    } elseif ($key == 'supplier') {
                        $arr[$key][$key2] = $value ? $value2 : '无';
                    } elseif ($key == 'internal_no') {
                        $arr[$key][$key2] = intval($value2, 10);
                    } elseif ($key == 'initial_no') {
                        $arr[$key][$key2] = intval($value2, 10);
                    } elseif ($key == 'remark') {
                        $arr[$key][$key2] = $value2 ? $value2 : '无';
                    }
                }
            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }


    //得到普通查询的数据总条数
    public function getMaterialTotalbyNormal( $rows)
    {
        $sql="select count(*) as count from village_material";
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

    //得到搜索查询的数据总条数
    public function getMaterialTotalbySearch($parent_code,$building_code, $material_type, $keyword, $rows)
    {
        $sql="select count(*) as count from (";

        $sql .= "select *,M.code as m_code, M.name as m_name,M.effective_date as m_effective_date,M.effective_status as m_effective_status from village_material M left join village_building_stage AS bs ON M .building_code = bs.room_code";
        $sql .= " LEFT JOIN village_building AS b ON M.building_code = b.code";
        $sql .= " where b.effective_date =(select max(effective_date) from village_building A where b. name=A.name and b.parent_code=A.parent_code and M.building_code=bs.room_code and bs.room_code=b.code  and A.effective_status=TRUE) and b.effective_status = TRUE";
        /*
                if(!empty($time)){
                    $sql .= " where effective_date < now() ";
                }
        */

        if(!empty($material_type)){
            $sql .= " and M.material_type=$material_type ";
        }
        if(!empty($building_code)){
            $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code)";
        }

        if (!empty($keyword)) {
            if (preg_match("/^\d*$/", $keyword)) {
                $sql .= " and M.code=$keyword or M.material_type=$keyword";
            }
            if (preg_match('/^\d*[\x7f-\xff]+\d*$/', $keyword)) {
                $sql .= " and concat(M.supplier,M.remark,M.function,M.name) like '%$keyword%'";
            }
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



    //插入数据
    public function insertMaterial($code, $effective_date, $effective_status, $name, $pcs, $material_type, $building_code, $supplier, $internal_no, $initial_no, $remark, $create_time)
    {
        $now="'".date('Y-m-d H:i:s',time())."'";
        //先查出最新的code;
        $sql = " select code from village_material order by code desc";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if(empty($row['code'])){
            $code = '1000001';
        }
        else {
            $code = $row['code'] +1;
        }
        $sql = "INSERT INTO village_material (code,effective_date,effective_status,name,pcs,material_type,building_code,supplier,internal_no,initial_no,remark,create_time) values (".

            $this->db->escape($code).", ".
            $this->db->escape($effective_date).", ".
            $this->db->escape($effective_status).", ".
            $this->db->escape($name).", ".
            $this->db->escape($pcs).", ".
            $this->db->escape($material_type).",".
            $this->db->escape($building_code).", ".
            $this->db->escape($supplier).", ".
            $this->db->escape($internal_no).", ".
            $this->db->escape($initial_no).", ".
            $this->db->escape($remark).", ".$now.")"
        ;
        $this->db->query($sql);
        return $this->db->affected_rows();
    }



    //获排名最前的数据
    public function getMaterialCode()
    {
        $sql = "select code from village_material order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['code'];
    }


    //动态获取所有楼宇信息
    public function getMaterialNameCode()
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


}
?>


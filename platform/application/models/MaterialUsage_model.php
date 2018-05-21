

<?php
class Material_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMaterialList($building_code, $material_type, $keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;

        //$sql = "select material_type,code,name,building_code,pcs,effective_date,function,supplier,internal_no,initial_no,remark from village_material";

        $sql = "SELECT * from village_material as m left join village_building_stage as bs on m.building_code = bs.room_code";

        /*
                if(!empty($time)){
                    $sql .= " where effective_date < now() ";
                }*/

        /*   if(!empty($material_type)){
               $sql .= " where material_type=$material_type ";

           if(!empty($building_code)){
               $sql .= " and building_code=$building_code ";
           }
           }
           if(empty($material_type) && !empty($building_code)){
               $sql .= " where building_code=$building_code ";
           }*/

        if (!empty($keyword)) {
            if (preg_match("/^\d*$/", $keyword)) {
                $sql .= " where code=$keyword or material_type=$keyword or supplier like '%$keyword%' or remark like '%$keyword%' or function like '%$keyword%'";
            }
            if (preg_match('/^\d*[\x7f-\xff]+\d*$/', $keyword)) {
                $sql .= " where name like '%$keyword%' or supplier like '%$keyword%' or remark like '%$keyword%' or function like '%$keyword%' ";
            }
            if (!empty($material_type)) {
                $sql .= " and material_type=$material_type ";
            }
            if (!empty($building_code)) {
                $sql .= " and building_code=$building_code ";
            }
        }

        if (empty($keyword) && !empty($material_type)) {
            $sql .= " where material_type=$material_type ";
            if (!empty($building_code)) {
                $sql .= " and building_code=$building_code ";
            }
        }

        if (empty($keyword) && empty($material_type) && !empty($building_code)) {
            $sql .= " where building_code=$building_code";
        }

//判断keyword是数字还是汉字
        /*  if(!empty($keyword)){

              if(preg_match("/^\d*$/",$keyword)){
                  $sql .= " where code=$keyword or material_type=$keyword or supplier like '%$keyword%' or remark like '%$keyword%' or function like '%$keyword%'";
              }

              if(preg_match('/^\d*[\x7f-\xff]+\d*$/', $keyword)){
              $sql .= " where name like '%$keyword%' or supplier like '%$keyword%' or remark like '%$keyword%' or function like '%$keyword%' ";
              }
      }*/


        $sql = $sql . " order by code asc limit " . $rows . " offset " . $start;

        $query = $this->db->query($sql);
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();
            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "material_type") {
                        if ($value2 == "101") {
                            $arr[$key]['material_type_name'] = '工程物资';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['material_type_name'] = '安防物资';
                        }
                        if ($value2 == "103") {
                            $arr[$key]['material_type_name'] = '消防物资';
                        }
                        if ($value2 == "104") {
                            $arr[$key]['material_type_name'] = '保洁物资';
                        }
                        if ($value2 == "105") {
                            $arr[$key]['material_type_name'] = '办公物资';
                        }
                        /* else{
                             $arr[$key]['material_type_name'] = '物资类别';
                         }*/

                    }
                    //$arr[$key]['room_name'] = "";
                    if ($key2 == 'room') {
                        $arr[$key]['room_name'] = $value['immeuble'] . '栋';

                        if (!empty($value2)) {
                            $arr[$key]['room_name'] .= $value['room'];
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
            //$arr=$this->MaterialListArray($q->result_array());
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }


    public function MaterialListArray($data)
    {
        $material_type_arr = array(array('code' => '101', 'name' => '工程物资'), array('code' => '102', 'name' => '安防物资'), array('code' => '103', 'name' => '消防物资'), array('code' => '104', 'name' => '保洁物资'), array('code' => '105', 'name' => '办公物资'));
        $arr = array();
        foreach ($data as $row) {
            $item = array();
            foreach ($row as $key => $value) {
                if ($key == 'code') {
                    $item["code"] = intval($value, 10);
                } elseif ($key == 'effective_date') {
                    $item["effective_date"] = substr($value, 0, 4) . "-" . substr($value, 5, 2) . "-" . substr($value, 8, 2);
                    // $item["effective_date"]=$value;
                } elseif ($key == 'effective_status') {
                    if ($value == 't') {
                        $item["effective_status"] = "有效";
                    } elseif ($value == 'f') {
                        $item["effective_status"] = "无效";
                    } else {
                        $item["effective_status"] = "未知";
                    }
                } elseif ($key == 'name') {
                    $item["name"] = $value;
                } elseif ($key == 'pcs') {
                    $item["pcs"] = intval($value, 10) ? intval($value, 10) : null;
                } elseif ($key == 'material_type') {
                    $item["material_type"] = intval($value, 10);
                    foreach ($material_type_arr as $key => $v) {
                        if ($value == $v['code']) {
                            $item["material_type"] = $v['name'];
                            break;
                        }
                    }
                } elseif ($key == 'function') {
                    $item["function"] = $value ? $value : '无';
                } elseif ($key == 'supplier') {
                    $item["supplier"] = $value ? $value : '无';
                } elseif ($key == 'internal_no') {
                    $item["internal_no"] = intval($value, 10);
                } elseif ($key == 'initial_no') {
                    $item["initial_no"] = intval($value, 10);
                } elseif ($key == 'remark') {
                    $item["remark"] = $value ? $value : '无';
                }
            }
            $arr[] = $item;
        }
        return $arr;
    }

    public function getMaterialTotal($building_code, $material_type, $keyword, $rows)
    {
        $sql = "select count(*) as count from village_material";
        $limit = false;
        if (!empty($material_type)) {
            $sql .= " where material_type=$material_type ";
            $limit = true;
            if (!empty($building_code)) {
                $sql .= " and building_code=$building_code ";
            }
            if (!empty($keyword)) {
                $sql .= " and name like '%$keyword%' ";
            }
        }

        if (empty($material_type) && !empty($building_code)) {
            $sql .= " where building_code=$building_code ";
            $limit = true;
            if (!empty($keyword)) {
                $sql .= " and name like '%$keyword%' ";
            }
        }

        if (empty($material_type) && empty($building_code) && !empty($keyword)) {
            $sql .= " where name like '%$keyword%' ";
            $limit = true;
        }


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


    public function getMaterialCode()
    {
        $sql = "select code from village_material order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['code'];
    }



    public function insertMaterial($code, $effective_date, $effective_status, $name, $pcs, $material_type, $building_code, $supplier, $internal_no, $initial_no, $remark, $create_time)
    {

        $sql = "INSERT INTO village_material (code,effective_date,effective_status,name,pcs,material_type,building_code,supplier,internal_no,initial_no,remark,create_time) values ($code,'$effective_date',$effective_status,'$name',$pcs,$material_type,$building_code,'$supplier','$internal_no','$initial_no', '$remark','$create_time')";

        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }


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

public function getBuildingTreeData(){

}



}
?>


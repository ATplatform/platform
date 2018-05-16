

<?php
class Material_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMaterialList($keyword,$page, $rows)
    {
        $start = ($page - 1) * $rows;

        $sql = "select material_type,code,name,building_code,pcs,effective_date,function,supplier,internal_no,initial_no,remark from village_material";



        if(!empty($keyword)){
            $sql .= " where name like '%$keyword%' or supplier like '%$keyword%' or remark like '%$keyword%' or code=$keyword or material_type=$keyword ";
        }

        $sql=$sql." order by code asc limit ".$rows." offset ".$start;
        $query = $this->db->query($sql);
        $q = $this->db->query($sql); //自动转义
        if ( $q->num_rows() > 0 ) {
            $arr=$this->MaterialListArray($q->result_array());
            $json=json_encode($arr);
            return $json;
        }
        return false;
    }


    public function MaterialListArray($data)
    {
        $material_type_arr = array(array('code' => '1', 'name' => '工程物资'), array('code' => '2', 'name' => '安防物资'), array('code' => '3', 'name' => '消防物资'), array('code' => '4', 'name' => '保洁物资'), array('code' => '5', 'name' => '办公物资'));
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
                    $item["pcs"] = intval($value, 10);
                } elseif ($key == 'material_type') {
                    $item["material_type"] = intval($value, 10);
                    foreach ($material_type_arr as $key => $v) {
                        if ($value == $v['code']) {
                            $item["material_type"] = $v['name'];
                            break;
                        }
                    }
                }elseif ($key == 'function') {
                    $item["function"] = $value ? $value : '无';
                } elseif ($key == 'supplier') {
                    $item["supplier"] = $value ? $value : '无';
                } elseif ($key == 'internal_no') {
                    $item["internal_no"] = intval($value, 10);
                }elseif ($key == 'initial_no') {
                    $item["initial_no"] = intval($value, 10);
                }elseif ($key == 'remark') {
                    $item["remark"] = $value ? $value : '无';
                }
            }
            $arr[] = $item;
        }
        return $arr;
    }

    public function getMaterialTotal($keyword,$rows){
        $sql = "select count(*) as count from village_material";
        $limit = false;
        if(!empty($keyword)){
            $sql .= " where name like '%$keyword%' ";
            $limit = true;
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
    public function getMaterialCode(){
        $sql = "select code from village_material order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['code'];
    }
//,$effective_date,$effective_status,$name,$pcs,$material_type,$building_code,$supplier,$now,$internal_no,$initial_no, $remark
    public function insertMaterial($code,$effective_date,$effective_status,$name,$pcs,$material_type,$building_code,$supplier,$internal_no,$initial_no,$remark,$create_time){
        //if(is_null($pcs)||empty($pcs)){
        //}
        //else{
        //,effective_date,effective_status,name,pcs,material_type,building_code,supplier,now,internal_no,initial_no,remark
        //i,$effective_date,$effective_status,$name,$pcs,$material_type,$building_code,$supplier,$now,$internal_no,$initial_no, $remark
            $sql = "INSERT INTO village_material (code,effective_date,effective_status,name,pcs,material_type,building_code,supplier,internal_no,initial_no,remark,create_time) values ($code,'$effective_date',$effective_status,'$name',$pcs,$material_type,$building_code,'$supplier','$internal_no','$initial_no', '$remark','$create_time')";
        //}
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

}




?>

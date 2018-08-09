

<?php
class h5_pay_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    ///////////////////////////////////获取数据////////////////////////////////////
    /////////////数据内容////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    /////////////数据数目////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    public function bill_list_sql($person_code)
    {
        $sql="select * from village_bill_list where pay_status=101 or pay_status=102";
        return $sql;
    }





    //////////////// 根据输入的sql语句参数，得到数据////////////////
    public function getbill_list( $sql){
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();


            $json = json_encode($arr);
            return $json;
        }
        return false;
    }

    public function getbill_list_record($person_code){
        $sql="select * from village_bill_list where pay_status=103";
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "bill_type") {
                        if($value2=='101'){
                            $arr[$key]['bill_type_name']="车位租金";
                        }
                        if($value2=='102'){
                            $arr[$key]['bill_type_name']="临时车缴费";
                        }
                        if($value2=='103'){
                            $arr[$key]['bill_type_name']="物业费缴费";
                        }
                        if($value2=='104'){
                            $arr[$key]['bill_type_name']="二次供水";
                        }
                        if($value2=='105'){
                            $arr[$key]['bill_type_name']="车位服务";
                        }
                        if($value2=='106'){
                            $arr[$key]['bill_type_name']="增值服务";
                        }
                        if($value2=='999'){
                            $arr[$key]['bill_type_name']="其他";
                        }

                    }

                    if ($key2 == "pay_method") {
                        if($value2=='201'){
                            $arr[$key]['pay_method_name']="微信支付";
                        }
                        if($value2=='202'){
                            $arr[$key]['pay_method_name']="支付宝支付";
                        }
                        else{
                            $arr[$key]['pay_method_name']="未知";

                        }
                    }
                }
            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }


    public function getbill_list_other($person_code){
        $sql="select * from village_bill_list where bill_type=106 and (pay_status=102 or pay_status=101)";
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "bill_type") {
                        if($value2=='101'){
                            $arr[$key]['bill_type_name']="车位租金";
                        }
                        if($value2=='102'){
                            $arr[$key]['bill_type_name']="临时车缴费";
                        }
                        if($value2=='103'){
                            $arr[$key]['bill_type_name']="物业费缴费";
                        }
                        if($value2=='104'){
                            $arr[$key]['bill_type_name']="二次供水";
                        }
                        if($value2=='105'){
                            $arr[$key]['bill_type_name']="车位服务";
                        }
                        if($value2=='106'){
                            $arr[$key]['bill_type_name']="增值服务";
                        }
                        if($value2=='999'){
                            $arr[$key]['bill_type_name']="其他";
                        }

                    }

                    if ($key2 == "pay_method") {
                        if($value2=='201'){
                            $arr[$key]['pay_method_name']="微信支付";
                        }
                        if($value2=='202'){
                            $arr[$key]['pay_method_name']="支付宝支付";
                        }
                        else{
                            $arr[$key]['pay_method_name']="未知";

                        }
                    }
                }
            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }

    public function getbill_list_other_record($person_code){
        $sql="select * from village_bill_list where bill_type=106 and pay_status=103 ";
        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == "bill_type") {
                        if($value2=='101'){
                            $arr[$key]['bill_type_name']="车位租金";
                        }
                        if($value2=='102'){
                            $arr[$key]['bill_type_name']="临时车缴费";
                        }
                        if($value2=='103'){
                            $arr[$key]['bill_type_name']="物业费缴费";
                        }
                        if($value2=='104'){
                            $arr[$key]['bill_type_name']="二次供水";
                        }
                        if($value2=='105'){
                            $arr[$key]['bill_type_name']="车位服务";
                        }
                        if($value2=='106'){
                            $arr[$key]['bill_type_name']="增值服务";
                        }
                        if($value2=='999'){
                            $arr[$key]['bill_type_name']="其他";
                        }

                    }

                    if ($key2 == "pay_method") {
                        if($value2=='201'){
                            $arr[$key]['pay_method_name']="微信支付";
                        }
                        if($value2=='202'){
                            $arr[$key]['pay_method_name']="支付宝支付";
                        }
                        else{
                            $arr[$key]['pay_method_name']="未知";

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
    public function get_park_car($bill_source_code,$village_id)
    {
        $sql="select * from village_park_rent where parking_lot_code=$bill_source_code and village_id=$village_id";
          $q = $this->db->query($sql);
            $arr = $q->result_array();
        return  $arr;


    }

    public function get_car_service($bill_source_code,$village_id)
    {
        $sql="select * from village_parking_lot where parkcode=$bill_source_code and village_id=$village_id";
        $q = $this->db->query($sql);
        $arr = $q->result_array();
        return  $arr;
    }

    public function get_all_park_car($person_code,$village_id)
    {
        $sql="select * from village_park_rent where renter=$person_code and village_id=$village_id";
        $q = $this->db->query($sql);
        $arr = $q->result_array();
        return  $arr;
    }

    public function get_all_property($person_code,$village_id)
    {
        $sql="select pb.building_code as pb_code,pb.person_code,ppe_fee.*,tmp.* from village_person_building  as pb
left join village_dtl_ppe_fee as ppe_fee on ppe_fee.building_code=pb.building_code 
left join village_tmp_building as tmp on tmp.code=pb.building_code
where pb.person_code=$person_code and pb.village_id=$village_id and pb.id=(select max(id) from village_person_building A where A.building_code=pb.building_code ) ";
        $q = $this->db->query($sql);
        $arr = $q->result_array();



        foreach ($arr as $key => $value) {

            $arr[$key]["building_name"] = $this->getHouseholdInfo($value);

        }

        return  $arr;
    }

    public function get_all_service($person_code,$village_id)
    {
        $sql="select * from village_parking_lot where owner=$person_code and village_id=$village_id ";
        $q = $this->db->query($sql);
        $arr = $q->result_array();


        return  $arr;
    }


   public function get_all_property_record($person_code,$village_id)
    {
        $sql="select * from village_parking_lot where owner=$person_code and village_id=$village_id ";
        $q = $this->db->query($sql);
        $arr = $q->result_array();


        return  $arr;
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

}
?>


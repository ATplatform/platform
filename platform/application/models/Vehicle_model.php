

<?php
class Vehicle_model extends CI_Model
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
    public function sqlTogetList($effective_date,$building_code, $parent_code,$if_resident,$vehicle_type,$vehicle_auz,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());

         /////////////////判断为普通查询或搜索查询////////////////////////////
         if (empty($effective_date) && empty($building_code) && empty($parent_code)  && empty($if_resident) && empty($vehicle_type) && empty($vehicle_auz)&& empty($keyword))

         /////////////////////////普通查询sql语句/////////////////////////
         {
             $sql = "select 
v.code as v_code,
v.effective_date as v_effective_date,
v.effective_status as v_effective_status,
v.person_code as v_person_code,
v.vehicle_type as v_vehicle_type,
v.if_electro as v_if_electro,
v.if_resident as v_if_resident,
v.licence as v_licence,
v.if_temp as v_if_temp,
v.owner as v_owner,
v.brand as v_brand,
v.model as v_model,
v.color as v_color,
v.owner as v_owner,
v.remark as v_remark,
auz.code as auz_code,
auz.person_code as auz_person_code,
auz.begin_date as auz_begin_date,
auz.end_date as auz_end_date,
auz.remark as auz_remark
from village_vehicle as v
left join village_person as p on v.person_code=p.code
left join village_person_building as pb on v.person_code=pb.person_code
left join village_tmp_building as tmp on tmp.code=pb.building_code
left join village_vehicle_auz as auz on auz.vehicle_code=v.code
where auz.code = (select max(code) from village_vehicle_auz as auz_s where auz.vehicle_code=auz_s.vehicle_code)

";}



         /////////////////////////搜索查询sql语句/////////////////////////
         else {
             $sql = "select 
v.code as v_code,
v.effective_date as v_effective_date,
v.effective_status as v_effective_status,
v.person_code as v_person_code,
v.vehicle_type as v_vehicle_type,
v.if_electro as v_if_electro,
v.if_resident as v_if_resident,
v.licence as v_licence,
v.if_temp as v_if_temp,
v.owner as v_owner,
v.brand as v_brand,
v.model as v_model,
v.color as v_color,
v.owner as v_owner,
v.remark as v_remark,
auz.code as auz_code,
auz.person_code as auz_person_code,
auz.begin_date as auz_begin_date,
auz.end_date as auz_end_date,
auz.remark as auz_remark
from village_vehicle as v
left join village_person as p on v.person_code=p.code
left join village_person_building as pb on v.person_code=pb.person_code
left join village_tmp_building as tmp on tmp.code=pb.building_code
left join village_vehicle_auz as auz on auz.vehicle_code=v.code
where auz.code = (select max(code) from village_vehicle_auz as auz_s where auz.vehicle_code=auz_s.vehicle_code)
";
         }
             if(empty($effective_date)){
                 $sql .= " and v.effective_date <= '$now' ";
             }
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
                 $sql.=$this->vehicle_auzForselect($vehicle_auz);


                 /*
                  $sql .= " and v.effective_status='$vehicle_auz' ";*/
             }


               if (!empty($keyword)) {
                   if (preg_match('/^[\x7f-\xff]*\w*\d*$/', $keyword)) {
                       $sql .= " and concat (v.code,v.licence, owner,model,p.last_name,p.first_name) like '%$keyword%'";
                   }

               }




        $sqlshow = $sql . " ORDER BY v.code ASC limit ".$rows." offset ".$start;
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
                    if($key2=="v_brand"){
                        foreach($brand_arr as $k2 => $v2){
                            if($value2 == $v2['code']){
                                $arr[$key]["v_brand_name"] = $v2['name'];
                                break;
                            }
                        }
                    }
                    if ($key2 == "v_vehicle_type") {
                        if ($value2 == "101") {$arr[$key]['v_vehicle_type_name'] = '轿车';}
                        if ($value2 == "102") {$arr[$key]['v_vehicle_type_name'] = '客车';}
                        if ($value2 == "103") {$arr[$key]['v_vehicle_type_name'] = '货车';}
                        if ($value2 == "104") {$arr[$key]['v_vehicle_type_name'] = '专用汽车';}
                        if ($value2 == "105") {$arr[$key]['v_vehicle_type_name'] = '摩托车';}
                        if ($value2 == "106") {$arr[$key]['v_vehicle_type_name'] = '电瓶车';}
                        if ($value2 == "107") {$arr[$key]['v_vehicle_type_name'] = '自行车';}
                        if ($value2 == "999") {$arr[$key]['v_vehicle_type_name'] = '其他车辆';}
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
                    if ($key2 == 'v_if_resident') {
                        if ($arr[$key]['v_if_resident'] == 't') {
                            $arr[$key]['v_if_resident_name'] = "小区车";
                        }
                        if ($arr[$key]['v_if_resident'] == 'f') {
                            $arr[$key]['v_if_resident_name'] = "访客车";
                        }
                    }
                    if ($key2 == 'v_if_temp') {
                        if ($arr[$key]['v_if_temp'] == 't') {
                            $arr[$key]['v_if_temp_name'] = "是";
                        }
                        if ($arr[$key]['v_if_temp'] == 'f') {
                            $arr[$key]['v_if_temp_name'] = "否";
                        }
                    }
                    if ($key2 == 'v_if_electro') {
                        if ($arr[$key]['v_if_electro'] == 't') {
                            $arr[$key]['v_if_electro_name'] = "是";
                        }
                        if ($arr[$key]['v_if_electro'] == 'f') {
                            $arr[$key]['v_if_electro_name'] = "否";
                        }
                    }

                    $auzfornow=$this->vehicle_auzForNow( $arr[$key]['v_code']);
                    $arr[$key]['auzfornow']=$auzfornow;
                    if($auzfornow==true){
                        $arr[$key]['auzfornow_name'] = "有效";
                    }
                    if($auzfornow==false){
                        $arr[$key]['auzfornow_name'] = "无效";
                    }

                    if ($key2 == "auz_code") {
                        $arr[$key][$key2]=$value2 ;
                    }
                    if ($key2 == "auz_person_code") {
                        $arr[$key][$key2]=$value2 ;
                        if(!empty($value['auz_person_code']) ) {

                            $arr[$key]['auz_person_name'] = "";

                            $person = $this->getPersonByCode($value['auz_person_code']);
                            $name = $person['full_name'];
                            $arr[$key]['auz_person_name'] = $name;
                        }

                    }
                    if ($key2 == "auz_begin_date") {
                        $arr[$key][$key2]=$arr[$key]["auz_begin_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                    }
                    if ($key2 == "auz_end_date") {
                        $arr[$key][$key2]=$arr[$key]["auz_end_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                    }
                    if ($key2 == "auz_remark") {
                        $arr[$key][$key2]=$value2 ;
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


    public function sqlTogetRecord($date,$type, $keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());

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
where a_rcd.service_code=p.code 
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

";   }
            if(empty($effective_date)){
                $sql .= " and a_rcd.date <= '$now' ";
            }
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




        $sqlshow = $sql . " ORDER BY a.code ASC limit ".$rows." offset ".$start;
        $arrayres=array($sql,$sqlshow);
        return $arrayres;
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


public function insert($village_id,$code,$effective_date,$licence,$owner,$color, $model,$remark,$brand,$vehicle_type,$person_code,$effective_status,$if_resident,$if_electro,$if_temp,$auz_code,$auz_person_code,$begin_date,$end_date,$auz_remark,$create_time)
{

    $sql = " INSERT INTO village_vehicle (village_id,code,effective_date,licence,owner,color, model,remark,brand,vehicle_type,person_code,effective_status,if_resident,if_electro,if_temp,create_time) values (".
        $this->db->escape($village_id).", ".
        $this->db->escape($code).", ".
        $this->db->escape($effective_date).", ".
        $this->db->escape($licence).", ".
        $this->db->escape($owner).", ".
        $this->db->escape($color).", ".
        $this->db->escape($model).", ".
        $this->db->escape($remark).", ".
        $this->db->escape($brand).", ".
        $this->db->escape($vehicle_type).", ".
        $this->db->escape($person_code).", ".
        $this->db->escape($effective_status).", ".
        $this->db->escape($if_resident).", ".
        $this->db->escape($if_electro).", ".
        $this->db->escape($if_temp).", ".
        $this->db->escape($create_time).")";
    $this->db->query($sql);

    $sql = " INSERT INTO village_vehicle_auz (code,vehicle_code,person_code,begin_date,end_date,remark,create_time) values (".

        $this->db->escape($auz_code).", ".
        $this->db->escape($code).", ".
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

                    $arr[$key]['pp_name'] = $arr[$key]['last_name'] . $arr[$key]['first_name'] ;

            }

        return $arr;

    }


public function getactivity_codeUrl(){
    $sql = "select code as a_code,name as a_name from village_activity order by code asc ";
    $query = $this->db->query($sql);
    $row = $query->result_array();
    return $row;
}

    public function getpresentCodeforauz($code){
        $sql = "select *  from village_vehicle_auz where vehicle_code=$code ";
        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }



    public function vehicle_auzForNow($code){

        $sql="SELECT
	*
FROM
	village_vehicle AS v,
  village_vehicle_auz AS auz 
WHERE
$code = auz.vehicle_code and
	auz.begin_date < now()
AND auz.end_date > now()";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {return true;}
             else{return false;}
    }


 public function vehicle_auzForselect($select){
       if($select=='101'){
           $sql = "
and v.code in(
select code from village_vehicle as v
where v.code not in (
SELECT
	auz.vehicle_code
FROM
village_vehicle_auz AS auz 
 left join 	village_vehicle AS v on  auz.vehicle_code=v.code ))";
           return $sql;
       }
       if($select=='102'){
           $sql = "
and v.code in(
select code from village_vehicle as v
where v.code in (
SELECT
	auz.vehicle_code
FROM
village_vehicle_auz AS auz 
 left join 	village_vehicle AS v on  auz.vehicle_code=v.code 
where auz.end_date > now() ))";
           return  $sql;
       }
       if($select=='103'){
           $sql = "
and v.code in(
select code from village_vehicle as v
where v.code not in (
SELECT
	auz.vehicle_code
FROM
village_vehicle_auz AS auz 
 left join 	village_vehicle AS v on  auz.vehicle_code=v.code 
where auz.end_date > now() ) 
and  v.code in (
SELECT
	auz.vehicle_code
FROM
village_vehicle_auz AS auz 
 left join 	village_vehicle AS v on  auz.vehicle_code=v.code 
 ) )";

           return $sql;
       }



     $sql="SELECT
	*
FROM
village_vehicle_auz AS auz 

 left join 	village_vehicle AS v on  auz.vehicle_code=v.code  
";
     $q1 = $this->db->query($sql);
     if ($q1->num_rows() == 0) {return 101;}
     if ($q1->num_rows() > 0) {
         foreach ($q1 as $key => $value) {
             if($key=='code'){
             $sql = "SELECT
	auz.code
FROM
village_vehicle_auz AS auz 
 left join 	village_vehicle AS v on  auz.vehicle_code=v.code 
where auz.vehicle_code=$value
AND auz.end_date > now()";
             $q2 = $this->db->query($sql);
             if ($q2->num_rows() > 0) {
                 return 102;
             } else {
                 return 103;
             }
         }
         }
     }
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


    public function getauzbyMax_begin_date($code){
        $sql="select * from village_vehicle_auz 
where vehicle_code=$code and 
begin_date=(select max(begin_date) from village_vehicle_auz where vehicle_code=$code) 
and 
end_date=(select max(end_date) from village_vehicle_auz where vehicle_code=$code) 
limit 1 
";
        $q = $this->db->query($sql);

        if ($q->num_rows() > 0) {
            $arr= $q->row_array();
            foreach ($arr as $key => $value) {

                if ($key == 'begin_date') {
                    $arr['begin_date'] = substr($value, 0, 4) . "-" . substr($value, 5, 2) . "-" . substr($value, 8, 2);
                }
                if ($key == 'end_date') {
                    $arr['end_date'] = substr($value, 0, 4) . "-" . substr($value, 5, 2) . "-" . substr($value, 8, 2);
                }
            }
            return $arr;
        }
        else{
            return false;
        }
    }

public function updateVehicle($village_id,$code,$effective_date,$effective_status
,$person_code,$licence,$owner,$color,$model,$remark,$vehicle_type,$if_resident,$if_electro,$if_temp,$create_time){

    $sql = " update village_vehicle

       set effective_date=".$this->db->escape($effective_date).",".
        "village_id=".$this->db->escape($village_id).",".
        "licence=".$this->db->escape($licence).",".
        "owner=".$this->db->escape($owner).",".
        "color=".$this->db->escape($color).",".
        "model=".$this->db->escape($model).",".
        "remark=".$this->db->escape($remark).",".
        "vehicle_type=".$this->db->escape($vehicle_type).",".
        "person_code=".$this->db->escape($person_code).",".
        "effective_status=".$this->db->escape($effective_status).",".
        "if_resident=".$this->db->escape($if_resident).",".
        "if_electro=".$this->db->escape($if_electro).",".
        "if_temp=".$this->db->escape($if_temp).",".
        "create_time=".$this->db->escape($create_time)." ".
        "where code=$code";

    $this->db->query($sql);

}


public function updateAuz($village_id,$code,$vehicle_code,$begin_date
,$end_date,$remark,$person_code,$create_time){
    $sql = " INSERT INTO village_vehicle_auz (village_id,code,vehicle_code,person_code,begin_date,end_date,remark,create_time) values (".
        $this->db->escape($village_id).", ".
        $this->db->escape($code).", ".
        $this->db->escape($vehicle_code).", ".
        $this->db->escape($person_code).", ".
        $this->db->escape($begin_date).", ".
        $this->db->escape($end_date).", ".
        $this->db->escape($remark).", ".
        $this->db->escape($create_time).")";
    $this->db->query($sql);

}



public function sqlTogetAuz($effective_date,$if_resident,$auz_2,$keyword, $page, $rows)
{
    $start = ($page - 1) * $rows;
    $now   =  date("Y-m-d",time());

    /////////////////判断为普通查询或搜索查询////////////////////////////
    if (empty($effective_date) && empty($if_resident) && empty($auz_2) && empty($keyword))

        /////////////////////////普通查询sql语句/////////////////////////
    {
        $sql = "select 
v.code as v_code,
v.effective_date as v_effective_date,
v.effective_status as v_effective_status,
v.person_code as v_person_code,
v.vehicle_type as v_vehicle_type,
v.if_electro as v_if_electro,
v.if_resident as v_if_resident,
v.licence as v_licence,
v.if_temp as v_if_temp,
v.owner as v_owner,
v.brand as v_brand,
v.model as v_model,
v.color as v_color,
v.owner as v_owner,
v.remark as v_remark,
auz.code as auz_code,
auz.person_code as auz_person_code,
auz.begin_date as auz_begin_date,
auz.end_date as auz_end_date,
auz.remark as auz_remark
from village_vehicle as v
left join village_person as p on v.person_code=p.code
left join village_vehicle_auz as auz on auz.vehicle_code=v.code
where auz.vehicle_code=v.code
";}



    /////////////////////////搜索查询sql语句/////////////////////////
    else {
        $sql = "select 
v.code as v_code,
v.effective_date as v_effective_date,
v.effective_status as v_effective_status,
v.person_code as v_person_code,
v.vehicle_type as v_vehicle_type,
v.if_electro as v_if_electro,
v.if_resident as v_if_resident,
v.licence as v_licence,
v.if_temp as v_if_temp,
v.owner as v_owner,
v.brand as v_brand,
v.model as v_model,
v.color as v_color,
v.owner as v_owner,
v.remark as v_remark,
auz.code as auz_code,
auz.person_code as auz_person_code,
auz.begin_date as auz_begin_date,
auz.end_date as auz_end_date,
auz.remark as auz_remark
from village_vehicle as v
left join village_person as p on v.person_code=p.code
left join village_vehicle_auz as auz on auz.vehicle_code=v.code
where auz.vehicle_code=v.code
"; }
        if(empty($effective_date)){
            $sql .= " and auz.begin_date<='$now' ";
            $sql .= " and auz.end_date>='$now'  ";
        }

        if(!empty($effective_date)){
            $sql .= " and auz.begin_date<='$effective_date' ";
            $sql .= " and auz.end_date>='$effective_date' ";
        }

        if(!empty($auz_2)){
            if($auz_2=='101')
            {
                $sql .= " and auz.begin_date<=now() ";

            }
            if($auz_2=='102')
            {
                $sql .= " and auz.begin_date>now() ";
            }
        }

        if(!empty($if_resident)){
            $sql .= " and v.if_resident='$if_resident' ";
        }


        if (!empty($keyword)) {
            if (preg_match('/^[\x7f-\xff]*\w*\d*$/', $keyword)) {
                $sql .= " and concat (v.code,v.licence, owner,model,p.last_name,p.first_name) like '%$keyword%'";
            }

        }


    $sqlshow = $sql . " ORDER BY auz.code ASC limit ".$rows." offset ".$start;
    $arrayres=array($sql,$sqlshow);
    return $arrayres;
}



public function getAuzlist($sql)
{
    $brand_arr = $this->brand_arr;
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
                if($key2=="v_brand"){
                    foreach($brand_arr as $k2 => $v2){
                        if($value2 == $v2['code']){
                            $arr[$key]["v_brand_name"] = $v2['name'];
                            break;
                        }
                    }
                }
                if ($key2 == "v_vehicle_type") {
                    if ($value2 == "101") {$arr[$key]['v_vehicle_type_name'] = '轿车';}
                    if ($value2 == "102") {$arr[$key]['v_vehicle_type_name'] = '客车';}
                    if ($value2 == "103") {$arr[$key]['v_vehicle_type_name'] = '货车';}
                    if ($value2 == "104") {$arr[$key]['v_vehicle_type_name'] = '专用汽车';}
                    if ($value2 == "105") {$arr[$key]['v_vehicle_type_name'] = '摩托车';}
                    if ($value2 == "106") {$arr[$key]['v_vehicle_type_name'] = '电瓶车';}
                    if ($value2 == "107") {$arr[$key]['v_vehicle_type_name'] = '自行车';}
                    if ($value2 == "999") {$arr[$key]['v_vehicle_type_name'] = '其他车辆';}
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

                }
                if ($key2 == 'v_effective_status') {
                    if ($arr[$key]['v_effective_status'] == 't') {
                        $arr[$key]['v_effective_status_name'] = "有效";
                    }
                    if ($arr[$key]['v_effective_status'] == 'f') {
                        $arr[$key]['v_effective_status_name'] = "无效";
                    }
                }
                if ($key2 == 'v_if_resident') {
                    if ($arr[$key]['v_if_resident'] == 't') {
                        $arr[$key]['v_if_resident_name'] = "小区车";
                    }
                    if ($arr[$key]['v_if_resident'] == 'f') {
                        $arr[$key]['v_if_resident_name'] = "访客车";
                    }
                }
                if ($key2 == 'v_if_temp') {
                    if ($arr[$key]['v_if_temp'] == 't') {
                        $arr[$key]['v_if_temp_name'] = "是";
                    }
                    if ($arr[$key]['v_if_temp'] == 'f') {
                        $arr[$key]['v_if_temp_name'] = "否";
                    }
                }
                if ($key2 == 'v_if_electro') {
                    if ($arr[$key]['v_if_electro'] == 't') {
                        $arr[$key]['v_if_electro_name'] = "是";
                    }
                    if ($arr[$key]['v_if_electro'] == 'f') {
                        $arr[$key]['v_if_electro_name'] = "否";
                    }
                }


                $auzfornow=$this->vehicle_auzForNow( $arr[$key]['v_code']);
                $arr[$key]['auzfornow']=$auzfornow;
                if($auzfornow==true){
                    $arr[$key]['auzfornow_name'] = "有效";
                }
                if($auzfornow==false){
                    $arr[$key]['auzfornow_name'] = "无效";
                }

                if ($key2 == "auz_code") {
                    $arr[$key][$key2]=$value2;
                }
                if ($key2 == "auz_person_code") {
                    $arr[$key][$key2]=$value2 ;
                    if(!empty($value['auz_person_code']) ) {

                        $arr[$key]['auz_person_name'] = "";

                        $person = $this->getPersonByCode($value['auz_person_code']);
                        $name = $person['full_name'];
                        $arr[$key]['auz_person_name'] = $name;
                    }

                }
                if ($key2 == "auz_begin_date") {
                    $arr[$key][$key2]=$arr[$key]["auz_begin_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                }
                if ($key2 == "auz_end_date") {
                    $arr[$key][$key2]=$arr[$key]["auz_end_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                }
                if ($key2 == "auz_remark") {
                    $arr[$key][$key2]=$value2;
                }
                if ($key2 == "v_licence") {
                    $arr[$key][$key2]=$value2 ;
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


public function verifyauz($licence)
{
    $sql="select licence from village_vehicle where licence='$licence'";
    $q = $this->db->query($sql);
    $q=$q->result_array();
 // $res=$res->row_array();
    return $q;
}



public function sqlTogetparkinglot($effective_date,$parkcode,$floor,$biz_type,$biz_status,$biz_reason,$keyword, $page, $rows)
{
    $start = ($page - 1) * $rows;
    $now   =  date("Y-m-d",time());

    /////////////////判断为普通查询或搜索查询////////////////////////////
    if (empty($effective_date) && empty($parkcode) && empty($floor)  && empty($biz_type) && empty($biz_status) && empty($biz_reason)&& empty($keyword))

        /////////////////////////普通查询sql语句/////////////////////////
    {



        $sql = "select 
lot.code as lot_code,
lot.effective_date as lot_effective_date,
lot.effective_status as lot_effective_status,
lot.parkcode as lot_parkcode,
lot.floor as lot_floor,
lot.biz_type as lot_biz_type,
lot.biz_status as lot_biz_status,
lot.biz_reason as lot_biz_reason,
lot.owner as lot_owner,
lot.begin_date as lot_begin_date,
lot.end_date as lot_end_date,
lot.monthly_rent as lot_monthly_rent,
lot.remark as lot_remark,
lot.linked_lot_code as lot_linked_lot_code,
lot.area as lot_area,
par.parkname as lot_parkcode_name
from village_parking_lot as lot
left join village_park as par on par.parkcode=lot.parkcode
left join village_person as p on lot.owner=p.code 
where lot.begin_date=lot.begin_date

";}



    /////////////////////////搜索查询sql语句/////////////////////////
    else {
        $sql = "select 
lot.code as lot_code,
lot.effective_date as lot_effective_date,
lot.effective_status as lot_effective_status,
lot.parkcode as lot_parkcode,
lot.floor as lot_floor,
lot.biz_type as lot_biz_type,
lot.biz_status as lot_biz_status,
lot.biz_reason as lot_biz_reason,
lot.owner as lot_owner,
lot.begin_date as lot_begin_date,
lot.end_date as lot_end_date,
lot.monthly_rent as lot_monthly_rent,
lot.remark as lot_remark,
lot.linked_lot_code as lot_linked_lot_code,
lot.area as lot_area,
par.parkname as lot_parkcode_name
from village_parking_lot as lot
left join village_park as par on par.parkcode=lot.parkcode
left join village_person as p on lot.owner=p.code 
where lot.begin_date=lot.begin_date
";
    }
        if(empty($effective_date)){
            $sql .= " and lot.effective_date<='$now'";
        }

        if(!empty($effective_date)){
            $sql .= " and lot.effective_date<='$effective_date' ";
        }

        if(!empty($parkcode)){
            $sql .= " and lot.parkcode=$parkcode  ";
        }
        if(!empty($floor)){
            $sql .= " and lot.floor=$floor  ";
        }
        if(!empty($biz_type)){
            $sql .= " and lot.biz_type='$biz_type' ";
        }
        if(!empty($biz_status)){
            $sql .= " and lot.biz_status=$biz_status ";
        }

        if(!empty($biz_reason)){
            $sql .= " and lot.biz_reason=$biz_reason ";
        }

        if (!empty($keyword)) {
            if (preg_match('/^[\x7f-\xff]*\w*\d*$/', $keyword)) {
                $sql .= " and concat (lot.code,p.last_name,p.first_name) like '%$keyword%'";
            }

        }


    $sqlshow = $sql . " ORDER BY lot.code ASC limit ".$rows." offset ".$start;
    $arrayres=array($sql,$sqlshow);
    return $arrayres;
}



    public function getparkinglot($sql)
    {

        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == 'lot_code') {
                            $arr[$key]['lot_code_name'] = $value2;
                    }
                    if ($key2 == 'lot_remark') {
                        $arr[$key]['lot_remark_name'] = $value2;
                    }
                    if ($key2 == 'lot_monthly_rent') {
                        $arr[$key]['lot_monthly_rent_name'] = $value2?$value2.'元/月':' ';
                    }
                  /*  if ($key2 == 'lot_parkcode') {
                        $arr[$key]['lot_parkcode_name'] = $value2;
                    }*/
                    if ($key2 == 'lot_linked_lot_code') {
                        $arr[$key]['lot_linked_lot_code_name'] = $value2;
                    }
                 /*   if ($key2 == 'lot_parkcode') {
                        $arr[$key]['lot_parkcode_name'] = $value2;
                    }*/

                    if ($key2 == 'lot_area') {
                        $arr[$key]['lot_area_name'] = $value2?$value2.'平方米':'';
                    }
                    if ($key2 == 'lot_effective_date') {
                        $arr[$key]["lot_effective_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'lot_begin_date') {
                        $arr[$key]["lot_begin_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'lot_end_date') {
                        $arr[$key]["lot_end_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'lot_effective_status') {
                        if ($arr[$key]['lot_effective_status'] == 't') {
                            $arr[$key]['lot_effective_status_name'] = "有效";
                        }
                        if ($arr[$key]['lot_effective_status'] == 'f') {
                            $arr[$key]['lot_effective_status_name'] = "无效";
                        }
                    }

                    if ($key2 == 'lot_floor') {
                        if ($value2 == "101") {
                            $arr[$key]['lot_floor_name'] = '地面';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['lot_floor_name'] = '地下一层';
                        }
                    }

                    if ($key2 == 'lot_biz_type') {
                        if ($value2 == "101") {
                            $arr[$key]['lot_biz_type_name'] = '住宅区停车位';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['lot_biz_type_name'] = '商业区停车位';
                        }
                    }
                    if ($key2 == 'lot_biz_status') {
                        if ($value2 == "101") {
                            $arr[$key]['lot_biz_status_name'] = '已占用';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['lot_biz_status_name'] = '公共车位';
                        }
                    }
                    if ($key2 == 'lot_biz_reason') {
                        if ($value2 == "101") {
                            $arr[$key]['lot_biz_reason_name'] = '已出售';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['lot_biz_reason_name'] = '租赁中';
                        }
                        if ($value2 == "103") {
                            $arr[$key]['lot_biz_reason_name'] = '被占用';
                        }
                    }
                    if ($key2 == 'lot_owner') {
                        $person= $this->getPersonByCode($value2);
                        $arr[$key]["lot_owner_name"]=$value2;
                        $arr[$key]["lot_owner_fullname"]=$person['full_name'];
                    }



                    /*if ($key2 == 'service_code'){
                          $person= $this->getPersonByCode($value2);
                        $arr[$key]["service_name"]=$person['full_name'];
                    }
                    if ($key2 == 'v_person_code') {
                        if (!empty($value['v_person_code'])) {

                            $arr[$key]['v_person_name'] = "";

                            $person = $this->getPersonByCode($value['v_person_code']);
                            $name = $person['full_name'];
                            $arr[$key]['v_person_name'] = $name;
                        } else {
                            $arr[$key]['v_person_name'] = '无';
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
                    if ($key2 == 'v_if_resident') {
                        if ($arr[$key]['v_if_resident'] == 't') {
                            $arr[$key]['v_if_resident_name'] = "是";
                        }
                        if ($arr[$key]['v_if_resident'] == 'f') {
                            $arr[$key]['v_if_resident_name'] = "否";
                        }
                    }
                    if ($key2 == 'v_if_temp') {
                        if ($arr[$key]['v_if_temp'] == 't') {
                            $arr[$key]['v_if_temp_name'] = "小区车";
                        }
                        if ($arr[$key]['v_if_temp'] == 'f') {
                            $arr[$key]['v_if_temp_name'] = "访客车";
                        }
                    }
                    if ($key2 == 'v_if_electro') {
                        if ($arr[$key]['v_if_electro'] == 't') {
                            $arr[$key]['v_if_electro_name'] = "是";
                        }
                        if ($arr[$key]['v_if_electro'] == 'f') {
                            $arr[$key]['v_if_electro_name'] = "否";
                        }
                    }



                    if ($key2 == "auz_code") {
                        $arr[$key][$key2] = $value2 ? $value2 : '无';
                    }
                    if ($key2 == "auz_person_code") {
                        $arr[$key][$key2] = $value2 ? $value2 : '无';
                        if (!empty($value['auz_person_code'])) {

                            $arr[$key]['auz_person_name'] = "";

                            $person = $this->getPersonByCode($value['auz_person_code']);
                            $name = $person['full_name'];
                            $arr[$key]['auz_person_name'] = $name;
                        } else {
                            $arr[$key]['auz_person_name'] = '无';
                        }
                    }
                    if ($key2 == "auz_begin_date") {
                        $arr[$key][$key2] = $arr[$key]["auz_begin_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                    }
                    if ($key2 == "auz_end_date") {
                        $arr[$key][$key2] = $arr[$key]["auz_end_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                    }
                    if ($key2 == "auz_remark") {
                        $arr[$key][$key2] = $value2 ? $value2 : '无';
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


public function updateParkinglot($code,$effective_date,$effective_status,$linked_lot_code,$begin_date,$end_date,$area,$monthly_rent,$parkcode,$floor,$biz_type,$biz_status,$biz_reason,$owner,$remark){

    $sql = " update village_parking_lot
         set effective_date=".$this->db->escape($effective_date).",".
        "effective_status=".$this->db->escape($effective_status).",".
        "linked_lot_code=".$this->db->escape($linked_lot_code).",".
        "begin_date=".$this->db->escape($begin_date).",".
        "end_date=".$this->db->escape($end_date).",".
        "area=".$this->db->escape($area).",".
        "monthly_rent=".$this->db->escape($monthly_rent).",".
        "parkcode=".$this->db->escape($parkcode).",".
        "floor=".$this->db->escape($floor).",".
        "biz_type=".$this->db->escape($biz_type).",".
        "biz_status=".$this->db->escape($biz_status).",".
        "biz_reason=".$this->db->escape($biz_reason).",".
        "owner=".$this->db->escape($owner).",".
        "remark=".$this->db->escape($remark)." ".
        "where code=$code";

    $this->db->query($sql);
}
    public function sqlTogetvehiclepkg($v_if_temp,$v_vehicle_type,$building_code,$parent_code,$pkg_begin_date,$pkg_end_date,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());

        /////////////////判断为普通查询或搜索查询////////////////////////////
        if (empty($v_if_temp) && empty($v_vehicle_type) && empty($building_code)  && empty($parent_code) && empty($pkg_begin_date) && empty($pkg_end_date)&& empty($keyword))

            /////////////////////////普通查询sql语句/////////////////////////
        {



            $sql = "select 
pkg.vehicle_code as pkg_vehicle_code,
pkg.licence as pkg_licence,
pkg.begin_date as pkg_begin_date,
pkg.entry_eqp as pkg_entry_eqp,
pkg.entry_type as pkg_entry_type,
pkg.end_date as pkg_end_date,
pkg.exit_eqp as pkg_exit_eqp,
pkg.exit_type as pkg_exit_type,
pkg.charge_type as pkg_charge_type,
pkg.if_charged as pkg_if_charged,
pkg.charge_amount as pkg_charge_amount,
pkg.related_id as pkg_related_id,
pkg.parking_payment_id as pkg_parking_payment_id,
v.licence as v_licence,
v.if_temp as v_if_temp,
v.person_code as v_person_code,
v.owner as v_owner,
v.vehicle_type as v_vehicle_type,
pb.building_code as building_code,
par_pay.person_code as par_pay_person_code
from village_vehicle_pkg as pkg
left join village_parking_payment as par_pay on par_pay.id=pkg.parking_payment_id
left join village_vehicle as v on v.code=pkg.vehicle_code
left join village_person as p on p.code=v.person_code
left join village_person_building as pb on v.person_code=pb.person_code
left join village_tmp_building as tmp on tmp.code=pb.building_code
where tmp.code=pb.building_code
";}



        /////////////////////////搜索查询sql语句/////////////////////////
        else {
            $sql = "select 
pkg.vehicle_code as pkg_vehicle_code,
pkg.licence as pkg_licence,
pkg.begin_date as pkg_begin_date,
pkg.entry_eqp as pkg_entry_eqp,
pkg.entry_type as pkg_entry_type,
pkg.end_date as pkg_end_date,
pkg.exit_eqp as pkg_exit_eqp,
pkg.exit_type as pkg_exit_type,
pkg.charge_type as pkg_charge_type,
pkg.if_charged as pkg_if_charged,
pkg.charge_amount as pkg_charge_amount,
pkg.related_id as pkg_related_id,
pkg.parking_payment_id as pkg_parking_payment_id,
v.licence as v_licence,
v.if_temp as v_if_temp,
v.person_code as v_person_code,
v.owner as v_owner,
v.vehicle_type as v_vehicle_type,
pb.building_code as building_code,
par_pay.person_code as par_pay_person_code
from village_vehicle_pkg as pkg
left join village_parking_payment as par_pay on par_pay.id=pkg.parking_payment_id
left join village_vehicle as v on v.code=pkg.vehicle_code
left join village_person as p on p.code=v.person_code
left join village_person_building as pb on v.person_code=pb.person_code
left join village_tmp_building as tmp on tmp.code=pb.building_code
where tmp.code=pb.building_code
";

        }
            if(empty($pkg_begin_date)){
                $sql .= " and pkg.begin_date>='$now' ";
            }
         if(!empty($pkg_begin_date)){
                $sql .= " and pkg.begin_date>='$pkg_begin_date' ";
            }
            if(!empty($pkg_end_date)){
                $sql .= " and pkg.end_date<='$pkg_end_date' ";
            }

            if(!empty($v_if_temp)){
                $sql .= " and v.if_temp='$v_if_temp'  ";
            }
            if(!empty($v_vehicle_type)){
                $sql .= " and v.vehicle_type=$v_vehicle_type  ";
            }

            if(!empty($building_code)){
                $sql .= " and (pb.building_code=$building_code or tmp.parent_code=$parent_code) ";
            }
            if (!empty($keyword)) {
                if (preg_match('/^[\x7f-\xff]*\w*\d*$/', $keyword)) {
                    $sql .= " and concat (pkg.vehicle_code,p.last_name,p.first_name) like '%$keyword%'";
                }

            }


        $sqlshow = $sql." ORDER BY pkg.vehicle_code ASC limit ".$rows." offset ".$start;
        $arrayres=array($sql,$sqlshow);
        return $arrayres;
    }






    public function getvehiclepkg($sql)
    {

        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {


                    if ($key2 == 'pkg_begin_date') {
                        $arr[$key]["pkg_begin_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'pkg_end_date') {
                        $arr[$key]["pkg_end_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'pkg_if_charged') {
                        if ($arr[$key]['pkg_if_charged'] == 't') {
                            $arr[$key]['pkg_if_charged_name'] = "是";
                        }
                        if ($arr[$key]['pkg_if_charged'] == 'f') {
                            $arr[$key]['pkg_if_charged_name'] = "否";
                        }
                    }

                    if ($key2 == 'pkg_charge_type') {
                        if ($value2 == "101") {
                            $arr[$key]['pkg_charge_type_name'] = '买断车位';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['pkg_charge_type_name'] = '租赁车位';
                        }
                        if ($value2 == "103") {
                            $arr[$key]['pkg_charge_type_name'] = '计时收费';
                        }
                    }
                    if ($key2 == 'v_if_temp') {
                        if ($arr[$key]['v_if_temp'] == 't') {
                            $arr[$key]['v_if_temp_name'] = "是";
                        }
                        if ($arr[$key]['v_if_temp'] == 'f') {
                            $arr[$key]['v_if_temp_name'] = "否";
                        }
                    }
                    if ($key2 == "v_vehicle_type") {
                        if ($value2 == "101") {$arr[$key]['v_vehicle_type_name'] = '轿车';}
                        if ($value2 == "102") {$arr[$key]['v_vehicle_type_name'] = '客车';}
                        if ($value2 == "103") {$arr[$key]['v_vehicle_type_name'] = '货车';}
                        if ($value2 == "104") {$arr[$key]['v_vehicle_type_name'] = '专用汽车';}
                        if ($value2 == "105") {$arr[$key]['v_vehicle_type_name'] = '摩托车';}
                        if ($value2 == "106") {$arr[$key]['v_vehicle_type_name'] = '电瓶车';}
                        if ($value2 == "107") {$arr[$key]['v_vehicle_type_name'] = '自行车';}
                        if ($value2 == "999") {$arr[$key]['v_vehicle_type_name'] = '其他车辆';}
                    }
                    if ($key2 == 'v_person_code') {
                        $person= $this->getPersonByCode($value2);
                        $arr[$key]["v_person_code_name"]=$person['full_name'];
                    }
                    if ($key2 == 'building_code') {
                        $building= $this->getBuildingnamebyCode($value2);
                        $arr[$key]["building_code_name"]=$building['full_name'];
                    }
                    if ($key2 == 'par_pay_person_code') {
                        $person= $this->getPersonByCode($value2);
                        $arr[$key]["par_pay_person_code_name"]=$person['full_name'];
                    }



                }
            }
            $json = json_encode($arr);
            return $json;
        }
        return false;

    }


    public function getBuildingnamebyCode($code)
    {
        $sql = "select code,concat(stage_name,area_name,immeuble_name,unit_name,floor_name,room_name,public_name) as full_name from village_tmp_building where $code=code";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row;
    }

    public function sqlTogetvehiclepayment($pay_status,$pay_method,$pay_specific,$issued_time,$keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $now   =  date("Y-m-d",time());

        /////////////////判断为普通查询或搜索查询////////////////////////////
        if (empty($pay_status) &&empty($pay_method) && empty($pay_specific) && empty($issued_time)  && empty($keyword))

            /////////////////////////普通查询sql语句/////////////////////////
        {



            $sql = "
            select 
pay.id as pay_id,
pay.person_code as pay_person_code,
pay.pay_status as pay_status,
pay.issued_time as pay_issued_time,
pay.close_time as  pay_close_time,
pay.charge_amount as pay_charge_amount,
pay.pay_method as pay_method ,
pay.pay_specific as pay_specific
from village_parking_payment as pay
left join village_person as p on p.code=pay.person_code
where p.code=pay.person_code
";}



        /////////////////////////搜索查询sql语句/////////////////////////
        else {
            $sql = "
              select 
pay.id as pay_id,
pay.person_code as pay_person_code,
pay.pay_status as pay_status,
pay.issued_time as pay_issued_time,
pay.close_time as  pay_close_time,
pay.charge_amount as pay_charge_amount,
pay.pay_method as pay_method ,
pay.pay_specific as pay_specific
from village_parking_payment as pay
left join village_person as p on p.code=pay.person_code
where p.code=pay.person_code
";        }

            if(empty($issued_time)){
                $sql .= " and pay.issued_time<='$now' ";
            }
            if(!empty($issued_time)){
                $sql .= " and pay.issued_time<='$issued_time' ";
            }
            if(!empty($pay_method)){
                $sql .= " and pay.pay_method='$pay_method'";
            }
            if(!empty($pay_status)){
                $sql .= " and pay.pay_status='$pay_status'";
            }
            if(!empty($pay_specific)){
                $sql .= " and pay.pay_specific='$pay_specific'  ";
            }


            if (!empty($keyword)) {
                if (preg_match('/^[\x7f-\xff]*\w*\d*$/', $keyword)) {
                    $sql .= " and concat (pay.id,p.last_name,p.first_name) like '%$keyword%'";
                }

            }



        $sqlshow = $sql . " ORDER BY pay.id ASC limit ".$rows." offset ".$start;
        $arrayres=array($sql,$sqlshow);
        return $arrayres;
    }





    public function getvehiclepayment($sql)
    {

        $q = $this->db->query($sql); //自动转义
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();

            foreach ($arr as $key => $value) {
                foreach ($value as $key2 => $value2) {


                    if ($key2 == 'pay_issued_time') {
                        $arr[$key]["pay_issued_time_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'pay_close_time') {
                        $arr[$key]["pay_close_time_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'pay_status') {
                        if ($value2== '101') {
                            $arr[$key]['pay_status_name'] = "未支付";
                        }
                        if ($value2== '102') {
                            $arr[$key]['pay_status_name'] = "支付失败";
                        }
                        if ($value2 == '103') {
                            $arr[$key]['pay_status_name'] = "支付成功";
                        }
                        if ($value2 == '104') {
                            $arr[$key]['pay_status_name'] = "交易完成";
                        }
                    }

                    if ($key2 == 'pay_method') {
                        if ($value2 == "101") {
                            $arr[$key]['pay_method_name'] = '现金缴费';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['pay_method_name'] = 'APP缴费_微信';
                        }
                        if ($value2 == "103") {
                            $arr[$key]['pay_method_name'] = 'APP缴费_支付宝';
                        }
                        if ($value2 == "104") {
                            $arr[$key]['pay_method_name'] = 'APP缴费_建行聚合支付';
                        }
                        if ($value2 == "105") {
                            $arr[$key]['pay_method_name'] = '微信小程序缴费';
                        }
                        if ($value2 == "999") {
                            $arr[$key]['pay_method_name'] = '未缴费';
                        }
                    }
                    if ($key2 == 'pay_specific') {
                        if ($value2 == "101") {
                            $arr[$key]['pay_specific_name'] = '应收金额';
                        }
                        if ($value2 == "102") {
                            $arr[$key]['pay_specific_name'] = '优惠金额';
                        }
                        if ($value2 == "103") {
                            $arr[$key]['pay_specific_name'] = '免费金额';
                        }

                    }
                    if ($key2 == 'pay_person_code') {
                        $person= $this->getPersonByCode($value2);
                        $arr[$key]["pay_person_code_name"]=$person['full_name'];
                    }

                }
            }
            $json = json_encode($arr);
            return $json;
        }
        return false;

    }

}

?>


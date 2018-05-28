

<?php
class Material_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    ///////////////////////////////////获取数据////////////////////////////////////
    /////////////数据内容////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////
    /////////////数据数目////////对sql进行分类：普通查询sql和搜索查询sql//////////////////////

   ////////普通查询数据内容的sql语句/////////
    public function getMaterialListbyNormal($page, $rows)
    {
        $start = ($page - 1) * $rows;
        $sql = "SELECT
	*
FROM
	village_material M
LEFT JOIN village_building_stage AS bs ON M .building_code = bs.room_code
WHERE
	M .building_code = bs.room_code 
and M .effective_status=true
and M .effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		village_material A
where M.code=A.code
	GROUP BY
		code
) 
";
        $sql .=  " ORDER BY code ASC limit ".$rows." offset ".$start;
        return $sql;
    }

    ////////搜索查询数据内容的sql语句//////////
    public function getMaterialListbySearch($effective_date,$parent_code,$building_code, $material_type, $keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $sql = "SELECT
m.*,
b.effective_date as b_effective_date,
b.code as b_code,
b.id,
b.parent_code as b_parent_code,
bs.room,
bs.immeuble,
bs.room_code


FROM village_material AS M 
left join 	village_building_stage AS bs on M .building_code = bs.room_code
left join 		village_building AS b on M .building_code = b.code

WHERE

	M .building_code = bs.room_code
and M .building_code = b.code
    AND bs.room_code = b.code
    and m.effective_status=true 
    AND  b.id IN (
		SELECT
			MAX (id)
		FROM
			village_building
		GROUP BY
			code
			)
	and  M .effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		village_material A
where M.code=A.code
	GROUP BY
		code 
) 	


";
        if(!empty($effective_date)){
            $sql .= " and M.effective_date<='$effective_date' ";
        }

        if(!empty($material_type)){
            $sql .= " and M.material_type=$material_type ";
        }
        if(!empty($building_code)){
            $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code) ";
        }

        if (!empty($keyword)) {
            if (preg_match('/^\d*[\x7f-\xff]+\d*$/', $keyword)) {
                $sql .= " and concat(M.supplier,M.remark,M.function,M.name,M.internal_no,M.initial_no) like '%$keyword%'";
            }
            if (preg_match("/^\d*$/", $keyword)) {
                $sql .= " and M.code=$keyword or M.material_type=$keyword or M.internal_no like '%$keyword%' or M.initial_no like '%$keyword%' ";
            }
        }
        $sql = $sql . " ORDER BY m.code ASC limit ".$rows." offset ".$start;
        return $sql;
    }


    //////////////// 根据输入的sql语句参数，得到数据////////////////
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
                    }
                    if ($key2 == 'room') {
                        if( (( empty($arr[$key]['room']) ) && empty($arr[$key]['immeuble']) ) ){
                            $arr[$key]['room_name']='和正·智汇谷';
                        }else{
                            $arr[$key]['room_name'] = $value['immeuble'] . '栋';
                            if (!empty($value2)) {$arr[$key]['room_name'] .= $value['room'];}
                        }
                    }
                    if ($key2 == 'code') {
                        $arr[$key][$key2] = intval($value2, 10);
                    }
                    if ($key2 == 'effective_date') {
                        $arr[$key]["effective_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'effective_status') {
                        if ($value2 == 't') {
                            $arr[$key]["effective_status_name"] = "有效";
                        } elseif ($value2 == 'f') {
                            $arr[$key]["effective_status_name"] = "无效";
                        } else {
                            $arr[$key]["effective_status_name"] = "未知";
                        }
                    }
                    if ($key2 == 'name') {
                        $arr[$key][$key2] = $value2;
                    }

                    if ($key2 == 'pcs') {
                        $arr[$key][$key2] = intval($value2, 10);
                    }
                    if ($key2 == 'function') {
                        $arr[$key][$key2] = $value2 ? $value2 : '无';
                    }
                    if ($key2 == 'supplier') {
                        $arr[$key][$key2] = $value2 ? $value2 : '无';
                    }
                    if ($key2 == 'internal_no') {
                        $arr[$key][$key2] = intval($value2, 10);
                    }
                    if ($key2 == 'initial_no') {
                        $arr[$key][$key2] = intval($value2, 10);
                    }
                    if ($key2 == 'remark') {
                        $arr[$key][$key2] = $value2 ? $value2 : '无';
                    }

                }
            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }


    ////////////////////普通查询数据数目的数据总条数///////////////
    public function getMaterialListTotalbyNormal( $rows)
    {
        $sql="select count(*) as count from (";
        $sql.="
SELECT
	*
FROM
	village_material M
LEFT JOIN village_building_stage AS bs ON M .building_code = bs.room_code
WHERE
	M .building_code = bs.room_code 
and M .effective_status=true
and M .effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		village_material A
where M.code=A.code
	GROUP BY
		code
		
)";
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

    //////////////////////搜索查询数据数目的数据总条数/////////////
    public function getMaterialListTotalbySearch($effective_date,$parent_code,$building_code, $material_type, $keyword, $rows)
    {
        $sql="select count(*) as count from (";

        $sql .= "SELECT
m.*,
b.effective_date as b_effective_date,
b.code as b_code,
b.id,
b.parent_code as b_parent_code,
bs.room,
bs.immeuble,
bs.room_code


FROM village_material AS M 
left join 	village_building_stage AS bs on M .building_code = bs.room_code
left join 		village_building AS b on M .building_code = b.code

WHERE
	M .building_code = bs.room_code
and M .building_code = b.code
    AND bs.room_code = b.code
    and m.effective_status=true 
    AND  b.id IN (
		SELECT
			MAX (id)
		FROM
			village_building
		GROUP BY
			code
)
	and  M .effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		village_material A
where M.code=A.code
	GROUP BY
		code
) 	
";

        if(!empty($effective_date)){
            $sql .= " and M.effective_date<='$effective_date' ";
        }


        if(!empty($material_type)){
            $sql .= " and M.material_type=$material_type ";
        }
        if(!empty($building_code)){
            $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code)";
        }

        if (!empty($keyword)) {
            if (preg_match("/^\d*$/", $keyword)) {
                $sql .= " and M.code=$keyword or M.material_type=$keyword or M.internal_no like '%$keyword%' or M.initial_no like '%$keyword%' ";
                // or M.material_type like '%$keyword%'
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



    ////////////////////////////////////插入数据/////////////////////////////////////
    public function insertMaterial($code, $effective_date, $effective_status, $name, $pcs, $material_type, $building_code, $function,$supplier, $internal_no, $initial_no, $remark, $create_time)
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
        $sql = "INSERT INTO village_material (code,effective_date,effective_status,name,pcs,material_type,building_code,function,supplier,internal_no,initial_no,remark,create_time) values (".

            $this->db->escape($code).", ".
            $this->db->escape($effective_date).", ".
            $this->db->escape($effective_status).", ".
            $this->db->escape($name).", ".
            $this->db->escape($pcs).", ".
            $this->db->escape($material_type).",".
            $this->db->escape($building_code).", ".
            $this->db->escape($function).", ".
            $this->db->escape($supplier).", ".
            $this->db->escape($internal_no).", ".
            $this->db->escape($initial_no).", ".
            $this->db->escape($remark).", ".$now.")"
        ;
        $this->db->query($sql);
        return $this->db->affected_rows();
    }




    //////////////////////////////////一些辅助功能///////////////////////////////////
    //获排名最前的数据
    public function getMaterialLatestCode()
    {
        $sql = "select code from village_material order by code desc limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['code'];
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


////////////////////获取用户名/////////////
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

///////////////////////获取物资类别名称///////////////////
    public function getmaterial_type_name($material_type)
    {
        if ($material_type == 101) {
            $material_type_name = '工程物资';
        } elseif ($material_type == 102) {
            $material_type_name = '安防物资';
        } elseif ($material_type == 103) {
            $material_type_name = '消防物资';
        } elseif ($material_type == 104) {
            $material_type_name = '保洁物资';
        } elseif ($material_type == 105) {
            $material_type_name = '办公物资';
        } else {
            $material_type_name = '物资类型';
        }
    return $material_type_name;
    }

////////////////////////////////////获取物资编码//////////////////////
    public function getMaterialAllCode()
    {
        $sql = "SELECT code,name,effective_date FROM village_material as M where
 M .effective_status=true
and M .effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		village_material A
where M.code=A.code
	GROUP BY
		code
)





	";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            $arr = $q->result_array();
            $json = json_encode($arr);
            return $json;
        }
    }





////////////////////////////////////根据物资状态表是否报废更新物资列表//////////////////////
    public function UpdateMaterialList ($code, $effective_date, $effective_status, $name, $pcs, $material_type, $building_code, $function,$supplier, $internal_no, $initial_no, $remark, $create_time)
    {

        $sql = "INSERT INTO village_material (code,effective_date,effective_status,name,pcs,material_type,building_code,function,supplier,internal_no,initial_no,remark,create_time) values (".

            $this->db->escape($code).", ".
            $this->db->escape($effective_date).", ".
            $this->db->escape($effective_status).", ".
            $this->db->escape($name).", ".
            $this->db->escape($pcs).", ".
            $this->db->escape($material_type).",".
            $this->db->escape($building_code).", ".
            $this->db->escape($function).", ".
            $this->db->escape($supplier).", ".
            $this->db->escape($internal_no).", ".
            $this->db->escape($initial_no).", ".
            $this->db->escape($remark).", ".
            $this->db->escape($create_time).")"
        ;
        $this->db->query($sql);
        return $this->db->affected_rows();


    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////materialUsage/////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////


    public function getMaterialUsagebyNormal($page, $rows)
    {
        $start = ($page - 1) * $rows;
        $sql = "SELECT
mtr.*,
bs.*,
m.code,
m.name,
m.material_type,
m.pcs,
m.building_code,
m.effective_date as m_effective_date,
p.code,
p.first_name,
p.last_name

 
FROM village_mtr_mgt AS mtr 
LEFT JOIN 	village_material AS m on 	mtr.material_code=m.code 
left join 	village_building_stage AS bs on m.building_code=bs.room_code 
left join 	village_person as p on mtr.person_code=p.code
	
WHERE
	mtr.material_code=m.code 
and m.building_code=bs.room_code

and M .effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		village_material A
where M.code=A.code
	GROUP BY
		code)
and mtr.effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		village_mtr_mgt A
where mtr.material_code=A.material_code
	GROUP BY
		material_code)

";
       /* $sql .= " LEFT JOIN village_building_stage AS bs ON M.building_code = bs.room_code";
        $sql .= " where M.effective_status=true";*/
        $sql = $sql . " order by case when mtr.mgt_status = 103  then 0 else 1 end , mtr.material_code ASC limit ".$rows." offset ".$start;
        return $sql;

    }




    public function getMaterialUsageTotalbyNormal( $rows)
    {
        $sql="select count(*) as count from (

SELECT
mtr.*,
bs.*,
m.code,
m.name,
m.material_type,
m.pcs,
m.building_code,
m.effective_date as m_effective_date,
p.code,
p.first_name,
p.last_name

 
FROM village_mtr_mgt AS mtr 
LEFT JOIN 	village_material AS m on 	mtr.material_code=m.code 
left join 	village_building_stage AS bs on m.building_code=bs.room_code 
left join 	village_person as p on mtr.person_code=p.code
	
WHERE
	mtr.material_code=m.code 
and m.building_code=bs.room_code

and M .effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		village_material A
where M.code=A.code
	GROUP BY
		code)
and mtr.effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		village_mtr_mgt A
where mtr.material_code=A.material_code
	GROUP BY
		material_code)
) as ss";
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


    public function getMaterialUsage( $sql){
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
                    }
                    if ($key2 == 'room') {
                        if( (( empty($arr[$key]['room']) ) && empty($arr[$key]['immeuble']) ) ){
                            $arr[$key]['room_name']='和正·智汇谷';
                        }else{
                            $arr[$key]['room_name'] = $value['immeuble'] . '栋';
                            if (!empty($value2)) {$arr[$key]['room_name'] .= $value['room'];}
                        }
                    }
                    if ($key2 == 'code') {
                        $arr[$key][$key2] = intval($value2, 10);
                    }
                    if ($key2 == 'effective_date') {
                        $arr[$key]["effective_date_name"] = substr($value2, 0, 4) . "-" . substr($value2, 5, 2) . "-" . substr($value2, 8, 2);
                        // $item["effective_date"]=$value;
                    }
                    if ($key2 == 'mgt_status') {
                        if ($value2 == '101') {
                            $arr[$key]["mgt_status_name"] = "在库保管";
                        } elseif ($value2 == '102') {
                            $arr[$key]["mgt_status_name"] = "使用中";
                        } elseif ($value2 == '103'){
                            $arr[$key]["mgt_status_name"] = "外借/外调";
                        }elseif ($value2 == '104'){
                            $arr[$key]["mgt_status_name"] = "已报废";

                        }elseif ($value2 == '105'){
                            $arr[$key]["mgt_status_name"] = "已消耗";
                        }
                    }
                    if ($key2 == 'name') {
                        $arr[$key][$key2] = $value2;
                    }
                    if ($key2 == 'pcs') {
                        $arr[$key][$key2] = intval($value2, 10);
                    }
                    if ($key2 == 'remark') {
                        $arr[$key][$key2] = $value2 ? $value2 : '无';
                    }
                    if ($key2 == 'person_code'){

                        $arr[$key]['person_name'] = $value['last_name'].$value['first_name']? $value['last_name'].$value['first_name'] : '无';
                    }



                }
            }
            $json = json_encode($arr);
            return $json;
        }
        return false;
    }

public function insertMaterialUsage($material_code,$mgt_status,$effective_date,$person_code,$remark,$create_time)
{


        $sql = " INSERT INTO village_mtr_mgt (material_code,mgt_status,effective_date,person_code,remark,create_time) values (".

            $this->db->escape($material_code).", ".
            $this->db->escape($mgt_status).", ".
            $this->db->escape($effective_date).", ".
            $this->db->escape($person_code).", ".
            $this->db->escape($remark).", ".
            $this->db->escape($create_time).")";
        $this->db->query($sql);
        return $this->db->affected_rows();
    }



    public function  getMaterialListbyUsage($material_code)
    {
        $sql = " SELECT
  mtr.material_code,
	mtr.effective_date,
  m.*

FROM village_material as m,
 village_mtr_mgt as mtr
where
mtr.material_code=$material_code and
mtr.material_code=m.code
and

	m.effective_date IN (
		SELECT
			MAX (effective_date)
		FROM
			village_material
		GROUP BY
			code=$material_code
	)";

        $q = $this->db->query($sql);
        $row = $q->row_array();

        return $row;


    }

    public function  defineUsageEffective($material_code,$effective_date)
    {

        $effective_date=$this->db->escape($effective_date);
        $sql="select count(*) as count from (";
        $sql.= " SELECT
  mtr.material_code,
  mtr.effective_date,
  m.effective_date,
  m.code
FROM 
 village_mtr_mgt as mtr
left join  village_material as m on mtr.material_code=m.code 
where
(mtr.material_code=m.code and
mtr.material_code=$material_code )and
( mtr.effective_date=$effective_date  or 
$effective_date=m.effective_date )
	";
       $sql.=" ) as sss";
        $q = $this->db->query($sql);
        $res=$q->row_array();
         if ($res["count"] > 0) {

             return true;
         }else{
             return false;

         }
    }










    public function getMaterialUsagebySearch($effective_date,$parent_code,$building_code, $material_type, $keyword, $page, $rows)
    {
        $start = ($page - 1) * $rows;
        $sql = "		SELECT
				mtr.*, bs.*, M .code,
				M . NAME,
				M .material_type,
				M .pcs,
				M .building_code,
				M .effective_date AS m_effective_date,
				P .code,
				P .first_name,
				P .last_name,
				b.parent_code,
				b.code AS b_code,
				b.id
			FROM
				village_mtr_mgt AS mtr,
				village_material AS M,
				village_building_stage AS bs,
				village_person AS P,
				village_building AS b
			WHERE
				mtr.material_code = M .code
			AND M .building_code = bs.room_code
			AND mtr.person_code = P .code
			AND b.code = M .building_code
			AND b.id = (
		SELECT
			MAX (id)
			FROM
			village_building A
            WHERE mtr.material_code = M .code
            AND M .building_code = bs.room_code	
            AND A.code = M .building_code
            and M .effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		village_material A
where M.code=A.code
	GROUP BY
		code)
)


";
        if(!empty($effective_date)){
            $sql .= " and mtr.effective_date<='$effective_date' ";
        }

        if(!empty($material_type)){
            $sql .= " and M.material_type=$material_type ";
        }
        if(!empty($building_code)){
            $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code) ";
        }


        if (!empty($keyword)) {
                if (preg_match("/^\d*$/", $keyword)) {
                    $sql .= " and M.code=$keyword or M.material_type=$keyword  ";
                    // or M.material_type like '%$keyword%'
                }
                 if (preg_match('/^\d*[\x7f-\xff]+\d*$/', $keyword)) {
                     $sql .= " and concat(mtr.remark,M.name,p.last_name,p.first_name) like '%$keyword%'";
                 }
        }

        $sql = $sql . " ORDER BY mtr.material_code ASC limit ".$rows." offset ".$start;
        return $sql;
    }



    public function getMaterialUsageTotalbySearch($effective_date,$parent_code,$building_code, $material_type, $keyword, $rows)
    {
        $sql="select count(*) as count from (";

        $sql .= "
		SELECT
				mtr.*, bs.*, M .code,
				M . NAME,
				M .material_type,
				M .pcs,
				M .building_code,
				M .effective_date AS m_effective_date,
				P .code,
				P .first_name,
				P .last_name,
				b.parent_code,
				b.code AS b_code,
				b.id
			FROM
				village_mtr_mgt AS mtr,
				village_material AS M,
				village_building_stage AS bs,
				village_person AS P,
				village_building AS b
			WHERE
				mtr.material_code = M .code
			AND M .building_code = bs.room_code
			AND mtr.person_code = P .code
			AND b.code = M .building_code
			AND b.id = (
		SELECT
			MAX (id)
			FROM
			village_building A
            WHERE mtr.material_code = M .code
            AND M .building_code = bs.room_code	
            AND A.code = M .building_code
            and M .effective_date = (
	SELECT  MAX(A.effective_date)
	FROM
		        village_material A
              where M.code=A.code
	          GROUP BY
		      code)
					
)

";

        if(!empty($effective_date)){
            $sql .= " and mtr.effective_date<='$effective_date' ";
        }


        if(!empty($material_type)){
            $sql .= " and M.material_type=$material_type ";
        }
        if(!empty($building_code)){
            $sql .= " and (M.building_code=$building_code or b.parent_code=$parent_code)";
        }

        if (!empty($keyword)) {
            if (preg_match("/^\d*$/", $keyword)) {
                $sql .= " and M.code=$keyword or M.material_type=$keyword  ";
                // or M.material_type like '%$keyword%'
            }
           /* if (preg_match('/^\d*[\x7f-\xff]+\d*$/', $keyword)) {
                $sql .= " and concat(M.supplier,M.remark,M.function,M.name) like '%$keyword%'";
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




}
?>


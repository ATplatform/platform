<?php
class Building_model extends CI_Model {

    public function __construct()
    {
    	parent::__construct();
        $this->load->database();
    }

    public function insertBuilding($village_id,$code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$remark,$create_time){
        // echo $code;exit;
        if(is_null($rank)||empty($rank)){
            $sql = "INSERT INTO village_building (village_id,code,effective_date,effective_status,name,level,rank,parent_code,remark,create_time) values ($village_id,$code,'$effective_date',$effective_status,'$name',$level,null,$parent_code,'$remark','$create_time')";
        }
        else{
            $sql = "INSERT INTO village_building (village_id,code,effective_date,effective_status,name,level,rank,parent_code,remark,create_time) values ($village_id,$code,'$effective_date',$effective_status,'$name',$level,$rank,$parent_code,'$remark','$create_time')";
        }
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function updateBuilding($id,$code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$remark,$create_time){
        if(is_null($rank)||empty($rank)){
            $sql = "update village_building set effective_date = '$effective_date',effective_status = $effective_status,name = '$name',level = $level,rank = null,parent_code = $parent_code,remark = '$remark',create_time = '$create_time' where id = $id";
        }
        else{
            $sql = "update village_building set effective_date = '$effective_date',effective_status = $effective_status,name = '$name',level = $level,rank = $rank,parent_code = $parent_code,remark = '$remark',create_time = '$create_time' where id = $id";
        }
        // echo $sql;exit;
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function updateBuildingName($code,$name,$remark,$village_id){
        if(empty($rank)){
            $rank = null;
        }
        $sql = "update village_building set name= ".
        $this->db->escape($name).", remark=".
        $this->db->escape($remark)." where code =".
        $this->db->escape($code)." and village_id=".
        $this->db->escape($village_id);
        // echo $sql;exit;
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function getBuildingCode(){
    	$sql = "select code from village_building order by code desc limit 1";
    	$query = $this->db->query($sql);
    	$row = $query->row_array();
    	return $row['code'];
    }

    public function getBuildingsList($level,$keyword,$id,$parent_code,$page,$rows,$village_id){
        $start=($page-1) * $rows;
    	$sql = "select b.id,b.code,b.effective_date,b.effective_status,b.name,b.level,b.rank,b.parent_code,b.remark,b.village_id,b.qr_code from village_building as b left join village_tmp_building tb on b.code = tb.code and b.village_id = tb.village_id  ";
        $limit = false;
        if(isset($keyword)&&$keyword!=''){
            if($limit){
                $sql .= " and b.name like '%$keyword%'";
            }
            else{
                $sql .= " where b.name like '%$keyword%'";
                $limit = true;
            }
        }
        if(!empty($id)||!empty($parent_code)){
            if(isset($keyword)&&$keyword!=''){
                //根据level来判断
                //表示是室,此时应该使用parent_code查询
                if($level=='106'){
                    $sql .= "  and b.id = $id or b.parent_code = $parent_code ";
                }
                //期
                else if($level == '101'){
                    $sql .= " and tb.stage = $parent_code ";
                }
                //区
                else if($level == '102'){
                    $sql .= " and tb.area = $parent_code ";
                }
                //栋
                else if($level == '103'){
                    $sql .= " and tb.immeuble = $parent_code ";
                }
                //单元
                else if($level == '104'){
                    $sql .= " and tb.stage = $parent_code ";
                }
                //层
                else if($level == '105'){
                    $sql .= " and tb.floor = $parent_code ";
                }
                //公共设施
                else if($level == '107'){
                    $sql .= " and tb.public = $parent_code ";
                }
            }
            else{
              if($limit){
                  $sql .= " and b.id = $id or b.parent_code = $parent_code";
              }
              else{
                  $sql .= " where b.id = $id or b.parent_code = $parent_code";
                  $limit = true;
              }  
            }
        }
        $sql=$sql." and b.village_id = $village_id";
        $sql=$sql." order by code asc limit ".$rows." offset ".$start;
        // echo $sql;exit;
    	$query = $this->db->query($sql);
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$this->buildingsListArray($q->result_array());
			$json=json_encode($arr);
			return $json;
		}
		return false;
    }


    public function getBuildingListById($id){
        $sql = "select id,code,effective_date,effective_status,name,level,rank,parent_code,remark from village_building where id = $id";
        $query = $this->db->query($sql);
        $arr=$this->buildingsListArray($query->result_array());
        $json=json_encode($arr);
        return $json;
    }

    public function buildingsListArray($data){
        $level_name_arr = array(array('code'=>'100','name'=>'小区'),array('code'=>'101','name'=>'期'),array('code'=>'102','name'=>'区'),array('code'=>'103','name'=>'栋'),array('code'=>'104','name'=>'单元'),array('code'=>'105','name'=>'层'),array('code'=>'106','name'=>'室'),array('code'=>'107','name'=>'公共设施'));
    	$arr = array();
    	foreach ( $data as $row) {
    		$item=array();
    		foreach ( $row as $key => $value) {
    			if($key=='code')
    			{
    				$item["code"]=intval($value,10);
    			}
    			elseif($key=='effective_date')
    			{
    				$item["effective_date"]=substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
    				// $item["effective_date"]=$value;
    			}
    			elseif($key=='effective_status')
    			{
    				if($value=='t')
    				{
    					$item["effective_status"]="有效";	
    				}
    				elseif($value=='f') {
    					$item["effective_status"]="无效";
    				}
    				else {
    					$item["effective_status"]="未知";
    				}				
    			}
    			elseif($key=='name')
    			{
    				$item["name"]=$value;
    			}
    			elseif($key=='level')
    			{
    				$item["level"]=intval($value,10);
                    foreach($level_name_arr as $key => $v){
                        if($value == $v['code']){
                            $item["level_name"] = $v['name'];
                            break;
                        }
                    }
    			}
    			elseif($key=='rank')
    			{
                    if(!empty($item["rank"])){
                        $item["rank"]=intval($value,10)?$value:' ';
                    }
    				else {
                        $item["rank"]= $value;
                    }
    			}
    			elseif($key=='parent_code')
    			{
    				$item["parent_code"]=intval($value,10);
                    $item['parent_code_name'] = $this->getBuildingByCode($value)['name'];
    			}
    			elseif($key=='remark')
    			{
    				$item["remark"]=$value?$value:' ';
    			}
                elseif($key=='village_id')
                {
                    $item["village_id"]=$value;
                }
                elseif($key=='qr_code')
                {
                    $item["qr_code"]=$value;
                }
                elseif($key=='id')
                {
                    $item["id"]=intval($value,10);
                }
                elseif($key=='level_type')
                {
                    $item["level_type"]=intval($value,10);
                }
                $item["household"]=$this->getHouseholdInfo($row);
    		}
    		$arr[]=$item;
    	}
    	return $arr;
    }

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
        if($row['level']==100){
            $result=$result.$row['name'];
        }              
        return $result;
    }

    public function getBuildingTotal($level,$keyword,$id,$parent_code,$rows,$village_id){
        $sql = "select count(b.id) as count from village_building as b left join village_tmp_building tb on b.code = tb.code and b.village_id = tb.village_id ";
        $limit = false;
        if(isset($keyword)&&$keyword!=''){
            if($limit){
                $sql .= " and b.name like '%$keyword%'";
            }
            else{
                $sql .= " where b.name like '%$keyword%'";
                $limit = true;
            }
        }
        if(!empty($id)||!empty($parent_code)){
            if(isset($keyword)&&$keyword!=''){
                //根据level来判断
                //表示是室,此时应该使用parent_code查询
                if($level=='106'){
                    $sql .= "  and b.parent_code = $parent_code ";
                }
                //期
                else if($level == '101'){
                    $sql .= " and tb.stage = $parent_code ";
                }
                //区
                else if($level == '102'){
                    $sql .= " and tb.area = $parent_code ";
                }
                //栋
                else if($level == '103'){
                    $sql .= " and tb.immeuble = $parent_code ";
                }
                //单元
                else if($level == '104'){
                    $sql .= " and tb.stage = $parent_code ";
                }
                //层
                else if($level == '105'){
                    $sql .= " and tb.floor = $parent_code ";
                }
                //公共设施
                else if($level == '107'){
                    $sql .= " and tb.public = $parent_code ";
                }
            }
            else{
              if($limit){
                  $sql .= " and b.id = $id or b.parent_code = $parent_code";
              }
              else{
                  $sql .= " where b.id = $id or b.parent_code = $parent_code";
                  $limit = true;
              }  
            }
        }
        if($limit){
            $sql .= " and b.village_id =$village_id ";
        }
        else{
            $sql .= " where b.village_id =$village_id ";
            $limit = true;
        }
        // echo $sql;exit;
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

    public function getBuildingNameCode($village_id){
        $sql = "select * from village_tmp_building where village_id = $village_id ORDER BY code,name";
        // echo $sql;exit;
        $q = $this->db->query($sql);
        if ( $q->num_rows() > 0 ) {
            $arr=$q->result_array();
            $res = array();
            foreach($arr as $k => $v){
              $res[$k]['code'] = $v['code'];
              $household = $this->getHouseholdInfo($v);
              $res[$k]['name'] =  $household;
            }
            $json=json_encode($res);
            return $json;
        }
        return false;
    }

    public function getBuildingById($id){
        $sql = "select id,code,name,effective_date from village_building where id = $id limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $res = array();
        $res[0] = $row;
        $arr=$this->buildingsListArray($res);
        $result = $arr[0];
        return $result;
    }

    public function getBuildingByCode($code){
        $sql = "select id,village_building.code,village_building.name,effective_date,stage,area,immeuble,unit,floor,room,sip  from village_building   LEFT JOIN village_tmp_building  on village_building.code = village_tmp_building.room where village_building.code = $code limit 1";
        // echo $sql;
        // echo "<br />";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $res = array();
        $res[0] = $row;
        $arr=$this->buildingsListArray($res);
        $result = $arr[0];
        return $result;
    }

    public function getBuildingFromBuilding($code,$village_id){
        $sql = "select * from village_building where code = $code and village_id = $village_id limit 1";
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function getBuildingTreeData($village_id){
       //查到最顶级节点
       $sql = "select concat(code,'_',id) as id,code,parent_code,name as text,id as real_id from village_building where effective_status = true and code = parent_code and village_id = $village_id";
       // echo $sql;exit;
       $query = $this->db->query($sql);
       $root_tree = $query->row_array();
       if(!empty($root_tree)){
           $root_tree= $this->treeALLnode($root_tree,$village_id);
           return json_encode($root_tree);
       }
       return false;
   }

   public function treeALLnode($node,$village_id){
       $res = $this->getTreeNodeByPcode($node['code'],$village_id);
       if(!empty($res)){
           $node['children']=$res;
           foreach($res as $k => $v){
               if($v['level']!=106 || $v['level'] !=107){
                    $children = $this->treeALLnode($v,$village_id);
                    if(!empty($children)){
                        $node['children'][$k]= $children;
                    }
               }
            }
        }
        return $node;
    }

    public function getTreeNodeByPcode($parent_code,$village_id){
        $sql = "select concat(code,'_',id) as id,code,parent_code,name as text,id as real_id,level from village_building a where effective_date =(select max(effective_date) from village_building b where a.code = b.code and a.name = b.name and a.parent_code = b.parent_code and b.effective_status = true and b.effective_date <= now() ) and a.parent_code = $parent_code and a.code != $parent_code and a.effective_status = true and a.village_id = $village_id order by a.code,a.id";
        // echo $sql;
        // exit;
        // echo '<br />';
        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }

    public function getTopNode($village_id){
        $sql = "select * from village_building where parent_code = code and village_id = $village_id limit 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function getBuilding($code,$village_id){
        $sql = "select * from village_tmp_building where code = $code and village_id = $village_id limit 1";
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function updateBuildingSipByCode($code,$sip,$village_id){
        $sql = "update village_building set sip= ".
        $this->db->escape($sip)." where code =".
        $this->db->escape($code)." and village_id = ".
        $this->db->escape($village_id);
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function updateBuildingQrcode($code,$qr_code){
        $sql = "update village_building set qr_code= '$qr_code' where code =".
        $this->db->escape($code);
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function getQrcodeData($type,$village,$code,$pngAbsoluteFilePath){
        $data=array();
        $data['type']=$type;
        $data['village']=$village;
        $data['code']=$code;
        $data['img_url']=$pngAbsoluteFilePath;
        $json=json_encode($data);
        return $json;
    }

    public function setQRcode($qrcodeData,$temp_path,$fileName){
        if (!file_exists(iconv('utf-8', 'gbk', $temp_path)))
        {
            mkdir(iconv('utf-8', 'gbk', $temp_path), 0777, true);
        }
        $pngAbsoluteFilePath = $temp_path.$fileName;
        $pngAbsoluteFilePath = iconv('utf-8', 'gbk', $pngAbsoluteFilePath);
        //有图片的情况下,先删除原来的图片 
        if(file_exists($pngAbsoluteFilePath)){
            unlink($pngAbsoluteFilePath);
        }
        QRcode::png($qrcodeData, $pngAbsoluteFilePath);
    }
    
        public function getBuildingbyTree($code)
    {
        $sql = "select * from village_building where code = $code limit 1";
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $arr = $this->buildingsListArray($query->result_array());

        print_r(json_encode($arr));
    }

    public function updateBuildbyTree($code, $name, $rank, $remark)
    {
        if (empty($rank)) {
            $rank = null;
        }
        $sql = "update village_building set name= " .
            $this->db->escape($name) . ", rank=" .
            $this->db->escape($rank) . ", remark=" .
            $this->db->escape($remark) . " where code =" .
            $this->db->escape($code);
        // echo $sql;exit;
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }
     public function getvillageInfo()
    {
        $sql = "select * from village_village";
        $query = $this->db->query($sql);
        $res = $query->row_array();
        $json = json_encode($res);
        return $json;
    }

    public function updatevillageInfo($id,$brief)
    {
        $sql = "update village_village set brief='$brief'  where id=$id";
        $query = $this->db->query($sql);

    }

    public function getvillagename($village_id)
    {
        $sql = "select name from village_tmp_building as b where b.code=$village_id";
        $query = $this->db->query($sql);
        $query=$query->result_array();
        return  $query['0']['name'];
    }
    
    
    
}
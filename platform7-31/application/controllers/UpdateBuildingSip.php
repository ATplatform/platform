<?php
class UpdateBuildingSip extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->database();
    }

    public function updateAllBuildingSip(){
        $village=$this->getVillage();
        // print_r($village);exit;
        if($village===false){
            return false;
        }

        //对每一个小区顶节点循环,写入sip地址
        foreach($village as $item){
            $villageInfo = $this->getVillageInfo($item['village_id']);
            // print_r($villageInfo);exit;
            //更改小区顶节点的sip地址
            $res = $this->updateTopBuildingSip($item['code'],$villageInfo['account'],$item['village_id']);
            //更改小区顶节点的qr_code字段
            //生成小区顶节点的二维码图片
            
            //如果顶节点修改sip成功,开始迭代,对每一个子节点修改sip地址
            if($res==true){
                $this->updateBuildingSipByParentCode($item['code'],$_SESSION['village_id']);
            }

        }
    
    }

    public function getVillage(){
    	$sql = "select * from village_building where level = '100' ";
        // echo $sql;exit;
    	$q = $this->db->query($sql); //自动转义
		if ( $q->num_rows() > 0 ) {
			$arr=$q->result_array();
			return $arr;
		}
		return false;
    }
	
    public function getVillageInfo($village_id){
        $sql = "select * from village_village where id = '$village_id' ";
        // echo $sql;exit;
        $q = $this->db->query($sql); //自动转义
        if ( $q->num_rows() > 0 ) {
            $row = $q->row_array();
            return $row;
        }
        return false;
    }

    public function updateTopBuildingSip($code,$sip,$village_id){
        $sql = "update village_building set sip= ".
        $this->db->escape($sip)." where code =".
        $this->db->escape($code)." and village_id = ".
        $this->db->escape($village_id);
        // echo $sql;exit;
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    //根据父节点的code来更新子节点的sip
    public function updateBuildingSipByParentCode($parent_code,$village_id){
        // echo $village_id;exit;
        //先得到父节点的sip
        $parent_building = $this->getBuildingByCode($parent_code,$village_id);
        $buildings = $this->getBuildingByParentCode($parent_code,$village_id);
        foreach($buildings as $item){
        // var_dump($item);exit;
            $res=$this->updateBuildingSip($item['code'],$item['level'],$item['rank'],$parent_building['sip'],$village_id);
            //开始迭代,迭代的条件是当前节点已经是最底层节点(室或者公共设施)
            if($item['level']!=106 || $item['level'] !=107){
                $this->updateBuildingSipByParentCode($item['code'],$village_id);
            }
        }
    }

    public function getBuildingByCode($code,$village_id){
        $sql = "select * from village_building where code = '$code' and village_id = '$village_id' limit 1";
        // echo $sql;exit;
        $q = $this->db->query($sql); //自动转义
        if ( $q->num_rows() > 0 ) {
            $arr=$q->row_array();
            return $arr;
        }
        return false;
    }

    public function getBuildingByParentCode($parent_code,$village_id){
        $sql = "select * from village_building where parent_code = '$parent_code' and village_id = '$village_id' and code != parent_code ";
        // echo $sql;exit;
        $q = $this->db->query($sql); //自动转义
        if ( $q->num_rows() > 0 ) {
            $arr=$q->result_array();
            return $arr;
        }
        return false;
    }

    public function updateBuildingSip($code,$level,$rank,$p_sip,$village_id){
        //得到被截取的长度
        $len = strrpos($p_sip,"r")+1;
        // echo $level;exit;
        $rank = intval($rank);
        //根据父级节点的sip和当前的楼宇level来截取字符串
        switch ($level) {
            case '106':
                $len = strrpos($p_sip,"r")+1;
                $end = "";
                //表示室,可能会小于0(地下停车场)
                if($rank<0){
                    $rank = 1000 + abs($rank);
                }
                break;
            case '105':
                $len = strrpos($p_sip,"f")+1;
                $end = "r0";
                //可能会小于0(地下停车场)
                if($rank<0){
                    $rank = 1000 + abs($rank);
                }
                break;
            case '104':
                $len = strrpos($p_sip,"u")+1;
                $end = "f0r0";
                break;
            case '103':
                $len = strrpos($p_sip,"b")+1;
                $end = "u0f0r0";
                break;
            case '102':
                $len = strrpos($p_sip,"a")+1;
                $end = "b0u0f0r0";
                break;
            case '101':
                $len = strrpos($p_sip,"s")+1;
                $end = "a0b0u0f0r0";
                break;
            //表示公共设施
            case '107':
                $len = strpos($p_sip,"0");
                switch($len){
                    case '1':
                        $end = "a0b0u0f0r0";
                        break;
                    case '3':
                        $end = "b0u0f0r0";
                        break;
                    case '5':
                        $end = "u0f0r0";
                        break;
                    case '7':
                        $end = "f0r0";
                        break;
                    case '9':
                        $end = "r0";
                        break;
                    case '11':
                        $end = "";
                        break;
                }
                //公共设施的顺序号强制从9001开始
                switch (strlen($rank)) {
                    case '1':
                        $rank = '900'.$rank;
                        break;
                    case '2':
                        $rank = '90'.$rank;
                        break;
                    case '3':
                        $rank = '9'.$rank;
                        break;
                    case '4':
                        $rank = $rank;
                        break;
                }
                break;
        }
        //生成最终的sip
        $sip = substr($p_sip,0,$len).$rank.$end;
        // echo $sip;exit;
        //更新这个楼宇的sip地址
        $res = $this->updateBuildingSipByCode($code,$sip,$village_id);
        //更新成功二维码信息后,生成二维码
    }

    public function updateBuildingSipByCode($code,$sip,$village_id){
        $sql = "update village_building set sip= ".
        $this->db->escape($sip)." where code =".
        $this->db->escape($code)." and village_id = ".
        $this->db->escape($village_id);
        // echo $sql;exit;
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

}
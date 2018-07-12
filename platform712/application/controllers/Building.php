<?php
include(APPPATH.'/libraries/include/phpqrcode/qrlib.php');
error_reporting(E_ERROR);
date_default_timezone_set('Asia/ShangHai');
class Building extends CI_Controller{
	public function __construct(){
		parent::__construct();
		session_start();
		//打开重定向
		$this->load->helper('url');
		$this->load->database();
		$this->user_per_page=$this->config->item('user_per_page');
		$this->at_url=$this->config->item('at_url');
	}
	//模拟生成tmp_building表
	public function setTmpBuilding(){
		$this->load->model('TmpBuilding_model');
		$this->TmpBuilding_model->getTmpBuilding();
	}

	public function index(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$this->load->view('app/buiding_tree');
	}

	public function buildingtree(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$keyword=$this->input->get('keyword');
		$data['keyword']=$keyword;
		$data['nav']='buildingtree';
		$data['username']=$_SESSION['username'];
		$data['at_url']= $this->at_url;
		$this->load->view('app/buiding_tree',$data);
	}

	public function getBuildingTreeData(){
		$this->load->model('Building_model');
		$village_id = $_SESSION['village_id'];
		$result = $this->Building_model->getBuildingTreeData($village_id);
		echo $result;
	}

	public function buildinglist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$village_id = $_SESSION['village_id'];
		$id=$this->input->get('id');
		$parent_code=$this->input->get('parent_code');
		$page=$this->input->get('page');
		$keyword=$this->input->get('keyword');
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		$this->load->model('Building_model');
		$level =  '';
		$village_id = $_SESSION['village_id'];
		if(!empty($parent_code)){
			//根据code查出当前的building_level
			$buidling = $this->Building_model->getBuilding($parent_code,$village_id);
			$level = $buidling['level'];
		}
		
		$total=$this->Building_model->getBuildingTotal($level,$keyword,$id,$parent_code,$this->user_per_page,$village_id);
		//树形菜单
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		
		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['id']=$id;
		$data['parent_code']=$parent_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='buildinglist';
		$data['username']=$_SESSION['username'];
		$data['at_url']= $this->at_url;
		$this->load->view('app/buiding_list',$data);
	}

	public function getBuildingsList(){
		$id=$this->input->get('id');
		$parent_code=$this->input->get('parent_code');
		$page = $this->input->get('page');
		$page = $page?$page:'1';
		$keyword = $this->input->get('keyword');
		$this->load->model('Building_model');
		//根据code查出当前的building_level
		$level = " ";
		$village_id = $_SESSION['village_id'];
		if(!empty($parent_code)){
			$buidling = $this->Building_model->getBuilding($parent_code,$village_id);
			$level = $buidling['level'];
		}
		$data = $this->Building_model->getBuildingsList($level,$keyword,$id,$parent_code,$page,$this->user_per_page,$village_id);
		echo $data;
	}

	public function insertBuilding(){
		$now = date('Y-m-d h:i:s',time());
		$code = $this->input->post('code');
		$effective_date = $this->input->post('effective_date');
		$effective_status = $this->input->post('effective_status');
		$name = $this->input->post('name');
		$level = $this->input->post('level');
		$rank = $this->input->post('rank');
		$parent_code = $this->input->post('parent_code');
		$remark = $this->input->post('remark');
		$this->load->model('Building_model');
		$village_id = $_SESSION['village_id'];
		// echo $village_id;exit;

		//先插入一条数据
		$res = $this->Building_model->insertBuilding($village_id,$code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$remark,$now);

		if($res==true){
			$data['message'] = '新增楼宇成功';
			//新增成功后,重新生成临时表
			$this->load->model('TmpBuilding_model');
			$this->TmpBuilding_model->getTmpBuilding();

			//更新这个楼宇的sip
			$parent_building = $this->Building_model->getBuildingFromBuilding($parent_code,$village_id);
			$p_sip = $parent_building['sip'];
			$this->updateBuildingSip($code,$level,$rank,$p_sip,$village_id);
			//更新这条数据的qr_code,然后生成一张二维码图片
			$this->setQRcode($code);
		}
		else {
			$data['message'] = '新增楼宇失败';
		}
		print_r(json_encode($data));
	}

	public function setQRcode($code){
		$village_id = $_SESSION['village_id'];
		//生成二维码的信息
		//得到楼宇信息
		$this->load->model('Building_model');
		$building = $this->Building_model->getBuilding($code,$village_id);
		$householdInfo = $this->Building_model->getHouseholdInfo($building);
		//二维码名称
		$fileName = $householdInfo.'.png';
		//二维码图片地址
		$pngAbsoluteFilePath='';
		$village_name = $_SESSION['village_name'];
		$temp_path='qrcode/'.$village_id.$village_name.'楼宇地点二维码/';
		//二维码内容,楼宇的二维码type为102,village暂时写为100001
		//生成的二维码图片地址
		$pngAbsoluteFilePath = $temp_path.$fileName;
		$qrcodeData = $this->Building_model->getQrcodeData(102,$village_id,$code,$pngAbsoluteFilePath);
		//更新这栋楼宇的二维码信息,生成二维码图片
		$this->Building_model->updateBuildingQrcode($code,$qrcodeData);
		$this->Building_model->setQRcode($qrcodeData,$temp_path,$fileName);
	}

	public function updateBuildingSip($code,$level,$rank,$p_sip,$village_id){
		//得到被截取的长度
		$len = strrpos($p_sip,"r")+1;
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
		//更新这个楼宇的sip地址
		$this->load->model('Building_model');
		$this->Building_model->updateBuildingSipByCode($code,$sip,$village_id);
	}

	public function updateBuilding(){
		$now = date('Y-m-d H:i:s',time());
		$id = $this->input->post('id');
		$code = $this->input->post('code');
		$name = $this->input->post('name');
		$level = $this->input->post('level');
		$rank = $this->input->post('rank');
		$parent_code = $this->input->post('parent_code');
		$remark = $this->input->post('remark');
		$village_id = $_SESSION['village_id'];
		//带search的参数用于异步刷新页面时做分页和查询总条数
		$keyword = $this->input->post('keyword');
		$search_parent_code = $this->input->post('search_parent_code');
		$search_id = $this->input->post('search_id');
		$effective_date = $this->input->post('effective_date');
		$effective_status = $this->input->post('effective_status');
		$this->load->model('Building_model');
		//先查到这条信息
		$oldBuilding = $this->Building_model->getBuildingById($id);
		//更新楼宇信息,如果生效日期没变,则更新这条信息,如果生效日期变化了,就新插入一条信息
		if($effective_date==$oldBuilding['effective_date']){
			$res = $this->Building_model->updateBuilding($id,$code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$remark,$now);
		}
		else {
			$res = $this->Building_model->insertBuilding($code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$remark,$now);
		}
		
		if($res==true){
			$data['message'] = '编辑楼宇成功';
		}
		else {
			$data['message'] = '编辑楼宇失败';
		}
		//根据code查出当前的building_level
		$level = " ";
		if(!empty($search_parent_code)){
			$buidling = $this->Building_model->getBuilding($search_parent_code,$village_id);
			$level = $buidling['level'];
		}
		$total=$this->Building_model->getBuildingTotal($level,$keyword,$search_id,$search_parent_code,$this->user_per_page,$village_id);
		$data['total'] = $total;
		print_r(json_encode($data));
	}

	public function updateBuildingName(){
		$now = date('Y-m-d H:i:s',time());
		$id = $this->input->post('id');
		$code = $this->input->post('code');
		$name = $this->input->post('name');
		$old_name = $this->input->post('old_name');
		$rank = $this->input->post('rank');
		$remark = $this->input->post('remark');
		$img_url = $this->input->post('img_url');
		$village_id = $_SESSION['village_id'];

		//带search的参数用于异步刷新页面时做分页和查询总条数
		$search_parent_code = $this->input->post('search_parent_code');
		$keyword = $this->input->post('keyword');
		$search_id = $this->input->post('search_id');
		$this->load->model('Building_model');
		//校正楼宇信息
		$res = $this->Building_model->updateBuildingName($code,$name,$remark,$village_id);
		if($res==true){
			$data['message'] = '编辑楼宇成功';
			//重新生成临时表
			$this->load->model('TmpBuilding_model');
			$this->TmpBuilding_model->getTmpBuilding();
			//楼宇名称改变了,那么二维码内容和图片都要改变
			if($name!=$old_name){
				//先删除原来的二维码图片
				$img_url = iconv('utf-8', 'gbk', $img_url);
				//有图片的情况下,先删除原来的图片 
				if(file_exists($img_url)){
				    unlink($img_url);
				}
				//更新这条数据的qr_code,然后生成一张二维码图片
				$this->setQRcode($code);
			}
		}
		else {
			$data['message'] = '编辑楼宇失败';
		}
		//根据code查出当前的building_level
		$level = " ";
		if(!empty($search_parent_code)){
			$buidling = $this->Building_model->getBuilding($search_parent_code,$village_id);
			$level = $buidling['level'];
		}
		$total=$this->Building_model->getBuildingTotal($level,$keyword,$search_id,$search_parent_code,$this->user_per_page,$village_id);
		$data['total'] = $total;
		print_r(json_encode($data));
	}

	public function getBuildingCode(){
		$this->load->model('Building_model');
		$res = $this->Building_model->getBuildingCode();
		if(empty($res)){
			$res = 100000;
		}
		echo $res; 
	}

	public function getBuildingNameCode(){
		$village_id = $_SESSION['village_id'];
		$this->load->model('Building_model');
		$res = $this->Building_model->getBuildingNameCode($village_id);
		echo $res;
	}

	public function getBuildingByCode(){
		$village_id = $_SESSION['village_id'];
		$this->load->model('Building_model');
		$res = $this->Building_model->getBuildingNameCode($village_id );
		echo $res;
	}

	//获取最近的有效房间号
	public function getBuildingLast(){
		$village_id = $_SESSION['village_id'];
		$this->load->model('Building_model');
		$res = $this->Building_model->getBuildingNameCode($village_id);
		echo $res;
	}

	public function getBuilding(){
		$village_id = $_SESSION['village_id'];
		$building_code = $this->input->post('building_code');
		$this->load->model('Building_model');
		$res = $this->Building_model->getBuilding($building_code,$village_id);
		print_r(json_encode($res));
	}
    public function getBuildingbyTree(){
        $building_code = $this->input->post('building_code');
        $this->load->model('Building_model');
        $res = $this->Building_model->getBuildingbyTree($building_code);
        echo $res;
    }

    public function updateBuildbyTree(){
        $code = $this->input->post('code');
        $name = $this->input->post('name');
        $rank = $this->input->post('rank');
        $remark = $this->input->post('remark');
        $this->load->model('Building_model');
        $res = $this->Building_model->updateBuildbyTree($code,$name,$rank,$remark);
        if($res==true){
            $data['message'] = '编辑楼宇成功';
        }
        else {
            $data['message'] = '编辑楼宇失败';
        }
        print_r(json_encode($data));
    }


    public function villageInfo(){
        if ( !isset($_SESSION['username']) ) {
            redirect('Login');
        }

        $data['nav']='villageInfo';
        $data['username']=$_SESSION['username'];
        $this->load->view('app/villageInfo_list',$data);
    }

    public function getvillageInfo(){


        $this->load->model('Building_model');


        $res = $this->Building_model->getvillageInfo();
        echo $res;
    }

    public function updatevillageInfo(){
        $id=$this->input->post('id');
        $brief=$this->input->post('brief');
        $this->load->model('Building_model');


        $res = $this->Building_model->updatevillageInfo($id,$brief);
        echo $res;
    }



}
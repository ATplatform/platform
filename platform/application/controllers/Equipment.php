<?php
include(APPPATH.'/libraries/include/phpqrcode/qrlib.php');
date_default_timezone_set('Asia/ShangHai');

class Equipment extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		session_start();
		//打开重定向
		$this->load->helper('url');
		$this->load->database();
		$this->user_per_page=$this->config->item('user_per_page');
		$this->equipment_type_arr=$this->config->item('equipment_type_arr');
		$this->equipment_type_sip_arr=$this->config->item('equipment_type_sip_arr');
		$this->at_url=$this->config->item('at_url');
	}

	public function index(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$this->load->view('app/equipment_list');
	}

	public function equipmentlist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$regular_check = $this->input->get('regular_check');
		$regular_check = $this->input->get('regular_check');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
		if(is_null($page)||empty($page))
		{
			$page=1;
		}

		//得到总条数
		$this->load->model('Equipment_model');
		$level = ' ';
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$buildings = $this->Equipment_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		$total = $this->Equipment_model->getEquipmentListTotal($village_id,$page,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$level,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date']=$effective_date;
		$data['equipment_type']=$equipment_type;
		$data['regular_check']=$regular_check;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='equipmentlist';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/equipment_list',$data);
	}

	public function getEquipmentNameCode(){
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		$res = $this->Equipment_model->getEquipmentNameCode($village_id);
		echo $res;
	}

	public function getEquipmentCode(){
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		$res = $this->Equipment_model->getEquipmentCode($village_id);
		if(empty($res)){
			$res = 1000000;
		}
		echo $res;
	}

	public function insertEquipment(){
		$now = date('Y-m-d h:i:s',time());
		$code = $this->input->post('code');
		$effective_date = $this->input->post('effective_date');
		$effective_status = $this->input->post('effective_status');
		$name = $this->input->post('name');
		$pcs = $this->input->post('pcs');
		$sign = $this->input->post('sign');
		$equipment_type = $this->input->post('equipment_type');
		$building_code = $this->input->post('building_code');
		$function_name = $this->input->post('function_name');
		$internal_no = $this->input->post('internal_no');
		$initial_no = $this->input->post('initial_no');
		$initial_model = $this->input->post('initial_model');
		$tech_spec = $this->input->post('tech_spec');
		$supplier = $this->input->post('supplier');
		$production_date  = $this->input->post('production_date');
		$parent_code = $this->input->post('parent_code');
		$regular_check  = $this->input->post('regular_check');
		$regular_date = $this->input->post('regular_date');
		$position_code = $this->input->post('position_code');
		$if_se = $this->input->post('if_se');
		$annual_check = $this->input->post('annual_check');
		$annual_date = $this->input->post('annual_date');
		$village_id = $_SESSION['village_id'];
		//生成二维码图片
		$qrcodeData = $this->setEquipmentQRcodeImg($code,$building_code,$equipment_type,$sign,$name);

		$this->load->model('Equipment_model');
		$res = $this->Equipment_model->insertEquipment($village_id,$qrcodeData,$code,$effective_date,$effective_status,$name,$pcs,$sign,$equipment_type,$building_code,$function_name,$internal_no,$initial_no,$initial_model,$tech_spec,$supplier,$production_date,$parent_code,$regular_check,$regular_date,$position_code,$if_se,$annual_check,$annual_date);
		if($res==true){
			$data['message'] = '新增成功';
		}
		else {
			$data['message'] = '新增失败';
		}
		print_r(json_encode($data));
	}

	//生成二维码图片方法
	public function setEquipmentQRcodeImg($code,$building_code,$equipment_type,$sign,$name){
		$village_id = $_SESSION['village_id'];
		$village_name = $_SESSION['village_name'];
		//得到楼宇信息
		$this->load->model('Building_model');
		$building = $this->Building_model->getBuilding($building_code,$village_id);
		$householdInfo = $this->Building_model->getHouseholdInfo($building);
		//二维码名称
		$fileName = $householdInfo.$name.'.png';
		//二维码图片地址
		$pngAbsoluteFilePath='';
		$temp_path='qrcode/'.$village_id.$village_name.'设备二维码/';
		//二维码内容,设备的二维码type为101,village暂时写为100001
		$this->load->model('Building_model');
		//生成的二维码图片地址
		$pngAbsoluteFilePath = $temp_path.$fileName;
		$qrcodeData = $this->Building_model->getQrcodeData(101,100001,$code,$pngAbsoluteFilePath);
		$this->Building_model->setQRcode($qrcodeData,$temp_path,$fileName);
		return $qrcodeData;
	}

	public function getEquipmentList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$regular_check = $this->input->get('regular_check');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';
		$village_id = $_SESSION['village_id'];
		$level = ' ';
		$this->load->model('Equipment_model');
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$buildings = $this->Equipment_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		//获得数据
		$res = $this->Equipment_model->getEquipmentList($village_id,$page,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$level,$this->user_per_page);
		echo $res;	
	}

	public function updateEquipment(){
		$now = date('Y-m-d h:i:s',time());
		$code = $this->input->post('code');
		$name = $this->input->post('name');
		$pcs = $this->input->post('pcs');
		$sign = $this->input->post('sign');
		$equipment_type = $this->input->post('equipment_type');
		$building_code = $this->input->post('building_code');
		$function_name = $this->input->post('function_name');
		$internal_no = $this->input->post('internal_no');
		$initial_no = $this->input->post('initial_no');
		$initial_model = $this->input->post('initial_model');
		$tech_spec = $this->input->post('tech_spec');
		$supplier = $this->input->post('supplier');
		$production_date  = $this->input->post('production_date');
		$parent_code = $this->input->post('parent_code');
		$regular_check  = $this->input->post('regular_check');
		$regular_date = $this->input->post('regular_date');
		$position_code = $this->input->post('position_code');
		$if_se = $this->input->post('if_se');
		$annual_check = $this->input->post('annual_check');
		$annual_date = $this->input->post('annual_date');
		//带search用于查询数据条数
		$page = $this->input->post('page');
		$search_keyword = $this->input->post('search_keyword');
		$search_effective_date = $this->input->post('search_effective_date');
		$search_equipment_type = $this->input->post('search_equipment_type');
		$search_regular_check = $this->input->post('search_regular_check');
		$search_building_code = $this->input->post('search_building_code');
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		//得到设备以前的名称
		$equipment = $this->Equipment_model->getEquipmentByCode($code,$village_id);
		$old_name = $equipment['name'];
		$old_qr_code = $equipment['qr_code'];
		$old_equipment_type = $equipment['equipment_type'];
		$old_sign = $equipment['sign'];
		$old_building_code = $equipment['building_code'];
		//如果设备类型\设备号\安装地点发生了变化,就要重新生成设备sip地址
		if($old_equipment_type!=$equipment_type||$old_sign!=$sign||$old_building_code!=$building_code){
			$this->updateEquipmentSip($building_code,$code,$equipment_type,$sign);
			//更新完sip地址后,紧接着重新生成设备网络配置二维码
        	//删除旧的网络配置二维码
			$old_config_img_url = $equipment['tdcode_url'];
			$old_config_img_url = iconv('utf-8', 'gbk', $old_config_img_url);
			if(file_exists($old_config_img_url)){
            	unlink($old_config_img_url);
        	}
        	//生成新的网络配置二维码
        	//得到新sip地址
        	$new_equipment = $this->Equipment_model->getEquipmentByCode($code,$village_id);
        	//得到新二维码信息
        	$config_qrcodeData = $this->Equipment_model->getConfigData($code,$equipment['server_ip'],$equipment['lan_ip'],$equipment['ip'],$equipment['gateway'],$equipment['netmask'],$equipment['dns1'],$equipment['dns2'],$new_equipment['sip']);
        	//生成一张二维码图片
        	$pngAbsoluteFilePath = $this->setConfigQRcodeImg($equipment['building_code'],$name,$config_qrcodeData);
		}
		
		//如果名称已经改变,则重新生成二维码图片(设备二维码和网络配置二维码)
		if($old_name!=$name){
			//先删除旧的设备二维码
			$qr_code_arr = json_decode($old_qr_code,true);
			$img_url = $qr_code_arr['img_url'];
			$img_url = iconv('utf-8', 'gbk', $img_url);
			if(file_exists($img_url)){
            	unlink($img_url);
        	}
        	//生成新的设备二维码
        	$qrcodeData = $this->setEquipmentQRcodeImg($code,$building_code,$equipment_type,$sign,$name);
        	//更新qr_code字段:
        	$this->Equipment_model->updateEquipmentQrCode($code,$qrcodeData,$village_id);

        	//删除旧的网络配置二维码
			$old_config_img_url = $equipment['tdcode_url'];
			$old_config_img_url = iconv('utf-8', 'gbk', $old_config_img_url);
			if(file_exists($old_config_img_url)){
            	unlink($old_config_img_url);
        	}
        	//生成新的网络配置二维码
        	//得到新二维码信息
        	$config_qrcodeData = $this->Equipment_model->getConfigData($code,$equipment['server_ip'],$equipment['lan_ip'],$equipment['ip'],$equipment['gateway'],$equipment['netmask'],$equipment['dns1'],$equipment['dns2'],$equipment['sip']);
        	//生成一张二维码图片
        	$pngAbsoluteFilePath = $this->setConfigQRcodeImg($equipment['building_code'],$name,$config_qrcodeData);
        	//更新tdcode_url字段
        	$this->Equipment_model->updateEquipmentTdCodeUrl($code,$pngAbsoluteFilePath,$village_id);
		}
		else {
			$qrcodeData = $old_qr_code;
		}
		$res = $this->Equipment_model->updateEquipment($code,$village_id,$name,$qrcodeData,$sign,$pcs,$equipment_type,$building_code,$function_name,$internal_no,$initial_no,$initial_model,$tech_spec,$supplier,$production_date,$parent_code,$regular_check,$regular_date,$position_code,$if_se,$annual_check,$annual_date);
		if($res==true){
			$data['message'] = '编辑成功';
		}
		else {
			$data['message'] = '编辑失败';
		}
		//得到总条数
		$this->load->model('Equipment_model');
		$level = ' ';
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($search_building_code)){
			$buildings = $this->Equipment_model->getBuildingByCode($search_building_code,$village_id);
			$level = $buildings['level'];
		}
		$total = $this->Equipment_model->getEquipmentListTotal($village_id,$page,$search_keyword,$search_effective_date,$search_equipment_type,$search_regular_check,$search_building_code,$level,$this->user_per_page);
		$data['total'] = $total;
		print_r(json_encode($data));
	}

	public function personequipmentlist(){
		if ( !isset($_SESSION['username']) ) {
		redirect('Login');
		}
		$now = date('Y-m-d');
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$regular_check = $this->input->get('regular_check');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		$building_code_arr = array();
		$person_code_arr = array();
		if(!is_null($keyword)&&$keyword!=''){
			//根据搜索词查到buildingcode
			$buildings = $this->Equipment_model->getBuildingByName($keyword,$village_id);
			if(!empty($buildings)){
				foreach($buildings as $key => $row){
					if(!empty($row['code'])){
						array_push($building_code_arr,$row['code']);
					}
				}
			}
			//根据搜索词查到personcode
			$persons = $this->Equipment_model->getPersonByName($keyword,$village_id);
			if(!empty($persons)){
				foreach($persons as $key => $row){
					if(!empty($row['code'])){
						array_push($person_code_arr,$row['code']);
					}
				}
			}
		}
		$effective_date = $effective_date?$effective_date:$now;
		//得到总条数
		$total = $this->Equipment_model->getPersoneEquipmentListTotal($village_id,$person_code_arr,$building_code_arr,$keyword,$effective_date,$equipment_type,$building_code,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date']=$effective_date;
		$data['equipment_type']=$equipment_type;
		$data['regular_check']=$regular_check;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='personequipmentlist';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/personequipment_list',$data);
	}

	public function equipmentprivilegelist(){
		if ( !isset($_SESSION['username']) ) {
		redirect('Login');
		}
		$now = date('Y-m-d');
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$regular_check = $this->input->get('regular_check');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		$building_code_arr = array();
		$person_code_arr = array();
		if(!is_null($keyword)&&$keyword!=''){
			//根据搜索词查到buildingcode
			$buildings = $this->Equipment_model->getBuildingByName($keyword,$village_id);
			if(!empty($buildings)){
				foreach($buildings as $key => $row){
					if(!empty($row['code'])){
						array_push($building_code_arr,$row['code']);
					}
				}
			}
			//根据搜索词查到personcode
			$persons = $this->Equipment_model->getPersonByName($keyword,$village_id);
			if(!empty($persons)){
				foreach($persons as $key => $row){
					if(!empty($row['code'])){
						array_push($person_code_arr,$row['code']);
					}
				}
			}
		}
		$effective_date = $effective_date?$effective_date:$now;
		//得到总条数
		$total = $this->Equipment_model->getPrivilegeEquipmentListTotal($village_id,$person_code_arr,$building_code_arr,$keyword,$effective_date,$equipment_type,$building_code,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date']=$effective_date;
		$data['equipment_type']=$equipment_type;
		$data['regular_check']=$regular_check;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='equipmentprivilegelist';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/equipmentprivilege_list',$data);
	}

	public function getEquipmentByName(){
		$village_id = $_SESSION['village_id'];
		$name = $this->input->post('name');
		$this->load->model('Equipment_model');
		$res = $this->Equipment_model->getEquipmentByName($name,$village_id);
		print_r(json_encode($res));
	}

	public function insertPersonEquipment(){
		$now = date('Y-m-d h:i:s',time());
		$equipment_code = $this->input->post('code');
		$person_code = $this->input->post('person_code');
		$building_code = $this->input->post('building_code');
		$begin_date = $this->input->post('begin_date');
		$end_date = $this->input->post('end_date');
		$remark = $this->input->post('remark');
		$village_id = $_SESSION['village_id'];
		$person_code = "{" .$person_code."}";
		$building_code = "{" .$building_code."}";

		$this->load->model('Equipment_model');
		$lastEquipment = $this->Equipment_model->getLastPersonEquipment($village_id);
		$code = $lastEquipment['code'];
		if(!$code){
			$code = 1000001;
		}
		else {
			$code = $code + 1;
		}		
		$res = $this->Equipment_model->insertPersonEquipment($code,$village_id,$equipment_code,$person_code,$building_code,$begin_date,$end_date,$remark);
		if($res==true){
			$data['message'] = '新增成功';
		}
		else {
			$data['message'] = '新增失败';
		}
		print_r(json_encode($data));

	}

	public function getPersoneEquipmentList(){
		$now = date('Y-m-d');
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';
		$building_code_arr = array();
		$person_code_arr = array();
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		$building_code_arr = array();
		$person_code_arr = array();
		if(!is_null($keyword)&&$keyword!=''){
			// echo '1';
			// echo $keyword;exit;
			//根据搜索词查到buildingcode
			$buildings = $this->Equipment_model->getBuildingByName($keyword,$village_id);
			if(!empty($buildings)){
				foreach($buildings as $key => $row){
					if(!empty($row['code'])){
						array_push($building_code_arr,$row['code']);
					}
				}
			}
			//根据搜索词查到personcode
			$persons = $this->Equipment_model->getPersonByName($keyword,$village_id);
			if(!empty($persons)){
				foreach($persons as $key => $row){
					if(!empty($row['code'])){
						array_push($person_code_arr,$row['code']);
					}
				}
			}
		}
		$effective_date = $effective_date?$effective_date:$now;
		//获得数据
		$res = $this->Equipment_model->getPersoneEquipmentList($village_id,$person_code_arr,$building_code_arr,$page,$keyword,$effective_date,$equipment_type,$building_code,$this->user_per_page);
		echo $res;	
	}

	public function getPrivilegeEquipmentList(){
		$now = date('Y-m-d');
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';
		$building_code_arr = array();
		$person_code_arr = array();
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		$building_code_arr = array();
		$person_code_arr = array();
		if(!is_null($keyword)&&$keyword!=''){
			// echo '1';
			// echo $keyword;exit;
			//根据搜索词查到buildingcode
			$buildings = $this->Equipment_model->getBuildingByName($keyword,$village_id);
			if(!empty($buildings)){
				foreach($buildings as $key => $row){
					if(!empty($row['code'])){
						array_push($building_code_arr,$row['code']);
					}
				}
			}
			//根据搜索词查到personcode
			$persons = $this->Equipment_model->getPersonByName($keyword,$village_id);
			if(!empty($persons)){
				foreach($persons as $key => $row){
					if(!empty($row['code'])){
						array_push($person_code_arr,$row['code']);
					}
				}
			}
		}
		$effective_date = $effective_date?$effective_date:$now;
		//获得数据
		$res = $this->Equipment_model->getPrivilegeEquipmentList($village_id,$person_code_arr,$building_code_arr,$page,$keyword,$effective_date,$equipment_type,$building_code,$this->user_per_page);
		echo $res;	
	}


	public function updatePersonEquipment(){
		$now = date('Y-m-d h:i:s',time());
		$code = $this->input->post('code');
		$person_code = $this->input->post('person_code');
		$building_code = $this->input->post('building_code');
		$begin_date = $this->input->post('begin_date');
		$end_date = $this->input->post('end_date');
		$remark = $this->input->post('remark');

		//带search的参数用于异步刷新页面时做分页和查询总条数
		$search_keyword = $this->input->post('search_keyword');
		$search_effective_date = $this->input->post('search_effective_date');
		$search_equipment_type = $this->input->post('search_equipment_type');
		$search_building_code = $this->input->post('search_building_code');
		$search_effective_date = $search_effective_date?$search_effective_date:$now;
		$village_id = $_SESSION['village_id'];
		$person_code = "{" .$person_code."}";
		$building_code = "{" .$building_code."}";

		$this->load->model('Equipment_model');		
		$res = $this->Equipment_model->updatePersonEquipment($village_id,$code,$person_code,$building_code,$begin_date,$end_date,$remark);
		if($res==true){
			$data['message'] = '编辑成功';
		}
		else {
			$data['message'] = '编辑失败';
		}

		$building_code_arr = array();
		$person_code_arr = array();
		if(!is_null($search_keyword)&&$search_keyword!=''){
			//根据搜索词查到buildingcode
			$buildings = $this->Equipment_model->getBuildingByName($search_keyword,$village_id);
			if(!empty($buildings)){
				foreach($buildings as $key => $row){
					if(!empty($row['code'])){
						array_push($building_code_arr,$row['code']);
					}
				}
			}
			//根据搜索词查到personcode
			$persons = $this->Equipment_model->getPersonByName($search_keyword,$village_id);
			if(!empty($persons)){
				foreach($persons as $key => $row){
					if(!empty($row['code'])){
						array_push($person_code_arr,$row['code']);
					}
				}
			}
		}
		
		//得到授权设备总数
		$total = $this->Equipment_model->getPersoneEquipmentListTotal($village_id,$person_code_arr,$building_code_arr,$search_keyword,$search_effective_date,$search_equipment_type,$search_building_code,$this->user_per_page);
		$data['total'] = $total;

		print_r(json_encode($data));
	}

	public function equipmentconfig(){
		if ( !isset($_SESSION['username']) ) {
		redirect('Login');
		}

		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		$building_code_arr = array();
		$person_code_arr = array();
		
		//得到总条数
		$total = $this->Equipment_model->getEquipmentConfigTotal($village_id,$page,$keyword,$effective_date,$equipment_type,$building_code,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date']=$effective_date;
		$data['equipment_type']=$equipment_type;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='equipmentconfig';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/equipment_config',$data);
	}

	public function getConfigEquipmentNameCode(){
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		$res = $this->Equipment_model->getConfigEquipmentNameCode($village_id);
		echo $res;
	}

	public function getEquipmentConfig(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		//获得数据
		$res = $this->Equipment_model->getEquipmentConfig($village_id,$page,$keyword,$effective_date,$equipment_type,$building_code,$this->user_per_page);
		echo $res;
	}



	public function insertEquipmentConfig(){
		$code = $this->input->post('code');
		$severip = $this->input->post('severip');
		$lan_ip = $this->input->post('lan_ip');
		$ip = $this->input->post('ip');
		$gatewayip = $this->input->post('gatewayip');
		$netmask = $this->input->post('netmask');
		$dns1 = $this->input->post('dns1');
		$dns2 = $this->input->post('dns2');
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');

		//先得到设备的名称和building_code,设备类型,设备号
		$equipment = $this->Equipment_model->getEquipmentByCode($code,$village_id);
		$building_code = $equipment['building_code'];
		$name = $equipment['name'];
		$equipment_type = $equipment['equipment_type'];
		$equipment_sign = $equipment['sign'];

		//更新设备sip地址
		$equipment_sip = $this->updateEquipmentSip($building_code,$code,$equipment_type,$equipment_sign);

		$qrcodeData = $this->Equipment_model->getConfigData($code,$severip,$lan_ip,$ip,$gatewayip,$netmask,$dns1,$dns2,$equipment_sip);

		// print_r($qrcodeData);exit;
		//生成一张二维码图片
		$pngAbsoluteFilePath = $this->setConfigQRcodeImg($building_code,$name,$qrcodeData);

		//更新设备配置信息
		$res = $this->Equipment_model->updateEquipmentConfig($code,$village_id,$severip,$lan_ip,$ip,$gatewayip,$netmask,$dns1,$dns2,$pngAbsoluteFilePath);
		if($res==true){
			$data['message'] = '新增成功';
		}
		else {
			$data['message'] = '新增失败';
		}
		print_r(json_encode($data));
	}

	public function updateEquipmentSip($building_code,$code,$equipment_type,$equipment_sign){
		$village_id = $_SESSION['village_id'];
		//得到楼宇信息
		$this->load->model('Building_model');
		$building = $this->Building_model->getBuildingFromBuilding($building_code,$village_id);
		//楼宇sip
		$building_sip = $building['sip'];

		//根据设备的类型拼接出设备的sip
		$equipment_type_sip_n = '';
		$equipment_type_sip_arr=$this->equipment_type_sip_arr;
		foreach($equipment_type_sip_arr as $k => $v){
			if($equipment_type==$v['code']){
				$equipment_type_sip_n = $v['name'];
				break;
			}
		}
		$equipment_sip = $building_sip.'n'.$equipment_sign.'_'.$equipment_type_sip_n;
		//更新sip地址
		$this->Equipment_model->updateEquipmentSip($code,$equipment_sip,$village_id);
		return $equipment_sip;
	}

	public function setConfigQRcodeImg($building_code,$name,$qrcodeData){
		$this->load->model('Building_model');
		$village_id = $_SESSION['village_id'];
		//楼宇名称
		$building_more = $this->Building_model->getBuilding($building_code,$village_id);
		$householdInfo = $this->Building_model->getHouseholdInfo($building_more);
		//二维码名称
		$fileName = $householdInfo.$name.'.png';
		//二维码图片地址
		$pngAbsoluteFilePath='';
		$village_id = $_SESSION['village_id'];
		$village_name = $_SESSION['village_name'];
		$temp_path='qrcode/'.$village_id.$village_name.'网络配置二维码/';
		//生成的二维码图片地址
		$pngAbsoluteFilePath = $temp_path.$fileName;
		//生成一张二维码图片
		$this->Building_model->setQRcode($qrcodeData,$temp_path,$fileName);
		return $pngAbsoluteFilePath;
	}

	public function updateEquipmentConfig(){
		$code = $this->input->post('code');
		$severip = $this->input->post('severip');
		$lan_ip = $this->input->post('lan_ip');
		$ip = $this->input->post('ip');
		$gatewayip = $this->input->post('gatewayip');
		$netmask = $this->input->post('netmask');
		$dns1 = $this->input->post('dns1');
		$dns2 = $this->input->post('dns2');
		$old_tdcode_url = $this->input->post('old_tdcode_url');
		//带search为查找总条数的分页参数
		$page = $this->input->post('page');
		$search_keyword = $this->input->post('search_keyword');
		$search_effective_date = $this->input->post('search_effective_date');
		$search_equipment_type = $this->input->post('search_equipment_type');
		$search_building_code = $this->input->post('search_building_code');
		$page = $page?$page:1;
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		//先得到设备的名称和building_code,设备类型,设备号
		$equipment = $this->Equipment_model->getEquipmentByCode($code,$village_id);
		$building_code = $equipment['building_code'];
		$name = $equipment['name'];
		$equipment_type = $equipment['equipment_type'];
		$equipment_sign = $equipment['sign'];
		$equipment_sip = $equipment['sip'];

		//删除原来的二维码图片
		$old_tdcode_url= iconv('utf-8', 'gbk', $old_tdcode_url);
		if(file_exists($old_tdcode_url)){
		    unlink($old_tdcode_url);
		}

		//得到新二维码信息
		$qrcodeData = $this->Equipment_model->getConfigData($code,$severip,$lan_ip,$ip,$gatewayip,$netmask,$dns1,$dns2,$equipment_sip);

		//生成一张二维码图片
		$pngAbsoluteFilePath = $this->setConfigQRcodeImg($building_code,$name,$qrcodeData);

		//更新设备配置信息
		$res = $this->Equipment_model->updateEquipmentConfig($code,$village_id,$severip,$lan_ip,$ip,$gatewayip,$netmask,$dns1,$dns2,$pngAbsoluteFilePath);

		//得到总条数
		$data['total'] = $this->Equipment_model->getEquipmentConfigTotal($village_id,$page,$search_keyword,$search_effective_date,$search_equipment_type,$search_building_code,$this->user_per_page);

		if($res==true){
			$data['message'] = '编辑成功';
		}
		else {
			$data['message'] = '编辑失败';
		}
		print_r(json_encode($data));
	}

	public function equipmentstatus(){
		if ( !isset($_SESSION['username']) ) {
			redirect('Login');
		}
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$regular_check = $this->input->get('regular_check');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		$level = ' ';
		$this->load->model('Equipment_model');
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$buildings = $this->Equipment_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		//得到总条数
		$total = $this->Equipment_model->getEquipmentStatusTotal($village_id,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$level,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date']=$effective_date;
		$data['equipment_type']=$equipment_type;
		$data['regular_check'] = $regular_check;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='equipmentstatus';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/equipment_status',$data);
	}

	public function getEquipmentStatus(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$regular_check = $this->input->get('regular_check');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';
		$village_id = $_SESSION['village_id'];
		$level = ' ';
		$this->load->model('Equipment_model');
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$buildings = $this->Equipment_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		// print_r($buildings);exit;
		//获得数据
		$res = $this->Equipment_model->getEquipmentStatus($village_id,$page,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$level,$this->user_per_page);
		echo $res;
	}

	public function verifyLanip(){
		$code = $this->input->post('code');
		$lan_ip = $this->input->post('lan_ip');
		$village_id = $_SESSION['village_id'];
		$this->load->model('Equipment_model');
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		$res = $this->Equipment_model->verifyLanip($village_id,$lan_ip,$code);
		if(!empty($res)){
			$data['message'] = "局域网ip已存在";
		}
		else {
			$data['message'] = '局域网ip不存在';
		}
		print_r(json_encode($data));
	}

	public function equipmentservice(){
		if ( !isset($_SESSION['username']) ) {
			redirect('Login');
		}
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$regular_check = $this->input->get('regular_check');
		$building_code = $this->input->get('building_code');
		$push_start_date = $this->input->get('push_start_date');
		$push_end_date = $this->input->get('push_end_date');
		$village_id = $_SESSION['village_id'];
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		if(is_null($push_start_date)||empty($push_start_date))
		{	
			//消息的初始查询开始日期为上个月的今天
			$push_start_date = date("Y-m-d", strtotime("-1 month"))." 00:00";
		}
		if(is_null($push_end_date)||empty($push_end_date))
		{
			$push_end_date = date('Y-m-d',time())." 23:59";
		}
		$level = ' ';
		$this->load->model('Equipment_model');
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$buildings = $this->Equipment_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		//得到总条数
		$total = $this->Equipment_model->getEquipmentServiceTotal($village_id,$keyword,$effective_date,$push_start_date,$push_end_date,$equipment_type,$regular_check,$building_code,$level,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date']=$effective_date;
		$data['equipment_type']=$equipment_type;
		$data['regular_check'] = $regular_check;
		$data['building_code'] = $building_code;
		$data['push_start_date'] = $push_start_date;
		$data['push_end_date'] = $push_end_date;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='equipmentservice';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/equipment_service',$data);
	}

	public function getEquipmentService(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$regular_check = $this->input->get('regular_check');
		$building_code = $this->input->get('building_code');
		$push_start_date = $this->input->get('push_start_date');
		$push_end_date = $this->input->get('push_end_date');
		$page = $page?$page:'1';
		$village_id = $_SESSION['village_id'];
		$level = ' ';
		$this->load->model('Equipment_model');
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$buildings = $this->Equipment_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		// print_r($buildings);exit;
		//获得数据
		$res = $this->Equipment_model->getEquipmentService($village_id,$page,$keyword,$effective_date,$push_start_date,$push_end_date,$equipment_type,$regular_check,$building_code,$level,$this->user_per_page);
		echo $res;
	}
		
}
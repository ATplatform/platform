<?php
defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(E_ERROR);
date_default_timezone_set('Asia/ShangHai');

class Equipment extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		session_start();
		//打开重定向
		$this->load->helper('url');
		$this->load->database();
		$this->user_per_page=$this->config->item('user_per_page');
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

		if(is_null($page)||empty($page))
		{
			$page=1;
		}

		//得到总条数
		$this->load->model('Equipment_model');
		$total = $this->Equipment_model->getEquipmentListTotal($page,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$this->user_per_page);

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

		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData();
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/equipment_list',$data);
	}

	public function getEquipmentNameCode(){
		$this->load->model('Equipment_model');
		$res = $this->Equipment_model->getEquipmentNameCode();
		echo $res;
	}

	public function getEquipmentCode(){
		$this->load->model('Equipment_model');
		$res = $this->Equipment_model->getEquipmentCode();
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
		$equipment_type = $this->input->post('equipment_type');
		$building_code = $this->input->post('building_code');
		$function_name = $this->input->post('function_name');
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

		$this->load->model('Equipment_model');
		$res = $this->Equipment_model->insertEquipment($code,$effective_date,$effective_status,$name,$pcs,$equipment_type,$building_code,$function_name,$initial_no,$initial_model,$tech_spec,$supplier,$production_date,$parent_code,$regular_check,$regular_date,$position_code,$if_se,$annual_check,$annual_date);
		if($res==true){
			$data['message'] = '新增成功';
		}
		else {
			$data['message'] = '新增失败';
		}
		print_r(json_encode($data));
	}

	public function getEquipmentList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$regular_check = $this->input->get('regular_check');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';

		$this->load->model('Equipment_model');
		//获得数据
		$res = $this->Equipment_model->getEquipmentList($page,$keyword,$effective_date,$equipment_type,$regular_check,$building_code,$this->user_per_page);
		echo $res;	
	}

	public function updateEquipment(){
		$now = date('Y-m-d h:i:s',time());
		$code = $this->input->post('code');
		$name = $this->input->post('name');
		$pcs = $this->input->post('pcs');
		$equipment_type = $this->input->post('equipment_type');
		$building_code = $this->input->post('building_code');
		$function_name = $this->input->post('function_name');
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

		$this->load->model('Equipment_model');
		$res = $this->Equipment_model->updateEquipment($code,$name,$pcs,$equipment_type,$building_code,$function_name,$initial_no,$initial_model,$tech_spec,$supplier,$production_date,$parent_code,$regular_check,$regular_date,$position_code,$if_se,$annual_check,$annual_date);
		if($res==true){
			$data['message'] = '编辑成功';
		}
		else {
			$data['message'] = '编辑失败';
		}
		//得到总条数
		$this->load->model('Equipment_model');
		$total = $this->Equipment_model->getEquipmentListTotal($page,$search_keyword,$search_effective_date,$search_equipment_type,$search_regular_check,$search_building_code,$this->user_per_page);
		$data['total'] = $total;
		print_r(json_encode($data));
	}

	public function personequipmentlist(){
		if ( !isset($_SESSION['username']) ) {
		redirect('Login');
		}

		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$regular_check = $this->input->get('regular_check');
		$building_code = $this->input->get('building_code');

		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		//根据keyword查询人员\楼宇

		//得到总条数
		$this->load->model('Equipment_model');
		$total = $this->Equipment_model->getPersoneEquipmentListTotal($keyword,$effective_date,$equipment_type,$building_code,$this->user_per_page);

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

		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData();
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/personequipment_list',$data);
	}

	public function getEquipmentByName(){
		$name = $this->input->post('name');
		$this->load->model('Equipment_model');
		$res = $this->Equipment_model->getEquipmentByName($name);
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

		$person_code = "{" .$person_code."}";
		$building_code = "{" .$building_code."}";


		$this->load->model('Equipment_model');
		$lastEquipment = $this->Equipment_model->getLastPersonEquipment();
		$code = $lastEquipment['code'];
		if(!$code){
			$code = 1000001;
		}
		else {
			$code = $code + 1;
		}		
		$res = $this->Equipment_model->insertPersonEquipment($code,$equipment_code,$person_code,$building_code,$begin_date,$end_date,$remark);
		if($res==true){
			$data['message'] = '新增成功';
		}
		else {
			$data['message'] = '新增失败';
		}
		print_r(json_encode($data));

	}

	public function getPersoneEquipmentList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$equipment_type = $this->input->get('equipment_type');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';

		$this->load->model('Equipment_model');
		//获得数据
		$res = $this->Equipment_model->getPersoneEquipmentList($page,$keyword,$effective_date,$equipment_type,$building_code,$this->user_per_page);
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

		$person_code = "{" .$person_code."}";
		$building_code = "{" .$building_code."}";

		$this->load->model('Equipment_model');		
		$res = $this->Equipment_model->updatePersonEquipment($code,$person_code,$building_code,$begin_date,$end_date,$remark);
		if($res==true){
			$data['message'] = '编辑成功';
		}
		else {
			$data['message'] = '编辑失败';
		}
		//得到授权设备总数
		$total = $this->Equipment_model->getPersoneEquipmentListTotal($search_keyword,$search_effective_date,$search_equipment_type,$search_building_code,$this->user_per_page);
		$data['total'] = $total;

		print_r(json_encode($data));
	}
}
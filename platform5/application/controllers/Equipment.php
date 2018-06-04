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

}
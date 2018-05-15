<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class People extends CI_Controller{
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
		redirect('People/residentlist');
	}

	public function residentlist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}

		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		$this->load->model('People_model');
		$total=$this->People_model->getPeopleTotal($this->user_per_page);

		$data['nav'] = 'residentlist';
		$data['page'] = $page;
		$data['total']=$total;
		$data['keyword']='';
		$data['pagesize']=$this->user_per_page;
		
		$this->load->view('app/resident_list',$data);
	}

	public function getPeopleCode(){
		$this->load->model('People_model');
		$res = $this->People_model->getPeopleCode();
		echo $res;
	}

	//验证证件号码唯一性
	public function verifyIdcard(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$id_card = $this->input->post('id_card');
		$this->load->model('People_model');
		$res = $this->People_model->verifyIdcard($id_card);
		if(!empty($res)){
			echo "证件号码已存在";
		}
		else {
			echo '证件号码不存在';
		}
	}

	public function insertPeople(){
		$now = date('Y-m-d h:i:s',time());
		$code = $this->input->post('code');
		$last_name = $this->input->post('last_name');
		$first_name = $this->input->post('first_name');
		$id_type = $this->input->post('id_type');
		$id_number = $this->input->post('id_number');
		$nationality = $this->input->post('nationality');
		$gender = $this->input->post('gender');
		$birth_date = $this->input->post('birth_date');
		$if_disabled = $this->input->post('if_disabled');
		$bloodtype = $this->input->post('bloodtype');
		$ethnicity = $this->input->post('ethnicity');
		$tel_country = $this->input->post('tel_country');
		$mobile_number = $this->input->post('mobile_number');
		$oth_mob_no = $this->input->post('oth_mob_no');
		$remark = $this->input->post('remark');

		$this->load->model('People_model');
		$res = $this->People_model->insertPeople($code,$last_name,$first_name,$id_type,$id_number,$nationality,$gender,$birth_date,$if_disabled,$bloodtype,$ethnicity,$tel_country,$mobile_number,$oth_mob_no,$remark,$now);
		if($res==true){
			$data['message'] = '新增人员成功';
		}
		else {
			$data['message'] = '新增人员失败';
		}
		print_r(json_encode($data));

	}

	public function updatePeople(){
		$now = date('Y-m-d h:i:s',time());
		$code = $this->input->post('code');
		$last_name = $this->input->post('last_name');
		$first_name = $this->input->post('first_name');
		$id_type = $this->input->post('id_type');
		$id_number = $this->input->post('id_number');
		$nationality = $this->input->post('nationality');
		$gender = $this->input->post('gender');
		$birth_date = $this->input->post('birth_date');
		$if_disabled = $this->input->post('if_disabled');
		$bloodtype = $this->input->post('bloodtype');
		$ethnicity = $this->input->post('ethnicity');
		$tel_country = $this->input->post('tel_country');
		$mobile_number = $this->input->post('mobile_number');
		$oth_mob_no = $this->input->post('oth_mob_no');
		$remark = $this->input->post('remark');

		$this->load->model('People_model');
		$res = $this->People_model->updatePeople($code,$last_name,$first_name,$id_type,$id_number,$nationality,$gender,$birth_date,$if_disabled,$bloodtype,$ethnicity,$tel_country,$mobile_number,$oth_mob_no,$remark);
		if($res==true){
			$data['message'] = '编辑人员成功';
		}
		else {
			$data['message'] = '编辑人员失败';
		}
		print_r(json_encode($data));
	}

	public function getPeopleList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$page = $page?$page:'1';
		$this->load->model('People_model');
		$res = $this->People_model->getPeopleList($page,$this->user_per_page);
		echo $res;	
	}

	public function getPersonByName(){
		$name = $this->input->post('name');
		$this->load->model('People_model');
		$res = $this->People_model->getPersonByName($name);
		echo $res;	
	}

	public function insertPersonBuilding(){
		$now = date('Y-m-d H:i:s',time());
		$building_code = $this->input->post('building_code');
		$begin_date = $this->input->post('begin_date');
		$end_date = $this->input->post('end_date');
		$remark = $this->input->post('remark');
		$persons = $this->input->post('persons');
		
		$this->load->model('People_model');
		foreach($persons as $row){
			$res = $this->People_model->insertPersonBuilding($building_code,$begin_date,$end_date,$remark,$row['code'],$row['household_type'],$now);	
		}
		//最后判断是否全部写入成功
		if($res==true){
			$data['message'] = '新增住户关系成功';
		}
		else {
			$data['message'] = '新增住户关系失败';
		}
		print_r(json_encode($data));
	}

	public function getBuildingByPersonCode(){
		$now = date('Y-m-d H:i:s',time());
		$person_code = $this->input->post('person_code');
		$building_code = $this->input->post('building_code');
		$this->load->model('People_model');
		$res = array();
		//得到该住户的其它有效房产
		$buildings = $this->People_model->getBuildingByPersonCode($person_code,$building_code,$now);
		//根据房产编号,得到房子的名称
		if(!empty($buildings)){
			foreach($buildings as $key => $row){
				$res[$key] = $this->People_model->getBuildingNameByCode($row['building_code']);
			}
		}

		$data = array();
		if(!empty($res)){
			foreach ($res as $key => $v) {
				$data[$key] = $v['name'];
			}
		}
		print_r(json_encode($data));
	}

	public function getPersonByPersonCode(){
		$this->load->helper('common');
		$now = date('Y-m-d H:i:s',time());
		$person_code = $this->input->post('person_code');
		$building_code = $this->input->post('building_code');
		$this->load->model('People_model');
		$res = array();
		$personcodes = array();
		//先得到该住户所有有效的房产
		$buildings = $this->People_model->getAllBuildingByPersonCode($person_code,$building_code,$now);
		//根据房产编号,得到房子的其他住户的编号
		if(count($buildings)>0){
			$i = 0;
			foreach($buildings as $key => $row){
				$personCode = $this->People_model->getPersonCodeByBuildingCode($row['building_code'],$person_code);
				if(!empty($personCode)){
					foreach($personCode as $k2 =>$v2){
						$personcodes[$i] = $v2['person_code'];
					}
					$i++;
				}
			}
		}
		//去重
		array_unique($personcodes);
		//根据住户编号,得到住户的名字等信息
		foreach($personcodes as $key => $row){
			$res[$key]= $this->People_model->getPersonByCode($row);
		}
		print_r(json_encode($res));
	}

	public function updatePersonBuilding(){
		$building_code = $this->input->post('building_code');
		$person_code = $this->input->post('person_code');
		$begin_date = $this->input->post('begin_date');
		$end_date = $this->input->post('end_date');
		$this->load->model('People_model');
		$res = $this->People_model->updatePersonBuilding($building_code,$person_code,$begin_date,$end_date);
		if($res==true){
			$data['message'] = '编辑住户成功';
		}
		else {
			$data['message'] = '编辑住户失败';
		}
		print_r(json_encode($data));
	}

	public function managementlist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}

		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		// $this->load->model('Management_model');
		// $total=$this->Management_model->getPeopleTotal($this->user_per_page);

		$data['nav'] = 'managementlist';
		$data['page'] = $page;
		$data['total'] = 1;

		// $data['total']=$total;
		$data['keyword']='';
		$data['pagesize']=$this->user_per_page;
		
		$this->load->view('app/management_list',$data);
	}

}
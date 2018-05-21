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
		$effective_date = $this->input->get('effective_date');
		$household_type = $this->input->get('household_type');
		$person_type = $this->input->get('person_type');
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		$this->load->model('People_model');
		//根据person_type得到出生年月或者是否残疾
		if($person_type=='104'){
			$if_disabled = true;
			$birth_end = '';
			$birth_begin = '';
		}
		else{
			$if_disabled = '';
			switch ($person_type) {
				case '101':
					//表示老人,大于60岁
					$birth_end = $this->getBirth(60);
					$birth_begin = '';
					break;
				case '102':
					//表示儿童,1-14岁之间
					$birth_end = $this->getBirth(1);
					$birth_begin = $this->getBirth(14);
					break;
				case '103':
					//表示婴儿,小于1岁
					$birth_end = date("Y-m-d");
					$birth_begin = $this->getBirth(1);
					break;
				default:
					$birth_end = '';
					$birth_begin = '';
					break;
			}
			
		}
		//得到住户人员总数
		$total = $this->People_model->getResidentListTotal($if_disabled,$birth_begin,$birth_end,$household_type,$effective_date,$keyword,$this->user_per_page);

		$data['nav'] = 'residentlist';
		$data['page'] = $page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date'] = $effective_date;
		$data['household_type'] = $household_type;
		$data['person_type'] = $person_type;
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
		//带search的参数用于异步刷新页面时做分页和查询总条数
		$search_keyword = $this->input->post('search_keyword');
		$search_effective_date = $this->input->post('search_effective_date');
		$search_household_type = $this->input->post('search_household_type');
		$search_person_type = $this->input->post('search_person_type');

		$this->load->model('People_model');
		$res = $this->People_model->updatePeople($code,$last_name,$first_name,$id_type,$id_number,$nationality,$gender,$birth_date,$if_disabled,$bloodtype,$ethnicity,$tel_country,$mobile_number,$oth_mob_no,$remark);
		if($res==true){
			$data['message'] = '编辑人员成功';
		}
		else {
			$data['message'] = '编辑人员失败';
		}
		//得到物业人员的总数
		$managementlist_total = $this->People_model->getPeoplePositionListTotal($search_effective_date,$search_keyword,$this->user_per_page);
		$data['managementlist_total'] = $managementlist_total;

		//根据person_type得到出生年月或者是否残疾
		if($search_person_type=='104'){
			$if_disabled = true;
			$birth_end = '';
			$birth_begin = '';
		}
		else{
			$if_disabled = '';
			switch ($search_person_type) {
				case '101':
					//表示老人,大于60岁
					$birth_end = $this->getBirth(60);
					$birth_begin = '';
					break;
				case '102':
					//表示儿童,1-14岁之间
					$birth_end = $this->getBirth(1);
					$birth_begin = $this->getBirth(14);
					break;
				case '103':
					//表示婴儿,小于1岁
					$birth_end = date("Y-m-d");
					$birth_begin = $this->getBirth(1);
					break;
				default:
					$birth_end = '';
					$birth_begin = '';
					break;
			}
			
		}
		//得到住户人员总数
		$data['residentlist_total'] = $this->People_model->getResidentListTotal($if_disabled,$birth_begin,$birth_end,$search_household_type,$search_effective_date,$search_keyword,$this->user_per_page);
		//得到商户人员总数
		// $data['residentlist_total'] = "";
		print_r(json_encode($data));
	}

	public function getResidentList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$household_type = $this->input->get('household_type');
		$person_type = $this->input->get('person_type');
		$page = $page?$page:'1';
		$this->load->model('People_model');
		//根据person_type得到出生年月或者是否残疾
		if($person_type=='104'){
			$if_disabled = true;
			$birth_end = '';
			$birth_begin = '';
		}
		else{
			$if_disabled = '';
			switch ($person_type) {
				case '101':
					//表示老人,大于60岁
					$birth_end = $this->getBirth(60);
					$birth_begin = '';
					break;
				case '102':
					//表示儿童,1-14岁之间
					$birth_end = $this->getBirth(1);
					$birth_begin = $this->getBirth(14);
					break;
				case '103':
					//表示婴儿,小于1岁
					$birth_end = date("Y-m-d");
					$birth_begin = $this->getBirth(1);
					break;
				default:
					$birth_end = '';
					$birth_begin = '';
					break;
			}
			
		}
		//获得住户列表
		$res = $this->People_model->getResidentList($if_disabled,$birth_begin,$birth_end,$household_type,$effective_date,$keyword,$page,$this->user_per_page);
		echo $res;	
	}

	//根据年龄得到出生年月日,返回 年-月-日 的形式
	public function getBirth($age){
		$y = date('Y');
		$m = date('m');
		$d = date('d');
		$birth_year = $y - $age;
		$birth = $birth_year.'-'.$m.'-'.$d;
		return $birth; 
	}

	public function getPersonByName(){
		$name = $this->input->post('name');
		$name = trim($name);
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
		//带search的参数用于异步刷新页面时做分页和查询总条数
		$search_keyword = $this->input->post('search_keyword');
		$search_effective_date = $this->input->post('search_effective_date');
		$search_household_type = $this->input->post('search_household_type');
		$search_person_type = $this->input->post('search_person_type');

		$res = $this->People_model->updatePersonBuilding($building_code,$person_code,$begin_date,$end_date);
		if($res==true){
			$data['message'] = '编辑住户成功';
		}
		else {
			$data['message'] = '编辑住户失败';
		}
		//得到物业人员的总数
		$managementlist_total = $this->People_model->getPeoplePositionListTotal($search_effective_date,$search_keyword,$this->user_per_page);
		$data['managementlist_total'] = $managementlist_total;

		//根据person_type得到出生年月或者是否残疾
		if($search_person_type=='104'){
			$if_disabled = true;
			$birth_end = '';
			$birth_begin = '';
		}
		else{
			$if_disabled = '';
			switch ($search_person_type) {
				case '101':
					//表示老人,大于60岁
					$birth_end = $this->getBirth(60);
					$birth_begin = '';
					break;
				case '102':
					//表示儿童,1-14岁之间
					$birth_end = $this->getBirth(1);
					$birth_begin = $this->getBirth(14);
					break;
				case '103':
					//表示婴儿,小于1岁
					$birth_end = date("Y-m-d");
					$birth_begin = $this->getBirth(1);
					break;
				default:
					$birth_end = '';
					$birth_begin = '';
					break;
			}
			
		}
		//得到住户人员总数
		$data['residentlist_total'] = $this->People_model->getResidentListTotal($if_disabled,$birth_begin,$birth_end,$search_household_type,$search_effective_date,$search_keyword,$this->user_per_page);
		//得到商户人员总数
		// $data['residentlist_total'] = "";

		print_r(json_encode($data));
	}

	public function managementlist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}

		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		if(is_null($page)||empty($page))
		{
			$page=1;
		}

		$this->load->model('People_model');
		$total=$this->People_model->getPeoplePositionListTotal($effective_date,$keyword,$this->user_per_page);

		$data['nav'] = 'managementlist';
		$data['page'] = $page;
		$data['total'] = $total;
		$data['keyword'] = $keyword;
		$data['effective_date'] = $effective_date;
		$data['pagesize'] = $this->user_per_page;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData();
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/management_list',$data);
	}

	//获取所有有效的职位名称
	public function getPositionName(){
		$this->load->model('People_model');
		$res = $this->People_model->getPositionName();
		print_r(json_encode($res));
	}

	public function insertPersonPosition(){
		$person_code = $this->input->post('person_code');
		$position_code = $this->input->post('position_code');
		$begin_date = $this->input->post('begin_date');
		$end_date = $this->input->post('end_date');
		$employee_no = $this->input->post('employee_no');
		$hire_date = $this->input->post('hire_date');
		$remark = $this->input->post('remark');
		$territorys = $this->input->post('territorys');
		// print_r($territorys);exit;
		$this->load->model('People_model');
		foreach($territorys as $row){
			$res = $this->People_model->insertPersonPosition($position_code,$person_code,$begin_date,$end_date,$employee_no,$hire_date,$row['code'],$remark);	
		}
		//最后判断是否全部写入成功
		if($res==true){
			$data['message'] = '新增物业关系成功';
		}
		else {
			$data['message'] = '新增物业关系失败';
		}
		print_r(json_encode($data));
	}

	public function updatePersonPosition(){
		$person_code = $this->input->post('person_code');
		$hire_date = $this->input->post('hire_date');
		$begin_date = $this->input->post('begin_date');
		$employee_no = $this->input->post('employee_no');
		$end_date = $this->input->post('end_date');
		$remark = $this->input->post('remark');
		$territorys = $this->input->post('territorys');
		$position_code = $this->input->post('position_code');

		$this->load->model('People_model');
		//更新物业职位表,两种情况下新增记录:1 职位改变; 2 管理区域改变
		print_r($territorys);exit;

	}

	public function getPeoplePositionList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$keyword = trim($keyword);
		$effective_date = trim($effective_date);
		$page = $page?$page:'1';
		$this->load->model('People_model');
		$res = $this->People_model->getPeoplePositionList($page,$this->user_per_page,$keyword,$effective_date);
		echo $res;
	}

	public function getPersonPositionByCode(){
		$position_code = $this->input->post('parent_code');
		$this->load->model('People_model');
		$res = $this->People_model->getPersonPositionByCode($position_code);
		print_r(json_encode($res));
	}

	public function getPersonPosition(){
		$person_code = $this->input->post('person_code');
		$this->load->model('People_model');
		$res = $this->People_model->getPersonPosition($person_code);
		$result = array();
		$this->load->model('Building_model');
		//获得每个区域的名称
		foreach($res as $key => $row){
			$result[$key] = $this->Building_model->getBuildingByCode($row['territory']);
		}
		print_r(json_encode($result));
	}
}
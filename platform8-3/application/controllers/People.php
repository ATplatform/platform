<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ERROR);
date_default_timezone_set('Asia/ShangHai');
class People extends CI_Controller{
	public function __construct(){
		parent::__construct();
		session_start();
		//打开重定向
		$this->load->helper('url');
		$this->load->database();
		$this->user_per_page=$this->config->item('user_per_page');
		$this->at_url=$this->config->item('at_url');
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
		$village_id = $_SESSION['village_id'];
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$household_type = $this->input->get('household_type');
		$person_type = $this->input->get('person_type');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
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
		$level = '';
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$this->load->model('People_model');
			$buildings = $this->People_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		//得到住户人员总数
		$total = $this->People_model->getResidentListTotal($building_code,$level,$if_disabled,$birth_begin,$birth_end,$household_type,$effective_date,$keyword,$this->user_per_page,$village_id);

		$data['nav'] = 'residentlist';
		$data['page'] = $page>$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date'] = $effective_date;
		$data['household_type'] = $household_type;
		$data['person_type'] = $person_type;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['username']=$_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/resident_list',$data);
	}

	public function getPeopleCode(){
		$village_id = $_SESSION['village_id'];
		$this->load->model('People_model');
		$res = $this->People_model->getPeopleCode($village_id);
		if(empty($res)){
			$res = 100000;
		}
		echo $res;
	}

	//验证证件号码唯一性
	public function verifyIdcard(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$village_id = $_SESSION['village_id'];
		$id_card = $this->input->post('id_card');
		$this->load->model('People_model');
		$res = $this->People_model->verifyIdcard($id_card,$village_id);
		if(!empty($res)){
			echo "证件号码已存在";
		}
		else {
			echo '证件号码不存在';
		}
	}

	//验证身份证号是否跟别人的重复
	public function verifyPersonIdCard(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$village_id = $_SESSION['village_id'];
		$id_number = $this->input->post('id_number');
		$code = $this->input->post('code');
		$this->load->model('People_model');
		$res = $this->People_model->verifyPersonIdCard($code,$id_number,$village_id);
		if(!empty($res)){
			echo "证件号码与别人重复";
		}
		else {
			echo '证件号码没有与别人重复';
		}
	}

	//验证手机号是否跟别人的重复
	public function verifyPersonMobile(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$village_id = $_SESSION['village_id'];
		$code = $this->input->post('code');
		$mobile_number = $this->input->post('mobile_number');
		$this->load->model('People_model');
		$res = $this->People_model->verifyPersonMobile($code,$mobile_number,$village_id);
		if(!empty($res)){
			echo "手机号码与别人重复";
		}
		else {
			echo '手机号码没有与别人重复';
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
		$village_id = $_SESSION['village_id'];
		$this->load->model('People_model');
		$res = $this->People_model->insertPeople($code,$last_name,$first_name,$id_type,$id_number,$nationality,$gender,$birth_date,$if_disabled,$bloodtype,$ethnicity,$tel_country,$mobile_number,$oth_mob_no,$remark,$now,$village_id);
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
		$search_biz_type = $this->input->post('search_biz_type');
		$search_building_code = $this->input->post('search_building_code');
		$village_id = $_SESSION['village_id'];
		$this->load->model('People_model');
		$village_id = $_SESSION['village_id'];
		$res = $this->People_model->updatePeople($code,$last_name,$first_name,$id_type,$id_number,$nationality,$gender,$birth_date,$if_disabled,$bloodtype,$ethnicity,$tel_country,$mobile_number,$oth_mob_no,$remark,$village_id);
		if($res==true){
			$data['message'] = '编辑人员成功';
		}
		else {
			$data['message'] = '编辑人员失败';
		}
		//得到物业人员的总数
		$managementlist_total = $this->People_model->getPeoplePositionListTotal($search_effective_date,$search_keyword,$this->user_per_page,$village_id);
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
		$level = '';
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($search_building_code)){
			$this->load->model('People_model');
			$buildings = $this->People_model->getBuildingByCode($search_building_code,$village_id);
			$level = $buildings['level'];
		}
		//得到住户人员总数
		$data['residentlist_total'] = $this->People_model->getResidentListTotal($search_building_code,$level,$if_disabled,$birth_begin,$birth_end,$search_household_type,$search_effective_date,$search_keyword,$this->user_per_page,$village_id);
		//得到商户人员总数
		$data['businesslist_total'] = $this->People_model->getBusinessListTotal($village_id,$search_effective_date,$search_biz_type,$search_building_code,$level,$search_keyword,$this->user_per_page);
		print_r(json_encode($data));
	}

	public function getResidentList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$household_type = $this->input->get('household_type');
		$person_type = $this->input->get('person_type');
		$building_code = $this->input->get('building_code');
		$level = ' ';
		$page = $page?$page:'1';
		$village_id = $_SESSION['village_id'];
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
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$this->load->model('People_model');
			$buildings = $this->People_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		//获得住户列表
		$res = $this->People_model->getResidentList($building_code,$level,$if_disabled,$birth_begin,$birth_end,$household_type,$effective_date,$keyword,$page,$this->user_per_page,$village_id);
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
		$village_id = $_SESSION['village_id'];
		$name = $this->input->post('name');
		$name = trim($name);
		$this->load->model('People_model');
		$res = $this->People_model->getPersonByName($name,$village_id);
		echo $res;	
	}

	public function insertPersonBuilding(){
		$now = date('Y-m-d H:i:s',time());
		$building_code = $this->input->post('building_code');
		$begin_date = $this->input->post('begin_date');
		$end_date = $this->input->post('end_date');
		$remark = $this->input->post('remark');
		$persons = $this->input->post('persons');
		$village_id = $_SESSION['village_id'];
		$this->load->model('People_model');
		foreach($persons as $row){
			$res = $this->People_model->insertPersonBuilding($village_id,$building_code,$begin_date,$end_date,$remark,$row['code'],$row['household_type'],$now);	
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
		$village_id = $_SESSION['village_id'];
		$this->load->model('People_model');
		$res = array();
		//得到该住户的其它有效房产
		$buildings = $this->People_model->getBuildingByPersonCode($village_id,$person_code,$building_code,$now);
		//根据房产编号,得到楼宇全部信息
		if(!empty($buildings)){
			foreach($buildings as $key => $row){
				$res[$key] = $this->People_model->getBuildingNameByCode($village_id,$row['building_code']);
			}
		}

		$data = array();
		//根据楼宇的信息,拼接出楼宇的全称
		if(!empty($res)){
			foreach ($res as $key => $v) {
				$data[$key] = $this->People_model->getHouseholdInfo($v);
			}
		}
		print_r(json_encode($data));
	}

	public function getPersonByPersonCode(){
		$this->load->helper('common');
		$now = date('Y-m-d H:i:s',time());
		$person_code = $this->input->post('person_code');
		$building_code = $this->input->post('building_code');
		$village_id = $_SESSION['village_id'];
		$this->load->model('People_model');
		$res = array();
		$personcodes = array();
		//先得到该住户所有有效的房产
		$buildings = $this->People_model->getAllBuildingByPersonCode($village_id,$person_code,$building_code,$now);
		//根据房产编号,得到房子的其他住户的编号
		if(count($buildings)>0){
			$i = 0;
			foreach($buildings as $key => $row){
				$personCode = $this->People_model->getPersonCodeByBuildingCode($village_id,$row['building_code'],$person_code);
				if(!empty($personCode)){
					foreach($personCode as $k2 =>$v2){
						$personcodes[$i] = $v2['person_code'];
						$i++;
					}
				}
			}
		}
		// exit;
		//去重
		$personcodes = array_unique($personcodes);
		$j = 0;
		//去掉以前的键名
		foreach($personcodes as $key => $row){
			if(!empty($row)){
				$pcodes[$j] = $row;
				$j++;
			}
		}
		//根据住户编号,得到住户的名字等信息
		$k = 0;
		foreach($pcodes as $key => $row){
			$p = $this->People_model->getPersonByCode($row,$village_id);
			if(!empty($p)){
				$res[$k]= $p;
				$k++;
			}
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
		$search_building_code = $this->input->post('search_building_code');
		$village_id = $_SESSION['village_id'];
		$res = $this->People_model->updatePersonBuilding($building_code,$person_code,$begin_date,$end_date);
		if($res==true){
			$data['message'] = '编辑住户成功';
		}
		else {
			$data['message'] = '编辑住户失败';
		}

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
		$level = '';
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($search_building_code)){
			$this->load->model('People_model');
			$buildings = $this->People_model->getBuildingByCode($search_building_code,$village_id);
			$level = $buildings['level'];
		}
		//得到住户人员总数
		$residentlist_total = $this->People_model->getResidentListTotal($search_building_code,$level,$if_disabled,$birth_begin,$birth_end,$search_household_type,$search_effective_date,$search_keyword,$this->user_per_page,$village_id);
		$data['residentlist_total'] = $residentlist_total;

		print_r(json_encode($data));
	}

	public function managementlist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$village_id = $_SESSION['village_id'];
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		$village_id = $_SESSION['village_id'];
		$this->load->model('People_model');
		$total=$this->People_model->getPeoplePositionListTotal($effective_date,$keyword,$this->user_per_page,$village_id);

		$data['nav'] = 'managementlist';
		$data['page'] = $page>$total?$total:$page;
		$data['total'] = $total;
		$data['keyword'] = $keyword;
		$data['effective_date'] = $effective_date;
		$data['pagesize'] = $this->user_per_page;
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		// echo $data['page'];
		// echo $data['total'];
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/management_list',$data);
	}

	//获取所有有效的职位名称
	public function getPositionName(){
		$village_id = $_SESSION['village_id'];
		$this->load->model('People_model');
		$res = $this->People_model->getPositionName($village_id);
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
		$territory = $this->input->post('territory');
		$village_id = $_SESSION['village_id'];
		//存入时要写成数组形式
		$territory = '{'.$territory.'}';
		$this->load->model('People_model');
		$res = $this->People_model->insertPersonPosition($position_code,$village_id,$person_code,$begin_date,$end_date,$employee_no,$hire_date,$territory,$remark);	
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

		$code = $this->input->post('code');
		$end_date = $this->input->post('end_date');
		$remark = $this->input->post('remark');
		$position_code = $this->input->post('position_code');

		$search_keyword = $this->input->post('search_keyword');
		$search_effective_date = $this->input->post('search_effective_date');
		$search_biz_type = $this->input->post('search_biz_type');
		$search_building_code = $this->input->post('search_building_code');
		$village_id = $_SESSION['village_id'];
		//更新物业职位表
		$this->load->model('People_model');

		$res = $this->People_model->updatePersonPosition($code,$end_date,$remark,$position_code,$village_id);
		if($res==true){
			$data['message'] = '编辑物业关系成功';
		}
		else {
			$data['message'] = '编辑物业关系失败';
		}

		$level = '';
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($search_building_code)){
			$this->load->model('People_model');
			$buildings = $this->People_model->getBuildingByCode($search_building_code,$village_id);
			$level = $buildings['level'];
		}
		//得到物业人员总数
		$managementlist_total=$this->People_model->getPeoplePositionListTotal($search_effective_date,$search_keyword,$this->user_per_page,$village_id);
		$data['managementlist_total'] = $managementlist_total;
		print_r(json_encode($data));


	}

	public function getPeoplePositionList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$keyword = trim($keyword);
		$effective_date = trim($effective_date);
		$page = $page?$page:'1';
		$this->load->model('People_model');
		$village_id = $_SESSION['village_id'];
		$res = $this->People_model->getPeoplePositionList($page,$this->user_per_page,$keyword,$effective_date,$village_id);
		echo $res;
	}

	public function getPersonPositionByCode(){
		$village_id = $_SESSION['village_id'];
		$position_code = $this->input->post('parent_code');
		$this->load->model('People_model');
		$res = $this->People_model->getPersonPositionByCode($position_code,$village_id);
		print_r(json_encode($res));
	}

	public function getPersonPosition(){
		$village_id = $_SESSION['village_id'];
		$person_code = $this->input->post('person_code');
		$this->load->model('People_model');
		$res = $this->People_model->getPersonPosition($person_code);
		$result = array();
		//得到管理区域,形式为{100001,100002}
		$territory = $res[0]['territory'];
		//截取第一个字符
		$territory = substr($territory,1);
		//截掉最后一个字符,变成字符串 100001,100002
		$territory = substr($territory,0,strlen($territory)-1);
		//将管理区域字符串转变成数组
		$territorys = explode(",", $territory); 
		//获得每个区域的名称
		foreach($territorys as $key => $row){
			$result[$key] = $this->People_model->getBuildingByCode($row,$village_id);
		}
		print_r(json_encode($result));
	}

	public function businesslist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$village_id = $_SESSION['village_id'];
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$biz_type = $this->input->get('biz_type');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		$level = '';
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$this->load->model('People_model');
			$buildings = $this->People_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		} 
		$this->load->model('People_model');
		$total=$this->People_model->getBusinessListTotal($village_id,$effective_date,$biz_type,$building_code,$level,$keyword,$this->user_per_page);
		$data['nav'] = 'businesslist';
		$data['page'] = $page>$total?$total:$page;
		$data['total'] = $total;
		$data['keyword'] = $keyword;
		$data['effective_date'] = $effective_date;
		$data['biz_type'] = $biz_type;
		$data['building_code'] = $building_code;
		$data['pagesize'] = $this->user_per_page;
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/business_list',$data);
	}

	public function insertPersonBiz(){
		$now = date('Y-m-d H:i:s',time());
		$building_code = $this->input->post('building_code');
		$begin_date = $this->input->post('begin_date');
		$end_date = $this->input->post('end_date');
		$remark = $this->input->post('remark');
		$biz_info = $this->input->post('biz_info');
		$persons = $this->input->post('persons');
		$village_id = $_SESSION['village_id'];
		$this->load->model('People_model');
		foreach($persons as $row){
			$res = $this->People_model->insertPersonBiz($village_id,$building_code,$begin_date,$end_date,$biz_info,$remark,$row['code'],$row['biz_Type'],$now);	
		}
		//最后判断是否全部写入成功
		if($res==true){
			$data['message'] = '新增商户关系成功';
		}
		else {
			$data['message'] = '新增商户关系失败';
		}
		print_r(json_encode($data));
	}

	public function getBusinessList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$biz_type = $this->input->get('biz_type');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';
		$this->load->model('People_model');
		$village_id = $_SESSION['village_id'];
		$level = '';
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$this->load->model('People_model');
			$buildings = $this->People_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		//获得商户列表
		$res = $this->People_model->getBusinessList($village_id,$effective_date,$building_code,$level,$biz_type,$keyword,$page,$this->user_per_page);
		echo $res;	
	}

	public function updatePersonBiz(){
		$biz_code = $this->input->post('biz_code');
		$end_date = $this->input->post('end_date');
		$remark = $this->input->post('remark');
		$biz_info = $this->input->post('biz_info');

		$search_keyword = $this->input->post('search_keyword');
		$search_effective_date = $this->input->post('search_effective_date');
		$search_biz_type = $this->input->post('search_biz_type');
		$search_building_code = $this->input->post('search_building_code');
		$village_id = $_SESSION['village_id'];
		//先更新这一条记录
		$this->load->model('People_model');

		$res = $this->People_model->updatePersonBiz($village_id,$biz_code,$end_date,$remark,$biz_info);
		if($res==true){
			$data['message'] = '编辑商户关系成功';
		}
		else {
			$data['message'] = '编辑商户关系失败';
		}

		$level = '';
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($search_building_code)){
			$this->load->model('People_model');
			$buildings = $this->People_model->getBuildingByCode($search_building_code,$village_id);
			$level = $buildings['level'];
		}
		//得到商户人员总数
		$data['businesslist_total'] = $this->People_model->getBusinessListTotal($village_id,$search_effective_date,$search_biz_type,$search_building_code,$level,$search_keyword,$this->user_per_page);
		print_r(json_encode($data));
	}

	public function getBizByPersonCode(){
		$now = date('Y-m-d H:i:s',time());
		$person_code = $this->input->post('person_code');
		$building_code = $this->input->post('building_code');
		$this->load->model('People_model');
		$res = array();
		//得到该人员的其它有效商铺
		$buildings = $this->People_model->getBizByPersonCode($person_code,$building_code,$now);
		//根据房产编号,得到房子的名称
		if(!empty($buildings)){
			foreach($buildings as $key => $row){
				$res[$key] = $this->People_model->getBuildingNameByCode($village_id,$row['building_code']);
			}
		}

		$data = array();
		//最终得到楼宇的全称
		if(!empty($res)){
			foreach ($res as $key => $v) {
				$household = $this->People_model->getHouseholdInfo($v);
				$data[$key] = $household;
			}
		}
		print_r(json_encode($data));
	}

	public function getBizPersonByPersonCode(){
		$this->load->helper('common');
		$now = date('Y-m-d H:i:s',time());
		$person_code = $this->input->post('person_code');
		$building_code = $this->input->post('building_code');
		$village_id = $_SESSION['village_id'];
		$this->load->model('People_model');
		$res = array();
		$personcodes = array();
		//先得到该住户所有有效的商铺
		$buildings = $this->People_model->getAllBizByPersonCode($person_code,$building_code,$now);
		//根据房产编号,得到房子的其他人员的编号
		if(count($buildings)>0){
			$i = 0;
			foreach($buildings as $key => $row){
				$personCode = $this->People_model->getPersonCodeByBizCode($row['building_code'],$person_code);
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
		//根据人员编号,得到人员的名字等信息
		foreach($personcodes as $key => $row){
			$res[$key]= $this->People_model->getPersonByCode($row,$village_id);
		}
		print_r(json_encode($res));
	}

	public function getPersonTerritory(){
		$village_id = $_SESSION['village_id'];
		$territory = $this->input->post('territory');
		$this->load->model('Building_model');
		$res = array();
		foreach($territory as $key => $row){
			$res[$key]['buildings'] = $this->Building_model->getBuilding($row,$village_id);
			$res[$key]["household"]=$this->Building_model->getHouseholdInfo($res[$key]['buildings']);
		}
		print_r(json_encode($res));
	}

	public function visitorlist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$equipment_type = $this->input->get('equipment_type');
		$building_code = $this->input->get('building_code');
		$push_start_date = $this->input->get('push_start_date');
		$push_end_date = $this->input->get('push_end_date');
		$village_id = $_SESSION['village_id'];
		$now = date("Y-m-d",time());
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		if(is_null($push_start_date)||empty($push_start_date))
		{	
			//初始查询开始日期为上个月的今天
			$push_start_date = date("Y-m-d", strtotime("-1 month"))." 00:00";
		}
		if(is_null($push_end_date)||empty($push_end_date))
		{
			$push_end_date = date('Y-m-d',time())." 23:59";
		}
		$level = "";
		$this->load->model('People_model');
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$buildings = $this->People_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		//得到总条数
		$total = $this->People_model->getVisitorListTotal($village_id,$level,$push_start_date,$push_end_date,$equipment_type,$building_code,$keyword,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['push_start_date']=$push_start_date;
		$data['push_end_date']=$push_end_date;
		$data['equipment_type']=$equipment_type;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='visitorlist';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/visitor_list',$data);
	}

	public function getVisitorList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$equipment_type = $this->input->get('equipment_type');
		$building_code = $this->input->get('building_code');
		$push_start_date = $this->input->get('push_start_date');
		$push_end_date = $this->input->get('push_end_date');
		$page = $page?$page:'1';
		$now=date('Y-m-d',time());
		$village_id = $_SESSION['village_id'];
		$level = "";
		$this->load->model('People_model');
		//先根据buildingcode查出当前搜索的楼栋的层级信息
		if(!empty($building_code)){
			$buildings = $this->People_model->getBuildingByCode($building_code,$village_id);
			$level = $buildings['level'];
		}
		$res = $this->People_model->getVisitorList($village_id,$level,$push_start_date,$push_end_date,$equipment_type,$building_code,$keyword,$page,$this->user_per_page);
		echo $res;
	}

	public function invalidPersonBuilding(){
		$person_code=$this->input->post('person_code');
		$end_date=$this->input->post('end_date');
		$this->load->model('People_model');
		$village_id = $_SESSION['village_id'];
		$haslimit = false;
		$message = "该人员已经在此日期前已经";

		$equip = $this->People_model->getPersonEquipment($person_code,$village_id,$end_date);
		if(!empty($equip)){
			$message .= "有被授权的设备/";
			$haslimit = true;
		}

		$equip = $this->People_model->getPersonCard($person_code,$village_id,$end_date);
		if(!empty($equip)){
			$message .= "有绑定的一卡通/";
			$haslimit = true;
		}

		$material = $this->People_model->getPersonMaterial($person_code,$village_id,$end_date);
		if(!empty($material)){
			$message .= "有借用的物资/";
			$haslimit = true;
		}

		if($haslimit==true){
			$message = substr($message, 0, -1);
			$message .= ',必须完成解绑才能失效';
		}
		else{
			$message = "可以修改结束日期";

		}
		$res['haslimit'] = $haslimit;
		$res['message'] = $message;
		print_r(json_encode($res));

	}

}
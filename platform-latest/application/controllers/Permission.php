<?php
date_default_timezone_set('Asia/ShangHai');

class Permission extends CI_Controller{
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
		$this->load->view('app/access_card');
	}

	public function accesscard(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$person_type = $this->input->get('person_type');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		//得到总条数
		$this->load->model('Permission_model');
		$total = $this->Permission_model->getAccessCardListTotal($village_id,$effective_date,$person_type,$building_code,$keyword,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date']=$effective_date;
		$data['person_type']=$person_type;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='accesscard';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/access_card',$data);
	}

	public function getAccessCardList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$person_type = $this->input->get('person_type');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';
		$village_id = $_SESSION['village_id'];
		$this->load->model('Permission_model');
		$res = $this->Permission_model->getAccessCardList($village_id,$effective_date,$person_type,$building_code,$keyword,$page,$this->user_per_page);
		echo $res;
	}	

	public function getLastAccessCardCode(){
		$village_id = $_SESSION['village_id'];
		$this->load->model('Permission_model');
		$res = $this->Permission_model->getLastAccessCardCode($village_id);
		if(empty($res)){
			$res = 100001;
		}
		echo $res; 
	}

	public function getPersonRole(){
		$code = $this->input->post('code');
		$village_id = $_SESSION['village_id'];
		$this->load->model('Permission_model');
		$res['management'] = array();
		$territory = $this->Permission_model->getPersonPositionTerritory($code,$village_id);
		if(!empty($territory)){
			//去掉前后的大括号,并转换成数组形式
			$territory = substr($territory,0,strlen($territory)-1);
			$territory = substr($territory,1);
			$territory = explode(',',$territory);
			$this->load->model('Building_model');
			$res = array();
			foreach($territory as $key => $row){
				$buildings = $this->Building_model->getBuilding($row,$village_id);
				$res['management'][$key]['building_code'] = $buildings['code'];
				$res['management'][$key]["building_name"] = $this->Building_model->getHouseholdInfo($buildings);
			}
		}
		$res['resident'] = $this->Permission_model->getPersonBuilding($code,$village_id);
		$res['business'] = $this->Permission_model->getPersonBiz($code,$village_id);
		print_r(json_encode($res));
	}

	public function insertAccessCard(){
		$village_id = $_SESSION['village_id'];
		$code = $this->input->post('code');
		$card_no = $this->input->post('card_no');
		$person_code = $this->input->post('person_code');
		$person_type = $this->input->post('person_type');
		$building_code = $this->input->post('building_code');
		$begin_date = $this->input->post('begin_date');
		$end_date = $this->input->post('end_date');

		$building_code = "{".$building_code."}";
		$this->load->model('Permission_model');
		$res = $this->Permission_model->insertAccessCard($village_id,$code,$card_no,$person_code,$person_type,$building_code,$begin_date,$end_date);	
		//最后判断是否全部写入成功
		if($res==true){
			$data['message'] = '一卡通授权成功';
		}
		else {
			$data['message'] = '一卡通授权失败';
		}
		print_r(json_encode($data));

	}

	public function getAccessCardByNo(){
		$village_id = $_SESSION['village_id'];
		$card_no = $this->input->post('card_no');
		$this->load->model('Permission_model');
		$res = $this->Permission_model->getAccessCardByNo($village_id,$card_no);
		print_r(json_encode($res));
	}

	public function updateAccessCard(){
		$village_id = $_SESSION['village_id'];
		$code = $this->input->post('code');
		$end_date = $this->input->post('end_date');
		$search_keyword = $this->input->post('search_keyword');
		$search_effective_date = $this->input->post('search_effective_date');
		$search_person_type = $this->input->post('search_person_type');
		$search_building_code = $this->input->post('search_building_code');

		$this->load->model('Permission_model');
		$res = $this->Permission_model->updateAccessCard($village_id,$code,$end_date);	
		//最后判断是否全部写入成功
		if($res==true){
			$data['message'] = '编辑成功';
		}
		else {
			$data['message'] = '编辑失败';
		}
		//得到总条数
		$data['total'] = $this->Permission_model->getAccessCardListTotal($village_id,$search_effective_date,$search_person_type,$search_building_code,$search_keyword,$this->user_per_page);

		print_r(json_encode($data));

	}

	public function permissionfacelist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$person_type = $this->input->get('person_type');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		//得到总条数
		$this->load->model('Permission_model');
		$total = $this->Permission_model->getAccessCardListTotal($village_id,$effective_date,$person_type,$building_code,$keyword,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date']=$effective_date;
		$data['person_type']=$person_type;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='permissionfacelist';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/permissionface_list',$data);
	}


	public function applyfacelist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$person_type = $this->input->get('person_type');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		//得到总条数
		$this->load->model('Permission_model');
		$total = $this->Permission_model->getAccessCardListTotal($village_id,$effective_date,$person_type,$building_code,$keyword,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date']=$effective_date;
		$data['person_type']=$person_type;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='permissionfacelist';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/applyface_list',$data);
	}

	public function refusefacelist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$person_type = $this->input->get('person_type');
		$building_code = $this->input->get('building_code');
		$village_id = $_SESSION['village_id'];
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		//得到总条数
		$this->load->model('Permission_model');
		$total = $this->Permission_model->getAccessCardListTotal($village_id,$effective_date,$person_type,$building_code,$keyword,$this->user_per_page);

		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['effective_date']=$effective_date;
		$data['person_type']=$person_type;
		$data['building_code'] = $building_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='permissionfacelist';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/refuseface_list',$data);
	}

	public function getApplyFaceList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$person_type = $this->input->get('person_type');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';
		$village_id = $_SESSION['village_id'];
		$this->load->model('Permission_model');
		$res = $this->Permission_model->getApplyFaceList($village_id,$effective_date,$person_type,$building_code,$keyword,$page,$this->user_per_page);
		echo $res;
	}

	public function getAccessFaceList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$effective_date = $this->input->get('effective_date');
		$person_type = $this->input->get('person_type');
		$building_code = $this->input->get('building_code');
		$page = $page?$page:'1';
		$village_id = $_SESSION['village_id'];
		$this->load->model('Permission_model');
		$res = $this->Permission_model->getAccessFaceList($village_id,$effective_date,$person_type,$building_code,$keyword,$page,$this->user_per_page);
		echo $res;
	}

	public function insertAccessFace(){
		$face_apply_code = $this->input->post('face_apply_code');
		$apply_person = $this->input->post('apply_person');
		$person_code = $this->input->post('person_code');
		$person_type = $this->input->post('person_type');
		$begin_date = $this->input->post('begin_date');
		$end_date = $this->input->post('end_date');
		$building_code = $this->input->post('building_code');
		$source_type = $this->input->post('source_type');
		$pic = $this->input->post('pic');
		$subject = $this->input->post('subject');
		$pos = $this->input->post('pos');
		$feat = $this->input->post('feat');
		$img_url = $this->input->post('img_url');
		$village_id = $_SESSION['village_id'];

		//先查出最新的code
		$this->load->model('Permission_model');
		$code = $this->Permission_model->getLastAccessFaceidCode($village_id);

		$res = $this->Permission_model->insertAccessFace($village_id,$code,$face_apply_code,$apply_person,$person_code,$person_type,$building_code,$begin_date,$end_date,$source_type,$pic,$subject,$pos,$feat,$img_url);	
		//最后判断是否全部写入成功
		if($res==true){
			$data['message'] = '编辑成功';
			//通过成功后更改状态
			$this->Permission_model->refuseApplyFace($village_id,$face_apply_code,"",103);
		}
		else {
			$data['message'] = '编辑失败';
		}
		//得到总条数
		// $data['total'] = $this->Permission_model->getAccessCardListTotal($village_id,$search_effective_date,$search_person_type,$search_building_code,$search_keyword,$this->user_per_page);
		print_r(json_encode($data));
	}

	public function updateAccessFace(){
		$code = $this->input->post('code');
		$building_code = $this->input->post('building_code');

		$village_id = $_SESSION['village_id'];
		$building_code = "{".$building_code."}";
		$this->load->model('Permission_model');
		$res = $this->Permission_model->updateAccessFace($village_id,$code,$building_code);	
		//最后判断是否全部写入成功
		if($res==true){
			$data['message'] = '编辑成功';
		}
		else {
			$data['message'] = '编辑失败';
		}
		//得到总条数
		// $data['total'] = $this->Permission_model->getAccessCardListTotal($village_id,$search_effective_date,$search_person_type,$search_building_code,$search_keyword,$this->user_per_page);
		print_r(json_encode($data));
	}

	public function refuseApplyFace(){
		$code = $this->input->post('code');
		$reason = $this->input->post('reason');

		$village_id = $_SESSION['village_id'];
		$this->load->model('Permission_model');
		$res = $this->Permission_model->refuseApplyFace($village_id,$code,$reason,102);	
		//最后判断是否全部写入成功
		if($res==true){
			$data['message'] = '编辑成功';
		}
		else {
			$data['message'] = '编辑失败';
		}
		//得到总条数
		// $data['total'] = $this->Permission_model->getAccessCardListTotal($village_id,$search_effective_date,$search_person_type,$search_building_code,$search_keyword,$this->user_per_page);

		print_r(json_encode($data));
	}

	public function getFaceUrl(){
		$person_code=$this->input->post('person_code');
		$pic=$this->input->post('pic');

		$img = base64_decode($pic);
		$temp_path = "upload/faceImg/";
		if (!file_exists($temp_path))
		{
		    mkdir($temp_path, 0777, true);
		}
		$img_name = "upload/faceImg/".$person_code.'.jpg';
		//有图片的情况下,先删除原来的图片 
		if(file_exists($img_name)){
		    unlink($img_name);
		}
		$a = file_put_contents($img_name, $img);//生成图片，返回的是字节数
		$result = array();
		if($a)
		{
			$result['result'] = "生成图片成功";
			$result['img_url'] = $img_name;
		}
		else {
			$result['result'] =  "生成图片失败";
			$result['img_url'] = "";
		}
		print_r(json_encode($result));
	}

}
?>
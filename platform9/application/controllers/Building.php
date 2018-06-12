<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
		$this->load->view('app/buiding_tree',$data);
	}

	public function getBuildingTreeData(){
		$this->load->model('Building_model');
		$result = $this->Building_model->getBuildingTreeData();
		echo $result;
	}

	public function buildinglist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}

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
		if(!empty($parent_code)){
			//根据code查出当前的building_level
			$buidling = $this->Building_model->getBuilding($parent_code);
			$level = $buidling['level'];
		}
		
		$total=$this->Building_model->getBuildingTotal($level,$keyword,$id,$parent_code,$this->user_per_page);
		//树形菜单
		$treeNav_data = $this->Building_model->getBuildingTreeData();
		$data['treeNav_data']=$treeNav_data;
		
		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['id']=$id;
		$data['parent_code']=$parent_code;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='buildinglist';
		$data['username']=$_SESSION['username'];
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
		if(!empty($parent_code)){
			$buidling = $this->Building_model->getBuilding($parent_code);
			$level = $buidling['level'];
		}
		$data = $this->Building_model->getBuildingsList($level,$keyword,$id,$parent_code,$page,$this->user_per_page);
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
		//查到父节点的level_type,在此基础上加1,
		// $parent_building = $this->Building_model->getBuildingByCode($parent_code);
		// $parent_level_type =$parent_building['level_type'];
		// $level_type = $parent_level_type + 1;
		$res = $this->Building_model->insertBuilding($code,$effective_date,$effective_status,$name,$level,$rank,$parent_code,$remark,$now);
		if($res==true){
			$data['message'] = '新增楼宇成功';
			//新增成功后,重新生成临时表
			$this->load->model('TmpBuilding_model');
			$this->TmpBuilding_model->getTmpBuilding();
		}
		else {
			$data['message'] = '新增楼宇失败';
		}
		// $total=$this->Building_model->getBuildingTotal($keyword,$this->user_per_page);
		// $data['total'] = $total;
		print_r(json_encode($data));
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

		//带search的参数用于异步刷新页面时做分页和查询总条数
		$keyword = $this->input->post('keyword');
		$search_parent_code = $this->input->post('search_parent_code');
		$search_id = $this->input->post('search_id');
		$effective_date = $this->input->post('effective_date');
		$effective_status = $this->input->post('effective_status');
		$this->load->model('Building_model');
		//先查到这条信息
		$oldBuilding = $this->Building_model->getBuildingById($id);
		//查到父节点的level_type,在此基础上加1,
		// $parent_building = $this->Building_model->getBuildingByCode($parent_code);
		// $parent_level_type =$parent_building['level_type'];
		// $level_type = $parent_level_type + 1;
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
			$buidling = $this->Building_model->getBuilding($search_parent_code);
			$level = $buidling['level'];
		}
		$total=$this->Building_model->getBuildingTotal($level,$keyword,$search_id,$search_parent_code,$this->user_per_page);
		$data['total'] = $total;
		print_r(json_encode($data));
	}

	public function updateBuildingName(){
		$now = date('Y-m-d H:i:s',time());
		$id = $this->input->post('id');
		$code = $this->input->post('code');
		$name = $this->input->post('name');
		$rank = $this->input->post('rank');
		$remark = $this->input->post('remark');

		//带search的参数用于异步刷新页面时做分页和查询总条数
		$search_parent_code = $this->input->post('search_parent_code');
		$keyword = $this->input->post('keyword');
		$search_id = $this->input->post('search_id');
		$this->load->model('Building_model');
		//校正楼宇信息
		$res = $this->Building_model->updateBuildingName($code,$name,$rank,$remark);
		if($res==true){
			$data['message'] = '编辑楼宇成功';
		}
		else {
			$data['message'] = '编辑楼宇失败';
		}
		//根据code查出当前的building_level
		$level = " ";
		if(!empty($search_parent_code)){
			$buidling = $this->Building_model->getBuilding($search_parent_code);
			$level = $buidling['level'];
		}
		$total=$this->Building_model->getBuildingTotal($level,$keyword,$search_id,$search_parent_code,$this->user_per_page);
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
		$this->load->model('Building_model');
		$res = $this->Building_model->getBuildingNameCode();
		echo $res;
	}

	public function getBuildingByCode(){
		$this->load->model('Building_model');
		$res = $this->Building_model->getBuildingNameCode();
		echo $res;
	}

	//获取最近的有效房间号
	public function getBuildingLast(){
		$this->load->model('Building_model');
		$res = $this->Building_model->getBuildingLast();
		echo $res;
	}

	public function getBuilding(){
		$building_code = $this->input->post('building_code');
		$this->load->model('Building_model');
		$res = $this->Building_model->getBuilding($building_code);
		print_r(json_encode($res));
	}
}
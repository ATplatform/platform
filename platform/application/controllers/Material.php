<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller{
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
		redirect('Material/materialList');
	}

	public function materialList(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}

		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		$this->load->model('Material_model');
		$total=$this->Material_model->getMaterialTotal($this->user_per_page);

        $data['nav'] = 'materialList';
        $data['total']=$total;
        $data['page']=$page>=$total?$total:$page;
		$data['keyword']='';
		$data['pagesize']=$this->user_per_page;
        $this->load->model('Material_model');
		$this->load->view('app/material_list',$data);
	}

    public function getMaterialList(){
        $id=$this->input->get('id');
        $parent_code=$this->input->get('parent_code');
        $page = $this->input->get('page');
        $keyword = $this->input->get('keyword');
        $this->load->model('Material_model');
        $page = $page?$page:'1';
        $data = $this->Material_model->getMaterialList($page,$this->user_per_page);

        echo $data;
    }

    public function insertMaterial(){
        $now = date('Y-m-d h:i:s',time());
        $code = $this->input->post('code');
        $effective_date = $this->input->post('effective_date');
        $effective_status = $this->input->post('effective_status');
        $name = $this->input->post('name');
        $pcs = $this->input->post('pcs');
        $material_type = $this->input->post('material_type');
        $building_code = $this->input->post('building_code');
        $supplier = $this->input->post('supplier');
        $internal_no = $this->input->post('internal_no');
        $initial_no = $this->input->post('initial_no');
        $remark = $this->input->post('remark');
        $keyword = $this->input->post('keyword');
        $this->load->model('Material_model');
        //查到父节点的level_type,在此基础上加1,
        //$parent_material = $this->Material_model->getMaterialByCode($parent_code);
        //$parent_material_type =$parent_material['material_type'];
        //$material_type = $parent_material_type + 1;
        $res = $this->Material_model->insertMaterial($code,$effective_date,$effective_status,$name,$pcs,$material_type,$building_code,$supplier,$now,$internal_no,$initial_no, $remark);
        if($res==true){
            $data['message'] = '新增楼宇成功';
        }
        else {
            $data['message'] = '新增楼宇失败';
        }
        $total=$this->Material_model->getMaterialTotal($keyword,$this->user_per_page);
        $data['total'] = $total;
        print_r(json_encode($data));
    }
    public function getMaterialCode(){
        $this->load->model('Material_model');
        $res = $this->Material_model->getMaterialCode();
        echo $res;
    }

}
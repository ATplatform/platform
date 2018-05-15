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


}
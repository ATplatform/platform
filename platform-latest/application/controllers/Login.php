<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	function __construct(){
		session_start();
		parent::__construct();
		//打开重定向
		$this->load->helper('url');
		$this->load->database();
		$this->at_url=$this->config->item('at_url');
	}

	public function index(){
		// session_destroy();
		$at_url=$this->at_url;
		$data['at_url'] = $at_url;
		$data['page_url'] = "login";
		$this->load->view('app/index',$data);
	}

	//切换小区
	public function switchVillage(){
		$at_url=$this->at_url;
		$data['at_url'] = $at_url;
		$data['page_url'] = "switchVillage";
		$this->load->view('app/index',$data);
	}

	//退出登录
	public function logout(){
		session_destroy();
		$at_url=$this->at_url;
		$data['at_url'] = $at_url;
		$data['page_url'] = "login";
		$this->load->view('app/index',$data);
	}

	//验证艾特云平台的账号密码是否在本平台存在
	public function UserLogin(){
		header('Access-Control-Allow-Origin:http://119.23.56.17');
		header("Access-Control-Allow-Credentials:true");
		$username = $this->input->post('username');
		$password = $this->input->post('password');
        $sql = "select * from village_web_login where usr='$username' and password='$password' limit 1 ";
        // echo $sql;exit;
		$query = $this->db->query($sql); //自动转义
        $row = $query ->row_array();
    	if(!empty($row)){
            $data['Message'] = "验证成功";
            //验证成功后,返回一个跳转链接
            $data['url'] = $row['visit_url'];
            //设置session
            $_SESSION['username'] = $row['usr'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['village_id'] = $row['village_id'];
            $_SESSION['village_name'] = $row['village_name'];
            $_SESSION['village_account'] = $row['village_account'];
            $_SESSION['person_code'] = $row['person_code'];
            $_SESSION['visit_url'] = $row['visit_url'];
            // print_r($_SESSION);exit;
        }
        else{
            $data['Message'] = "验证失败";
        }
        print_r(json_encode($data)); 
	}
}

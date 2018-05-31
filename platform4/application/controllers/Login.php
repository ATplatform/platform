<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		session_start();
		parent::__construct();
		//打开重定向
		$this->load->helper('url');
		$this->load->database();
	}

	public function index(){
		// echo '进入login控制器';exit;	
		$this->load->view('app/index');
	}

	public function test(){
		echo '测试页面';exit;
	}

	//退出登录
	public function logout(){
		session_destroy();
		$this->load->view('app/index');
	}
}

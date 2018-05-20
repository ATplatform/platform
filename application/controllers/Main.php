<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Main extends CI_Controller {

	public function __construct(){
		parent::__construct();
		session_start();
		//打开重定向
		$this->load->helper('url');
		$this->load->database();
	}

	public function index(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		redirect('Building/buildingtree');
	}

	public function UserLogin(){
		$name = $this->input->post('username');
		$password = $this->input->post('password');

		if(empty($name)||empty($password)){
			echo '
            <script language="javascript">
                alert("用户名或密码不能为空！");
                window.location.href=\''.base_url().'index.php/Login\';
            </script> ';

		}
		else{

			//在模型中查询有没有这个用户名和密码
			$this->load->model('Login_model');
			$res = $this->Login_model->verify_user($name,$password);

			if($res != false){
				//验证通过,储存session,并跳页面
				$_SESSION['username'] = $this->input->post('username');
				redirect('Main');
			}
			else {
				echo '
	            <script language="javascript"> 
	                   
	                alert("用户名或密码错误！"); 
	                window.location.href=\''.base_url().'index.php/Login\'; 
	            </script> ';
			}
		}
	}
	
}

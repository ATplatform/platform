<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfond extends CI_Controller {

	function __construct(){
		session_start();
		parent::__construct();
		//打开重定向
		$this->load->helper('url');
		$this->load->database();
		$this->at_url=$this->config->item('at_url');
	}

	public function index(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		$data['username']=$_SESSION['username'];
		$data['at_url']= $this->at_url;
		$this->load->view('app/404',$data);
	}

}

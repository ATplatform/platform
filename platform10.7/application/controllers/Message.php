<?php
defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(E_ERROR);
date_default_timezone_set('Asia/ShangHai');
require_once APPPATH.'/simple_html_dom/simple_html_dom.php';

class Message extends CI_Controller{
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
		$this->load->view('app/message_list');
	}

	public function messagelist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}

		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$msg_type = $this->input->get('msg_type');
		$cycle_type = $this->input->get('cycle_type');
		$push_start_date = $this->input->get('push_start_date');
		$push_end_date = $this->input->get('push_end_date');

		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		if(is_null($push_start_date)||empty($push_start_date))
		{	
			//消息的初始查询开始日期为上个月的今天
			$push_start_date = date("Y-m-d", strtotime("-1 month"))." 00:00";
		}
		if(is_null($push_end_date)||empty($push_end_date))
		{
			$push_end_date = date('Y-m-d',time())." 23:59";
		}
		//得到信息条目总数
		$this->load->model('Message_model');
		$total = $this->Message_model->getMessageListTotal($push_start_date,$push_end_date,$msg_type,$cycle_type,$keyword,$this->user_per_page);
		// echo $total;exit;
		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['push_start_date']=$push_start_date;
		$data['push_end_date']=$push_end_date;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='messagelist';
		$data['username'] = $_SESSION['username'];

		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData();
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/message_list',$data);
	}

	public function getMessageCode(){
		$this->load->model('Message_model');
		$res = $this->Message_model->getMessageCode();
		if(empty($res)){
			$res = 1000000;
		}
		echo $res;
	}

	public function addContent(){
		$code = $this->input->post('messagecode');
		$content = $this->input->post('content');
		$html = str_get_html($content);
		// $url = $_SERVER['SERVER_NAME'];
		$url = $_SERVER['SERVER_ADDR'];
		// $url = "119.23.56.17";
		$new_html = $html;
		//补全路径,加上http://和服务器ip
		$base_url = 'http://'.$url;
		//对所有的有链接的元素(img和src)补全链接路径	
		foreach($new_html->find('[src]') as $key => $img){
			$new_src = $base_url.$img->src;
			//链接重新赋值
			$img->src = $new_src;
		}
		//根据new_html生成一个静态html文件
		// 上级目录
		$parent_dir = dirname(dirname(__FILE__));
		//得到模板文件
		$mobanpath= $parent_dir."/message_temp/message_temp.html";  
		if(!file_exists($mobanpath)){
		    die("没有模板文件");  
		}
		//打开模板文件  
		$fp=fopen($mobanpath,'r');  
		//读取模板文件  
		$str=fread($fp,filesize($mobanpath));  
		//将接收到的字段,替换模板文件的字段  
		$str=str_replace("{content}",$new_html,$str); 
		//生成静态页面的文件夹路径  
		$folderpath="./messagelist/";
		//如果没有这个文件夹就创建一个
		if(!file_exists($folderpath)){  
		    mkdir($folderpath);  
		}  
		//生成文件名字  
		$filename=$code.".html"; 
		//生成文件路径  
		$filepath="{$folderpath}{$filename}";  
		//判断是否有此文件  
		if(file_exists($filepath)){  
		    //有,先删除,再创建
			unlink($filepath); 
		}
		$fp=fopen($filepath,"w");  
		fwrite($fp,$str);
	    fclose($fp);  
		$first_dir = basename(dirname($parent_dir));
		$html_path = $base_url.'/'.$first_dir.'/messagelist/'.$filename;
		//返回文件绝对路径
		print_r(json_encode($html_path)); 
	}

	public function addMessage(){
		$code = $this->input->post('messagecode');
		$msg_type = $this->input->post('msg_type');
		$if_cycle = $this->input->post('if_cycle');
		$cycle_type = $this->input->post('cycle_type');
		$if_bill = $this->input->post('if_bill');
		$bill_amount = $this->input->post('bill_amount');
		$if_receipt = $this->input->post('if_receipt');
		$msg_title = $this->input->post('msg_title');
		$msg_link = $this->input->post('msg_link');
		$msg_img = $this->input->post('msg_img');
		$target_type = $this->input->post('target_type');
		$target = $this->input->post('target');
		$push_end_date = $this->input->post('push_end_date');
		$push_start_date = $this->input->post('push_start_date');

		$now=date('Y-m-d H:i',time());
		$this->load->model('Message_model');
		$user = $this->Message_model->getUser($_SESSION['username']);
		//获取当前登录用户的身份标识
		$person_code = $user['person_code'];

		//获取当客户端ip
		// $create_ip = '119.10.10.11';
		$create_ip = $_SERVER['REMOTE_ADDR'];
		//web端都是人工创建,类型为1
		$create_type = '1';

		//表示不是全部推
		if($target_type!='101'){
			$target = '{'.$target.'}';
		}
		//整个小区都推信息
		else {
			$this->load->model('Building_model');
			$topNode = $this->Building_model->getTopNode();
			$target = '{'.$topNode['code'].'}';
		}

		//表示立即推送消息,推送时间为当前
		if($if_cycle==101){
			$push_start_date = $now;
		}
		if(!$cycle_type){
			$cycle_type = null;
		}
		if(!$push_end_date){
			$push_end_date = null;
		}

		//写入数据
		$res = $this->Message_model->insertMessage($msg_type,$target_type,$target,$if_cycle,$cycle_type,$if_bill,$bill_amount,$person_code,$if_receipt,$create_type,$create_ip,$msg_img,$msg_title,$msg_link,$code,$push_end_date,$push_start_date);

		if($res==true){
			$data['message'] = '信息操作成功';
		}
		else {
			$data['message'] = '信息操作失败';
		}
		print_r(json_encode($data));

	}

	//获得标识图片
	public function getMsgImg(){
		// $url = $_SERVER['SERVER_NAME'];
		$url = $_SERVER['SERVER_ADDR'];
		// $url = "119.23.56.17";
		$parent_dir = dirname(dirname(__FILE__));
		$first_dir = basename(dirname($parent_dir));
		//加上http://
		$base_url = 'http://'.$url.'/'.$first_dir.'/upload/msg_img/';
		$res = array();
		for($i=1;$i<11;$i++){
			$msg_img_url = $base_url.$i.'.png';
			array_push($res,$msg_img_url);
		}
		print_r(json_encode($res));
	}

	public function getMessageList(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$msg_type = $this->input->get('msg_type');
		$cycle_type = $this->input->get('cycle_type');
		$push_start_date = $this->input->get('push_start_date');
		$push_end_date = $this->input->get('push_end_date');
		$this->load->model('Message_model');
		if(empty($page)){
			$page = 1;
		}
		//写入数据
		$res = $this->Message_model->getMessageList($push_start_date,$push_end_date,$msg_type,$cycle_type,$keyword,$page,$this->user_per_page);
		echo $res;
	}

	public function messagerecordlist(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}

		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$msg_type = $this->input->get('msg_type');
		$cycle_type = $this->input->get('cycle_type');
		$push_start_date = $this->input->get('push_start_date');
		$push_end_date = $this->input->get('push_end_date');
		$push_state = $this->input->get('push_state');
		$if_has_receipt = $this->input->get('if_has_receipt');

		if(is_null($page)||empty($page))
		{
			$page=1;
		}
		if(is_null($push_start_date)||empty($push_start_date))
		{
			//消息的初始查询开始日期为上个月的今天
			$push_start_date = date("Y-m-d", strtotime("-1 month"))." 00:00";
		}
		if(is_null($push_end_date)||empty($push_end_date))
		{
			$push_end_date = date('Y-m-d',time())." 23:59";
		}
		//得到信息条目总数
		$this->load->model('Message_model');
		$total = $this->Message_model->getMessageRecordListTotal($if_has_receipt,$push_state,$push_start_date,$push_end_date,$msg_type,$cycle_type,$keyword,$this->user_per_page);
		
		$data['page']=$page>=$total?$total:$page;
		$data['total']=$total;
		$data['keyword']=$keyword;
		$data['push_start_date']=$push_start_date;
		$data['push_end_date']=$push_end_date;
		$data['push_state']=$push_state;
		$data['pagesize']=$this->user_per_page;
		$data['nav']='messagerecordlist';
		$data['username'] = $_SESSION['username'];

		//树形菜单
		$this->load->model('Building_model');
		$treeNav_data = $this->Building_model->getBuildingTreeData();
		$data['treeNav_data']=$treeNav_data;
		$this->load->view('app/messagerecord_list',$data);
	}
	
	public function getmessagerecordlist(){
		$page = $this->input->get('page');
		$keyword = $this->input->get('keyword');
		$msg_type = $this->input->get('msg_type');
		$cycle_type = $this->input->get('cycle_type');
		$push_start_date = $this->input->get('push_start_date');
		$push_end_date = $this->input->get('push_end_date');
		$push_state = $this->input->get('push_state');
		$if_has_receipt = $this->input->get('if_has_receipt');
		$this->load->model('Message_model');
		$page = 1;
		//写入数据
		$res = $this->Message_model->getMessageRecordList($if_has_receipt,$push_state,$push_start_date,$push_end_date,$msg_type,$cycle_type,$keyword,$page,$this->user_per_page);
		echo $res;
	}

	public function getMessageTarget(){
		$target = $this->input->post('target');
		$this->load->model('Building_model');
		$res = array();
		foreach($target as $key => $row){
			$buildings = $this->Building_model->getBuilding($row);
			$res[$key]['buildings'] = $buildings;
			if($buildings['level'] == 100){
				//如果这个楼宇的实体等级是100,表示是丁节点
				$res[$key]["household"]=$buildings['name'];
			}
			else{
				$household = $this->Building_model->getHouseholdInfo($res[$key]['buildings']);
				$res[$key]["household"]=$household;
			}
		}
		print_r(json_encode($res));
	}

	public function updateMessage(){
		$code = $this->input->post('code');
		$push_end_date = $this->input->post('push_end_date');
		$search_push_start_date = $this->input->post('search_push_start_date');
		$search_push_end_date = $this->input->post('search_push_end_date');
		$search_msg_type = $this->input->post('search_msg_type');
		$search_cycle_type = $this->input->post('search_cycle_type');
		$search_keyword = $this->input->post('search_keyword');

		$this->load->model('Message_model');
		$res = $this->Message_model->updateMessage($code,$push_end_date);
		if($res==true){
			$data['message'] = '编辑消息成功';
		}
		else {
			$data['message'] = '编辑消息失败';
		}
		//得到数据总页数
		$data['total'] = $this->Message_model->getMessageListTotal($search_push_start_date,$search_push_end_date,$search_msg_type,$search_cycle_type,$search_keyword,$this->user_per_page);
		print_r(json_encode($data));
	}
}

?>
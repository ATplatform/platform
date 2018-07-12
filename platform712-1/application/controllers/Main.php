<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ERROR);
date_default_timezone_set('Asia/ShangHai');

class Main extends CI_Controller {

	public function __construct(){
		parent::__construct();
		session_start();
		//打开重定向
		$this->load->helper('url');
		$this->load->database();
		$this->qr_code_type_arr=$this->config->item('qr_code_type_arr');
		$this->at_url=$this->config->item('at_url');
	}

	public function index(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		redirect('Building/buildingtree');
	}	

	//二维码打印页面
	public function tdcodepath(){
		if (!isset($_SESSION['username'])) {
		   redirect('Login');
		}

		$data['nav']='tdcodepath';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		$this->load->view('app/tdcodepath',$data);
	}

	//二维码打印功能
	public function downloadTdcode(){
		$qr_code_type = $this->input->post('qr_code_type');
		$qr_code_type_name = '';
		//二维码类型名称
		$qr_code_type_arr=$this->qr_code_type_arr;
		foreach($qr_code_type_arr as $k => $v){
			if($qr_code_type==$v['code']){
				$qr_code_type_name = $v['name'];
				break;
			}
		}
		//拼接文件夹地址
		$data_dir = './qrcode/'.$session['village_id'].$session['village_name'].$qr_code_type_name.'二维码/';
		// $data_dir = './qrcode/100001/';
		//转成中文
		$data_dir = iconv('utf-8', 'gbk', $data_dir);
		$data_dir = urlencode($data_dir);
		// print_r($data_dir);exit;
		$datalist=$this->list_dir($data_dir);

		// echo $data_dir;exit;
		$filename = "./qrcode.zip"; //最终生成的文件名（含路径）
		if(file_exists($filename))
		{
			unlink($filename);	
		}
		if(!file_exists($filename)){   
			//重新生成文件
		    $zip = new ZipArchive();//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释   
		    if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {   
		        exit('无法打开文件，或者文件创建失败');
		    }   
		    foreach( $datalist as $val){
		        if(file_exists($val)){
		        	$zip->addFile( $val,$val); //这样可以把文件夹也一起压缩  
		            // $zip->addFile( $val, basename($val));//第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下   
		        }   
		    }
		    $zip->close();//关闭   
		}  
		if(!file_exists($filename)){  
		    exit("无法找到文件"); //即使创建，仍有可能失败。。。。
		}   
		$url='http://'.$_SERVER['HTTP_HOST'].base_url()."qrcode.zip";
		echo $url;
	}

	//获取文件列表
	function list_dir($dir){
		// $dir = iconv('utf-8', 'gbk', $dir);
		// echo $dir;exit;
    	$result = array();
    	if (is_dir($dir)){
    		$file_dir = scandir($dir);
    		foreach($file_dir as $file){
    			if ($file == '.' || $file == '..'){
    				continue;
    			}
    			elseif (is_dir($dir.$file)){
    				$result = array_merge($result, $this->list_dir($dir.$file.'/'));
    			}
    			else{
    				array_push($result, $dir.$file);
    			}
    		}
    	}
    	return $result;
    }

}

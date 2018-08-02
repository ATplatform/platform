<?php
require_once APPPATH.'/libraries/include/Classes/PHPExcel/IOFactory.php';
error_reporting(E_ERROR);
date_default_timezone_set('Asia/ShangHai');

class Import extends CI_Controller {

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

	//数据导入页面
	public function importData(){
		if (!isset($_SESSION['username'])) {
		   redirect('Login');
		}

		$data['nav']='import_data';
		$data['username'] = $_SESSION['username'];
		$data['at_url']= $this->at_url;
		$this->load->view('app/import_data',$data);
	}

	public function importPerson(){
		$type="person";
		set_time_limit(3800); 
		if(PHP_OS=='Linux'){
			$this->ImportLinux($type);	
		}
		else{
			$this->ImportWindows($type);
		}
	}

	public function importPersonBuilding(){
		$type="person_building";
		set_time_limit(3800); 
		if(PHP_OS=='Linux'){
			$this->ImportLinux($type);	
		}
		else{
			$this->ImportWindows($type);
		}
	}

	public function importPersonBiz(){
		$type="person_biz";
		set_time_limit(3800); 
		if(PHP_OS=='Linux'){
			$this->ImportLinux($type);	
		}
		else{
			$this->ImportWindows($type);
		}
	}

	public function importBuilding(){
		$type="building";
		set_time_limit(3800); 
		if(PHP_OS=='Linux'){
			$this->ImportLinux($type);	
		}
		else{
			$this->ImportWindows($type);
		}
	}

    public function importWaterFee(){
        $type="water_fee";
        set_time_limit(3800);
        if(PHP_OS=='Linux'){
            $this->ImportLinux($type);
        }
        else{
            $this->ImportWindows($type);
        }
    }




	public function ImportWindows($type){
		if(isset($_FILES["file"]["type"])===false){
			echo '
            <script language="javascript"> 
                alert("请选择文件！"); 
                window.location.href=\''.base_url().'index.php/Import/importData\'; 
            </script> ';		
		}
		else {
			if((($_FILES["file"]["type"] == "application/vnd.ms-excel")||($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"))&&($_FILES["file"]["size"] < 10*1024*1024)){
				if ($_FILES["file"]["error"] > 0){
					echo '
		            <script language="javascript"> 
		                alert("上传文件出错！请重试。"); 
		                window.location.href=\''.base_url().'index.php/Main\'; 
		            </script> ';		
				}
				else{
					if (file_exists("upload/" . $_FILES["file"]["name"])){
						move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $_FILES["file"]["name"]);
					}
					else{
						move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $_FILES["file"]["name"]);
					}
					$sheet_data=$this->excelImportData("upload/" . $_FILES["file"]["name"]);
					// print_r($sheet_data);exit;
					//根据type不一样,导入不一样的数据
					$this->load->model('Import_model');
					if($type=="person"){
						$results = $this->Import_model->importPersonData($sheet_data);
					}
					if($type=="person_building"){
						$results = $this->Import_model->importPersonBuildingData($sheet_data);
					}
					if($type=="person_biz"){
						$results = $this->Import_model->importPersonBizData($sheet_data);
					}
                    if($type=="water_fee"){
                        $results = $this->Import_model->importWaterFeeData($sheet_data);
                    }
					if($type=="building"){
						$results = $this->Import_model->importBuildingData($sheet_data);
						//如果有数据写入成功,就需要更新楼宇临时表\生成楼宇sip地址\生成楼宇二维码
						if(strpos($results,'成功') == true){
							//生成楼宇临时表 
							$this->setTmpBuilding();
						 	//生成楼宇sip地址
						 	$this->updateAllBuildingSip();
						 	//生成楼宇二维码
						 	// $this->setAllBuildingQRcode();
						}
					}
					echo '
		            <script language="javascript"> 
		                alert("'.$results.'"); 
		                window.location.href=\''.base_url().'index.php/Import/importData\'; 
		            </script> ';
													
				}
			}
			elseif($_FILES["file"]["size"] >= 10*1024*1024){
				echo '
	            <script language="javascript"> 
	                alert("上传的文件太大了！"); 
	                window.location.href=\''.base_url().'index.php/Import/importData\'; 
	            </script> ';		
			}
			else{
				echo '
	            <script language="javascript"> 
	                alert("请上传xls,xlsx等格式的文件！"); 
	                window.location.href=\''.base_url().'index.php/Import/importData\'; 
	            </script> ';		
			}
		}
	}

	public function ImportLinux($type){
		if(isset($_FILES["file"]["type"])===false){
			echo '
            <script language="javascript"> 
                alert("请选择文件！"); 
                window.location.href=\''.base_url().'index.php/Main\'; 
            </script> ';		
		}
		else {
			if((($_FILES["file"]["type"] == "application/vnd.ms-excel")||($_FILES["file"]["type"]=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"))&&($_FILES["file"]["size"]<10*1024*1024)){
				if ($_FILES["file"]["error"] > 0){
					echo '
		            <script language="javascript"> 
		                alert("上传文件出错！请重试。"); 
		                window.location.href=\''.base_url().'index.php/Import/importData\'; 
		            </script> ';		
				}
				else{
					if (file_exists("/tmp/" . $_FILES["file"]["name"])){
						move_uploaded_file($_FILES["file"]["tmp_name"],"/tmp/" . $_FILES["file"]["name"]);
					}
					else{
						move_uploaded_file($_FILES["file"]["tmp_name"],"/tmp/" . $_FILES["file"]["name"]);
					}
					$sheet_data=$this->excelImportData("/tmp/" . $_FILES["file"]["name"]);
					//根据type不一样,导入不一样的数据
					$this->load->model('Import_model');
					if($type=="person"){
						$results = $this->Import_model->importPersonData($sheet_data);
					}
					if($type=="person_building"){
						$results = $this->Import_model->importPersonBuildingData($sheet_data);
					}
					if($type=="person_biz"){
						$results = $this->Import_model->importPersonBizData($sheet_data);
					}
                    if($type=="water_fee"){
                        $results = $this->Import_model->importWaterFeeData($sheet_data);
                    }
					echo '
		            <script language="javascript"> 
		                alert("'.$results.'"); 
		                window.location.href=\''.base_url().'index.php/Import/importData\'; 
		            </script> ';
				}
			}
			else if($_FILES["file"]["size"] >= 10*1024*1024){
				echo '
	            <script language="javascript"> 
	                alert("上传的文件太大了！"); 
	                window.location.href=\''.base_url().'index.php/Import/importData\'; 
	            </script> ';		
			}
			else{
				echo '
	            <script language="javascript"> 
	                alert("请上传xls,xlsx等格式的文件！"); 
	                window.location.href=\''.base_url().'index.php/Import/importData\'; 
	            </script> ';		
			}
		}
		
	}

	public function excelImportData($file){
		// Check prerequisites
		if (!file_exists($file)) {
			exit("not found device.xlsx.\n");
		}
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		$sheet = $objPHPExcel->getSheet(0);

		//获取行数与列数,注意列数需要转换
		$highestRowNum = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnNum = PHPExcel_Cell::columnIndexFromString($highestColumn);
		
		//取得字段，这里测试表格中的第一行为数据的字段，因此先取出用来作后面数组的键名
		$filed = array();
		for($i=0; $i<$highestColumnNum;$i++){
			$cellName = PHPExcel_Cell::stringFromColumnIndex($i).'1';
			$cellVal = $sheet->getCell($cellName)->getValue();//取得列内容
			$filed []= $cellVal;
		}
		$sheet_table_arr = array(array('code'=>'编号','name'=>'code'),array('code'=>'楼宇名称','name'=>'name'),array('code'=>'状态','name'=>'effective_status'),array('code'=>'生效日期','name'=>'effective_date'),array('code'=>'楼宇层级','name'=>'level'),array('code'=>'顺序号','name'=>'rank'),array('code'=>'上一级楼宇','name'=>'parent_code'),array('code'=>'楼宇建筑面积','name'=>'floor_area'),array('code'=>'楼宇套内面积','name'=>'inside_area'),array('code'=>'产权类型','name'=>'building_type'),array('code'=>'姓','name'=>'last_name'),array('code'=>'名','name'=>'first_name'),array('code'=>'身份证件类型','name'=>'id_type'),array('code'=>'身份证件号码','name'=>'id_number'),array('code'=>'国家或地区','name'=>'nationality'),array('code'=>'性别','name'=>'gender'),array('code'=>'出生年月日','name'=>'birth_date'),array('code'=>'血型','name'=>'blood_type'),array('code'=>'民族','name'=>'ethnicity'),array('code'=>'是否残疾','name'=>'if_disabled'),array('code'=>'手机号码国别','name'=>'tel_country'),array('code'=>'手机号码','name'=>'mobile_number'),array('code'=>'其他手机号码','name'=>'oth_mob_no'),array('code'=>'楼宇编号','name'=>'building_code'),array('code'=>'人员编号','name'=>'person_code'),array('code'=>'开始日期','name'=>'begin_date'),array('code'=>'结束日期','name'=>'end_date'),array('code'=>'住户类型','name'=>'household_type'),array('code'=>'商户类型','name'=>'biz_type'),array('code'=>'经营内容','name'=>'biz_info'),array('code'=>'用水记录编号','name'=>'code'),array('code'=>'楼宇编号','name'=>'building_code'),array('code'=>'楼宇名称','name'=>'building_name'),array('code'=>'楼宇层顺序号','name'=>'rank'),array('code'=>'对应月份','name'=>'month'),array('code'=>'本月用水量','name'=>'water_csp'));

    /*    用水记录
编号	Water_List	Code
楼宇编号	Water_List
        /Building	Building_Code
楼宇名称	Water_List
        /Building	Building_Name
楼宇
层顺序号	Water_List
        /Building	Rank
对应月份	Water_List	Month
本月用水量	Water_List	Water_CSP*/



		$tablekey=array();
		for($i=0;$i<sizeof($filed);$i++){
			foreach($sheet_table_arr as $key => $row){
				if($filed[$i]==$row['code']){
					$tablekey[]=$row['name'];
				}
			}
			
		}
		//开始取出数据并存入数组
		$data = array();
		for($i=2;$i<=$highestRowNum;$i++){//ignore row 1
			$row = array();
			for($j=0; $j<$highestColumnNum;$j++){
				$cellName = PHPExcel_Cell::stringFromColumnIndex($j).$i;
				$cellVal = $sheet->getCell($cellName)->getValue();
				$row[ $tablekey[$j] ] = $cellVal;
			}
			$data []= $row;
		}
		return $data;
	}

	//更新所有楼宇的sip地址
	public function updateAllBuildingSip(){
		$this->load->model('UpdateBuildingSip_model');
		$this->UpdateBuildingSip_model->updateAllBuildingSip();
	}

	//批量生成楼宇二维码
	public function setAllBuildingQRcode(){
		$this->load->model('Building_model');
		$buildings = $this->Building_model->getAllBuilding($_SESSION['village_id']);
		//对每个building循环,生成二维码
		foreach($buildings as $row){
			$this->Building_model->setBuildingQRcode($row['code']);
		}
	}

	//模拟生成tmp_building表
	public function setTmpBuilding(){
		$this->load->model('TmpBuilding_model');
		$this->TmpBuilding_model->getTmpBuilding();
	}

}

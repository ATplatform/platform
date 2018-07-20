<?php
include(APPPATH.'/libraries/include/phpqrcode/qrlib.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //打开重定向
        $this->load->helper('url');
        $this->load->database();
        $this->user_per_page = $this->config->item('user_per_page');
        $this->at_url=$this->config->item('at_url');
        $this->material_type_arr=$this->config->item('material_type_arr');
    }

    public function index()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }
        redirect('Material/materialList');
    }

    /////////////数据展示///////////////
    public function materialList()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }
        $this->load->model('Building_model');
        $this->load->model('Material_model');
        $village_id = $_SESSION['village_id'];
        $username=$_SESSION['username'];

        $treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
        $effective_date=$this->input->get('effective_date');
        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $material_type = $this->input->get('material_type');
        $keyword = $this->input->get('keyword');
        $material_type_name=$this->Material_model->getmaterial_type_name($material_type);

        $page = $this->input->get('page');
        $page = $page ? $page : '1';


        //判断是普通查询还是搜索查询
        if (empty($parent_code) && empty($building_code) && empty($material_type) && empty($keyword) && empty($effective_date)) {
            $total = $this->Material_model->getMaterialListTotalbyNormal($this->user_per_page);
            $dataNormal['nav'] = 'materialList';
            $dataNormal['keyword'] = $keyword;
            $dataNormal['material_type'] = $material_type;
            $dataNormal['building_code'] = $building_code;
            $dataNormal['parent_code'] = $parent_code;
            $dataNormal['effective_date'] = $effective_date;
            $dataNormal['username'] = $username;
            $dataNormal['at_url']= $this->at_url;
            $dataNormal['material_type_name'] = $material_type_name;
            $dataNormal['treeNav_data'] = $treeNav_data;
            $dataNormal['total'] = $total;
            $dataNormal['page'] = $page >= $total ? $total : $page;
            $dataNormal['pagesize'] = $this->user_per_page;
            $this->load->view('app/material_list', $dataNormal);
        } else {
            $total = $this->Material_model->getMaterialListTotalbySearch($effective_date,$parent_code, $building_code, $material_type, $keyword, $this->user_per_page);
            $dataSearch['nav'] = 'materialList';
            $dataSearch['keyword'] = $keyword;
            $dataSearch['material_type'] = $material_type;
            $dataSearch['building_code'] = $building_code;
            $dataSearch['parent_code'] = $parent_code;
            $dataSearch['effective_date'] = $effective_date;
            $dataSearch['username'] = $username;
            $dataSearch['at_url']= $this->at_url;
            $dataSearch['material_type_name'] = $material_type_name;
            $dataSearch['treeNav_data'] = $treeNav_data;
            $dataSearch['total'] = $total;
            $dataSearch['page'] = $page >= $total ? $total : $page;
            $dataSearch['pagesize'] = $this->user_per_page;

            $this->load->view('app/material_list', $dataSearch);
        }

    }


    //////////////////////插入数据/////////////////////
    public function insertMaterial()
    {
        $village_id = $_SESSION['village_id'];
        //收集数据
        $create_time = date('Y-m-d h:i:s', time());
        $code = $this->input->post('code');
        $effective_date = $this->input->post('effective_date');
        $effective_status = $this->input->post('effective_status');
        $name = $this->input->post('name');
        $pcs = $this->input->post('pcs');
        $material_type = $this->input->post('material_type');
        $building_code = $this->input->post('building_code');
        $function = $this->input->post('materialfunction');
        $supplier = $this->input->post('supplier');
        $internal_no = $this->input->post('internal_no');
        $initial_no = $this->input->post('initial_no');
        $remark = $this->input->post('remark');
        $this->load->model('Material_model');
        $this->load->model('Building_model');

        $building = $this->Building_model->getBuilding($building_code,$village_id);

        $householdInfo = $this->Building_model->getHouseholdInfo($building);
        // echo $householdInfo;exit;
        //根据设备类型得到设备类型名称
        $material_type_arr=$this->material_type_arr;
        foreach($material_type_arr as $k => $v){
            if($material_type==$v['code']){
                $material_type_name = $v['name'];
            }
        }

        $url = $_SERVER['SERVER_ADDR'];
        $base_url = 'http://'.$url;
        //二维码名称
        $fileName =$url.'_'.$code.'.png';
        //二维码图片地址
        $village_id = $_SESSION['village_id'];

        $village_name= $this->Building_model->getvillagename($village_id);

        $temp_path='qrcode/'.$village_id.'_QRCODE_MATERIAL';

        //二维码内容,设备的二维码type为101,village暂时写为100001
        $this->load->model('Building_model');

        $pushserver_address=$base_url;
        $qr_code=$pushserver_address.'/platform/'.$temp_path.'/'.$fileName;
        $qrcodeData = $this->Building_model->getQrcodeData(104,$village_id,$code,$qr_code);
        $this->Building_model->setQRcode($qrcodeData,$temp_path,$fileName);

        $res = $this->Material_model->insertMaterial($village_id,$code, $effective_date, $effective_status, $name, $pcs, $material_type, $building_code, $function,$supplier, $internal_no, $initial_no, $remark, $qr_code,$create_time);
        if ($res) {
            $data['message'] = '新增物资成功';
            //新增成功后,生成一张二维码图片
            //得到楼宇信息

        } else {
            $data['message'] = '新增物资失败';
        }
      //  $total = $this->Material_model->getMaterialListTotalbyNormal($this->user_per_page);
        //$data['total'] = $total;
        print_r(json_encode($data));
    }


    //////////////////////普通查询数据///////////////
    public function getMaterialListbyNormal()
    {
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Material_model');
        $sqlNormal = $this->Material_model->getMaterialListbyNormal($page, $this->user_per_page);
        $dataNormal = $this->Material_model->getMaterialList($sqlNormal);
        echo $dataNormal;
    }


    ///////////////////搜索查询数据 get方法 查询参数//////////////
    public function getMaterialListbySearch()
    {
        $effective_date=$this->input->get('effective_date');
        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $material_type = $this->input->get('material_type');
        $keyword = $this->input->get('keyword');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Material_model');
        $sqlSearch = $this->Material_model->getMaterialListbySearch($effective_date,$parent_code, $building_code, $material_type, $keyword, $page, $this->user_per_page);
        $dataSearch = $this->Material_model->getMaterialList($sqlSearch);
        echo $dataSearch;
    }


   /////////////////获得目前数据库里的最高序列+1
    public function getMaterialLatestCode()
    {
        $this->load->model('Material_model');
        $res = $this->Material_model->getMaterialLatestCode();
        echo $res;
    }




    //动态获取所有楼宇信息
    public function getMaterialBuildingCode()
    {
        $this->load->model('Material_model');
        $res = $this->Material_model->getMaterialNameCode();
        echo $res;
    }

    //动态获取所有物资的编号
    public function getMaterialAllCode()
    {
        $this->load->model('Material_model');
        $res = $this->Material_model->getMaterialAllCode();
        echo $res;
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////materialUsage/////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////


    public function materialUsage()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }
        $this->load->model('Building_model');
        $this->load->model('Material_model');
        $village_id = $_SESSION['village_id'];
        $username=$_SESSION['username'];


        $treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
        $effective_date=$this->input->get('effective_date');
        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $material_type = $this->input->get('material_type');
        $keyword = $this->input->get('keyword');
        $material_type_name=$this->Material_model->getmaterial_type_name($material_type);



        $page = $this->input->get('page');
        $page = $page ? $page : '1';

        //根据物资状态管理表更新物资表
      //  $this->Material_model->updateCodeInMaterial();

        //判断是普通查询还是搜索查询
        if (empty($parent_code) && empty($building_code) && empty($material_type) && empty($keyword) && empty($effective_date)) {
            $total = $this->Material_model->getMaterialUsageTotalbyNormal($this->user_per_page);
            $dataNormal['nav'] = 'materialUsage';
            $dataNormal['keyword'] = $keyword;
            $dataNormal['material_type'] = $material_type;
            $dataNormal['building_code'] = $building_code;
            $dataNormal['parent_code'] = $parent_code;
            $dataNormal['effective_date'] = $effective_date;
            $dataNormal['username'] = $username;
            $dataNormal['at_url']= $this->at_url;
            $dataNormal['material_type_name'] = $material_type_name;
            $dataNormal['treeNav_data'] = $treeNav_data;
            $dataNormal['total'] = $total;
            $dataNormal['page'] = $page >= $total ? $total : $page;
            $dataNormal['pagesize'] = $this->user_per_page;
            $this->load->view('app/material_usage', $dataNormal);
        } else {
            $total = $this->Material_model->getMaterialUsageTotalbySearch($effective_date,$parent_code, $building_code, $material_type, $keyword, $this->user_per_page);
            $dataSearch['nav'] = 'materialUsage';
            $dataSearch['keyword'] = $keyword;
            $dataSearch['material_type'] = $material_type;
            $dataSearch['building_code'] = $building_code;
            $dataSearch['parent_code'] = $parent_code;
            $dataSearch['effective_date'] = $effective_date;
            $dataSearch['username'] = $username;
            $dataSearch['at_url']= $this->at_url;
            $dataSearch['material_type_name'] = $material_type_name;
            $dataSearch['treeNav_data'] = $treeNav_data;
            $dataSearch['total'] = $total;
            $dataSearch['page'] = $page >= $total ? $total : $page;
            $dataSearch['pagesize'] = $this->user_per_page;

            $this->load->view('app/material_usage', $dataSearch);
        }

    }

    public function getMaterialUsagebyNormal()
    {
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Material_model');
        $sqlNormal = $this->Material_model->getMaterialUsagebyNormal($page, $this->user_per_page);
        $dataNormal = $this->Material_model->getMaterialUsage($sqlNormal);
        echo $dataNormal;
    }


public function insertMaterialUsage()
{
    //收集数据
  /*  $create_time = date('Y-m-d h:i:s', time());
    $effective_date = $this->input->post('effective_date');
    $effective_status = $this->input->post('effective_status');


    $pcs = $this->input->post('pcs');
    $material_type = $this->input->post('material_type');
    $building_code = $this->input->post('building_code');
    $function = $this->input->post('materialfunction');
    $supplier = $this->input->post('supplier');
    $internal_no = $this->input->post('internal_no');
    $initial_no = $this->input->post('initial_no');
    $remark = $this->input->post('remark');
 */

    $create_time = date('Y-m-d h:i:s', time());
    $material_code = $this->input->post('material_code');
    $mgt_status=$this->input->post('mgt_status');
    $person_codes=$this->input->post('person_codes');
    $remark = $this->input->post('remark');
    $effective_date=$this->input->post('effective_date');
    $this->load->model('Material_model');


  /*  foreach ($building_code as $row) {
        $res = $this->Material_model->insertMaterial($code, $effective_date, $effective_status, $name, $pcs, $material_type, $row['code'], $function,$supplier, $internal_no, $initial_no, $remark, $create_time);
    }*/
    $flag =$this->Material_model-> defineUsageEffective($material_code,$effective_date);
    if ($flag) {
        $data['message'] = '同一物资每天只能修改一次';
        $data['datebug']=true;
    } else {
        $data['datebug']=false;




    foreach($person_codes as $row){

        $result=$this->Material_model->insertMaterialUsage($material_code,$mgt_status,$effective_date,$row['person_code'],$remark,$create_time);

        if($mgt_status==104 || $mgt_status==105  ){

            $effective_status='f';
            $res =$this->Material_model->getMaterialListbyUsage($material_code);
            $result=$this->Material_model->UpdateMaterialList($material_code,$effective_date,$effective_status,$res['name'],$res['pcs'],$res['material_type'],$res['building_code'],$res['function'],$res['supplier'],$res['internal_no'],$res['initial_no'],$res['remark'],$create_time);
        }

    }

    //$res = $this->Material_model->insertMaterialUsage($id,$mgt_status,$effective_date,$person_code,$remark);
    if ($result) {
        $data['message'] = '新增物资状态成功';
    } else {
        $data['message'] = '新增物资状态失败';
    }
    }
    $total = $this->Material_model->getMaterialUsageTotalbyNormal($this->user_per_page);
    $data['total'] = $total;
    print_r(json_encode($data));

}






    ///////////////////搜索查询数据 get方法 查询参数//////////////
    public function getMaterialUsagebySearch()
    {
        $effective_date=$this->input->get('effective_date');
        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $material_type = $this->input->get('material_type');
        $keyword = $this->input->get('keyword');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Material_model');
        $sqlSearch = $this->Material_model->getMaterialUsagebySearch($effective_date,$parent_code, $building_code, $material_type, $keyword, $page, $this->user_per_page);
        $dataSearch = $this->Material_model->getMaterialUsage($sqlSearch);
        echo $dataSearch;
    }








}
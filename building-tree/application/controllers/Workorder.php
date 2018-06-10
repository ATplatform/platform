<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workorder extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //打开重定向
        $this->load->helper('url');
        $this->load->database();
        $this->user_per_page = $this->config->item('user_per_page');
    }

    public function index()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }
        redirect('Workorder/workorderList');
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////workorderList/////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////数据展示///////////////
    public function workorderList()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }
        $this->load->model('Building_model');
        $this->load->model('Workorder_model');

        $username=$_SESSION['username'];
        $username= $this->Workorder_model->getUserName($username);
        $treeNav_data = $this->Building_model->getBuildingTreeData();
        $effective_date=$this->input->get('effective_date');
        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $material_type = $this->input->get('material_type');
        $keyword = $this->input->get('keyword');
        $material_type_name=$this->Workorder_model->getmaterial_type_name($material_type);

        $page = $this->input->get('page');
        $page = $page ? $page : '1';


        //判断是普通查询还是搜索查询
        if (empty($parent_code) && empty($building_code) && empty($material_type) && empty($keyword) && empty($effective_date)) {
            $total = $this->Workorder_model->getWorkorderListTotalbyNormal($this->user_per_page);
            $dataNormal['nav'] = 'workorderList';
            $dataNormal['keyword'] = $keyword;
            $dataNormal['material_type'] = $material_type;
            $dataNormal['building_code'] = $building_code;
            $dataNormal['parent_code'] = $parent_code;
            $dataNormal['effective_date'] = $effective_date;
            $dataNormal['username'] = $username;
            $dataNormal['material_type_name'] = $material_type_name;
            $dataNormal['treeNav_data'] = $treeNav_data;
            $dataNormal['total'] = $total;
            $dataNormal['page'] = $page >= $total ? $total : $page;
            $dataNormal['pagesize'] = $this->user_per_page;
            $this->load->view('app/workorder_list', $dataNormal);
        } else {
            $total = $this->Workorder_model->getWorkorderListTotalbySearch($effective_date,$parent_code, $building_code, $material_type, $keyword, $this->user_per_page);
            $dataSearch['nav'] = 'workorderList';
            $dataSearch['keyword'] = $keyword;
            $dataSearch['material_type'] = $material_type;
            $dataSearch['building_code'] = $building_code;
            $dataSearch['parent_code'] = $parent_code;
            $dataSearch['effective_date'] = $effective_date;
            $dataSearch['username'] = $username;
            $dataSearch['material_type_name'] = $material_type_name;
            $dataSearch['treeNav_data'] = $treeNav_data;
            $dataSearch['total'] = $total;
            $dataSearch['page'] = $page >= $total ? $total : $page;
            $dataSearch['pagesize'] = $this->user_per_page;

            $this->load->view('app/workorder_list', $dataSearch);
        }

    }


    //////////////////////插入数据/////////////////////
    public function insertMaterial()
    {
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
        $this->load->model('Workorder_model');
        foreach ($building_code as $row) {
            $res = $this->Workorder_model->insertMaterial($code, $effective_date, $effective_status, $name, $pcs, $material_type, $row['code'], $function,$supplier, $internal_no, $initial_no, $remark, $create_time);
        }
        if ($res) {
            $data['message'] = '新增物资成功';
        } else {
            $data['message'] = '新增物资失败';
        }
        $total = $this->Workorder_model->getWorkorderListTotalbyNormal($this->user_per_page);
        $data['total'] = $total;
        print_r(json_encode($data));
    }


    //////////////////////普通查询数据///////////////
    public function getWorkorderListbyNormal()
    {
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Workorder_model');
        $sqlNormal = $this->Workorder_model->getWorkorderListbyNormal($page, $this->user_per_page);
        $dataNormal = $this->Workorder_model->getWorkorderList($sqlNormal);
        echo $dataNormal;
    }


    ///////////////////搜索查询数据 get方法 查询参数//////////////
    public function getWorkorderListbySearch()
    {
        $effective_date=$this->input->get('effective_date');
        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $material_type = $this->input->get('material_type');
        $keyword = $this->input->get('keyword');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Workorder_model');
        $sqlSearch = $this->Workorder_model->getWorkorderListbySearch($effective_date,$parent_code, $building_code, $material_type, $keyword, $page, $this->user_per_page);
        $dataSearch = $this->Workorder_model->getWorkorderList($sqlSearch);
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






}
<?php
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
    }

    public function index()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }
        redirect('Material/materialList');
    }


    //数据展示
    public function materialList()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }
        $this->load->model('Building_model');
        $this->load->model('Material_model');

        $treeNav_data = $this->Building_model->getBuildingTreeData();

        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $material_type = $this->input->get('material_type');
        $keyword = $this->input->get('keyword');

        if ($material_type == 101) {
            $material_type_name = '工程物资';
        } elseif ($material_type == 102) {
            $material_type_name = '安防物资';
        } elseif ($material_type == 103) {
            $material_type_name = '消防物资';
        } elseif ($material_type == 104) {
            $material_type_name = '保洁物资';
        } elseif ($material_type == 105) {
            $material_type_name = '办公物资';
        } else {
            $material_type_name = '物资类别';
        }

        $page = $this->input->get('page');
        $page = $page ? $page : '1';

        //判断是普通查询还是搜索查询
        if (empty($parent_code) && empty($building_code) && empty($material_type) && empty($keyword)) {
            $total = $this->Material_model->getMaterialTotalbyNormal($this->user_per_page);
            $dataNormal['nav'] = 'materialList';
            $dataNormal['keyword'] = $keyword;
            $dataNormal['material_type'] = $material_type;
            $dataNormal['building_code'] = $building_code;
            $dataNormal['parent_code'] = $parent_code;
            $dataNormal['material_type_name'] = $material_type_name;
            $dataNormal['treeNav_data'] = $treeNav_data;
            $dataNormal['total'] = $total;
            $dataNormal['page'] = $page >= $total ? $total : $page;
            $dataNormal['pagesize'] = $this->user_per_page;
            $this->load->view('app/material_list', $dataNormal);
        } else {
            $total = $this->Material_model->getMaterialTotalbySearch($parent_code, $building_code, $material_type, $keyword, $this->user_per_page);

            $dataSearch['nav'] = 'materialList';
            $dataSearch['keyword'] = $keyword;
            $dataSearch['material_type'] = $material_type;
            $dataSearch['building_code'] = $building_code;
            $dataSearch['parent_code'] = $parent_code;
            $dataSearch['material_type_name'] = $material_type_name;
            $dataSearch['treeNav_data'] = $treeNav_data;
            $dataSearch['total'] = $total;
            $dataSearch['page'] = $page >= $total ? $total : $page;
            $dataSearch['pagesize'] = $this->user_per_page;
            $this->load->view('app/material_list', $dataSearch);
        }

    }


    //插入数据
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
        $supplier = $this->input->post('supplier');
        $internal_no = $this->input->post('internal_no');
        $initial_no = $this->input->post('initial_no');
        $remark = $this->input->post('remark');
        $this->load->model('Material_model');
        foreach ($building_code as $row) {
            $res = $this->Material_model->insertMaterial($code, $effective_date, $effective_status, $name, $pcs, $material_type, $row['code'], $supplier, $internal_no, $initial_no, $remark, $create_time);
        }
        if ($res) {
            $data['message'] = '新增物资成功';
        } else {
            $data['message'] = '新增物资失败';
        }
        $total = $this->Material_model->getMaterialTotalbyNormal($this->user_per_page);
        $data['total'] = $total;
        print_r(json_encode($data));
    }


    //普通查询数据
    public function getMaterialListbyNormal()
    {
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Material_model');
        $sqlNormal = $this->Material_model->getMaterialListbyNormal($page, $this->user_per_page);
        $dataNormal = $this->Material_model->getMaterialList($sqlNormal);
        echo $dataNormal;
    }


    //搜索查询数据 get方法 查询参数
    public function getMaterialListbySearch()
    {

        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $material_type = $this->input->get('material_type');
        $keyword = $this->input->get('keyword');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Material_model');
        $sqlSearch = $this->Material_model->getMaterialListbySearch($parent_code, $building_code, $material_type, $keyword, $page, $this->user_per_page);
        $dataSearch = $this->Material_model->getMaterialList($sqlSearch);
        echo $dataSearch;
    }


    //获得目前数据库里的最高序列+1
    public function getMaterialCode()
    {
        $this->load->model('Material_model');
        $res = $this->Material_model->getMaterialCode() ? $this->Material_model->getMaterialCode() : 100000;
        echo $res;
    }

    public function getMaterialNameCode()
    {
        $this->load->model('Material_model');
        $res = $this->Material_model->getMaterialNameCode();
        echo $res;
    }


    public function materialUsage()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }
        $this->load->model('Building_model');
        $this->load->model('Material_model');

        $treeNav_data = $this->Building_model->getBuildingTreeData();

        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $material_type = $this->input->get('material_type');
        $keyword = $this->input->get('keyword');

        if ($material_type == 101) {
            $material_type_name = '工程物资';
        } elseif ($material_type == 102) {
            $material_type_name = '安防物资';
        } elseif ($material_type == 103) {
            $material_type_name = '消防物资';
        } elseif ($material_type == 104) {
            $material_type_name = '保洁物资';
        } elseif ($material_type == 105) {
            $material_type_name = '办公物资';
        } else {
            $material_type_name = '物资类别';
        }

        $page = $this->input->get('page');
        $page = $page ? $page : '1';

        //判断是普通查询还是搜索查询
        if (empty($parent_code) && empty($building_code) && empty($material_type) && empty($keyword)) {
            $total = $this->Material_model->getMaterialTotalbyNormal($this->user_per_page);
            $dataNormal['nav'] = 'materialList';
            $dataNormal['keyword'] = $keyword;
            $dataNormal['material_type'] = $material_type;
            $dataNormal['building_code'] = $building_code;
            $dataNormal['parent_code'] = $parent_code;
            $dataNormal['material_type_name'] = $material_type_name;
            $dataNormal['treeNav_data'] = $treeNav_data;
            $dataNormal['total'] = $total;
            $dataNormal['page'] = $page >= $total ? $total : $page;
            $dataNormal['pagesize'] = $this->user_per_page;
            $this->load->view('app/material_list', $dataNormal);
        } else {
            $total = $this->Material_model->getMaterialTotalbySearch($parent_code, $building_code, $material_type, $keyword, $this->user_per_page);

            $dataSearch['nav'] = 'materialList';
            $dataSearch['keyword'] = $keyword;
            $dataSearch['material_type'] = $material_type;
            $dataSearch['building_code'] = $building_code;
            $dataSearch['parent_code'] = $parent_code;
            $dataSearch['material_type_name'] = $material_type_name;
            $dataSearch['treeNav_data'] = $treeNav_data;
            $dataSearch['total'] = $total;
            $dataSearch['page'] = $page >= $total ? $total : $page;
            $dataSearch['pagesize'] = $this->user_per_page;
            $this->load->view('app/material_list', $dataSearch);
        }

    }
}
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

        $create_time=$this->input->get('create_time');
        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $create_type = $this->input->get('create_type');
        $order_kind=$this->input->get('order_kind');
        $keyword = $this->input->get('keyword');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';


        //判断是普通查询还是搜索查询
        if (empty($parent_code) && empty($building_code) && empty($create_type) && empty($keyword) && empty($create_time) && empty($order_kind)) {
            $total = $this->Workorder_model->getWorkorderListTotalbyNormal($this->user_per_page);
            $dataNormal['nav'] = 'workorderList';
            $dataNormal['keyword'] = $keyword;
            $dataNormal['create_type'] = $create_type;
            $dataNormal['order_kind'] = $order_kind;
            $dataNormal['building_code'] = $building_code;
            $dataNormal['parent_code'] = $parent_code;
            $dataNormal['create_time'] = $create_time;
            $dataNormal['username'] = $username;

            $dataNormal['treeNav_data'] = $treeNav_data;
            $dataNormal['total'] = $total;
            $dataNormal['page'] = $page >= $total ? $total : $page;
            $dataNormal['pagesize'] = $this->user_per_page;
            $this->load->view('app/workorder_list', $dataNormal);
        } else {
            $total = $this->Workorder_model->getWorkorderListTotalbySearch($create_time,$parent_code, $building_code, $create_type, $keyword, $order_kind,$this->user_per_page);
            $dataSearch['nav'] = 'workorderList';
            $dataSearch['keyword'] = $keyword;
            $dataSearch['create_type'] = $create_type;
            $dataSearch['order_kind'] = $order_kind;
            $dataSearch['building_code'] = $building_code;
            $dataSearch['parent_code'] = $parent_code;
            $dataSearch['create_time'] = $create_time;
            $dataSearch['username'] = $username;

            $dataSearch['treeNav_data'] = $treeNav_data;
            $dataSearch['total'] = $total;
            $dataSearch['page'] = $page >= $total ? $total : $page;
            $dataSearch['pagesize'] = $this->user_per_page;

            $this->load->view('app/workorder_list', $dataSearch);
        }

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
        $create_time=$this->input->get('create_time');
        $create_type = $this->input->get('create_type');
        $order_kind = $this->input->get('order_kind');
        //$keyword = $this->input->get('keyword');
        $keyword='';
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Workorder_model');

        $sqlSearch = $this->Workorder_model->getWorkorderListbySearch($create_time,$create_type, $order_kind, $keyword, $page, $this->user_per_page);
        $dataSearch = $this->Workorder_model->getWorkorderList($sqlSearch);
        echo $dataSearch;
    }


    public function getOrderRecordPerson()
    {
        $team_person_code = $this->input->post('team_person_code');
        $property_person_code = $this->input->post('property_person_code');
        $this->load->model('Workorder_model');
        $res = $this->Workorder_model->getOrderRecordPerson($team_person_code,$property_person_code);
        print_r(json_encode($res));

    }

    //动态获取所有楼宇信息
    public function getMaterialBuildingCode()
    {
        $this->load->model('Material_model');
        $res = $this->Material_model->getMaterialNameCode();
        echo $res;
    }


}
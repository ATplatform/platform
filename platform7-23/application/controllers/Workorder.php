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
        $this->at_url=$this->config->item('at_url');
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

        $village_id = $_SESSION['village_id'];
        $username=$_SESSION['username'];

        $treeNav_data = $this->Building_model->getBuildingTreeData($village_id);
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $create_time=$this->input->get('create_time');


        $create_type = $this->input->get('create_type');
        $order_type=$this->input->get('order_type');
        $keyword = $this->input->get('keyword');

        $data['nav'] = 'workorderList';
        $data['keyword'] = $keyword;
        $data['create_type'] = $create_type;
        $data['order_type'] = $order_type;
        $data['building_code'] = $building_code;
        $data['parent_code'] = $parent_code;
        $data['create_time'] = $create_time;
        $data['username'] = $username;
        $data['treeNav_data'] = $treeNav_data;
        $data['at_url']= $this->at_url;
        $total = $this->Workorder_model->getWorkorderListTotal($create_time,$parent_code, $building_code, $create_type, $keyword, $order_type,$this->user_per_page);
        $data['total'] = $total;
        $data['page'] = $page >= $total ? $total : $page;
        $data['pagesize'] = $this->user_per_page;
        $this->load->view('app/workorder_list', $data);
    }


    //////////////////////查询数据///////////////

    public function getWorkorderList()
    {
        $create_time=$this->input->get('create_time');
        $create_type = $this->input->get('create_type');
        $order_type = $this->input->get('order_type');
        $keyword = $this->input->get('keyword');

        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Workorder_model');

        $sql = $this->Workorder_model->sqlTogetWorkorderList($create_time,$create_type, $order_type, $keyword, $page, $this->user_per_page);
        $data = $this->Workorder_model->getWorkorderList($sql);

        echo $data;
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
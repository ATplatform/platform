<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract extends CI_Controller
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
        redirect('Contract/contractList');
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////contractList/////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////数据展示///////////////
    public function contractList()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }
        $this->load->model('Building_model');
        $this->load->model('Contract_model');

        $username=$_SESSION['username'];
        $username= $this->Contract_model->getUserName($username);
        $treeNav_data = $this->Building_model->getBuildingTreeData();

        $begin_date=$this->input->get('create_time');
        $parent_code = $this->input->get('parent_code');
        $building_code = $this->input->get('building_code');
        $type = $this->input->get('create_type');
        $level=$this->input->get('order_type');
        $keyword = $this->input->get('keyword');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $data['nav'] = 'contractList';
        $data['keyword'] = $keyword;
        $data['type'] = $type;
        $data['level'] = $level;
        $data['building_code'] = $building_code;
        $data['parent_code'] = $parent_code;
        $data['begin_date'] = $begin_date;
        $data['username'] = $username;
        $data['treeNav_data'] = $treeNav_data;
        $total = $this->Contract_model->getWorkorderListTotal($begin_date,$parent_code, $building_code, $type, $keyword, $level,$this->user_per_page);
        $data['total'] = $total;
        $data['page'] = $page >= $total ? $total : $page;
        $data['pagesize'] = $this->user_per_page;
        $this->load->view('app/contract_list', $data);
    }


    //////////////////////查询数据///////////////

    public function getWorkorderList()
    {
        $begin_date=$this->input->get('create_time');
        $type = $this->input->get('create_type');
        $level = $this->input->get('order_type');
        $keyword = $this->input->get('keyword');

        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Contract_model');

        $sql = $this->Contract_model->sqlTogetWorkorderList($begin_date,$type, $level, $keyword, $page, $this->user_per_page);
        $data = $this->Contract_model->getWorkorderList($sql);

        echo $data;
    }


    public function getOrderRecordPerson()
    {
        $team_person_code = $this->input->post('team_person_code');
        $property_person_code = $this->input->post('property_person_code');
        $this->load->model('Contract_model');
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
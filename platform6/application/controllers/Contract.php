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
        $this->load->model('Contract_model');

        $username=$_SESSION['username'];
        $username= $this->Contract_model->getUserName($username);


        $begin_date=$this->input->get('begin_date');
        $type = $this->input->get('type');
        $level=$this->input->get('level');
        $keyword = $this->input->get('keyword');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $data['nav'] = 'contractList';
        $data['keyword'] = $keyword;
        $data['type'] = $type;
        $data['level'] = $level;

        $data['begin_date'] = $begin_date;
        $data['username'] = $username;

        $total = $this->Contract_model->getContractListTotal($begin_date, $type, $keyword, $level,$this->user_per_page);
        $data['total'] = $total;
        $data['page'] = $page >= $total ? $total : $page;
        $data['pagesize'] = $this->user_per_page;
        $this->load->view('app/contract_list', $data);
    }


    //////////////////////查询数据///////////////

    public function getContractList()
    {
        $begin_date=$this->input->get('begin_date');
        $type = $this->input->get('type');
        $level = $this->input->get('level');
        $keyword = $this->input->get('keyword');

        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $this->load->model('Contract_model');

        $sql = $this->Contract_model->sqlTogetContractList($begin_date,$type, $level, $keyword, $page, $this->user_per_page);
        $data = $this->Contract_model->getContractList($sql);
        echo $data;
    }



    public function insert(){

            $code = $this->input->post('code');
            $type = $this->input->post('type');
            $level = $this->input->post('level');
            $signed_with=$this->input->post('signed_with');
            $amount=$this->input->post('amount');
        $position_code=$this->input->post('position_code');
            $begin_date=$this->input->post('begin_date');
            $end_date=$this->input->post('end_date');
            $remark = $this->input->post('remark');
            $create_time = date('Y-m-d h:i:s', time());
            $this->load->model('Contract_model');

         /*   $flag =$this->Material_model-> defineUsageEffective($material_code,$effective_date);
            if ($flag) {
                $data['message'] = '同一物资每天只能修改一次';
                $data['datebug']=true;
            } else {
                $data['datebug']=false;*/

                    $result=$this->Contract_model->insert($code,$type,$level,$signed_with,$amount, $position_code,$begin_date,$end_date,$remark,$create_time);


            $total = $this->Contract_model->getContractListTotal($begin_date,$type,'',$level,$this->user_per_page);
            $data['total'] = $total;
            print_r(json_encode($data));

    }



    public function getLatestCode()
    {
        $this->load->model('Contract_model');
        $res = $this->Contract_model->getLatestCode();
        echo $res;
    }

    public function getposition_code()
    {
        $this->load->model('Contract_model');
        $res = $this->Contract_model->getposition_code();
        print_r(json_encode($res));
    }

}
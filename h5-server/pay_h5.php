<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pay_h5 extends CI_Controller
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
        redirect('pay_h5/park_pay_h5');
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////workorderList/////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////数据展示///////////////
    public function index_h5()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/h5_pay/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $data['nav'] = 'pay_h5';
        $data['at_url']= $this->at_url;
        $this->load->view('app/h5_pay/index', $data);
    }

    public function property_h5()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/h5_pay/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $data['nav'] = 'pay_h5';
        $data['at_url']= $this->at_url;
        $this->load->view('app/h5_pay/property', $data);
    }


    public function property_record_h5()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/h5_pay/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $data['nav'] = 'pay_h5';
        $data['at_url']= $this->at_url;
        $this->load->view('app/h5_pay/property_record', $data);
    }

    public function car_h5()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/h5_pay/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $data['nav'] = 'pay_h5';
        $data['at_url']= $this->at_url;
        $this->load->view('app/h5_pay/h5', $data);
    }

    public function other_h5()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/h5_pay/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $data['nav'] = 'pay_h5';
        $data['at_url']= $this->at_url;
        $this->load->view('app/h5_pay/other', $data);
    }

    public function other_record_h5()
    {
        if (!isset($_SESSION['username'])) {
            redirect('Login');
        }

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/h5_pay/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $data['nav'] = 'pay_h5';
        $data['at_url']= $this->at_url;
        $this->load->view('app/h5_pay/other_record', $data);
    }
    //////////////////////查询数据///////////////

    public function bill_list()
    {
        $village_id=$this->input->post('village_id');
        $person_code=$this->input->post('person_code');

        $this->load->model('h5_pay_model');

        $sql = $this->h5_pay_model->bill_list_sql($person_code);
        $data = $this->h5_pay_model->getbill_list($sql);

        echo $data;
    }

    public function bill_list_record()
    {
        $village_id=$this->input->post('village_id');
        $person_code=$this->input->post('person_code');

        $this->load->model('h5_pay_model');

        $data = $this->h5_pay_model->getbill_list_record($person_code);

        echo $data;
    }

    public function bill_list_other()
    {
        $village_id=$this->input->post('village_id');
        $person_code=$this->input->post('person_code');

        $this->load->model('h5_pay_model');

        $data = $this->h5_pay_model->getbill_list_other($person_code);

        echo $data;
    }

    public function bill_list_other_record()
    {
        $village_id=$this->input->post('village_id');
        $person_code=$this->input->post('person_code');

        $this->load->model('h5_pay_model');

        $data = $this->h5_pay_model->getbill_list_other_record($person_code);

        echo $data;
    }


    public function get_park_car()
    {
        $village_id = $this->input->post('village_id');
        $bill_source_code = $this->input->post('bill_source_code');
        $this->load->model('h5_pay_model');
        $res = $this->h5_pay_model->get_park_car($bill_source_code,$village_id);
        print_r(json_encode($res));

    }

    public function get_car_service()
    {
        $village_id = $this->input->post('village_id');
        $bill_source_code = $this->input->post('bill_source_code');
        $this->load->model('h5_pay_model');
        $res = $this->h5_pay_model->get_car_service($bill_source_code,$village_id);
        print_r(json_encode($res));

    }

    public function get_all_park_car()
    {
        $village_id = $this->input->post('village_id');
        $person_code = $this->input->post('person_code');
        $this->load->model('h5_pay_model');
        $res = $this->h5_pay_model->get_all_park_car($person_code,$village_id);
        print_r(json_encode($res));

    }

    public function get_all_property()
    {
        $village_id = $this->input->post('village_id');
        $person_code = $this->input->post('person_code');
        $this->load->model('h5_pay_model');
        $res = $this->h5_pay_model->get_all_property($person_code,$village_id);
        print_r(json_encode($res));

    }


    public function get_all_service()
    {
        $village_id = $this->input->post('village_id');
        $person_code = $this->input->post('person_code');
        $this->load->model('h5_pay_model');
        $res = $this->h5_pay_model->get_all_service($person_code,$village_id);
        print_r(json_encode($res));

    }


    public function get_all_property_record()
    {
        $village_id = $this->input->post('village_id');
        $person_code = $this->input->post('person_code');
        $this->load->model('h5_pay_model');
        $res = $this->h5_pay_model->get_all_property_record($person_code,$village_id);
        print_r(json_encode($res));

    }




}
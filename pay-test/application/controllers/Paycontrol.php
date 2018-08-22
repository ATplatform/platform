<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paycontrol extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //打开重定向
        $this->load->helper('url');
        $this->load->database();
    }

    public function index()
    {
        $this->load->view('app/index.php');
    }



    public function property_h5()
    {
        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $basic_url=base_url().'application/views/app/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $this->load->view('app/property',$data);
    }


    public function property_record_h5()
    {

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $this->load->view('app/property_record', $data);
    }

    public function car_pay_h5()
    {

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $this->load->view('app/car_pay', $data);
    }




    public function car_pay_bill_h5()
    {

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $this->load->view('app/car_pay_bill', $data);
    }

    public function car_pay_record_h5()
    {

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $this->load->view('app/car_pay_record', $data);
    }



    public function other_h5()
    {

        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $page = $this->input->get('page');
        $page = $page ? $page : '1';
        $basic_url=base_url().'application/views/app/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $this->load->view('app/other', $data);
    }

    public function other_record_h5()
    {


        $username= $this->input->get('username');
        $village_id = $this->input->get('village_id');
        $person_code = $this->input->get('person_code');
        $basic_url=base_url().'application/views/app/';
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;
        $this->load->view('app/other_record', $data);
    }


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


public function get_car_list()
{
    $village_id = $this->input->post('village_id');
    $person_code = $this->input->post('person_code');
    $this->load->model('h5_pay_model');
    $res = $this->h5_pay_model->get_car_list($person_code,$village_id);
    print_r(json_encode($res));
}

}
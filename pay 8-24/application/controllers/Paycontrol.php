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

        $this->load->model('Paymodel');

        $sql = $this->Paymodel->bill_list_sql($person_code);
        $data = $this->Paymodel->getbill_list($sql);

        echo $data;
    }

    public function bill_list_record()
    {
        $village_id=$this->input->post('village_id');
        $person_code=$this->input->post('person_code');

        $this->load->model('Paymodel');

        $data = $this->Paymodel->getbill_list_record($person_code);

        echo $data;
    }

    public function bill_list_other()
    {
        $village_id=$this->input->post('village_id');
        $person_code=$this->input->post('person_code');

        $this->load->model('Paymodel');

        $data = $this->Paymodel->getbill_list_other($person_code);

        echo $data;
    }

    public function bill_list_other_record()
    {
        $village_id=$this->input->post('village_id');
        $person_code=$this->input->post('person_code');

        $this->load->model('Paymodel');

        $data = $this->Paymodel->getbill_list_other_record($person_code);

        echo $data;
    }


    public function get_park_car()
    {
        $village_id = $this->input->post('village_id');
        $bill_source_code = $this->input->post('bill_source_code');
        $this->load->model('Paymodel');
        $res = $this->Paymodel->get_park_car($bill_source_code,$village_id);
        print_r(json_encode($res));

    }

    public function get_car_service()
    {
        $village_id = $this->input->post('village_id');
        $bill_source_code = $this->input->post('bill_source_code');
        $this->load->model('Paymodel');
        $res = $this->Paymodel->get_car_service($bill_source_code,$village_id);
        print_r(json_encode($res));

    }

    public function get_all_park_car()
    {
        $village_id = $this->input->post('village_id');
        $person_code = $this->input->post('person_code');
        $this->load->model('Paymodel');
        $res = $this->Paymodel->get_all_park_car($person_code,$village_id);
        print_r(json_encode($res));

    }

    public function get_all_property()
    {
        $village_id = $this->input->post('village_id');
        $person_code = $this->input->post('person_code');
        $this->load->model('Paymodel');
        $res = $this->Paymodel->get_all_property($person_code,$village_id);
        print_r(json_encode($res));

    }


    public function get_all_service()
    {
        $village_id = $this->input->post('village_id');
        $person_code = $this->input->post('person_code');
        $this->load->model('Paymodel');
        $res = $this->Paymodel->get_all_service($person_code,$village_id);
        print_r(json_encode($res));

    }


    public function get_all_property_record()
    {
        $village_id = $this->input->post('village_id');
        $person_code = $this->input->post('person_code');
        $this->load->model('Paymodel');
        $res = $this->Paymodel->get_all_property_record($person_code,$village_id);
        print_r(json_encode($res));

    }


public function get_car_list()
{
    $village_id = $this->input->post('village_id');
    $person_code = $this->input->post('person_code');
    $this->load->model('Paymodel');
    $res = $this->Paymodel->get_car_list($person_code,$village_id);
    print_r(json_encode($res));
}


    public function park_lot()
    {
        $village_id = $this->input->post('village_id');

        $this->load->model('Paymodel');
        $res = $this->Paymodel->get_park_lot($village_id);
        print_r(json_encode($res));
    }


    public function park_pay_139()
    {


        $park_lot = $this->input->post('park_lot');
        $issued_time = date('Y-m-d H:i:s',time());
        $carNo = $this->input->post('carNo');
        $park_lot=(int)$park_lot;
        $post_data = array(
            'carNo'=>$carNo,
            'cmd'=>'js_createorder',
            'parkCode'=>$park_lot,
            'issued_time'=>$issued_time
        );

        $data_string =json_encode($post_data);

        $ch = curl_init('http://139.159.224.188/js/park_pay');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0); //强制协议为1.0

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect: ')); //头部要送出'Expect: '
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); //强制使用IPV4协议解析域名
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);
        echo $result;
    }

    public function park_pay_bill()
    {

        $username= $this->input->get('username');
        $village_id = $this->input->post('village_id');
        $park_lot=$this->input->post('park_lot');

        $this->load->model('Paymodel');
        $park_lot_name=$this->Paymodel->get_park_lot_name($park_lot,$village_id);
        $village_name=$this->Paymodel->get_village_name($village_id);


        $person_code = $this->input->get('person_code');

        $basic_url=base_url().'application/views/app/';
        $issued_time=$this->input->post('issued_time');
        $endTime = $this->input->post('endTime');
        $totalFee = $this->input->post('totalFee');
        $bill_code = $this->input->post('bill_code');
        $carNo=$this->input->post('carNo');



        $data['issued_time']=$issued_time;
        $data['endTime']=$endTime;
        $data['totalFee']=$totalFee;
        $data['bill_code']=$bill_code;
        $data['carNo']=$carNo;
        $data['park_lot']=$park_lot;
        $data['village_id']=$village_id;
        $data['park_lot_name']=$park_lot_name;
        $data['village_name']=$village_name;
        $data['person_code']=$person_code;
        $data['basic_url']=$basic_url;

        $this->load->view('app/car_pay_bill', $data);

    }



   /* public function send_post($url, $post_data) {
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/json',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }*/

}
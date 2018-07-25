<?phpdefined('BASEPATH') OR exit('No direct script access allowed');class Moneypay extends CI_Controller{    public function __construct()    {        parent::__construct();        session_start();        //打开重定向        $this->load->helper('url');        $this->load->database();        $this->user_per_page = $this->config->item('user_per_page');        $this->at_url=$this->config->item('at_url');    }    public function index()    {        if (!isset($_SESSION['username'])) {            redirect('Login');        }        redirect('Moneypay/property_fee');    }    /////////////////////////////////////////////////////////////////////////////////////////////////    ////////////////////////////////////////activityList/////////////////////////////////////////////    /////////////////////////////////////////////////////////////////////////////////////////////////    /////////////数据展示///////////////    public function property_fee()    {        if (!isset($_SESSION['username'])) {            redirect('Login');        }        $this->load->model('Moneypay_model');        $this->load->model('Building_model');        $village_id = $_SESSION['village_id'];        $username=$_SESSION['username'];        $treeNav_data = $this->Building_model->getBuildingTreeData($village_id);        $effective_date=$this->input->get('effective_date');        $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');        $if_standard = $this->input->get('property_if_standard');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $data['nav'] = 'property_fee';        $data['username'] = $username;        $data['at_url']= $this->at_url;        $data['treeNav_data'] = $treeNav_data;        $arrayres = $this->Moneypay_model->sqlTogetList_property_fee($if_standard,$building_code, $parent_code,$keyword, $page, $this->user_per_page);        $total = $this->Moneypay_model->getTotal($arrayres['0'],$this->user_per_page);        $data['total'] = $total;        $data['page'] = $page >= $total ? $total : $page;        $data['pagesize'] = $this->user_per_page;        $this->load->view('app/property_fee', $data);    }    //////////////////////查询数据///////////////    public function getList()    {        $rent_end_date=$this->input->get('rent_end_date');        $parklot_parkcode = $this->input->get('parklot_parkcode');        $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $this->load->model('Parkrent_model');        $arrayres = $this->Parkrent_model->sqlTogetList($rent_end_date,$parklot_parkcode, $keyword, $page, $this->user_per_page);        $data = $this->Parkrent_model->getList($arrayres['1']);        echo $data;    }    public function update(){        $village_id = $_SESSION['village_id'];        $rent_id = $this->input->post('rent_id');        $rent_begin_date = $this->input->post('rent_begin_date');        $rent_end_date = $this->input->post('rent_end_date');        $rent_pay_type = $this->input->post('rent_pay_type');        $rent_rent = $this->input->post('rent_rent');        $rent_renter = $this->input->post('rent_renter');        $rent_parking_lot_code = $this->input->post('rent_parking_lot_code');        $create_time = date('Y-m-d h:i:s', time());        $this->load->model('Parkrent_model');        $this->Parkrent_model->update($village_id,$rent_id,$rent_begin_date,$rent_end_date,$rent_pay_type,$rent_rent, $rent_renter,$rent_parking_lot_code,$create_time);    }    public function insert(){        $village_id = $_SESSION['village_id'];            $rent_id = $this->input->post('rent_id');$rent_begin_date = $this->input->post('rent_begin_date');    $rent_end_date = $this->input->post('rent_end_date');$rent_pay_type = $this->input->post('rent_pay_type');$rent_rent = $this->input->post('rent_rent');$rent_renter = $this->input->post('rent_renter');$rent_parking_lot_code = $this->input->post('rent_parking_lot_code');            $create_time = date('Y-m-d h:i:s', time());            $this->load->model('Parkrent_model');        $this->Parkrent_model->insert($village_id,$rent_id,$rent_begin_date,$rent_end_date,$rent_pay_type,$rent_rent, $rent_renter,$rent_parking_lot_code,$create_time);    }    public function getparking_lot_code(){        $this->load->model('Parkrent_model');        $floor=$this->input->post('floor');        $parkcode=$this->input->post('parkcode');        $res = $this->Parkrent_model->getparking_lot_code($floor,$parkcode);        print_r(json_encode($res));    }    public function getfloor(){        $this->load->model('Parkrent_model');        $res = $this->Parkrent_model->getfloor();        print_r(json_encode($res));    }    public function getLatestCode()    {        $this->load->model('Parkrent_model');        $res = $this->Parkrent_model->getLatestCode();        echo $res;    }    public function getLatestCodeforauz()    {        $this->load->model('Vehicle_model');        $res = $this->Vehicle_model->getLatestCodeforauz();        echo $res;    }    public function getpresentCodeforauz()    {        $code=$this->input->post('code');        $this->load->model('Vehicle_model');        $res = $this->Vehicle_model->getpresentCodeforauz($code);        print_r(json_encode($res));    } public function getservice_code(){     $this->load->model('Activity_model');     $res = $this->Activity_model->getservice_code();     print_r(json_encode($res)); }public function getperson_code(){    $this->load->model('Parkrent_model');    $res = $this->Parkrent_model->getperson_code();    print_r(json_encode($res));}    public function getactivity_codeUrl(){        $this->load->model('Activity_model');        $res = $this->Activity_model->getactivity_codeUrl();        print_r(json_encode($res));    }    public function getparkingcode()    {        $this->load->model('Vehicle_model');        $res = $this->Vehicle_model->getparkingcode();        print_r(json_encode($res));    }    public function pkg_fee()    {        if (!isset($_SESSION['username'])) {            redirect('Login');        }        $this->load->model('Moneypay_model');        $this->load->model('Building_model');        $village_id = $_SESSION['village_id'];        $username=$_SESSION['username'];        $treeNav_data=$this->Building_model->getBuildingTreeData($village_id);        $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');        $effective_date=$this->input->get('pkg_effective_date');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $data['nav'] = 'pkg_fee';        $data['username'] = $username;        $data['at_url']= $this->at_url;        $data['treeNav_data'] = $treeNav_data;        $arrayres = $this->Moneypay_model->sqlTogetList_pkg_fee($effective_date,$keyword, $page, $this->user_per_page);        $total = $this->Moneypay_model->getTotal($arrayres['0'],$this->user_per_page);        $data['total'] = $total;        $data['page'] = $page >= $total ? $total : $page;        $data['pagesize'] = $this->user_per_page;        $this->load->view('app/pkg_s_fee', $data);    }    public function getList_pkg_fee(){        $effective_date=$this->input->get('pkg_effective_date');        $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $this->load->model('Moneypay_model');        $arrayres = $this->Moneypay_model->sqlTogetList_pkg_fee($effective_date,$keyword, $page, $this->user_per_page);        $data = $this->Moneypay_model->getList_pkg_fee($arrayres['1']);        echo $data;    }    public function water_fee()    {        if (!isset($_SESSION['username'])) {            redirect('Login');        }        $this->load->model('Moneypay_model');        $this->load->model('Building_model');        $village_id = $_SESSION['village_id'];        $username=$_SESSION['username'];        $treeNav_data=$this->Building_model->getBuildingTreeData($village_id);        $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');        $effective_date=$this->input->get('effective_date');        $parklot_parkcode = $this->input->get('parklot_parkcode');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $data['nav'] = 'water_fee';        $data['username'] = $username;        $data['at_url']= $this->at_url;        $data['treeNav_data'] = $treeNav_data;        $arrayres = $this->Moneypay_model->sqlTogetList_water_fee($effective_date,$keyword, $page, $this->user_per_page);        $total = $this->Moneypay_model->getTotal($arrayres['0'],$this->user_per_page);        $data['total'] = $total;        $data['page'] = $page >= $total ? $total : $page;        $data['pagesize'] = $this->user_per_page;        $this->load->view('app/water_fee', $data);    }    public function service_fee()    {        if (!isset($_SESSION['username'])) {            redirect('Login');        }        $this->load->model('Moneypay_model');        $this->load->model('Building_model');        $village_id = $_SESSION['village_id'];        $username=$_SESSION['username'];        $treeNav_data=$this->Building_model->getBuildingTreeData($village_id);        $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');        $service_type = $this->input->get('service_type');        $effective_date=$this->input->get('service_change_date');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $data['nav'] = 'service_fee';        $data['username'] = $username;        $data['at_url']= $this->at_url;        $data['treeNav_data'] = $treeNav_data;        $arrayres = $this->Moneypay_model->sqlTogetList_service_fee($service_type,$effective_date,$keyword, $page, $this->user_per_page);        $total = $this->Moneypay_model->getTotal($arrayres['0'],$this->user_per_page);        $data['total'] = $total;        $data['page'] = $page >= $total ? $total : $page;        $data['pagesize'] = $this->user_per_page;        $this->load->view('app/service_fee', $data);    }    public function order_fee()    {        if (!isset($_SESSION['username'])) {            redirect('Login');        }        $this->load->model('Moneypay_model');        $this->load->model('Building_model');        $village_id = $_SESSION['village_id'];        $username=$_SESSION['username'];        $treeNav_data=$this->Building_model->getBuildingTreeData($village_id);        $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');        $begin_date=$this->input->get('order_begin_date');        $end_date=$this->input->get('order_end_date');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $data['nav'] = 'order_fee';        $data['username'] = $username;        $data['at_url']= $this->at_url;        $data['treeNav_data'] = $treeNav_data;        $arrayres = $this->Moneypay_model->sqlTogetList_order_fee($begin_date,$end_date,$keyword,$page, $this->user_per_page);        $total = $this->Moneypay_model->getTotal($arrayres['0'],$this->user_per_page);        $data['total'] = $total;        $data['page'] = $page >= $total ? $total : $page;        $data['pagesize'] = $this->user_per_page;        $this->load->view('app/order_fee', $data);    }    public function getList_water_fee(){        $effective_date=$this->input->get('effective_date');        $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $this->load->model('Moneypay_model');        $arrayres = $this->Moneypay_model->sqlTogetList_water_fee($effective_date,$keyword, $page, $this->user_per_page);        $data = $this->Moneypay_model->getList_water_fee($arrayres['1']);        echo $data;    }    public function getList_property_fee(){        $effective_date=$this->input->get('effective_date');        $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');        $if_standard = $this->input->get('property_if_standard');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $this->load->model('Moneypay_model');        $arrayres = $this->Moneypay_model->sqlTogetList_property_fee($if_standard,$building_code, $parent_code,$keyword, $page, $this->user_per_page);        $data = $this->Moneypay_model->getList_property_fee($arrayres['1']);        echo $data;    }    public function getList_service_fee(){       /* $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');*/        $service_type = $this->input->get('service_type');        $effective_date=$this->input->get('service_change_date');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $this->load->model('Moneypay_model');        $arrayres = $this->Moneypay_model->sqlTogetList_service_fee($service_type,$effective_date,$keyword, $page, $this->user_per_page);        $data = $this->Moneypay_model->getList_service_fee($arrayres['1']);        echo $data;    }    public function getList_order_fee(){        $effective_date=$this->input->get('effective_date');        $building_code = $this->input->get('building_code');        $parent_code = $this->input->get('parent_code');        $begin_date=$this->input->get('order_begin_date');        $end_date=$this->input->get('order_end_date');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $this->load->model('Moneypay_model');        $arrayres = $this->Moneypay_model->sqlTogetList_order_fee($begin_date,$end_date,$keyword,$page, $this->user_per_page);        $data = $this->Moneypay_model->getList_order_fee($arrayres['1']);        echo $data;    }    public function update_property(){        $village_id = $_SESSION['village_id'];        $building_code = $this->input->post('building_code');        $ppe_payable= $this->input->post('ppe_payable');        $change_reason = $this->input->post('change_reason');        $if_standard_date = $this->input->post('if_standard_date');        $if_standard = $this->input->post('if_standard');        $this->load->model('Moneypay_model');        $this->Moneypay_model->update_property($building_code,$ppe_payable,$change_reason,$if_standard_date,$if_standard);    }    public function getbuilding_type(){        $building_type = $this->input->post('building_type');        $this->load->model('Moneypay_model');        $res=$this->Moneypay_model->getbuilding_type($building_type);        print_r(json_encode($res));    }    public function getbiz_type(){        $biz_type = $this->input->post('biz_type');        $this->load->model('Moneypay_model');        $res=$this->Moneypay_model->getbiz_type($biz_type);        print_r(json_encode($res));    }    public function getwater(){        $this->load->model('Moneypay_model');        $res=$this->Moneypay_model->getwater();        print_r(json_encode($res));    }    public function change_history(){        $building_type = $this->input->get('building_type');        $this->load->model('Moneypay_model');        $res=$this->Moneypay_model->change_history($building_type);        print_r(json_encode($res));    }    public function change_history_pkg_fee(){        $biz_type = $this->input->get('biz_type');        $this->load->model('Moneypay_model');        $res=$this->Moneypay_model->change_history_pkg_fee($biz_type);        print_r(json_encode($res));    }    public function change_history_water_fee(){        $this->load->model('Moneypay_model');        $res=$this->Moneypay_model->change_history_water_fee();        print_r(json_encode($res));    }    public function insert_property(){        $building_type = $this->input->post('building_type');        $change_date = $this->input->post('change_date');        $fee_standard = $this->input->post('fee_standard');        $this->load->model('Moneypay_model');        $code=$this->Moneypay_model->getLatestCode('village_type_ppe_fee');        $code=$code?$code+1:1000001;        $res=$this->Moneypay_model->insert_property($code,$building_type,$change_date,$fee_standard);        print_r(json_encode($res));    }    public function insert_pkg_fee(){        $biz_type = $this->input->post('biz_type');        $change_date = $this->input->post('change_date');        $fee_standard = $this->input->post('fee_standard');        $this->load->model('Moneypay_model');        $code=$this->Moneypay_model->getLatestCode('village_pkg_s_fee');        $code=$code?$code+1:1000001;        $res=$this->Moneypay_model->insert_pkg_fee($code,$biz_type,$change_date,$fee_standard);        print_r(json_encode($res));    }    public function insert_water_fee(){        $change_date = $this->input->post('change_date');        $fee_standard = $this->input->post('fee_standard');        $this->load->model('Moneypay_model');        $code=$this->Moneypay_model->getLatestCode('village_water_fee');        $code=$code?$code+1:1000001;        $res=$this->Moneypay_model->insert_water_fee($code,$change_date,$fee_standard);        print_r(json_encode($res));    }}
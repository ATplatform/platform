<?phpinclude(APPPATH.'/libraries/include/phpqrcode/qrlib.php');defined('BASEPATH') OR exit('No direct script access allowed');class Activity extends CI_Controller{    public function __construct()    {        parent::__construct();        session_start();        //打开重定向        $this->load->helper('url');        $this->load->database();        $this->user_per_page = $this->config->item('user_per_page');    }    public function index()    {        if (!isset($_SESSION['username'])) {            redirect('Login');        }        redirect('Activity/activityList');    }    /////////////////////////////////////////////////////////////////////////////////////////////////    ////////////////////////////////////////activityList/////////////////////////////////////////////    /////////////////////////////////////////////////////////////////////////////////////////////////    /////////////数据展示///////////////    public function activityList()    {        if (!isset($_SESSION['username'])) {            redirect('Login');        }        $this->load->model('Activity_model');        $username=$_SESSION['username'];        $username= $this->Activity_model->getUserName($username);        $begin_date=$this->input->get('begin_date');        $type = $this->input->get('type');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $data['nav'] = 'activityList';        $data['username'] = $username;        $sql = $this->Activity_model->sqlTogetList($begin_date,$type, $keyword, $page, $this->user_per_page);        $total = $this->Activity_model->getListTotal($sql,$this->user_per_page);        $data['total'] = $total;        $data['page'] = $page >= $total ? $total : $page;        $data['pagesize'] = $this->user_per_page;        $this->load->view('app/activity_list', $data);    }    //////////////////////查询数据///////////////    public function getList()    {        $begin_date=$this->input->get('begin_date');        $type = $this->input->get('type');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $this->load->model('Activity_model');        $sql = $this->Activity_model->sqlTogetList($begin_date,$type, $keyword, $page, $this->user_per_page);        $data = $this->Activity_model->getList($sql);        echo $data;    }    public function insert(){            $code = $this->input->post('code');            $type = $this->input->post('type');            $name=$this->input->post('name');            $person_code=$this->input->post('person_code');            $service_code=$this->input->post('service_code');            $begin_date=$this->input->post('begin_date');            $end_date=$this->input->post('end_date');            $create_time = date('Y-m-d h:i:s', time());            $this->load->model('Activity_model');         $this->Activity_model->insert($code,$type,$name,$person_code,$service_code, $begin_date,$end_date,$create_time);            //新增成功后,生成一张二维码图片            //得到楼宇信息            $this->load->model('Building_model');            //$building = $this->Building_model->getBuilding($building_code);           // $householdInfo = $this->Building_model->getHouseholdInfo($building);            // echo $householdInfo;exit;            //根据设备类型得到设备类型名称            //二维码名称            $fileName = $code.$name.'.png';            //二维码图片地址            $village_id = "100001";            $village_name = "和正智汇谷";            $temp_path='qrcode/'.$village_id.$village_name.'活动二维码/';            //二维码内容,设备的二维码type为101,village暂时写为100001            $this->load->model('Building_model');            $qrcodeData = $this->Building_model->getQrcodeData(101,100001,$code);            //生成二维码图片            $this->Building_model->setQRcode($qrcodeData,$temp_path,$fileName);    }    public function getLatestCode()    {        $this->load->model('Activity_model');        $res = $this->Activity_model->getLatestCode();        echo $res;    } public function getservice_code(){     $this->load->model('Activity_model');     $res = $this->Activity_model->getservice_code();     print_r(json_encode($res)); }    public function getactivity_codeUrl(){        $this->load->model('Activity_model');        $res = $this->Activity_model->getactivity_codeUrl();        print_r(json_encode($res));    }    //////////////////////////////////////////////////////////////////////////////////////////    public function activityRecord()    {        if (!isset($_SESSION['username'])) {            redirect('Login');        }        $this->load->model('Activity_model');        $username=$_SESSION['username'];        $username= $this->Activity_model->getUserName($username);        $data['nav'] = 'activityRecord';        $date=$this->input->get('date');        $type = $this->input->get('type');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $data['keyword'] = $keyword;        $data['type'] = $type;        $data['date'] = $date;        $data['username'] = $username;        $sql = $this->Activity_model->sqlTogetRecord($date,$type, $keyword, $page, $this->user_per_page);        $total = $this->Activity_model->getRecordTotal($sql,$this->user_per_page);        $data['total'] = $total;        $data['page'] = $page >= $total ? $total : $page;        $data['pagesize'] = $this->user_per_page;        $this->load->view('app/activity_record', $data);    }    public function getRecord()    {        $date=$this->input->get('date');        $type = $this->input->get('type');        $keyword = $this->input->get('keyword');        $page = $this->input->get('page');        $page = $page ? $page : '1';        $this->load->model('Activity_model');        $sql = $this->Activity_model->sqlTogetRecord($date,$type, $keyword, $page, $this->user_per_page);        $data = $this->Activity_model->getRecord($sql);        echo $data;    }    public function insertRecord(){        $code = $this->input->post('code');        $person_code=$this->input->post('person_code');        $service_code=$this->input->post('service_code');        $date=$this->input->post('date');        $create_time = date('Y-m-d h:i:s', time());        $this->load->model('Activity_model');        $this->Activity_model->insertRecord($code,$person_code,$service_code, $date,$create_time);    }}
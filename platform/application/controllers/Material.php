<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller{
	public function __construct(){
		parent::__construct();
		session_start();
		//打开重定向
		$this->load->helper('url');
		$this->load->database();
		$this->user_per_page=$this->config->item('user_per_page');
	}

	public function index(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}
		redirect('Material/materialList');
	}


	//php->js&html
	public function materialList(){
		if ( !isset($_SESSION['username']) ) {
		   redirect('Login');
		}




        $this->load->model('Building_model');
        $treeNav_data = $this->Building_model->getBuildingTreeData();
        $parent_code=$this->input->get('parent_code');
        $building_code=$this->input->get('building_code');
        $material_type=$this->input->get('material_type');
        $keyword = $this->input->get('keyword');
		$page = $this->input->get('page');
        $page = $page?$page:'1';
		$this->load->model('Material_model');
		$total=$this->Material_model->getMaterialTotal($parent_code,$building_code,$material_type,$keyword,$this->user_per_page);
        $data['nav'] = 'materialList';
        $data['keyword']=$keyword;
        $data['material_type']=$material_type;
        $data['building_code']=$building_code;
        $data['parent_code']=$parent_code;
        if($material_type==101){$material_type_name='工程物资';}
        elseif($material_type==102){$material_type_name='安防物资';}
        elseif($material_type==103){$material_type_name='消防物资';}
        elseif($material_type==104){$material_type_name='保洁物资';}
        elseif($material_type==105){$material_type_name='办公物资';}
        else{$material_type_name='物资类别';}
        $data['material_type_name']=$material_type_name;
        $data['treeNav_data']=$treeNav_data;
        $data['total']=$total;
        $data['page']=$page>=$total?$total:$page;
		$data['pagesize']=$this->user_per_page;
        $this->load->model('Material_model');
		$this->load->view('app/material_list',$data);
	}

	//js&html ->php
    public function getMaterialList(){
        $page = $this->input->get('page');
        $keyword = $this->input->get('keyword');
        $material_type=$this->input->get('material_type');
        $building_code=$this->input->get('building_code');
        $parent_code=$this->input->get('parent_code');
        $this->load->model('Material_model');
        $page = $page?$page:'1';
        $data = $this->Material_model->getMaterialList($parent_code,$building_code,$material_type,$keyword,$page,$this->user_per_page);

        echo $data;
    }


    public function SearchMaterialList(){
        $page = $this->input->get('page');
        $keyword = $this->input->get('keyword');


        $this->load->model('Material_model');
        $page = $page?$page:'1';
        $data = $this->Material_model->getMaterialList($keyword,$page,$this->user_per_page);

        echo $data;
    }







    public function insertMaterial(){
	    //收集数据
        $create_time = date('Y-m-d h:i:s',time());
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
        $keyword='';
        $territorys = $this->input->post('territorys');

        $this->load->model('Material_model');


        //查到父节点的level_type,在此基础上加1,
        //$parent_material = $this->Material_model->getMaterialByCode($parent_code);
        //$parent_material_type =$parent_material['material_type'];
        //$material_type = $parent_material_type + 1;
        //$code,$effective_date,$effective_status,$name,$pcs,$material_type,$building_code,$supplier,$now,$internal_no,$initial_no, $remark
        $res = $this->Material_model->insertMaterial($code,$effective_date,$effective_status,$name,$pcs,$material_type,$building_code,$supplier,$internal_no,$initial_no,$remark,$create_time);

        if($res){
            $data['message'] = '新增物资成功';
        }
        else {
            $data['message'] = '新增物资失败';
        }

        $total=$this->Material_model->getMaterialTotal(null,null,'',$this->user_per_page );
        $data['total'] = $total;

        print_r(json_encode($data));
    }



    //获得目前数据库里的最高序列+1
    public function getMaterialCode(){
        $this->load->model('Material_model');
        $res = $this->Material_model->getMaterialCode()? $this->Material_model->getMaterialCode():100000;

        echo $res;
    }

    public function getMaterialNameCode(){
        $this->load->model('Material_model');
        $res = $this->Material_model->getMaterialNameCode();
        echo $res;
    }





public function materialUsage(){
    if ( !isset($_SESSION['username']) ) {
        redirect('Login');
    }
    $this->load->model('Building_model');
    $treeNav_data = $this->Building_model->getBuildingTreeData();
    $building_code=$this->input->get('building_code');
    $material_type=$this->input->get('material_type');
    $keyword = $this->input->get('keyword');
    $page = $this->input->get('page');
    $page = $page?$page:'1';
    $this->load->model('Material_model');
    $total=$this->Material_model->getMaterialTotal($building_code,$material_type,$keyword,$this->user_per_page);
    $data['nav'] = 'materialUsage';
    $data['keyword']=$keyword;
    $data['material_type']=$material_type;
    $data['building_code']=$building_code;
    if($material_type==101){$material_type_name='工程物资';}
    elseif($material_type==102){$material_type_name='安防物资';}
    elseif($material_type==103){$material_type_name='消防物资';}
    elseif($material_type==104){$material_type_name='保洁物资';}
    elseif($material_type==105){$material_type_name='办公物资';}
    else{$material_type_name='物资类别';}
    $data['material_type_name']=$material_type_name;
    $data['treeNav_data']=$treeNav_data;
    $data['total']=$total;
    $data['page']=$page>=$total?$total:$page;
    $data['pagesize']=$this->user_per_page;
    $this->load->model('Material_model');
    $this->load->view('app/material_usage',$data);
}










}
<?php
class Login_model extends CI_Model {

    public function __construct()
    {
    	parent::__construct();
        $this->load->database();
    }

    public function verify_user($username,$password)
    {
        $sql = "select count(*) as count from admin_login where name=? and password=md5(?)";
		$query = $this->db->query($sql,array($username, $password)); //自动转义
        $row = $query ->row();
    	if($row->count>0)
        {
            return true;
        }
        else
        {
            return false;
        } 
    }
}
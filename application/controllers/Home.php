<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
		function __construct() {
			 parent::__construct();
			    $this->load->helper('url');
			    $this->load->library('session');
				$this->load->model('loginmodel');
				// $this->load->model('usermodel');
	 }

	public function index()	{
		$this->load->view('index');
	}



	public function dashboard(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		// print_r($data);exit;
		if($user_type=='1'){
			$this->load->view('admin/admin_header');
			$this->load->view('admin/dashboard');
			$this->load->view('admin/admin_footer');
		}else if ($user_type=='2'){
			$this->load->view('site_header');
			$this->load->view('dashboard',$data);
			$this->load->view('site_footer');
		} else {
			 redirect('/login');
		}

	}

	public function profile(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1 || $user_type==2){
		  $data['res']=$this->loginmodel->get_user_info($user_id);
			$this->load->view('admin/admin_header');
			$this->load->view('admin/profile',$data);
			$this->load->view('admin/admin_footer');
		}else{

		}

	}

	public function change_password(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1 || $user_type==2){
			$this->load->view('admin/admin_header');
			$this->load->view('admin/change_password',$data);
			$this->load->view('admin/admin_footer');
		}else{
			redirect('/');
		}

	}



	public function check_login(){
		$password=md5($this->db->escape_str($this->input->post('password')));
		$username=$this->db->escape_str($this->input->post('username'));
		$data['res']=$this->loginmodel->check_login($username,$password);
		echo json_encode($data['res']);
	}
	public function forgot_password(){
		$email=$this->db->escape_str($this->input->post('email'));
		$data['res']=$this->loginmodel->forgot_password($email);
		echo json_encode($data['res']);
	}



	public function create_staff(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1 || $user_type==2){
			$this->load->view('admin/admin_header');
			$this->load->view('admin/staff/create',$data);
			$this->load->view('admin/admin_footer');
		}else{
			redirect('/');
		}

	}

	public function get_all_staff(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1){
			$data['res']=$this->loginmodel->get_all_staff();
			$this->load->view('admin/admin_header');
			$this->load->view('admin/staff/view_staff',$data);
			$this->load->view('admin/admin_footer');
		}else{
			redirect('/');
		}

	}

	public function get_register_staff(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1 || $user_type==2){
		$name=$this->db->escape_str($this->input->post('name'));
		$email=$this->db->escape_str($this->input->post('email'));
		$phone=$this->db->escape_str($this->input->post('phone'));
		$username=$this->db->escape_str($this->input->post('username'));
		$city=$this->db->escape_str($this->input->post('city'));
		$address=$this->db->escape_str($this->input->post('address'));
		$gender=$this->db->escape_str($this->input->post('gender'));
		$status=$this->db->escape_str($this->input->post('status'));
		$data['res']=$this->loginmodel->get_register_staff($name,$email,$phone,$username,$city,$address,$gender,$status,$user_id);
		echo json_encode($data['res']);
		}else{
			redirect('/');
		}
		}

		public function get_staff_details(){
			$data=$this->session->userdata();
			$user_id=$this->session->userdata('user_id');
			$user_type=$this->session->userdata('user_role');
			if($user_type== 1){
				$staff_id=$this->uri->segment(3);
				$data['res']=$this->loginmodel->get_staff_details($staff_id);
				$this->load->view('admin/admin_header');
				$this->load->view('admin/staff/edit_staff',$data);
				$this->load->view('admin/admin_footer');
			}else{
				redirect('/');
			}

		}





	public function update_profile(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1){
		$email=$this->db->escape_str($this->input->post('email'));
		$phone=$this->db->escape_str($this->input->post('phone'));
		$name=$this->db->escape_str($this->input->post('name'));
		$city=$this->db->escape_str($this->input->post('city'));
		$address=$this->db->escape_str($this->input->post('address'));
		$gender=$this->db->escape_str($this->input->post('gender'));
		$data['res']=$this->loginmodel->update_profile($email,$phone,$name,$city,$address,$gender,$user_id);
		echo json_encode($data['res']);
		}else{

		}
	}

	public function update_password(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1 || $user_type==2){
		$current_password=$this->db->escape_str($this->input->post('current_password'));
		$new_password=$this->db->escape_str($this->input->post('new_password'));
		$confrim_password=$this->db->escape_str($this->input->post('confrim_password'));
		$data['res']=$this->loginmodel->update_password($current_password,$new_password,$confrim_password,$user_id);
		echo json_encode($data['res']);
		}else{

		}
	}

	public function checkphone(){
		$phone=$this->input->post('phone');
		$data=$this->loginmodel->checkphone($phone);
	}

	public function checkemail(){
		$email=$this->input->post('email');
		$data=$this->loginmodel->checkemail($email);
	}

	public function checkusername(){
		$username=$this->input->post('username');
		$data=$this->loginmodel->checkusername($username);
	}

	public function check_email_exist(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1){
			$email=$this->input->post('email');
			$data=$this->loginmodel->check_email_exist($email,$user_id);
		}
	}

	public function check_phone_exist(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1){
			$phone=$this->input->post('phone');
			$data=$this->loginmodel->check_phone_exist($phone,$user_id);
		}
	}



	public function check_staff_email_exist(){

		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1){
			$id=$this->uri->segment(3);
			$email=$this->input->post('email');
			$data=$this->loginmodel->check_staff_email_exist($email,$id);
		}
	}

	public function check_staff_phone_exist(){

		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1){
			$phone=$this->input->post('phone');
			$id=$this->uri->segment(3);
			$data=$this->loginmodel->check_staff_phone_exist($phone,$id);
		}
	}

	public function update_staff_profile(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1){
		$email=$this->db->escape_str($this->input->post('email'));
		$phone=$this->db->escape_str($this->input->post('phone'));
		$name=$this->db->escape_str($this->input->post('name'));
		$city=$this->db->escape_str($this->input->post('city'));
		$address=$this->db->escape_str($this->input->post('address'));
		$gender=$this->db->escape_str($this->input->post('gender'));
		$id=$this->db->escape_str($this->input->post('id'));
		$status=$this->db->escape_str($this->input->post('status'));
		$data['res']=$this->loginmodel->update_staff_profile($email,$phone,$name,$city,$address,$gender,$user_id,$id,$status);
		echo json_encode($data['res']);
		}else{

		}
	}

	public function check_current_password(){
		$data=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_role');
		if($user_type== 1 || $user_type==2){
		$current_password=md5($this->input->post('current_password'));
		$data=$this->loginmodel->check_current_password($current_password,$user_id);
		}else{

	}
	}



	public function emailverfiy(){
		$email = $this->uri->segment(3);
		$data['res']=$this->loginmodel->email_verify($email);
		if($data['res']['msg']=='verify'){
				$this->load->view('site_header');
				$this->load->view('email_verify',$data);
				$this->load->view('site_footer');
			}else{
				$this->load->view('site_header');
				$this->load->view('email_verify',$data);
				$this->load->view('site_footer');
		}
	}

	public function logout(){
		$datas=$this->session->userdata();
		$this->session->unset_userdata($datas);
		$this->session->sess_destroy();
		redirect('/');
	}


}
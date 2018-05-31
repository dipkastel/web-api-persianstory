<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class JsonProfile extends CI_Controller {
	public function __construct(){
        parent::__construct();
		date_default_timezone_set("Asia/Tehran");
		$this->load->model(array('model_json'));
    }

	public function index()
	{

	}

	public function register()
	{


		$this->load->model('user_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('u', 'نام کاربری', 'trim|required|alpha_numeric|min_length[3]|is_unique[tg_client.username]', array('is_unique' => 'نام کاربری انتخاب شده قبلا توسط شخص دیگری استفاده شده است'));
		$this->form_validation->set_rules('email', 'ایمیل', 'trim|required|valid_email|is_unique[tg_client.email]',array('is_unique' => 'این ایمیل قبلا در سیستم به ثبت رسیده'));
		$this->form_validation->set_rules('h', 'رمز عبور', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('hh', 'تکرار رمز عبور', 'trim|required|min_length[4]|matches[h]');
		$this->form_validation->set_rules('a', 'key', 'trim|required|min_length[2]|is_unique[tg_client.imei]', array('is_unique' => 'این دستگاه قبلا در سیستم ثبت شده است / وارد حساب شوید'));
		if ($this->form_validation->run() === false) {
					$return = str_replace('<p>','',validation_errors());
					$return = str_replace('</p>','',$return);
					echo $return;
		} else {
			$username = $this->input->post('u');
			$email    = $this->input->post('email');
			$password = $this->input->post('h');
			$imei = $this->input->post('a');
			
			 $config = Array(
					 'protocol' => 'smtp',
					 'smtp_host' => 'cpanel.serverdns.biz',
					 'smtp_port' => 465,
					 'smtp_crypto' => 'ssl',
					 'newline' => '\r\n',
					 'smtp_user' => 'info@bahar.persianstory.ir', // change it to yours
					 'smtp_pass' => '1qaz2wsxC', // change it to yours
					 'mailtype' => 'html',
					 'charset' => 'utf-8',
					 'wordwrap' => TRUE
				); 
				$this->load->library('email', $config);
				$this->email->from('info@bahar.persianstory.ir', 'قصه های بهار');
				$this->email->to($email);
				$this->email->subject('ثبت نام قصه های بهار');
				$this->email->message('<html><p style="direction:rtl;text-align:right;font:11px tahoma;">با تشکر از ثبت نام در برنامه قصه های بهار .<br/> حساب شما در سیستم ثبت شده و میتوانید از تمام امکانات برنامه استفاده کنید .<br/> اطلاعات حساب شما : <br/> نام کاربری : ' . $username.'<br/> رمز عبور : ' .$password .' <br/> در صورت وجود هرگونه سوال میتوانید با ایمیل زیر با ما در تماس باشید : <br/>info@bahar.persianstory.ir</p></html>');				
			if ($this->user_model->create_user_mob($username, $email, $password,$imei) && $this->email->send()) {
				
				echo "true";
				
			} else {
				echo 'There was a problem creating your new account. Please try again.';
			}
		}
	}
	
	
	
	public function forget()
	{
		$this->load->model('user_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'ایمیل', 'trim|required|valid_email');
		if ($this->form_validation->run() === false) {
					$return = str_replace('<p>','',validation_errors());
					$return = str_replace('</p>','',$return);
					echo $return;
		} else {
			$email = $this->input->post('email');
			
			 $config = Array(
					 'protocol' => 'smtp',
					 'smtp_host' => 'cpanel.serverdns.biz',
					 'smtp_port' => 465,
					 'smtp_crypto' => 'ssl',
					 'newline' => '\r\n',
					 'smtp_user' => 'info@bahar.persianstory.ir', // change it to yours
					 'smtp_pass' => '1qaz2wsxC', // change it to yours
					 'mailtype' => 'html',
					 'charset' => 'utf-8',
					 'wordwrap' => TRUE
				); 
				if($this->model_json->f_check_mail($email)) {
					
					$hash = $this->model_json->update_hashExp($email);
					
					$this->load->library('email', $config);
					$this->email->from('info@bahar.persianstory.ir', 'قصه های بهار');
					$this->email->to($email);
					$this->email->subject('فراموشی رمز عبور ');
					$this->email->message('<html><p style="direction:rtl;text-align:right;font:11px tahoma;">
					این ایمیل جهت نوسازی کلمه عبور شما در قصه های بهار ارسال شده است در صورتی که به اشتباه این ایمیل برای شما ارسال شده است این ایمیل را نادیده بگیرید . <br/>
این کد 4 رقمی را در برنامه وارد کنید : <strong>'.$hash.'</strong><br/>
 در صورت وجود هرگونه سوال میتوانید با ایمیل زیر با ما در تماس باشید : <br/>info@bahar.persianstory.ir
 </p></html>');			
					if ($this->email->send()) {
					
					echo "true";
					} else { echo "مشکل در عملیت نوسازی کلمه عبور";}
				} else { echo "این ایمیل در سیستم موجود نیست";}
				
			}
		}
	
	
	
	public function reset_pass() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('code', 'کد', 'trim|required|alpha_numeric|min_length[4]|max_length[4]');
		if ($this->form_validation->run() === false) {
					$return = str_replace('<p>','',validation_errors());
					$return = str_replace('</p>','',$return);
					echo $return;
		} else {
			$code = $this->input->post('code');
			if($this->model_json->get_user($code))
			echo "true";
			else echo "کد وارد شده معتبر نیست";
			
		}
	}

	
	public function change_pass() {
		
		$this->load->model('user_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('code', 'کد', 'trim|required|alpha_numeric|min_length[4]|max_length[4]');
		$this->form_validation->set_rules('h', 'رمز عبور', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('hh', 'تکرار رمز عبور', 'trim|required|min_length[4]|matches[h]');
		if ($this->form_validation->run() === false) {
					$return = str_replace('<p>','',validation_errors());
					$return = str_replace('</p>','',$return);
					echo $return;
		} else {
			 $config = Array(
					 'protocol' => 'smtp',
					 'smtp_host' => 'cpanel.serverdns.biz',
					 'smtp_port' => 465,
					 'smtp_crypto' => 'ssl',
					 'newline' => '\r\n',
					 'smtp_user' => 'info@bahar.persianstory.ir', // change it to yours
					 'smtp_pass' => '1qaz2wsxC', // change it to yours
					 'mailtype' => 'html',
					 'charset' => 'utf-8',
					 'wordwrap' => TRUE
				); 
			$code = $this->input->post('code');
			$email = $this->input->post('email');
			$pass = $this->input->post('h');
			if($this->model_json->get_user($code) && $this->user_model->update_pass($email,$pass)) {
				$usernamee = $this->model_json->get_username2($email);
			$this->load->library('email', $config);
					$this->email->from('info@bahar.persianstory.ir', 'قصه های بهار');
					$this->email->to($email);
					$this->email->subject('فراموشی رمز عبور ');
					$this->email->message('<html><p style="direction:rtl;text-align:right;font:11px tahoma;">
					رمز عبور با موفقیت تغییر یافت 
					نام کاربری شما : '.$usernamee.'<br/>
 در صورت وجود هرگونه سوال میتوانید با ایمیل زیر با ما در تماس باشید : <br/>info@bahar.persianstory.ir
 </p></html>');			
					if ($this->email->send()) {
					
					echo "true";
					} else { echo "مشکل در عملیت نوسازی کلمه عبور";}



			}
			elseif(!$this->model_json->get_user($code)) {
					echo "کد وارد شده معتبر نیست";
				} else {
					echo "عملیات تغییر کلمه عبور انجام نشد";
				}
			
		}
	}
	




	
	public function panel()
	{
		$key = $_GET['key'];
		$info = array();
		$info['c'] = $this->model_json->get_client($key);
		echo json_encode($info,true);
	}
	
	
	
	
		public function check()
	{
		$this->load->model('user_model');
		$username = $this->input->post('u');	
		$pass = $this->input->post('h');
if ($this->user_model->resolve_user_login_mob($username, $pass)) {
		$user_id = $this->user_model->get_user_id_from_username_mob($username);
		$user    = $this->user_model->get_user_mob($user_id);
		
		@$coin = $this->model_json->get_coin($user->id);
		
		if($user != "") {
				echo $user->is_deleted."--tg--".$user->price;
		}else {
			echo "6--tg--0";
		} 
} else {
echo "6--tg--0";
}
	}
	
	
	
public function buy()
	{
		$this->load->model('user_model');
		$username = $this->input->post('username');
		$pid = $this->input->post('pid');
		$price = $this->input->post('price');
		$user_id = $this->user_model->get_user_id_from_username_mob($username);
		$user    = $this->user_model->get_user_mob($user_id);
		$user    = $this->user_model->get_user_mob($user_id);
		
		@$coin = $this->model_json->get_coin($user->id);
		if($user != "") {
			if($this->model_json->get_buy($pid,$user->id) >= 1 ) {
				die($user->is_deleted."--tg--".$user->price."--tg--".$pid."-pid");
			}
				if($user->price >= $price) {
					if($this->model_json->insert_buy($user->id,$pid) && $this->model_json->update_price_profile($user->id,$user->price - $price ))
					echo $user->is_deleted."--tg--".$user->price."--tg--empty";
				} else echo $user->is_deleted."--tg--".$user->price."--tg--empty";
		} else echo "6--tg--0"."--tg--empty";
		
	}
	
	public function check_buy()
	{
		$this->load->model('user_model');
		$username = $this->input->post('username');
		$pid = $this->input->post('pid');
		$user_id = $this->user_model->get_user_id_from_username_mob($username);
		$user    = $this->user_model->get_user_mob($user_id);
		if($user != "") {
			if($this->model_json->get_buy($pid,$user->id) >= 1 ) {
				echo "true";
			} else echo "false";
		} else echo "false";
	}	
	
	
	
	
	public function login() {
		$this->load->model('user_model');
		$this->load->helper('form');
		$this->load->library(array('form_validation'));
		$this->form_validation->set_rules('u', 'نام کاربری', 'required|alpha_numeric|trim');
		$this->form_validation->set_rules('h', 'رمز عبور', 'required');
		if ($this->form_validation->run() == false) {
			echo validation_errors();
		} else {
			$username = $this->input->post('u');
			$password = $this->input->post('h');
			$imei = explode("_",$this->input->post('a'));
			if($imei[0] == "tg"){ 
				if ($this->user_model->resolve_user_login_mob($username, $password)) {
					$user_id = $this->user_model->get_user_id_from_username_mob($username);
					$user    = $this->user_model->get_user_mob($user_id);
					echo 'true--tg--'.$user->username."--tg--".$user->price."--tg--".$user->is_deleted;
				} 
				else {
					echo 'نام کاربری / رمز عبور را به درستی وارد نمایید';
				}
			}
		} 
		}
	
	}

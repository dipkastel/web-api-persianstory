<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class JsonBuy extends CI_Controller {
	public function __construct(){
        parent::__construct();
include('jdf.php');
		date_default_timezone_set("Asia/Tehran");
		$this->load->model(array('model_json'));
    }

	public function index()
	{

	}

	public function pay()
	{
	$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('key', 'کد', 'trim|required|min_length[30]');
		$this->form_validation->set_rules('token', 'کد', 'trim|required|min_length[10]');
		$this->form_validation->set_rules('pack', 'بسته', 'trim|required|min_length[6]');
		if ($this->form_validation->run() === false) {
					$return = str_replace('<p>','',validation_errors());
					$return = str_replace('</p>','',$return);
					echo "عملیات خرید انجام نشد";
		} else {
			
			$this->load->model('user_model');
			$key = $this->input->post('key');
			$username = $this->input->post('user');
			$token = $this->input->post('token');
			$pack    = $this->input->post('pack');
			$date = time();
			$user_id = $this->user_model->get_user_id_from_username_mob($username);
			$user    = $this->user_model->get_user_mob($user_id);	
			$my_key = "Tg_MIHNMA0GCSqGSIb3DQEBAQUAA4G7ADC==".$username;

			switch($pack) {
				case "bahar_1000":
				$package = "بسته 1000 تایی سکه";
				$coin = "1000";
				break;
				case "bahar_3000":
				$package = "بسته 3000 تایی سکه";
				$coin = "3000";
				break;
				case "bahar_5000":
				$package="بسته 5000 تایی سکه";
				$coin = "5000";
				break;
				case "bahar_10000":
				$package = "بسته 10000 تایی سکه";
				$coin = "10000";
				break;
				default:
				$package = "نا مشخص";
				$coin = "0";
			}
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
				$this->email->to($user->email);
				$this->email->subject('اطلاعات خرید سکه');
				$this->email->message('<html>
				<p style="direction:rtl;text-align:right;font:11px tahoma;">
با تشکر از خرید شما . <br/> اطلاعات سکه خریداری شده : <br/> بسته خریداری شده : '.$package.'<br/> شماره پیگیری :'.$token.' <br/> تاریخ خرید : '.jdate("Y-m-d h:i a",$date).' <br/> در صورت وجود هرگونه سوال میتوانید با ایمیل زیر با ما در تماس باشید : <br/>info@bahar.persianstory.ir
				</p></html>');	

			
			
				if($key == $my_key) {
				
			if ($this->model_json->insert_pay($user->id, $token,$coin) && $this->model_json->update_price_profile($user->id,$user->price+$coin)) {
				$this->email->send();
				echo "true";
			
				
			} else {
				echo 'There was a problem creating your new account. Please try again.';
			}
			} else {
				echo "protected ! :)";
			}
			 
			

			
			
		}
		}
		
		public function check_patch() {
			$token = $this->input->post('token');
			$pack    = $this->input->post('pack');
			$package = 'ir.tg.bahar';
			$url = 'http://pardakht.cafebazaar.ir/auth/token/';
			$refcode = "nEbciOHECMNvrNd2YdOK4Bfeqc8L4M";
			$data = array('grant_type'=>'refresh_token', 'client_id' => 'ygy0CnSL0JyDRHxTxe9WLrag0LfeqFGoHxy9Ydx5', 'client_secret' => 'UYJVTz4dTde08qVpnEx777rO64pnbPdZgUTeodHb3dfqBM8nHlY3M1h8v65Z', 'refresh_token' => $refcode);
			$ch = curl_init($url);
			$postString = http_build_query($data, '', '&');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			$jsonResponse = json_decode($response, true);
			$access_token = $jsonResponse['access_token'];
			$result = file_get_contents("https://pardakht.cafebazaar.ir/api/validate/$package/inapp/$pack/purchases/$token/?access_token=$access_token");
			$jsonResponse2 = json_decode($result, true);
			@$status = $jsonResponse2['developerPayload'];
			if($status == null || $status != "tg") {
				echo "false";
			}
			elseif($status == "tg") {
				echo "true";
			} else {
				echo "false";
			}
			curl_close($ch);
			
		}
		
	}
	
	
	
	

<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 6/2/2018
 * Time: 2:42 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class account extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_json'));
        header('Content-Type: application/json');
        date_default_timezone_set("Asia/Tehran");
    }

    public function index()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        echo json_encode([
            'data' => $jsonArray,
            'ErrorMessage' => 'permision denied'
        ]);
    }

    public function Login()
    {
        $this->load->model('user_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phoneNumber', 'شماره همراه', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('deviceId', 'deviceId', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[2]');
        if ($this->form_validation->run() === false) {
            $return = str_replace('<p>', '', validation_errors());
            $return = str_replace('</p>', '', $return);
            echo json_encode([
                'data' => [],
                'ErrorMessage' => $return
            ]);
            return;
        }

        $phoneNumber = $this->input->post('phoneNumber');
        $password = $this->input->post('password');
        $device_id = $this->input->post('deviceId');

        $user = $this->user_model->getUserByDeviceId($device_id);

        if ($user) {
            if ($this->user_model->getTimeFromJoin($user) < 5) {

                //new fish
                $this->user_model->setUserStatus($user,0);

            }
            if ($this->user_model->getTimeFromJoin($user) > 5 && $this->user_model->getTimeFromJoin($user) <= 10) {
                //old fish

                if ($user->phoneNumber != 'guest')
                    $this->user_model->setUserStatus($user,0);
                else
                    $this->user_model->setUserStatus($user,1);
                //shomararo bede lotfan

            }
            if ($this->user_model->getTimeFromJoin($user) > 10 && $this->user_model->getTimeFromJoin($user) <= 15) {
                //old fish

                if ($user->phoneNumber == 'guest')
                    $this->user_model->setUserStatus($user,2);
                //shomararo bayad bedi
                else {
                    if ($user->is_active == true)
                        $this->user_model->setUserStatus($user,0);
                    else
                        $this->user_model->setUserStatus($user,3);
                    //active kon lotfan
                }

            }
            if ($this->user_model->getTimeFromJoin($user) > 15) {
                //mashkook
                if ($user->phoneNumber == 'guest')
                    $this->user_model->setUserStatus($user,2);
                //shomararo bayad bedi
                else {
                    if ($user->is_active == 1)
                        $this->user_model->setUserStatus($user,0);
                    else
                        $this->user_model->setUserStatus($user,4);
                    //bayad active koni
                }
            }

            echo json_encode([
                'data' => $this->user_model->getUserByDeviceId($device_id),
                'ErrorMessage' => ""
            ]);
        } else {
            $this->user_model->createUserByDeviceId($device_id);
            echo json_encode([
                'data' => $this->user_model->getUserByDeviceId($device_id),
                'ErrorMessage' => "به قصه های فارسی خوش آمدید"
            ]);
        }

//        if($device_id==null)
//            return;
//
//        $userObj = $this->user_model->getUserAuth($phoneNumber, $password);
//        if ($userObj) {
//            $this->user_model->setLogin($userObj->id, $device_id);
//            echo json_encode([
//                'data'=>$userObj,
//                'status'=>'success'
//            ]);
//        } else {
//            echo json_encode([
//                'data'=>[],
//                'ErrorMessage'=>"کاربر یافت نشد"
//            ]);
//        }

    }

}
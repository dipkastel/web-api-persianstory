<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 6/4/2018
 * Time: 6:44 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Stories extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_json','user_model'));
        header('Content-Type: application/json');
        $this->load->library('pagination');
    }


    public function index()
    {
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        echo json_encode([
            'data' => $jsonArray,
            'ErrorMessage' => 'permision denied'
        ]);
    }

    public function page()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phoneNumber', 'شماره همراه', 'trim|required|alpha_numeric|min_length[3]|is_unique[tg_client.username]', array('is_unique' => 'شماره تلفن انتخاب شده قبلا توسط شخص دیگری استفاده شده است'));
        $this->form_validation->set_rules('deviceId', 'deviceId', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[2]');
        if ($this->form_validation->run() === false) {
            $Message = str_replace('<p>', '', validation_errors());
            $Message = str_replace('</p>', '', $Message);
            if ($Message == "")
                $Message = "ورودی نادرست";
            echo json_encode([
                'data' => null,
                'ErrorMessage' => $Message
            ]);
            return;
        }
        If(!$this->user_model->CheckUser($this->input)){
            $Message = "خطا احراز هویت";
            echo json_encode([
                'data' => null,
                'ErrorMessage' => $Message
            ]);
            return;
        }
        $config = array();
        $config['base_url'] = base_url() . '/JsonArchive/page/';
        $config['total_rows'] = $this->model_json->get_countPage('tg_dastan');
        $config["per_page"] = 10;
        $config['use_page_numbers'] = TRUE;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
       // $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $page = ($this->input->post('pageNumber'))?$this->input->post('pageNumber'):0;
        if ($page >= 1) $page = ($page * $config["per_page"]) - $config["per_page"];
        $data['posts'] = $this->model_json->getArchive('tg_dastan', $config["per_page"], $page);

        $data['upload_url'] = $this->config->item('upload_url');
        echo json_encode([
            'data' =>  $data,
            'ErrorMessage' => ''
        ]);
    }
}
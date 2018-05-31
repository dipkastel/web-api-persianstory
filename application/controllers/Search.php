<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	public function __construct(){
        parent::__construct();

		//$this->load->helper('form');
		
		$this->load->model(array('model_home'));
		$this->load->library('pagination');

		
    }


	public function index()
	{
		if(!isset($_GET['s'])) {
		$this->load->view('404'); 
		} else {
		$config = array();
			$config['base_url'] = base_url() . '/search/';
   			$config['total_rows'] = $this->model_home->get_countPage('tg_dastan');
   			$config['full_tag_open'] = '<ul class="pagination">';
        	$config["per_page"] = 6;
        	$config['use_page_numbers'] = TRUE;
        	$config["uri_segment"] = 4;
        	$config['full_tag_close'] = '</ul>';
	        $config['first_link'] = false;
	        $config['last_link'] = false;
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo';
	        $config['prev_tag_open'] = '<li class="prev">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = '&raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';
       		$this->pagination->initialize($config);
        	$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        	if($page >= 1)
        	$page = ( $page * $config["per_page"] ) - $config["per_page"];
			$find =  urldecode($_GET['s']);

		$data['posts'] = $this->model_home->get_find($find);
		
		$data['pagination'] = $this->pagination->create_links();
		$dataHead['title'] = 'نتایج جستجو برای '.'"'.$find.'"';
		$data['title'] = 'نتایج جستجو برای '.'"'.$find.'"';
		$this->load->view('sitePage-head',$dataHead);
		$this->load->view('archive',$data);
		$this->load->view('page-footer');
	}
	}

	public function find()
	{
		$config = array();
			$config['base_url'] = base_url() . '/search/';
   			$config['total_rows'] = $this->model_home->get_countPage('tg_dastan');
   			$config['full_tag_open'] = '<ul class="pagination">';
        	$config["per_page"] = 6;
        	$config['use_page_numbers'] = TRUE;
        	$config["uri_segment"] = 4;
        	$config['full_tag_close'] = '</ul>';
	        $config['first_link'] = false;
	        $config['last_link'] = false;
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo';
	        $config['prev_tag_open'] = '<li class="prev">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = '&raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';
       		$this->pagination->initialize($config);
        	$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        	if($page >= 1)
        	$page = ( $page * $config["per_page"] ) - $config["per_page"];
			$find =  $_GET['s'];

		$data['posts'] = $this->model_home->get_find($find);

		$data['pagination'] = $this->pagination->create_links();
		$dataHead['title'] = 'نتایج جستجو برای '.'"'.$find.'"';
		$data['title'] = 'نتایج جستجو برای '.'"'.$find.'"';
		$this->load->view('sitePage-head',$dataHead);
		$this->load->view('archive',$data);
		$this->load->view('page-footer');
	}
	

	public function populars()
	{
		$config = array();
			$config['base_url'] = base_url() . '/populars/page/';
   			$config['total_rows'] = count($this->model_home->get_count_popular());
   			$config['full_tag_open'] = '<ul class="pagination">';
        	$config["per_page"] = 6;
        	$config['use_page_numbers'] = TRUE;
        	$config["uri_segment"] = 4;
        	$config['full_tag_close'] = '</ul>';
	        $config['first_link'] = false;
	        $config['last_link'] = false;
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo';
	        $config['prev_tag_open'] = '<li class="prev">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = '&raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';
       		$this->pagination->initialize($config);
        	$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        	if($page >= 1)
        	$page = ( $page * $config["per_page"] ) - $config["per_page"];
			
		$data['posts'] = $this->model_home->get_populars($config["per_page"],$page);
		$data['pagination'] = $this->pagination->create_links();
		$dataHead['title'] = 'آرشیو قصه ها';
		$data['title'] = 'آرشیو برترین ها';
		$this->load->view('sitePage-head',$dataHead);
		$this->load->view('archive',$data);
		$this->load->view('page-footer');
	}


	public function page()
	{
		
			$config = array();
			$config['base_url'] = base_url() . $this->uri->segment(1).'/page/';
   			$config['total_rows'] = $this->model_home->get_countPage('tg_dastan');
   			$config['full_tag_open'] = '<ul class="pagination">';
   			$config['use_page_numbers'] = TRUE;
        	$config["per_page"] = 6;
        	$config["uri_segment"] = 3;
        	$config['full_tag_close'] = '</ul>';
	        $config['first_link'] = false;
	        $config['last_link'] = false;
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo';
	        $config['prev_tag_open'] = '<li class="prev">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = '&raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';
       		$this->pagination->initialize($config);
        	$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        	if($page >= 1)
        	$page = ( $page * $config["per_page"] ) - $config["per_page"];
			$data['posts'] = $this->model_home->get_dataMpages('tg_dastan',$config["per_page"],$page);
		$data['pagination'] = $this->pagination->create_links();
		$dataHead['title'] = 'آرشیو قصه ها';

		$this->load->view('sitePage-head',$dataHead);
		$this->load->view('archive',$data);
		$this->load->view('page-footer');
		
		
	}
public function popularPage()
	{
		
			$config = array();
			$config['base_url'] = base_url() . $this->uri->segment(1).'/page/';
   			$config['total_rows'] = count($this->model_home->get_count_popular());
   			$config['full_tag_open'] = '<ul class="pagination">';
   			$config['use_page_numbers'] = TRUE;
        	$config["per_page"] = 6;
        	$config["uri_segment"] = 3;
        	$config['full_tag_close'] = '</ul>';
	        $config['first_link'] = false;
	        $config['last_link'] = false;
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo';
	        $config['prev_tag_open'] = '<li class="prev">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = '&raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';
       		$this->pagination->initialize($config);
        	$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        	if($page >= 1)
        	$page = ( $page * $config["per_page"] ) - $config["per_page"];
			$data['posts'] = $this->model_home->get_populars($config["per_page"],$page);
		$data['pagination'] = $this->pagination->create_links();
		$dataHead['title'] = 'آرشیو قصه ها';
		$this->load->view('sitePage-head',$dataHead);
		$this->load->view('archive',$data);
		$this->load->view('page-footer');
		
		
	}
	
}

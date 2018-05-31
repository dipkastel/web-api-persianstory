<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ManagePosts extends CI_Controller {

	public function __construct(){
        parent::__construct();
		$this->load->helper('form');
		$this->load->model(array('model_webSetting','model_admin','model_jdf'));
		$this->load->library('pagination');
		
			
			
			

    		




    }
	
	public function index()
	{
			$config = array();
			$config['base_url'] = base_url() . '/tg-admin/managePosts/page/';
   			$config['total_rows'] = $this->model_admin->get_countPage('tg_dastan');
   			$config['full_tag_open'] = '<ul class="pagination">';
        	$config["per_page"] = 15;
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
			$data['posts'] = $this->model_admin->get_dataMpages('tg_dastan',$config["per_page"],$page);
			$data['pagination'] = $this->pagination->create_links();
			$data['sucs'] = '';
			$dataHead['nav'] = 'مدیریت پست ها';
			$dataHead['title'] = 'مدیریت پست ها';
			if(isset($_GET['update']) && $_GET['update'] == "true") $data['sucs'] = "پست با موفقیت ویرایش شد";
			if(isset($_GET['delete']) && $_GET['delete'] == "true") $data['sucs'] = "پست با موفقیت حذف شد";
			if(isset($_GET['delete']) && $_GET['delete'] == "false") $data['error'] = "مشکلی در حذف از بانک اطلاعاتی پیش آمد";
			if(isset($_GET['updatepost']) && $_GET['updatepost'] == "false") $data['error'] = "ویرایش پست با خطا در بانک اطلاعاتی مواجه شد";
			if(isset($_GET['updatepost']) && $_GET['updatepost'] == "true") $data['sucs'] = "ویرایش پست با موفقیت انجام شد";
			if(isset($_GET['addpost']) && $_GET['addpost'] == "false") $data['error'] = "اضافه کردن پست با خطا در بانک اطلاعاتی مواجه شد";
			if(isset($_GET['addpost']) && $_GET['addpost'] == "true") $data['sucs'] = "پست با موفقیت اضافه شد";
			
		$this->load->view('page-head',$dataHead);
		$this->load->view('manage_posts',$data);
		$this->load->view('page-footer',null);
	
	}

	


	public function removePost()
	{
		$id = $_GET['id'];
		if($this->model_admin->removePost($id))
		redirect('tg-admin/managePosts/?delete=true');
		else
		redirect('tg-admin/managePosts/?delete=flase');	
	}

	public function page()
	{
		
			$config = array();
			$config['base_url'] = base_url() . '/tg-admin/managePosts/page/';
   			$config['total_rows'] = $this->model_admin->get_countPage('tg_dastan');
   			$config['full_tag_open'] = '<ul class="pagination">';
   			$config['use_page_numbers'] = TRUE;
        	$config["per_page"] = 15;
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
			$data['posts'] = $this->model_admin->get_dataMpages('tg_dastan',$config["per_page"],$page);
			$data['pagination'] = $this->pagination->create_links();
			$data['sucs'] = '';
			$dataHead['nav'] = 'مدیریت پست ها';
			$dataHead['title'] = 'مدیریت پست ها';
			
		$this->load->view('page-head',$dataHead);
		$this->load->view('manage_posts',$data);
		$this->load->view('page-footer',null);
		
		
	}



}


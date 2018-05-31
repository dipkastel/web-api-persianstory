<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddCat extends CI_Controller {

	public function __construct(){
        parent::__construct();
		$this->load->helper('form');
		$this->load->model(array('model_webSetting','model_admin'));

    }
	
	public function index()
	{



		$data = array(
		        
		        'sucs' => "",
		        'cats' => $this->model_admin->get_dataM('tg_cats'),
		        'message' => 'My Message'
				);
		$dataH = array(
		        'title' => 'مدیریت دسته ها',
		        'nav' => "true"
		        
				);
		$this->load->view('page-head',$dataH);
		$this->load->view('add_cat',$data);
		$this->load->view('page-footer',null);
	
	}

	public function add_cat()
	{

		$data = new stdClass();
		$dataH = new stdClass();
		$data = array(
				        'sucs' => "",
				        'cats' => $this->model_admin->get_dataM('tg_cats'),
				        'message' => 'My Message'
				);
		$dataH = array(
		        'title' => 'افزودن دسته',
		        'nav' => "true"
		        
				);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'نام دسته', 'required');
		
		

		if ($this->form_validation->run() == FALSE)
		{
		$this->load->view('page-head',$dataH);
		$this->load->view('add_cat',$data);
		$this->load->view('page-footer',null);
			
		} else {
			// set variables from the form


       

                $this->model_admin->insert_cat($_POST['name']);
                 $data = array(
        	'sucs' => "دسته شما با موفقیت اضافه شد",
        	'cats' => $this->model_admin->get_dataM('tg_cats')

        	);
                $this->load->view('page-head',$dataH);
				$this->load->view('add_cat',$data);
				$this->load->view('page-footer',null);
        
}


			
		}


		public function update_cat()
	{

		$data = new stdClass();
		$dataH = new stdClass();
		$id = $_GET['editId'];
		$data = array(
				        'sucs' => "",
				        'cats' => $this->model_admin->get_dataM('tg_cats'),
				        'catval' => $this->model_admin->get_dataSingle('tg_cats','id',$id,'name'),
				        'message' => 'My Message'
				);
		
		$dataH = array(
		        'title' => 'ویرایش دسته',
		        'nav' => "true"
		        
				);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'نام دسته', 'required');
		
		

		if ($this->form_validation->run() == FALSE)
		{
		$this->load->view('page-head',$dataH);
		$this->load->view('add_cat',$data);
		$this->load->view('page-footer',null);
			
		} else {
			// set variables from the form

 $this->model_admin->update_cat($_POST['name'],$id);

 $data = array(
        	'sucs' => "دسته شما با موفقیت ویرایش شد",
        	'cats' => $this->model_admin->get_dataM('tg_cats'),
        	'catval' => $this->model_admin->get_dataSingle('tg_cats','id',$id,'name')

        	);
       
				
               
                

                $this->load->view('page-head',$dataH);
				$this->load->view('add_cat',$data);
				$this->load->view('page-footer',null);
        
}


			
		}


	public function removeCat()
	{
		$id = $_GET['id'];
		if($id != 1) {
		$this->model_admin->removeCat($id);
			$data = array(
        	'sucs' => "دسته حذف شد",
        	'cats' => $this->model_admin->get_dataM('tg_cats')
        	
        	);
        	$dataH = array(
		        'title' => 'ویرایش دسته',
		        'nav' => "true"
		        
				);
		} else {
			$dataH = array(
		        'title' => 'ویرایش دسته',
		        'nav' => "true"
		        
				);
			$data = array(
        	'sucs' => "این دسته قابل حذف نیست",
        	'cats' => $this->model_admin->get_dataM('tg_cats')
        	
        	);
		}
		 $this->load->view('page-head',$dataH);
				$this->load->view('add_cat',$data);
				$this->load->view('page-footer',null);
		}
		
		
	

	public function editCat()
	{
		$id = $_GET['editId'];
		
			$data = array(
        	'sucs' => "",
        	'cats' => $this->model_admin->get_dataM('tg_cats'),
        	'catval' => $this->model_admin->get_dataSingle('tg_cats','id',$id,'name')
        	);

        	$dataH = array(
		        'title' => 'ویرایش دسته',
		        'nav' => "true"
		        
				);


			 	$this->load->view('page-head',$dataH);
				$this->load->view('add_cat',$data);
				$this->load->view('page-footer',null);
		
		
	}



}






/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
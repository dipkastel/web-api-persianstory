<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AddPost extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model(array('model_admin'));
        date_default_timezone_set("Asia/Tehran");
    }

    public function index()
    {

        $dataH = array(
            'title' => 'افزودن پست جدید',
            'nav' => 'true',
            'style' => '
	<link rel="stylesheet" href="' . base_url('assets/css/blueimp-gallery.min.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-ui.css') . '">
	<noscript><link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-noscript.css') . '"></noscript>
	<noscript><link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-ui-noscript.css') . '"></noscript>
	<style>
	/* Hide Angular JS elements before initializing */
	.ng-cloak,.selectpic {
		display: none;
	}
	</style>',
            'script' => '<script src="' . base_url('assets/js/angular.min.js') . '"></script>
<script src="' . base_url('assets/js/vendor/jquery.ui.widget.js') . '"></script>
<script src="' . base_url('assets/js/load-image.all.min.js') . '"></script>
<script src="' . base_url('assets/assets/js/canvas-to-blob.min.js') . '"></script>
<script src="' . base_url('assets/js/jquery.blueimp-gallery.min.js') . '"></script>
<script src="' . base_url('assets/js/jquery.iframe-transport.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-process.js') . '"></script>
<script src="' . base_url('assets/assets/js/jquery.fileupload-image.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-audio.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-video.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-validate.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-angular.js') . '"></script>
<script src="' . base_url('assets/js/app.js') . '"></script>


<script src="' . base_url('assets/ckeditor/ckeditor.js') . '"></script>
	<script src="' . base_url('assets/ckeditor/samples/js/sample.js') . '"></script>
	<link rel="stylesheet" href="' . base_url('assets/ckeditor/samples/css/samples.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css') . '">
<script>

initSample();
</script>

'
        );

        $data = array(
            'sucs' => "",
            'cats' => $this->model_admin->get_dataM('tg_cats'),
            'message' => 'My Message'
        );
        $this->load->view('page-head', $dataH);
        $this->load->view('add_post', $data);
        $this->load->view('page-footer', $dataH);

    }

    public function add_post()
    {
        $data = new stdClass();
        $dataH = new stdClass();

        $dataH = array(
            'title' => 'افزودن پست جدید',
            'nav' => 'true',
            'style' => '
	<link rel="stylesheet" href="' . base_url('assets/css/blueimp-gallery.min.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-ui.css') . '">
	<noscript><link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-noscript.css') . '"></noscript>
	<noscript><link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-ui-noscript.css') . '"></noscript>
	<style>
	/* Hide Angular JS elements before initializing */
	.ng-cloak,.selectpic {
		display: none;
	}
	</style>',
            'script' => '<script src="' . base_url('assets/js/angular.min.js') . '"></script>
<script src="' . base_url('assets/js/vendor/jquery.ui.widget.js') . '"></script>
<script src="' . base_url('assets/js/load-image.all.min.js') . '"></script>
<script src="' . base_url('assets/assets/js/canvas-to-blob.min.js') . '"></script>
<script src="' . base_url('assets/js/jquery.blueimp-gallery.min.js') . '"></script>
<script src="' . base_url('assets/js/jquery.iframe-transport.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-process.js') . '"></script>
<script src="' . base_url('assets/assets/js/jquery.fileupload-image.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-audio.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-video.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-validate.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-angular.js') . '"></script>
<script src="' . base_url('assets/js/app.js') . '"></script>
<script src="' . base_url('assets/ckeditor/ckeditor.js') . '"></script>
	<script src="' . base_url('assets/ckeditor/samples/js/sample.js') . '"></script>
	<link rel="stylesheet" href="' . base_url('assets/ckeditor/samples/css/samples.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css') . '">
<script>

initSample();
</script>
'
        );

        $data = array(
            'sucs' => "",
            'cats' => $this->model_admin->get_dataM('tg_cats'),
            'message' => 'My Message'
        );
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'نام پست', 'required');

        $this->form_validation->set_rules('kholase', 'خلاصه پست', 'required');


        if ($this->form_validation->run() == FALSE && !isset($_POST['pending'])) {

            $this->load->view('page-head', $dataH);
            $this->load->view('add_post', $data);
            $this->load->view('page-footer', $dataH);

        } elseif (isset($_POST['pending'])) {

            if ($this->model_admin->insert_dastan($_POST['name'], $_POST['teller'], $_POST['kholase'], $_POST['description'], $_POST['cat'], $_POST['imgname'], $_POST['musicname'], time(), 2, $_POST['price']))
                redirect('tg-admin/managePosts/?addpost=true');
            else
                redirect('tg-admin/managePosts/?addpost=false');
        } else {
            // set variables from the form


            if ($this->model_admin->insert_dastan($_POST['name'], $_POST['teller'], $_POST['kholase'], $_POST['description'], $_POST['cat'], $_POST['imgname'], $_POST['musicname'], time(), 1, $_POST['price'])) {
                $postid = $this->model_admin->get_id($_POST['name']);
                $this->model_admin->update_rate($postid, 0, 0);
                redirect('tg-admin/managePosts/?addpost=true');
            } else {
                redirect('tg-admin/managePosts/?addpost=false');
            }


        }


    }


    public function updatePost()
    {

        $data = new stdClass();
        $dataH = new stdClass();

        $id = $_GET['editPostId'];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'نام پست', 'required');

        $this->form_validation->set_rules('kholase', 'خلاصه پست', 'required');


        $dataH = array(
            'title' => 'ویرایش پست',
            'nav' => 'true',
            'style' => '
	<link rel="stylesheet" href="' . base_url('assets/css/blueimp-gallery.min.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-ui.css') . '">
	<noscript><link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-noscript.css') . '"></noscript>
	<noscript><link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-ui-noscript.css') . '"></noscript>
	<style>
	/* Hide Angular JS elements before initializing */
	.ng-cloak,.selectpic {
		display: none;
	}
	</style>',
            'script' => '<script src="' . base_url('assets/js/angular.min.js') . '"></script>
<script src="' . base_url('assets/js/vendor/jquery.ui.widget.js') . '"></script>
<script src="' . base_url('assets/js/load-image.all.min.js') . '"></script>
<script src="' . base_url('assets/assets/js/canvas-to-blob.min.js') . '"></script>
<script src="' . base_url('assets/js/jquery.blueimp-gallery.min.js') . '"></script>
<script src="' . base_url('assets/js/jquery.iframe-transport.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-process.js') . '"></script>
<script src="' . base_url('assets/assets/js/jquery.fileupload-image.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-audio.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-video.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-validate.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-angular.js') . '"></script>
<script src="' . base_url('assets/js/app.js') . '"></script>
<script src="' . base_url('assets/ckeditor/ckeditor.js') . '"></script>
	<script src="' . base_url('assets/ckeditor/samples/js/sample.js') . '"></script>
	<link rel="stylesheet" href="' . base_url('assets/ckeditor/samples/css/samples.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css') . '">
<script>

initSample();
</script>

'
        );


        if ($this->form_validation->run() == FALSE && !isset($_POST['pending'])) {
            $data = array(
                'sucs' => "",
                'cats' => $this->model_admin->get_dataM('tg_cats'),
                'name' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'name'),
                'teller' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'teller'),
                'kholase' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'content'),
                'matn' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'description'),
                'pic' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'pic'),
                'sound' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'sound'),
                'price' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'price'),
                'catval' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'cat')
            );

            $this->load->view('page-head', $dataH);
            $this->load->view('add_post', $data);
            $this->load->view('page-footer', $dataH);

        } elseif (isset($_POST['pending'])) {

            if ($this->model_admin->update_post($_POST['name'], $_POST['teller'], $_POST['kholase'], $_POST['description'], $_POST['cat'], $_POST['imgname'], $_POST['musicname'], time(), $id, 2, $_POST['price']))

                redirect('tg-admin/managePosts/?postupdate=true');
            else
                redirect('tg-admin/managePosts/?postupdate=false');

        } else {
            // set variables from the form


            if ($this->model_admin->update_post($_POST['name'], $_POST['teller'], $_POST['kholase'], $_POST['description'], $_POST['cat'], $_POST['imgname'], $_POST['musicname'], time(), $id, 1, $_POST['price'])) {
                $postid = $this->model_admin->get_id($_POST['name']);
                $this->model_admin->update_rate($postid, 0, 0);
                redirect('tg-admin/managePosts/?update=true');
            } else {
                redirect('tg-admin/managePosts/?update=false');
            }


        }
    }


    public function editPost()
    {
        $dataHh = array(
            'title' => 'ویرایش پست',
            'nav' => 'true',
            'style' => '
	<link rel="stylesheet" href="' . base_url('assets/css/blueimp-gallery.min.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-ui.css') . '">
	<noscript><link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-noscript.css') . '"></noscript>
	<noscript><link rel="stylesheet" href="' . base_url('assets/css/jquery.fileupload-ui-noscript.css') . '"></noscript>
	<style>
	/* Hide Angular JS elements before initializing */
	.ng-cloak,.selectpic {
		display: none;
	}
	</style>',
            'script' => '<script src="' . base_url('assets/js/angular.min.js') . '"></script>
<script src="' . base_url('assets/js/vendor/jquery.ui.widget.js') . '"></script>
<script src="' . base_url('assets/js/load-image.all.min.js') . '"></script>
<script src="' . base_url('assets/assets/js/canvas-to-blob.min.js') . '"></script>
<script src="' . base_url('assets/js/jquery.blueimp-gallery.min.js') . '"></script>
<script src="' . base_url('assets/js/jquery.iframe-transport.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-process.js') . '"></script>
<script src="' . base_url('assets/assets/js/jquery.fileupload-image.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-audio.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-video.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-validate.js') . '"></script>
<script src="' . base_url('assets/js/jquery.fileupload-angular.js') . '"></script>
<script src="' . base_url('assets/js/app.js') . '"></script>
<script src="' . base_url('assets/ckeditor/ckeditor.js') . '"></script>
	<script src="' . base_url('assets/ckeditor/samples/js/sample.js') . '"></script>
	<link rel="stylesheet" href="' . base_url('assets/ckeditor/samples/css/samples.css') . '">
	<link rel="stylesheet" href="' . base_url('assets/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css') . '">
<script>

initSample();
</script>
'
        );
        $data = new stdClass();
        $dataH = new stdClass();


        $id = $_GET['editPostId'];


        $data = array(
            'sucs' => "",
            'cats' => $this->model_admin->get_dataM('tg_cats'),
            'name' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'name'),
            'teller' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'teller'),
            'kholase' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'content'),
            'matn' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'description'),
            'pic' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'pic'),
            'sound' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'sound'),
            'price' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'price'),
            'catval' => $this->model_admin->get_dataSingle('tg_dastan', 'id', $id, 'cat')
        );
        $this->load->view('page-head', $dataHh);
        $this->load->view('add_post', $data);
        $this->load->view('page-footer', $dataH);


    }

}







/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
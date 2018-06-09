<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class User extends CI_Controller
{
    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');

    }


    public function index()
    {


    }

    /**
     * register function.
     *
     * @access public
     * @return void
     */
    public function register()
    {
        $this->load->model('model_admin');

        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

        if ($this->form_validation->run() === false) {

            // validation not ok, send validation errors to the view
            $this->load->view('header');
            $this->load->view('user/register/register', $data);
            $this->load->view('footer');

        } else {

            // set variables from the form
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->user_model->create_user($username, $email, $password)) {

                // user creation ok
                $this->load->view('header');
                $this->load->view('user/register/register_success', $data);
                $this->load->view('footer');

            } else {

                // user creation failed, this should never happen
                $data->error = 'There was a problem creating your new account. Please try again.';

                // send error to the view
                $this->load->view('header');
                $this->load->view('user/register/register', $data);
                $this->load->view('footer');

            }

        }

    }

    /**
     * login function.
     *
     * @access public
     * @return void
     */
    public function login()
    {


        // create the data object
        $data = new stdClass();
        $dataH = new stdClass();
        // load form helper and validation library
        $this->load->helper('form');
        $this->load->config('recaptcha');
        $this->load->library(array('form_validation', 'recaptcha'));


        // set validation rules
        $this->form_validation->set_rules('username', 'نام کاربری', 'required|alpha_numeric|trim');
        $this->form_validation->set_rules('password', 'رمز عبور', 'required');
        $dataH->nav = 'false';
        $dataH->title = 'ورود به سایت';
        $data = array(

            'error' => '',
            'widget' => $this->recaptcha->getWidget(),
            'script' => $this->recaptcha->getScriptTag(),
        );

        if ($this->form_validation->run() == false) {

            if (isset($_GET['logout']) && $_GET['logout'] == "true") $data['error'] = "شما از مدیریت خارج شدید";
            // validation not ok, send validation errors to the view
            $this->load->view('page-head', $dataH);
            $this->load->view('user/login/login', $data);
            $this->load->view('page-footer');

        } else {

            // set variables from the form
            $username = $this->input->post('username');
            $password = $this->input->post('password');


            $recaptcha = $this->input->post('g-recaptcha-response');
            if (!empty($recaptcha)) {
                $response = $this->recaptcha->verifyResponse($recaptcha);
                if (isset($response['success']) and $response['success'] === true) {


                    if ($this->user_model->resolve_user_login($username, $password)) {

                        $user_id = $this->user_model->get_user_id_from_username($username);
                        $user = $this->user_model->get_user($user_id);


                        // set session user datas
                        $_SESSION['user_id'] = (int)$user->id;
                        $_SESSION['username'] = (string)$user->username;
                        $_SESSION['logged_in'] = (bool)true;
                        $_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
                        $_SESSION['is_admin'] = (bool)$user->is_admin;

                        // user login ok
                        redirect('tg-admin');

                    } else {

                        // login failed

                        $data = array(

                            'error' => 'نام کاربری / رمز عبور را به درستی وارد نمایید',
                            'widget' => $this->recaptcha->getWidget(),
                            'script' => $this->recaptcha->getScriptTag(),
                        );
                        // send error to the view
                        $this->load->view('page-head', $dataH);
                        $this->load->view('user/login/login', $data);
                        $this->load->view('page-footer');

                    }

                } else {
                    $data = array(

                        'error' => '',
                        'widget' => $this->recaptcha->getWidget(),
                        'script' => $this->recaptcha->getScriptTag(),
                    );

                    // send error to the view
                    $this->load->view('page-head', $dataH);
                    $this->load->view('user/login/login', $data);
                    $this->load->view('page-footer');
                }

            } else {
                $data = array(

                    'error' => 'شما به عنوان ربات شناخته شده اید',
                    'widget' => $this->recaptcha->getWidget(),
                    'script' => $this->recaptcha->getScriptTag(),
                );

                // send error to the view
                $this->load->view('page-head', $dataH);
                $this->load->view('user/login/login', $data);
                $this->load->view('page-footer');
            }
        }

    }

    /**
     * logout function.
     *
     * @access public
     * @return void
     */
    public function logout()
    {

        // create the data object
        $data = new stdClass();
        $this->load->config('recaptcha');
        $this->load->library(array('form_validation', 'recaptcha'));
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

            // remove session datas
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }

            $dataH = array(

                'nav' => 'false'

            );
            $data = array(

                'error' => 'شما از مدیریت خارج شدید',
                'widget' => $this->recaptcha->getWidget(),
                'script' => $this->recaptcha->getScriptTag(),
            );
            // user logout ok
            redirect('login?logout=true');

        } else {

            // there user was not logged in, we cannot logged him out,
            // redirect him to site root
            redirect('/login');

        }

    }


    public function recaptcha()
    {
        // load from spark tool
        $this->load->spark('recaptcha-library/1.0.1');
        // load from CI library
        // $this->load->library('recaptcha');

        $recaptcha = $this->input->post('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) and $response['success'] === true) {
                echo "You got it!";
            }
        }

        $data = array(
            'widget' => $this->recaptcha->getWidget(),
            'script' => $this->recaptcha->getScriptTag(),
        );
        $this->load->view('recaptcha', $data);
    }

}
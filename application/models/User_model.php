<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 *
 * @extends CI_Model
 */
class User_model extends CI_Model
{
    public function __construct()
    {

        parent::__construct();
        $this->load->database();

    }

    public function getUserByDeviceId($device_id)
    {
        //todo get last
        $this->db->select();
        $this->db->from('mobile_user');
        $this->db->where('device_id', $device_id);
        $user = $this->db->get()->row();

        return $user;


    }

    public function CheckUser($input)
    {
        $password = $input->post('password');
        $device_id = $input->post('deviceId');
        $user =$this->getUserAuth($device_id,$password);
if($user!=null&&$user->device_id)
        return ($user->device_id==$device_id)?true:false;
else return false;

    }

    public function createUserByDeviceId($device_id)
    {
        $data = array(
            'phoneNumber' => 'guest',
            'password' => '',
            'device_id' => $device_id,
            'created_at' => date('Y-m-j H:i:s'),
            'status' => 0,
            'is_active' => false,

        );
        $user =  $this->db->insert('mobile_user', $data);
        return $user;

    }

    public function getTimeFromJoin($user){
        $user_create_date = DateTime::createFromFormat('Y-m-j',$user->created_at);
        $current_date = new DateTime();
        return ($current_date->getTimestamp()-$user_create_date->getTimestamp())/(24*60*60);
    }

    public function setUserStatus($user,$status)
    {
        $user->status=$status;
        $this->db->from('mobile_user');
        $this->db->where('device_id', $user->device_id);
        $this->db->set('status',$status);
        $this->db->update('mobile_user',$user);
    }

    public function getUserAuth($device_id, $password)
    {
        $this->db->select();
        $this->db->from('mobile_user');
        $this->db->where('device_id', $device_id);
        $this->db->where('password', $password);
        $user = $this->db->get()->row();
        return $user;

    }

    public function getUser($phoneNumber)
    {

        $this->db->select();
        $this->db->from('mobile_user');
        $this->db->where('phoneNumber', $phoneNumber);
        $user = $this->db->get()->row();

        return $user;


    }


    public function RegisterUser($PhoneNumber)
    {
        $password = rand(100000,999999);
        $data = array(
            'phoneNumber' => $PhoneNumber,
            'password' => $password,
            'created_at' => date('Y-m-j H:i:s'),
            'status' => 0
        );
        $user =  $this->db->insert('mobile_user', $data);
        return $user;

    }


    public function setLogin($user_id, $device_id)
    {
        $data = array(
            'user_id' => $user_id,
            'device_id' => $device_id,
            'created_at' => date('Y-m-j H:i:s'),
            'action' => 'login'
        );
        $user =  $this->db->insert('user_action', $data);
        return $user;

    }

    public function userExist($phoneNumber)
    {

        $this->db->select();
        $this->db->from('mobile_user');
        $this->db->where('phoneNumber', $phoneNumber);
        $user = $this->db->get()->row();
        return $user?true:false;

    }

    /**
     * create_user function.
     *
     * @access public
     * @param mixed $username
     * @param mixed $email
     * @param mixed $password
     * @return bool true on success, false on failure
     */
    public function create_user($username, $email, $password, $key)
    {


        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $this->hash_password($password),
            'created_at' => date('Y-m-j H:i:s'),
            'imei' => $key,
        );

        return $this->db->insert('users', $data);

    }

//    public function create_user_mob($username, $email, $password, $key)
//    {
//
//        $data = array(
//            'username' => $username,
//            'email' => $email,
//            'password' => $this->hash_password($password),
//            'created_at' => date('Y-m-j H:i:s'),
//            'imei' => $key,
//        );
//
//        return $this->db->insert('tg_client', $data);
//
//    }

    public function update_pass($email, $pass)
    {

        $data = array(
            'password' => $this->hash_password($pass),
            'hash_exp' => 0,
            'hash_code' => 0
        );
        $this->db->where('email', $email);

        if ($this->db->update('tg_client', $data))
            return true;
        else
            return false;
        return false;
    }


    public function insertLogin(User $user,device $device){

    }

    /**
     * resolve_user_login function.
     *
     * @access public
     * @param mixed $username
     * @param mixed $password
     * @return bool true on success, false on failure
     */
    public function resolve_user_login($username, $password)
    {

        $this->db->select('password');
        $this->db->from('users');
        $this->db->where('username', $username);
        $hash = $this->db->get()->row('password');

        return $this->verify_password_hash($password, $hash);

    }

    /**
     * get_user_id_from_username function.
     *
     * @access public
     * @param mixed $username
     * @return int the user id
     */
    public function get_user_id_from_username($username)
    {

        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('username', $username);

        return $this->db->get()->row('id');

    }

    /**
     * get_user function.
     *
     * @access public
     * @param mixed $user_id
     * @return object the user object
     */
    public function get_user($user_id)
    {

        $this->db->from('users');
        $this->db->where('id', $user_id);
        return $this->db->get()->row();

    }


    public function resolve_user_login_mob($username, $password)
    {

        $this->db->select('password');
        $this->db->from('tg_client');
        $this->db->where('username', $username);
        $hash = $this->db->get()->row('password');

        return $this->verify_password_hash($password, $hash);

    }




    /**
     * get_user_id_from_username function.
     *
     * @access public
     * @param mixed $username
     * @return int the user id
     */
    public function get_user_id_from_username_mob($username)
    {

        $this->db->select('id');
        $this->db->from('tg_client');
        $this->db->where('username', $username);

        return $this->db->get()->row('id');

    }

    /**
     * get_user function.
     *
     * @access public
     * @param mixed $user_id
     * @return object the user object
     */
    public function get_user_mob($user_id)
    {

        $this->db->from('tg_client');
        $this->db->where('id', $user_id);
        return $this->db->get()->row();

    }

    /**
     * hash_password function.
     *
     * @access private
     * @param mixed $password
     * @return string|bool could be a string on success, or bool false on failure
     */
    private function hash_password($password)
    {

        return password_hash($password, PASSWORD_BCRYPT);

    }

    /**
     * verify_password_hash function.
     *
     * @access private
     * @param mixed $password
     * @param mixed $hash
     * @return bool
     */
    private function verify_password_hash($password, $hash)
    {
        return password_verify($password, $hash);
    }

}

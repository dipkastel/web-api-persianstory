<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Model_admin extends CI_Model {
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->database();
		$this->check_login();
		
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
	
	function check_login() {

		if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) {
			
		} else {
			redirect('login');
		}
	}


	 function login($username, $password)
 {
   $this -> db -> select('id, username, password');
   $this -> db -> from('admin_user');
   $this -> db -> where('username', $username);
   $this -> db -> where('password', MD5($password));
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }

public function get_id($name) {
	
    $this->db->select('id');
    $this->db->from('tg_dastan');
    $this->db->where('name',$name);
    $query = $this->db->get();
    if($query -> num_rows() >= 1) {
	
		$roww = $query->row();
		return $roww->id; 
	}else {
		return false;
}
}

	

public function update_rate($pid,$rate,$ip) {
	$this -> db -> select('*');
	$this -> db -> from('tg_rating');
	$this -> db -> where('pid', $pid);
	$this -> db -> where('userId', $ip);
	$query = $this -> db -> get();
	$roww = $query->row();
	
	if($query -> num_rows() >= 1) {
		$data = array(
			'rate'   => $rate
		);
		$this->db->where('pid', $pid);
		$this->db->where('userId', $ip);
		if($this->db->update('tg_rating', $data))
			echo 1;
	} else {
		$data = array(
			'pid'   => $pid,
			'rate'   => $rate,
			'userId'   => $ip
		);
		
		if($this->db->insert('tg_rating', $data))
			echo 0;
	}
}

public function get_dataSingle($tbl,$field,$value,$row) {
		//$array = array($field => $value, 'type' => $type);

	$this -> db -> select('*');
	$this -> db -> from($tbl);
	$this -> db -> where($field, $value);
	$query = $this -> db -> get();
	$roww = $query->row();
	return $roww->$row;
	}


public function get_dataCat($tbl,$field,$value,$row) {
		//$array = array($field => $value, 'type' => $type);

	$this -> db -> select('*');
	$this -> db -> from($tbl);
	$this -> db -> where($field, $value);
	$query = $this -> db -> get();
	$roww = $query->row();
	
	if($query -> num_rows() >= 1)
	return $roww->$row;
	else
		$this -> db -> select('*');
		$this -> db -> from($tbl);
		$this -> db -> where($field, '1');
		$query = $this -> db -> get();
		$roww = $query->row();
		return $roww->$row;
	}

public function get_countPage($tbl) {

	
        return $this->db->count_all($tbl);
    
	
}

	public function get_dataM($tbl) {

			$sql = "select * from $tbl ORDER BY id desc";
			
			$sql = $this->db->query($sql);


			return $sql->result_array(); 	
		
	}


	 public function get_dataMpages($tbl,$limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->order_by("id", "desc");
        $query = $this->db->get($tbl);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }



 
 // public function get_dataMpages($tbl,$limit,$offest) {

	// 		if(empty($offest)){
	// 			$offest = 1;
	// 		}
	// 		$offsett = ($offest  == 1) ? 0 : ($offest * $limit) - $limit;

	// 		$start = ($offest * $limit) -$limit;
	// 		//$start = ($offest - 1) * $limit;
	// 		$sql = "select * from $tbl ORDER BY id ASC LIMIT $start, $limit";
	// 		$sql = $this->db->query($sql);

	// 		return $sql->result_array(); 	
		
	// }





	public function insert_dastan($name,$teller,$kholase,$desc,$cat,$pic,$sound,$time,$status,$price) {
		
		$data = array(
			'name'   => $name,
			'teller'   => $teller,
			'content'   => $kholase,
			'description'      => $desc,
			'cat'      => $cat,
			'pic'      => $pic,
			'sound'      => $sound,
			'datetime'      => $time,
			'status'      => $status,
			'price'      => $price
			
		);
		
		if($this->db->insert('tg_dastan', $data))
			return true;
		else
			return false;
		
		
	}

public function insert_cat($name) {
		
		$data = array(
			'name'   => $name
			
		);
		
		if($this->db->insert('tg_cats', $data))
			return true;
		else
			return false;
		
		
	}

	public function update_cat($name,$id) {
		
		$data = array(
			'name'   => $name
			
		);
		$this->db->where('id', $id);
		if($this->db->update('tg_cats', $data))
			return true;
		else
			return false;
		
		
	}

	public function update_post($name,$teller,$kholase,$desc,$cat,$pic,$sound,$time,$id,$status,$price) {
		
		$data = array(
			'name'   => $name,
			'teller'   => $teller,
			'content'   => $kholase,
			'description'      => $desc,
			'cat'      => $cat,
			'pic'      => $pic,
			'sound'      => $sound,
			'datetime'      => $time,
			'status'      => $status,
			'price'      => $price
			
		);
		$this->db->where('id', $id);
		if($this->db->update('tg_dastan', $data))
			return true;
		else
			return false;
		
		
	}

public function removeCat($id)
{
   $this->db->where('id', $id);
   $this->db->delete('tg_cats'); 
}
public function removePost($id)
{
   $this->db->where('id', $id);
   if($this->db->delete('tg_dastan'))
   	return true;
   else
   	return false;
}
	


	
}
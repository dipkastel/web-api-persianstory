<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Model_home extends CI_Model {
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
		
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
	
	


	




public function get_dataSingle($tbl,$id) {
	
    $this->db->select('*');
    $this->db->from($tbl);
    $this->db->where('id',$id);
    $query = $this->db->get();
    if($query -> num_rows() >= 1)
	return $query->result_array(); 
	else
		return false;


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

public function get_popular() {

			$sql = "SELECT p.id,p.name,p.pic,p.content,p.price,p.datetime,AVG(pr.rate) AS rating_average FROM tg_dastan p INNER JOIN tg_rating pr ON pr.pid = p.id GROUP BY p.id ORDER BY rating_average DESC,p.datetime DESC,p.views DESC LIMIT 6";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;	
		
	}


public function get_count_popular() {

			$sql = "SELECT p.id FROM tg_dastan p INNER JOIN tg_rating pr ON pr.pid = p.id GROUP BY p.id";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;	
		
	}

public function get_count_votes($post_id) {
	$this->db->select('pid');
    $this->db->from("tg_rating");
    $this->db->where('pid',$post_id);
  $this->db->where('userId >','0');
    $query = $this->db->get();
    if($query -> num_rows() >= 1)
	return $query -> num_rows(); 
	else
		return false;
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

public function get_populars($limit, $start) {

			$sql = "SELECT p.id,p.name,p.pic,p.content,p.price,p.datetime,AVG(pr.rate) AS rating_average FROM tg_dastan p INNER JOIN tg_rating pr ON pr.pid = p.id GROUP BY p.id ORDER BY rating_average DESC,p.datetime DESC LIMIT $start,$limit";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;	
		
	}




public function get_rating($pid) {
       $this -> db -> select('*');
		$this -> db -> from("tg_rating");
		$this -> db -> where("pid", $pid);
		$query = $this->db->get();
		return $query->result_array(); 
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


public function update_rate_mob($pid,$rate,$ip) {
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
			return true;
	} else {
		$data = array(
			'pid'   => $pid,
			'rate'   => $rate,
			'userId'   => $ip
		);
		
		if($this->db->insert('tg_rating', $data))
			return true;
	}
return false;
}




public function get_count_rate($pid,$rate) {

	$this -> db -> select('*');
	$this -> db -> from('tg_rating');
	$this -> db -> where('pid', $pid);
	$this -> db -> where('rate', $rate);
	$query = $this -> db -> get();
	$roww = $query->row();
	
	return $query -> num_rows();
	
	
		
	}

public function calc_rate($pid) {
	
	$one = $this->get_count_rate($pid,1);
	$two = $this->get_count_rate($pid,2);
	$three = $this->get_count_rate($pid,3);
	$four = $this->get_count_rate($pid,4);
	$five = $this->get_count_rate($pid,5);

	$res = $five + $four + $three + $two + $one;
	if($res > 0)
		$res = ($five*5 + $four*4 + $three*3 + $two*2 + $one*1) / ($five + $four + $three + $two + $one);
	else
		$res = 0;
	return $res;
	
		
	}

public function get_find($title) {
		$sql = "SELECT *, MATCH (name) AGAINST ('$title') AS score FROM tg_dastan WHERE MATCH (name) AGAINST ('$title') ORDER BY score ASC";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;	
	
}






	public function insert_dastan($name,$desc,$cat,$pic,$sound,$time,$status,$price) {
		
		$data = array(
			'name'   => $name,
			'description'      => $desc,
			'cat'      => $cat,
			'pic'      => $pic,
			'sound'      => $sound,
			'datetime'      => $time,
			'status'      => $status,
			'price'      => $price
			
		);
		
		return $this->db->insert('tg_dastan', $data);
		
		
	}

public function insert_cat($name) {
		
		$data = array(
			'name'   => $name
			
		);
		
		return $this->db->insert('tg_cats', $data);
		
		
	}

	public function update_cat($name,$id) {
		
		$data = array(
			'name'   => $name
			
		);
		$this->db->where('id', $id);
		return $this->db->update('tg_cats', $data);
		
		
	}

	public function update_view($id,$view) {
		
		$data = array(
			'views'   => $view + 1
			
		);
		$this->db->where('id', $id);
		return $this->db->update('tg_dastan', $data);
		
		
	}



	public function update_post($name,$desc,$cat,$pic,$sound,$time,$id,$status,$price) {
		
		$data = array(
			'name'   => $name,
			'description'      => $desc,
			'cat'      => $cat,
			'pic'      => $pic,
			'sound'      => $sound,
			'datetime'      => $time,
			'status'      => $status,
			'price'      => $price
			
		);
		$this->db->where('id', $id);
		return $this->db->update('tg_dastan', $data);
		
		
	}

public function removeCat($id)
{
   $this->db->where('id', $id);
   $this->db->delete('tg_cats'); 
}
public function removePost($id)
{
   $this->db->where('id', $id);
   $this->db->delete('tg_dastan'); 
}
	


	
}
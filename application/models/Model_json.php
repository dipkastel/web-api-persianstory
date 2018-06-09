<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Model_json extends CI_Model
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
        date_default_timezone_set("Asia/Tehran");
        $this->load->database();


    }
    //mycodes
    public function getArchive($tbl, $limit, $start)
    {
        $this->db->cache_on();
        $sql = "SELECT id,name,pic,sound,teller,price,datetime FROM tg_dastan ORDER BY id DESC LIMIT $start,$limit";
        $query = $this->db->query($sql);
        $data = [];
        foreach ($query->result() as $row) {
            $rate = round($this->model_json->calc_rate($row->id), 1);

            $row->rating_average = $rate;
            $data[] = $row;


        }
        return $data;
    }


    //shit codes
    public function get_countPage($tbl)
    {
        return $this->db->count_all($tbl);
    }


    public function get_dataSingle($tbl, $id)
    {

        $this->db->select('name,pic,teller,sound,');
        $this->db->from($tbl);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            foreach ($query->result() as $row) {

                $data[] = $row;
            }
            return $data;
        } else
            return false;


    }


    public function get_archive($tbl, $limit, $start)
    {
        $this->db->cache_on();
        $sql = "SELECT id,name,pic,sound,teller,price,datetime FROM tg_dastan ORDER BY datetime DESC LIMIT $start,$limit";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $rate = round($this->model_json->calc_rate($row->id), 1);

                $row->rating_average = $rate;
                $data[] = $row;


            }
            return $data;
        } else {
            $data[]['status'] = '0';
            return $data;
        }
    }

    public function get_populars($limit, $start)
    {
        $this->db->cache_on();
        $sql = "SELECT p.id,p.name,p.pic,p.price,p.sound,p.teller,p.datetime,ROUND(AVG(pr.rate),2) AS rating_average FROM tg_dastan p INNER JOIN tg_rating pr ON pr.pid = p.id WHERE pr.userId > 0 GROUP BY p.id ORDER BY rating_average DESC,p.views DESC,p.datetime DESC LIMIT $start,$limit";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $rate = round($this->model_json->calc_rate($row->id), 1);

                $row->rating_average = $rate;
                $data[] = $row;
            }
            return $data;
        } else {
            $data[]['status'] = '0';
            return $data;
        }

    }


    public function get_rating($pid)
    {
        $this->db->select('rate');
        $this->db->from("tg_rating");
        $this->db->where("pid", $pid);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_count_rate($pid, $rate)
    {

        $this->db->select('*');
        $this->db->from('tg_rating');
        $this->db->where('pid', $pid);
        $this->db->where('rate', $rate);
        $query = $this->db->get();
        $roww = $query->row();

        return $query->num_rows();


    }

    public function calc_rate($pid)
    {

        $one = $this->get_count_rate($pid, 1);
        $two = $this->get_count_rate($pid, 2);
        $three = $this->get_count_rate($pid, 3);
        $four = $this->get_count_rate($pid, 4);
        $five = $this->get_count_rate($pid, 5);

        $res = $five + $four + $three + $two + $one;
        if ($res > 0)
            $res = ($five * 5 + $four * 4 + $three * 3 + $two * 2 + $one * 1) / ($five + $four + $three + $two + $one);
        else
            $res = 0;
        return $res;


    }


    public function insert_client($key, $name, $tell)
    {

        $data = array(
            'name' => $name,
            'tell' => $tell,
            'key' => $key,
            'price' => 0,
            'datetime' => time(),
            'ip' => $_SERVER['REMOTE_ADDR']
        );

        if ($this->db->insert('tg_clients', $data))
            return true;
        else
            return false;


    }

    public function f_check_mail($email)
    {

        $this->db->select('*');
        $this->db->from('tg_client');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
        return false;
    }


    public function update_hashExp($email)
    {


        $this->db->select('*');
        $this->db->from('tg_client');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $roww = $query->row();

        if ($query->num_rows() > 0) {
            $time = date('h:i:s');
            $endTime = strtotime("+5 minutes", strtotime($time));
            $data = array(
                'hash_exp' => $endTime,
                'hash_code' => substr(md5($endTime), 5, 4)
            );
            $this->db->where('email', $email);

            if ($this->db->update('tg_client', $data))
                return substr(md5($endTime), 5, 4);
        } else {
            return false;
        }
        return false;
    }


    public function get_user($hash)
    {
        $time = strtotime(date('h:i:s'));
        $this->db->select('*');
        $this->db->from('tg_client');
        $this->db->where('hash_exp >', $time);
        $this->db->where('hash_code', $hash);

        $query = $this->db->get();
        $roww = $query->row();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_username2($email)
    {
        $time = strtotime(date('h:i:s'));
        $this->db->select('username');
        $this->db->from('tg_client');
        $this->db->where('email', $email);

        $query = $this->db->get();
        $roww = $query->row();
        if ($query->num_rows() > 0) {
            return $roww->username;
        } else {
            return false;
        }
    }


    public function insert_buy($userid, $pid)
    {
        $data = array(
            'client' => $userid,
            'pid' => $pid,
            'date' => time(),
            'ip' => $_SERVER['REMOTE_ADDR']
        );

        if ($this->db->insert('tg_buy', $data))
            return true;
        else
            return false;


    }


    public function insert_pay($cid, $token, $pack)
    {
        $data = array(
            'cid' => $cid,
            'token' => $token,
            'date' => time(),
            'pack' => $pack,
            'ip' => $_SERVER['REMOTE_ADDR']
        );

        $insert = $this->db->insert('tg_pay', $data);
        if ($insert) {
            return true;
        } else {
            return false;
        }
        return false;

    }


    public function update_coin($userid, $coin)
    {


        $this->db->select('*');
        $this->db->from('tg_client');
        $this->db->where('id', $userid);
        $query = $this->db->get();
        $roww = $query->row();

        if ($query->num_rows() > 0) {

            $coinn = (int)$roww->price + $coin;
            $data = array(
                'price' => $coinn,
            );
            $this->db->where('id', $userid);

            if ($this->db->update('tg_client', $data))
                return true;
            else return false;
        } else {
            return false;
        }
        return false;
    }

    public function update_price_profile($userid, $price)
    {
        $data = array(
            'price' => $price

        );
        $this->db->where('id', $userid);

        if ($this->db->update('tg_client', $data))
            return true;
        else return false;
    }

    public function check_buy($userid, $token)
    {

        $this->db->select('*');
        $this->db->from('tg_pay');
        $this->db->where('cid', $userid);
        $this->db->where('token', $token);
        $query = $this->db->get();
        $roww = $query->row();
        if ($query->num_rows() > 0)
            return true;
        else
            return false;

    }

    public function get_buy($pid, $userId)
    {

        $this->db->select('id');
        $this->db->from('tg_buy');
        $this->db->where('pid', $pid);
        $this->db->where('client', $userId);
        $query = $this->db->get();
        $roww = $query->row();
        return $query->num_rows();
    }


    public function get_client($key)
    {
        $this->db->select('price');
        $this->db->from("tg_clients");
        $this->db->where("key", $key);
        $query = $this->db->get();
        $roww = $query->row();
        return $roww->price;
    }

    public function get_coin($userid)
    {

        $this->db->select_sum('pack');
        $this->db->where('cid', $userid);
        $q = $this->db->get('tg_pay');
        if ($q->num_rows() > 0) {
            $roww = $q->row();
            $coin = $roww->pack;
            return $coin;
        } else {
            false;
        }
        return false;
    }

}
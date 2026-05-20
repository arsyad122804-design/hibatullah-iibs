<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{
    function ChekingUserByUsn($usn)
    {
        $this->db->select("*");
        //$this->db->join("sys_level b", 'b.id_level = a.id_level');
        $this->db->where("username", $usn);
        return $this->db->get('sys_user');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_slider extends CI_Model
{
    function GetAllDataUser()
    {
        return $this->db->get("sys_slider");
    }
    function update_data($data, $id)
    {
        $this->db->set($data);
        $this->db->where('id_slide', $id);
        $this->db->update('sys_slider');
        return true;
    }
}

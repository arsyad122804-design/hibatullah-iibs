<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_User extends CI_Model
{
    function GetAllDataUser()
    {
        $this->db->select("*");
        $this->db->join("sys_level b", "b.id_level = a.id_level");
        $this->db->join("data_kantor_cabang c", "c.id = a.fid_cabang", 'LEFT');
        $this->db->where("a.id_user!=", 1);
        $this->db->where("a.id_level", 22);
        return $this->db->get("sys_user a");
    }
    function GetAllDataUserLAZ()
    {
        $this->db->select("*");
        $this->db->join("sys_level b", "b.id_level = a.id_level");
        $this->db->join("data_kantor_cabang c", "c.id = a.fid_cabang");
        $this->db->where("a.id_level", 8);
        return $this->db->get("sys_user a");
    }
    function GetAllDataUserBy($cabang)
    {
        $this->db->select("*");
        $this->db->join("sys_level b", "b.id_level = a.id_level");
        $this->db->join("data_kantor_cabang c", "c.id = a.fid_cabang");
        $this->db->where("fid_cabang", $cabang);
        return $this->db->get("sys_user a");
    }
    function GetDataSantri($cabang)
    {
        return $this->db->get_where("data_pelajar", ['cabang_id' => $cabang]);
    }

    function GetDataDonatur($cabang)
    {
        return $this->db->get_where("data_pelajar", ['cabang_id' => $cabang]);
    }
    function GetDataKaryawan($cabang)
    {
        return $this->db->get_where("data_karyawan", ['cabang_id' => $cabang]);
    }
    function SaveData($result)
    {
        if ($this->db->insert("sys_user", $result)) {
            return true;
        } else {
            return false;
        };
    }
    function DeletData($id)
    {
        $this->db->where("id_user", $id);
        if ($this->db->delete("sys_user")) {
            return true;
        } else {
            return false;
        };
    }
}

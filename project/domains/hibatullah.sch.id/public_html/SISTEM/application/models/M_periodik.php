<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_periodik extends CI_Model
{
    function GetAllDataPeriodik()
    {
        $this->db->select("a.*,b.nama_cabang,c.set_active");
        $this->db->join("data_kantor_cabang b", 'b.id = a.cabang_id');
        $this->db->join("sys_active c", 'c.id = a.active');
        $this->db->where('a.hapus', 0);
        $this->db->order_by('a.active', "DESC");
        return $this->db->get("master_periodik_akademik a");
    }
    function GetAllDataPeriodikByCabang($cabang)
    {
        $this->db->select("a.*,b.nama_cabang,c.set_active");
        $this->db->join("data_kantor_cabang b", 'b.id = a.cabang_id');
        $this->db->join("sys_active c", 'c.id = a.active');
        $this->db->where('a.hapus', 0);
        $this->db->where('a.cabang_id', $cabang);
        $this->db->order_by('a.active', "DESC");
        return $this->db->get("master_periodik_akademik a");
    }
    function GetAllDataPeriodikByCabangALL($cabang)
    {
        $this->db->select("a.*,b.nama_cabang,c.set_active");
        $this->db->join("data_kantor_cabang b", 'b.id = a.cabang_id');
        $this->db->join("sys_active c", 'c.id = a.active');
        $this->db->where('a.hapus', 0);
        $this->db->where('a.cabang_id', $cabang);
        $this->db->order_by('a.active', "DESC");
        return $this->db->get("master_periodik_akademik a");
    }
    function GetAllDataPeriodikByid($id)
    {
        $this->db->select("a.*,b.nama_cabang,c.set_active");
        $this->db->join("data_kantor_cabang b", 'b.id = a.cabang_id');
        $this->db->join("sys_active c", 'c.id = a.active');
        $this->db->where('a.hapus', 0);
        $this->db->where('a.id_akademik', $id);
        $this->db->order_by('a.active', "DESC");
        return $this->db->get("master_periodik_akademik a");
    }
    function GetDataAktifByCabang($cabang)
    {
        $this->db->where('cabang_id', $cabang);
        $this->db->where('active', 1);
        return $this->db->get("master_periodik_akademik");
    }
}

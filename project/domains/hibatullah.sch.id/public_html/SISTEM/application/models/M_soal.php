<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_soal extends CI_Model
{
    function GetAllSoal()
    {
        $this->db->select("a.*,b.nama_asli");
        $this->db->join('aa_user b', 'b.id_user = a.usr_id');
        $this->db->order_by('a.id', 'DESC');
        $data = $this->db->get("mhs2_master_soal a");
        return $data;
    }

    function GetAllSoalByUser($idu)
    {
        $this->db->select("a.*,b.nama_asli");
        $this->db->join('aa_user b', 'b.id_user = a.usr_id');
        $this->db->where("a.usr_id", $idu);
        $this->db->order_by('a.id', 'DESC');
        $data = $this->db->get("mhs2_master_soal a");
        return $data;
    }

    function GetAllSoalBy($id)
    {
        $this->db->select("a.*,b.nama_asli");
        $this->db->join('aa_user b', 'b.id_user = a.usr_id');
        $this->db->where('a.id', $id);
        $this->db->order_by('a.id', 'DESC');
        $data = $this->db->get("mhs2_master_soal a");
        return $data;
    }
    function GetAllUser()
    {
        return  $this->db->get_where('aa_user');
    }
    function GetAllUserByID($idu)
    {
        return  $this->db->get_where('aa_user', ['id_user' => $idu]);
    }

    function GetAllSoalPertama()
    {
        $this->db->select("a.*,b.nama_asli");
        $this->db->join('aa_user b', 'b.id_user = a.usr_id');
        $this->db->where('a.modulid', 1);
        $this->db->order_by('a.id', 'RAND()');
        $data = $this->db->get("mhs2_master_soal a");
        return $data;
    }

    function GetSoalUjian()
    {
        $this->db->select('a.*,b.modul,c.nama_asli');
        $this->db->join('mhs2_master_modul_soal b', 'b.id = a.modul_id');
        $this->db->join('aa_user c', 'c.id_user = a.usr_id');
        return $this->db->get("mhs2_master_ujian a");
    }

    function cari_kategori($like)
    {
        $this->db->like('kategori_soal', $like, 'both');
        $this->db->group_by('kategori_soal');
        $this->db->order_by('kategori_soal', 'ASC');
        $this->db->limit(10);
        return $this->db->get('mhs2_master_soal');
    }

    function getUjianByToken($token)
    {
        $this->db->where("token", $token);
        return $this->db->get("mhs2_master_ujian_detail");
    }

    function cari_kategorList($kode, $res)
    {
        $this->db->like('kategori_soal', $kode, 'both');
        $this->db->where_not_in('id', $res);
        $this->db->order_by('id', 'ASC');
        $this->db->limit(100);
        return $this->db->get('mhs2_master_soal');
    }
    function GetkodeUji()
    {
        $this->db->select('IFNULL(MAX(id),0)+1 as id');
        return $this->db->get("mhs2_master_ujian");
    }

    function getDataUjianDTLBy($token)
    {
        $this->db->select("*");
        $this->db->join("mhs2_master_soal b", "b.id = a.soal_id");
        $this->db->where("a.token", $token);
        return $this->db->get('mhs2_master_ujian_detail a');
    }
}

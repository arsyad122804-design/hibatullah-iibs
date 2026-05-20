<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_withdraw extends CI_Model
{
    function GetAllDataUser()
    {

        $QR = "SELECT a.*,b.*,c.nama_cabang,d.nama_asli,e.registrasi as fee FROM master_pmb_register_pelajar a
       LEFT JOIN master_pmb_status b ON b.id_status = a.status_pelajar
       LEFT JOIN data_kantor_cabang c ON c.id = a.cabang_id
       LEFT JOIN sys_user d ON d.id_user = a.aff_id 
       LEFT JOIN master_pmb_tahun_akademik e ON e.tahun_akademik = a.periode 
       where a.status_pelajar >=3
       ";
        return $this->db->query($QR);
    }
    function GetAllDataUserByTa($ta)
    {

        $QR = "SELECT a.*,b.*,c.nama_cabang,d.nama_asli,e.registrasi as fee FROM master_pmb_register_pelajar a
       LEFT JOIN master_pmb_status b ON b.id_status = a.status_pelajar
       LEFT JOIN data_kantor_cabang c ON c.id = a.cabang_id 
       LEFT JOIN sys_user d ON d.id_user = a.aff_id
       LEFT JOIN master_pmb_tahun_akademik e ON e.tahun_akademik = a.periode
       WHERE e.id_tahun='$ta' and a.status_pelajar >=3";
        return $this->db->query($QR);
    }
    function GetAllDataUserID($id)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.nama_asli,e.registrasi as fee FROM master_pmb_register_pelajar a
       LEFT JOIN master_pmb_status b ON b.id_status = a.status_pelajar
       LEFT JOIN data_kantor_cabang c ON c.id = a.cabang_id
       LEFT JOIN sys_user d ON d.id_user = a.aff_id
       LEFT JOIN master_pmb_tahun_akademik e ON e.tahun_akademik = a.periode
       WHERE a.aff_id = '$id' and a.status_pelajar >=3";
        return $this->db->query($QR);
    }
    function GetAllDataUserIDBy($id, $ta)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.nama_asli,e.registrasi as fee FROM master_pmb_register_pelajar a
       LEFT JOIN master_pmb_status b ON b.id_status = a.status_pelajar
       LEFT JOIN data_kantor_cabang c ON c.id = a.cabang_id
       LEFT JOIN sys_user d ON d.id_user = a.aff_id
       LEFT JOIN master_pmb_tahun_akademik e ON e.tahun_akademik = a.periode
       WHERE a.aff_id = '$id' and e.id_tahun='$ta' and a.status_pelajar >=3";
        return $this->db->query($QR);
    }
    function GetAllDataUserBy($cb)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.nama_asli,e.registrasi as fee FROM master_pmb_register_pelajar a
       LEFT JOIN master_pmb_status b ON b.id_status = a.status_pelajar
       LEFT JOIN data_kantor_cabang c ON c.id = a.cabang_id
       LEFT JOIN sys_user d ON d.id_user = a.aff_id
       LEFT JOIN master_pmb_tahun_akademik e ON e.tahun_akademik = a.periode
       WHERE a.cabang_id = '$cb' and a.status_pelajar >=3";
        return $this->db->query($QR);
    }
}

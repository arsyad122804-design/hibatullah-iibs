<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_pendaftar extends CI_Model
{
    function GetAllDataUser()
    {

        $QR = "SELECT *,c.nama_cabang,e.nama_asli FROM master_pmb_register_pelajar a
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
       LEFT JOIN sys_user e ON e.id_user = a.aff_id";
        return $this->db->query($QR);
    }
    function GetAllDataUserByTa($ta)
    {

        $QR = "SELECT *,c.nama_cabang,e.nama_asli FROM master_pmb_register_pelajar a
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
       LEFT JOIN sys_user e ON e.id_user = a.aff_id
       WHERE b.id_tahun='$ta'";
        return $this->db->query($QR);
    }
    function GetAllDataUserID($id)
    {
        $QR = "SELECT *,c.nama_cabang,e.nama_asli FROM master_pmb_register_pelajar a
        LEFT JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        LEFT JOIN data_kantor_cabang c ON c.id = a.cabang_id
        LEFT JOIN master_pmb_status d ON d.id_status = a.status_pelajar
       LEFT JOIN sys_user e ON e.id_user = a.aff_id
       WHERE a.aff_id = '$id'";
        return $this->db->query($QR);
    }
    function GetAllDataUserIDBy($id, $ta)
    {
        $QR = "SELECT *,c.nama_cabang,e.nama_asli FROM master_pmb_register_pelajar a
        LEFT JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        LEFT JOIN data_kantor_cabang c ON c.id = a.cabang_id
        LEFT JOIN master_pmb_status d ON d.id_status = a.status_pelajar
       LEFT JOIN sys_user e ON e.id_user = a.aff_id
       WHERE a.aff_id = '$id' and b.id_tahun='$ta'";
        return $this->db->query($QR);
    }
    function GetAllDataUserBy($cb)
    {
        $QR = "SELECT *,c.nama_cabang,e.nama_asli FROM master_pmb_register_pelajar a
        LEFT JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        LEFT JOIN data_kantor_cabang c ON c.id = a.cabang_id
        LEFT JOIN master_pmb_status d ON d.id_status = a.status_pelajar
       LEFT JOIN sys_user e ON e.id_user = a.aff_id
       WHERE a.cabang_id = '$cb'";
        return $this->db->query($QR);
    }
}

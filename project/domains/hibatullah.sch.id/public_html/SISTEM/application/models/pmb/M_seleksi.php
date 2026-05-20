<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_seleksi extends CI_Model
{
    function get_dataPendaftarByCabang($cb)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.status ,a.email as email_set,a.alamat as alamat_set 
        FROM master_pmb_register_pelajar a 
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
        WHERE a.cabang_id='$cb' order by b.id_tahun DESC ";
        return $this->db->query($QR);
    }
    function get_dataPendaftarByCBPeriode($cb, $pr)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.status ,a.email as email_set,a.alamat as alamat_set 
        FROM master_pmb_register_pelajar a 
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
        WHERE a.cabang_id='$cb' AND b.id_tahun='$pr'";
        return $this->db->query($QR);
    }
    function get_dataPendaftarByPeriode($pr)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.status ,a.email as email_set,a.alamat as alamat_set  
        FROM master_pmb_register_pelajar a 
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
        WHERE b.id_tahun='$pr' Order by a.cabang_id ASC";
        return $this->db->query($QR);
    }
}

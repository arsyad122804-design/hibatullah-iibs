<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_pendaftar extends CI_Model
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
    function get_dataPendaftarByID($id, $jns)
    {
        $QR = "SELECT *,c.nama_cabang,d.status,a.email as email_set,a.alamat as alamat_set 
        FROM master_pmb_register_pelajar a 
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
        LEFT JOIN master_wilayah_kota e ON e.id = a.id_kota
        LEFT JOIN master_pmb_reg f ON f.nomor_reg = a.nomor_registrasi and f.jns ='$jns'
        WHERE a.nomor_registrasi='$id'";
        return $this->db->query($QR);
    }

    function GetDataPelajarByNis($id)

    {

        $this->db->select("a.*,b.nama_cabang,b.cabang_kode,b.pengurus,c.*,
        (SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,
        (SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,
        (SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,
        (SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan,
        (SELECT nama_lengkap FROM data_karyawan where id_karyawan =  a.management) as nama_guru");

        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");

        $this->db->join("master_pmb_status c", 'c.id_status = a.status_pelajar');

        $this->db->where("a.hapus", 0);

        $this->db->where("a.nomor_registrasi", $id);

        return $this->db->get("master_pmb_register_pelajar a");
    }
    function GetDataPelajarById($id)

    {

        $this->db->select("a.*,b.nama_cabang,b.cabang_kode,c.*,
        (SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,
        (SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,
        (SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,
        (SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan,
        (SELECT nama_lengkap FROM data_karyawan where id_karyawan =  a.management) as nama_guru");

        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");

        $this->db->join("master_pmb_status c", 'c.id_status = a.status_pelajar');

        $this->db->where("a.hapus", 0);

        $this->db->where("a.id_pelajar", $id);

        return $this->db->get("master_pmb_register_pelajar a");
    }
}

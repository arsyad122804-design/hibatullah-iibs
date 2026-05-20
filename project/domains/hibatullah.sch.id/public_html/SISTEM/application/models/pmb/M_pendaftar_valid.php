<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_pendaftar_valid  extends CI_Model
{
    function get_dataPendaftarByCabang($cb)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.status FROM master_pmb_register_pelajar a 
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
        WHERE a.cabang_id='$cb' and a.status_pelajar > 4  order by b.id_tahun DESC ";
        return $this->db->query($QR);
    }
    function get_dataPendaftarByCBPeriode($cb, $pr)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.status FROM master_pmb_register_pelajar a 
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
        WHERE a.cabang_id='$cb' AND b.id_tahun='$pr' and a.status_pelajar > 4";
        return $this->db->query($QR);
    }
    function get_dataPendaftarByCbMigrasi($cb, $pr)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.status FROM master_pmb_register_pelajar a 
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
        WHERE a.cabang_id='$cb' AND b.id_tahun='$pr' and a.status_pelajar =5";
        return $this->db->query($QR);
    }
    function get_dataPendaftarByCbMigrasiBy($cb, $pr, $id)
    {
        $this->db->select("a.*,b.*,c.nama_cabang,d.status");
        $this->db->join("master_pmb_tahun_akademik b", 'b.tahun_akademik = a.periode', "INNER");
        $this->db->join("data_kantor_cabang c", 'c.id = a.cabang_id', "INNER");
        $this->db->join("master_pmb_status d", 'd.id_status = a.status_pelajar', "INNER");
        $this->db->where("a.cabang_id", $cb);
        $this->db->where("b.id_tahun", $pr);
        $this->db->where("a.status_pelajar", '5');
        $this->db->where_in('a.id_pelajar', $id);
        return $this->db->get("master_pmb_register_pelajar a ");
    }
    function get_dataPendaftarByPeriode($pr)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.status  FROM master_pmb_register_pelajar a 
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
        WHERE b.id_tahun='$pr' and a.status_pelajar > 4 Order by a.cabang_id ASC";
        return $this->db->query($QR);
    }
    function get_dataPendaftarByID($id)
    {
        $QR = "SELECT a.*,b.*,c.nama_cabang,d.status,a.alamat as alamat_set,a.email as email_set  FROM master_pmb_register_pelajar a 
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode 
        INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
        INNER JOIN master_pmb_status d ON d.id_status = a.status_pelajar
        WHERE a.nomor_registrasi='$id'";
        return $this->db->query($QR);
    }

    function GetDataPelajarByNis($id)

    {

        $this->db->select("a.*,b.nama_cabang,b.cabang_kode,c.*,(SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,(SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,(SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,(SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan,(SELECT infaq_bulanan FROM master_infaq_santri_bulanan where id_nominal =  a.infaq_bulanan) as bulanan,(SELECT infaq_tahunan FROM master_infaq_santri_tahunan where id_nominal =  a.infaq_tahunan) as tahunan,(SELECT nama_lengkap FROM data_karyawan where id_karyawan =  a.management) as nama_guru");

        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");

        $this->db->join("master_pmb_status c", 'c.id_status = a.status_pelajar');

        $this->db->where("a.hapus", 0);

        $this->db->where("a.nomor_registrasi", $id);

        return $this->db->get("master_pmb_register_pelajar a");
    }
    function GetDataPelajarById($id)

    {

        $this->db->select("a.*,b.nama_cabang,b.cabang_kode,c.*,(SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,(SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,(SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,(SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan,(SELECT infaq_bulanan FROM master_infaq_santri_bulanan where id_nominal =  a.infaq_bulanan) as bulanan,(SELECT infaq_tahunan FROM master_infaq_santri_tahunan where id_nominal =  a.infaq_tahunan) as tahunan,(SELECT nama_lengkap FROM data_karyawan where id_karyawan =  a.management) as nama_guru");

        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");

        $this->db->join("master_pmb_status c", 'c.id_status = a.status_pelajar');

        $this->db->where("a.hapus", 0);

        $this->db->where("a.id_pelajar", $id);

        return $this->db->get("master_pmb_register_pelajar a");
    }
}

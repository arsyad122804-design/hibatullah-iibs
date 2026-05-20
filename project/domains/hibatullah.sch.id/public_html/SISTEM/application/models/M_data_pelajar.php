<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_data_pelajar extends CI_Model
{
    function GetAllDataPelajar()
    {
        $this->db->select("*");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->where("a.hapus", 0);
        return $this->db->get("data_pelajar a");
    }
    function GetAllDataPelajarByCab($id)
    {
        $this->db->select("*");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.cabang_id", $id);
        return $this->db->get("data_pelajar a");
    }
    function GetDataPelajarByCB($cb)
    {
        $this->db->select("a.*,b.nama_cabang,b.cabang_kode,c.*,(SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,(SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,(SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,(SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan,(SELECT infaq_bulanan FROM master_infaq_santri_bulanan where id_nominal =  a.infaq_bulanan) as bulanan,(SELECT infaq_tahunan FROM master_infaq_santri_tahunan where id_nominal =  a.infaq_tahunan) as tahunan,(SELECT nama_lengkap FROM data_karyawan where id_karyawan =  a.management) as nama_guru");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.cabang_id", $cb);
        return $this->db->get("data_pelajar a");
    }
    function GetAllDataPelajarByCabGr($id, $idg)
    {
        $this->db->select("*");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->join("data_kelas_detail d", 'd.pelajar_id = a.id_pelajar');
        $this->db->join("data_kelas e", 'e.id_kelas =d.kelas_id');
        $this->db->where("a.id_pelajar", $idg);
        $this->db->where("a.hapus", 0);
        $this->db->where("a.cabang_id", $id);
        return $this->db->get("data_pelajar a");
    }
    function GetAllDataPelajarByCabGrGA($id, $idg, $ta)
    {
        $this->db->select("*");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->join("data_kelas_detail d", 'd.pelajar_id = a.id_pelajar');
        $this->db->join("data_kelas e", 'e.id_kelas =d.kelas_id');
        $this->db->where("a.id_pelajar", $idg);
        $this->db->where("a.hapus", 0);
        $this->db->where("a.cabang_id", $id);
        $this->db->where("e.akademik_id", $ta);
        return $this->db->get("data_pelajar a");
    }
    function GetAllDataPelajarByCabIDK($id, $idg)
    {
        $this->db->select("*");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->join("data_kelas_detail d", 'd.pelajar_id = a.id_pelajar');
        $this->db->join("data_kelas e", 'e.id_kelas =d.kelas_id');
        $this->db->where("e.karyawan_id", $idg);
        $this->db->where("a.hapus", 0);
        $this->db->where("a.cabang_id", $id);
        return $this->db->get("data_pelajar a");
    }
    function GetAllDataPelajarByCabIDKGA($id, $idg, $ta)
    {
        $this->db->select("*");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->join("data_kelas_detail d", 'd.pelajar_id = a.id_pelajar');
        $this->db->join("data_kelas e", 'e.id_kelas =d.kelas_id');
        $this->db->where("e.karyawan_id", $idg);
        $this->db->where("e.akademik_id", $ta);
        $this->db->where("a.hapus", 0);
        $this->db->where("a.cabang_id", $id);
        return $this->db->get("data_pelajar a");
    }
    function GetAllDataPelajarByCabIDKTHS($id, $idg)
    {
        $this->db->select("*");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->join("data_kelas_tahsin_detail d", 'd.pelajar_id = a.id_pelajar');
        $this->db->join("data_kelas_tahsin e", 'e.id_kelas =d.kelas_id');
        $this->db->where("e.karyawan_id", $idg);
        $this->db->where("a.hapus", 0);
        $this->db->where("a.cabang_id", $id);
        return $this->db->get("data_pelajar a");
    }

    function GetAllDataPelajarByCabIDAK($cb, $id, $ta)
    {
        $QR = "SELECT * FROM data_pelajar a 
        INNER JOIN data_kantor_cabang b ON b.id = a.cabang_id
        INNER JOIN sys_active c ON c.id = a.status_pelajar
        INNER JOIN data_akademik_rombel_detail d ON d.pelajar_id = a.id_pelajar AND d.pertemuan_id='$ta'
        INNER JOIN data_akademik_jadwal f ON f.rombel_id = d.rombel_id
        WHERE f.karyawan_id='$id' AND a.cabang_id='$cb' AND d.pertemuan_id='$ta' GROUP BY a.id_pelajar;";
        return $this->db->query($QR);
    }
    function GetDataPelajarBy($id)
    {
        $this->db->select("a.*,b.nama_cabang,b.cabang_kode,c.*,(SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,(SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,(SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,(SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan,(SELECT infaq_bulanan FROM master_infaq_santri_bulanan where id_nominal =  a.infaq_bulanan) as bulanan,(SELECT infaq_tahunan FROM master_infaq_santri_tahunan where id_nominal =  a.infaq_tahunan) as tahunan,(SELECT nama_lengkap FROM data_karyawan where id_karyawan =  a.management) as nama_guru");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.id_pelajar", $id);
        return $this->db->get("data_pelajar a");
    }
    function GetDataPelajarByNis($id)
    {
        $this->db->select("a.*,b.nama_cabang,b.cabang_kode,c.*,(SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,(SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,(SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,(SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan,(SELECT infaq_bulanan FROM master_infaq_santri_bulanan where id_nominal =  a.infaq_bulanan) as bulanan,(SELECT infaq_tahunan FROM master_infaq_santri_tahunan where id_nominal =  a.infaq_tahunan) as tahunan,(SELECT nama_lengkap FROM data_karyawan where id_karyawan =  a.management) as nama_guru");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.id_pelajar", $id);
        return $this->db->get("data_pelajar a");
    }
    function HapusData($id)
    {
        $this->db->where('id_pelajar', $id);
        if ($this->db->delete("data_pelajar")) {
            return true;
        } else {
            return false;
        }
    }
}

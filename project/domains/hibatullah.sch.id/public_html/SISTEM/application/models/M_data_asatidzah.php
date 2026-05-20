<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_data_asatidzah extends CI_Model
{
    function GetAllDataAsatid()
    {
        $this->db->select("*");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pengajar');
        $this->db->where("a.hapus", 0);
        return $this->db->get("data_karyawan a");
    }

    function GetAllDataAsatidByCab($id)
    {
        $this->db->select("*");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pengajar');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.cabang_id", $id);
        return $this->db->get("data_karyawan a");
    }
    function GetAllDataAsatidByGuru($id)
    {
        $this->db->select("*");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pengajar');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.id_karyawan", $id);
        return $this->db->get("data_karyawan a");
    }

    function GetDataAsatidBy($id)
    {
        $this->db->select("a.*,b.nama_cabang,c.*,(SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,(SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,(SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,(SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pengajar');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.id_karyawan", $id);
        return $this->db->get("data_karyawan a");
    }
    function GetDataAsatidByCabang($id)
    {
        $this->db->select("a.*,b.nama_cabang,c.*,(SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,(SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,(SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,(SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pengajar');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.cabang_id", $id);
        return $this->db->get("data_karyawan a");
    }

    function HapusData($id)
    {
        $this->db->where('id_karyawan', $id);
        if ($this->db->delete("data_karyawan")) {
            return true;
        } else {
            return false;
        }
    }
    function HapusDataKompetensi($id)
    {
        $this->db->where('karyawan_id', $id);
        if ($this->db->delete("data_karyawan_kompetensi")) {
            return true;
        } else {
            return false;
        }
    }
}

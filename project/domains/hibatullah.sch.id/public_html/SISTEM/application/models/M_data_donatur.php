<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_data_donatur extends CI_Model
{
    function GetAllDataDonatur()
    {
        $this->db->select("a.*,b.nama_cabang,c.set_active,d.cara_donasi,(SELECT infaq FROM master_infaq_donatur WHERE id_nominal= d.infaq_id) as donasi,(SELECT nama_lengkap FROM data_pelajar WHERE id_pelajar=d.pelajar_id) as santri");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.active');
        $this->db->join("data_donatur_prog d", 'd.donatur_id = a.id_donatur');
        $this->db->where("a.hapus", 0);
        return $this->db->get("data_donatur a");
    }

    function GetAllDataDonaturByCab($id)
    {
        $this->db->select("a.*,b.nama_cabang,c.set_active,d.cara_donasi,(SELECT infaq FROM master_infaq_donatur WHERE id_nominal= d.infaq_id) as donasi,(SELECT nama_lengkap FROM data_pelajar WHERE id_pelajar=d.pelajar_id) as santri");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.active');
        $this->db->join("data_donatur_prog d", 'd.donatur_id = a.id_donatur');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.cabang_id", $id);
        return $this->db->get("data_donatur a");
    }
    function GetAllDataDonaturByID($id)
    {
        $this->db->select("a.*,b.nama_cabang,c.set_active,d.cara_donasi,(SELECT infaq FROM master_infaq_donatur WHERE id_nominal= d.infaq_id) as donasi,(SELECT nama_lengkap FROM data_pelajar WHERE id_pelajar=d.pelajar_id) as santri");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.active');
        $this->db->join("data_donatur_prog d", 'd.donatur_id = a.id_donatur');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.id_donatur", $id);
        return $this->db->get("data_donatur a");
    }

    function GetDataDonaturBy($id)
    {
        $this->db->select("a.*,b.nama_cabang,c.set_active,d.cara_donasi,d.pelajar_id,d.infaq_id,d.id_donatur_prog,b.kode_donatur,
        (SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,
        (SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,
        (SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,
        (SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan,
        (SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.kelurahan_kantor,1,4)) as kota2,
        (SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.kelurahan_kantor,1,7)) as kecamatan2,
        (SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.kelurahan_kantor) as kelurahan2,
        (SELECT infaq FROM master_infaq_donatur WHERE id_nominal= d.infaq_id) as donasi,
        (SELECT nama_lengkap FROM data_pelajar WHERE id_pelajar=d.pelajar_id) as santri");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.active');
        $this->db->join("data_donatur_prog d", 'd.donatur_id = a.id_donatur');
        $this->db->where("a.hapus", 0);
        $this->db->where("a.id_donatur", $id);
        return $this->db->get("data_donatur a");
    }

    function UpdateData($id, $data)
    {
        $this->db->set($data);
        $this->db->where('id_donatur', $id);
        if ($this->db->update("data_donatur")) {
            return true;
        } else {
            return false;
        }
    }
    function UpdateDataProg($id, $data)
    {
        $this->db->set($data);
        $this->db->where('donatur_id', $id);
        if ($this->db->update("data_donatur_prog")) {
            return true;
        } else {
            return false;
        }
    }
    function HapusData($id)
    {
        $this->db->where('id_donatur', $id);
        if ($this->db->delete("data_donatur")) {
            return true;
        } else {
            return false;
        }
    }
}

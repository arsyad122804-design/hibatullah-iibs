<?php

defined('BASEPATH') or exit('No direct script access allowed');



class M_dashboard extends CI_Model

{
    function GetUserMhsBy($id)
    {
        $this->db->select("a.*,b.photo_ as img");
        $this->db->join('mhs1_data0_persyaratan b', 'b.mhs_id = a.fid_keterangan');
        $this->db->where('a.id_user', $id);
        $this->db->where('a.fid_level', 11);
        $data = $this->db->get('aa_user a');
        return $data;
    }

    function GetUserBy($id)
    {
        $this->db->select("*");
        $this->db->where('id_user', $id);
        $data = $this->db->get('aa_user');
        return $data;
    }

    function GetDataMhsBy($id, $mhs_id)
    {
        $this->db->select('a.*,b.photo_ as img,b.jenistest,c.namasekolah,d.studi,(SELECT count(id) from mhs1_data4_ujian where mhs_id = a.mhs_id) as test');
        $this->db->join('mhs1_data0_persyaratan b', 'a.mhs_id = b.mhs_id');
        $this->db->join('mhs1_data2_sekolah c', 'a.mhs_id = c.mhs_id');
        $this->db->join('mhs1_master_studi d', 'b.studi_id = d.id');
        $this->db->join('aa_user e', 'a.mhs_id = e.fid_keterangan');
        $this->db->where('e.id_user', $id);
        $this->db->where('e.fid_keterangan', $mhs_id);
        $this->db->where('e.fid_level', 11);
        $data = $this->db->get('mhs1_data0_mahasiswa a');
        return $data;
    }

    function GetDataUsrBy($id, $usi)
    {
        $this->db->select('*');
        $this->db->join('aa_user b', 'a.id_pengajar = b.fid_keterangan');
        $this->db->where('b.id_user', $id);
        $this->db->where('b.fid_keterangan', $usi);
        $data = $this->db->get('dtr_2_pengajar a');
        return $data;
    }



    function ujianmahasiswa()
    {
        $this->db->select("a.*,b.modul, (SELECT keterangan from mhs1_data4_ujian where token = concat(a.token,a.id)) as ujian");

        $this->db->join("mhs2_master_modul_soal b", "b.id = a.modul_id");

        return $this->db->get("mhs2_master_ujian a");
    }

    function getDataSantriDonatur($id)
    {
        $QR = "SELECT * FROM data_donatur_prog  a 
        INNER JOIN data_pelajar b ON b.id_pelajar = a.pelajar_id
        WHERE a.donatur_id='$id'";
        $dataini = $this->db->query($QR)->result();
        foreach ($dataini as $r) {
            $data = [
                'id_santri' => $r->pelajar_id,
            ];
        }
        return $data;
    }



    function GetDataPelajarBy($id)
    {
        $this->db->select("a.*,b.nama_cabang,b.cabang_kode,c.*,(SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,(SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,(SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,(SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan,(SELECT infaq_bulanan FROM master_infaq_santri_bulanan where id_nominal =  a.infaq_bulanan) as bulanan,(SELECT infaq_tahunan FROM master_infaq_santri_tahunan where id_nominal =  a.infaq_tahunan) as tahunan,(SELECT nama_lengkap FROM data_karyawan where id_karyawan =  a.management) as nama_guru");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->where("a.cabang_id", $id);
        $this->db->group_by("a.id_pelajar", "DESC");
        return $this->db->get("data_pelajar a");
    }
    function GetDataPelajarAll()
    {
        $this->db->select("a.*,b.nama_cabang,b.cabang_kode,c.*,(SELECT kota FROM master_wilayah_kota where id = a.id_kota) as kota_lahir,(SELECT kota FROM master_wilayah_kota where id =  SUBSTRING(a.id_kelurahan,1,4)) as kota,(SELECT kecamatan FROM master_wilayah_kecamatan where id =  SUBSTRING(a.id_kelurahan,1,7)) as kecamatan,(SELECT kelurahan FROM master_wilayah_kelurahan where id =  a.id_kelurahan) as kelurahan,(SELECT infaq_bulanan FROM master_infaq_santri_bulanan where id_nominal =  a.infaq_bulanan) as bulanan,(SELECT infaq_tahunan FROM master_infaq_santri_tahunan where id_nominal =  a.infaq_tahunan) as tahunan,(SELECT nama_lengkap FROM data_karyawan where id_karyawan =  a.management) as nama_guru");
        $this->db->join("data_kantor_cabang b", "b.id=a.cabang_id");
        $this->db->join("sys_active c", 'c.id = a.status_pelajar');
        $this->db->group_by("a.id_pelajar", "DESC");
        return $this->db->get("data_pelajar a");
    }
}

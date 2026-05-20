<?php

defined('BASEPATH') or exit('No direct script access allowed');



class M_lembaga extends CI_Model

{

    function GetAllDataLembaga()

    {

        $this->db->select("a.*,(SELECT paket FROM master_paket_kantor where id = a.paket_id) as paket");

        $this->db->where('a.hapus', 0);

        return $this->db->get("data_kantor_cabang a");
    }

    function GetAllDataLembagaById($id)

    {

        $this->db->select("a.*,(SELECT paket FROM master_paket_kantor where id = a.paket_id) as paket");

        $this->db->where('a.hapus', 0);

        $this->db->where('a.id', $id);

        return $this->db->get("data_kantor_cabang a");
    }



    function HapusData($id)

    {

        $this->db->where('id', $id);

        if ($this->db->update("data_kantor_cabang", ['hapus' => 1])) {

            return true;
        } else {

            return false;
        }
    }

    function DeleteAllData($id)
    {
        $this->db->delete("data_absensi_karyawan", ['cabang_id' => $id]);
        $this->db->delete("data_pelajar", ['cabang_id' => $id]);
        $this->db->delete("data_reg_donatur", ['cabang_id' => $id]);
        $this->db->delete("data_reg_kelompok", ['cabang_id' => $id]);
        $this->db->delete("data_silabus1", ['cabang_id' => $id]);
        $this->db->delete("data_silabus2", ['cabang_id' => $id]);
        $this->db->delete("master_infaq_donatur", ['cabang_id' => $id]);
        $this->db->delete("master_infaq_santri_bulanan", ['cabang_id' => $id]);
        $this->db->delete("master_infaq_santri_tahunan", ['cabang_id' => $id]);
        $this->db->delete("master_infaq_tahun", ['cabang_id' => $id]);
        $this->db->delete("master_juz", ['cabang_id' => $id]);
        $this->db->delete("master_kbm_hari_belajar", ['id_cabang' => $id]);
        $this->db->delete("master_kbm_langkah_belajar", ['cabang_id' => $id]);
        $this->db->delete("master_periodik_akademik", ['cabang_id' => $id]);
        $this->db->delete("master_ruangan", ['cabang_id' => $id]);
        $this->db->delete("sys_user", ['fid_cabang' => $id]);

        $QR1 = "DELETE a,b FROM data_karyawan a 
        LEFT JOIN data_karyawan_kompetensi b ON b.karyawan_id = a.id_karyawan WHERE a.cabang_id = '$id'";
        $this->db->query($QR1);

        $QR2 = "DELETE a,b FROM data_kbm_belajar1 a
        LEFT JOIN data_kbm_belajar1_detail b ON b.kbm_belajar_id = a.id_kbm_belajar WHERE a.cabang_id = '$id'";
        $this->db->query($QR2);
        $QR21 = "DELETE a,b FROM data_kbm_belajar2 a
        LEFT JOIN data_kbm_belajar2_detail b ON b.kbm_belajar_id = a.id_kbm_belajar WHERE a.cabang_id = '$id'";
        $this->db->query($QR21);

        $QR3 = "DELETE a,b,c FROM data_kelas a
        LEFT JOIN data_kelas_detail b ON b.kelas_id = a.id_kelas
        LEFT JOIN data_ujian_kelas c ON b.kelas_id = a.id_kelas
        WHERE a.cabang_id = '$id'";
        $this->db->query($QR3);

        $QR4 = "DELETE a,b FROM data_registrasi a
        LEFT JOIN data_reg_pembayaran b ON b.order_id = a.order_id WHERE a.cabang_id = '$id'";
        $this->db->query($QR4);

        $QR5 = "DELETE a,b FROM data_ujian1 a
        LEFT JOIN data_ujian1_detail b ON b.ujian_id = a.id_ujian WHERE a.cabang_id = '$id'";
        $this->db->query($QR5);

        $QR6 = "DELETE a,b FROM data_ujian2 a
        LEFT JOIN data_ujian2_detail b ON b.ujian_id = a.id_ujian WHERE a.cabang_id = '$id'";
        $this->db->query($QR6);
        $QR7 = "DELETE a,b FROM master_periode_pertemuan1 a
        LEFT JOIN master_periode_dtl_pertemuan1 b ON b.pertemuan_id = a.id_pertemuan WHERE a.cabang_id = '$id'";
        $this->db->query($QR7);
    }
}

<?php

function activity_log($tipe, $aksi, $kelas, $tm, $ta, $data_jsn, $cb)
{
    $CI = &get_instance();
    $param['nama_user'] = $CI->session->userdata('nmuser');
    $param['kelas'] = $kelas;
    $param['tm'] = $tm;
    $param['tipe'] = $tipe; //asset, asesoris, komponen, inventori
    $param['aksi'] = $aksi; //membuat, menambah, menghapus, mengubah,
    $param['data'] = $data_jsn; //data_json
    $param['cabang_id'] = $cb; //cabang
    $param['periode'] = $ta; //cabang

    //load model log
    $CI->load->model('m_log_kbm_zyadah');

    //save to database
    $CI->m_log_kbm_zyadah->save_log($param);
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Pendaftar_valid extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'secure', 'encryption']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
        $this->lang->load('auth');
        $this->load->model(['m_periodik', 'm_lembaga', 'pmb/m_pendaftar_valid', 'm_mail']);
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function get_data($cb_set = null, $pr_set = null)
    {
        $data = [];
        if ($cb_set != null) {
            if ($cb_set != 'null') {
                $data = $this->m_pendaftar_valid->get_dataPendaftarByCabang($cb_set)->result();
                if ($pr_set != null) {
                    if ($pr_set != 'null') {
                        $data = $this->m_pendaftar_valid->get_dataPendaftarByCBPeriode($cb_set, $pr_set)->result();
                    }
                }
            } else {
                if ($pr_set != null) {
                    if ($pr_set != 'null') {
                        $data = $this->m_pendaftar_valid->get_dataPendaftarByPeriode($pr_set)->result();
                    }
                }
            }
        }
        $no = 1;
        $res_data = [];
        foreach ($data as $row) {
            $jnk = "-";

            // $chek = '<iput type="checkbox" class="form-chekcbox " disabled/>';
            $b1 = "active";
            $b2 = "notActive";
            $b3 = "notActive";
            // if ($row->status_pelajar < 5) {
            $chek = '<input type="checkbox" class="form-chekcbox san_check " name="id_pelajar[]" value="' . $row->id_pelajar . '">';
            // }
            if ($row->jns_kelamin == 1) {
                $jnk = "L";
            } elseif ($row->jns_kelamin == 2) {
                $jnk = "P";
            }
            if ($row->status_pelajar >= 5) {
                $b1 = "notActive";
                $b2 = "active";
                $b3 = "notActive";
            } else if ($row->status_pelajar == 4) {
                $b1 = "notActive";
                $b2 = "notActive";
                $b3 = "active";
            }
            if ($this->session->userdata("idlevel") <= 2) {
                $BTN_A = '  <a href="' . base_url('pmb/getdata_valid/') . $this->secure->encrypt_url($row->nomor_registrasi) . '"  class="badge badge-sm rounded-circle badge-success" title="List Data"><i class="dw dw-file"></i></a>
                
                ';
            } else {
                $BTN_A = '<span  class="badge badge-sm rounded-circle btn-secondary "><i class="dw dw-file"></i></span>';
            }
            $BTNS = '<div class="input-group mb-1">
            <div id="radioBtn" class="btn-group">
                <a class="btn btn-info radioBtnChk btn-sm ' . $b1 . '" data-idset="' . $row->id_pelajar . '" data-toggle="DTST_' . $row->id_pelajar . '" data-title="3">Pending</a>
                <a class="btn btn-primary radioBtnChk  btn-sm ' . $b2 . '" data-idset="' . $row->id_pelajar . '" data-toggle="DTST_' . $row->id_pelajar . '" data-title="5">Lulus</a>
                <a class="btn btn-danger radioBtnChk btn-sm ' . $b3 . '" data-idset="' . $row->id_pelajar . '" data-toggle="DTST_' . $row->id_pelajar . '" data-title="4">Tidak</a>
            </div>
        </div>';
            if ($row->status_pelajar == 6) {
                $BTNS = "<span class='badge badge-info'>$row->status</span>";
                $chek = '';
            }
            $res_data[] = [
                $chek,
                $row->nama_cabang,
                '<div>' . $row->nama_lengkap . '</div><div class="badge badge-primary">' . $row->nomor_registrasi . '</div>',
                $jnk,
                $row->tahun_akademik,
                $row->phone,
                $row->email,
                $BTNS,
                $BTN_A,
                $row->status_pelajar
            ];
        }
        echo json_encode(['data' => $res_data], true);
    }
    function get_data_migrasi($cb_set = null, $pr_set = null)
    {
        $data = [];
        if ($cb_set != null) {
            if ($cb_set != 'null') {
                if ($pr_set != null) {
                    if ($pr_set != 'null') {
                        $data = $this->m_pendaftar_valid->get_dataPendaftarByCbMigrasi($cb_set, $pr_set)->result();
                    }
                }
            }
        }
        $no = 1;
        $res_data = [];

        $dataset = '
        <div class="table-responsive">
        <table id="TableMigrasi" class=" table-lg  order-column w-100">
                            <thead style=" border:solid 1px">
                                <tr style="border: solid 1px;text-align:center;">
                                    <th style="min-width:40px;text-align:center;vertical-align:middle;padding:5px;font-size: 12pt; z-index: 100;border: solid 1px;width:10px">
                                        <input type="checkbox" id="CheckAll"/>&nbsp;All
                                    </th>
                                    <th style="border: solid 1px;font-size:12pt">Data Peserta</th>
                                </tr>
                            </thead>
                            <tbody>';
        foreach ($data as $row) {
            $jnk = "-";
            if ($row->jns_kelamin == 1) {
                $jnk = "Laki-Laki";
            } elseif ($row->jns_kelamin == 2) {
                $jnk = "Perempuan";
            }

            $dataset .= '<tr style="border: solid 1px"> 
            <td style="border: solid 1px;text-align:center"><input type="checkbox" name="noregs[]" class="check-item" value="' . $row->id_pelajar . '"></td>
            <td style="border: solid 1px; padding: 2px 10px">
            <table class="tbl-sm border-0 w-100">
            <tr class="border-0" ><td style="width:60px;font-size:11pt;line-height:11pt;"">Nama</td><td style="width:10px;font-size:11pt;line-height:11pt;">:</td><td style="font-size:11pt;line-height:11pt;">' . $row->nama_lengkap . '</td></tr>
            <tr class="border-0"><td style="line-height:11pt;font-size:11pt">No.Reg</td><td style="line-height:11pt;font-size:11pt">:</td><td style="line-height:11pt;font-size:11pt">' . $row->nomor_registrasi . '</td></tr>
            <tr class="border-0"><td style="line-height:11pt;font-size:11pt">Gender</td><td style="line-height:11pt;font-size:11pt">:</td><td style="line-height:11pt;font-size:11pt">' . $jnk . '</td></tr>
            <tr class="border-0"><td style="line-height:11pt;font-size:11pt">Periode</td><td style="line-height:11pt;font-size:11pt">:</td><td style="line-height:11pt;font-size:11pt">' . $row->tahun_akademik . '</td></tr>
            <tr class="border-0"><td style="line-height:11pt;font-size:11pt">Status</td><td style="line-height:11pt;font-size:11pt">:</td><td style="line-height:11pt;font-size:11pt">' . $row->status . '</td></tr>
            </table>
           </td>
            </tr>';
        }

        $dataset .= '</tbody>
        </table>
        <button type="button" class="btn btn-sm btn-primary" onclick="checkAll()">Check All</button>
        <button type="button" class="btn btn-sm btn-danger" onclick="uncheckAll()">Uncheck All</button>
        </div>';
        echo json_encode(['data' => $dataset, 'token' => $this->secure->encrypt_url(json_encode($data))], true);
    }
    // <div>' . $row->nama_lengkap . '</div><div class="badge badge-primary">' .
    // $row->nomor_registrasi . '</div></td>
    // <td style="border: solid 1px">' . $jnk . '</td>
    // <td style="border: solid 1px">' . $row->tahun_akademik . '</td>
    // <td style="border: solid 1px">' . $row->status . '
    function get_data_periode()
    {
        $id = $this->input->post("id");
        $checking = $this->db->get_where("master_pmb_tahun_akademik", ['tahun_akademik' => $id]);
        $data = 0;
        $info = "";
        if ($checking->num_rows() > 0) {
            $data = 1;
            $info = [
                'icon' => 'fa-frown-o',
                'title' => 'Opssss!',
                'description' => 'Tahun  Angkatan <b> ' . $id . '</b> Sudah Ada',
                'color' => '#e80000',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        }

        echo $this->output_json(['result' => $data, 'event' => $info]);
    }
    function get_data_by()
    {
        $id = $this->secure->decrypt_url($this->input->post("id"));
        $data = $this->db->get_where("master_pmb_tahun_akademik", ['id_tahun' => $id])->row_object();
        echo $this->output_json($data);
    }
    function get_data_by_id()
    {
        $cabang = $this->session->userdata("fid_cabang");
        if ($cabang > 0) {
            $Getdata = $this->m_lembaga->GetAllDataLembagaById($cabang);
            $tahunan = $this->db->get_where("master_infaq_santri_tahunan", ['cabang_id' => $cabang])->result();
            $bulanan = $this->db->get_where("master_infaq_santri_bulanan", ['cabang_id' => $cabang])->result();
        } else {
            $Getdata = $this->m_lembaga->GetAllDataLembaga();
            $tahunan = $this->db->get("master_infaq_santri_tahunan")->result();
            $bulanan = $this->db->get("master_infaq_santri_bulanan")->result();
        }
        if ($Getdata->num_rows() > 0) {
            $data = $Getdata->result();
        }
        $id = $this->input->post("id");
        $kota = $this->db->get("master_wilayah_kota")->result();
        $kecamatan = $this->db->get("master_wilayah_kecamatan")->result();
        $kelurahan = $this->db->get("master_wilayah_kelurahan")->result();
        $asatid = $this->db->get("data_karyawan")->result();
        $pelajar = $this->m_pendaftar_valid->GetDataPelajarById($id)->row_object();
        $token = $this->secure->encrypt_url($pelajar->nomor_registrasi);
        echo json_encode(['dt1' => $pelajar,  'dt2' => $data, 'kota' => $kota, 'kec' => $kecamatan, 'kel' => $kelurahan, 'bulanan' => $bulanan, 'tahunan' => $tahunan, 'guru' => $asatid, 'token' => $token], true);
    }
    function get_data_reg()
    {
        $id = $this->input->post('id');
        $data = $this->db->query("SELECT * FROM `master_pmb_reg` WHERE `id_red`='$id' ")->row_object();

        $jenis = "-";
        if ($data->jns == 1) {
            $jenis = "FORMULIR PENDAFTARAN ";
        } elseif ($data->jns == 2) {
            $jenis = "REGISTRASI ULANG";
        }
        $dataset = '<table class="tbl tbl-sm table-bordered" style="width:100%; padding:10px">
        <thead style="padding:10px">
            <th style="text-align: left;font-weight:500; font-size:12pt;padding: 5px 10px ">Pembayaran</th>
            <th style="text-align:right;font-weight:500; font-size:12pt;padding: 5px 10px ">Nominal</th>
        </thead>
        <tr>
            <td style="text-align: left; font-size:12pt;;font-weight:700;padding: 5px 10px">' . $jenis . '</td>
            <td style="text-align:right; font-size:14pt; font-weight:800;padding: 5px 10px">
                Rp. ' . number_format($data->nominal) . '</td>
        </tr>
    </table>';
        echo $this->output_json(['dt' => $data, 'data' => $dataset]);
    }


    function migrasidata()
    {
        $param = $this->input->post("token");
        $noregs = $this->input->post("noregs");
        $Cabang_id = $this->input->post("Cabang_id");
        $Periode_id = $this->input->post("Periode_id");
        $data_row = 0;
        $set_data = [];
        $dt_udate = [];
        if (empty($noregs)) {
            $info = [
                'icon' => 'warning',
                'title' => 'Oooopss!',
                'description' => 'Anda belum ada santri yang dipilih',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        } else {

            $data_row = $this->m_pendaftar_valid->get_dataPendaftarByCbMigrasiBy($Cabang_id, $Periode_id, $noregs)->result();
            // $data = $this->secure->decrypt_url($param);
            // $data_row = json_decode($data);
            $sort = [0];
            $emailset = [];
            $dataMessage = [];
            foreach ($data_row as $dr) {
                $set_data[] = [
                    "cabang_id" => $dr->cabang_id,
                    "nik_santri" => $dr->nik_santri,
                    "nis" => $dr->nis,
                    "nama_lengkap" => $dr->nama_lengkap,
                    "nama_panggilan" => $dr->nama_panggilan,
                    "id_kota" => $dr->id_kota,
                    "tgl_lahir" => $dr->tgl_lahir,
                    "jns_kelamin" => $dr->jns_kelamin,
                    "anak_ke" => $dr->anak_ke,
                    "dari" => $dr->dari,
                    "st_anak" => $dr->st_anak,
                    "alamat" => $dr->alamat,
                    "id_kelurahan" => $dr->id_kelurahan,
                    "nama_sekolah" => $dr->nama_sekolah,
                    "alamat_sekolah" => $dr->alamat_sekolah,
                    "kelas" => $dr->kelas,
                    "hafal" => $dr->hafal,
                    "lancar" => $dr->lancar,
                    "baca" => $dr->baca,
                    "nama_ayah" => $dr->nama_ayah,
                    "nama_ibu" => $dr->nama_ibu,
                    "nomor_hp_ayah" => $dr->nomor_hp_ayah,
                    "nomor_hp_ibu" => $dr->nomor_hp_ibu,
                    "pekerjaan_ayah" => $dr->pekerjaan_ayah,
                    "pekerjaan_ibu" => $dr->pekerjaan_ibu,
                    "pendidikan_ayah" => $dr->pendidikan_ayah,
                    "pendidikan_ibu" => $dr->pendidikan_ibu,
                    "nik_ayah" => $dr->nik_ayah,
                    "nik_ibu" => $dr->nik_ibu,
                    "tempat_lahir_ayah" => $dr->tempat_lahir_ayah,
                    "tempat_lahir_ibu" => $dr->tempat_lahir_ibu,
                    "penghasilan_ayah" => $dr->penghasilan_ayah,
                    "penghasilan_ibu" => $dr->penghasilan_ibu,
                    "tgl_lahir_ayah" => $dr->tgl_lahir_ayah,
                    "tgl_lahir_ibu" => $dr->tgl_lahir_ibu,
                    "infaq_tahunan" => $dr->infaq_tahunan,
                    "infaq_bulanan" => $dr->infaq_bulanan,
                    "hari_belajar" => $dr->hari_belajar,
                    "waktu_belajar" => $dr->waktu_belajar,
                    "wali_peserta" => $dr->wali_peserta,
                    "management" => $dr->management,
                    "tgl_pendaftaran" => $dr->tgl_pendaftaran,
                    "kontak_wali" => $dr->kontak_wali,
                    "tempat_lahir_wali" => $dr->tempat_lahir_wali,
                    "tgl_lahir_wali" => $dr->tgl_lahir_wali,
                    "penghasilan_wali" => $dr->penghasilan_wali,
                    "pendidikan_wali" => $dr->pendidikan_wali,
                    "pekerjaan_wali" => $dr->pekerjaan_wali,
                    "nik_wali" => $dr->nik_wali,
                    "gambar" => $dr->gambar,
                    "status_pelajar" => 1,
                    "jalur_daftar" => 1,
                    "beasiswa" => "",
                    "reg_kelompok_id" => $dr->reg_kelompok_id,
                    "nomor_registrasi" => $dr->nomor_registrasi,
                    "date_create" => $dr->date_create,
                    "date_update" => $dr->date_update,
                    "hapus" => 0,
                    "usr_create" => 1,
                    "usr_update" => 1,
                    "last_action" => $dr->last_action,
                ];

                $nohp = (strpos($dr->phone, '62') === 0) ? $dr->phone : (strpos($dr->phone, '0') === 0 ? '62' . ltrim($dr->phone, '0') : '62' . $dr->phone);
                $dataMessage[] = [
                    'number' => $nohp,
                    'message' => "*INFO PPDB AL-AZHAR AS-SYARIF*\n\nAssalamu'alaikum Ayah/Bunda, ananda *$dr->nama_lengkap* telah diterima menjadi santri Al-Azhar As-Syarif. Kami ucapkan selamat bergabung di keluarga besar kami.\n\nSilahkan logout dari SIAKAD, kemudian login ulang, untuk mendapatkan tampilan menu-menu akademik kami. Terimakasih.\n\n---------------------------\n*#PPDB AL-AZHAR AS-SYARIF*",
                ];
                $emailset[] = $dr->email;
                $dt_udate[] = [
                    'id_pelajar' => $dr->id_pelajar,
                    'status_pelajar' => 6,
                ];
                $sort[] = $dr->nomor_registrasi;
            }
            $migrate = $this->db->insert_batch("data_pelajar", $set_data);
            if ($migrate) {
                $update = $this->db->update_batch("master_pmb_register_pelajar", $dt_udate, 'id_pelajar');
                if ($update) {
                    $this->UpdateUser($sort);
                }

                $this->send_MailNotif($emailset);
                $info = [
                    'icon' => 'thumbs-up',
                    'title' => 'Update Data Success!',
                    'description' => 'Data Peserta Berhasil di Pindahkan',
                    'color' => '#a4cc00',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
            } else {
                $info = [
                    'icon' => 'thumbs-up',
                    'title' => 'Oooopss!',
                    'description' => 'Data Peserta Gagal di Pindahkan',
                    'color' => '#a4cc00',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
            }
        }

        echo $this->output_json(['result' => true, 'data' => $data_row, 'event' => $info, "notifwa" => $dataMessage]);
    }


    function UpdateUser($sort)
    {
        $this->db->where_in("nomor_registrasi", $sort);
        $gdpset = $this->db->get("data_pelajar")->result();
        $ups_set = [];
        foreach ($gdpset as $r) {
            $ups_set[] = [
                'username' => $r->nomor_registrasi,
                'fid_keterangan' => $r->id_pelajar,
                'id_level' => 30
            ];
        }
        $this->db->update_batch("sys_user", $ups_set, 'username');
    }

    function send_MailNotif($email)
    {
        $sendatamail = '
    	<div style="max-width:620px; margin:auto">
    		<div style="margin-left: auto;margin-right:auto">
    			<div style="padding: 20px 10px 0 10px;background-color: #fff;border-bottom: #027530 double 8px;">
    				<table style=" width: 100%;">
    					<tr>
    						<td style="width: 100px;">
    							<img src="' . base_url("assets/images/pavicon.png") . '" style="width:80px" alt="">
    						</td>
    						<td style="text-align: right;">
    							<div>
    								<div><span style="font-size: 12pt; font-weight:700">HIBATULLAH IIBS</span></div>
    							</div> 
    						</td>
    					</tr>
    				</table>
    			</div>
    			<div style="background-color: #fff; border-bottom: #027530 double 2px; padding:10px 0">
    				<div class="col">
    					<div style="margin-top:1%">
    						<div style="padding:4px 10px">
    							<div style="font-weight:500; font-size:12pt;line-height:14pt; margin-bottom:6px; text-align:left">Assalamu' . "'" . 'alaikum Ayah/Bunda 
                               <div>Alhamdulillah ananda telah diterima menjadi Santri Hibatullah IIBS. </div>
                               <div>Kami ucapkan selamat bergabung di keluarga besar kami.</div>  
    							</div>
    						
    					</div>
    				</div>
    			</div>
    			<br>
                #PPDB HIBATULLAH IIBS
    		</div>

    	</div>
    	</div>
    	';
        // return $sendatamail;
        return $this->m_mail->SendMail($email, 'PPDB HIBATULLAH IIBS', $sendatamail);
    }

    function set_status($id, $status)
    {
        $return = 500;
        try {
            $update = $this->db->where('id_pelajar', $id)->update("master_pmb_register_pelajar", ['status_pelajar' => $status]);
            if ($update) {
                $return = 500;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        echo json_encode($return);
    }
    function set_all_status()
    {
        $id = $this->input->post("ids");
        $st = $this->input->post("st");
        $pros = $this->input->post("pros");
        $data = [];
        for ($i = 0; $i < count($id); $i++) {
            $data[] = [
                'id_pelajar' => $id[$i],
                'status_pelajar' => $st
            ];
        }
        $result = 500;
        try {
            $this->db->update_batch("master_pmb_register_pelajar", $data, 'id_pelajar');
            $info = [
                'icon' => 'thumbs-up',
                'title' => 'Update Data Success!',
                'description' => $pros . ' data berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
            $result = 200;
        } catch (\Throwable $th) {
            $info = [
                'icon' => 'frown-o',
                'title' => 'Ooppss!',
                'description' => $pros . ' data gagal',
                'color' => '#df0000',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        }
        echo $this->output_json(['result' => $result, 'event' => $info]);
    }
}

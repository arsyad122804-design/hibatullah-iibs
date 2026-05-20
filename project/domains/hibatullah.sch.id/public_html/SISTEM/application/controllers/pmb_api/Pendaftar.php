<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Pendaftar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'secure', 'encryption', 'upload']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
        $this->lang->load('auth');
        $this->load->model(['m_periodik', 'm_lembaga', 'pmb/m_pendaftar', 'm_mail']);
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function get_data($cb_set = null, $pr_set = null)
    {
        $data = [];
        $periodesctiv = $this->db->query("SELECT * FROM master_pmb_tahun_akademik where active=1 ORDER BY tahun_akademik ASC")->row_object();
        $ta = $periodesctiv->id_tahun;
        if ($pr_set != null) {
            if ($pr_set != 'null') {
                if ($pr_set != 'undefined') {
                    $ta = $pr_set;
                }
            }
        }
        if ($cb_set != null) {
            if ($cb_set != 'null') {
                $data = $this->m_pendaftar->get_dataPendaftarByCabang($cb_set)->result();
                if ($pr_set != null) {
                    if ($pr_set != 'null') {
                        if ($pr_set != 'undefined') {
                            $data = $this->m_pendaftar->get_dataPendaftarByCBPeriode($cb_set, $ta)->result();
                        }
                    }
                }
            } else {
                $data = $this->m_pendaftar->get_dataPendaftarByPeriode($ta)->result();
            }
        }
        $no = 1;
        $res_data = [];
        foreach ($data as $row) {
            $jnk = "-";
            if ($row->jns_kelamin == 1) {
                $jnk = "L";
            } elseif ($row->jns_kelamin == 2) {
                $jnk = "P";
            }
            if ($this->session->userdata("idlevel") <= 2) {
                $BTN_A = '  <a href="' . base_url('pmb/getdata/') . $this->secure->encrypt_url($row->nomor_registrasi) . '"  class="badge badge-sm rounded-circle badge-success" title="List Data"><i class="dw dw-file"></i></a>';
            } else {
                $BTN_A = '<span  class="badge badge-sm rounded-circle btn-secondary "><i class="dw dw-file"></i></span>';
            }
            if ($row->status_pelajar == 3) {
                $status = '<div class="badge badge-info">' . $row->status . '</div>';
            } elseif ($row->status_pelajar == 5) {
                $status = '<div class="badge badge-success">' . $row->status . '</div>';
            } else {
                $status = $row->status;
            }
            $res_data[] = [
                $row->nama_cabang,
                $no++,
                '<div>' . $row->nama_lengkap . '</div><div class="badge badge-primary">' . $row->nomor_registrasi . '</div>',
                $status,
                $row->tahun_akademik,
                $jnk,
                $row->phone,
                $row->email,
                $BTN_A,
                $row->status_pelajar
            ];
        }
        echo json_encode(['data' => $res_data], true);
    }

    function get_periode($id)
    {
        $y1 = date("Y");
        $y2 = date("Y") + 1;
        $yn = $y1 . "-" . $y2;
        $aktif = $this->db->get_where("master_pmb_tahun_akademik", ['tahun_akademik' => $yn, 'cabang_id' => $id])->row_object();
        $data = $this->db->get_where("master_pmb_tahun_akademik", ['cabang_id' => $id])->result();
        echo $this->output_json(['ta' => $data, 'now' => $aktif]);
    }

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
        } else {
            $Getdata = $this->m_lembaga->GetAllDataLembaga();
        }
        if ($Getdata->num_rows() > 0) {
            $data = $Getdata->result();
        }
        $id = $this->input->post("id");
        $kota = $this->db->get("master_wilayah_kota")->result();
        $kecamatan = $this->db->get("master_wilayah_kecamatan")->result();
        $kelurahan = $this->db->get("master_wilayah_kelurahan")->result();
        $asatid = $this->db->get("data_karyawan")->result();
        $pelajar = $this->m_pendaftar->GetDataPelajarById($id)->row_object();
        $token = $this->secure->encrypt_url($pelajar->nomor_registrasi);
        echo json_encode(['dt1' => $pelajar,  'dt2' => $data, 'kota' => $kota, 'kec' => $kecamatan, 'kel' => $kelurahan, 'guru' => $asatid, 'token' => $token], true);
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
    function get_data_reg2()
    {
        $id = $this->input->post('id');
        $data = $this->db->query("SELECT * FROM `master_pmb_reg` WHERE `id_red`='$id' ")->row_object();
        $jenis = "-";
        if ($data->jns == 1) {
            $jenis = "FORMULIR PENDAFTARAN";
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
            <td style="text-align:right; font-size:16pt; font-weight:800;padding: 5px 10px">
                Rp. ' . number_format($data->nominal) . '</td>
        </tr>
    </table>';
        echo $this->output_json(['dt' => $data, 'data' => $dataset]);
    }
    function newdata()
    {
        $id = $this->input->post("idAkademik");
        $angkatan = $this->input->post("Angkatan");
        $periode = $this->input->post("Periode");
        $Nominal = $this->input->post("Nominal");
        $Aktif = $this->input->post("Aktif");
        if ($id == 'new') {
            $data = [
                'nominal' => $Nominal,
                'tahun_akademik' => $periode,
                'active' => $Aktif,
                'hapus' => '0',
            ];
            $this->db->insert("master_pmb_tahun_akademik", $data);
            $info = [
                'icon' => 'thumbs-up',
                'title' => 'New Data Success!',
                'description' => 'Simpan Tahun PMB <b> ' . $periode . '</b> Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
            echo $this->output_json(['result' => true, 'data' => $data, 'event' => $info]);
        } else {
            $data = [
                'nominal' => $Nominal,
                'tahun_akademik' => $periode,
                'active' => $Aktif,
                'hapus' => '0',
            ];
            $this->db->where("id_tahun", $this->secure->decrypt_url($id));
            $this->db->update("master_pmb_tahun_akademik", $data);
            $info = [
                'icon' => 'thumbs-up',
                'title' => 'Update Success!',
                'description' => 'Update Data Tahun PMB <b> ' . $periode . '</b> Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
            echo $this->output_json(['result' => true, 'data' => $data, 'event' => $info]);
        }
    }
    function rekonfirmasi()
    {
        $idr             = $this->input->post("idred");
        $jns             = $this->input->post("jns");
        $email             = $this->input->post("email");
        $noregister     = $this->input->post("noregister");
        $rekpengirim     = $this->input->post("rekpengirim");
        $atasnama         = $this->input->post("atasnama");
        $nota             = $this->input->post("nota");
        // Define the message body
        $data = [
            'norek'          => $rekpengirim,
            'atasnama'      => $atasnama,
            'nota'          => base_url('databerkas/') . $nota,
            'status'          => 1,
        ];
        $proses =  $this->db->where('id_red', $idr)->update("master_pmb_reg", $data);
        if ($proses) {
            $this->db->where("nomor_registrasi", $noregister)->update("master_pmb_register_pelajar", ['status_pelajar' => 4]);
            $info = [
                'icon' => 'thumbs-up',
                'title' => 'Success!',
                'description' => 'Upload Data Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
            $dtp = $this->db->query("SELECT * FROM master_pmb_register_pelajar a 
            INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode
            INNER JOIN data_kantor_cabang c ON c.id = a.cabang_id
            WHERE a.nomor_registrasi='$noregister'")->row_object();
            $this->send_MailNotif_Aamin($dtp, $data);
        } else {
            $info = [
                'icon' => 'frown-o',
                'title' => 'Ooppss!',
                'description' => 'Update Data  Gagal!',
                'color' => '#df0000',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        }
        echo $this->output_json(['result' => true, 'data' => $data, 'event' => $info]);
    }
    function hapusdata()
    {
        $id = $this->input->post("id");
        $nm = $this->input->post("nm");
        $this->db->where("id_akademik", $this->secure->decrypt_url($id));
        $this->db->delete("master_periodik_akademik");
        $info = [
            'icon' => 'thumbs-up',
            'title' => 'Delete Success!',
            'description' => 'Hapus  <b> ' . $nm . '</b> Berhasil..',
            'color' => '#a4cc00',
            'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
        ];
        echo $this->output_json(['result' => true, 'event' => $info]);
    }
    function validasi_data()
    {
        $id = $this->input->post("id");
        $idr = $this->input->post("idr");
        $val = $this->input->post("val");
        $jns = $this->input->post("jns");
        // echo json_encode($idr);
        $update = $this->db->where("id_red", $id)->update("master_pmb_reg", ["status" => $val]);
        if ($update) {
            $get_data = $this->db->query("SELECT * FROM master_pmb_register_pelajar a 
            INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode
            WHERE a.nomor_registrasi='$idr'");
            if ($val == 2) {
                if ($jns == 1) {
                    if ($get_data->num_rows() > 0) {
                        $dtp = $get_data->row_object();
                        $idu = $this->db->query("SELECT IFNULL(MAX(id_user),0)+1 as id FROM `sys_user`")->row_object();
                        $checking = $this->db->get_where("sys_user", ['username' => $idr, 'fid_keterangan' => $dtp->id_pelajar]);
                        $this->db->where('nomor_registrasi', $idr)->where('id_pelajar', $dtp->id_pelajar)->update("master_pmb_register_pelajar", ['status_pelajar' => 3]);
                        if ($checking->num_rows() > 0) {
                            $this->db->where('username', $idr)->where('fid_keterangan', $dtp->id_pelajar)->update("sys_user", ['konfirm' => "Y", 'aktif' => 'Y']);
                        } else {
                            $SetPass = md5(123456 . "!@#$%^&*()_+ >> b(^_^)v");
                            $result = [
                                'id_user' => $idu->id,
                                'username' => $idr,
                                'password' => $SetPass,
                                'id_level' => 32,
                                'sess_id' => $this->encryption->encrypt(date("dmy") . '-' . $this->session->userdata("id_user")),
                                'last_login' => '',
                                'last_logout' => '',
                                'fid_keterangan' => $dtp->id_pelajar,
                                'nama_asli' => $dtp->nama_lengkap,
                                'email' => $dtp->email,
                                'block_count' => 0,
                                'block_exp' => '',
                                'reset_token' => '',
                                'reset_exp' => '',
                                'konfirm' => 'Y',
                                'aktif' => 'Y',
                                'icon' => 'pavicon.png',
                                'fid_cabang' => $dtp->cabang_id,
                                'created_by' => $this->session->userdata("id_user"),
                            ];
                            $this->db->insert("sys_user", $result);
                        }
                        $checking2 = $this->db->get_where("master_pmb_reg", ['nomor_reg' => $idr, 'jns' => 2]);
                        if ($checking2->num_rows() > 0) {
                        } else {
                            $nominal2 =  $dtp->registrasi + substr($idr, 6);
                            $data2 = [
                                'jns'  => 2,
                                'nomor_reg'  => $idr,
                                'nominal'  => $nominal2,
                                'status'  => 0,
                            ];
                            $this->db->insert("master_pmb_reg", $data2);
                            $this->send_MailNotif($dtp, null);
                        }
                    }
                } elseif ($jns == 2) {
                    if ($get_data->num_rows() > 0) {
                        $dtp = $get_data->row_object();
                        $this->db->where('nomor_registrasi', $idr)->where('id_pelajar', $dtp->id_pelajar)->update("master_pmb_register_pelajar", ['status_pelajar' => 5]);
                        $this->send_MailNotif_2($dtp, null);
                    }
                }
            } else {
                if ($get_data->num_rows() > 0) {
                    $dtp = $get_data->row_object();
                    if ($jns == 1) {
                        $idu = $this->db->query("SELECT IFNULL(MAX(id_user),0)+1 as id FROM `sys_user`")->row_object();
                        $checking = $this->db->get_where("sys_user", ['username' => $idr, 'fid_keterangan' => $dtp->id_pelajar]);
                        if ($checking->num_rows() > 0) {
                            $this->db->where('username', $idr)->where('fid_keterangan', $dtp->id_pelajar)->update("sys_user", ['konfirm' => "T", 'aktif' => 0]);
                            $this->db->where('nomor_registrasi', $idr)->where('id_pelajar', $dtp->id_pelajar)->update("master_pmb_register_pelajar", ['status_pelajar' => 2]);
                        }
                    } elseif ($jns == 2) {
                        $this->db->where('nomor_registrasi', $idr)->where('id_pelajar', $dtp->id_pelajar)->update("master_pmb_register_pelajar", ['status_pelajar' => 4]);
                    }
                }
            }
            echo 200;
        } else {
            echo 500;
        }
        // 
    }
    function new_data()
    {

        $periode = $this->input->post('Periode');
        $tgllahir = $this->input->post('Tlahir');
        $nominal = $this->input->post('Nominal');
        $param = explode("-", $periode);
        $rand = rand(100, 999);
        $register =  substr($param[0], 2) . date('md') . $rand;
        $amount = $nominal;

        $data = [
            'nomor_registrasi'  => $register,
            'cabang_id'         => $this->input->post('Cabang'),
            'periode'           => $periode,
            'nama_lengkap'      => $this->input->post('Nama_lengkap'),
            'jns_kelamin'       => $this->input->post('jns_kelamin'),
            'id_kota'           => $this->input->post('KotaLahir'),
            'tgl_lahir'         => date('Y-m-d', strtotime($tgllahir)),
            'alamat'            => $this->input->post('Alamat_rumah'),
            'id_kelurahan'      => $this->input->post('KelAlamat'),
            'wali_peserta'      => $this->input->post('Nama_Wali'),
            'phone'             => $this->input->post('Telepon_Wali'),
            'email'             => $this->input->post('EmailWali'),
            'nama_sekolah'      => $this->input->post('Sekolah_asal'),
            'tgl_pendaftaran'   => $param[0] . date('-m-d H:i'),
            'status_pelajar'    => 3,
            'aff_id'            => "",
        ];

        $config['upload_path'] = './nota/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        $nota = null;
        if (!empty($_FILES['BuktiFile']['name'])) {
            if ($this->upload->do_upload('BuktiFile')) {
                $gbr = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = './nota/' . $gbr['file_name'];
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = false;
                $config['quality'] = 50;
                $config['new_image'] = './nota/' . $gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $nota = $gbr['file_name'];
            }
        }

        $data2 = [
            'jns'  => 1,
            'nomor_reg'  => $register,
            'nominal'  => $amount,
            'transaction_status' => 'settlement',
            'payment_type' => 'OffLine',
            'bank' => $nota,
            'tgl_bayar' => date("Y-m-d H:i:s"),
            'status' => 1
        ];


        $proses =  $this->db->insert("master_pmb_register_pelajar", $data);
        if ($proses) {
            $this->db->insert("master_pmb_reg", $data2);
            $this->setupakun($register);
            $info = [
                'icon' => 'thumbs-up',
                'title' => ' Success!',
                'description' => 'Update Data Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        } else {
            $info = [
                'icon' => 'frown-o',
                'title' => 'Ooppss!',
                'description' => 'Update Data Gagal!',
                'color' => '#df0000',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        }

        echo $this->output_json(['result' => false, 'data' => $data, 'data2' => $data2, 'event' => $info]);
    }


    function setupakun($id)
    {

        $get_data = $this->db->query("SELECT *,a.email as email_reg,a.alamat as alamat_set FROM master_pmb_register_pelajar a 
        INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode
        LEFT JOIN master_wilayah_kota c ON c.id = a.id_kota
        LEFT JOIN data_kantor_cabang d ON d.id = a.cabang_id
        WHERE a.nomor_registrasi='$id'");
        $dtp = $get_data->row_object();
        // $this->send_MailNotif1($dtp);
        $checking = $this->db->get_where("sys_user", ['username' => $dtp->nomor_registrasi, 'fid_keterangan' => $dtp->id_pelajar]);
        if ($checking->num_rows() > 0) {
            $this->db->where('username', $dtp->nomor_registrasi)->where('fid_keterangan', $dtp->id_pelajar)->update("sys_user", ['konfirm' => "Y", 'aktif' => 'Y']);
        } else {
            $SetPass =  md5('123456' . "!@#$%^&*()_+ >> b(^_^)v");
            $result = [
                'username' => $dtp->nomor_registrasi,
                'password' => $SetPass,
                'id_level' => 50,
                'sess_id' =>  $this->secure->encrypt_url(date("dmy") . '-' . $this->session->userdata("id_user")),
                'last_login' => '',
                'last_logout' => '',
                'fid_keterangan' => $dtp->id_pelajar,
                'nama_asli' => $dtp->nama_lengkap,
                'email' => $dtp->email_reg,
                'block_count' => 0,
                'block_exp' => '',
                'reset_token' => '',
                'reset_exp' => '',
                'konfirm' => 'Y',
                'aktif' => 'Y',
                'icon' => 'pavicon.png',
                'fid_cabang' => $dtp->cabang_id,
                'created_by' => 0
            ];
            $this->db->insert("sys_user", $result);
        }
    }


    function update_data()
    {
        $idh = $this->input->post('idPelajar');
        $lembaga = $this->input->post('Lembaga');
        $Nama_lengkap = strtoupper($this->input->post('Nama_lengkap'));
        $Nama_Panggilan = strtoupper($this->input->post('Nama_Panggilan'));
        $jns_kelamin = $this->input->post('jns_kelamin');
        $KotaLahir = $this->input->post('KotaLahir');
        $Tlahir = $this->input->post('Tlahir');
        $Anak_ke = $this->input->post('Anak_ke');
        $NIK = $this->input->post('NIK');
        $ST_ANAK = $this->input->post('ST_ANAK');
        $Dari_saudara = $this->input->post('Dari_saudara');
        $Alamat_rumah = $this->input->post('Alamat_rumah');
        $Kelurahan = $this->input->post('Kelurahan');
        $Nama_Sekolah = $this->input->post('Sekolah');
        $Alamat_Sekolah = $this->input->post('Alamat_Sekolah');
        $Kelas_Sekolah = $this->input->post('Kelas_Sekolah');
        $Hafal = $this->input->post('Hafal');
        $Lacar = $this->input->post('Lacar');
        $Jilid = $this->input->post('Jilid');
        $Nama_Ayah = strtoupper($this->input->post('Nama_Ayah'));
        $Telepon_Ayah = $this->input->post('Telepon_Ayah');
        $Pekerjaan_Ayah = $this->input->post('Pekerjaan_Ayah');
        $Pendidikan_Ayah = $this->input->post('Pendidikan_Ayah');
        $TLAyah = $this->input->post('TLAyah');
        $TlahirAyah = date("Y-m-d", strtotime($this->input->post('TlahirAyah')));
        $NIK_Ayah = $this->input->post('NIK_Ayah');
        $Penghasilan_Ayah = $this->input->post('Penghasilan_Ayah');
        $Nama_Ibu = strtoupper($this->input->post('Nama_Ibu'));
        $Telepon_Ibu = $this->input->post('Telepon_Ibu');
        $Pekerjaan_Ibu = $this->input->post('Pekerjaan_Ibu');
        $Pendidikan_Ibu = $this->input->post('Pendidikan_Ibu');
        $TLIbu = $this->input->post('TLIbu');
        $TlahirIbu = date("Y-m-d", strtotime($this->input->post('TlahirIbu')));
        $NIK_Ibu = $this->input->post('NIK_Ibu');
        $Penghasilan_Ibu = $this->input->post('Penghasilan_Ibu');
        $chekwali = strtoupper($this->input->post('chekwali'));
        if ($chekwali == "A") {
            $Nama_Wali = $Nama_Ayah;
            $Telepon_Wali = $Telepon_Ayah;
            $Pekerjaan_Wali = $Pekerjaan_Ayah;
            $Pendidikan_Wali = $Pendidikan_Ayah;
            $TLWali = $TLAyah;
            $TlahirWali = $TlahirAyah;
            $NIK_Wali = $NIK_Ayah;
            $Penghasilan_Wali = $Penghasilan_Ayah;
        } elseif ($chekwali == "I") {
            $Nama_Wali = $Nama_Ibu;
            $Telepon_Wali = $Telepon_Ibu;
            $Pekerjaan_Wali = $Pekerjaan_Ibu;
            $Pendidikan_Wali = $Pendidikan_Ibu;
            $TLWali = $TLIbu;
            $TlahirWali = $TlahirIbu;
            $NIK_Wali = $NIK_Ibu;
            $Penghasilan_Wali = $Penghasilan_Ibu;
        } else {
            $Nama_Wali = strtoupper($this->input->post('Nama_Wali'));
            $Telepon_Wali = $this->input->post('Telepon_Wali');
            $Pekerjaan_Wali = $this->input->post('Pekerjaan_Wali');
            $Pendidikan_Wali = $this->input->post('Pendidikan_Wali');
            $TLWali = $this->input->post('TLWali');
            $TlahirWali = date("Y-m-d", strtotime($this->input->post('TlahirWali')));
            $NIK_Wali = $this->input->post('NIK_Wali');
            $Penghasilan_Wali = $this->input->post('Penghasilan_Wali');
        }
        $NIS =  $this->input->post('NIS');
        $dp = $this->input->post("Image");
        if ($dp == "" || $dp == "null") {
            $photo = "default.png";
        } else {
            $photo = $dp;
        }
        $data = [
            'nama_lengkap' => $Nama_lengkap,
            'nis' => $NIS,
            'nik_santri' => $NIK,
            'nama_panggilan' => $Nama_Panggilan,
            'id_kota' => $KotaLahir,
            'tgl_lahir' => date("Y-m-d", strtotime($Tlahir)),
            'jns_kelamin' => $jns_kelamin,
            'st_anak' => $ST_ANAK,
            'anak_ke' => $Anak_ke,
            'dari' => $Dari_saudara,
            'alamat' => $Alamat_rumah,
            'id_kelurahan' => $Kelurahan,
            'nama_sekolah' => $Nama_Sekolah,
            'alamat_sekolah' => $Alamat_Sekolah,
            'kelas' => $Kelas_Sekolah,
            'hafal' => $Hafal,
            'lancar' => $Lacar,
            'baca' => $Jilid,
            'nama_ayah' => $Nama_Ayah,
            'nik_ayah' => $NIK_Ayah,
            'nomor_hp_ayah' => $Telepon_Ayah,
            'pekerjaan_ayah' => $Pekerjaan_Ayah,
            'pendidikan_ayah' => $Pendidikan_Ayah,
            'tgl_lahir_ayah' => $TlahirAyah,
            'tempat_lahir_ayah' => $TLAyah,
            'penghasilan_ayah' => $Penghasilan_Ayah,
            'nama_ibu' => $Nama_Ibu,
            'nik_ibu' => $NIK_Ibu,
            'nomor_hp_ibu' => $Telepon_Ibu,
            'pekerjaan_ibu' => $Pekerjaan_Ibu,
            'pendidikan_ibu' => $Pendidikan_Ibu,
            'tgl_lahir_ibu' => $TlahirIbu,
            'tempat_lahir_ibu' => $TLIbu,
            'penghasilan_ibu' => $Penghasilan_Ibu,
            'wali_peserta' => $Nama_Wali,
            'nik_wali' => $NIK_Wali,
            'kontak_wali' => $Telepon_Wali,
            'pekerjaan_wali' => $Pekerjaan_Wali,
            'pendidikan_wali' => $Pendidikan_Wali,
            'tgl_lahir_wali' => $TlahirWali,
            'tempat_lahir_wali' => $TLWali,
            'penghasilan_wali' => $Penghasilan_Wali,
            'gambar' => $photo,
            'hapus' => 0,
            'usr_update' => $this->session->userdata("id_user"),
            'last_action' => 1,
        ];
        $this->db->where("id_pelajar", $idh);
        $proses = $this->db->update("master_pmb_register_pelajar", $data);
        if ($proses) {
            $info = [
                'icon' => 'thumbs-up',
                'title' => ' Success!',
                'description' => 'Update Data <b> '  . $Nama_lengkap . '</b> Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        } else {
            $info = [
                'icon' => 'frown-o',
                'title' => 'Ooppss!',
                'description' => 'Update Data <b> ' . $Nama_lengkap . '</b>  Gagal!',
                'color' => '#df0000',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        }
        echo $this->output_json(['result' => false, 'data' => 0, 'event' => $info]);
    }
    function send_MailNotif($dtp, $data)
    {
        $gender = '-';
        if ($dtp->jns_kelamin == 1) {
            $gender = 'Laki-Laki';
        } elseif ($dtp->jns_kelamin == 2) {
            $gender = 'Perempuan';
        }
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
    								<a target="_blank" href="https://siakadtahfidz.com/" style="text-decoration: none; color:#027530;font-weight:900">
    									REGISTRASI PPDB
    								</a>
    								<div><span style="font-size: 12pt; font-weight:700">HIBATULLAH IIBS</span></div>
    							</div>
    							<div style="font-size: 11px;">Jl. KH. Zubair No. 54 Kota Gresik</div>
    							<div style="font-size: 11px;">Telepon: (031) 3990158</div>
    						</td>
    					</tr>
    				</table>
    			</div>
    			<div style="background-color: #fff; border-bottom: #027530 double 2px; padding:10px 0">
    				<div class="col">
    					<div style="margin-top:1%">
    						<div style="padding:4px 10px">
    							<div style="font-weight:500; font-size:14pt; margin-bottom:6px">
                                Assalamuaiakum, Ayah/Bunda dari ' . $dtp->nama_lengkap . ', berikut adalah akun ananda untuk login ke SIAKAD kami.
                                </div>
    							<table style="width:100%;text-align:left">
    								<tr>
    									<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Username</b></td>
    									<td style="width:10px">: </td>
    									<td>' . strtoupper($dtp->nomor_registrasi) . '</td>
    								</tr>
    								<tr>
    									<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Password</b></td>
    									<td style="width:10px">: </td>
    									<td>123456</td>
    								</tr>
    								<tr>
    									<td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Link Siakad</b></td>
    									<td>: </td>
    									<td>
                                        <a  style="
                                        text-decoration: none;
                                        cursor: pointer;" target="blank_" href="' . base_url() . '">' . base_url() . '</a></td>
    								</tr>
    							</table>
    							</div>
    							<div style="margin:20px 0;text-align: center; line-height:100%;">
    								Silahkan login siakad melalui link diatas. kemudia isi lengkap Data diri Ananda.
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
        return $this->m_mail->SendMail([$dtp->email,], 'DAFTAR ULANG PPDB', $sendatamail);
    }
    function send_MailNotif_2($dtp, $data)
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
    								<a target="_blank" href="https://siakadtahfidz.com/" style="text-decoration: none; color:#027530;font-weight:900">
    									REGISTRASI PPDB
    								</a>
    								<div><span style="font-size: 12pt; font-weight:700">HIBATULLAH IIBS</span></div>
    							</div>
    							<div style="font-size: 11px;">Jl. KH. Zubair No. 54 Kota Gresik</div>
    							<div style="font-size: 11px;">Telepon: (031) 3990158</div>
    						</td>
    					</tr>
    				</table>
    			</div>
    			<div style="background-color: #fff; border-bottom: #027530 double 2px; padding:10px 0">
    				<div class="col">
    					<div style="margin-top:1%">
    						<div style="padding:4px 10px">
    							<div style="font-weight:500; font-size:12pt; margin-bottom:6px">
                                Assalamuaiakum, Ayah/Bunda dari ' . $dtp->nama_lengkap . '.
                                </div>
    							<div style="font-weight:500; font-size:20pt; margin-bottom:6px">
                                No. Register : ' . $dtp->nomor_registrasi . '
                                </div>
    							</div>
    							<div style="margin:20px 0;text-align: center; line-height:100%;font-size:12pt;line-height:12pt">
                                Terimakasih sudah melakukan daftar ulang PPDB, pembayaran anda sudah kami verifikasi.
                                
                                Kami akan memproses perubahan data untuk ananda, jika dalam kurun waktu 7x24 jam akun ananda setelah login ulang belum berubah, silahkan hubungi kami.
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
        return $this->m_mail->SendMail([$dtp->email,], 'VERIFIKASI DAFTAR ULANG PPDB', $sendatamail);
    }
    function send_MailNotif_Aamin($data, $dt)
    {
        $gender = '-';
        if ($data->jns_kelamin == 1) {
            $gender = 'Laki-Laki';
        } elseif ($data->jns_kelamin == 2) {
            $gender = 'Perempuan';
        }
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
    								<a target="_blank" href="https://siakadtahfidz.com/" style="text-decoration: none; color:#027530;font-weight:900">
    									REGISTRASI PPDB
                                        <div><span style="font-size: 12pt; font-weight:700">HIBATULLAH IIBS</span></div>
    								</a>
    							</div>
    							<div style="font-size: 11px;">Jl. KH. Zubair No. 54 Kota Gresik</div>
    							<div style="font-size: 11px;">Telepon: (031) 3990158</div>
    						</td>
    					</tr>
    				</table>
    			</div>
    					<div style="font-weight:800; font-size:12pt; margin-bottom:6px;text-align:right">
                               ' . $data->nama_cabang . '
                                </div>
    			<div style="background-color: #fff; border-bottom: #027530 double 2px; padding:10px 0">
    				<div class="col">
    					<div style="margin-top:1%">
    						<div style="padding:4px 10px">
    							<div style="font-weight:500; font-size:14pt; margin-bottom:6px">
                                Pembayaran Daftar Ulang :
                                </div>
                                <table style="width:100%;text-align:left">
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Nama Lengkap</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($data->nama_lengkap) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Panggilan</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($data->nama_panggilan) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Jenis Kelamin</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($gender) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>No. Telepon</b></td>
                                    <td>: </td>
                                    <td>' . $data->phone . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Email</b></td>
                                    <td>: </td>
                                    <td>' . $data->email . '</td>
                                </tr>
                            </table>
    							<div style="font-weight:500; font-size:14pt; margin-bottom:6px">
                                    Data Pengirim:
                                </div>
                                <table style="width:100%;text-align:left">
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Atas Nama</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($dt['atasnama']) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>No. Rekening</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . ($dt['norek']) . '</td>
                                </tr>
                            </table>
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
        // return $sendatamail;officialHIBATULLAH IIBS;kbtkhafizhquran
        return $this->m_mail->SendMail(['officialHIBATULLAH IIBS@gmail.com'], 'PEMBAYARAN DAFTAR ULANG', $sendatamail);
    }
}

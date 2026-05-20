<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Berkas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['session', 'encryption', 'secure', 'upload']);
        $this->lang->load('auth');
        $this->load->model(['m_mail', 'pmb/m_pendaftar',]);
        $this->load->helper(['url', 'language', 'auth', 'security']);
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function get_data_by_id()
    {
        $id = $this->input->post("id");
        $pelajar = $this->m_pendaftar->GetDataPelajarById($id)->row_object();
        $token = $this->secure->encrypt_url($pelajar->nomor_registrasi);
        echo json_encode(['dt1' => $pelajar, 'token' => $token], true);
    }

    function upload_berkas()
    {
        $idPelajar      = $this->input->post("idPelajar");
        $Photo          = $this->input->post("Photo");
        $FileAkte       = $this->input->post("FileAkte");
        $FileKK         = $this->input->post("FileKK");
        $FileRaport     = $this->input->post("FileRaport");
        $data = [
            'gambar' => $Photo,
            'akte' => $FileAkte,
            'kk' => $FileKK,
            'rapot' => $FileRaport,
        ];
        try {
            $this->db->where("id_pelajar", $idPelajar)->update("master_pmb_register_pelajar", $data);
            $info = [
                'icon' => 'thumbs-up',
                'title' => 'Success!',
                'description' => 'Update Berkas Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
            $result = true;
        } catch (\Exception $e) {
            $info = [
                'icon' => 'fa-frown-o',
                'title' =>  'Update Berkas Gagal',
                'description' => $e->getMessage(), "\n",
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
            $result = false;
        }

        echo $this->output_json(['result' => $result, 'data' => $data, 'event' => $info]);
    }

    function upload_file()
    {
        $config['upload_path'] = './berkas';
        $config['allowed_types'] = 'pdf';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        if (!empty($_FILES['file']['name'])) {
            if ($this->upload->do_upload('file')) {
                $gbr = $this->upload->data();
                $config['source_image'] = './berkas/' . $gbr['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $photomhs = $gbr['file_name'];
                $response = [
                    "file" => $photomhs,
                ];
                echo json_encode($response);
                exit;
            }
        }
        echo 0;
    }

    function uploads_img()
    {
        $config['upload_path'] = './berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        if (!empty($_FILES['file']['name'])) {
            if ($this->upload->do_upload('file')) {
                $gbr = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = './berkas/' . $gbr['file_name'];
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = false;
                $config['quality'] = 50;
                $config['new_image'] = './berkas/' . $gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $photomhs = $gbr['file_name'];
                $response = [
                    "img" => substr($config['new_image'], 1),
                    "nimg" => $photomhs,
                ];
                echo json_encode($response);
                exit;
            }
        } else {
            echo 0;
        }
    }
}

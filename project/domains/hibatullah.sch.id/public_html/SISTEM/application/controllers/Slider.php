<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Slider extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'encryption', 'secure', 'user_agent']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model(['m_slider', 'm_lembaga']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        $this->load->library('upload');
        is_auth_chek();
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function index()
    {
        $data['TitelPage'] = 'Slide Gambar';
        $data['data_plug'] = 'datatable';
        $data['action'] = 'slider_v3.2';
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('slider');
        $this->load->view('template/footer');
    }
    function get_data()
    {
        $data =  $this->m_slider->GetAllDataUser()->result();
        $no = 1;
        $res_data = [];
        foreach ($data as $row) {
            if ($this->session->userdata("idlevel") == 1) {
                $BTN_A = '<button type="button" class="btn btn-sm btn-primary openform" data-id="' . $this->secure->encrypt_url($row->id_slide) . '" data-option="Edit"><i class="dw dw-edit2"></i> Update</button>
            ';
            } else {
                $BTN_A = '';
            }
            $act = '<i class="icon-copy ion-close-round text-danger"></i>';
            if ($row->active == 1) {
                $act = '<i class="icon-copy ion-checkmark-round text-success"></i>';
            }
            $pertama = '<i class="icon-copy ion-close-round text-danger"></i>';
            if ($row->current == 1) {
                $pertama = '<i class="icon-copy ion-checkmark-round text-success"></i>';
            }
            $urlset = '<i class="icon-copy ion-close-round text-danger"></i>';
            if ($row->red == 1) {
                $urlset = '<i class="icon-copy ion-checkmark-round text-success"></i>';
            }
            $imgset = $row->img;
            $img = "assets/slider/" . $row->img;
            if (!file_exists(FCPATH . $img)) {
                $imgset = 'default.jpg';
            }
            $res_data[] = [
                // $no++,
                '<img style="width:220px" src="' . base_url("assets/slider/" . $imgset) . '" alt="slider">',
                $row->url,
                $urlset,
                // $pertama,
                $act,
                '<div class="col">
                ' . $BTN_A . '
                </div>'
            ];
        }
        echo json_encode(['data' => $res_data], true);
    }
    function get_data_by()
    {
        $id = $this->secure->decrypt_url($this->input->post('id'));
        $data = $this->db->get_where("sys_slider", ['id_slide' => $id])->row_object();
        echo $this->output_json($data);
    }
    function new_data()
    {
        $id = $this->input->post("idUser");

        $Link = $this->input->post("Link");
        $Active = $this->input->post("Active");
        $Current = $this->input->post("Current");
        $Url = $this->input->post("Url");
        $Image = $this->input->post("Image");
        $data = [
            'active' => $Active,
            'current' => $Current,
            'img' => $Image,
            'red' => $Link,
            'url' => $Url,
        ];

        // if ($Active > 0) {
        //     $this->db->set('current', '0');
        //     $this->db->update('sys_slider');
        // }
        try {
            $simpan = $this->m_slider->update_data($data, $id);
            if ($simpan) {
                $info = [
                    'icon' => 'thumbs-up',
                    'title' => ' Success!',
                    'description' => 'Simpan Data Berhasil',
                    'color' => '#a4cc00',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
            } else {
                $info = [
                    'icon' => 'frown-o',
                    'title' => 'Ooppss!',
                    'description' => 'Simpan Data Gagal!',
                    'color' => '#df0000',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
            }
        } catch (\Throwable $th) {
            $info = [
                'icon' => 'frown-o',
                'title' => 'Ooppss!',
                'description' => $th,
                'color' => '#df0000',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        }

        echo $this->output_json(['result' => true, 'event' => $info, $data, $id]);
    }
    function uploads_img()
    {
        $config['upload_path'] = './assets/slider/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        if (!empty($_FILES['file']['name'])) {
            if ($this->upload->do_upload('file')) {
                $gbr = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/slider/' . $gbr['file_name'];
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = false;
                $config['quality'] = '70%';
                $config['new_image'] = './assets/slider/' . $gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $photomhs = $gbr['file_name'];
                $response = [
                    "img" => base_url(substr($config['new_image'], 1)),
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

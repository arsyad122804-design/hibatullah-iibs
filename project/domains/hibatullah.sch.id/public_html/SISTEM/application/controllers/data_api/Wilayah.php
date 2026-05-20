<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'encryption']);
        $this->load->helper(['url', 'language']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
    }

    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function get_kecamatan()
    {
        $id = $this->input->post("id");
        $kecamatan = $this->db->get_where("master_wilayah_kecamatan", ['kota_id' => $id])->result();
        echo $this->output_json(['result' => true, 'kec' => $kecamatan]);
    }
    function get_kelurahan()
    {
        $id = $this->input->post("id");
        $kelurahan = $this->db->get_where("master_wilayah_kelurahan", ['kecamatan_id' => $id])->result();
        echo $this->output_json(['result' => true, 'kel' => $kelurahan]);
    }
}

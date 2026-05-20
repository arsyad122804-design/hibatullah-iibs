<?php

function is_auth_chek()

{
    $ci = get_instance();
    $ci->load->library('user_agent');
    if (!$ci->session->userdata('id_user')) {
        redirect('auth/logout');
    } else {
        $ci->session->set_userdata('referrer_url', current_url());
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Myphp extends CI_Controller
{
    function index()
    {
        phpinfo();
    }
}

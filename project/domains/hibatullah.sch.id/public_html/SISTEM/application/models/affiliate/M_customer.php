<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_customer extends CI_Model
{
    function GetAllDataUser()
    {

        $QR = "SELECT * FROM data_customer a
        LEFT JOIN sys_user b ON b.id_user = a.id_aff";
        return $this->db->query($QR);
    }

    function GetAllDataUserID($id)
    {
        $QR = "SELECT * FROM data_customer a
        LEFT JOIN sys_user b ON b.id_user = a.id_aff
       WHERE a.id_aff = '$id'";
        return $this->db->query($QR);
    }
}

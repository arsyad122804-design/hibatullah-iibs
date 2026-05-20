<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Payment extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(['form_validation', 'session', 'secure']);
		$params = array('server_key' => 'Mid-server-Abt88gw49JHKgOPVZDr457FI', 'production' => true);
		// $params = array('server_key' => '', 'production' => true);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper(['url', 'language', 'string']);
		// $this->load->model('m_payment');
		// $this->load->library('cart');
	}
	function index()
	{
		redirect(base_url(), 'refresh');
	}
	public function output_json($data)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function token()
	{
		$noregister = $this->input->post('noreg');
		$fullname = $this->input->post('nama');
		$namakelas = $this->input->post('pembayaran');
		$total = $this->input->post('nominal');
		$phone = $this->input->post('wa');
		$jns = $this->input->post('jns');
		$email = $this->input->post('email');
		$address = "";
		$MethodeBayar = $this->input->post('MethodeBayar');


		$order_id = "INV" . date('ym') . rand();
		$gross_amount = intval($total);
		// Required
		$transaction_details = array(
			'order_id' => $order_id,
			'gross_amount' =>   $gross_amount, // no decimal allowed for creditcard
		);

		$productList[] = array(
			'id' => $noregister,
			'price' => $total,
			'quantity' => 1,
			'name' => $namakelas
		);

		$item1_details = $productList;
		// Optional
		$billing_address = array(
			'first_name'    => $fullname,
			'address'       => $address,
			'phone'         => $phone,
			'country_code'  => 'IDN'
		);
		// Optional
		$shipping_address = array(
			'first_name'    => $fullname,
			'address'       => $address,
			'phone'         => $phone,
			'country_code'  => 'IDN'
		);
		$customer_details = array(
			'first_name'    => $fullname,
			'email'         => $email,
			'phone'         => $phone,
			'billing_address'  => $billing_address,
			'shipping_address' => $shipping_address
		);

		$credit_card['secure'] = true;
		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'days',
			'duration'  => 6
		);

		$params_id = $this->secure->encrypt_url($order_id);
		$gopay = array(
			"enable_callback" => true,
			"callback_url" => base_url()
		);
		$bni_va = array('va_number' => '1234' . substr($phone, 0, -4));
		$bri_va = array('va_number' => '1234' . substr($phone, 0, -4));
		$permat_va = array(
			"va_number" => "1234567890",
			"recipient_name" => "HIBATULLAH"
		);
		// echo json_encode($transaction_details);
		$mandiri_va = array('bill_info1' => 'echannel', "bill_info2" => "Online purchase");
		switch ($MethodeBayar) {
			case 'VA-BNI':
				$transaction_data = array(
					'enabled_payments'        => ['bni_va'],
					'bni_va'                => $bni_va,
					'transaction_details' => $transaction_details,
					'item_details'       => $item1_details,
					'customer_details'   => $customer_details,
					'expiry'             => $custom_expiry,
				);
				break;
			case 'VA-BRI':
				$transaction_data = array(
					'enabled_payments'        => ['bri_va'],
					'bri_va'                => $bri_va,
					'transaction_details' => $transaction_details,
					'item_details'       => $item1_details,
					'customer_details'   => $customer_details,
					'expiry'             => $custom_expiry,
				);
				break;
			case 'VA-PERMATA':
				$transaction_data = array(
					'enabled_payments'    => ['permata_va'],
					'permata_va' => $permat_va,
					'transaction_details' => $transaction_details,
					'item_details'       => $item1_details,
					'customer_details'   => $customer_details,
					'expiry'             => $custom_expiry,
				);
				break;
			case 'em-gopay':
				$transaction_data = array(
					'enabled_payments'        => ['gopay'],
					'gopay'                => $gopay,
					'transaction_details' => $transaction_details,
					'item_details'       => $item1_details,
					'customer_details'   => $customer_details,
					'expiry'             => $custom_expiry,
				);
				break;
			case 'VA-MANDIRI':
				$transaction_data = array(
					'enabled_payments'        => ['echannel'],
					'echannel' => $mandiri_va,
					'transaction_details' => $transaction_details,
					'item_details'       => $item1_details,
					'customer_details'   => $customer_details,
					'expiry'             => $custom_expiry
				);
				break;
			default:
				$transaction_data = array(
					'enabled_payments'      => ['other_va'],
					'transaction_details' 	=> $transaction_details,
					'item_details'       	=> $item1_details,
					'customer_details'   	=> $customer_details,
					'expiry'             	=> $custom_expiry
				);
				break;
		}
		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);

		echo $snapToken;
		if ($snapToken) {
			$send_data = [
				'nomor_reg'         => $noregister,
				'nota'          	=> $order_id,
				'jns'          		=> $jns,
				'payment_type'      => $MethodeBayar,
				'fraud_status'      => 'created',
				'transaction_status' => 'created',
				'expiry_at'    		=> date("Y-m-d H:i", strtotime('+6 days'))
			];
			// API endpoint	
			$site_api = "https://sistem.hibatullah.sch.id/";
			$apiUrl = $site_api . 'api/v1/pmb/regtoken';
			// Headers for the FCM request
			$headers = [
				"cache-control: no-cache",
				"content-type: application/json",
				"x-api-key: 1234567"
			];
			// Initialize cURL session
			$ch = curl_init();
			// Set cURL options
			curl_setopt($ch, CURLOPT_URL, $apiUrl);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($send_data));
			// Execute cURL session and capture the response
			$response = curl_exec($ch);
			// Close cURL session
			// Close cURL session
			curl_close($ch);
			// echo $response;
			die();
			// $this->finish($);
		}
	}

	public function finish()
	{
		$datapost = $this->input->post('result_data');
		$dtsv = json_decode($datapost, true);
		$vanumber = 0;
		$biller = 0;
		$inv = $dtsv['pdf_url'];
		if (isset($dtsv['permata_va_number'])) {
			$vanumber = $dtsv['permata_va_number'];
		}
		if (isset($dtsv['va_numbers'])) {
			$vanumber = $dtsv['va_numbers'];
			if (is_array($vanumber)) {
				$vanumber = $dtsv['va_numbers'][0]['va_number'];
			};
		}
		if (isset($dtsv['biller_code'])) {
			$biller = $dtsv['biller_code'];
			$vanumber = $dtsv['bill_key'];
		}
		$customer1 = [
			'transaction_id'        => $dtsv['transaction_id'],
			'gross_amount'            => $dtsv['gross_amount'],
			'payment_type'            => $dtsv['payment_type'],
			'transaction_time'        => $dtsv['transaction_time'],
			'fraud_status'            => $dtsv['fraud_status'],
			'va_number'            => $vanumber,
			'biller'            => $biller,
			'invoice'            => $inv,
			'transaction_status'    => $dtsv['transaction_status']
		];

		$params = $this->secure->encrypt_url($dtsv['order_id']);
		$this->db->set($customer1);
		$this->db->where("order_id", $dtsv['order_id']);
		if ($this->db->update('data_class_order')) {
			redirect(base_url('invoice/' . $params));
			// echo  $vanumber;
		}
	}

	public function finish_order($param = null, $pdf = null)
	{
		if ($param != null) {
			if ($pdf == 'pdf') {

				$this->load->library('pdf');
				$params = $this->secure->decrypt_url($param);
				$id = $params;

				$checking_order = $this->m_payment->GetOrderID($id)->row_object();
				// echo print_r($checking_order);
				$data_['title'] = 'Invoice ' . $id;
				$data_['data'] = $checking_order;
				$data_['status'] = json_decode($this->status_bayar($checking_order->transaction_status));

				$this->data['title_pdf'] =  'Invoice ' . $id;
				$file_pdf =  'Invoice ' . $id;
				$paper = 'A4';
				$orientation = "portrait";
				//echo $this->output_json(['id' => $id]);

				// $this->load->view('web/invoice_pdf', $data_);
				$html = $this->load->view('web/invoice_pdf', $data_, true);
				$this->pdf->generate($html, $file_pdf, $paper, $orientation, FALSE);
			} else {
				$params = $this->secure->decrypt_url($param);
				// $rd = json_decode($params);
				$id = $params;
				$checking_order = $this->m_payment->GetOrderID($id)->row_object();

				// print_r($checking_order);
				$data['title'] = 'Finish Order';
				$data['data'] = $checking_order;
				// $data['data2'] = $rd;
				$data['status'] = json_decode($this->status_bayar($checking_order->transaction_status));
				$this->load->view('web/template/head_proses', $data);
				$this->load->view('web/invoice');
				$this->load->view('web/template/footer_proses');
			}
		} else {
			$this->load->view("errors/html/error_404");
		}
	}


	function status_bayar($e)
	{
		switch ($e) {
			case 'pending':
				$result = [
					'st' => 'Menunggu Pembayaran',
					'msg' => 'Mohon Untuk Melakukan transaksi pembayaran sebelum masa <b>Expired</b>.'
				];
				break;
			case 'settlement':

				$result = [
					'st' =>  'Pembayaran Berhasil',
					'msg' => 'Terimaksih sudah melakukan pembayaran sebelum masa berlaku habis..'
				];
				break;
			case 'expire':
				$result = [
					'st' =>  'Invoice Sudah Expired',
					'msg' => 'Mohon Untuk Melakukan transaksi ulang karena sudah masa <b>Expired</b>.'
				];
				break;
			case 'failure':
				$result = [
					'st' =>  'Gagal',
					'msg' => 'Mohon ma' . "'" . 'af transaksi tidak bisa dimuat, silahkan lakukan pemesanan ulang..'
				];
				break;
			case 'cancel':
				$result = [
					'st' =>  'Dibatalkan',
					'msg' => 'Mohon ma' . "'" . 'af transaksi tidak bisa dimuat, silahkan lakukan pemesanan ulang..'
				];
				break;
			case 'Gratis':
				$result = [
					'st' =>  'Gratis',
					'msg' => 'Selamat Anda sudah bisa mengakses kelas anda secara gratis..'
				];
				break;

			default:
				$result = [
					'st' => 'Menunggu Pembayaran',
					'msg' => 'Mohon Untuk Melakukan transaksi pembayaran sebelum masa <b>Expired</b>.'
				];
				break;
		}
		return json_encode($result);
	}
	function kelas_free()
	{
		$idu = $this->input->post('id');
		$MethodeBayar = $this->input->post('MethodeBayar');


		$noregister = $this->input->post('klsid');

		$price = $this->input->post('price');
		$ppn = $this->input->post('Ppn');
		$diskon = $this->input->post('Diskon');
		$total = $this->input->post('nominal');

		$order_id = "INV" . date('ym') . rand();
		$gross_amount = $total;
		$savedata = [
			'id' => '',
			'order_id'          => $order_id,
			'transaction_id'    =>  "Free",
			'user_id'         => $idu,
			'kelas_id'			=> $noregister,
			'discount'          => $diskon,
			'ppn'             	=> $ppn,
			'price'            	=> $price,
			'gross_amount'      => $gross_amount,
			'payment_type'      => $MethodeBayar,
			'bank'      => $MethodeBayar,
			'active' => 1,
			'fraud_status'      => 'Gratis',
			'transaction_status' => 'Gratis',
			'created_at'    	=> date('Y-m-d H:i'),
			'expiry_at'    		=> date("Y-m-d H:i", strtotime('+6 days'))
		];


		$simpan = $this->db->insert('data_class_order', $savedata);
		if ($simpan) {
			$params = $this->secure->encrypt_url($order_id);
			$urls = base_url('invoice/' . $params);
			$proses = 1;
			$alert = [
				'info' => 'success',
				'text' => 'Daftar Kelas Berhasil..',
			];
		} else {
			$urls = "#";
			$proses = 0;
			$alert = [
				'info' => 'error',
				'text' => 'Daftar Kelas Gagal..',
			];
		}
		echo $this->output_json(['proses' => $proses, 'url' => $urls, 'msg' => $alert]);
	}
}

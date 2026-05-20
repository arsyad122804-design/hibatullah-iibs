<!-- Appointment Start -->
<!-- initialize jQuery Library -->
<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-Yorva26_vsOUEv5L"></script>
<!-- <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-UE0MZLr5Nrrk0Dz2"></script> -->

<div class="container">
	<div class="bg-light rounded">
		<div class="row g-0">
			<div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
				<div class="h-100 d-flex flex-column justify-content-center bg-white ">
					<div class="col-md-12 ">
						<?php
						$response = $data->data;
						// echo json_encode($response);
						$json = $this->secure->encrypt_url(json_encode(['url' => $site_api, 'id' => $response->nomor_registrasi]));
						// print_r($response->nomor_registrasi);
						if ($data->status == 200) :
							$msg = "";
							$msg2 = "*Kami juga mengirimkan pesan ini ke email <b>" . $response->email . "</b>";
							$gender = '-';
							if ($response->jns_kelamin == 1) {
								$gender = 'Laki-Laki';
							} elseif ($response->jns_kelamin == 2) {
								$gender = 'Perempuan';
							}

							if ($response->status == 1 and $response->transaction_status == 'settlement') :

								$msg = "";
								$msg2 = "";
								$body = $body = '<table style=" width: 100%;">
								<tr>
									<td style="text-align:left">
									<h4>Data Formulir</h4>
									</td>
									<td style="text-align: right;">
											<h2 style="text-decoration: none; color:#0d4d93;font-weight:900">
											' . strtoupper($response->nama_cabang) . '
											</h2>
									</td>
								</tr>
							</table>
						<div style="background-color: #adc4f8;color:#0a0a0a; padding:4px 10px;border-top: #e37b46 double 8px;">
							<table style="width: 100%;">
								<tr>
									<td style="text-align:left;font-weight:900">No. Registrasi</td>
									<td style="text-align:right;font-weight:900; font-size:14pt">#' . $response->nomor_registrasi . '</td>
								</tr>
							</table>
						</div>
						<br>
						<div style="background-color: #fff; color:#0a0a0a ">
							<div class="col">
								<div >
								<div class="row">
									<div class="col-md-6" style="padding:4px 10px">
										<div style="font-weight:500; font-size:14pt; margin-bottom:6px">Data Calon Peserta Didik Baru :</div>
										<table style="width:100%;text-align:left">
											<tr>
												<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:100px"><b>Nama Lengkap</b></td>
												<td style="width:10px">: </td>
												<td>' . strtoupper($response->nama_lengkap) . '</td>
											</tr>
											<tr>
												<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:100px"><b>Tempat Lahir</b></td>
												<td style="width:10px">: </td>
												<td>PPDB ' . ($response->kota) . '</td>
											</tr>
											<tr>
												<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Tanggal Lahir</b></td>
												<td style="width:6px">: </td>
												<td>' . date("d-m-Y", strtotime($response->tgl_lahir)) . '</td>
											</tr>
											<tr>
												<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Jenis Kelamin</b></td>
												<td style="width:6px">: </td>
												<td>' . strtoupper($gender) . '</td>
											</tr>
											<tr>
												<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Alamat Domisili</b></td>
												<td style="width:6px">: </td>
												<td>' . ($response->alamat) . '</td>
											</tr>
											<tr>
												<td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Nama Ayah/Ibus</b></td>
												<td>: </td>
												<td>' . strtoupper($response->wali_peserta) . '
												</td>
											</tr>
											<tr>
												<td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>No. Telepon</b></td>
												<td>: </td>
												<td>' . $response->phone . '
												</td>
											</tr>
											<tr>
												<td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Email</b></td>
												<td>: </td>
												<td>' . $response->email . '</td>
											</tr>
										</table>
										</div>
										<div class="col-md-6" >
										<div style=" border-radius:10px; background-color:#adc4f8;color:#0a0a0a;">

											<table style="width:100%; background-color:#ff8040; border-radius:10px 10px 0 0;">
											<tr>
												<td style="text-align: left; font-size:12pt;font-weight:700;vertical-align:top;padding:2px 10px;">Invoice</td>
												
												<td style="text-align:right;padding:2px 10px; ">
													<span style="font-size:12px; font-weight:800">#' . $response->nota . '</span> 
													</td>
											</tr>
											</table>
											
										<div style=" padding:10px; ">
											<table style="width:100%">
												<thead>
													<th style="text-align: left;font-weight:500; font-size:12pt; ">Pembayaran</th>
													<th style="text-align:right;font-weight:500; font-size:12pt; ">Nominal</th>
												</thead>
												<tr>
													<td style="text-align: left; font-size:12pt;;font-weight:700;vertical-align:top">Formulir PPDB ' . $response->nama_cabang . '</td>
													
													<td style="text-align:right; ">
														<span style="font-size:26px; font-weight:800">Rp. ' . number_format($response->nominal) . '</span> 
														</td>
												</tr>
												<tr>
													<td style="text-align: left; font-size:12pt;;font-weight:700;vertical-align:top"></td>
													
													<td style="text-align:right; ">
													<div>Status Pembayaran</div>
													<h4>BERHASIL</h4>
														</td>
												</tr>

											</table>

											</div>
											</div>
											
										
										</div>
										</div>
										</div>
										</div>
									</div>';
							else :
								$body = '<table style=" width: 100%;">
						<tr>
							<td style="text-align:left">
                            <h4>Data Formulir</h4>
							</td>
							<td style="text-align: right;">
									<h2 style="text-decoration: none; color:#0d4d93;font-weight:900">
									' . strtoupper($response->nama_cabang) . '
									</h2>
							</td>
						</tr>
					</table>
				<div style="background-color: #adc4f8;color:#0a0a0a; padding:4px 10px;border-top: #e37b46 double 8px;">
					<table style="width: 100%;">
						<tr>
							<td style="text-align:left;font-weight:900">No. Registrasi</td>
							<td style="text-align:right;font-weight:900; font-size:14pt">#' . $response->nomor_registrasi . '</td>
						</tr>
					</table>
				</div>
                <br>
				<div style="background-color: #fff; border-bottom: #e37b46 double 2px; color:#0a0a0a">
					<div class="col">
						<div >
						<div class="row">
							<div class="col-md-6" style="padding:4px 10px">
								<div style="font-weight:500; font-size:14pt; margin-bottom:6px">Data Calon Peserta Didik Baru :</div>
								<table style="width:100%;text-align:left">
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:100px"><b>Nama Lengkap</b></td>
										<td style="width:10px">: </td>
										<td>' . strtoupper($response->nama_lengkap) . '</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:100px"><b>Tempat Lahir</b></td>
										<td style="width:10px">: </td>
										<td>' . ($response->kota) . '</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Tanggal Lahir</b></td>
										<td style="width:6px">: </td>
										<td>' . date("d-m-Y", strtotime($response->tgl_lahir)) . '</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Jenis Kelamin</b></td>
										<td style="width:6px">: </td>
										<td>' . strtoupper($gender) . '</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Alamat Domisili</b></td>
										<td style="width:6px">: </td>
										<td>' . ($response->alamat) . '</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Nama Ayah/Ibus</b></td>
										<td>: </td>
										<td>' . strtoupper($response->wali_peserta) . '
										</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>No. Telepon</b></td>
										<td>: </td>
										<td>' . $response->phone . '
										</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Email</b></td>
										<td>: </td>
										<td>' . $response->email . '</td>
									</tr>
								</table>
								</div>
								<div class="col-md-6" >
								<div style=" padding:10px; border-radius:10px; background-color:#adc4f8;color:#0a0a0a;">
									<table style="width:100%">
										<thead>
											<th style="text-align: left;font-weight:500; font-size:12pt; ">Pembayaran</th>
											<th style="text-align:right;font-weight:500; font-size:12pt; ">Nominal</th>
										</thead>
										<tr>
											<td style="text-align: left; font-size:12pt;;font-weight:700;vertical-align:top">Formulir PPDB ' . $response->nama_cabang . '</td>
											
											<td style="text-align:right; ">
												<span style="font-size:26px; font-weight:800">Rp. ' . number_format($response->nominal) . '</span> 
												</td>
										</tr>
									</table>
									</div>

									<form id="payment-form" method="post" action="' . base_url() . '">
									<input type="hidden" name="result_type" id="result-type" value="">
									<input type="hidden" name="result_data" id="result-data" value="">
									</form>
									<div class="page-customer mb-2 wow slideInUp" data-wow-delay="0.1s">
										<input type="hidden" value="' . $response->nomor_registrasi . '" id="noregis">
										<input type="hidden" value="PPDB FORMULIR" id="pembayaran">
										<input type="hidden" value="1" id="Jns">
										<input type="hidden" class="Total" value="' . $response->nominal . '" id="nominal">
										<input type="hidden" value="' . $response->nama_lengkap . '" id="nama">
										<input type="hidden" value="' . $response->email . '" id="email">
										<input type="hidden" class="form-control valids " value="' . $response->phone . '" id="wa" required />
									</div>
									<div class="Proses">
									<div>
										<span>Metode Pembayaran</span>
										<select id="MethodeBayar" class="MethodeBayar form-control valids" style="width: 100%;font-weight:700" required />
										<option></option>
										<optgroup label="E-WALLET">
											<option value="em-gopay">GOPAY</option>
										</optgroup>
		
										<optgroup label="VIRTUAL ACCOUNT">
											<option value="VA-BNI">Bank Negara Indonesia (BNI)</option>
											<option value="VA-MANDIRI">Bank Mandiri</option>
											<option value="VA-PERMATA">Bank Permata</option>
											<option value="VA-BRI">Bank BRI</option>
											<!--option value="VA-BSS"> Bank Sahabat Sampoerna</!--option-->
										</optgroup>
										</select>
									</div>
									<div class=" py-2 mt-2 ">
										<div class="text-center load-proses" style="display: none;">
											<img src="' . base_url("assets/images/spin3.svg") . '" alt="spin" width="80px">
											<div>Mohon Menunggu...</div>
										</div>
										<button id="pay-button" class="btn btn-primary py-3 px-5 my-2 mt-3  wow zoomIn" style="width:100%; display:block;" data-wow-delay="0.8s">
											<strong>PROSES PEMBAYARAN </strong></button>
									</div>
								</div>
								</div>	
							</div>
						
							</div>
						</div>
					</div>
		';

							endif;
						else :
							$msg = "Registrasi Gagal";
							$msg2 = "";
							$body = "";
						endif;
						?>
						<h1 class="mb-4 text-center"><?= $msg; ?></h1>
						<p><?= $body; ?></p>
						<div class="mb-5"><?= $msg2; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		// Menggunakan jQuery untuk menangani klik pada tombol copy
		$(".CopyData").click(function() {
			// Pilih teks yang akan di-copy
			var copys = $(this).data("val");
			var temp = $("<input>").val(copys);
			$("body").append(temp);
			temp.select();
			document.execCommand('copy');
			temp.remove();

			var notificationTag = $("div.copy-notification");
			notificationTag = $("<div/>", {
				"class": "copy-notification",
				text: "Copy : " + copys
			});
			$("body").append(notificationTag);

			notificationTag.fadeIn("slow", function() {
				setTimeout(function() {
					notificationTag.fadeOut("slow", function() {
						notificationTag.remove();
					});
				}, 1000);
			});
		});

		function formatState(state) {
			if (!state.id) {
				return state.text;
			}
			var $state = $(
				'<span><img src="<?= base_url() ?>assets/pay/' + state.element.value.toLowerCase() + '.png" class="img-flag" style="width:80px" /> ' + state.text + '</span>'
			);
			return $state;
		};
		$("#MethodeBayar").select2({
			templateResult: formatState,
			minimumResultsForSearch: Infinity,
			placeholder: "--Pilih Metode Pembayaran--",
			allowClear: true
		});
	});
	$('#pay-button').click(function(event) {

		var noreg = $("#noregis").val();
		var pembayaran = $("#pembayaran").val();
		var nominal = $("#nominal").val();
		var nama = $("#nama").val();
		var email = $("#email").val();
		var wa = $("#wa").val();
		var jns = $("#Jns").val();

		var MethodeBayar = $("#MethodeBayar").val();
		event.preventDefault();
		$(this).attr("disabled", "disabled");
		$.ajax({
			method: 'POST',
			url: '<?= base_url() ?>checking-pay',
			data: {
				noreg: noreg,
				pembayaran: pembayaran,
				nominal: nominal,
				nama: nama,
				email: email,
				wa: wa,
				jns: jns,
				MethodeBayar: MethodeBayar,
			},
			cache: false,
			beforeSend: function() {
				// $(".loader").show(0);
				$(".load-proses").css('display', 'block');
			},
			error: function(x) {
				console.log(x.responseText);
			},
			success: function(data) {

				console.log('token = ' + data);

				var resultType = document.getElementById('result-type');
				var resultData = document.getElementById('result-data');

				function changeResult(type, data) {
					$("#result-type").val(type);
					$("#result-data").val(JSON.stringify(data));
					//resultType.innerHTML = type;
					//resultData.innerHTML = JSON.stringify(data);
				}

				snap.pay(data, {

					onSuccess: function(result) {
						changeResult('success', result);
						// console.log(result.status_message);
						console.log(result);
						$("#payment-form").submit();
					},
					onPending: function(result) {
						changeResult('pending', result);
						// console.log(result.status_message);
						$("#payment-form").submit();
					},
					onError: function(result) {
						changeResult('error', result);
						console.log(result.status_message);
						$("#payment-form").submit();
					}
				});

				// $(".loader").fadeOut(1000);
				$(".load-proses").css('display', 'none');
			}
		});
	});
</script>
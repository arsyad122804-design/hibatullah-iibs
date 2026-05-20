<style>
	.carousel-indicators li {
		border-radius: 100%;
		width: 10px;
		height: 10px;
		margin: 0 8px;
	}
</style>

<div class="main-container">
	<div class="card-box w-100  mb-10 text-center">
		<div style="padding:10px; font-size:13pt">Assalamu'alaikum
			<div style="font-weight: 800;"><b><?= $this->session->userdata('nmuser'); ?></b></div>
		</div>
	</div>
	<?php if ($this->session->userdata("idlevel") == 50) : ?>
		<div class="container-xxl py-5">
			<div class="container">
				<div class="bg-light rounded">
					<div class="row g-0">
						<div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
							<div class="h-100 d-flex flex-column justify-content-center p-4 ">
								<div class="col-md-12 text-center">
									<h1 class="mb-4 text-center">Pendaftaran Pesarta Didik Baru</h1>
									<?php
									$dtppdb = $this->db->get_where("master_pmb_register_pelajar", ['id_pelajar' => $this->session->userdata("fid_keterangan")])->row_object();
									if ($dtppdb->status_pelajar == 3) : ?>
										<p>Silahkan lengkapi data diri calon peserta didik baru dan selesaikan pembayaran tes seleksi </p>

									<?php elseif ($dtppdb->status_pelajar == 4) : ?>
										<p>Terimakasih sudah melakukan pembayaran tes seleksi PPDB, kartu tes seleksi ananda sudah kami buatkan</p>
									<?php endif; ?>
									<div class="row mt-3">

										<div class="col">

											<a href="<?= base_url('pmb/datadiri/' . $this->secure->encrypt_url($this->session->userdata('user'))) ?>">

												<div class="w-100 align-items-center ">

													<div class="widget-data ">

														<div class="text-center p-2 rounded card-icon-d ">

															<img src="<?= base_url('assets/images/Data-Santri.png') ?>" alt="target" width="60px">

														</div>

													</div>

													<div class="menudashboard mb-0 text-center"> Data Diri Peserta
													</div>

												</div>

											</a>

										</div>
										<div class="col">
											<a href="<?= base_url('pmb/pembayaran/' . $this->secure->encrypt_url($this->session->userdata('user'))) ?>">

												<div class="w-100 align-items-center ">

													<div class="widget-data ">

														<div class="text-center p-2 rounded card-icon-d ">

															<img src="<?= base_url('assets/images/Rekap-Infaq.png') ?>" alt="target" width="60px">

														</div>

													</div>

													<div class="menudashboard mb-0 text-center">Pembayaran Tes Seleksi</div>

												</div>

											</a>

										</div>


										<?php if ($dtppdb->status_pelajar == 4) : ?>
											<div class="col">

												<a href="<?= base_url('pmb/cardprofile/' . $this->secure->encrypt_url($this->session->userdata('user'))) ?>" target="_blank">

													<div class="w-100 align-items-center ">

														<div class="widget-data ">

															<div class="text-center p-2 rounded card-icon-d ">

																<img src="<?= base_url('assets/images/kartu.png') ?>" alt="target" width="60px">

															</div>

														</div>

														<div class="menudashboard mb-0 text-center">Kartu Tes Seleksi Data
														</div>

													</div>

												</a>

											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	<?php else : ?>
		<?php $levl = $this->session->userdata("idlevel"); ?>
		<style>
			.hero-widget {
				text-align: center;
				padding-top: 20px;
				padding-bottom: 20px;
			}

			.hero-widget .icon {
				display: block;
				font-size: 96px;
				line-height: 96px;
				margin-bottom: 10px;
				text-align: center;
			}

			.hero-widget var {
				display: block;
				height: 64px;
				font-size: 64px;
				line-height: 64px;
				font-style: normal;
			}

			.hero-widget label {
				font-size: 17px;
			}

			.hero-widget .options {
				margin-top: 10px;
			}
		</style>

		<?php if ($this->session->userdata("idlevel") == 22) : ?>
			<div class="pd-ltr-20">
				<a target="_blank" href="https://api.whatsapp.com/send?text=<?= 'https://ppdb.hibatullah.sch.id/' . $tokenset->aff_id ?>" class="btn btn-xl btn-success rounded-lg"> <span class="fa fa-whatsapp"></span> Share Link PPDB</a>
			</div>
		<?php endif; ?>
		<div class="pd-ltr-20">

			<!--/*///////////////////*/ -->

			<div class="row ">
				<div class="col-xl-12 mb-30">
					<div class="form-group mb-1">
						<div class="input-group-prepend row ">
							<span class="input-group-text" id="basic-addon1" style="width: 160px;">Periode Pendaftaran </span>
						</div>
						<div class="col-sm-4 row">
							<?php $periodesctiv = $this->db->query("SELECT * FROM master_pmb_tahun_akademik where active=1 ORDER BY tahun_akademik ASC")->row_object(); ?>
							<?php $dt_periode = $this->db->query("SELECT * FROM master_pmb_tahun_akademik ORDER BY id_tahun DESC")->result(); ?>
							<select id="Periode_Chek" class="form-control">
								<option value="null">-Pilih Periode-</option>

								<?php foreach ($dt_periode as $dp) : ?>
									<?php ($periodesctiv->id_tahun == $dp->id_tahun) ? $aktif = 'selected' : $aktif = "" ?>
									<option value="<?= $dp->tahun_akademik ?>" <?= $aktif ?>><?= $dp->tahun_akademik ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-xl-4 mb-30">
					<div class="card-box height-100-p widget-style1">
						<div class="d-flex flex-row  align-items-center ">
							<div class=" col-8 weight-700 font-14   ">Jumlah Pendaftar </div>
							<div class="col-4 text-center  align-items-center  row" style="font-size:46pt;font-weight:bold">
								<span id="AllPendaftar"><?= $pendaftar; ?></span><i class="fa fa-user" style="font-size: 14pt;"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 mb-30">
					<div class="card-box height-100-p widget-style1">
						<div class="d-flex flex-wrap align-items-center">
							<div class=" col-8 weight-600 font-14  col-lg-pull-0">Pendaftar Lunas Formulir </div>
							<div class="col-4 text-center  align-items-center  row" style="font-size:46pt;font-weight:bold">
								<span id="LunaFromulir"><?= $valid; ?></span><i class="fa fa-user" style="font-size: 14pt;"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 mb-30">
					<div class="card-box height-100-p widget-style1">
						<div class="d-flex flex-wrap align-items-center">
							<div class=" col-8 weight-600 font-14  col-lg-pull-0">Pendaftar Lunas Tes Seleksi </div>
							<div class="col-4 text-center  align-items-center  row" style="font-size:46pt;font-weight:bold">
								<span id="LunasTes"><?= $migrasi; ?></span><i class="fa fa-user" style="font-size: 14pt;"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	<?php endif; ?>
</div>
<div class="modal fade ModalABS" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md " style="max-width:360px">
		<div class="modal-content">
			<div class="modal-body ABSSHOW">
			</div>
		</div>
	</div>
</div>
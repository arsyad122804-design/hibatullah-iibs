<div class="left-side-bar">
	<div class="brand-logo">
		<a href="<?= base_url() ?>">
			<img src="<?= base_url("assets/") ?>images/logo-155.png" alt="" class="dark-logo">
			<img src="<?= base_url("assets/") ?>images/logo-155.png" alt="" class="light-logo">
		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				<li>
					<a href="<?= base_url() ?>" class="dropdown-toggle no-arrow"><span class="micon dw dw-house"></span><span class="mtext">Home</span>
					</a>
				</li>
				<?php
				$level = $this->session->userdata("idlevel");
				$ids = $this->session->userdata("fid_keterangan");

				// if ($level >= 30 && $level < 100) {
				// 	$thisid = $this->db->get_where("data_pelajar", ['id_pelajar' => $ids])->row_object();
				// 	$idsiswa = $ids;
				// 	$sandnt = [
				// 		'id_santri' => $ids,
				// 	];
				// 	$urlinfaq_hd = base_url('infaq/siswa/') . $this->secure->encrypt_url($idsiswa);
				// 	$urldtsantri_hd = base_url('datasantri/get/') . $this->secure->encrypt_url(json_encode($sandnt));
				// } else {
				// 	$urlinfaq_hd = "#";
				// 	$urldtsantri_hd = base_url('data/santri');
				// }
				// $urltarget_hd = base_url("target/ziyadah");
				// $urlevaluasi_hd = base_url("evaluasi/ziyadah");

				$getdata = $this->db->get_where('sys_level', ['id_level' => $level])->row_object();
				$param = explode(',', $getdata->menu);
				for ($i = 0; $i < count($param) - 1; $i++) :
					$qrmenu = "SELECT * FROM sys_nav_menu WHERE  active !='0' AND id ='$param[$i]' ";
					if ($this->db->query($qrmenu)->num_rows() > 0) :
						$m = $this->db->query($qrmenu)->row_object();
						if ($m->mode == 'url') : ?>
							<li>
								<a href="<?= base_url() . $m->url ?>" class="dropdown-toggle no-arrow"><span class="micon <?= $m->icon ?>"></span><span class="mtext"><?= $m->menu ?></span>
								</a>
							</li>
						<?php else : ?>
							<li class="dropdown child1">
								<a href="javascript:;" class="dropdown-toggle ">
									<span class="micon <?= $m->icon ?>"></span><span class="mtext"><?= $m->menu ?></span>
								</a>
								<ul class="submenu child2">
									<?php
									$qrsubmenu = "SELECT * FROM sys_nav_menu_sub1 WHERE menu_id='$m->id' AND active=1 AND level_sys LIKE '%,$level,%'";
									$submenu = $this->db->query($qrsubmenu)->result();
									foreach ($submenu as $sm) :
										if ($sm->mode == 'url') :
									?>
											<li class="menu child2"><a href="<?= base_url() . $sm->url ?>"><?= $sm->menu ?></a></li>
										<?php else : ?>
											<li class="dropdown child2">
												<a href="javascript:;" class="dropdown-toggle ">
													<span class="micon <?= $sm->icon ?>" style="font-size: 16px;"></span><span class="mtext"><?= $sm->menu ?></span>
												</a>
												<ul class="submenu child child2">
													<?php
													$qrlvl2 = "SELECT * FROM sys_nav_menu_sub2 where sub_id = '$sm->id' AND active=1 AND level_sys LIKE '%,$level,%' ";
													$mn_levl2 = $this->db->query($qrlvl2)->result();
													foreach ($mn_levl2 as $sm2) :
													?>
														<li><a href="<?= base_url() . $sm2->url ?>"><?= $sm2->menu ?></a></li>
													<?php endforeach; ?>
												</ul>
											</li>
									<?php
										endif;
									endforeach;
									?>
								</ul>
							</li>
				<?php
						endif;
					endif;
				endfor; ?>

			</ul>
		</div>
		<div style="text-align: center;">
			<div style="margin-top:70px ; background-color: #eda24e; padding:18px">
				<a href="http://siata.org/" target="_blank" style=" font-weight:800; color:#363636;">SIATA <span style="color: #fff; font-weight:400;"> &copy;<?= date("Y") ?> </span><small>V.3.1</small> </a>
			</div>
		</div>
	</div>
</div>
<div class="mobile-menu-overlay"></div>
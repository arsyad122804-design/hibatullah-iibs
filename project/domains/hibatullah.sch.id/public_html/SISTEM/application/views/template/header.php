<div class="header">
	<div class="header-left">
		<div class="menu-icon ti-layout-grid2-alt"></div>
	</div>
	<div class="header-right">
		<div class="dashboard-setting user-notification">
			<div class="dropdown">
			</div>
		</div>
		<div class="user-notification">
			<!--div class="dropdown">
				<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
					<i class="icon-copy dw dw-notification" style="color:aliceblue;"></i>
					<span class="badge notification-active"></span>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<div class="notification-list mx-h-350 customscroll">
						<ul>
							<li>
								<a href="#">
									<img src="<?= base_url("assets/") ?>vendors/images/img.jpg" alt="">
									<h3>John Doe</h3>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
								</a>
							</li>
							<li>
								<a href="#">
									<img src="<?= base_url("assets/") ?>vendors/images/photo1.jpg" alt="">
									<h3>Lea R. Frith</h3>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
								</a>
							</li>
							<li>
								<a href="#">
									<img src="<?= base_url("assets/") ?>vendors/images/photo2.jpg" alt="">
									<h3>Erik L. Richards</h3>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
								</a>
							</li>
							<li>
								<a href="#">
									<img src="<?= base_url("assets/") ?>vendors/images/photo3.jpg" alt="">
									<h3>John Doe</h3>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
								</a>
							</li>
							<li>
								<a href="#">
									<img src="<?= base_url("assets/") ?>vendors/images/photo4.jpg" alt="">
									<h3>Renee I. Hansen</h3>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
								</a>
							</li>
							<li>
								<a href="#">
									<img src="<?= base_url("assets/") ?>vendors/images/img.jpg" alt="">
									<h3>Vicki M. Coleman</h3>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</!--div-->
		</div>
		<div class="user-info-dropdown">
			<div class="dropdown">
				<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
					<?php
					$getpict = $this->db->get_where("sys_user", ['id_user' => $this->session->userdata("id_user")])->row_object();
					if ($getpict->icon != "" || $getpict->icon != null) : ?>
						<span class="user-icon" style='background-image: url("<?= base_url("img_profile/" . $getpict->icon) ?>"); background-color: #cccccc;  background-position: center; background-size: cover;'>
						</span>
					<?php else : ?>
						<span class="user-icon" style='background-image: url("<?= base_url("img_profile/pavicon.png") ?>"); background-color: #cccccc;  background-position: center; background-size: cover;'>
						</span>
					<?php endif; ?>
					<span class="user-name" style="color:#042baa;"><?= $this->session->userdata("nmuser") ?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list" style="color:aliceblue;">
					<a class="dropdown-item" href="<?= base_url("profile") ?>"><i class="dw dw-user1"></i> Profile</a>
					<!--a-- class=" dropdown-item no-arrow" href="javascript:;" data-toggle="right-sidebar">
						<i class="dw dw-settings2"></i> Setting
					</!--a-->
					<!--a class="dropdown-item" href="profile.html"><i class="dw dw-settings2"></i> Setting</a-->
					<!--a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</!--a-->
					<a class="dropdown-item" href="<?= base_url('auth/signout') ?>"><i class="dw dw-logout"></i> Log Out</a>
				</div>
			</div>
		</div>
	</div>
</div>
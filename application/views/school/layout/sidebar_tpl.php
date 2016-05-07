<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- add "navbar-no-scroll" class to disable the scrolling of the sidebar menu -->
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li class="start">
					<a href="<?=base_url()?>school/dashboard/">
						<i class="fa fa-home"></i>
						<span class="title">
							Home
						</span>
						<span class="selected">
						</span>
					</a>
				</li>
				<? $cname = $this->router->fetch_class();?>
				<li class="start <?=$cname=="GradeLevel"||$cname=="classroom"||$cname=="student"?"active":""?>">
					<a href="<?=base_url()?>school/GradeLevel/">
						<i class="fa fa-group"></i>
						<span class="title">
							ชั้นเรียน
						</span>
						<span class="selected">
						</span>
					</a>
				</li>

				<li class="start <?=$cname=="teacher"?"active":""?>">
					<a href="<?=base_url()?>school/teacher/">
						<i class="fa fa-group"></i>
						<span class="title">
							อาจารย์
						</span>
						<span class="selected">
						</span>
					</a>
				</li>

				<li class="start">
					<a href="<?=base_url()?>school/student/move">
						<i class="fa fa-medium"></i>
						<span class="title">
							ย้ายห้องเรียน
						</span>
						<span class="selected">
						</span>
					</a>
				</li>

			</ul>
		</div>
	</div>
	<!-- END SIDEBAR -->



<?php $this->load->view("layout/header_tpl")?>
<?php $this->load->view("school/layout/head_bar_tpl")?>
<div class="clearfix">
</div>
<div class="page-container">
	<?php $this->load->view("school/layout/sidebar_tpl")?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">

			<!-- BEGIN PAGE HEADER-->
			<br/><br/>
			<div class="row">
				<div class="col-md-12">

				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN DASHBOARD STATS -->
			<div class="row">

			<?php echo $content;?>

			</div>
			<!-- END DASHBOARD STATS -->

		</div>
	</div>
	<!-- END CONTENT -->
</div>

<?php $this->load->view("layout/footer_tpl")?>

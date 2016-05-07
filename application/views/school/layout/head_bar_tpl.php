<div class="header navbar navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->

<style>
	#text-header{
	  height: 100%;
	  line-height: 100%;
	}
	#text-header h4 {
		display: inline-block;
  	vertical-align: middle;
  	line-height: normal;
		color:white;
		padding:0; margin-left:20px;
	}
</style>
		<div id="text-header"  ">
			<h4>
				<?php
					$sc_data = $this->session->userdata('sc_data');
					//print_r($sc_data);
					echo $sc_data->name;
				?>
			</h4>
		</div>
	<!-- END TOP NAVIGATION BAR -->
</div>

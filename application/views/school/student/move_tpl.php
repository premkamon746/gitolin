<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/select2/select2-metronic.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/jquery-multi-select/css/multi-select.css"/>

<script type="text/javascript" src="<?=base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>

<script src="<?=base_url();?>assets/scripts/core/app.js"></script>
<script src="<?=base_url();?>assets/scripts/custom/components-dropdowns.js"></script>

<div class="row">
<div class="col-md-12">
<!-- BEGIN PORTLET-->
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i>ย้ายห้องเรียน
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
			<a href="#portlet-config" data-toggle="modal" class="config">
			</a>
			<a href="javascript:;" class="reload">
			</a>
			<a href="javascript:;" class="remove">
			</a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->


    <div class="row">

        <div class="col-md-3">
          <label class="control-label ">ย้ายจาก</label>
          <select class="bs-select form-control">
              <option>Mustard</option>
              <option>Ketchup</option>
              <option>Relish</option>
          </select>
        </div>

      <div class="col-md-3">
        <label class="control-label ">ไปที่</label>
        <select class="bs-select form-control">
            <option>Mustard</option>
            <option>Ketchup</option>
            <option>Relish</option>
        </select>
      </div>
    </div>

		<form action="index.html" class="form-horizontal form-row-seperated">
			<div class="form-body">
				<div class="form-group">

					<label class="control-label col-md-3">Default</label>
					<div class="col-md-9">

						<select multiple="multiple" class="multi-select" id="my_multi_select1" name="my_multi_select1[]">
							<option>Dallas Cowboys</option>
							<option>New York Giants</option>
							<option>Philadelphia Eagles</option>
							<option>Washington Redskins</option>
							<option>Chicago Bears</option>
							<option>Detroit Lions</option>
							<option>Green Bay Packers</option>
							<option>Minnesota Vikings</option>
							<option>Atlanta Falcons</option>
							<option>Carolina Panthers</option>
							<option>New Orleans Saints</option>
							<option>Tampa Bay Buccaneers</option>
							<option>Arizona Cardinals</option>
							<option>St. Louis Rams</option>
							<option>San Francisco 49ers</option>
							<option>Seattle Seahawks</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-offset-3 col-md-9">
							<button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
							<button type="button" class="btn default">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- END FORM-->
	</div>
</div>
<!-- END PORTLET-->
</div>
</div>
<!-- END PAGE CONTENT-->
<script>
        jQuery(document).ready(function() {
           // initiate layout and plugins
           App.init();
           ComponentsDropdowns.init();
        });
    </script>

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/select2/select2-metronic.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/jquery-multi-select/css/multi-select.css"/>

<script type="text/javascript" src="<?=base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>

<script src="<?=base_url();?>assets/js/jquery.mockjax.js"></script>
<script src="<?=base_url();?>assets/js/bootstrap-typeahead.js"></script>

<script src="<?=base_url();?>assets/scripts/core/app.js"></script>
<script src="<?=base_url();?>assets/scripts/custom/components-dropdowns.js"></script>
<style>
	.row{
		padding:20px;
	}
</style>
<div class="row">
<div class="col-md-6">
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

	        <div class="col-md-12">
	          <label class="control-label ">ชั้นเรียน</label>
	          <select id="level" class="bs-select form-control">
	              <? foreach ($grade->result() as $g) : ?>
								<option value="<?=$g->id?>"><?=$g->name?></option>
								<? endforeach ?>
	          </select>
	        </div>
	      <div class="col-md-12">
	        <label class="control-label ">ห้อง</label>
					<select id="room" class="bs-select form-control">
					</select>
	      </div>
        <div class="col-md-12">
          <label class="control-label ">นักเรียน</label>
          <input id="demo4" type="text" class="col-md-12 form-control" placeholder="ค้นหานักเรียน..." autocomplete="off" />
        </div>

				<div class="col-md-12">
          <label class="control-label ">รายชื่อนักเรียน</label>
        	<div style="border:1px solid #ccc;height:400px;">
						<ul class="changeTo">
						</ul>
					</div>
        </div>

  </div>
		<br/><br/><br/>

		<!-- END FORM-->
	</div>
</div>
<!-- END PORTLET-->
</div>
</div>
<!-- END PAGE CONTENT-->
		<script>
        $(document).ready(function(){

          $('#demo4').typeahead({
             ajax: '<?=site_url();?>school/student/getstd',
             displayField: 'fullname',
             onSelect: function(item) {
                console.log(item.value);
            }
         });

          $('#level').change(function(){
              var url ='<?=base_url()?>school/student/getroom/'+$(this).val();
              $('#room').html("");
              $.getJSON(url,function(data){
                  $(data).each(function(i,el){
                      $('#room').append("<option value='"+el.id+"'>"+el.name+"</option>");
                  })
              })
          })

				})
    </script>

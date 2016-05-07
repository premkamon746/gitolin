<?php echo $header;?>
<?php echo $data_table;?>
    
								<div class="portlet box blue">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-save"></i>บันทึกข้อมูลอุปกรณ์
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="" class="form-horizontal form-row-seperated" method="post">
										<input type="hidden" name="dv_id" id="dv_id"/>
										<input type="hidden" name="school_id" value="<?=$school_id?>" />
											<div class="form-body">
												<div class="form-group">
													<label class="control-label col-md-3">ชื่ออุปกรณ์</label>
													<div class="col-md-9">
														<input type="text" id="name" name="name" placeholder="ชื่ออุปกรณ์" class="form-control" 
														value="<?=isset($name)?$name:'' ?>" />
														
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">หมายเลขอุปกรณ์</label>
													<div class="col-md-9">
														<input type="text" id="device_id" name="device_id" placeholder="หมายเลขอุปกรณ์" class="form-control"
														value="<?=isset($device_id)?$device_id:'' ?>"  />
														
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-md-3">เบอร์ติดต่อ</label>
													<div class="col-md-9">
														<input type="text" id="contact_number" name="contact_number" placeholder="เบอร์ติดต่อ" class="form-control"
														value="<?=isset($contact_number)?$contact_number:'' ?>"  />
														
													</div>
												</div>
												
											</div>
											
											<div class="form-actions fluid">
												<div class="row">
													<div class="col-md-12">
														<div class="col-md-offset-3 col-md-9">
															<button type="submit" class="btn green"><i class="fa fa-pencil"></i> บันทึก</button>
														
														</div>
													</div>
												</div>
											</div>
											
											
											
											
										</form>
										<!-- END FORM-->
									</div>
								</div>
								
								
								<script>
				function edit(id){
					$('#basic').modal('show');
					$.getJSON("<?=site_url("device/ajax_get_device_data");?>/"+id,function(data){
							$("#name").val(data.name);
							//console.log(data.device_id);
							$("#device_id").val(data.device_id);
							$("#dv_id").val(data.id);
							$("#contact_number").val(data.contact_number);
							scrollToAnchor($(".btn"));
							
							$('#basic').modal('hide');
					});
				}

				function deleteData(id){
					$("#delete_id").val(id);
					$("#deleteData").modal("show");
				}
			</script>
							
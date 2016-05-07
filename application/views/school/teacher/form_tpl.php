								<div class="portlet box blue">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-save"></i>บันทึกข้อมูลอาจารย์
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="" class="form-horizontal form-row-seperated" method="post">
										<input type="hidden" name="school_id" value="<?=$school_id?>" />
										<!-- <input type="hidden" id="student_id" name="student_id"  /> -->
											<div class="form-body">
												<div class="form-group">
													<label class="control-label col-md-3">ชื่อ</label>
													<div class="col-md-9">
														<input type="text" id="firstname" name="firstname" placeholder="ชื่อ" class="form-control"
														value="<?=isset($firstname)?$firstname:'' ?>" />

													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">นามสกุล</label>
													<div class="col-md-9">
														<input type="text" id="lastname" name="lastname" placeholder="นามสกุล" class="form-control"
														value="<?=isset($lastname)?$lastname:'' ?>"  />

													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3">User Name</label>
													<div class="col-md-9">
														<input type="text" id="username" name="username" placeholder="User Name" class="form-control"
														value="<?=isset($lastname)?$lastname:'' ?>"  />

													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3">Password</label>
													<div class="col-md-9">
														<input type="text" id="password" name="password" placeholder="Password" class="form-control"
														value="<?=isset($lastname)?$lastname:'' ?>"  />

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
					var time_refresh = new Date().getTime();
					$.getJSON("<?=site_url("teacher/ajax_get_std_data");?>/"+id+"?n="+time_refresh,function(data){
							$("#firstname").val(data.firstname);
							$("#lastname").val(data.lastname);ป
					});
				}

				function deleteData(id){
					$("#delete_id").val(id);
					$("#deleteData").modal("show");
				}
			</script>

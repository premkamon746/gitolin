<div class="portlet box blue col-md-12">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-save"></i>เพิ่มห้องเรียน
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="" class="form-horizontal form-row-seperated" method="post">
										<input type="hidden" name="dv_id" id="dv_id"/>
										<input type="hidden" name="school_id" value="<?=$school_id?>" />
											<div class="form-body">
												<div class="form-group">
													<label class="control-label col-md-3">ชื่อห้องเรียน เช่น 1,2, อินเตอร์, ห้องโครงการ</label>
													<div class="col-md-9">
														<input type="text" id="name" name="name" class="form-control"
														value="<?=isset($name)?$name:'' ?>" />

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
								<div style="clear:both;"></div>
<?php echo $data_table; ?>

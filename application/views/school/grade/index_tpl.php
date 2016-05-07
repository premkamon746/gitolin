<div class="portlet box blue col-md-12">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-save"></i>เพิ่มชั้นเรียน
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="" class="form-horizontal form-row-seperated" method="post">
										<input type="hidden" name="dv_id" id="dv_id"/>
										<input type="hidden" name="school_id" value="<?=$school_id?>" />
											<div class="form-body">
												<div class="form-group">
													<label class="control-label col-md-3">ชื่อชั้นเรียน</label>
													<div class="col-md-9">
														<input type="text" id="name" name="name" class="form-control"
														value="<?=isset($name)?$name:'' ?>" />

													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3">จำนวนห้อง</label>
													<div class="col-md-9">
														<input type="number" id="num_room" name="num_room" class="form-control"
														value="<?=isset($num_room)?$num_room:'' ?>" style="width:80px;" maxlength="2"/>

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

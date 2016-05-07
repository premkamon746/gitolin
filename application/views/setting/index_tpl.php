<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-flag"></i>การตั้งค่า การแจ้งเตือน
							</div>
						</div>
						<div class="portlet-body flip-scroll">
						
							<form method="post"  id="settingForm" >
							
								<table class="table table-bordered table-striped table-condensed flip-content">
								
								<tbody>
								
								<?php  foreach ($result->result() as $r) : ?>
									<tr >
										<td>
											<?php if($r->html_input =="checkbox") : ?>
													<input class="checkbox_data"  type="checkbox"  value="<?=$r->value?>"   <?=($r->value==1)?"checked":""  ?>  />
													<input type="hidden"  name="<?=$r->field_name?>" value="<?=$r->value?>" />
											<?php elseif($r->html_input =="text") : ?>
													<?php if(is_numeric($r->value)) {?>
														<input type="text" value="<?=$r->value?>" name="<?=$r->field_name?>" style="width:40px;" />
													<?php }else {?>
														<input type="text" value="<?=$r->value?>" name="<?=$r->field_name?>" style="width:250px;" />
													<?php }?>
											<?php endif ?>
											<?=$r->text_unit?>
										</td>
										<td style="width:90%"><?=$r->name ?></td>
									</tr>
								<?php endforeach ?>
									
								</tbody>
								</table>
								
						<button type="button" class="btn btn-danger" onclick="$('#settingForm').submit()">Save</button>
					</form>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->
					
					
				</div>
			</div>
			
			<script>
				$(document).ready(function(){
					$(".checkbox_data").click(function(){
							if($(this).prop("checked")==true){
								$(this).closest("td").find("input").val(1);
							}else{
								$(this).closest("td").find("input").val(0);
							}
					});
					
				});
			</script>
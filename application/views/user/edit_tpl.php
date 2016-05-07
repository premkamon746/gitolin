


<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<a href="<?=site_url("user"); ?>" >ข่าว  </a>&gt; สร้างผู้ใช้งาน
							</div>
							</div>
							
<div class="portlet-body form">
							<form role="form" method="post">
							<input type="hidden" name="user_id" value="<?=$user->id?>" />
							<div class="form-body">
									<div class="form-group">
										<label >Role</label>
										<select name="role" class="form-control" style="width:200px;">
										
											<?php foreach ($role->result() as $r) {?>
											<option value="<?=$r->id?>" <?=$r->id==$user->role?"selected":""?> ><?=$r->name ?></option>
											<?php  }?>
										</select>
										
									</div>
									
									<div class="form-group">
										<label >User name</label>
										<input type="text" name="name" class="form-control" style="width:200px;" value="<?=$user->name?>">
										
									</div>
									
									<div class="form-group">
										<label >Password</label>
										<input type="text" name="password" class="form-control" style="width:200px;">
										
									</div>
									
									<div class="form-group">
										<label >Status</label>
										<select name="status" class="form-control" style="width:200px;">
											<option value="active" <?=$user->status=="active"?"selected":""?> >active</option>
											<option value="inactive" <?=$user->status=="inactive"?"selected":""?> >inactive</option>
										</select>
										
									</div>
									
								</div>
								<div class="form-actions">
									<button type="submit" class="btn blue">บันทึก</button>
								</div>
							</form>
						</div>
						
</div>
</div>

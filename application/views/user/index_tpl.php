<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>ข่าวสาร
							</div>
						</div>
						<div class="portlet-body flip-scroll">
						<a  href="<?=site_url("user/insert") ?>" type="button" class="btn btn-success" >สร้างผู้ใช้งานใหม่</a>
							<table class="table table-bordered table-striped table-condensed flip-content">
							<thead class="flip-content">
							<tr>
								<th width="50" class="numeric">
									 No.
								</th>
								
								<th width="150">
									 วันที่ประกาศ
								</th>
								<th >
									 user name
								</th>
								<th >
									 status
								</th>
								<th  width="100" >
									ดู/แก้ไข
								</th>
								<th  width="100" >
									ลบ
								</th>
							</tr>
							</thead>
							<tbody>
							<?php $i=1;?>
							<?php foreach ($user->result() as $d) {?>
								<tr>
									<td>
										 <?=$i++?>.
									</td>
									<td>
										 <?=thaidate($d->create_date)?>
									</td>
									<td>
										 <?=$d->name?>
									</td>
									<td>
										 <?=$d->status?>
									</td>
									<td class="numeric">
										  <a href="<?=site_url("user/edit/$d->id")?>">ดู/แก้ไข</a>
									</td>
									<td class="numeric">
										  <a href="javascript:void(0);" onclick="removeUser('<?=$d->id?>');">ลบ</a>
									</td>
								</tr>
							<?php }?>
							
							</tbody>
							</table>
						<?=$page?>
						</div>
					</div>
					
					
					
					
					<script>
						function removeUser(id){


							if(confirm("Confrim delete user, when you choose ok this user will be lose")){
								window.location = "<?=base_url()?>user/delete/"+id;
							}
									
						}
							

					</script>
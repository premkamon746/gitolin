<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-mobile"></i>ข้อมูลรถโรงเรียน (อุปกรณ์ที่ติดกับรถ)
							</div>
						</div>
						<div class="portlet-body flip-scroll">
							<table class="table table-bordered table-striped table-condensed flip-content">
							<thead class="flip-content">
							<tr>
								<th width="20%">
									 ชื่ออุปกรณ์
								</th>
								<th>
									device id
								</th>
								<th>
									เบอร์ติดต่อ
								</th>
								<th class="numeric">
									 สถานะ
								</th>
								<th class="numeric">
									แก้ไข
								</th>
								
								<th class="numeric">
									ลบ
								</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($sc->result() as $s) {?>
							<tr  style="<?=$s->status=="active"?"":"color:#ccc !important;"?>"  >
								<td>
									 <a href="<?=base_url("student/lists/".$s->id)?>"><?=$s->name?></a>
								</td>
								<td>
									 <?=$s->device_id?>
								</td>
								<td>
									 <?=$s->contact_number?>
								</td>
								<td class="numeric">
									 
									 <input type="checkbox" class="make-switch" 
									 data-on-label="YES" 
									 data-off-label="NO"  
									 <?=$s->status=="active"?"checked":""?>
									 
									 />
								</td>
								
								<td>
									<a href="javascript:void(0);" onclick="edit(<?=$s->id?>)" />แก้ไข</a>
								</td>
								<td>
									<a href="javascript:void(0);" onclick="deleteData(<?=$s->id?>)" />ลบ</a>
								</td>
							</tr>
							<?php }?>
							</tbody>
							</table>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->
					
					
				</div>
			</div>
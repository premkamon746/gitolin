<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-flag"></i>ข้อมูลโรงเรียน
							</div>
						</div>
						<div class="portlet-body flip-scroll">
							<table class="table table-bordered table-striped table-condensed flip-content">
							<thead class="flip-content">
							<tr>
								<th width="20%">
									 ชื่อโรงเรียน
								</th>
								<th>
									 ที่อยู่
								</th>
								<th class="numeric">
									 lutitute
								</th>
								<th class="numeric">
									 longtitute
								</th>
								<th class="numeric">
									 สถานะ
								</th>
								
								<th >
									แก้ไข
								</th>
								
								<th >
									ลบ
								</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($sc->result() as $s) {?>
							<tr  style="<?=$s->status=="active"?"":"color:#ccc !important;"?>" >
								<td>
									 <a href="<?=base_url("device/lists/".$s->id)?>"><?=$s->name?></a>
								</td>
								<td>
									 <?=$s->address?>
								</td>
								<td class="numeric">
									 <?=$s->lat?>
								</td>
								<td class="numeric">
									 <?=$s->lng?>
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
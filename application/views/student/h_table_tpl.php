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
									 สถานะ
								</th>
								<th class="numeric">
									ข้อมูลนักเรียน
								</th>
							</tr>
							</thead>
							<tbody>
								<?php foreach ($sc->result() as $s) {?>
									<tr  style="<?=$s->status=="active"?"":"color:#ccc !important;"?>" >
										<td>
											 <a href="<?=base_url("student/lists/".$s->id)?>"><?=$s->name?></a>
										</td>
										<td>
											 <?=$s->address?>
										</td>
										<td class="numeric">
											 
											 <input type="checkbox" class="make-switch" 
											 data-on-label="YES" 
											 data-off-label="NO"  
											 <?=$s->status=="active"?"checked":""?>/>
										</td>
										
										<td>
											 	<a href="student/lists"></a><i class="fa fa-group"></i>
											 
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
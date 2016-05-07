<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-mobile"></i>ข้อมูลการส่ง sms
							</div>
						</div>
						<div class="portlet-body flip-scroll">
							<table class="table table-bordered table-striped table-condensed flip-content">
							<thead class="flip-content">
							<tr>
								<th width="20%">
									id
								</th>
								<th>
									ข้อความที่ส่ง
								</th>
								<th>
									วันที่สอง
								</th>
								<th>
									ประเภท
								</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($result->result() as $s) {?>
							<tr  >
								<td>
									 <?= $s->id ?>
								</td>
								
								<td>
									 <?= $s->msg ?>
								</td>
								<td>
									 <?= $s->create_date ?>
								</td>
								
								<td>
									 <?= $s->type ?>
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
			
			<?php echo $pagelink?>
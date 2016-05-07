<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>ข่าวสาร
							</div>
							<!-- <div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div> -->
						</div>
						<div class="portlet-body flip-scroll">
						<a  href="<?=site_url("news/insert") ?>" type="button" class="btn btn-success" >สร้างข่าวใหม่</a>
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
									 หัวข้อ
								</th>
								<th  width="100" >
									ดู/แก้ไข
								</th>
								<th  width="50"  >
									 ส่งออก
								</th>
							</tr>
							</thead>
							<tbody>
							<?php $i=1;?>
							<?php foreach ($news->result() as $d) {?>
								<tr>
									<td>
										 <?=$i++?>.
									</td>
									<td>
										 <?=thaidate($d->create_date)?>
									</td>
									<td>
										 <?=$d->title?>
									</td>
									<td class="numeric">
										  <a href="<?=site_url("news/edit/$d->id")?>">ดู/แก้ไข</a>
									</td>
									
									<td class="numeric">
										  <button  type="button" class="btn btn-success" >ส่งออก</button>
									</td>
								</tr>
							<?php }?>
							
							</tbody>
							</table>
						<?=$page?>
						</div>
					</div>
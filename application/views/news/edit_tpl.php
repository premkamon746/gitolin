


<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<a href="<?=site_url("news"); ?>" >ข่าว  </a>&gt; สร้างข้อความ
							</div>
							</div>
							
<div class="portlet-body form">
							<form role="form" method="post">
							<input type="hidden" name="news_id" value="<?=$news_id?>"  >
								<div class="form-body">
									<div class="form-group">
										<label >หัวข้อ</label>
										<input type="text" name="title" class="form-control" value="<?=$news->title?>">
										<span class="help-block">
											 title
										</span>
									</div>
									
									<div class="form-group">
										<label >เนื้อหา</label>
										<textarea class="form-control" id="textArea" rows="20" name="content"><?=$news->content?></textarea>
										<span class="help-block">
											 เนื้อหา
										</span>
									</div>
									
								</div>
								<div class="form-actions">
									<button type="submit" class="btn blue">บันทึก</button>
								</div>
							</form>
						</div>
						
</div>
</div>

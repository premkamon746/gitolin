<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-mobile"></i>
							</div>
						</div>
						<div class="portlet-body flip-scroll">
							<table  class="table table-bordered table-striped table-condensed flip-content">
								<thead>
									<tr>
										<td>ชื่อ</td>
										<td>นามสกุล</td>
										<td>ลบ</td>
									</tr>
								</thead>
							<tbody id="sortable">
							<?php foreach ($sc->result() as $s) {?>
								<tr class="ui-state-default" id="<?=$s->id?>">
									<td class='content_name'  style="cursor:pointer;" >
										 <a href='javascript:void(0);' data-pk="<?=$s->id?>" ><?=$s->firstname?> </a>
									</td>

									<td class='content_name'  style="cursor:pointer;" >
										 <a href='javascript:void(0);' data-pk="<?=$s->id?>" ><?=$s->lastname?> </a>
									</td>
									<td width="100" align="center" >
										 <i class="glyphicon glyphicon-remove-circle fa-lg" style="cursor: pointer;color:red;" onclick="deleteClassRoom(<?=$s->id ?>)" ></i>
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
<script>


	$(document).ready(function(){
			// $('.editcell').click(function(){
			// 	name = $.trim($(this).closest('tr').find('.content_name').text());
			// 	id = $.trim($(this).closest('tr').prop("id"));
			// 	$('#name').val(id);
			// })
			//$.fn.editable.defaults.mode = 'inline';

			var urls = "<?=base_url("school/gradelevel/update_name/")?>";

			$('.table tbody tr td a').editable({
         type:  'text',
         name:  'name',
         url:   urls,
         title: 'แก้ไขชื่อชั้นเรียน'
      });

			// $('.table tbody tr td a').on('shown', function(e, editable) {
			//     alert('Initialized with value: ' + editable.value);
			// });




			$( "#sortable" ).sortable({
				handle: ".portlet-header",
				stop: function( event, ui ) {
					//console.log($('#sortable').sortable('toArray'));
					var data_send = [];
					$.map($(this).find('tr'), function(el) {
                //console.log( el.id + ' = ' + $(el).index() );
								var em = [];
								em[0] = el.id;
								em[1] = $(el).index().toString();
								data_send.push(em);
          })

					var myJsonString = JSON.stringify(data_send);
					var url = "<?=base_url("school/gradelevel/sort/")?>";
					$.post(url,{"sort":myJsonString},function(data){

					})

				}//end stop
			});

			$( "#sortable" ).disableSelection();
	});

	function deleteClassRoom(id){
		if(confirm("ต้องการลบ ?")){
				window.location = "<?=base_url("school/classroom/delete/")?>/"+id;
			}
	}
</script>

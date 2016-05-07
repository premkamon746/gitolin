<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

<script>
	var geocoder;
	var map;
	var marker;
	function initialize() {
	  geocoder = new google.maps.Geocoder();
	  var latlng = new google.maps.LatLng(13.7745749, 100.5728574);
	  var mapOptions = {
	    zoom: 12,
	    center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
	  }
	  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	  marker = new google.maps.Marker({
          map: map,
          draggable:true,
          position: latlng
      });

	  google.maps.event.addListener(marker,'drag',function(event) {
    	  $("#lat").val(event.latLng.lat());
		  $("#lng").val(event.latLng.lng());
      })

	}

	$('#myModal').on('shown.bs.modal', function () {
    initialize();
	});

	function codeAddress() {
	  var address = document.getElementById('address').value;
	  console.log(address);
	  geocoder.geocode( { 'address': address}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	      map.setCenter(results[0].geometry.location);
	      var lat = results[0].geometry.location.lat();
	      var lng = results[0].geometry.location.lng();
		  $("#lat").val(lat);
		  $("#lng").val(lng);
		  marker.setPosition(results[0].geometry.location);




	    } else {
	      //alert('Geocode was not successful for the following reason: ' + status);
	    }
	  });
	}

	//google.maps.event.addDomListener(window, 'load', initialize);


	$(document).ready(function(){

// 		$('#address').focusout(function(){
// 			codeAddress();
// 		});
	});
</script>


								<div class="portlet box blue">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-save"></i>บันทึกข้อมูลนักเรียน
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="" class="form-horizontal form-row-seperated" method="post">
										<input type="hidden" name="school_id" value="<?=$school_id?>" />
										<!-- <input type="hidden" id="student_id" name="student_id"  /> -->
											<div class="form-body">
												<div class="form-group">
													<label class="control-label col-md-3">ชื่อนักเรียน</label>
													<div class="col-md-9">
														<input type="text" id="firstname" name="firstname" placeholder="ชื่อนักเรียน" class="form-control"
														value="<?=isset($firstname)?$firstname:'' ?>" />

													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">นามสกุล</label>
													<div class="col-md-9">
														<input type="text" id="lastname" name="lastname" placeholder="นามสกุล" class="form-control"
														value="<?=isset($lastname)?$lastname:'' ?>"  />

													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">เบอร์เมือถือ</label>
													<div class="col-md-9">
														<input type="text" id="contact_number" name="contact_number" placeholder="เบอร์เมือถือ" class="form-control"
														value="<?=isset($contact_number)?$contact_number:'' ?>"  />

													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3">ที่อยู่</label>
													<div class="col-md-9">
														<input type="text" id="address" name="address" placeholder="ที่อยู่" class="form-control"
														value="<?=isset($address)?$address:'' ?>"  />
														<button class="btn blue" onclick="codeAddress();return false;"><i class="fa fa-map-marker"></i> ค้นหาตำแหน่ง</button>

													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3">mac address</label>
													<div class="col-md-9">
														<input type="text" id="macaddr" name="macaddr" placeholder="mac address" class="form-control"
														value="<?=isset($macaddr)?$macaddr:'' ?>"  />

													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3">latitute</label>
													<div class="col-md-9">
														<input type="text" id="lat" name="lat" placeholder="latitute" class="form-control"
														value="<?=isset($lat)?$lat:'' ?>" />

													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3">longtitute</label>
													<div class="col-md-9">
														<input type="text" id="lng" name="lng" placeholder="longtitute" class="form-control"

														value="<?=isset($lng)?$lng:'' ?>" />

													</div>
												</div>
											</div>
											<div class="form-actions fluid">
												<div class="row">
													<div class="col-md-12">
														<div class="col-md-offset-3 col-md-9">
															<div id="map-canvas" style="width:600px;height:200px;"></div>
														</div>
													</div>
												</div>
											</div>

											<div class="form-actions fluid">
												<div class="row">
													<div class="col-md-12">
														<div class="col-md-offset-3 col-md-9">
															<button type="submit" class="btn green"><i class="fa fa-pencil"></i> บันทึก</button>

														</div>
													</div>
												</div>
											</div>




										</form>
										<!-- END FORM-->
									</div>
								</div>

		<script>
				function edit(id){
					$('#basic').modal('show');
					var time_refresh = new Date().getTime();
					$.getJSON("<?=site_url("student/ajax_get_std_data");?>/"+id+"?n="+time_refresh,function(data){
							$("#firstname").val(data.firstname);
							$("#lastname").val(data.lastname);
							$("#address").val(data.address);
							$("#contact_number").val(data.contact_number);
							$("#lat").val(data.lat);
							$("#lng").val(data.lng);
							$("#macaddr").val(data.macaddr);
							$("#room").val(data.room);
							$("#class").val(data.class);
							$("#student_id").val(data.id);
							scrollToAnchor($(".btn"));

							$('#basic').modal('hide');
							var mm = new google.maps.LatLng(parseFloat(data.lat), parseFloat(data.lng));
							map.setCenter(mm);
							marker.setMap(null)
							marker = new google.maps.Marker({
						          map: map,
						          draggable:true,
						          position: mm
						      });
							google.maps.event.addListener(marker,'drag',function(event) {
						    	  $("#lat").val(event.latLng.lat());
								  $("#lng").val(event.latLng.lng());
						      })
					});
				}

				function deleteData(id){
					$("#delete_id").val(id);
					$("#deleteData").modal("show");
				}
			</script>

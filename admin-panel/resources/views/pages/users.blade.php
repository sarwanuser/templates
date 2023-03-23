@include('common.header', ['page_class' => 'page-admin-guests', 'pagetitle' => 'Vidyarthis | Vihangam Yog Seva', 'pagename' => 'Vidyarthis List'])
<div class="content mt100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">
							@if(($data->sessionlogindata->user_role !== 'administrator') || ($data->sessionlogindata->user_role !== 'admin'))
								Profile
							@else
								All Vidyarthis
							@endif
						</h4>
                        <p class="card-category">
							@if($data->sessionlogindata->user_role !== 'administrator')
								Here is the profile details
							@else
								Here is the list of all vidyarthis
							@endif
						</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
										@if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin'))
											<!--th id="checkAll">
												<div class="form-check">
													<label class="form-check-label">
														<input class="form-check-input" type="checkbox" value="1" autocomplete="off" />
														<span class="form-check-sign">
															<span class="check"></span>
														</span>
													</label>
												</div>
											</th-->
										@endif 
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Signed</th>
                                        <th>Hawans</th>
										@if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin'))
											<th>Edit</th>
										@endif
                                    </tr> 
                                </thead>
                                <tbody>
									<?php $user = $data->users; ?>
									@if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin'))
										@if($data->users->total() > 0)
											@foreach($data->users as $user)
												<tr>
													 <!--td class="text-nowrap">
														<div class="form-check">
															<label class="form-check-label">
																<input class="form-check-input" type="checkbox" value="1" autocomplete="off" data-userid="{{ $user->ID }}"/>
																<span class="form-check-sign">
																	<span class="check"></span>
																</span>
															</label>
														</div>
													</td-->
													<td class="text-nowrap">{{ get_user_meta($user->ID, "first_name", true) }} {{ get_user_meta($user->ID, "last_name", true) }}</td>
													<td class="text-nowrap">{{ $user->user_email }}</td>
													<td class="text-nowrap">
														@php
														$phone_numbers = get_user_meta($user->ID, "phone_number", true);
														if($phone_numbers != ""){
															$phnumber = $phone_numbers;
														}else{
															$phnumber = "### ### ####";
														}
														@endphp
														{{ $phnumber }}
													</td>
													<td class="text-nowrap">{{ date('d-m-Y', strtotime($user->user_registered)) }}</td>
													<td class="text-nowrap">{{ get_havancount($user->ID) }}</td>
													<td><span class="viewdetails text-success"><a href="{{ url('admin/vidyarthis/edit') }}/{{ $user->ID }}"><i class="material-icons">edit</i></a></span></td>
												</tr>
											@endforeach
										@else
											<tr>
												<td colspan="5">No Users!</td>
											</tr>
										@endif
									@else
										<tr>
											<td class="text-nowrap">{{ get_user_meta($user->ID, "first_name", true) }} {{ get_user_meta($user->ID, "last_name", true) }}</td>
											<td class="text-nowrap">{{ $user->user_email }}</td>
											<td class="text-nowrap">
												@php
												$phone_numbers = get_user_meta($user->ID, "phone_number", true);
												if($phone_numbers != ""){
													$phnumber = $phone_numbers;
												}else{
													$phnumber = "### ### ####";
												}
												@endphp
												{{ $phnumber }}
											</td>
											<td class="text-nowrap">{{ date('d-m-Y', strtotime($user->user_registered)) }}</td>
											<td class="text-nowrap">{{ get_havancount($user->ID) }}</td>
										</tr>
									@endif
                                </tbody>
                            </table>
                        </div>
						@if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin'))
							@if($data->users->total() > 15)
								<div class="pagination_wrap">
									{!! $data->users->links() !!}
								</div>
							@endif
							@if($data->users->total() > 0)
								<div class="btn btn-primary exportuserbtn">Export</div>
							@endif
							<!--div class="btn btn-danger deleteuserbtn d-none">Delete User</div-->
						@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @section('usersscript')
    <script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("html, body").animate({
            scrollTop: 0
        }, 0);
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
		jQuery("#checkAll input:checkbox").click(function(){
			jQuery('.form-check-label input:checkbox').not(this).prop('checked', this.checked);
			jQuery(".deleteuserbtn").removeClass("d-none");
		});
		jQuery('.form-check-input').on('click',function(){
			if(jQuery("tbody tr").length == jQuery("tbody tr .form-check-input:checked").length){
				jQuery('#checkAll input:checkbox').prop('checked',true);
				jQuery(".error").remove();
			}else{
				jQuery('#checkAll input:checkbox').prop('checked',false);
				jQuery(".error").remove();
			}
			var checkedln = jQuery("tbody tr .form-check-input:checked").length;
			if(checkedln > 0){
				jQuery(".deleteuserbtn").removeClass("d-none");
			}else{
				jQuery(".deleteuserbtn").addClass("d-none");
			}
		});
		jQuery("body").on("click", ".exportuserbtn", function(){
			jQuery(".error").remove();
			var alluserid = 0;
			var checkedln = jQuery("tbody tr .form-check-input:checked").length;
			if(jQuery("tbody tr .form-check-input:checked").length > 0){
				var userexptype = 1;
				var alluserid = new Array();
				for(var i=0; i < checkedln; i++){
					var userid = jQuery("tbody tr .form-check-input:checked").eq(i).attr("data-userid");
					alluserid.push(userid);
				}
			}else{
				var userexptype = 2;
			}
			jQuery(this).html("<i class='fa fa-refresh fa-spin'></i> Processing...");
			jQuery.post("{{ url('ajax') }}", {exportusers: 1, userexptype:userexptype, alluserid:alluserid}, function(response){
				var response = JSON.parse(response);
				jQuery(".exportuserbtn").html("Export");
				if(response.status==1){
					window.location.href = response.excellink;
				}
			});
		});
		jQuery("body").on("click", ".deleteuserbtn", function(){
			jQuery(".error").remove();
			var alluserid = new Array();
			for(var i=0; i < jQuery("tbody tr .form-check-input:checked").length; i++){
				var userid = jQuery("tbody tr .form-check-input:checked").eq(i).attr("data-userid");
				alluserid.push(userid);
			}
			if(jQuery("tbody tr .form-check-input:checked").length == 0){
				jQuery(".deleteuserbtn").before("<div class='error'>Please select the rows!</div>");
				return false;
			}else{
				console.log(alluserid);
				Swal.fire({
					title: 'Are you sure?',
					text: "All selected hawans will be removed, you won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#4caf50',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Delete',
					focusConfirm: false
				}).then((result) => {
					if (result.value) {
						var deleteuserdata = new FormData();
						deleteuserdata.append("deleteusers", 1);
						deleteuserdata.append("userids", JSON.stringify(alluserid));
						jQuery(this).html("<i class='fa fa-spin fa-refresh' aria-hidden='true'></i> Processing...");
						jQuery.ajax({
							url: "{{ url('ajax') }}",
							type: 'POST',
							data: deleteuserdata,
							cache: false,
							contentType: false,
							processData: false,
							success: function(response) {
								var response = JSON.parse(response);
								jQuery(".deleteuserbtn").html("Delete user");
								if (response.status == 1) {
									Swal.fire(
										'Successful',
										'Vidyarthi has been removed.',
										'success'
									).then((result) => {
										window.location.href="{{ url()->current() }}";
									});
								}else{
									Swal.fire({
										icon: 'error',
										title: 'Oops...',
										text: 'Something went wrong!'
									}).then((result) => {
										jQuery(".deleteuserbtn").html("Delete user");
									});
								}
							},
							error: function() {
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: 'Something went wrong!'
								}).then((result) => {
									jQuery(".deleteuserbtn").html("Delete user");
								});
							}
						});
					}
				});
			}
		});
    });
    </script>
    @stop
    @include('common.footer')
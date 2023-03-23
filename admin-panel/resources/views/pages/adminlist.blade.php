@include('common.header', ['page_class' => 'page-admin-lists', 'pagetitle' => 'Admins | Vihangam Yog Seva', 'pagename' => 'Admins'])
<div class="content mt100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title"> @if(($data->sessionlogindata->user_role == "administrator") || ($data->sessionlogindata->user_role == "admin")) All Admins @else Profile @endif</h4>
                        <p class="card-category">Here is the @if(($data->sessionlogindata->user_role == "administrator") || ($data->sessionlogindata->user_role == "admin")) list of all admins @else Profile details @endif</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
										@if(($data->sessionlogindata->user_role == "administrator") || ($data->sessionlogindata->user_role == "admin"))
											<th id="checkAll">
												<div class="form-check">
													<label class="form-check-label">
														<input class="form-check-input" type="checkbox" value="1" autocomplete="off" />
														<span class="form-check-sign">
															<span class="check"></span>
														</span>
													</label>
												</div>
											</th>
										@endif
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Email</th>
                                        <th class="text-nowrap">Role</th>
                                        <th class="text-nowrap">Contact</th>
                                        <th class="text-nowrap">Added</th>
                                        <th class="text-nowrap">Edit</th>
                                        <!--th>Edit</th-->
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($data->users->total() > 0)
										@foreach($data->users as $user)
										<tr>
											@if(($data->sessionlogindata->user_role == "administrator") || ($data->sessionlogindata->user_role == "admin"))
												<td class="text-nowrap">
													<div class="form-check">
														<label class="form-check-label">
															<input class="form-check-input" type="checkbox" value="1" autocomplete="off" data-uid="{{ $user->ID }}"/>
															<span class="form-check-sign">
																<span class="check"></span>
															</span>
														</label>
													</div>
												</td>
											@endif
											<td class="text-nowrap">{{ get_user_meta($user->ID, "first_name", true) }} {{ get_user_meta($user->ID, "last_name", true) }}</td>
											<td class="text-nowrap">{{ $user->user_email }}</td>
											<td class="text-nowrap">{{ $user->user_role }}</td>
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
											<td><span class="viewdetails text-success"><a href="{{ url('admin/profile/edit') }}/{{ $user->ID }}"><i class="material-icons">edit</i></a></span></td>
										</tr>
										@endforeach
                                    @else
										<tr>
											<td colspan="6">No Admins!</td>
										</tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if($data->users->total() > 15)
                        <div class="pagination_wrap">
                            {!! $data->users->links() !!}
                        </div>
                        @endif
						@if(($data->sessionlogindata->user_role == "administrator") || ($data->sessionlogindata->user_role == "admin"))
							<div class="btn btn-danger deleteuserbtn d-none">Delete admin</div>
						@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @section('adminssscript')
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
		@if(($data->sessionlogindata->user_role == "administrator") || ($data->sessionlogindata->user_role == "admin"))
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
			jQuery("body").on("click", ".deleteuserbtn", function(){
				jQuery(".error").remove();
				var alluserid = new Array();
				for(var i=0; i < jQuery("tbody tr .form-check-input:checked").length; i++){
					var userid = jQuery("tbody tr .form-check-input:checked").eq(i).attr("data-uid");
					alluserid.push(userid);
				}
				if(jQuery("tbody tr .form-check-input:checked").length == 0){
					jQuery(".deleteuserbtn").before("<div class='error'>Please select the rows!</div>");
					return false;
				}else{
					console.log(alluserid);
					Swal.fire({
						title: 'Are you sure?',
						text: "All selected admin will be removed, you won't be able to revert this!",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#4caf50',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Delete',
						focusConfirm: false
					}).then((result) => {
						if (result.value) {
							var deleteuserdata = new FormData();
							deleteuserdata.append("deleteadmins", 1);
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
									jQuery(".deleteuserbtn").html("Delete admin");
									if (response.status == 1) {
										Swal.fire(
											'Successful',
											'Admin has been removed.',
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
											jQuery(".deleteuserbtn").html("Delete admin");
										});
									}
								},
								error: function() {
									Swal.fire({
										icon: 'error',
										title: 'Oops...',
										text: 'Something went wrong!'
									}).then((result) => {
										jQuery(".deleteuserbtn").html("Delete admin");
									});
								}
							});
						}
					});
				}
			});
		@endif
    });
    </script>
    @stop
    @include('common.footer')
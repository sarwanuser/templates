@include('common.header', ['page_class' => 'page-edit-admin-profile-dashboard', 'pagetitle' => 'Edit Admin Profile | Vihangam Yog Seva', 'pagename' => 'Edit Admin Profile'])
<div class="content">
    <div class="container-fluid">
		<?php $loginuserdata = json_decode(Session::get('auserdata'));?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Edit Admin Profile</h4>
                        <p class="card-category">Edit admin profile</p>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="adduser_form_inn">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="username">Name</label>
                                            <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="" value="{{ $data->userdata->user_name }}" autocomplete="off" />
                                        </div>
                                    </div>
									<div class="col-md-6">
                                        <div class="form-group">
											<label for="useremail">Email address</label>
                                            <input type="email" class="form-control" id="useremail" aria-describedby="emailHelp" placeholder=""  value="{{ $data->userdata->user_email }}" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group select_wrap">
											<label for="gender_select">Gender</label>
                                            <select class="form-control gender_select selectpicker" data-style="btn btn-link" id="gender_select" autocomplete="off">
                                                <option value="male" @if( $data->userdata->user_gender == 'Male' ) selected="selected" @endif>Male</option>
                                                <option value="female" @if( $data->userdata->user_gender == 'Female' ) selected="selected" @endif>Female</option>
                                                <option value="other" @if( $data->userdata->user_gender == 'Other' ) selected="selected" @endif>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="usermob">Mobile number</label>
                                            <input type="text" class="form-control" id="usermob" aria-describedby="usermobHelp" placeholder=""  value="{{ $data->userdata->phone_number }}" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="userpwd">Password</label>
                                            <input type="password" class="form-control" id="userpwd" placeholder="" autocomplete="off" />																						<div class="togglepass"><i class="fa fa-eye-slash"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="userpwd1">Confrim password</label>
                                            <input type="password" class="form-control" id="userpwd1" placeholder="" autocomplete="off" />																						<div class="togglepass"><i class="fa fa-eye-slash"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group select_wrap">
											<label for="country_select">Country</label>
                                            <select class="form-control country_select selectpicker" data-style="btn btn-link" id="country_select" autocomplete="off">
                                                @foreach($data->countries as $country)
													<option value="{{ $country->sortname }}" data-cid="{{ $country->ID }}" @if($country->sortname == $data->userdata->sortname) selected="selected"
                                                    @endif>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group select_wrap">
											<label for="state_select">State</label>
                                            <select class="form-control state_select selectpicker" data-style="btn btn-link" id="state_select" autocomplete="off">
                                                @foreach($data->country_by_states as $state)
                                                <option value="{{ $state->name }}" @if($state->name == $data->userdata->user_state)
                                                    selected="selected" @endif>{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group select_wrap">
											<label for="userrole">User role</label>
											<select class="form-control userrole selectpicker" data-style="btn btn-link" id="userrole">
												@if(($loginuserdata->user_role == "administrator") || ($loginuserdata->user_role == "admin"))
													<option value="1"  @if($data->userdata->user_role == 1 ) selected="selected" @endif>Admin</option>
													<option value="2" @if( $data->userdata->user_role == 2 ) selected="selected" @endif>KK Admin</option>
												@else
													<option value="2"@if( $data->userdata->user_role == 2 ) selected="selected" @endif>KK Admin</option>
												@endif
											</select>
										</div>
                                    </div>
									<div class="col-md-6">
                                        <div class="form-group ourhub select_wrap @if( $data->userdata->user_role == 1 ) d-none @endif">
											<label for="hub">Hub</label> 
											<select class="form-control hub selectpicker" data-style="btn btn-link" id="hub">
												@if(($loginuserdata->user_role == "administrator") || ($loginuserdata->user_role == "admin"))
													@foreach($data->our_hub as $hub)
														<option value="{{ $hub->ID }}" @if($hub->ID == $data->userdata->hubid) selected="selected" @endif>{{ $hub->name }}</option>
													@endforeach
												@else
													<option value="{{ $data->userdata->hubid }}" selected="selected">{{ $data->userdata->hubname }}</option>
												@endif
											</select>
										</div>
                                    </div>
								</div>
                                <div class="btn btn-primary updateadminprofilebtn">Update</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
@section('updateadminscript')
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			}
		});
		jQuery("#country_select").change(function() {
			var country_id = jQuery("#country_select option:selected").attr("data-cid");
			jQuery.post("{{ url('ajax') }}", {
				getstates: 1,
				country_id: country_id
			}, function(response) {
				var response = JSON.parse(response);
				if (response.status == 1) {
					jQuery("#state_select").html(response.optionhtml);
					jQuery(".state_select.selectpicker").selectpicker('refresh');
				}
			});
		});
		jQuery("#userrole").change(function() {
			var userrole = jQuery("#userrole option:selected").val();
			if(userrole == 1){
				jQuery(".ourhub").addClass("d-none");
			}else{
				jQuery(".ourhub").removeClass("d-none");
			}
		});				jQuery(".togglepass").click(function(){			if(jQuery(this).find(".fa").hasClass("fa-eye-slash")){				jQuery(this).find(".fa").removeClass("fa-eye-slash").addClass("fa-eye");				jQuery(this).parent().parent().find("input").attr('type', 'text');			}else{				jQuery(this).find(".fa").removeClass("fa-eye").addClass("fa-eye-slash");				jQuery(this).parent().parent().find("input").attr('type', 'password');						}		});		
		jQuery('.form-file-multiple .inputFileVisible, .form-file-multiple .input-group-btn').click(function() {
			jQuery(this).parent().parent().find('.inputFileHidden').trigger('click');
			jQuery(this).parent().parent().addClass('is-focused');
		});
		jQuery('.form-file-multiple .inputFileHidden').change(function() {
			var names = '';
			for (var i = 0; i < jQuery(this).get(0).files.length; ++i) {
				if (i < jQuery(this).get(0).files.length - 1) {
					names += jQuery(this).get(0).files.item(i).name + ',';
				} else {
					names += jQuery(this).get(0).files.item(i).name;
				}
			}
			jQuery(this).siblings('.input-group').find('.inputFileVisible').val(names);
		});
		jQuery(".updateadminprofilebtn").click(function() {
			var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
			jQuery(".error").remove();
			var username = jQuery("#username").val();
			var useremail = jQuery("#useremail").val();
			var gender_select = jQuery("#gender_select option:selected").val();
			var usermob = jQuery("#usermob").val();
			var userpwd = jQuery("#userpwd").val();
			var userpwd1 = jQuery("#userpwd1").val();
			var country_select = jQuery("#country_select option:selected").val();
			var state_select = jQuery("#state_select option:selected").val();
			var userrole = jQuery("#userrole option:selected").val();
			var hub = jQuery("#hub option:selected").val();
			if (username == "") {
				jQuery("#username").after("<div class='error'>User name is required!</div>");
				jQuery("#username").focus();
				return false;
			}
			if (useremail == "") {
				jQuery("#useremail").after("<div class='error'>Email is required!</div>");
				jQuery("#useremail").focus();
				return false;
			}
			if (!filter.test(useremail)) {
				jQuery("#useremail").after("<div class='error'>Email address is not valid!</div>");
				jQuery("#useremail").focus();
				return false;
			}
			if (gender_select == "") {
				jQuery("#gender_select").after("<div class='error'>Please select gender!</div>");
				jQuery("#permanentaddress").focus();
				return false;
			}
			if (usermob == "") {
				jQuery("#usermob").after("<div class='error'>Mobile number is required!</div>");
				jQuery("#usermob").focus();
				return false;
			}
			if (!jQuery.isNumeric(usermob)) {
				jQuery("#usermob").after("<div class='error nomobie'>Mobile number can't contain alphbets & special characters!</div>");
				jQuery("#usermob").focus();
				return false;
			}
			if (userpwd !== "") {
				if (userpwd1 == "") {
					jQuery("#userpwd1").after("<div class='error'>Confrim password is required!</div>");
					jQuery("#userpwd1").focus();
					return false;
				}
				if(userpwd != userpwd1) {
					jQuery("#userpwd1").after("<div class='error'>Paswords not matched.</div>");
					jQuery("#userpwd1").focus();
					return false;
				}
			}
			if(userrole == 1){
				hub = "";
			}else{
				hub = hub;
			}
			var updateadminprofiledata = new FormData();
			updateadminprofiledata.append('updateadminprofile', 1);
			updateadminprofiledata.append('uuid', {{ $data->userdata->ID }});
			updateadminprofiledata.append('username', username);
			updateadminprofiledata.append('useremail', useremail);
			updateadminprofiledata.append('usermob', usermob);
			updateadminprofiledata.append('userpwd1', userpwd1);
			updateadminprofiledata.append('country_select', country_select);
			updateadminprofiledata.append('state_select', state_select);
			updateadminprofiledata.append('gender_select', gender_select);
			updateadminprofiledata.append('userrole', userrole);
			updateadminprofiledata.append('hub', hub);
			console.log(updateadminprofiledata);
			Swal.fire({
				title: 'Are you sure?',
				text: "Update admin data, you won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#4caf50',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Update',
				focusConfirm: false
			}).then((result) => {
				if (result.value) {
					jQuery(this).html("<i class='fa fa-spin fa-refresh' aria-hidden='true'></i> Processing...");
					jQuery.ajax({
						url: "{{ url('ajax') }}",
						type: 'POST',
						data: updateadminprofiledata,
						cache: false,
						contentType: false,
						processData: false,
						success: function(response) {
							var response = JSON.parse(response);
							jQuery(".updateadminprofilebtn").html("Update");
							if (response.status == 1) {
								Swal.fire(
									'Successful',
									'New member has been added.',
									'success'
								).then((result) => {
									window.location.href="{{ url()->current() }}";
								});
							}else{
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: 'An member already exists with this email id!'
								}).then((result) => {
									jQuery(".updateadminprofilebtn").html("Update");
									jQuery("#useremail").after("<div class='error'>An admin already exists with this email id.</div>");
								});
							}
						},
						error: function() {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: 'Something went wrong!'
							}).then((result) => {
								jQuery(".updateadminprofilebtn").html("Update");
							});
						}
					});
				}
			});
		});
	});
</script>
@stop
@include('common.footer')
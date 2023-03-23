@include('common.header', ['page_class' => 'page-admin-dashboard-add-admin', 'pagetitle' => 'Add Admin | Vihangam Yog Seva', 'pagename' => 'Add Admin'])
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Add Admin</h4>
                        <p class="card-category">Create new admin profile</p>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="adduser_form_inn">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="username">Name</label>
                                            <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
									<div class="col-md-6">
                                        <div class="form-group">
											<label for="useremail">Email address</label>
                                            <input type="email" class="form-control" id="useremail" aria-describedby="emailHelp" placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group select_wrap">
											<label for="gender_select">Gender</label>
                                            <select class="form-control gender_select selectpicker" data-style="btn btn-link" id="gender_select" autocomplete="off">
                                                <option value="male" selected="selected">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="usermob">Mobile number</label>
                                            <input type="text" class="form-control" id="usermob" aria-describedby="usermobHelp" placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="userpwd">Password</label>
                                            <input type="password" class="form-control" id="userpwd" placeholder="" autocomplete="off" />											<div class="togglepass"><i class="fa fa-eye-slash"></i></div>
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
                                                <option value="{{ $country->sortname }}" data-cid="{{ $country->ID }}" @if($country->sortname == 'IN') selected="selected"
                                                    @endif>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group select_wrap">
											<label for="state_select">State</label>
                                            <select class="form-control state_select selectpicker" data-style="btn btn-link" id="state_select" autocomplete="off">
                                                @foreach($data->states as $state)
                                                <option value="{{ $state->name }}" @if($state->ID == '16')
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
												<option value="1">Admin</option>
												<option value="2">KK Admin</option>
											</select>
										</div>
                                    </div>
									<div class="col-md-6">
                                        <div class="form-group ourhub select_wrap d-none">
											<label for="hub">Hub</label>
											<select class="form-control hub selectpicker" data-style="btn btn-link" id="hub">
												@foreach($data->our_hub as $hub)
													<option value="{{ $hub->ID }}" @if($hub->ID == '16')
                                                    selected="selected" @endif>{{ $hub->name }}</option>
                                                @endforeach
											</select>
										</div>
                                    </div>
								</div>
                                <div class="btn btn-primary createaccount">Register Now</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
@section('addadminscript')
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
    });
    jQuery('.form-file-multiple .inputFileVisible, .form-file-multiple .input-group-btn').click(function() {
        jQuery(this).parent().parent().find('.inputFileHidden').trigger('click');
        jQuery(this).parent().parent().addClass('is-focused');
    });			jQuery(".togglepass").click(function(){		if(jQuery(this).find(".fa").hasClass("fa-eye-slash")){			jQuery(this).find(".fa").removeClass("fa-eye-slash").addClass("fa-eye");			jQuery(this).parent().parent().find("input").attr('type', 'text');		}else{			jQuery(this).find(".fa").removeClass("fa-eye").addClass("fa-eye-slash");			jQuery(this).parent().parent().find("input").attr('type', 'password');					}	});
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
    jQuery(".createaccount").click(function() {
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
        if (userpwd == "") {
            jQuery("#userpwd").after("<div class='error'>Password is required!</div>");
            jQuery("#userpwd").focus();
            return false;
        }
        if (userpwd1 == "") {
            jQuery("#userpwd1").after("<div class='error'>Confrim password is required!</div>");
            jQuery("#userpwd1").focus();
            return false;
        }
        if (userpwd != userpwd1) {
            jQuery("#userpwd1").after("<div class='error'>Paswords not matched.</div>");
            jQuery("#userpwd1").focus();
            return false;
        }
		if(userrole == 1){
			hub = "";
		}else{
			hub = hub;
		}
        var createaccountdata = new FormData();
        createaccountdata.append('addnewadmin', 1);
        createaccountdata.append('username', username);
        createaccountdata.append('useremail', useremail);
        createaccountdata.append('usermob', usermob);
        createaccountdata.append('userpwd1', userpwd1);
        createaccountdata.append('country_select', country_select);
        createaccountdata.append('state_select', state_select);
        createaccountdata.append('gender_select', gender_select);
        createaccountdata.append('userrole', userrole);
        createaccountdata.append('hub', hub);
		Swal.fire({
			title: 'Are you sure?',
			text: "Add new member, you won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#4caf50',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Add',
			focusConfirm: false
		}).then((result) => {
			if (result.value) {
				jQuery(this).html("<i class='fa fa-spin fa-refresh' aria-hidden='true'></i> Processing...");
				jQuery.ajax({
					url: "{{ url('ajax') }}",
					type: 'POST',
					data: createaccountdata,
					cache: false,
					contentType: false,
					processData: false,
					success: function(response) {
						var response = JSON.parse(response);
						jQuery(".createaccount").html("Register Now");
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
								jQuery(".createaccount").html("Register Now");
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
							jQuery(".createaccount").html("Register Now");
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
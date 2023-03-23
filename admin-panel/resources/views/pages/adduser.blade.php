@include('common.header', ['page_class' => 'page-admin-dashboard-add-user', 'pagetitle' => 'Add Vidyarthi | Vihangam Yog Seva', 'pagename' => 'Add Vidyarthi'])
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Add vidyarthi</h4>
                        <p class="card-category">Create new vidyarthi profile</p>
                    </div>
					<div class="card-profile upid">
                        <div class="card-avatar img_upload">
                            <a href="javascript:;">
                                <img class="profileimg img" src="{{ url('img/profile_dp.png') }}" alt="Profile Image" title="" />
								<input type="file" id="user_dp" class="inputFileHidden imgInp" autocomplete="off" />
                            </a>
						</div>
					</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="adduser_form_inn">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="regid">Registration number</label>
                                            <input type="text" class="form-control" id="regid" aria-describedby="regidHelp" placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="username">Vidyarthi Name</label>
                                            <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="useremail">Vidyarthi email</label>
                                            <input type="email" class="form-control" id="useremail" aria-describedby="emailHelp" placeholder="" autocomplete="off" />
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
                                            <input type="password" class="form-control" id="userpwd" placeholder="" autocomplete="off" />
											<div class="togglepass"><i class="fa fa-eye-slash"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
											<label for="userpwd1">Confrim Password</label>
                                            <input type="password" class="form-control" id="userpwd1" placeholder="" autocomplete="off" />
											<div class="togglepass"><i class="fa fa-eye-slash"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
									<div class="col-md-4">
                                        <div class="form-group">
											<label for="postcode">Post code</label>
                                            <input type="text" class="form-control" id="postcode" aria-describedby="postcodeHelp" placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
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
											<label for="hub">Hub</label>
											<select class="form-control hub selectpicker" data-style="btn btn-link" id="hub">
												@foreach($data->our_hub as $hub)
													<option value="{{ $hub->ID }}" @if($hub->ID == '16')
													selected="selected" @endif>{{ $hub->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
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
								</div>
                                <div class="form-group">
									<label for="permanentaddress">Permanent Address</label>
                                    <textarea class="form-control" id="permanentaddress" rows="3" placeholder="" autocomplete="off"></textarea>
                                </div>
								<div class="form-group">
									<label for="comments">Comments</label>
                                    <textarea class="form-control" id="comments" rows="4" placeholder="" autocomplete="off"></textarea>
                                </div>
                                <div class="btn btn-primary createaccount">register Now</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
@section('adduserscript')
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
	jQuery(".profileimg").click(function(){
		jQuery(this).parent().find('input[type="file"]').trigger('click');
	});
	/*----image upload-----*/
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			var file = input.files[0];
			var img = new Image();
			var sizeKB = file.size / 1024;
			img.src = window.URL.createObjectURL( file );
			reader.onload = function (e) {
				if(sizeKB <= 4194304){
					jQuery(input).parent().find('.profileimg').attr('src', e.target.result);
				}else{
					alert('Please upload image size below the 4MB');
				}
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	jQuery(".imgInp").change(function(){
		var val = jQuery(this).val();
		switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
			case 'bmp': case 'jpg': case 'png':
				readURL(this);
				break;
			default:
				jQuery(this).val('');
				alert("Not an Image format, Accepted formats are .jpg, .bmp & .png.")
				break;
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
	
	jQuery(".togglepass").click(function(){
		if(jQuery(this).find(".fa").hasClass("fa-eye-slash")){
			jQuery(this).find(".fa").removeClass("fa-eye-slash").addClass("fa-eye");
			jQuery(this).parent().parent().find("input").attr('type', 'text');
		}else{
			jQuery(this).find(".fa").removeClass("fa-eye").addClass("fa-eye-slash");
			jQuery(this).parent().parent().find("input").attr('type', 'password');			
		}
	});

    jQuery('.inputFileHidden').change(function() {
        var names = '';
        for (var i = 0; i < jQuery(this).get(0).files.length; ++i) {
            if (i < jQuery(this).get(0).files.length - 1) {
                names += jQuery(this).get(0).files.item(i).name + ',';
            } else {
                names += jQuery(this).get(0).files.item(i).name;
            }
        }
        jQuery(this).siblings('.img_upload').find('.inputFileVisible').val(names);
    });

    jQuery(".createaccount").click(function(){
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        jQuery(".error").remove();
        var regid = jQuery("#regid").val();
        var username = jQuery("#username").val();
        useremail = jQuery("#useremail").val();
        var usermob = jQuery("#usermob").val();
        var userpwd = jQuery("#userpwd").val();
        var userpwd1 = jQuery("#userpwd1").val();
        var postcode = jQuery("#postcode").val();
        var country_select = jQuery("#country_select option:selected").val();
        var state_select = jQuery("#state_select option:selected").val();
		var hub = jQuery("#hub option:selected").val();
        var gender_select = jQuery("#gender_select option:selected").val();
        var user_dp = jQuery("#user_dp")[0].files[0];
		var permanentaddress = jQuery("#permanentaddress").val();
		var comments = jQuery("#comments").val();
        if (regid == "") {
            jQuery("#regid").after("<div class='error'>Registration number is required!</div>");
            jQuery("#regid").focus();
            return false;
        }
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
		if (postcode == "") {
            jQuery("#postcode").after("<div class='error'>Postcode is required!</div>");
            jQuery("#postcode").focus();
            return false;
        }
        if (permanentaddress == "") {
            jQuery("#permanentaddress").after("<div class='error'>Permanent address is required!</div>");
            jQuery("#permanentaddress").focus();
            return false;
        }

        if (typeof user_dp == "undefined") {
            user_dp = "";
            ext = "";
        } else {
            var ext = user_dp.name.split('.').pop().toLowerCase();
            var allowedimgs = ['jpg', 'jpeg', 'png', 'bmp'];
            var imgindex = jQuery.inArray(ext, allowedimgs, 0);
            if (imgindex == -1) {
                jQuery("#user_dp").after("<div class='error'>Please select jpg, jpeg, png, bmp file!</div>");
                jQuery("#user_dp").focus();
                return false;
            }
        }
        var createaccountdata = new FormData();
        createaccountdata.append('addnewuser', 1);
        createaccountdata.append('regid', regid);
        createaccountdata.append('username', username);
        createaccountdata.append('useremail', useremail);
        createaccountdata.append('usermob', usermob);
        createaccountdata.append('userpwd1', userpwd1);
        createaccountdata.append('postcode', postcode);
        createaccountdata.append('country_select', country_select);
        createaccountdata.append('state_select', state_select);
		createaccountdata.append('hub', hub);
        createaccountdata.append('gender_select', gender_select);
        createaccountdata.append('user_dp', user_dp);
        createaccountdata.append('user_dp_ext', ext);
		createaccountdata.append('permanentaddress', permanentaddress);
		createaccountdata.append('comments', comments);
		Swal.fire({
			title: 'Are you sure?',
			text: "Add new vidyarthi, you won't be able to revert this!",
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
								'New user has been added.',
								'success'
							).then((result) => {
								window.location.href="{{ url()->current() }}";
							});
						}else{
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: 'A user already exists with this email id!'
							}).then((result) => {
								jQuery(".createaccount").html("Register Now");
								jQuery("#useremail").after("<div class='error'>A user already exists with this email id.</div>");
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
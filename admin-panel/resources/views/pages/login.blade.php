@include('common.header', ['page_class' => 'page-admin-login', 'pagetitle' => 'Admin Login | Vihangam Yog Seva'])
<div class="content loginindex">
    <div class="loginwrap">
		<div class="loginwrapinner">
			<div class="loginweblogo"><a href="{{ url('/') }}"><img src="{{ url('img/logo.png') }}" alt="Logo" title="Vihangam Logo"/></a></div>
			<div class="loginform">
				<div class="form_input_wrap"> 
					<div class="form_input_left">
						<label for="memberemail" class="loginlabel_txt">Email</label>
						<input type="email" id="memberemail" class="memberemail" name="memberemail" placeholder="Email Address"/>
					</div>
					<div class="form_input_right">
						<label for="memberpassword" class="loginlabel_txt">Password</label>
						<input type="password" id="memberpassword" class="memberpassword" name="memberpassword" placeholder="Password"/>
						<div class="rhs">
							<a href="#" class="forgotpassword" data-toggle="modal" data-target="#ForgotPwdModal">Forgot password ?</a>
						</div>
					</div>
				</div>
				<div class="button_wrap">
					<div class="lhs">
						<div class="loginbtn">Login</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="ForgotPwdModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalLabel">Forgot password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="loginwrap">
					<div class="loginwrapinner">
						<div class="loginform">
							<div class="form_input_wrap">
								<input type="text" id="useremail" class="username" name="username" placeholder="Email Address"/>
								<input type="text" id="emailotp" class="emailotp d-none" name="username" placeholder="OTP"/>
								<input type="password" id="password" class="password d-none" name="password" placeholder="Password"/>
								<input type="password" id="confirm_pwd" class="confirm_pwd d-none" name="confirm_pwd" placeholder="Confirm Password"/>
							</div>
							<div class="button_wrap">
								<div class="lhs">
									<div class="pwdreset">Forgot password</div>
								</div>
								<div class="rhs">
									<a href="#" class="openloginform">Login</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@section('loginscript')
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("html, body").animate({scrollTop:0}, 0);
	jQuery.ajaxSetup({
		headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
	});
	jQuery("#ForgotPwdModal .button_wrap .rhs a").click(function(event){
		event.preventDefault();
		jQuery(".error, .success").remove();
		if(jQuery(this).hasClass('forgotpassword')){
			jQuery(this).parent().parent().parent().find(".button_wrap .lhs").html("<div class='pwdreset'>Forgot password</div>");
			jQuery(this).removeClass("forgotpassword").addClass("openloginform").html("Login").parent().parent().parent().find(".password").addClass("d-none");
		}else{
			jQuery(this).removeClass("openloginform").addClass("forgotpassword").html("Forgot Password?").parent().parent().parent().find(".password").removeClass("d-none");
			jQuery(this).parent().parent().parent().find(".button_wrap .lhs").html("<div class='adminlogin'>Login</div>");
		}
	});
	jQuery("body").on("click", ".pwdreset", function(){
		jQuery(".error, .success").remove();
		var email = jQuery("#ForgotPwdModal #useremail").val();
		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if(email==""){
			jQuery("#ForgotPwdModal #useremail").after("<div class='error blankemail'>Email field is blank.</div>");
			jQuery("#ForgotPwdModal #useremail").focus();
			return false;
		}
		if(!filter.test(email)){
			jQuery("#ForgotPwdModal #useremail").after("<div class='error'>Email Address is NOT Valid.</div>");
			jQuery("#ForgotPwdModal #useremail").focus();
			jQuery("#ForgotPwdModal .pwdreset").html("Forgot password");
			return false;
		}else{
			jQuery("#ForgotPwdModal .openloginform").addClass("d-none");
			jQuery(this).html("<i class='fa fa-refresh fa-spin'></i> Processing...");
			jQuery.post("{{ url('ajax') }}", {set_otp_pwd_reset:1, email:email}, function(response){
				var response = JSON.parse(response);
				if(response.status==1){
					jQuery("#ForgotPwdModal #emailotp").after(response.msg);
					jQuery("#ForgotPwdModal #useremail").val("");
					jQuery("#ForgotPwdModal .button_wrap .lhs").html("<div class='emailverification'>Verify</div>");
					jQuery("#ForgotPwdModal #ModalLabel").html("Email Verification");
					jQuery("#ForgotPwdModal #useremail, #ForgotPwdModal  #password").addClass("d-none");
					jQuery("#ForgotPwdModal #emailotp").removeClass("d-none");
					setTimeout(function(){
						jQuery(".error, .success").remove();
					}, 1000);
				}else if(response.status==2){
					jQuery("#ForgotPwdModal #useremail").after(response.msg);
					jQuery("#ForgotPwdModal .pwdreset").html("Forgot password");
					jQuery("#ForgotPwdModal #useremail").removeClass("d-none");
					jQuery("#ForgotPwdModal #password").addClass("d-none");
				}else{
					jQuery("#ForgotPwdModal #useremail").after(response.msg);
					jQuery("#ForgotPwdModal .pwdreset").html("Forgot password");
					jQuery("#ForgotPwdModal #useremail").removeClass("d-none");
					jQuery("#ForgotPwdModal #password").addClass("d-none");
				}
			});
		}
	});
	jQuery("body").on("click", ".emailverification", function(){
		jQuery(".error, .success").remove();
		var emailotp = jQuery("#ForgotPwdModal #emailotp").val();
		if(emailotp==""){
			jQuery("#ForgotPwdModal #emailotp").after("<div class='error pass_error'>OTP cant be empty!</div>");
			jQuery("#ForgotPwdModal #emailotp").focus();
			return false;
		}
		if(!jQuery.isNumeric(emailotp)){
			jQuery("#ForgotPwdModal #emailotp").append("<div class='error'>OTP cant be alphanumeric, use only Numeric!</div>");
			jQuery("#ForgotPwdModal #emailotp").focus();
			return false;
		}else{
			jQuery(this).html("<i class='fa fa-refresh fa-spin'></i> Processing...");
			jQuery.post("{{ url('ajax') }}", {email_verify:1, emailotp:emailotp}, function(response){
				var response = JSON.parse(response);
				if(response.status==1){
					jQuery(".button_wrap .lhs").html("<div class='setnewpwd'>Change Password</div>");
					jQuery("#ForgotPwdModal #ModalLabel").html("Set New Password");
					jQuery("#ForgotPwdModal #emailotp").addClass("d-none");
					jQuery("#ForgotPwdModal #password, #ForgotPwdModal .confirm_pwd").removeClass("d-none");;
					setTimeout(function(){
						jQuery(".error, .success").remove();
					}, 1000);
				}else{
					jQuery("#ForgotPwdModal #emailotp").after("<div class='error'>Wrong OTP!</div>");
					jQuery("#ForgotPwdModal .button_wrap .lhs").html("<div class='emailverification'>Verify</div>");
					jQuery("#ForgotPwdModal #useremail, #password").addClass("d-none");
					jQuery("#ForgotPwdModal #confirm_pwd").addClass("d-none");
				}
			});
		}
	});
	jQuery("body").on("click", ".setnewpwd", function(){
		jQuery(".error, .success").remove();
		var password = jQuery("#ForgotPwdModal #password").val();
		var confirm_pwd = jQuery("#ForgotPwdModal #confirm_pwd").val();
		if(password==""){
			jQuery(".password").after("<div class='error'>Password cant be blank.</div>");
			jQuery(".password").focus();
			return false;
		}
		if(confirm_pwd==""){
			jQuery("#ForgotPwdModal .confirm_pwd").after("<div class='error'>Confirm password cant be blank.</div>");
			jQuery("#ForgotPwdModal .confirm_pwd").focus();
			return false;
		}
		if(password != confirm_pwd){
			jQuery("#ForgotPwdModal .confirm_pwd").after("<div class='error'>Paswords not matched.</div>");
			jQuery("#ForgotPwdModal .confirm_pwd").focus();
			return false;
		}else{
			jQuery(this).html("<i class='fa fa-refresh fa-spin'></i> Processing...");
			jQuery.post("{{ url('ajax') }}", {change_password:1, confirm_pwd:confirm_pwd}, function(response){
				var response = JSON.parse(response);
				if(response.status==1){
					jQuery("#confirm_pwd").after(response.msg);
					jQuery(".button_wrap .lhs").html("<div class='setnewpwd'>Rredirecting...</div>");
					jQuery("#ForgotPwdModal #emailotp").addClass("d-none");
					setTimeout(function(){
						jQuery(".error, .success").remove();
					}, 900);
					setTimeout(function(){
						window.location.href="{{ url()->current() }}";
					}, 1500);
				}else if(response.status==2){
					jQuery("#ForgotPwdModal #confirm_pwd").after(response.msg);
					jQuery(".button_wrap .lhs").html("<div class='setnewpwd'>Change Password</div>");
					jQuery("#ForgotPwdModal .error, #ForgotPwdModal .success").remove();
					setTimeout(function(){
						window.location.href="{{ url()->current() }}";
					}, 1000);
				}else{
					jQuery("#ForgotPwdModal #confirm_pwd").after(response.msg);
					jQuery("#ForgotPwdModal .button_wrap .lhs").html("<div class='setnewpwd'>Change Password</div>");
					jQuery("#ForgotPwdModal #useremail, #password").hide();
					jQuery("#ForgotPwdModal #confirm_pwd").addClass("d-none");
					setTimeout(function(){
						window.location.href="{{ url()->current() }}";
					}, 1000);
				}
			});
		}
	});
	jQuery("body").on("click", ".loginbtn", function(){
		jQuery(".error").remove();
		var memberemail = jQuery(".memberemail").val();
		var memberpassword = jQuery(".memberpassword").val();
		if(memberemail==""){
			jQuery(".memberemail").after("<div class='error'>Email cant be empty!</div>");
			jQuery(".memberemail").focus();
			return false;
		}
		if(memberpassword==""){
			jQuery(".memberpassword").after("<div class='error pass_error'>Password cant be empty!</div>");
			jQuery(".memberpassword").focus();
			return false;
		}
		jQuery(this).html("<i class='fa fa-spin fa-refresh' aria-hidden='true'></i> Processing...");
		jQuery.post("{{ url('ajax') }}", {adminlogin: 1, username:memberemail, password:memberpassword}, function(response){
			var response = JSON.parse(response);
			if(response.status==1){
				jQuery(".loginbtn").html("<i class='fa fa-spin fa-refresh' aria-hidden='true'></i> Loginning in...");
				window.location.href = "{{ url('/') }}";
			}else if(response.status==2){
                jQuery(".loginbtn").text("Login");
                jQuery(".memberpassword").after("<div class='error'>Password incorrect!</div>");
                jQuery(".memberpassword").focus();
				return false;
			}else{
                jQuery(".loginbtn").text("Login");
                jQuery(".memberemail").after("<div class='error'>User not exist!</div>");
				jQuery(".memberemail").focus();
				return false;
			}
		});
    }); 
	jQuery("body").on("click", "#ForgotPwdModal .adminlogin", function(){
		jQuery(".error").remove();
		var username = jQuery(".username").val();
		var password = jQuery(".password").val();
		if(username==""){
			jQuery("#ForgotPwdModal .username").after("<div class='error'>Email cant be empty!</div>");
			jQuery("#ForgotPwdModal .username").focus();
			return false;
		}
		if(password==""){
			jQuery("#ForgotPwdModal .password").after("<div class='error pass_error'>Password cant be empty!</div>");
			jQuery("#ForgotPwdModal .password").focus();
			return false;
		}
		jQuery(this).html("<i class='fa fa-spin fa-refresh' aria-hidden='true'></i> Processing...");
		jQuery.post("{{ url('ajax') }}", {adminlogin: 1, username:username, password:password}, function(response){
			var response = JSON.parse(response);
			if(response.status==1){
				jQuery("#ForgotPwdModal .adminlogin").text("Loginning in...");
				window.location.href = "{{ url('/') }}";
			}else if(response.status==2){
                jQuery("#ForgotPwdModal .adminlogin").text("Login");
                jQuery("#ForgotPwdModal .password").after("<div class='error'>Password incorrect!</div>");
                jQuery("#ForgotPwdModal .password").focus();
				return false;
			}else{
                jQuery("#ForgotPwdModal .adminlogin").text("Login");
                jQuery("#ForgotPwdModal .username").after("<div class='error'>User not exist!</div>");
				jQuery("#ForgotPwdModal .username").focus(); 
				return false;
			}
		});
    });
});
</script>
@stop
@include('common.footer')
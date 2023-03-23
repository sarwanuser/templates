
@if(is_admin_logged_in())
		<footer class="footer">
			<div class="container-fluid">
				<div class="copyright float-right">&copy; <script> document.write(new Date().getFullYear()) </script> Vihangam</div>
			</div>
		</footer>
	</div>
</div>
@endif

<script src="{{ url('js/core/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ url('js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ url('js/core/bootstrap-material-design.min.js') }}" type="text/javascript"></script>
<script src="{{ url('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ url('js/plugins/moment.min.js') }}"></script>
<script src="{{ url('js/plugins/sweetalert2.js') }}"></script>
<script src="{{ url('js/plugins/jquery.validate.min.js') }}"></script>
<script src="{{ url('js/plugins/jquery.bootstrap-wizard.js') }}"></script>
<script src="{{ url('js/plugins/bootstrap-selectpicker.js') }}" ></script>
<script src="{{ url('js/plugins/jquery.datatables.min.js') }}"></script>
<script src="{{ url('js/plugins/sweetalert2.js') }}"></script>
<script src="{{ url('js/plugins/bootstrap-tagsinput.js') }}"></script>
<script src="{{ url('js/plugins/jasny-bootstrap.min.js') }}"></script>
<script src="{{ url('js/plugins/fullcalendar.min.js') }}"></script>
<script src="{{ url('js/plugins/jquery-jvectormap.js') }}"></script>
<script src="{{ url('js/plugins/nouislider.min.js') }}" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<script src="{{ url('js/plugins/arrive.min.js') }}"></script>
<script src="{{ url('js/plugins/chartist.min.js') }}"></script>
<script src="{{ url('js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ url('js/plugins/bootstrap-notify.js') }}"></script>
<script src="{{ url('js/material-dashboard.min.js') }}"></script>
<script src="{{ url('js/jquery.cookie.js') }}"></script>

@yield('loginscript')
@yield('dashboardscript')
@yield('usersscript')
@yield('adduserscript')
@yield('edituserscript')
@yield('hawanscript')
@yield('addhawanscript')
@yield('updatehawanscript')
@yield('searchscript')
@yield('addadminscript')
@yield('updateadminscript')
@yield('adminssscript')
@yield('settingscript')

</body>
</html>

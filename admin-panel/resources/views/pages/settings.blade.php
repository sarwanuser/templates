@include('common.header', ['page_class' => 'page-admin-setting', 'pagetitle' => 'Admin Setting | Vihangam Yog Seva', 'pagename' => 'Setting', 'pageurl' => url('admin/setting')])

<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h4 class="card-title">Settings</h4>
						
					</div>
					<div class="card-body table-responsive">
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



@section('settingscript')
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
    md.initDashboardPageCharts();
});
</script>
@stop

@include('common.footer')
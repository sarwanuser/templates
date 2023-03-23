@include('common.header', ['page_class' => 'page-admin-help', 'pagetitle' => 'Admin Help | Vihangam Yog Seva', 'pagename' => 'Help', 'pageurl' => url('admin/help')])

<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h4 class="card-title">Help</h4>

					</div>
					<div class="card-body table-responsive">
						<div class="row">                            <div class="col-md-12">								<p>Sanjeev Thakur<br>Mob no -9334769087</p>								<p>Neeraj Pandey<br>Mob no- 9235597787</p>							</div>						</div>
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

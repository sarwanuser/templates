@include('common.header', ['page_class' => 'page-admin-dashboard', 'pagetitle' => 'Admin Dashboard | Vihangam Yog Seva', 'pagename' => ''])
<div class="content">
	<div class="container-fluid mobile_area">
		@include('common.sidebar')
	</div>
	<div class="container-fluid desktop_area">
		 @if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin'))
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-warning card-header-icon">
							<div class="card-icon">
								<img class="allvidyarthisimgpng" src="{{ url('img/all-vidyarthi.png') }}" alt="All vidyarthis" title=""/>
							</div>
							<p class="card-category">Total Vidyarthi </p>
							<h3 class="card-title">{{ get_user_count() }}</h3>
						</div>
						<div class="card-footer">
							<div class="stats">
								<img class="allvidyarthisimgpng" src="{{ url('img/all-vidyarthi.png') }}" alt="All vidyarthis" title=""/>
								<a href="{{ url('admin/vidyarthis') }}"> All Vidyarthis</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-success card-header-icon">
							<div class="card-icon">
								<img class="allhawansimgpng" src="{{ url('img/all havans.png') }}" alt="All hawans" title=""/>
							</div>
							<p class="card-category">Total Hawans</p>
							<h3 class="card-title">{{ get_hawan_count() }}</h3>
						</div>
						<div class="card-footer">
							<div class="stats">
								<img class="allhawansimgpng" src="{{ url('img/all havans.png') }}" alt="All hawans" title=""/>
								<a href="{{ url('admin/hawans') }}"> All Hawans</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
				<div class="card card-chart">
					<div class="card-header card-header-success">
						<div class="ct-chart" id="weeklyhawanchart"></div>
						<div class="d-none weaklychartdata_wrap">
							<?php
								$weeklydata = $data->weeklychartdata;
							?>
							<div class="weaklychartdata">{{ $weeklydata['monday'] }}</div>
							<div class="weaklychartdata">{{ $weeklydata['tuesday'] }}</div>
							<div class="weaklychartdata">{{ $weeklydata['wednesday'] }}</div>
							<div class="weaklychartdata">{{ $weeklydata['thursday'] }}</div>
							<div class="weaklychartdata">{{ $weeklydata['friday'] }}</div>
							<div class="weaklychartdata">{{ $weeklydata['saturday'] }}</div>
							<div class="weaklychartdata">{{ $weeklydata['sunday'] }}</div>
						</div>
					</div>
					<div class="card-body">
						<h4 class="card-title">Hawans Daily</h4>
						<p class="card-category">
							Increase in today Hawans.
						</p>
					</div>
					<div class="card-footer">
						<div class="stats"><i class="material-icons">access_time</i> Updated 4 minutes ago</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
				<div class="card card-chart">
					<div class="card-header card-header-warning">
						<div class="ct-chart" id="hawanMonthlyChart"></div>
						<div class="d-none monthlyHawanChart_wrap">
							<div class="monthlyhawanchartdata">{{ $data->havan_count_1 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_2 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_3 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_4 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_5 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_6 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_7 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_8 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_9 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_10 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_11 }}</div>
							<div class="monthlyhawanchartdata">{{ $data->havan_count_12 }}</div>
						</div>
					</div>
					<div class="card-body">
						<h4 class="card-title">Hawans Monthly</h4>
						<p class="card-category">Last Hawans Monthly</p>
					</div>
					<div class="card-footer">
						<div class="stats"><i class="material-icons">access_time</i> Updated 4 minutes ago</div>
					</div>
				</div>
			</div>
		</div>
		 @if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin'))
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
					<div class="card card-chart">
						<div class="card-header card-header-success">
							<div class="ct-chart" id="stateshawanchart"></div>
							<div class="d-none stateschartdata_wrap">
								<?php
									$statesdata = $data->stateschartdata;
								?>
								<div class="statechartdata">{{ $statesdata['and'] }}</div>
								<div class="statechartdata">{{ $statesdata['aru'] }}</div>
								<div class="statechartdata">{{ $statesdata['ass'] }}</div>
								<div class="statechartdata">{{ $statesdata['bih'] }}</div>
								<div class="statechartdata">{{ $statesdata['chh'] }}</div>
								<div class="statechartdata">{{ $statesdata['goa'] }}</div>
								<div class="statechartdata">{{ $statesdata['guj'] }}</div>
								<div class="statechartdata">{{ $statesdata['har'] }}</div>
								<div class="statechartdata">{{ $statesdata['him'] }}</div>
								<div class="statechartdata">{{ $statesdata['jha'] }}</div>
								<div class="statechartdata">{{ $statesdata['kar'] }}</div>
								<div class="statechartdata">{{ $statesdata['ker'] }}</div>
								<div class="statechartdata">{{ $statesdata['mad'] }}</div>
								<div class="statechartdata">{{ $statesdata['mah'] }}</div>
								<div class="statechartdata">{{ $statesdata['man'] }}</div>
								<div class="statechartdata">{{ $statesdata['meg'] }}</div>
								<div class="statechartdata">{{ $statesdata['miz'] }}</div>
								<div class="statechartdata">{{ $statesdata['nag'] }}</div>
								<div class="statechartdata">{{ $statesdata['odi'] }}</div>
								<div class="statechartdata">{{ $statesdata['pun'] }}</div>
								<div class="statechartdata">{{ $statesdata['raj'] }}</div>
								<div class="statechartdata">{{ $statesdata['sik'] }}</div>
								<div class="statechartdata">{{ $statesdata['tam'] }}</div>
								<div class="statechartdata">{{ $statesdata['tel'] }}</div>
								<div class="statechartdata">{{ $statesdata['tri'] }}</div>
								<div class="statechartdata">{{ $statesdata['utt'] }}</div>
								<div class="statechartdata">{{ $statesdata['utr'] }}</div>
								<div class="statechartdata">{{ $statesdata['wes'] }}</div>
							</div>
						</div>
						<div class="card-body">
							<h4 class="card-title">Hawans State Wise</h4>
							<p class="card-category">Increase in Hawans.</p>
						</div>
						<div class="card-footer">
							<div class="stats"><i class="material-icons">access_time</i> Updated today</div>
						</div>
					</div>
				</div>
			</div>
		@endif
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h4 class="card-title">Havan Recent Detail Area</h4>
						<p class="card-category">Last five days hawan details</p>
					</div>
					<div class="card-body table-responsive">
						<table class="table table-hover havanstable">
							<thead class="text-primary">
								<th class="text-nowrap">Date</th>
								<th class="text-nowrap">Hawans</th>
								<th class="text-nowrap">Amount</th>
								<th class="text-nowrap">Action</th>
							</thead>
							<tbody>
								@foreach($data->hawans as $hawank => $hawanv)
									@php
									$newhawandatetime = new DateTime($hawank);
									$dateofhawan = $newhawandatetime->format('d-m-Y');
									@endphp
									<tr>
										<td class="text-nowrap">{{ $dateofhawan }}</td>
										<td class="text-nowrap">{{ $hawanv }}</td>
										<td class="text-nowrap">Rs. {{ havan_sum_datewise($hawank) }}</td>
										<td class="text-nowrap"><span class="viewdetails text-success"><a href="{{ url('admin/search') }}?searchby=all&yajnakartaname=&username=&contact=&fromdate={{$hawank}}&toodate=&country=&state=&district=&rashidno=&is_search=1"><i class="material-icons"></i>Details</a></span></td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<!-- User Wise Report -->
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h4 class="card-title">Per Month Detail Havans</h4>
						<p class="card-category">This month report vidyarthi wise</p>
					</div>
					<div class="card-body table-responsive">
						<table class="table table-hover havanstable">
							<thead class="text-primary">
								<th class="text-nowrap">Vidyarthi Name</th>
								<th class="text-nowrap">Total Hawans</th>
								<th class="text-nowrap">Total Seva</th>
								<th class="text-nowrap">Month</th>
								<th class="text-nowrap">Year</th>
							</thead>
							<tbody>
								@foreach($per_month_report as $report)
									<tr>
										<td class="text-nowrap">{{ $report->vidyarthi_name }}</td>
										<td class="text-nowrap">{{ $report->total_hawan }}</td>
										<td class="text-nowrap">Rs. {{ $report->total_seva }}</td>
										<td class="text-nowrap">{{ $report->month }}</td>
										<td class="text-nowrap">{{ $report->year }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- /User Wise Report -->
		
	</div>
</div>
@section('dashboardscript')
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


    md.initDocumentationCharts();
});
</script>
@stop
@include('common.footer')

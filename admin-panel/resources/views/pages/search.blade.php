@include('common.header', ['page_class' => 'page-admin-search', 'pagetitle' => 'Admin Search | Vihangam Yog Seva', 'pagename' => 'Search', 'pageurl' => url('admin/search')])
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h4 class="card-title">Hawan Search Details & Export Hawans</h4>
					</div>
					<div class="card-body">
						<form id="searchform" action="{{ url('admin/search') }}" method="GET">
							<div class="search_form_inn">
								<div class="row">
									<div class="col-md-3 col-sm-12">
										<div class="form-group select_wrap">
											<label for="searchby">Sarch By</label>
											<select class="form-control searchby selectpicker" data-style="btn btn-link" id="searchby"  name="searchby">
												<option value="all" @if($data->ssearchby == "all") selected="selected" @endif>All</option>
												<option value="statewise" @if($data->ssearchby == "statewise") selected="selected" @endif>State Wise</option>
												<option value="districtwise" @if($data->ssearchby == "districtwise") selected="selected" @endif>District Wise</option>
												<option value="vidyarthiwise" @if($data->ssearchby == "vidyarthiwise") selected="selected" @endif>Vidyarthi Wise</option>
												<option value="hubwise" @if($data->ssearchby == "hubwise") selected="selected" @endif>Hub Wise</option>
											</select>
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label for="yajnakartaname">Yajman Name</label>
											<input type="text" class="form-control" id="yajnakartaname" name="yajnakartaname" placeholder="" value="{{ $data->syajnakartaname }}" autocomplete="off" />
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label for="username">Vidyarthi Name</label>
											<input type="text" class="form-control" id="username" name="username" placeholder="" value="{{ $data->susername }}" autocomplete="off" />
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label for="contact">Contact</label>
											<input type="text" class="form-control" id="contact" name="contact" placeholder="" autocomplete="off" value="{{ $data->scontact }}" />
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label for="fromdate">Date From</label>
											<input type="text" class="form-control datepicker" id="fromdate"  name="fromdate" placeholder="" value="{{ $data->sfromdate }}"/>
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label for="toodate">To</label>
											<input type="text" class="form-control datepicker" id="toodate"  name="toodate" placeholder="" value="{{ $data->stoodate }}"/>
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group select_wrap">
											<label for="country_select">Country</label>
											<select class="form-control country_select selectpicker" data-style="btn btn-link" id="country_select" name="country">
												<option value="">Select Country</option>
												@foreach($data->countries as $country)
													<option value="{{ $country->ID }}" data-cid="{{ $country->ID }}" @if($country->ID == $data->scountry) selected="selected" @endif>{{ $country->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group select_wrap">
											<label for="state_select">State</label>
											<select class="form-control state_select selectpicker" data-style="btn btn-link" id="state_select"  name="state">
												<option value="">Select State</option>
												@if($data->scountry !="")
													@foreach($data->country_by_states as $state)
														<option value="{{ $state->ID }}" @if($state->ID == $data->sstate) selected="selected" @endif>{{ $state->name }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group select_wrap">
											<label for="hub">Hub</label>
											<select class="form-control hub selectpicker" data-style="btn btn-link" id="hub" name="hub">
												<option value="">Select Hub</option>
												@foreach($data->our_hub as $hub)
													<option value="{{ $hub->ID }}" @if($data->shubid == $hub->ID) selected="selected" @endif>{{ $hub->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label for="district">District</label>
											<input type="text" class="form-control district" id="district" name="district" placeholder="" value="{{ $data->sdistrict }}" autocomplete="off" />
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group select_wrap">
											<label for="rashidcode">Rashid code</label>
											<select class="form-control rashidcode selectpicker" name="rashidcode" data-style="btn btn-link" id="rashidcode">
												<option value="VYS/HYS/{{ date('y',strtotime('-1 year')) }}-{{ date('y') }}" @if($data->srashidcode == "VYS/HYS/{{ date('y',strtotime('-1 year')) }}-{{ date('y') }}") selected="selected" @endif>VYS/HYS/{{ date('y',strtotime('-1 year')) }}-{{ date('y') }}</option>
												<option value="VYS/HYS/{{ date('y') }}-{{ date('y',strtotime('+1 year')) }}" @if($data->srashidcode == "VYS/HYS/{{ date('y') }}-{{ date('y',strtotime('+1 year')) }}") selected="selected" @endif>VYS/HYS/{{ date('y') }}-{{ date('y',strtotime('+1 year')) }}</option>
											</select>
											<!--<input type="text" class="form-control" id="rashidcode" name="rashidcode" placeholder="" value="{{ $data->srashidcode }}" autocomplete="off" />-->
										</div>
									</div>
									<div class="col-md-3 col-sm-12"> 
										<div class="form-group">
											<label for="rashidnofrom">Rashid No From.</label>
											<input type="text" class="form-control rashidnofrom" id="rashidnofrom" name="rashidnofrom" placeholder="" value="{{ $data->srashidnofrom }}" autocomplete="off" />
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label for="rashidnoto">Rashid No. To</label>
											<input type="text" class="form-control rashidnoto" id="rashidnoto" name="rashidnoto" placeholder="" value="{{ $data->srashidnoto }}" autocomplete="off" />
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group fg_btn_wrap">
											<input type="hidden" name="is_search" value="1" />
											<button type="submit" class="btn btn-primary searchjplbtn">Search</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h4 class="card-title">Search Results</h4>
					</div>
					<div class="card-body">
						@if($data->ssearchby == "statewise")
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="table-responsive">
										<table class="table table-hover admintable">
											<thead class="text-primary">
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
												<th>Sl.no</th>
												<th>State Name</th>
												<th>No of Vidyarthis</th>
												<th>No of Hawans</th>
												<th>Hawan Amount</th>
											</thead>
											<tbody>
												@if($data->hawansc > 0)
													@foreach($data->hawans as $hawank => $hawan)
														<tr>
															<td class="text-nowrap">
																<div class="form-check">
																	<label class="form-check-label">
																		<input class="form-check-input" type="checkbox" value="1" autocomplete="off" data-hawanid="{{ $hawan->hawan_id }}"/>
																		<span class="form-check-sign">
																			<span class="check"></span>
																		</span>
																	</label>
																</div>
															</td>
															<td class="text-nowrap">{{ $data->hawans->firstItem() + $hawank }}</td>
															<td class="text-nowrap">{{ get_statename_by_stateid($hawan->state) }}</td>
															<td class="text-nowrap">{{ vidhyarthi_count_statewise($hawan->state) }}</td>
															<td class="text-nowrap">{{ havan_count_statewise($hawan->state) }}</td>
															<td class="text-nowrap">Rs. {{ havan_sum_statewise($hawan->state) }}</td>
														</tr>
													@endforeach
												@else
													<tr><td colspan="8">No Hawans found</td></tr>
												@endif
											</tbody>
										</table>
										@if($data->hawansc > 30)
											<div class="pagination_wrap search_pagination">
												@if(isset($data->ssearchby))
													{!! $data->hawans->appends(['searchby' => $data->ssearchby, 'country' => $data->scountry, 'is_search' => $data->is_search])->links() !!}
												@else
													{!! $data->hawans->links() !!}
												@endif
											</div>
										@endif
									</div>
								</div>
							</div>
						@endif

						@if($data->ssearchby == "districtwise")
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="table-responsive">
										<table class="table table-hover admintable">
											<thead class="text-primary">
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
												<th>Sl.no</th>
												<th>District Name</th>
												<th>No of Vidyarthis</th>
												<th>No of Hawans</th>
												<th>Hawan Amount</th>
											</thead>
											<tbody>
												@if($data->hawansc > 0)
													@foreach($data->hawans as $hawank => $hawan)
														<tr>
															<td class="text-nowrap">
																<div class="form-check">
																	<label class="form-check-label">
																		<input class="form-check-input" type="checkbox" value="1" autocomplete="off" data-hawanid="{{ $hawan->hawan_id }}"/>
																		<span class="form-check-sign">
																			<span class="check"></span>
																		</span>
																	</label>
																</div>
															</td>
															<td class="text-nowrap">{{ $data->hawans->firstItem() + $hawank }}</td>
															<td class="text-nowrap">{{ ucfirst(get_districtname_by_districtid($hawan->distric)) }}</td>
															<td class="text-nowrap">{{ vidhyarthi_count_districtwise($hawan->distric) }}</td>
															<td class="text-nowrap">{{ havan_count_districtwise($hawan->distric) }}</td>
															<td class="text-nowrap">Rs. {{ havan_sum_districtwise($hawan->distric) }}</td>
														</tr>
													@endforeach
												@else
													<tr><td colspan="8">No Hawans found</td></tr>
												@endif
											</tbody>
										</table>
										@if($data->hawansc > 30)
											<div class="pagination_wrap search_pagination">
												@if(isset($data->ssearchby))
													{!! $data->hawans->appends(['searchby' => $data->ssearchby, 'country' => $data->scountry, 'state' => $data->sstate, 'is_search' => $data->is_search])->links() !!}
												@else
													{!! $data->hawans->links() !!}
												@endif
											</div>
										@endif
									</div>
								</div>
							</div>
						@endif
						@if($data->ssearchby == "hubwise")
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="table-responsive">
										<table class="table table-hover admintable">
											<thead class="text-primary">
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
												<th>Sl.no</th>
												<th>Hub Name</th>
												<th>No of Vidyarthis</th>
												<th>No of Hawans</th>
												<th>Hawan Amount</th>
											</thead>
											<tbody>
												@if($data->hawansc > 0)
													@foreach($data->hawans as $hawank => $hawan)
														<tr>
															<td class="text-nowrap">
																<div class="form-check">
																	<label class="form-check-label">
																		<input class="form-check-input" type="checkbox" value="1" autocomplete="off" data-hawanid="{{ $hawan->hawan_id }}"/>
																		<span class="form-check-sign">
																			<span class="check"></span>
																		</span>
																	</label>
																</div>
															</td>
															<td class="text-nowrap">{{ $data->hawans->firstItem() + $hawank }}</td>
															<td class="text-nowrap">{{ $hawan->hubname }}</td>
																<td class="text-nowrap">{{ vidhyarthi_count_hubwise($hawan->hub_id) }}</td>
															<td class="text-nowrap">{{ havan_count_hubwise($hawan->hub_id) }}</td>
															<td class="text-nowrap">Rs. {{ havan_sum_hubwise($hawan->hub_id) }}</td>
														</tr>
													@endforeach
												@else
													<tr><td colspan="8">No Hawans found</td></tr>
												@endif
											</tbody>
										</table>
										@if($data->hawansc > 30)
											<div class="pagination_wrap search_pagination">
												@if(isset($data->ssearchby))
													{!! $data->hawans->appends(['searchby' => $data->ssearchby, 'country' => $data->scountry, 'is_search' => $data->is_search])->links() !!}
												@else
													{!! $data->hawans->links() !!}
												@endif
											</div>
										@endif
									</div>
								</div>
							</div>
						@endif
						@if(($data->ssearchby == "vidyarthiwise") || ($data->ssearchby == "all"))
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="table-responsive">
										<table class="table table-hover admintable">
											<thead class="text-primary">
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
												<th>Sl.no</th>
												@if($data->ssearchby == "all")
													<th>Rashid No</th>
												@endif
												<th>Vidyarthi</th>
												<th>State</th>
												<th>District</th>
												<th>Contact</th>
												@if($data->ssearchby == "vidyarthiwise")
													<th>No of Hawans</th>
													<th>Hawan Amount</th>
												@endif
											</thead>
											<tbody>
												@if($data->hawansc > 0)
													@foreach($data->hawans as $hawank => $hawan)
														<tr>
															<td class="text-nowrap">
																<div class="form-check">
																	<label class="form-check-label">
																		<input class="form-check-input" type="checkbox" value="1" autocomplete="off" data-hawanid="{{ $hawan->hawan_id }}" data-uid="{{ $hawan->vidyarthi_id }}"/>
																		<span class="form-check-sign">
																			<span class="check"></span>
																		</span>
																	</label>
																</div>
															</td>
															<td class="text-nowrap">{{ $data->hawans->firstItem() + $hawank }}</td>
															@if($data->ssearchby == "all")
																<td class="text-nowrap">{{ $hawan->rashid_code }} {{ $hawan->rashid_number }}</td>
															@endif
															<td class="text-nowrap">{{ get_user_meta($hawan->vidyarthi_id, 'first_name', true) }} {{ get_user_meta($hawan->vidyarthi_id, 'last_name', true) }}</td>
															<td class="text-nowrap">{{ get_statename_by_stateid($hawan->state) }}</td>
															<td class="text-nowrap">{{ get_districtname_by_districtid($hawan->distric) }}</td>
															<td class="text-nowrap">{{ get_hawan_meta($hawan->hawan_id, 'yazman_whatsapp_num', true) }}</td>
															@if($data->ssearchby == "vidyarthiwise")
																<td class="text-nowrap">{{ get_havancount($hawan->vidyarthi_id) }}</td>
																<td class="text-nowrap">Rs. {{ get_hawanamt_byuser($hawan->vidyarthi_id) }}</td>
															@endif
														</tr>
													@endforeach
												@else
													<tr><td colspan="8">No Hawans found</td></tr>
												@endif
											</tbody>
										</table>
										@if($data->hawansc > 30)
											<div class="pagination_wrap search_pagination">
												@if(!empty($_REQUEST['is_search']))
													{!! $data->hawans->appends(['searchby' => $_REQUEST['searchby'], 'yajnakartaname' => $_REQUEST['yajnakartaname'], 'username' => $_REQUEST['username'], 'contact' => $_REQUEST['contact'], 'fromdate' => $_REQUEST['fromdate'], 'toodate' => $_REQUEST['toodate'], 'country' => $_REQUEST['country'], 'state' => $_REQUEST['state'], 'hub' => $_REQUEST['hub'], 'district' => $_REQUEST['district'], 'rashidcode' => $_REQUEST['rashidcode'], 'rashidnofrom' => $_REQUEST['rashidnofrom'], 'rashidnoto' => $_REQUEST['rashidnoto'], 'is_search' => $_REQUEST['is_search']])->links() !!}
												@else
													{!! $data->hawans->links() !!}
												@endif
											</div>
										@endif
									</div>
								</div>
							</div>
						@endif
						@if($data->hawansc > 0)
							<div class="btn btn-primary exporthawanbtn">Export</div>
							<div class="btn btn-primary printallpdfbtn">Print</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@section('searchscript')

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

	md.initFormExtendedDatetimepickers();

   jQuery("#country_select").change(function() {
        var country_id = jQuery("#country_select option:selected").attr("data-cid");
        jQuery.post("{{ url('ajax') }}", {getstates: 1, country_id: country_id}, function(response) {
            var response = JSON.parse(response);
            if (response.status == 1) {
                jQuery("#state_select").html(response.optionhtml);
                jQuery(".state_select.selectpicker").selectpicker('refresh');
            }
        });
    });
	jQuery("#checkAll input:checkbox").click(function(){
		jQuery('.form-check-label input:checkbox').not(this).prop('checked', this.checked);
	});
	jQuery('.form-check-input').on('click',function(){
		if(jQuery("tbody tr").length == jQuery("tbody tr .form-check-input:checked").length){
			jQuery(".error").remove();
		}else{
			jQuery(".error").remove();
		}
	});

	jQuery("body").on("click", ".exporthawanbtn", function(){
		jQuery(".error").remove();
		var hawanids = 0;
		var uids = 0;
		var checkedln = jQuery("tbody tr .form-check-input:checked").length;
		if(jQuery("tbody tr .form-check-input:checked").length > 0){
			var havanexptype = 1;
			var searchby = jQuery(".searchby").val();
			if(searchby != 'vidyarthiwise'){
				var hawanids = new Array();
				for(var i=0; i < checkedln; i++){
					var hawanid = jQuery("tbody tr .form-check-input:checked").eq(i).attr("data-hawanid");
					hawanids.push(hawanid);
				}
			}else{
				var uids = new Array();
				for(var i=0; i < checkedln; i++){
					var uid = jQuery("tbody tr .form-check-input:checked").eq(i).attr("data-uid");
					uids.push(uid);
				}
			}
		}else{
			var havanexptype = 2;
		}
		// Search Params
		var searchparams = jQuery("#searchform").serializeArray();
		jQuery(this).html("<i class='fa fa-refresh fa-spin'></i> Processing...");
		jQuery.post("{{ url('ajax') }}", {exporthawans: 1, havanexptype:havanexptype, searchparams:searchparams, hawanids:hawanids, uids:uids}, function(response){
			var response = JSON.parse(response);
			jQuery(".exporthawanbtn").html("Export");
			if(response.status==1){
				window.location.href = response.excellink;
			}
		});
	});

});
</script>
@stop
@include('common.footer')

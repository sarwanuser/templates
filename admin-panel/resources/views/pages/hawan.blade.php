@include('common.header', ['page_class' => 'page-admin-hawan', 'pagetitle' => 'Admin Hawan | Vihangam Yog Seva', 'pagename' => 'Hawans List', 'pageurl' => url('admin/hawans')])
<div class="content mt100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Search Hawans</h4>
                        <p class="card-category">Add keywords to filter all hawans</p>
                    </div>
                    <div class="card-body">
						<form id="searchform" action="{{ url('admin/hawans') }}" method="GET">
							<div class="search_form_inn">
								<div class="row">
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
											<label for="rashidcode">Rashid code</label>
											<select class="form-control rashidcode selectpicker" name="rashidcode" data-style="btn btn-link" id="rashidcode">
												<option value="VYS/HYS/{{ date('y',strtotime('-1 year')) }}-{{ date('y') }}" @if($data->srashidcode == "VYS/HYS/{{ date('y',strtotime('-1 year')) }}-{{ date('y') }}") selected="selected" @endif>VYS/HYS/{{ date('y',strtotime('-1 year')) }}-{{ date('y') }}</option>
												<option value="VYS/HYS/{{ date('y') }}-{{ date('y',strtotime('+1 year')) }}" @if($data->srashidcode == "VYS/HYS/{{ date('y') }}-{{ date('y',strtotime('+1 year')) }}") selected="selected" @endif>VYS/HYS/{{ date('y') }}-{{ date('y',strtotime('+1 year')) }}</option>
											</select>										
										</div>
									</div>
									<div class="col-md-3 col-sm-12"> 
										<div class="form-group">
											<label for="rashidnofrom">Rashid No</label>
											<input type="text" class="form-control rashidnofrom" id="rashidnofrom" name="rashidnofrom" placeholder="" value="{{ $data->srashidnofrom }}" autocomplete="off" />
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
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">All Hawans</h4>
                        <p class="card-category">Here is the list of all Hawans</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
										<?php 
											$loginuserdata = json_decode(Session::get('auserdata'));
										?>
										@if($loginuserdata->user_role == "administrator")
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
										<th>Sl.no</th>
										<th>Rasid No</th>
										<th>Date</th>
                                        <th>Yajman Name</th>
										<th>Mobile</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Vidyarthi</th>
                                        <th>Ashram Seva</th>
										<th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($data->hawans->total() > 0)
										@foreach($data->hawans as $hawank => $hawan)
											@php
												$newhawandatetime = new DateTime($hawan->date_of_hawan);
												$dateofhawan = $newhawandatetime->format('d-m-Y');
												$swamiji_seva_amt = get_hawan_meta($hawan->ID, 'swamiji_seva_amt', true);
												$swamiji_general_seva_amt = get_hawan_meta($hawan->ID, 'swamiji_general_seva_amt', true);
												$swamiji_other_seva_amt = get_hawan_meta($hawan->ID, 'swamiji_other_seva_amt', true);
												$ashram_seva_rashi = number_format(floatval($swamiji_seva_amt + $swamiji_general_seva_amt + $swamiji_other_seva_amt), 2, '.', '');
											@endphp
											<tr>
												@if($loginuserdata->user_role == "administrator")									
													<td class="text-nowrap">
														<div class="form-check">
															<label class="form-check-label">
																<input class="form-check-input" type="checkbox" value="1" autocomplete="off" data-hawanid="{{ $hawan->ID }}"/>
																<span class="form-check-sign">
																	<span class="check"></span>
																</span>
															</label>
														</div>
													</td>
												@endif
												<td>{{ $data->hawans->firstItem() + $hawank }}</td>
												<td class="text-nowrap">{{ $hawan->rashid_number }}</td>
												<td class="text-nowrap">{{ $dateofhawan }}</td>
												<td class="text-nowrap">{{ $hawan->yazman_name }}</td>
												<td class="text-nowrap">{{ get_hawan_meta($hawan->ID, 'yazman_whatsapp_num', true) }}</td>
												<td class="text-nowrap">{{ get_statename_by_stateid($hawan->state) }}</td>
												<td class="text-nowrap">{{ get_districtname_by_districtid($hawan->distric) }}</td>
												<td class="text-nowrap">{{ get_user_meta($hawan->user_id, "first_name", true) }} {{ get_user_meta($hawan->user_id, "last_name", true) }}</td>
												<td class="text-nowrap">Rs. {{ $ashram_seva_rashi }}</td>
												<td><span class="viewdetails text-success"><a href="{{ url('admin/hawans/edit') }}/{{ $hawan->ID }}"><i class="material-icons">edit</i></a></span></td>
											</tr>
										@endforeach
                                    @else
                                    <tr>
                                        <td colspan="5">No Hawans!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if($data->hawans->total() > 10)
							<div class="pagination_wrap">
								@if($data->is_search == 1)
									{!! $data->hawans->appends(['yajnakartaname' => $_REQUEST['yajnakartaname'], 'username' => $_REQUEST['username'], 'contact' => $_REQUEST['contact'], 'fromdate' => $_REQUEST['fromdate'], 'toodate' => $_REQUEST['toodate'], 'rashidcode' => $_REQUEST['rashidcode'], 'rashidnofrom' => $_REQUEST['rashidnofrom']])->links() !!}
								@else
									{!! $data->hawans->links() !!}
								@endif
							</div>
                        @endif
						@if($loginuserdata->user_role == "administrator")		
							<div class="btn btn-danger deletehawanbtn d-none">Delete Hawan</div>
						@endif 
						
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('hawanscript')
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

	jQuery("#checkAll input:checkbox").click(function(){
		jQuery('.form-check-label input:checkbox').not(this).prop('checked', this.checked);
		jQuery(".deletehawanbtn").removeClass("d-none");
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
			jQuery(".deletehawanbtn").removeClass("d-none");
		}else{
			jQuery(".deletehawanbtn").addClass("d-none");
		}
	});
	jQuery("body").on("click", ".deletehawanbtn", function(){
		jQuery(".error").remove();
		var allhawanid = new Array();
		for(var i=0; i < jQuery("tbody tr .form-check-input:checked").length; i++){
			var hawanid = jQuery("tbody tr .form-check-input:checked").eq(i).attr("data-hawanid");
			allhawanid.push(hawanid);
		}
		if(jQuery("tbody tr .form-check-input:checked").length == 0){
			jQuery(".deletehawanbtn").before("<div class='error'>Please select the rows!</div>");
			return false;
		}else{
			Swal.fire({
				title: 'Are you sure?',
				text: "All selected hawans will be removed, you won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#4caf50',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Delete',
				focusConfirm: false
			}).then((result) => {
				if (result.value) {
					var deletehawandata = new FormData();
					deletehawandata.append("deletehawans", 1);
					deletehawandata.append("hawanids", JSON.stringify(allhawanid));
					jQuery(this).html("<i class='fa fa-spin fa-refresh' aria-hidden='true'></i> Processing...");
					jQuery.ajax({
						url: "{{ url('ajax') }}",
						type: 'POST',
						data: deletehawandata,
						cache: false,
						contentType: false,
						processData: false,
						success: function(response) {
							var response = JSON.parse(response);
							jQuery(".deletehawanbtn").html("Delete Hawan");
							if (response.status == 1) {
								Swal.fire(
									'Successful',
									'Hawans has been removed.',
									'success'
								).then((result) => {
									window.location.href="{{ url()->current() }}";
								});
							}else{
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: 'Something went wrong!'
								});
							}
						},
						error: function() {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: 'Something went wrong!'
							});
						}
					});
				}
			});
		}
	});
});
</script>
@stop
@include('common.footer')
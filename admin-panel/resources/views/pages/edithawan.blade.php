@include('common.header', ['page_class' => 'page-admin-dashboard-edit-hawan', 'pagetitle' => 'Edit Hawan | Vihangam Yog Seva', 'pagename' => 'Edit Hawan', 'pageurl' => url('admin/hawans/edit')])
<div class="content edithawan_form_inn">
    <div class="container-fluid">
        <div class="row @if($data->sessionlogindata->user_role == 'vidyarthi'){{ $data->sessionlogindata->hide }} @endif">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card vidyarthi_select_wrap">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Vidyarthi Profile</h4>
                        <p class="card-category">Edit hawan data</p>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group select_wrap">
                                    <label for="vidyarthi_select">Select vidyarthi</label>
                                    <select class="form-control vidyarthi_select selectpicker" data-style="btn btn-link" id="vidyarthi_select">
                                        @if(($data->sessionlogindata->user_role == "administrator") || ($data->sessionlogindata->user_role == "admin")) 
											@foreach($data->vidyarthi as $vidyarthi)
												<option value="{{ $vidyarthi->ID }}" @if($vidyarthi->
													ID == $data->hawandata->user_id) selected='selected' @endif>{{ get_user_meta($vidyarthi->ID, 'user_reg_number', true) }} {{ $vidyarthi->user_email }}
												</option>
											@endforeach 
										@else
											<option value="{{ $data->sessionlogindata->ID }}">{{ get_user_meta($data->sessionlogindata->ID, 'user_reg_number', true) }} {{ $data->sessionlogindata->email }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-profile upid">
                                    <div class="card-avatar">
                                        <a href="javascript:;">
                                            <img class="img" src="{{ url($data->userdata->profileimage_path) }}" alt="Profile Image" title="" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Vidyarthi name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="username"
                                        placeholder=""
                                        value="{{ get_user_meta($data->hawandata->user_id, 'first_name', true) }} {{ get_user_meta($data->hawandata->user_id, 'last_name', true) }}"
                                        autocomplete="off"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="useremail">Vidyarthi email</label>
                                    <input type="email" class="form-control" id="useremail" placeholder="" value="{{$data->userdata->user_email }}" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usermob">Mobile number</label>
                                    <input type="text" class="form-control" id="usermob" placeholder="" value="{{ $data->userdata->phone_number }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="regdtp">Year of admission</label>
                                    <input type="text" class="form-control" id="regdtp" placeholder="" value="{{ $data->userdata->regdtp }}" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vi_postcode">Post code</label>
                                    <input type="text" class="form-control" id="vi_postcode" placeholder="" value="{{ $data->userdata->vi_postcode }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_country_selected">Country</label>
                                    <input type="text" class="form-control" id="user_country_selected" placeholder="" value="{{ $data->userdata->country_name }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_state_selected">State</label>
                                    <input type="text" class="form-control" id="user_state_selected" placeholder="" value="{{ $data->userdata->user_state }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vi_hub">Hub</label>
                                    <input type="text" class="form-control" id="vi_hub" placeholder="" value="{{ $data->userdata->vi_name }}" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="permanentaddress">Permanent address</label>
                            <textarea class="form-control" id="permanentaddress" rows="3" placeholder="" placeholder="Permanent address" autocomplete="off">{{ $data->userdata->user_address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="comments">Comments</label>
                            <textarea class="form-control" id="comments" rows="4" placeholder="" autocomplete="off">{{ $data->userdata->comments }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Yajman Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rashidcode">Rashid code</label>
                                    <input type="text" class="form-control" id="rashidcode" placeholder="" value="{{ $data->hawandata->rashid_code }}" autocomplete="off" />
                                    <div class="overlaynoread"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rashidnumber">Rashid no<sup>*</sup></label>
                                    <input type="text" class="form-control" id="rashidnumber" placeholder="" value="{{ $data->hawandata->rashid_number }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="yazmanname">Yazman name<sup>*</sup></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="yazmanname"
                                        aria-describedby="yazmannameHelp"
                                        placeholder=""
                                        value="{{ get_hawan_meta($data->hawandata->ID, 'first_name', true) }} {{ get_hawan_meta($data->hawandata->ID, 'last_name', true) }}"
                                        autocomplete="off"
                                    />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fatherhusband">Father's / Husband's name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="fatherhusband"
                                        aria-describedby="fatherhusbandHelp"
                                        placeholder=""
                                        value="{{ get_hawan_meta($data->hawandata->ID, 'father_husband', true) }}"
                                        autocomplete="off"
                                    />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dateofhawan">Date of hawan<sup>*</sup></label>
                                    <input type="text" class="form-control datepicker" id="dateofhawan" aria-describedby="dateofhawanHelp" placeholder="" value="{{ $data->hawandata->dateofhawan }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="postcode">Post code</label>
                                    <input type="text" class="form-control" id="postcode" aria-describedby="postcodeHelp" placeholder="" value="{{ $data->hawandata->postcode }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group select_wrap">
                                    <label for="country_select">Country<sup>*</sup></label>
                                    <select class="form-control country_select selectpicker" data-style="btn btn-link" id="country_select">
                                        @foreach($data->countries as $country)
                                        <option value="{{ $country->ID }}" data-cid="{{ $country->ID }}" @if($country->ID == $data->hawandata->country_code) selected="selected" @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group select_wrap">
                                    <label for="hub_select">Hub<sup>*</sup></label>
                                    <select class="form-control hub_select selectpicker" data-style="btn btn-link" id="hub_select">
                                        @foreach($data->our_hub as $hub)
                                        <option value="{{ $hub->ID }}" @if($hub->ID == $data->hawandata->hub_id) selected="selected" @endif>{{ $hub->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group select_wrap">
                                    <label for="state_select">State<sup>*</sup></label>
                                    <select class="form-control state_select selectpicker" data-style="btn btn-link" id="state_select">
                                        @foreach($data->country_by_states as $state)
                                        <option value="{{ $state->ID }}" data-cid="{{ $state->ID }}" @if($state->ID == $data->hawandata->state) selected="selected" @endif>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group select_wrap">
                                    <label for="district_select">District<sup>*</sup></label>
                                    <select class="form-control district_select selectpicker" data-style="btn btn-link" id="district_select">
                                        @foreach($data->districts as $district)
                                        <option value="{{ $district->ID }}" @if($district->ID == $data->hawandata->distric) selected="selected" @endif>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="yazmanvillage">City/Village<sup>*</sup></label>
                                    <input type="text" class="form-control" id="yazmanvillage" placeholder="" value="{{ $data->hawandata->village }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="yazmanpostoffice">Street Address<sup>*</sup></label>
                                    <input type="text" class="form-control" id="yazmanpostoffice" placeholder="" value="{{ $data->hawandata->postoffice }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="yazman_ward_house_num">Ward / House Number<sup>*</sup></label>
                                    <input type="text" class="form-control" id="yazman_ward_house_num" placeholder="" value="{{ $data->hawandata->ward_house_number }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="yazman_whatsapp_num">Whatsapp number</label>
                                    <input type="text" class="form-control" id="yazman_whatsapp_num" placeholder="" autocomplete="off" value="{{ get_hawan_meta($data->hawandata->ID, 'yazman_whatsapp_num', true) }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="yazman_other_num">Other Contact number<sup>*</sup></label>
                                    <input type="text" class="form-control" id="yazman_other_num" placeholder="" autocomplete="off" value="{{ get_hawan_meta($data->hawandata->ID, 'yazman_other_num', true) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Ashram Seva Rashi Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="swamiji_seva_amt">Ashram Seva Rashi<sup>*</sup></label>
                                    <input type="text" class="form-control" id="swamiji_seva_amt" aria-describedby="ashramsevaHelp" placeholder="" autocomplete="off" value="{{ $data->hawandata->swamiji_seva_amt }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="swamiji_general_seva_amt">Aarti / Chadhawa Seva Rashi<sup>*</sup></label>
                                    <input type="text" class="form-control" id="swamiji_general_seva_amt" aria-describedby="ashramsevaHelp" placeholder="" autocomplete="off" value="{{ $data->hawandata->swamiji_general_seva_amt }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="swamiji_other_seva_amt">Vastra Seva</label>
                                    <input type="text" class="form-control" id="swamiji_other_seva_amt" aria-describedby="ashramsevaHelp" placeholder="" autocomplete="off" value="{{ $data->hawandata->swamiji_other_seva_amt }}" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group select_wrap">
                                    <label for="ashram_amt_paid_status">Due or Paid<sup>*</sup></label>
                                    <select class="form-control ashram_amt_paid_status selectpicker" data-style="btn btn-link" id="ashram_amt_paid_status">
                                        <option value="1" @if( $data->hawandata->ashram_amt_paid_status == 1 ) selected="selected" @endif>Paid</option>
                                        <option value="0" @if( $data->hawandata->ashram_amt_paid_status == 0 ) selected="selected" @endif>Due</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group select_wrap">
                                    <label for="ashram_amt_payment_mode">Mode of transfer<sup>*</sup></label>
                                    <select class="form-control ashram_amt_payment_mode selectpicker" data-style="btn btn-link" id="ashram_amt_payment_mode">
                                        <option value="cash" @if( $data->hawandata->ashram_amt_payment_mode == 'cash') selected="selected" @endif>Cash</option>
                                        <option value="online" @if( $data->hawandata->ashram_amt_payment_mode == 'online') selected="selected" @endif>Online transfer</option>
                                        <option value="check" @if( $data->hawandata->ashram_amt_payment_mode == 'check') selected="selected" @endif>Check</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Vidyarthi Seva Rashi details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vidyarthi_seva_amt">Vidyarthi Seva Rashi<sup>*</sup></label>
                                    <input type="text" class="form-control" id="vidyarthi_seva_amt" aria-describedby="vidyarthi_seva_amtHelp" placeholder="" autocomplete="off" value="{{ $data->hawandata->vidyarthi_seva_amt }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="travell_seva_amt">Travel Seva Rashi<sup>*</sup></label>
                                    <input type="text" class="form-control" id="travell_seva_amt" aria-describedby="travell_seva_amtHelp" placeholder="" autocomplete="off" value="{{ $data->hawandata->travell_seva_amt }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vidyarthi_other_seva_amt">Other Seva Rashi<sup>*</sup></label>
                                    <input type="text" class="form-control" id="vidyarthi_other_seva_amt" aria-describedby="ashramsevaHelp" placeholder="" autocomplete="off" value="{{ $data->hawandata->vidyarthi_other_seva_amt }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Screen Shots of Rashid</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group img_upload">
                            <img class="rashidimg" src="{{ url($data->hawandata->rashidimage) }}" alt="Screen Shots of Rashid" />
                            <input type="file" id="rashid_img" class="inputFileHidden imgInp" autocomplete="off" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Purpose of Hawan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group select_wrap">
                                    <label for="purposeofhawan">Select purpose of hawan</label>
                                    <select class="form-control purposeofhawan selectpicker" data-style="btn btn-link" id="purposeofhawan">
                                        @foreach($data->purpose_of_hawans as $purpose_of_hawan)
                                        <option value="{{ $purpose_of_hawan->ID }}" @if($purpose_of_hawan->ID == $data->hawandata->purposeofhawan) selected="selected" @endif>{{ $purpose_of_hawan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Prachar activity</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group select_wrap">
                                    <label for="satsang">Satsang</label>
                                    <select class="form-control satsang selectpicker" data-style="btn btn-link" id="satsang">
                                        <option value="1" @if( $data->hawandata->satsang == 1 ) selected="selected" @endif>Yes</option>
                                        <option value="0" @if( $data->hawandata->satsang == 0 ) selected="selected" @endif>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="@if( $data->hawandata->newserved == 1 ) col-md-3 @else col-md-6 @endif">
                                <div class="form-group select_wrap">
                                    <label for="newserved">New Serwed</label>
                                    <select class="form-control newserved selectpicker" data-style="btn btn-link" id="newserved">
                                        <option value="1" @if( $data->hawandata->newserved == 1 ) selected="selected" @endif>Yes</option>
                                        <option value="0" @if( $data->hawandata->newserved == 0 ) selected="selected" @endif>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 serwedqtywrap" style="@if($data->hawandata->newserved == 1) display: block @else display: none @endif ;">
                                <div class="form-group">
                                    <label for="serwedqty">QTY</label>
                                    <input type="text" class="form-control" id="serwedqty" placeholder="" autocomplete="off" value="{{ $data->hawandata->serwedqty }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="@if( $data->hawandata->newpatrika == 1 ) col-md-3 @else col-md-6 @endif">
                                <div class="form-group select_wrap">
                                    <label for="newpatrika">New Patrika</label>
                                    <select class="form-control newpatrika selectpicker" data-style="btn btn-link" id="newpatrika">
                                        <option value="1" @if( $data->hawandata->newpatrika == 1 ) selected="selected" @endif>Yes</option>
                                        <option value="0" @if( $data->hawandata->newpatrika == 0 ) selected="selected" @endif>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 newpatrikaqtywrap" style="@if($data->hawandata->newpatrika == 1) display: block @else display: none @endif ;">
                                <div class="form-group">
                                    <label for="newpatrikaqty">QTY</label>
                                    <input type="text" class="form-control" id="newpatrikaqty" placeholder="" autocomplete="off" value="{{ $data->hawandata->newpatrikaqty }}" />
                                </div>
                            </div>
                            <div class="@if( $data->hawandata->newakshaypatra == 1 ) col-md-3 @else col-md-6 @endif">
                                <div class="form-group select_wrap">
                                    <label for="newakshaypatra">New Akshay Patra</label>
                                    <select class="form-control newakshaypatra selectpicker" data-style="btn btn-link" id="newakshaypatra">
                                        <option value="1" @if( $data->hawandata->newakshaypatra == 1 ) selected="selected" @endif>Yes</option>
                                        <option value="0" @if( $data->hawandata->newakshaypatra == 0 ) selected="selected" @endif>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 newakshaypatraqtywrap" style="@if($data->hawandata->newakshaypatra == 1) display: block @else display: none @endif ;">
                                <div class="form-group">
                                    <label for="newakshaypatraqty">QTY</label>
                                    <input type="text" class="form-control" id="newakshaypatraqty" placeholder="" autocomplete="off" value="{{ $data->hawandata->newakshaypatraqty }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group select_wrap">
                                    <label for="newupdesh">New updesh</label>
                                    <select id="newupdesh" class="form-control newupdesh selectpicker" data-style="btn btn-link" id="newakshaypatra">
                                        <option value="1" @if( $data->hawandata->newupdesh == 1 ) selected="selected" @endif>Yes</option>
                                        <option value="0" @if( $data->hawandata->newupdesh == 0 ) selected="selected" @endif>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="peopleattendedhawan">No of people attended Hawan</label>
                                    <input type="text" class="form-control" id="peopleattendedhawan" aria-describedby="travell_seva_amtHelp" placeholder="" autocomplete="off" value="{{ $data->hawandata->peopleattendedhawan }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Comments</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="hawancomments">Add comments</label>
                                    <textarea class="form-control hawancomments" id="hawancomments" rows="3" placeholder="" autocomplete="off">{{ get_hawan_meta($data->hawandata->ID, 'hawan_comments', true) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group fg_btn_wrap">
                                    <div class="btn btn-primary updatehawanbtn">Update</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <!--a href="https://demos.creative-tim.com/material-dashboard/docs/2.1/components/forms.html">Theme</a-->
    </div>
</div>
@section('updatehawanscript')
<script src="{{ url('js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
    	jQuery.ajaxSetup({
    		headers: {
    			'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    		}
    	});
    	if(jQuery('.datepicker').length != 0){
    		md.initFormExtendedDatetimepickers();
    	}
    	jQuery("#vidyarthi_select").change(function (){
    		var uid = jQuery("#vidyarthi_select option:selected").val();
    		jQuery.post(
    			"{{ url('ajax') }}",
    			{
    				vidyarthidata: 1,
    				uid: uid,
    			},
    			function (response){
    				var response = JSON.parse(response);
    				if(response.status == 1){
    					jQuery(".card-profile.upid img").attr("src", response.user_dp);
    					jQuery(".card.vidyarthi_select_wrap #username").val(response.username);
    					jQuery(".card.vidyarthi_select_wrap #useremail").val(response.useremail);
    					jQuery(".card.vidyarthi_select_wrap #usermob").val(response.usermob);
    					jQuery(".card.vidyarthi_select_wrap #regdtp").val(response.regdtp);
    					jQuery(".card.vidyarthi_select_wrap #vi_postcode").val(response.vi_postcode);
    					jQuery(".card.vidyarthi_select_wrap #user_country_selected").val(response.user_country_selected);
    					jQuery(".card.vidyarthi_select_wrap #user_state_selected").val(response.user_state_selected);
    					jQuery(".card.vidyarthi_select_wrap #vi_hub").val(response.vi_hub);
    					jQuery(".card.vidyarthi_select_wrap #permanentaddress").val(response.permanentaddress);
    					jQuery(".card.vidyarthi_select_wrap #comments").html(response.comments);
    				}
    			}
    		);
    	});

    	jQuery(".rashidimg").click(function(){
    		jQuery(this).parent().find('input[type="file"]').trigger('click');
    	});

    	/*----image upload-----*/

    	function readURL(input){
    		if(input.files && input.files[0]){
    			var reader = new FileReader();
    			var file = input.files[0];
    			var img = new Image();
    			var sizeKB = file.size / 1024;
    			img.src = window.URL.createObjectURL( file );
    			reader.onload = function (e){
    				if(sizeKB <= 4194304){
    					jQuery(input).parent().parent().parent().find('.rashidimg').attr('src', e.target.result);
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
    			case 'bmp': case 'jpg': case 'jpeg': case 'png':
    				readURL(this);
    				break;
    			default:
    				jQuery(this).val('');
    				alert("Not an Image format, Accepted formats are .jpg, .bmp & .png.");
    				break;
    		}
    	});


           jQuery("#state_select").change(function (){
               var state_id = jQuery(".edithawan_form_inn #state_select option:selected").attr("data-cid");
               jQuery.post("{{ url('ajax') }}", {getdistricts: 1, state_id: state_id}, function (response){
    			var response = JSON.parse(response);
    			if(response.status == 1){
    				jQuery("#district_select").html(response.optionhtml);
    				jQuery(".district_select.selectpicker").selectpicker("refresh");
    			}
    		});
           });

    	jQuery("#country_select").change(function (){
    		var country_id = jQuery("#country_select option:selected").attr("data-cid");
    		jQuery.post("{{ url('ajax') }}", {getstates: 1, country_id: country_id}, function (response){
    			var response = JSON.parse(response);
    			if(response.status == 1){
    				jQuery("#state_select").html(response.optionhtml);
    				jQuery(".state_select.selectpicker").selectpicker("refresh");
    			}
    		});
    	});

    	jQuery("#hawan_orgniser_country").change(function (){
    		var country_id = jQuery("#hawan_orgniser_country option:selected").attr("data-cid");
    		jQuery.post("{{ url('ajax') }}", {getstates: 1, country_id: country_id}, function (response){
    			var response = JSON.parse(response);
    			if(response.status == 1){
    				jQuery("#hawan_orgniser_state").html(response.optionhtml);
    				jQuery(".hawan_orgniser_state.selectpicker").selectpicker("refresh");
    			}
    		});
    	});

    	jQuery(".inputFileHidden").change(function (){
    		var names = "";
    		for (var i = 0; i < jQuery(this).get(0).files.length; ++i){
    			if(i < jQuery(this).get(0).files.length - 1){
    				names += jQuery(this).get(0).files.item(i).name + ",";
    			} else {
    				names += jQuery(this).get(0).files.item(i).name;
    			}
    		}
    		jQuery(this).siblings(".img_upload").find(".inputFileVisible").val(names);
    	});

    	jQuery("#newserved").change(function (){
    		var newserved = parseInt(jQuery("#newserved option:selected").val());
    		if(newserved == 1){
    			jQuery(this).parent().parent().parent().attr("class","col-md-3");
    			jQuery(this).parent().parent().parent().parent().find(".serwedqtywrap").show();
    		}else{
    			jQuery(this).parent().parent().parent().attr("class","col-md-6");
    			jQuery(this).parent().parent().parent().parent().find(".serwedqtywrap").hide();
    		}
    	});

    	jQuery("#newpatrika").change(function (){
    		var newpatrika = parseInt(jQuery("#newpatrika option:selected").val());
    		if(newpatrika == 1){
    			jQuery(this).parent().parent().parent().attr("class","col-md-3");
    			jQuery(this).parent().parent().parent().parent().find(".newpatrikaqtywrap").show();
    		}else{
    			jQuery(this).parent().parent().parent().attr("class","col-md-6");
    			jQuery(this).parent().parent().parent().parent().find(".newpatrikaqtywrap").hide();
    		}
    	});

    	jQuery("#newakshaypatra").change(function (){
    		var newakshaypatra = parseInt(jQuery("#newakshaypatra option:selected").val());
    		if(newakshaypatra == 1){
    			jQuery(this).parent().parent().parent().attr("class","col-md-3");
    			jQuery(this).parent().parent().parent().parent().find(".newakshaypatraqtywrap").show();
    		}else{
    			jQuery(this).parent().parent().parent().attr("class","col-md-6");
    			jQuery(this).parent().parent().parent().parent().find(".newakshaypatraqtywrap").hide();
    		}
    	});

    	jQuery(".updatehawanbtn").click(function (){
    		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    		jQuery(".error").remove();
    		var uid = jQuery("#vidyarthi_select option:selected").val();
    		var rashidcode = jQuery("#rashidcode").val();
    		var rashidnumber = jQuery("#rashidnumber").val();
    		var yazmanname = jQuery("#yazmanname").val();
    		var fatherhusband = jQuery("#fatherhusband").val();
    		var dateofhawan = jQuery("#dateofhawan").val();
    		var postcode = jQuery("#postcode").val();
    		var country_select = jQuery("#country_select option:selected").val();
    		var hub_select = jQuery("#hub_select option:selected").val();
    		var state_select = jQuery("#state_select option:selected").val();
    		var distric = jQuery("#district_select option:selected").val();
    		var yazmanvillage = jQuery("#yazmanvillage").val();
            var yazmanpostoffice = jQuery("#yazmanpostoffice").val();
    		var yazman_ward_house_num = jQuery("#yazman_ward_house_num").val();
    		var yazman_whatsapp_num = jQuery("#yazman_whatsapp_num").val();
    		var yazman_other_num = jQuery("#yazman_other_num").val();
    		var swamiji_seva_amt = jQuery("#swamiji_seva_amt").val();
    		var swamiji_general_seva_amt = jQuery("#swamiji_general_seva_amt").val();
    		var swamiji_other_seva_amt = jQuery("#swamiji_other_seva_amt").val();
    		var ashram_amt_paid_status = jQuery("#ashram_amt_paid_status option:selected").val();
    		var ashram_amt_payment_mode = jQuery("#ashram_amt_payment_mode option:selected").val();
    		var vidyarthi_seva_amt = jQuery("#vidyarthi_seva_amt").val();
    		var travell_seva_amt = jQuery("#travell_seva_amt").val();
    		var vidyarthi_other_seva_amt = jQuery("#vidyarthi_other_seva_amt").val();
    		var rashid_img = jQuery("#rashid_img")[0].files[0];
    		var purposeofhawan = jQuery("#purposeofhawan").val();
    		var satsang = parseInt(jQuery("#satsang option:selected").val());
               var newserved = parseInt(jQuery("#newserved option:selected").val());
               var serwedqty = jQuery("#serwedqty").val();
               var newpatrika = parseInt(jQuery("#newpatrika option:selected").val());
    		var newpatrikaqty = jQuery("#newpatrikaqty").val();
               var newakshaypatra = parseInt(jQuery("#newakshaypatra option:selected").val());
    		var newakshaypatraqty = jQuery("#newakshaypatraqty").val();
               var newupdesh = parseInt(jQuery("#newupdesh").val());
               var peopleattendedhawan = parseInt(jQuery("#peopleattendedhawan").val());
               var hawancomments = jQuery("#hawancomments").val();
    		if(rashidcode == ""){
                   jQuery("#rashidcode").after("<div class='error'>Rashid code is required!</div>");
                   jQuery("#rashidcode").focus();
                   return false;
               }
    		if(rashidnumber == ""){
    			jQuery("#rashidnumber").after("<div class='error'>Rashid number is required!</div>");
    			jQuery("#rashidnumber").focus();
    			return false;
    		}
    		if(!jQuery.isNumeric(rashidnumber)){
    			jQuery("#rashidnumber").after("<p class='error'>Number only!</p>");
    			jQuery("#rashidnumber").focus();
    			return false;
    		}
    		if(yazmanname == ""){
    			jQuery("#yazmanname").after("<div class='error'>Yazman name is required!</div>");
    			jQuery("#yazmanname").focus();
    			return false;
    		}
    		if(dateofhawan == ""){
    			jQuery("#dateofhawan").after("<div class='error'>Date of hawan is required!</div>");
    			jQuery("#dateofhawan").focus();
    			return false;
    		}
            if(postcode != ""){
                if(!jQuery.isNumeric(postcode)){
                    jQuery(".postcode").after("<p class='error'>Number only!</p>");
                    jQuery("#postcode").focus();
                    return false;
                }
            }
    		if(distric == ""){
    			jQuery("#district_select").after("<div class='error'>District is required!</div>");
    			jQuery("#district_select").focus();
    			return false;
    		}
    		if(yazmanvillage == ""){
                   jQuery("#yazmanvillage").after("<div class='error'>Village is required!</div>");
                   jQuery("#yazmanvillage").focus();
                   return false;
               }
    		if(jQuery.isNumeric(yazmanvillage)){
                   jQuery("#yazmanvillage").after("<div class='error nomobie'>Only alphbets!</div>");
                   jQuery("#yazmanvillage").focus();
                   return false;
               }
    		if(yazmanpostoffice == ""){
                   jQuery("#yazmanpostoffice").after("<div class='error'>Post office is required!</div>");
                   jQuery("#yazmanpostoffice").focus();
                   return false;
               }
    		if(jQuery.isNumeric(yazmanpostoffice)){
                   jQuery("#yazmanpostoffice").after("<div class='error nomobie'>Only alphbets!</div>");
                   jQuery("#yazmanpostoffice").focus();
                   return false;
               }
    		if(yazman_ward_house_num == ""){
    			jQuery("#yazman_ward_house_num").after("<div class='error'>Ward / House humber is required!</div>");
    			jQuery("#yazman_ward_house_num").focus();
    			return false;
    		}
    		if(yazman_whatsapp_num != ""){
    			if(!jQuery.isNumeric(yazman_whatsapp_num)){
    				jQuery("#yazman_whatsapp_num").after("<div class='error nomobie'>Mobile number can't contain alphbets & special characters!</div>");
    				jQuery("#yazman_whatsapp_num").focus();
    			}
    		}
    		if(yazman_other_num != ""){
    			if(!jQuery.isNumeric(yazman_other_num)){
    				jQuery("#yazman_other_num").after("<div class='error nomobie'>Mobile number can't contain alphbets & special characters!</div>");
    				jQuery("#yazman_other_num").focus();
    			}
    		}
    		if(swamiji_seva_amt == ""){
    			jQuery("#swamiji_seva_amt").after("<div class='error'>Rashi is required!</div>");
    			jQuery("#swamiji_seva_amt").focus();
    			return false;
    		}
    		if(!jQuery.isNumeric(swamiji_seva_amt)){
    			jQuery("#swamiji_seva_amt").after("<div class='error nomobie'>Amount can't contain alphbets & special characters!</div>");
    			jQuery("#swamiji_seva_amt").focus();
    			return false;
    		}
    		if(swamiji_general_seva_amt == ""){
    			jQuery("#swamiji_general_seva_amt").after("<div class='error'>Rashi is required!</div>");
    			jQuery("#swamiji_general_seva_amt").focus();
    			return false;
    		}
    		if(!jQuery.isNumeric(swamiji_general_seva_amt)){
    			jQuery("#swamiji_general_seva_amt").after("<div class='error nomobie'>Amount can't contain alphbets & special characters!</div>");
    			jQuery("#swamiji_general_seva_amt").focus();
    			return false;
    		}
    		if(swamiji_other_seva_amt == ""){
    			jQuery("#swamiji_other_seva_amt").after("<div class='error'>Rashi is required!</div>");
    			jQuery("#swamiji_other_seva_amt").focus();
    			return false;
    		}
    		if(!jQuery.isNumeric(swamiji_other_seva_amt)){
    			jQuery("#swamiji_other_seva_amt").after("<div class='error nomobie'>Amount can't contain alphbets & special characters!</div>");
    			jQuery("#swamiji_other_seva_amt").focus();
    			return false;
    		}
    		if(vidyarthi_seva_amt == ""){
    			jQuery("#vidyarthi_seva_amt").after("<div class='error'>Rashi is required!</div>");
    			jQuery("#vidyarthi_seva_amt").focus();
    			return false;
    		}
    		if(!jQuery.isNumeric(vidyarthi_seva_amt)){
    			jQuery("#vidyarthi_seva_amt").after("<div class='error nomobie'>Amount can't contain alphbets & special characters!</div>");
    			jQuery("#vidyarthi_seva_amt").focus();
    			return false;
    		}
    		if(travell_seva_amt == ""){
    			jQuery("#travell_seva_amt").after("<div class='error'>Rashi is required!</div>");
    			jQuery("#travell_seva_amt").focus();
    			return false;
    		}
    		if(!jQuery.isNumeric(travell_seva_amt)){
    			jQuery("#travell_seva_amt").after("<div class='error nomobie'>Amount can't contain alphbets & special characters!</div>");
    			jQuery("#travell_seva_amt").focus();
    			return false;
    		}
    		if(vidyarthi_other_seva_amt == ""){
    			jQuery("#vidyarthi_other_seva_amt").after("<div class='error'>Rashi is required!</div>");
    			jQuery("#vidyarthi_other_seva_amt").focus();
    			return false;
    		}
    		if(!jQuery.isNumeric(vidyarthi_other_seva_amt)){
    			jQuery("#vidyarthi_other_seva_amt").after("<div class='error nomobie'>Amount can't contain alphbets & special characters!</div>");
    			jQuery("#vidyarthi_other_seva_amt").focus();
    			return false;
    		}
    		if(typeof rashid_img == "undefined"){
    			rashid_img = "";
    			ext = "";
    		}else{  
    			var ext = rashiddefined") {
    			rashid_img = "";
    			ext = "";
    		}else{  
    			var ext = rashid_img.name.split('.').pop().toLowerCase(); 
    			var allowedimgs = ['jpg', 'jpeg', 'png', 'bmp'];
    			var imgindex = jQuery.inArray(ext, allowedimgs, 0);
    			if (imgindex == -1) {
    				jQuery("#rashid_img").after("<div class='error'>Please select jpg, jpeg, png, bmp file!</div>");
    				return false;
    			}
    		}
    		if(newserved == 1){
    			if(serwedqty == ""){
    				jQuery("#serwedqty").after("<div class='error'>QTY is required!</div>");
    				jQuery("#serwedqty").focus();
    				return false;
    			}
    			if(!jQuery.isNumeric(serwedqty)){
    				jQuery("#serwedqty").after("<div class='error nomobie'>Number Only!</div>");
    				jQuery("#serwedqty").focus();
    				return false;
    			}else{
    				serwedqty = serwedqty;
    			}
    		}else{
    			serwedqty = serwedqty;
    		}
    		if(newpatrika == 1){
    			if(newpatrikaqty == ""){
    				jQuery("#newpatrikaqty").after("<div class='error'>QTY is required!</div>");
    				jQuery("#newpatrikaqty").focus();
    				return false;
    			}
    			if (!jQuery.isNumeric(newpatrikaqty)){
    				jQuery("#newpatrikaqty").after("<div class='error nomobie'>Number Only!</div>");
    				jQuery("#newpatrikaqty").focus();
    				return false;
    			}else{
    				newpatrikaqty = newpatrikaqty;
    			}
    		}else{
    			newpatrikaqty = newpatrikaqty;
    		}
    		if(newakshaypatra == 1){
    			if (newakshaypatraqty == "") {
    				jQuery("#newakshaypatraqty").after("<div class='error'>QTY is required!</div>");
    				jQuery("#newakshaypatraqty").focus();
    				return false;
    			}
    			if (!jQuery.isNumeric(newakshaypatraqty)){
    				jQuery("#newakshaypatraqty").after("<div class='error nomobie'>Number Only!</div>");
    				jQuery("#newakshaypatraqty").focus();
    				return false;
    			}else{
    				newakshaypatraqty = newakshaypatraqty;
    			}
    		}else{
    			newakshaypatraqty = newakshaypatraqty;
    		}
    		if (hawancomments == "") {
    			jQuery("#hawancomments").after("<div class='error'>Hawan comments is required!</div>");
    			jQuery("#hawancomments").focus();
    			return false;
    		}
    		var updatehawandata = new FormData();
    		updatehawandata.append('updatehawan', 1);
    		updatehawandata.append("uid", uid);
    		updatehawandata.append('hawan_id', {{ $data->hawandata->ID }});
    		updatehawandata.append("rashid_code", rashidcode);
    		updatehawandata.append("rashidnumber", rashidnumber);
    		updatehawandata.append("yazmanname", yazmanname);
    		updatehawandata.append("fatherhusband", fatherhusband);
    		updatehawandata.append("dateofhawan", dateofhawan);
    		updatehawandata.append("postcode", postcode);
    		updatehawandata.append("country_select", country_select);
    		updatehawandata.append("hub_select", hub_select);
    		updatehawandata.append("state_select", state_select);
    		updatehawandata.append("distric", distric);
    		updatehawandata.append("yazmanvillage", yazmanvillage);
               updatehawandata.append("yazmanpostoffice", yazmanpostoffice);
    		updatehawandata.append("yazman_ward_house_num", yazman_ward_house_num);
    		updatehawandata.append("yazman_whatsapp_num", yazman_whatsapp_num);
    		updatehawandata.append("yazman_other_num", yazman_other_num);
    		updatehawandata.append("swamiji_seva_amt", swamiji_seva_amt);
    		updatehawandata.append("swamiji_general_seva_amt", swamiji_general_seva_amt);
    		updatehawandata.append("swamiji_other_seva_amt", swamiji_other_seva_amt);
    		updatehawandata.append("ashram_amt_paid_status", ashram_amt_paid_status);
               updatehawandata.append("ashram_amt_payment_mode", ashram_amt_payment_mode);
    		updatehawandata.append("vidyarthi_seva_amt", vidyarthi_seva_amt);
    		updatehawandata.append("travell_seva_amt", travell_seva_amt);
    		updatehawandata.append("vidyarthi_other_seva_amt", vidyarthi_other_seva_amt);
    		updatehawandata.append('rashid_img', rashid_img);
    		updatehawandata.append('rashid_img_ext', ext);
    		updatehawandata.append("purposeofhawan", purposeofhawan);
    		updatehawandata.append("satsang", satsang);
               updatehawandata.append("newserved", newserved);
               updatehawandata.append("serwedqty", serwedqty);
               updatehawandata.append("newpatrika", newpatrika);
               updatehawandata.append("newpatrikaqty", newpatrikaqty);
               updatehawandata.append("newakshaypatra", newakshaypatra);
               updatehawandata.append("newakshaypatraqty", newakshaypatraqty);
               updatehawandata.append("newupdesh", newupdesh);
               updatehawandata.append("peopleattendedhawan", peopleattendedhawan);
    		updatehawandata.append("hawancomments", hawancomments);
    		Swal.fire({
    			title: 'Are you sure?',
    			text: "Update hawan data, you won't be able to revert this!",
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
    					data: updatehawandata,
    					cache: false,
    					contentType: false,
    					processData: false,
    					success: function(response) {
    						var response = JSON.parse(response);
    						jQuery(".updatehawanbtn").html("Update");
    						if (response.status == 1) {
    							Swal.fire('Successful', 'Hawan data has been successfully updated.','success').then((result) => {
    								window.location.href = "{{ url()->current() }}";
    							});
    						}else{
    							Swal.fire({
    								icon: 'error',
    								title: 'Oops...',
    								text: 'A hawan already exists with this Rashid number!'
    							}).then((result) => {
    								jQuery("#rashidnumber").after("<div class='error'>A hawan already exists with this Rashid number.</div>");
    								jQuery(".updatehawanbtn").html("Update");
    							});
    						}
    					},
    					error: function() {
    						Swal.fire({
    							icon: 'error',
    							title: 'Oops...',
    							text: 'Something went wrong!'
    						}).then((result) => {
    							jQuery(".updatehawanbtn").html("Update");
    						});
    					}
    				});
    			}
    		});
    	});
    });
</script>
@stop @include('common.footer')

@extends('admin.template.base')

@section('title', 'Employee Registration')

@section('styles')
    <style>
        .col-form-label{
            padding-right: 0px;
        }
    </style>
@endsection

@section('content')
<div class="main-panel">
        <div class="content-wrapper">
            <div class="row">                    
                <div class="col-12 grid-margin">
                    <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Register New Employee</h4>
                        <form class="form-sample" id="myForm" action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                        <p class="card-description"> Personal info </p>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="first_name" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="last_name" />
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Employee Code</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" required name="emp_code" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Job Position</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" required name="position" />
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Father Name</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="father_name" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date of Birth</label>
                                <div class="col-sm-9">
                                <input type="date" class="form-control" required name="DOB" placeholder="dd/mm/yyyy" />
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Gender</label>
                                <div class="col-sm-9">
                                <select class="form-control" required name="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Profile Image</label>
                                <div class="col-sm-9">
                                <input type="file" class="form-control" id="profile_photo" required name="profile_photo" />
                                </div>
                            </div>
                            </div>
                        </div>

                        <p class="card-description"> Contact </p>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Personal Email</label>
                                <div class="col-sm-9">
                                <input type="email" class="form-control" required name="personal_email" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Company Email</label>
                                <div class="col-sm-9">
                                <input type="email" class="form-control" required name="company_email" />
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Personal Mobile</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="personal_mobile" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Company Mobile</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="company_mobile" />
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <p class="card-description"> Address </p>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Current Address</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="current_add" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Permanent Address</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="permanent_add" />
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Pincode</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="pincode" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">City</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="city" />
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">State</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="state" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Country</label>
                                <div class="col-sm-9">
                                <select class="form-control" required name="country">
                                    <option value="India">India</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="America">America</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Russia">Russia</option>
                                    <option value="Britain">Britain</option>
                                </select>
                                </div>
                            </div>
                            </div>
                        </div>
                        <p class="card-description"> Account Details </p>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sallary</label>
                                <div class="col-sm-9">
                                <input type="number" class="form-control" required name="sallary" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Bank Name</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="bank_name" />
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Account Number</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="acc_no" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">IFSC Code</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="ifsc" />
                                </div>
                            </div>
                            </div>
                        <button type="submit" id="submit_btn" class="btn btn-primary mr-2">Register</button>
                        <div id="alertMSG" style="font-size: 12px; padding: 2px; display: none">&nbsp;</div>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>    
        jQuery(document).ready(function(){
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery('#myForm').on('submit', function(e){
                e.preventDefault();
                var btn  = jQuery('#submit_btn');
                var msg  = $('#alertMSG');
                var form = new FormData(this);
                let files = jQuery('#profile_photo');
                form.append('files', files);
                var url = '/admin/new-emp-registration';
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    data: form,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend:function(){
                        btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Submiting");
                    },
                    success: function(data) {
                        if (data.status=='1') {
                            // Ajax call completed successfully
                            // alert(data.msg);
                            msg.show().html(data.msg).css('color', 'green');
                            jQuery('#myForm').trigger('reset');
                            btn.html("Submit");
                            setTimeout(() => {
                                jQuery(msg).html('&nbsp;');
                            },3500);
                        } else {
                            // alert(data.msg);
                            msg.show().html(data.msg).css('color', 'red');
                            btn.html("Submit");
                        }
                    },
                    error: function(data) {
                        // Some error in ajax call
                        // alert("some Error");
                        msg.show().html("some Error").css('color', 'red');
                        btn.html("Submit");
                    }
                });  
            });
        });
    </script>

    <!-- <script>
        jQuery(document).ready(function(){
            jQuery('#myForm').on('submit', function(e){
                e.preventDefault();
                var btn  = jQuery('#submit_btn')
                var form = jQuery(this);
                var url = '/admin/new-emp-registration';
                jQuery.ajax({
                    type: "get",
                    url: url,
                    data: form.serialize(),
                    beforeSend:function(){
                        btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Submiting");
                    },
                    success: function(data) {
                        if (data.status=='1') {
                            // Ajax call completed successfully
                            alert(data.msg);
                            form.trigger('reset');
                            btn.html("Submit");
                        } else {
                            alert(data.msg);
                            btn.html("Submit");
                        }
                    },
                    error: function(data) {
                        // Some error in ajax call
                        alert("some Error");
                        btn.html("Submit");
                    }
                }); 
            });
        });
    </script> -->
@endsection
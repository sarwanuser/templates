@extends('admin.template.base')

@section('title', 'Update Client')

@section('styles')
    <style>
        /* body{
            color: red !important;
        } */
    </style>
@endsection

@section('content')
<div class="main-panel">
        <div class="content-wrapper">
            <div class="row">                    
                <div class="col-12 grid-margin">
                    <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Client</h4>
                        <form class="form-sample" id="myForm" action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                            <!-- <p class="card-description"> Personal info </p> -->
                            <div class="row">
                                <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Client Name</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" required name="client_name" value="{{$client->client_name}}"/>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Start Date</label>
                                    <div class="col-sm-9">
                                    <input type="date" class="form-control" required name="start_date" value="{{$client->start_date}}"/>
                                    </div>
                                </div>
                                </div>
                            </div>
                            
                            <!-- <p class="card-description"> Contact </p> -->
                            <div class="row">
                                <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Contact Email</label>
                                    <div class="col-sm-9">
                                    <input type="email" class="form-control" required name="contact_email" value="{{$client->contact_email}}"/>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Contact Mobile</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" required name="contact_mobile" value="{{$client->contact_mobile}}"/>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Company Name</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" name="company_name" value="{{$client->company_name}}"/>
                                    </div>
                                </div>
                                </div>

                                <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Company Logo</label>
                                    <div class="col-sm-9">
                                    <input type="file" class="form-control" id="company_logo" name="profile_photo" />
                                    </div>
                                </div>
                                </div>
                            </div>
                            <button type="submit" id="submit_btn" class="btn btn-primary mr-2">Update</button>
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
                var url = '/admin/update-client-{{$client->id}}';
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    data: form,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend:function(){
                        btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Updating");
                    },
                    success: function(data) {
                        if (data.status=='1') {
                            // Ajax call completed successfully
                            // alert(data.msg);
                            msg.show().html(data.msg).css('color', 'green');
                            btn.html("Update");
                            setTimeout(() => {
                                jQuery(msg).html('&nbsp;');
                            },3500);
                        } else {
                            // alert(data.msg);
                            msg.show().html(data.msg).css('color', 'red');
                            btn.html("Update");
                        }
                    },
                    error: function(data) {
                        // Some error in ajax call
                        msg.show().html("some Error").css('color', 'red');
                        btn.html("Update");
                    }
                }); 
            });
        });
    </script>
@endsection
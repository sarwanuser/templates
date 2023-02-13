@extends('admin.template.base')

@section('title', 'Add New Projects')

@section('styles')
    <style>
        /* body{
            color: red !important;
        } */
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
                        <h4 class="card-title">Add New Project</h4>
                        <form class="form-sample" id="myForm" action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                        <!-- <p class="card-description"> Personal info </p> -->
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project Name</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="project_name" />
                                </div>
                            </div>
                            </div>
                            
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project Budget</label>
                                <div class="col-sm-9">
                                <input type="number" class="form-control" name="budget" />
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project URL</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="project_url" />
                                </div>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project Dev URL</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="project_dev_url" />
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <!-- <p class="card-description"> Contact </p> -->
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Select Client</label>
                                <div class="col-sm-9">
                                    <select class="form-control" required name="client">
                                        <option value="">-select</option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}">{{$client->client_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Select Emp</label>
                                <div class="col-sm-9">
                                <select class="form-control" required name="working_emp">
                                    <option value="">-select</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->emp_code}}">{{$employee->first_name}} {{$employee->last_name}}({{$employee->emp_code}})</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project Timeline</label>
                                <div class="col-sm-9">
                                <input type="number" class="form-control" required name="timeline" />
                                </div>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Payment Status</label>
                                <div class="col-sm-9">
                                <select class="form-control" required name="payment_status">
                                    <option value="PN">Pending</option>
                                    <option value="PR">Partial</option>
                                    <option value="DU">Due</option>
                                    <option value="OD">Over Due</option>
                                    <option value="DN">Done</option>
                                </select>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <button type="submit" id="submit_btn" class="btn btn-primary mr-2">Update</button>
                            <div id="alertMSG" style="font-size: 12px; padding: 2px; display: none">&nbsp;</div>
                        </div>
                        </form>
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
                var url = '/admin/add-new-project';
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    data: form,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend:function(){
                        btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Adding");
                    },
                    success: function(data) {
                        if (data.status=='1') {
                            // Ajax call completed successfully
                            // alert(data.msg);
                            msg.show().html(data.msg).css('color', 'green');
                            jQuery('#myForm').trigger('reset');
                            btn.html("Add");
                            setTimeout(() => {
                                jQuery(msg).html('&nbsp;');
                            },3500);
                        } else {
                            // alert(data.msg);
                            msg.show().html(data.msg).css('color', 'red');
                            btn.html("Add");
                        }
                    },
                    error: function(data) {
                        // Some error in ajax call
                        // alert("some Error");
                        msg.show().html("some Error").css('color', 'red');
                        btn.html("Add");
                    }
                });  
            });
        });
    </script>
@endsection
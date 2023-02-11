@extends('admin.template.base')

@section('title', 'Update Client')

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
                        <h4 class="card-title">Update Project</h4>
                        <form class="form-sample" id="myForm" action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                            <!-- <p class="card-description"> Personal info </p> -->
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project Name</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="project_name" value="{{$project->project_name}}" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Start Date</label>
                                <div class="col-sm-9">
                                <input type="date" class="form-control" name="start_date" value="{{$project->start_date}}" />
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <!-- <p class="card-description"> Contact </p> -->
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Project URL</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" required name="project_url" value="{{$project->project_url}}" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Project Dev URL</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" required name="project_dev_url" value="{{$project->project_dev_url}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Select Client</label>
                                <div class="col-sm-9">
                                    <select class="form-control" required name="client">
                                        <option value="">-select</option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}" @if($project->client==$client->id) selected @endif>{{$client->client_name}}</option>
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
                                        <option value="{{$employee->emp_code}}" @if($project->working_emp==$employee->emp_code) selected @endif>{{$employee->first_name}} {{$employee->last_name}}({{$employee->emp_code}})</option>
                                    @endforeach
                                </select>

                                <!-- <label class="col-sm-12">Select Emp
                                    <input mbsc-input id="demo-multiple-select-input" placeholder="Select Employees" data-dropdown="true" data-input-style="outline" data-label-style="stacked" data-tags="true"/>
                                    </label>
                                    <select class="form-control" id="demo-multiple-select" multiple>
                                    <option value="1">Books</option>
                                    <option value="2">Movies, Music & Games</option>
                                    <option value="3">Electronics & Computers</option>
                                    <option value="4">Home, Garden & Tools</option>
                                    <option value="5">Health & Beauty</option>
                                    <option value="6">Toys, Kids & Baby</option>
                                    <option value="7">Clothing & Jewelry</option>
                                    <option value="8">Sports & Outdoors</option>
                                </select> -->
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project Budget</label>
                                <div class="col-sm-9">
                                <input type="number" class="form-control" name="budget" value="{{$project->budget}}" />
                                </div>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project Timeline</label>
                                <div class="col-sm-9">
                                <input type="number" class="form-control" required name="timeline"  value="{{$project->timeline}}" />
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row">                            
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Payment Status</label>
                                <div class="col-sm-9">
                                <select class="form-control" required name="payment_status">
                                    <option value="PN" @if($project->payment_status=='PN') selected @endif>Pending</option>
                                    <option value="PR" @if($project->payment_status=='PR') selected @endif>Partial</option>
                                    <option value="DU" @if($project->payment_status=='DU') selected @endif>Due</option>
                                    <option value="OD" @if($project->payment_status=='OD') selected @endif>Over Due</option>
                                    <option value="DN" @if($project->payment_status=='DN') selected @endif>Done</option>
                                </select>
                                </div>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" required name="status">
                                        <option value="ST" @if($project->status=='ST') selected @endif>Started</option>
                                        <option value="PL" @if($project->status=='PL') selected @endif>Planning</option>
                                        <option value="DV" @if($project->status=='DV') selected @endif>Developmemt</option>
                                        <option value="SG" @if($project->status=='SG') selected @endif>Staging</option>
                                        <option value="TS" @if($project->status=='TS') selected @endif>Testing</option>
                                        <option value="LV" @if($project->status=='LV') selected @endif>Live</option>
                                        <option value="DN" @if($project->status=='DN') selected @endif>Done</option>
                                        <option value="RW" @if($project->status=='RW') selected @endif>Re-Work</option>
                                        <option value="RT" @if($project->status=='RT') selected @endif>Re-Testing</option>
                                        <option value="PR" @if($project->status=='PR') selected @endif>Process</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- <p class="card-description"> Contact </p> -->
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Target Status</label>
                                <div class="col-sm-9">
                                <select class="form-control" required name="target_status">
                                    <option value="FN" @if($project->target_status=='FN') selected @endif>Fine</option>
                                    <option value="WR" @if($project->target_status=='WR') selected @endif>Worning</option>
                                    <option value="OD" @if($project->target_status=='ST') selected @endif>Over-Due</option>
                                </select>
                                </div>
                            </div>
                            </div>

                            
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">End Date</label>
                                <div class="col-sm-9">
                                <input type="date" class="form-control" value="{{$project->end_date}}" readonly style="background-color: #4b5564;" />
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Last Status Change</label>
                                <div class="col-sm-9">
                                <input type="date" class="form-control" @if(!empty($project->status_change_date)) value="{{date('Y-m-d', strtotime($project->status_change_date))}}"" @endif readonly style="background-color: #4b5564;" />
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row">
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
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<link href="../admin/assets/select-multiple/css/mobiscroll.jquery.min.css" rel="stylesheet" />
<script src="/admin/assets/select-multiple/js/mobiscroll.jquery.min.js"></script>
    <script>    
        mobiscroll.setOptions({
        theme: 'ios',
        themeVariant: 'light'
        });

        $(function () {
            $('#demo-multiple-select').mobiscroll().select({
                inputElement: document.getElementById('demo-multiple-select-input')
            });
        });

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
                var url = '/admin/update-project-{{$project->id}}';
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
@extends('admin.template.base')

@section('title', 'Update Team Member')

@section('styles')
    <style>
        /* body{
            color: red !important;
        } */
        .col-form-label{
            padding-right: 0px;
        }
        .rounded-circle{
            height: 50px;
            width: 50px;
        }
    </style>
@endsection

@section('content')
<div class="main-panel">
        <div class="content-wrapper">
            <div class="row">                    
                <div class="col-12 grid-margin">
                    <a href="/admin/all-team"><i class="mdi mdi-keyboard-backspace" style="font-size: 25px;"></i></a>
                    <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Team Member</h4>
                        <form class="form-sample" id="myForm" action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                        <!-- <p class="card-description"> Personal info </p> -->
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="mbr_name" value="{{$team->mbr_name}}" />
                                </div>
                            </div>
                            </div>
                            
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Designation</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" name="mbr_designation" value="{{$team->mbr_designation}}" />
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Facebook URL</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="fcb_url" value="{{$team->fcb_url}}"/>
                                </div>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Twitter URL</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="twr_url" value="{{$team->twr_url}}" />
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Linkedin URL</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="lnkd_url" value="{{$team->lnkd_url}}" />
                                </div>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Profile Pic</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-md-8 col-lg-8 col-sm-8">
                                            <input type="file" class="form-control" id="company_logo" name="profile_photo" />
                                        </div>
                                        <div class="col-md col-lg col-sm">
                                            @if(!empty($team->profile_photo))
                                                <img class="img-lg rounded-circle" src="../images/teams/{{$team->profile_photo}}" alt="profile photo">
                                            @else
                                                <img class="img-lg rounded-circle" src="{{ URL::asset('images/teams/default/user.jpg')}}" alt="profile photo">
                                            @endif
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea name="description" id="" cols="38" rows="3"  class="form-control" required>{{$team->description}}</textarea>
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
                var url = '/admin/update-team-{{$team->id}}';
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
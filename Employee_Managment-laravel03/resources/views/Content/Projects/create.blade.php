@extends('admin.template.base')

@section('title', 'Add New Projects')

@section('styles')
    <style>
        /* body{
            color: red !important;
        } */
        .mdi-plus{
            cursor: pointer;
            color: green;
            padding: 1px 3px !important;
        }
        .mdi-delete-forever{
            cursor: pointer;
            color: red;
            padding: 1px 3px !important;
            margin-left: 5px !important;
        }
    </style>
@endsection

@section('content')
<div class="main-panel">
        <div class="content-wrapper">
            <div class="row">                    
                <div class="col-12 grid-margin">
                    <a href="{{url('admin/allprojectsdetails')}}"><i class="mdi mdi-keyboard-backspace" style="font-size: 25px;"></i></a>
                    <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Projects</h4>
                        <form class="form-sample" id="myForm" action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                        <!-- <p class="card-description"> Personal info </p> -->
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project Title</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" required name="pr_main_title" />
                                </div>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Main Image</label>
                                <div class="col-sm-9">
                                <input type="file" class="form-control" id="profile_photo" name="pr_main_image" required accept=".jpg,.png"/>
                                </div>
                            </div>
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Project Description</label>
                                    <div class="col-sm-9">
                                        <textarea name="pr_main_description" id="" cols="38" rows="3"  class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-6">
                                <i class="mdi mdi-plus btn btn-success" title="Click for add new sub details"  onclick="addMore()"></i>
                            </div>
                        </div>

                        <div class="row table-responsive">
                            <table class="table">
                                <thead>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Descrption</th>
                                    <th>Images</th>
                                    <th>Action</th>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        <button type="submit" id="submit_btn" class="btn btn-primary mr-2">Add</button>
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
                var url = '/admin/addnewprojectsdetails';
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
                            jQuery('.rmbtr').remove();
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

	    var j =0;
		function addMore(){
            j++;
            jQuery('tbody').append(`
                                <tr class="rmbtr">
                                    <td>${j}</td>
                                    <td><input type="text" class="form-control" required name="pr_sub_title[]" /></td>
                                    <td><input type="text" class="form-control" required name="pr_sub_description[]" /></td>
                                    <td><input type="file" class="form-control" required id="company_logo" name="pr_sub_image[]"  accept=".jpg,.png" /></td>
                                    <td><i class="mdi mdi-plus btn btn-success" title="Click for add new sub details" onclick="addMore()"></i><i class="mdi mdi-delete-forever btn btn-danger"  title="Click for remove sub details"></i></td>
                                </tr>
                                `);
        }

        jQuery(document).on('click','.mdi-delete-forever',function(){
            jQuery(this).closest('tr').remove();
        });
    </script>
@endsection
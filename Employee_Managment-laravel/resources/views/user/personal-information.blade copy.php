@extends('user.template.base')

@section('title', 'Employee Personal Information')

@section('styles')
    <style>
        .valueDyn{
            color: green;
            padding-left: 3px;
        }
        input{
            background-color: black;
            color: green;
            border: none;
            border-bottom: 2px solid white !important;
            display: none;
        }
        .mdi-content-save{
            color: blue;
            display: none;
        }
    </style>
@endsection

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center;">
                        @if(!empty($employee->profile_photo))
                            <img class="img-lg rounded-circle" src="../images/employees/{{$employee->profile_photo}}" alt="Profile Pic">
                        @else
                            <img class="img-lg rounded-circle" src="../images/employees/user.jpg" alt="Profile Pic">
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center;">
                        @if(!empty($employee->profile_photo))
                            <img class="img-lg rounded-circle" src="../images/employees/{{$employee->profile_photo}}" alt="Profile Pic">
                        @else
                            <img class="img-lg rounded-circle" src="../images/employees/user.jpg" alt="Profile Pic">
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-sm-6">
                <div class="row">
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Name:                 <label class="valueDyn"> {{$employee->first_name}} {{$employee->last_name}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Employee Code:        <label class="valueDyn">{{$employee->emp_code}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Father Name:          <label class="valueDyn">{{$employee->father_name}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">DOB:                  <label class="valueDyn">{{date("d-m-Y", strtotime($employee->DOB))}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Personal Email:       <label class="valueDyn">{{$employee->personal_email}}</label>  <a href="#"><i class="mdi mdi-table-edit" style="color: red;"></i></a> <input type="email" bd_name="personal_email" id=""><a href="#"><i class="mdi mdi-content-save"></i></a> <br><label class='errorMassage'>&nbsp;</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Company Email:        <label class="valueDyn">{{$employee->company_email}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Personal Mobile:      <label class="valueDyn">{{$employee->personal_mobile}}</label> <a href="#"><i class="mdi mdi-table-edit" style="color: red;"></i></a> <input type="text" bd_name="personal_mobile" id=""><a href="#"><i class="mdi mdi-content-save"></i></a> <br><label class='errorMassage'>&nbsp;</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Company Mobile:       <label class="valueDyn">{{$employee->company_mobile}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Current Address:      <label class="valueDyn">{{$employee->current_add}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Permanent Address:    <label class="valueDyn">{{$employee->permanent_add}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Sallary:              <label class="valueDyn">{{$employee->sallary}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Bank Name:            <label class="valueDyn">{{$employee->bank_name}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">Acc. No :             <label class="valueDyn">{{$employee->acc_no}}</label></label>
                    <label class="col-6 col-sm-6 col-md-6 col-form-label">IFSC Code:            <label class="valueDyn">{{$employee->ifsc}}</label></label>
                </div>
            </div>   
        </div>
    <!-- content-wrapper ends -->
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            jQuery(document).on('click','.mdi-table-edit',function(){
                var btn = jQuery(this);
                btn.hide();
                var content = btn.closest('.col-form-label').find('.valueDyn').html();
                btn.closest('.col-form-label').find('.valueDyn').html('&nbsp;');
                btn.closest('.col-form-label').find('input').show().val(content).css('display', 'inline');
                btn.closest('.col-form-label').find('.mdi-content-save').show();
            });

            jQuery(document).on('click','.mdi-content-save',function(){
                var btn     =   jQuery(this);
                var val     =   btn.closest('.col-form-label').find('input').val();
                var bd_name =   btn.closest('.col-form-label').find('input').attr('bd_name');
                var msg     =   btn.closest('.col-form-label').find('.errorMassage');

                var url = '/update_emp_details';
                jQuery.ajax({
                    type: 'get',
                    url: url,
                    data : { val : val, bd_name : bd_name },
                    // beforeSend:function(){
                    //     btn.prepend("<i class='fa fa-circle-o-notch fa-spin'></i>");
                    // },
                    success: function(data) {
                        if (data.status=='1') {
                            // Ajax call completed successfully
                            btn.hide();
                            btn.closest('.col-form-label').find('.valueDyn').html(val);
                            btn.closest('.col-form-label').find('input').hide();
                            btn.closest('.col-form-label').find('.mdi-table-edit').show();
                            msg.html(data.msg).css('color', 'blue');
                            setTimeout(() => {
                                mgs.html('&nbsp;');
                            },5000);
                        } else {
                            msg.show().html(data.msg).css('color', 'red');
                        }
                    },
                    error: function(data) {
                        // Some error in ajax call
                        msg.html("some Error").css('color', 'red');
                    }
                });  
            });
        </script>
@endsection
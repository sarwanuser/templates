@extends('user.template.base')

@section('title', 'Employee Dashboard')

@section('styles')
<style>
    .fa-spin{
        color: blue;
    }
    small{
        font-weight: 100;
    }
    .punches{
        border: 1px solid white;
        border-radius: 30px;
        margin-top: 10px;
        padding: 5px 0px;
        text-align: center;
        background-color: #07134c;
    }
    .mdi-clock{
        color: blue;
    }
    .card{
        padding: 15px 15px !important;
        margin-top: 10px;
        min-height: 200px;
        text-align: center !important;
    }
    .puchHeading{
        /* color: yellow; */
    }
    .clockDIV{
        margin-top: 60px;
    }
    .progressbar{
        background-color: red;
        height: 100px;
        width: 100px;
        border-radius: 50%;
        padding-top: 40px;
        margin-left: 33%;
    }
</style>
@endsection

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-xl-4 col-md-4 col-sm-6">
                <!-- <i class="mdi mdi-clock"></i>  -->
                    @if(!$todayCheckedIn)
                        <button class="btn btn-primary" id="check-in">Check-In</button>
                        <button class="btn btn-primary" id="check-out" style="display: none;">Check-Out</button>
                    @else
                        <button class="btn btn-primary" id="check-out">Check-Out</button>    
                    @endif
                    <div id="ResMsg" style="font-size: 13px;">&nbsp;</div>

                    <div class="card">
                        @php $newdatet = date("D, d M Y"); @endphp
                        <h5 class="card-title">{{$newdatet}}</h5>
                        <div class="punches">
                            <p class="mb-0 puchHeading">Punch In Time</p>
                            @if($todayCheckedIn)
                                <small>{{date("h:i:s A", strtotime($todayCheckedIn->check_in))}}</small>
                            @else
                                <small id="checkInShow">Not Checked In !!</small>
                            @endif
                        </div>
                        
                        <div class="punches">
                            <p class="mb-0 puchHeading">Punch Out Time</p>
                            @if($todayCheckedOut)
                                <small>{{date("h:i:s A", strtotime($todayCheckedIn->check_out))}}</small>
                            @else
                                <small id="checkOutShow">Not Checked Out !!</small>
                            @endif
                    </div>
                    </div>


                    
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6">
                    <div class="card clockDIV">
                        <h5 class="card-title">Total Working Hours</h5>
                        <div class="punch-hours progressbar">
                            <span id="total_hours">00:00:00</span>
                        </div>
                    </div>
                </div>
            </div>
@endsection


@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script>
jQuery(document).ready(function(){
    jQuery('#check-in').on('click', function(){
        var btn  = jQuery(this);
        var msg  = jQuery('#ResMsg');
        var url = '/check-in';
        if(confirm('Are you sure for Check-In ?')){
            jQuery.ajax({
                type: "get",
                url: url,
                beforeSend:function(){
                    btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Check-In");
                },
                success: function(data) {
                    if (data.status=='1') {
                        // Ajax call completed successfully
                        msg.html(data.msg).css('color', 'green');
                        btn.html("Check-In");
                        btn.hide();
                        jQuery('#check-out').show();
                        jQuery('#checkInShow').html(data.time);
                        setTimeout(() => {
                            msg.html('&nbsp;');
                        },5000);
                    } else {
                        msg.html(data.msg).css('color', 'red');
                        btn.html("Check-In");
                    }
                },
                error: function(data) {
                    // Some error in ajax call
                    msg.html("Some error while Check-In").css('color', 'red');
                    btn.html("Check-In");
                }
            });
        } 
    });

    jQuery('#check-out').on('click', function(){
        var btn  = jQuery(this);
        var msg  = jQuery('#ResMsg');
        var url = '/check-out';
        if(confirm('Are you sure for Check-Out ?')){
            jQuery.ajax({
                type: "get",
                url: url,
                beforeSend:function(){
                    btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Check-Out");
                },
                success: function(data) {
                    if (data.status=='1') {
                        // Ajax call completed successfully
                        msg.html(data.msg).css('color', 'green');
                        btn.html("Check-Out");
                        jQuery('#checkOutShow').html(data.time);
                        setTimeout(() => {
                            msg.html('&nbsp;');
                        },5000);
                    } else {
                        msg.html(data.msg).css('color', 'red');
                        btn.html("Check-Out");
                    }
                },
                error: function(data) {
                    // Some error in ajax call
                    msg.html("Some error while Check-Out").css('color', 'red');
                    btn.html("Check-Out");
                }
            });
        } 
    });
});


function fetchdata(){
    $.ajax({
        url: '/getTimer',
        type: 'get',
        success: function(data){
            if (data.status=='1') {
                // Ajax call completed successfully
                // jQuery('#total_hours').html(data.checkIn);
                var checkIn = (data.checkIn);
                var current = new Date(); 
                var seconds = Math.floor((current - (new Date(checkIn)))/1000);
                
                var minutes = Math.floor(seconds/60);
                var hours = Math.floor(minutes/60);
                var days = Math.floor(hours/24);
                hours = hours-(days*24);
                minutes = minutes-(days*24*60)-(hours*60);
                seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);
                // statistics calculation
                if(hours <0)
                hours = 0;
                // var daytarget = (hours*60*100+minutes)/510;
                // jQuery('#set_target').css('width' ,daytarget+'%');
                
                if(seconds.toString().length == 1){
                    seconds = '0'+seconds;
                } if(minutes.toString().length == 1){
                    minutes = '0'+minutes;
                } if(hours.toString().length == 1){
                    hours = '0'+hours;
                }
                
                var finat_watch = hours + ":" +  minutes + ":" + seconds;
                jQuery('#total_hours').html(finat_watch);
            }
            if (data.status=='2') {
                jQuery('#total_hours').html(data.checkOut);
            }
        }
    });
}

$(document).ready(function(){
    setInterval(fetchdata,1000);
});
</script>
@endsection
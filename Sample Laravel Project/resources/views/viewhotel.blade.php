@extends('template.base')

@section('title', 'Ensober View Hotel')

@section('styles')
	
	<!-- Media Slider -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('asset/css/pages/advance-ui-media.css') }}">
	<!-- / Media Slider -->
	<style>
		.hotel_rating li {
			width: 30px;
			display: inline-block; 
		}
		.detal_1 {
			float: left;
			width: 75%;
		}
		.hotel_detail_main {
			float: left;
			width: 98%;
			margin-left: 15px;
			padding: 10px 20px 35px;
			border: 2px solid #7280ce;
		}
		b.hotel_name {
			font-size: 30px;
			color: #ff4081;
		}
		.hotel_detail_w60 {
			float: left;
			width: 100%;
		}
		.hotel_detail_w40 {
			float: left;
			width: 100%;
		}
		.hotel_rating {
			float: left;
			width: 100%;
		}
		ul.ho_contact_detail {
			float: left;
			width: 100%;
			margin: 0;
		}
		ul.ho_contact_detail li {
			display: inline-block;
			width: 100%;
			vertical-align: middle;
		}
		ul.ho_contact_detail li i {
			color: #ff4081;
			font-size: 28px;
			display: inline-block;
		}
		ul.ho_contact_detail li b {
			position: relative;
			display: inline-block;
			top: -10px;
			width:90%; 
		}
		b.tarif_text {
			float: left;
			width: 100%;
			border-bottom: 2px solid #7280ce;
			font-size: 20px;
			padding: 5px 0 7px;
			margin: 0 0 8px;
		}
		.price_text {
			font-size: 18px;
			color: #ff4081;
			font-weight: bold;
			margin-right: 4px;
		}
		.price_value {
			font-size: 23px;
			color: green;
			font-weight: bold;
			margin-right: 20px;
		}
		.date_text {
			font-size: 18px;
			font-weight: bold;
			color: #ff4081;
			float: left;
			width: 107px;
		}
		.date_val {
			float: left;
			width: 192px !important;
		}
		.select_date {
			float: left;
			width: 100%;
		}
		.price_main {
			float: left;
			width: 100%;
		}
		.hotel_left {
			float: left;
			width: 100%;
			padding-right: 15px;
			margin-right: 15px;
		}
		.hotel_amenities {
			float: left;
			width: 100%;
			margin: 20px 0 0;
		}
		.hotel_amenities li {
			font-size: 17px;
		}
		#main {
			padding-left: 0px !important;
		}
		.slider .slides {
			height: 400px !important;
		}
	</style>
@endsection

@section('content')
	<!-- BEGIN: Page Main-->
	<div id="main1">
      @if(isset($Hotel->id))
					<div class="row">
						
						<div class="hotel_detail_main">
							<div class="hotel_left">
							<div class="hotel_detail hotel_detail_w60">
								
								<div class="detal_1">
									<b class="hotel_name">{{ $Hotel->hotel_name}} </b>
									<div class="hotel_rating">
                                       <ul>
                                           @if($Hotel->start_category=="ONE") @php  $star=1; @endphp
                                           @elseif($Hotel->start_category=="TWO")  @php  $star=2; @endphp
                                           @elseif($Hotel->start_category=="THREE") @php  $star=3; @endphp
                                           @elseif($Hotel->start_category=="FOUR") @php  $star=4; @endphp
                                           @elseif($Hotel->start_category=="FIVE") @php  $star=5; @endphp  @endif 
										   @for($i = 0; $i < $star; $i++)
                                             <li><img src="{{ url('asset/images/icon/star.png') }}"/></li> 
										   @endfor
										</ul>
									</div>
									
									<ul class="ho_contact_detail">
										<li>
											<i class="material-icons">account_balance</i> 
											<b>{{$Hotel->address}}, {{$Hotel->city}}, {{$Hotel->region}}, {{$Hotel->country}}</b>
										</li>
									</ul>
								</div>
								<img src="/asset/images/logo/logo.png" style="float:right;" alt="logo">
							</div>
							<div class="hotel_gallery hotel_detail_w60" style="">
								<div class="slider1">
									<ul class="slides mt-2">
									  <li>
										<img src="{{ url('/storage/app/'.$Hotel->hotel_image) }}" alt="{{ $Hotel->hotel_name}}">
										<!-- random image -->
										<div class="caption center-align">
										  <h3 class="white-text">{{ $Hotel->hotel_name}}</h3>
										  <!--<h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>-->
										</div>
									  </li>
                                      @if($hotelgalleries)
                                        @foreach($hotelgalleries as $hotelgallery)
                                         <li>
                                        <img src="{{ url('/storage/app/'.$hotelgallery->image) }}" alt="{{ $Hotel->hotel_name}}">
                                        <!-- random image -->
                                        <div class="caption center-align">
                                          <h3 class="white-text">{{ $Hotel->hotel_name}}</h3>
                                          <!--<h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>-->
                                        </div>
                                      </li>
                                        @endforeach
                                      @endif
                  
									</ul>
								  </div>
							</div>
							</div>
							
							<div class="hotel_amenities hotel_detail_w40">
								<b class="tarif_text">Amenities: </b>
                                @if($hotelgalleries)
								<ul class="amenities_lest">
									@foreach($hotelamenity  as $h_amenity)
                                        <li>{{$h_amenity->name}}</li>
                                    @endforeach
								</ul>
                                @endif
							</div>
						</div>
					</div>
                @else
                 <div class="row">
                     <p> <strong>Sorry Hotel is not found.</strong></p>
                 </div>
                 @endif
    <!-- END: Page Main--> 
@endsection

@section('scripts')
	
	<!-- Media Slider -->
	<script src="{{ URL::asset('asset/js/scripts/advance-ui-media.js') }}" type="text/javascript"></script>
	<!-- / Media Slider -->
	
	<script>
		$(document).ready(function(){
			$('.slider').slider();
            
    $('#check_in_date, #room_type_id').change(function(){
        var room_type_id =  $('#room_type_id').val();
        var date = $('#check_in_date').val();
        var id = $('#check_in_date').attr('data-id');
        if(room_type_id !='' && date !=''){
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
     $("#loader-wrapper").css("display","block");       
     $.ajax({
    url: "ajaxGetSeasonRate",
    type:"post",
    cache: false,
    async:true,
    data: {'id':id, "date": date,'room_type_id':room_type_id},
    success: function(data){
      data = JSON.parse(data);
      if(data.status == true){
          $('#ep_price').html(data.hotelseasonrate.ep_price);
          $('#cp_price').html(data.hotelseasonrate.cp_price);
          $('#map_price').html(data.hotelseasonrate.map_price);
          $('#ap_price').html(data.hotelseasonrate.ap_price);
          $("#loader-wrapper").css("display","none");       
     
      }else{
          $('#ep_price').html('');
          $('#cp_price').html('');
          $('#map_price').html('');
          $('#ap_price').html('');
          $("#loader-wrapper").css("display","none");
          alert('Please select another date');
          
      }
    }
});
    }else{
        alert('Please select Room Type and Date');
    }
            });
		});
	</script>
@endsection
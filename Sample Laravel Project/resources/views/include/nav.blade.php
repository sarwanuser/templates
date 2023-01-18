   <!-- BEGIN: SideNav-->
    <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
      <div class="brand-sidebar">
        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="index.html"><img src="{{ URL::asset('asset/images/logo/logo.png') }}" alt="logo"/><span class="logo-text hide-on-med-and-down"></span></a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
      </div>
      <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
        <li class="active"><a class="collapsible-body active" href="{{URL::to('/admin/dashboard')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Dashboard</span></a>
        </li>
		
		<li class="navigation-header"><a class="navigation-header-text">Applications</a><i class="navigation-header-icon material-icons">more_horiz</i>
        </li>
		
		<!--<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">dvr</i><span class="menu-title" data-i18n="">Admin</span></a>
			<div class="collapsible-body">
				<ul class="collapsible" data-collapsible="accordion">
					<li><a class="collapsible-body" href="#" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Admin</span></a>
					</li>
					<li><a class="collapsible-body" href="#" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Admin</span></a>
					</li>
				</ul>
			</div>
        </li>-->
		
	 			<!-- Venders --> 
			<!--	<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">dvr</i><span class="menu-title" data-i18n="">Vendors</span></a>
					<div class="collapsible-body">
						<ul class="collapsible" data-collapsible="accordion">
							<li><a class="collapsible-body" href="{{URL::to('/admin/allvender')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Vendor</span></a>
							</li>
							<li><a class="collapsible-body" href="{{URL::to('/admin/addvender')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Vendon</span></a>
							</li>
						</ul>
					</div>
				</li>  -->
                
				<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">store</i><span class="menu-title" data-i18n="">View Vendors</span></a>
                    <div class="collapsible-body">
                        <ul class="collapsible" data-collapsible="accordion">
                            <li><a class="collapsible-body" href="{{URL::to('/admin/hotel')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Hotel Vendor</span></a>
                            </li>
                            <li><a class="collapsible-body" href="{{URL::to('/admin/hotel')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Activity Vendor</span></a> 
                            </li>
							
							<li><a class="collapsible-body" href="{{URL::to('/admin/hotel')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Transport Vendor</span></a> 
                            </li>
                        </ul>
                    </div>
                </li>
				
				
				<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">store</i><span class="menu-title" data-i18n="">Vendors</span></a>
                    <div class="collapsible-body">
                        <ul class="collapsible" data-collapsible="accordion">
							<!-- Add Vender -->
                            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">store</i><span class="menu-title" data-i18n="">Add Vendors</span></a>
								<div class="collapsible-body">
									<ul class="collapsible" data-collapsible="accordion">
										<li><a class="collapsible-body" href="{{URL::to('/admin/vender')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Vendor</span></a>
										</li>
										<li><a class="collapsible-body" href="{{URL::to('/admin/vender/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Vendor</span></a> 
										</li>
									</ul>
								</div>
							</li>
							
							<!-- Add Hotel -->
							<li class="bold">
								<a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">local_hotel</i><span class="menu-title" data-i18n="">Hotel</span></a>
								<div class="collapsible-body">
									<ul class="collapsible" data-collapsible="accordion">
										<li><a class="collapsible-body" href="{{URL::to('/admin/hotel')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Hotel</span></a>
										</li>
										<li><a class="collapsible-body" href="{{URL::to('/admin/hotel/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Hotels</span></a>
										</li>
									</ul>
								</div>
							</li>
							
							<!-- Htels Season Rate --> 
							<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">poll</i><span class="menu-title" data-i18n="">Hotel Season Rate</span></a>
								<div class="collapsible-body">
									<ul class="collapsible" data-collapsible="accordion">
										<li><a class="collapsible-body" href="{{URL::to('/admin/hotelseasonrate')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Rate</span></a>
										</li>
										<li><a class="collapsible-body" href="{{URL::to('/admin/hotelseasonrate/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Season Rate</span></a>
										</li>
									</ul>
								</div>
							</li>
							
							<!-- Htels Group Season Rate --> 
							<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">network_check</i><span class="menu-title" data-i18n="">Hotel Group S. Rate</span></a>
								<div class="collapsible-body">
									<ul class="collapsible" data-collapsible="accordion">
										<li><a class="collapsible-body" href="{{URL::to('/admin/hotelgroupseasonrate')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Group Rate</span></a>
										</li>
										<li><a class="collapsible-body" href="{{URL::to('/admin/hotelgroupseasonrate/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Group S. Rate</span></a>
										</li>
									</ul>
								</div>
							</li>
							
							
							<!-- Cars --> 
							<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">drive_eta</i><span class="menu-title" data-i18n="">Cars</span></a>
								<div class="collapsible-body">
									<ul class="collapsible" data-collapsible="accordion">
										<li><a class="collapsible-body" href="{{URL::to('/admin/car')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Cars</span></a>
										</li>
										<li><a class="collapsible-body" href="{{URL::to('/admin/car/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Car</span></a>
										</li>
									</ul>
								</div>
							</li>
							
							
							<!-- Transport --> 
							<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">local_car_wash</i><span class="menu-title" data-i18n="">Transport</span></a>
								<div class="collapsible-body">
									<ul class="collapsible" data-collapsible="accordion">
										<li><a class="collapsible-body" href="{{URL::to('/admin/transport')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Transports</span></a>
										</li>
										<li><a class="collapsible-body" href="{{URL::to('/admin/transport/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Transport</span></a>
										</li>
									</ul>
								</div>
							</li>
							
							<!-- Add Amenities --> 
							<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">streetview</i><span class="menu-title" data-i18n="">Add Amenities</span></a>
								<div class="collapsible-body">
									<ul class="collapsible" data-collapsible="accordion">
										<li><a class="collapsible-body" href="{{URL::to('/admin/amenity')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Amenities</span></a>
										</li>
										<li><a class="collapsible-body" href="{{URL::to('/admin/amenity/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Amenities</span></a>
										</li>
									</ul>
								</div>
							</li>
							
							
							<!-- Activities --> 
							<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">hot_tub</i><span class="menu-title" data-i18n="">Activities Items</span></a>
								<div class="collapsible-body">
									<ul class="collapsible" data-collapsible="accordion">
									
									<!-- Activity Cats --> 
									<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">loupe</i><span class="menu-title" data-i18n="">Activity Cats</span></a>
										<div class="collapsible-body">
											<ul class="collapsible" data-collapsible="accordion">
												<li><a class="collapsible-body" href="{{URL::to('/admin/activitycat')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Activity Cats</span></a> 
												</li>
												<li><a class="collapsible-body" href="{{URL::to('/admin/activitycat/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Activity Cat</span></a>
												</li>
											</ul>
										</div>
									</li>
									
									<!-- Activity Names --> 
									<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">loupe</i><span class="menu-title" data-i18n="">Activity Names</span></a>
										<div class="collapsible-body">
											<ul class="collapsible" data-collapsible="accordion">
												<li><a class="collapsible-body" href="{{URL::to('/admin/activityname')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Activity Names</span></a> 
												</li>
												<li><a class="collapsible-body" href="{{URL::to('/admin/activityname/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Activity Name</span></a>
												</li>
											</ul>
										</div>
									</li>
									
									<!-- Activity Subcats --> 
									<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">loupe</i><span class="menu-title" data-i18n="">Activity Subcats</span></a>
										<div class="collapsible-body">
											<ul class="collapsible" data-collapsible="accordion">
												<li><a class="collapsible-body" href="{{URL::to('/admin/activitysubcat')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Activity Subcats</span></a> 
												</li>
												<li><a class="collapsible-body" href="{{URL::to('/admin/activitysubcat/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Activity Subcat</span></a>
												</li>
											</ul>
										</div>
									</li>
									</ul>
								</div>
							</li>
							
							<!-- Add Activities --> 
							<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">pool</i><span class="menu-title" data-i18n="">Activities</span></a>
								<div class="collapsible-body">
									<ul class="collapsible" data-collapsible="accordion">
										<li><a class="collapsible-body" href="{{URL::to('/admin/activity')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Activities</span></a> 
										</li>
										<li><a class="collapsible-body" href="{{URL::to('/admin/activity/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Activity</span></a> 
										</li>
									</ul>
								</div>
							</li>
							
                        </ul>
                    </div>
                </li>
				
				
				
                

				<!-- Operators --> 
			<!--	<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">dvr</i><span class="menu-title" data-i18n="">Operators</span></a>
					<div class="collapsible-body">
						<ul class="collapsible" data-collapsible="accordion">
							<li><a class="collapsible-body" href="{{URL::to('/admin/alloperators')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Operators</span></a>
							</li>
							<li><a class="collapsible-body" href="{{URL::to('/admin/addoperator')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Operator</span></a>
							</li>
						</ul>
					</div>
				</li> -->
                <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">airline_seat_recline_normal</i><span class="menu-title" data-i18n="">Operators</span></a>
                    <div class="collapsible-body">
                        <ul class="collapsible" data-collapsible="accordion">
                            <li><a class="collapsible-body" href="{{URL::to('/admin/operator')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Operators</span></a>
                            </li>
                            <li><a class="collapsible-body" href="{{URL::to('/admin/operator/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Operator</span></a>
                            </li>
                        </ul>
                    </div>
                </li>


	 			<!-- Htels --> 
				<!-- <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">dvr</i><span class="menu-title" data-i18n="">Hotel</span></a>
					<div class="collapsible-body">
						<ul class="collapsible" data-collapsible="accordion">
							<li><a class="collapsible-body" href="{{URL::to('/admin/allhotels')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Hotel</span></a>
							</li>
							<li><a class="collapsible-body" href="{{URL::to('/admin/addhotel')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Hotels</span></a>
							</li>
						</ul>
					</div>
				</li> --->
                
                
				
				<!-- Add Lead --> 
				<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">library_books</i><span class="menu-title" data-i18n="">Leads</span></a>
					<div class="collapsible-body">
						<ul class="collapsible" data-collapsible="accordion">
							<li><a class="collapsible-body" href="{{URL::to('/admin/lead')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Lead</span></a> 
							</li>
							<li><a class="collapsible-body" href="{{URL::to('/admin/lead/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Lead</span></a> 
							</li>
							<li><a class="collapsible-body" href="{{URL::to('/admin/viewleadstatus')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>View Lead Status</span></a> 
							</li>
						</ul>
					</div>
				</li>
                
                <!-- Add contacts -->
                <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">airline_seat_recline_normal</i><span class="menu-title" data-i18n="">Conctacts</span></a>
                    <div class="collapsible-body">
                        <ul class="collapsible" data-collapsible="accordion">
                            <li><a class="collapsible-body" href="{{URL::to('/admin/contact')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Contacts</span></a>
                            </li>
                            <li><a class="collapsible-body" href="{{URL::to('/admin/contact/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Contact</span></a>
                            </li>
                            <li><a class="collapsible-body" href="{{URL::to('/admin/importcontact')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Import Contact</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
				
				<!-- Emailing System -->
                <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">email</i><span class="menu-title" data-i18n="">Emailing System</span></a>
					<div class="collapsible-body">
						<ul class="collapsible" data-collapsible="accordion">
						
						<!-- Add Emailing -->
						<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">loupe</i><span class="menu-title" data-i18n="">SMTP Email</span></a>
							<div class="collapsible-body">
								<ul class="collapsible" data-collapsible="accordion">
									<li><a class="collapsible-body" href="{{URL::to('/admin/smtpemail')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Email</span></a> 
									</li>
									<li><a class="collapsible-body" href="{{URL::to('/admin/smtpemail/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Email</span></a>
									</li>
								</ul>
							</div>
						</li>
						
						<!-- Email Template --> 
						<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">loupe</i><span class="menu-title" data-i18n="">Email Template</span></a>
							<div class="collapsible-body">
								<ul class="collapsible" data-collapsible="accordion">
									<li><a class="collapsible-body" href="{{URL::to('/admin/smtpemail')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Email Template</span></a> 
									</li>
									<li><a class="collapsible-body" href="{{URL::to('/admin/smtpemail/create')}}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Email Template</span></a>
									</li>
								</ul>
							</div>
						</li>
						
						</ul>
					</div>
				</li>
				
				<li class="bold"><a class="waves-effect waves-cyan " href="{{URL::to('/admin/request')}}"><i class="material-icons">record_voice_over</i><span class="menu-title" data-i18n="">Requests</span></a>
				</li>
				
				<li class="bold"><a class="waves-effect waves-cyan " href="http://www.ensoberhotels.com"><i class="material-icons">help_outline</i><span class="menu-title" data-i18n="">Support</span></a>
        </li>
      </ul>
    </aside>
    <!-- END: SideNav-->
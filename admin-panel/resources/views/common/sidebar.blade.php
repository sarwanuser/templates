<style>
.sidebar[data-color=purple] li.active>a {
    background-color: #9c27b057 !important;
}
</style>
<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ url('img/sidebar-1.jpg') }}">
    <div class="logo">
		<a href="{{ url('admin/dashboard') }}" class="simple-text logo-normal text-center">
			<img src="{{ url('img/sidebar_logo.png') }}" alt="Vihangam" title=""/>
		</a>
	</div>
    <div class="sidebar-wrapper">
		<ul class="nav">
			<li class="nav-item<?php if(url()->current() == url('admin/dashboard')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/dashboard') }}">
			<!--<i class="material-icons">dashboard</i>-->
			<p><span><img class="" src="{{ url('img/dashboard.png') }}" style="width:25px;" alt="Dashboard" title=""/></span>Dashboard</p></a></li>
			<?php
				$loginuserdata = json_decode(Session::get('auserdata'));
				//echo"<pre>"; print_r($loginuserdata); echo"</pre>";
				if(($loginuserdata->user_role == "administrator") || ($loginuserdata->user_role == "admin")){ ?>
					<li class="nav-item<?php if(url()->current() == url('admin/vidyarthis')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/vidyarthis') }}"><p><span><img class="vidyarthiimgpng" src="{{ url('img/vidyarthi.png') }}" alt="Vidyarthis" title=""/></span>Vidyarthis</p></a></li> 
					<li class="nav-item<?php if(url()->current() == url('admin/hawans')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/hawans') }}"><p><span><img class="hawanimgpng" src="{{ url('img/allawans.png') }}" alt="Hawans" title=""/></span>All Hawans</p></a></li>
					<li class="nav-item<?php if(url()->current() == url('admin/search')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/search') }}"><p><span><img class="" src="{{ url('img/search.png') }}" style="width:25px;" alt="Dashboard" title=""/></span>Search</p></a></li>
					<li class="nav-item<?php if(url()->current() == url('admin/admins')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/admins') }}"><p><span><img class="adminimgpng" src="{{ url('img/admins.png') }}" alt="Admins" title=""/></span>Admins</p></a></li>
					<li class="nav-item<?php if(url()->current() == url('admin/setting')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/setting') }}"><p><span><img class="adminimgpng" src="{{ url('img/settings.png') }}" alt="Admins" title=""/></span>Settings</p></a></li>
					<?php
				}
                if(($loginuserdata->user_role == "vidyarthi") || ($loginuserdata->user_role == "kkadmin")){?>
					<li class="nav-item<?php if(url()->current() == url('admin/hawans/add')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/hawans/add') }}"><p><span><img class="hawanimgpng" src="{{ url('img/add-havan-icon.png') }}" alt="Hawans" title=""/></span>Add Hawan</p></a></li>
					<?php
				}
                if(($loginuserdata->user_role == "vidyarthi") || ($loginuserdata->user_role == "kkadmin")){?>
					<li class="nav-item<?php if(url()->current() == url('admin/hawans')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/hawans') }}"><p><span><img class="hawanimgpng" src="{{ url('img/allawans.png') }}" alt="Hawans" title=""/></span>All Hawans</p></a></li>
					<?php
				}
                if($loginuserdata->user_role == "vidyarthi"){ ?>
					<li class="nav-item<?php if(url()->current() == url('admin/vidyarthis')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/vidyarthis') }}"><p><span><img class="vidyarthiimgpng" src="{{ url('img/profile-icon.png') }}" alt="Vidyarthis" title=""/></span>Profile</p></a></li>
					<?php
				} 
				if($loginuserdata->user_role == "kkadmin"){ ?>
					<li class="nav-item<?php if(url()->current() == url('admin/admins')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/admins') }}"><p><span><img class="vidyarthiimgpng" src="{{ url('img/admins.png') }}" alt="Vidyarthis" title=""/></span>Profile</p></a></li>
					<?php
				}
			?>
            <li class="nav-item<?php if(url()->current() == url('admin/help')){ echo ' active';}?>"><a class="nav-link" href="{{ url('admin/help') }}"><p><span><img class="logoutimg" src="{{ url('img/help.png') }}" alt="Help" title=""/></span>Help</p></a></li>
			<li class="nav-item"><a class="nav-link" href="{{ url('logout') }}"><p><span><img class="logoutimg" src="{{ url('img/logout.png') }}" alt="Log out" title=""/></span>Log out</p></a></li> 
		</ul>
    </div>
</div>

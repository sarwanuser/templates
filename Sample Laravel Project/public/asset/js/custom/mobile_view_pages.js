jQuery(document).ready(function(){
	if(window.location.href == '/operator/contactfollowup' && jQuery(window).width() <= 480){ 
		window.location = "/operator/contactfollowup/mobileview";
	}
});
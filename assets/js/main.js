// Track searches with GA
jQuery('#search-form').submit(function(ev) {
    ev.preventDefault(); // to stop the form from submitting
    /* Validations go here */
    this.submit(); // If all the validations succeeded
});

// When gravity form loads
jQuery(document).bind('gform_post_render', function(event, form_id){


});

// When the gravity form is successfully submitted
jQuery(document).bind('gform_confirmation_loaded', function(event, form_id){


});

// Used for tracking goals
function cc_ga_event_tracking(event_cat,event_action,event_label,event_value,redirect_to,new_window){

	// Set defaults to avoid loops
    new_window = typeof new_window !== 'undefined' ? new_window : false;
    redirect_to = typeof redirect_to !== 'undefined' ? redirect_to : '';
    event_value = typeof event_value !== 'undefined' ? event_value : '';

    // GAnalytics
    //ga('send', 'event', event_cat, event_action, event_label, event_value);
	ga('send', {
	  'hitType': 'event',
	  'eventCategory': event_cat,
	  'eventAction': event_action,
	  'eventLabel': event_label,
	  'eventValue': event_value,
	  'hitCallback': function () {
			  // Redirect After
			  if(redirect_to != ''){
			  	if(new_window === true){
			  		window.open(redirect_to,'_blank');
			  		//console.log('redirect popup');
			      }else{
			      	window.location = redirect_to;
			      	//console.log('redirect no popup');
			      }
			  }
		 }
	});

}

// Track a virtual pageview
function cc_ga_pageview_tracking(url){
	ga('send', 'pageview', url);
}

// Set a cookie
function cc_set_cookie(c_name,value,exdays){
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value = escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie = c_name + "=" + c_value + ";path=/;";
}

// Get a cookie
function cc_get_cookie(c_name){
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i = 0;i<ARRcookies.length;i++){
		x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x = x.replace(/^\s+|\s+$/g,"");
		if (x == c_name){
			return unescape(y);
		}
	}
}
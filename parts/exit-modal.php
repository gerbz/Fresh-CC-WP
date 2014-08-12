
    <!-- Exit Modal -->
    <div class="modal fade" id="exit-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Hey Waitup!</h4>
          </div>
          <div class="modal-body">
          <p>Message...</p>

    		<?php
    		// http://www.gravityhelp.com/documentation/page/Embedding_A_Form

    		?>
          	</div>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<script type="text/javascript">

// Prevent the popup if internal page click
var exitpopup = true;
jQuery('body').click(function() {
   exitpopup = false;
});

// Prevent popup for people who place orders
jQuery('.btn-warning, .btn-success').click(function() {
   exitpopup = false;
   cc_set_cookie('exitpopupcookie','false',300);
});

// Fires when page is exited
var clickedstaytimer;
window.onbeforeunload = function (e) {

	var exitcookie = cc_get_cookie('exitpopupcookie');
	cc_ga_pageview_tracking('/exitpopup/');

    // If they haven't done anything to prevent the popup... launch it
    if(exitpopup === true && exitcookie != 'false'){

    	// Launch a timer that will execute after they decide to stay
		clickedstaytimer = window.setTimeout(clicked_stay, 1000);

        return '================================ WAIT UP! DO SOMETHING FOR FREE! ================================ All you have to do is tell us why you didn\'t buy from us today. It only takes a second. Click STAY ON THIS PAGE.';
    }else{
	    return;
    }
};

//Fires when they decide to stay
function clicked_stay() {

	// Set a cookie so we don't popup again in the future
	cc_set_cookie('exitpopupcookie','false',300)

	// Display modal
    jQuery('#exit-modal').modal('show');

	// GA
	var gapv = window.setTimeout(callga, 1500);

}

function callga(){
	cc_ga_pageview_tracking('/exitpopup/form/');
}

// When the exit form is successfully submitted
// This was moved into coincrack.js
</script>

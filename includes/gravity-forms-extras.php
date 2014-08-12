<?php
// Post payments!
// Crap example: http://cullenwebservices.com/add-payment-page-wordpress-site-first-data-merchant-account/
// GF Validation documentation: http://www.gravityhelp.com/documentation/page/Gform_validation
// FatZebra CC Procesing Plugin: https://github.com/fatzebra/GravityForms-FatZebra/blob/master/fatzebra.php
// USA EPAY Error Codes: http://wiki.usaepay.com/developer/errorcodes?s[]=transaction&s[]=authentication&s[]=required
// USA EPAY API: http://wiki.usaepay.com/developer/phplibrary

// Modify the validation message
add_filter("gform_validation_message", "change_message", 10, 2);
function change_message(){
  return '<div class="row"><div class="col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10 col-sm-offset-0 col-sm-12"><div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please correct the red errors below and try again.</div></div><script type="text/javascript">document.getElementById("field_1_7").style.display="block";document.getElementById("sameaddress").checked = false;</script>';
}

// Enable the credit card field
// http://www.gravityhelp.com/documentation/page/Gform_enable_credit_card_field
add_action("gform_enable_credit_card_field", "enable_creditcard");
function enable_creditcard($is_enabled){
   return true;
}

// Allow tables to display in the backend form
// http://www.gravityhelp.com/documentation/page/Gform_allowable_tags
add_filter("gform_allowable_tags_1", "allow_basic_tags");
function allow_basic_tags($allowable_tags){
    return '<table><tr><td>';
}

// Don't scroll the gravity form after submission
// http://www.gravityhelp.com/documentation/page/Gform_confirmation_anchor
add_filter("gform_confirmation_anchor", create_function("","return false;"));

// Append header to email notifications
// http://www.gravityhelp.com/documentation/page/Gform_notification
add_filter('gform_notification', 'my_gform_notification_signature', 10, 3);
function my_gform_notification_signature( $notification, $form, $entry ) {

	$header = '<table cellpadding="0" cellspacing="0" style="width:600px;padding:10px 0px;margin:0px;"><tr><td class="column" width="600" align="center" valign="top"><img src="https://sigecig.com/wp-content/themes/sigecig/assets/img/email/email-header.jpg"></td></tr></table>';

	$notification['message'] = $header.$notification['message'];

    return $notification;
}

// Inject custom text into the note field
// http://www.gravityhelp.com/documentation/page/Gform_entry_detail_content_after
add_action("gform_entry_detail_content_after", "custom_footer", 10, 2);
function custom_footer($form, $entry){
   echo '<script type="text/javascript">var notetext = \''.GF_NOTE_DEFAULT_TEXT.'\';jQuery(\'textarea[name="new_note"]\').val(notetext);</script>';
}

// Break into two columns
// http://www.jordancrown.com/multi-column-gravity-forms/
add_filter('gform_field_content', 'gform_column_splits', 10, 5);
function gform_column_splits($content, $field, $value, $lead_id, $form_id) {
	if(!IS_ADMIN) { // only perform on the front end

		// target section breaks
		if($field['type'] == 'section') {
			$form = RGFormsModel::get_form_meta($form_id, true);

			// check for the presence of our special multi-column form class
			$form_class = explode(' ', $form['cssClass']);
			$form_class_matches = array_intersect($form_class, array('two-column'));

			// check for the presence of our special section break column class
			$field_class = explode(' ', $field['cssClass']);
			$field_class_matches = array_intersect($field_class, array('gform_column'));

			// if we have a column break field in a multi-column form, perform the list split
			if(!empty($form_class_matches) && !empty($field_class_matches)) {

				// we'll need to retrieve the form's properties for consistency
				$form = RGFormsModel::add_default_properties($form);
				$description_class = rgar($form, 'descriptionPlacement') == 'above' ? 'description_above' : 'description_below';

				$field_class_matches_1 = array_intersect($field_class, array('side-1'));
				$field_class_matches_2 = array_intersect($field_class, array('side-2'));

				if(!empty($field_class_matches_1)){

					// close current field's li and ul and begin a new list with the same form properties
					return '</li></ul><ul class="col-lg-offset-2 col-lg-4 col-md-offset-1 col-md-5 col-sm-offset-0 col-sm-6 gform_fields '.$form['labelPlacement'].' '.$description_class.' '.$field['cssClass'].'"><li class="gfield gsection">';

				}elseif(!empty($field_class_matches_2)){

					// close current field's li and ul and begin a new list with the same form properties
					return '</li></ul><ul class="col-lg-4 col-md-5 col-sm-6 gform_fields '.$form['labelPlacement'].' '.$description_class.' '.$field['cssClass'].'"><li class="gfield gsection">';
				}

			}
		}
	}

	return $content;
}

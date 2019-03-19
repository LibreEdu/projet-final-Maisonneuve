    var fm_currentDate = new Date();
    var FormCurrency_2 = '$';
    var FormPaypalTax_2 = '0';
    var check_submit2 = 0;
    var check_before_submit2 = {};
    var required_fields2 = ["4"];
    var labels_and_ids2 = {"2":"type_text","3":"type_text","4":"type_submitter_mail","5":"type_text","6":"type_text","7":"type_address","1":"type_submit_reset"};
    var check_regExp_all2 = [];
    var check_paypal_price_min_max2 = [];
    var file_upload_check2 = [];
    var spinner_check2 = [];
    var scrollbox_trigger_point2 = '20';
    var header_image_animation2 = 'none';
    var scrollbox_loading_delay2 = '0';
    var scrollbox_auto_hide2 = '1';
         function before_load2() {	
}	
 function before_submit2() {
	 }	
 function before_reset2() {	
} function after_submit2() {
  
}
    function onload_js2() {
    }
    function condition_js2() {
    }
    function check_js2(id, form_id) {
    if (id != 0) {
    x = jQuery("#" + form_id + "form_view"+id);
    }
    else {
    x = jQuery("#form"+form_id);
    }    }
    function onsubmit_js2() {
    
    var disabled_fields = "";
    jQuery("#form2 div[wdid]").each(function() {
      if(jQuery(this).css("display") == "none") {
        disabled_fields += jQuery(this).attr("wdid");
        disabled_fields += ",";
      }
    })
    if(disabled_fields) {
      jQuery("<input type=\"hidden\" name=\"disabled_fields2\" value =\""+disabled_fields+"\" />").appendTo("#form2");
    };    }
    form_view_count2 = 0;
    jQuery(document).ready(function () {
    if (jQuery('form#form2 .wdform_section').length > 0) {
    fm_document_ready(2);
    }
    else {
    jQuery("#form2").closest(".fm-form-container").removeAttr("style")
    }
    });
    jQuery(document).ready(function () {
    if (jQuery('form#form2 .wdform_section').length > 0) {
    formOnload(2);
    }
    });
    
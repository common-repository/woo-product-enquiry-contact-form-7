jQuery(document).ready(function(){
	jQuery('body').on('click','.form_opn',function(){

		jQuery('body').addClass("enquiry_popup_body");
		jQuery('body').append('<div class="wpecf7_loading"><img src="'+ window.location.origin +'/wp-content/plugins/woocommerce-product-enquiry-contact-form-7/images/loader.gif" class="wpecf7_loader"></div>');
		var loading = jQuery('.wpecf7_loading');
		loading.show();


        var id = jQuery(this).data("id");
        var current = jQuery(this);
        jQuery.ajax({
	        url:ajax_url,
            type:'POST',
	        data:'action=productscomments&popup_id='+id,
	        success : function(response) {
	        	var loading = jQuery('.wpecf7_loading');
				loading.remove(); 

	            jQuery("#enquiry_popup").css("display","block");
	            jQuery("#enquiry_popup").html(response);
	            jQuery("#enquiry_popup").find('input[name="product-name"]').val(current.attr("proname"));

	         	wpcf7.initForm(jQuery('.wpcf7 > form')); 
				var urL = jQuery('.wpcf7 > form').attr('action').split('#');
				jQuery('.wpcf7 > form').attr('action', "#" + urL[1]);
				document.addEventListener( 'wpcf7mailsent', function( event ) {	location.reload();}, false );
				jQuery('.popup_padding_div div.wpcf7>form>p input[name="product-name"]').attr('readonly', true);

				
	        },
	        error: function() {
	            alert('Error occured');
	        }
	    });
       return false;
    });
    var modal = document.getElementById("enquiry_popup");
	var span = document.getElementsByClassName("enquired_close")[0];

	jQuery(document).on('click','.enquired_close',function(){
		jQuery("#enquiry_popup").css("display","none");
		jQuery('body').removeClass("enquiry_popup_body");
	});
	
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	    jQuery('body').removeClass("enquiry_popup_body");
	  }
	}




})

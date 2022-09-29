/**
 * idonate admin js
 *
 */

;(function ($) {
    "use strict";
    
	// Add Color Picker to all inputs that have 'color-picker' class
    $(function() {
        $('.date-picker').datepicker();
    });
	
	// On change country 
	$('body').on( 'change', '.country', function() {
		$.ajax({
			type: "POST",
			url:localData.statesurl,
			data:{
				country: $(this).val(),
				action: 'country_to_states_ajax'
			},
			success:function(rss){
									
				$('.state').empty();
				var $opt = '';	
				$.each( JSON.parse(rss), function(key, value) {
							
					$opt += '<option value="'+key+'">'+value+'</option>';
				  
				});
				
				$('.state').append($opt);
			}
			
		});
		
		//return false;
	});
	
	// Selected  state
	var $selectedCount = $('.country').val(),
		$selectedState = $('.state').data('state');
					
	if( $selectedCount ){		
			$.ajax({
				type: "POST",
				url:localData.statesurl,
				data:{
					country: $selectedCount,
					action: 'country_to_states_ajax'
				},
				success:function(rss){
										
					$('.state').empty();
					var $opt = '';	
					$.each( JSON.parse(rss), function(key, value) {
						
						var $selected;
						
						if( $selectedState  === key ){
							$selected = 'selected';
						}else{
							$selected = '';
						}
						
						$opt += '<option value="'+key+'" '+$selected+'>'+value+'</option>';
					  
					});
					
					$('.state').append($opt);
				}
				
			});
		
	}
	
	
})(jQuery);

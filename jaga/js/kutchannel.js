
// $('.table > tr').click(function() {
    // // row was clicked
// });

jQuery(document).ready(function($) { $(".jagaClickableRow").click(function() { window.document.location = $(this).data('url'); }); });
				
$( window ).load( function() { $( '#list' ).masonry( { itemSelector: '.item' } ); });
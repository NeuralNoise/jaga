
var j = jQuery.noConflict();			

j(document).ready( // DOM is ready
	function() {
		j('.jagaClickableRow').click(
			function() {
				window.document.location = j(this).data('url');
			}
		);
	}
);

j(window).load( // assets are loaded
	function() {
		j('#list').masonry(
			{
				itemSelector: '.item'
			}
		);
	}
);

j(document).keyup(function(e) { 
    if (e.keyCode == 27) { // 'Esc'
        window.location.replace('/login/');
    }
});
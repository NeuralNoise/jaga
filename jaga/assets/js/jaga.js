
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





var scrollTimer, lastScrollFireTime = 0;

j(window).on('scroll', function() {

	var first = j('div#list').children('div.item').length + 1;
	
	
	var number = 25;
	var channelID = j('#channelID').val();
	if (channelID == 0) { channelID = 2006; }
	var contentCategoryKey = j('#contentCategoryKey').val();
	
    var minScrollTime = 2500;
    var now = new Date().getTime();

    if (!scrollTimer) {
        if (now - lastScrollFireTime > (3 * minScrollTime)) {
            getContent(first, number, channelID, contentCategoryKey);   // fire immediately on first scroll
            lastScrollFireTime = now;
			console.log(first);
        }
        scrollTimer = setTimeout(function() {
            scrollTimer = null;
            lastScrollFireTime = new Date().getTime();
            getContent(first, number, channelID, contentCategoryKey);
			console.log(first);
        }, minScrollTime);
    }
	
	j("#list").masonry('reloadItems').masonry('layout');

});


function getContent(first, number, channelID, contentCategoryKey) {

	var scrollHeight = j(document).height();
	var scrollPosition = j(window).height() + j(window).scrollTop();
	
	if (scrollHeight === scrollPosition) {

		var content = j.ajax({
			type: "GET",
			url: "/api/content/"+first+"/"+number+"/"+channelID+"/"+contentCategoryKey+"/",
			dataType: "json",
			success: function (data) {},
			error: function(){} 	        
		});

		content.done(function(data){
		
			console.dir(data);
		
			var items = "";
			
			for (var prop in data) {

				items = items + "<div class=\"item col-xs-12 col-sm-6 col-md-4 col-lg-3\">";
					items = items + "<div class=\"panel panel-default\">";
						items = items + "<div class=\"panel-heading jagaContentPanelHeading\">";
						items = items + "<h4><a href=\"" + data[prop].content_url + "\">" + data[prop].content_title + "</a></h4>";
							items = items + "<a href=\"http://jaga.io/u/" + data[prop].user_name + "/\">" + data[prop].user_display_name + "</a>";
							items = items + "<a href=\"http://" + (data[prop].channel_key!="www"?data[prop].channel_key+".":"") + "jaga.io/\" class=\"pull-right\">" + data[prop].channel_title + "</a>";
						items = items + "</div>";
						items = items + "<a href=\"" + data[prop].content_url + "\" class=\"list-group-item jagaListGroupItem\">";
							items = items + "<span class=\"jagaListGroup\">";
								if (data[prop].content_main_image) { items = items + "<img class=\"img-responsive\" src=\"" + data[prop].content_main_image + "\"><br>"; }
								items = items + "<div style=\"white-space:pre-line;overflow-y:hidden;\">" + data[prop].content_lead_text + "</div>";
							items = items + "</span>";
						items = items + "</a>";
					items = items + "</div>";
				items = items + "</div>";

			}
			
			j("#list").append(items).masonry('appended',items).masonry('reloadItems').masonry('layout');
			
		});
		
		

	}
	
	
}

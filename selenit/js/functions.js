$(function() {

	$('#navigation ul li:first-child').addClass('first')
	$('#navigation ul li:last-child').addClass('last')
	$('section:last').addClass('last-section')
});

$(window).load(function() {
	$('.flexslider').flexslider({
		animation: "slide",
		controlsContainer: ".slider-holder",
		slideshowSpeed: 5000,
		animationDuration: 900,
		directionNav: true,
		controlNav: false,
		
	});

	menu();

	var objs = $( ".imgbox" );
	objs.mouseenter(function() {
		$(this).css("border", "2px solid #2f6b8e");
		
	});
	objs.mouseout(function() {
		$(this).css("border", "2px solid #d6dae1");
	});

	/*$.each(objs, function( i, val ) {
		objs[i].children().mouseenter(function() {
			objs[i].css("border", "2px solid #2f6b8e");
		});		
	});*/

});


function menu(){
	var url = document.URL;


	url = url.substring(url.lastIndexOf("/")+1);
	url = url.substring(0, url.lastIndexOf("."));
	if(url == ""){
		url = "index";
	}
            

	var menu = $("#"+url);    
                				
	menu.children().removeAttr("href");
	menu.addClass("active");
}

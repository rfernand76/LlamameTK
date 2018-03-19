function menu(){
	var url = document.URL;

	url = url.substring(url.lastIndexOf("/")+1);
	url = url.substring(0, url.lastIndexOf("."));
	if(url == ""){
		url = "index";
	}
            
	var menu = $("#menusuperior #"+url);    
                				
	menu.children().removeAttr("href");
	menu.addClass("selected");
}

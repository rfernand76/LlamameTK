
<!DOCTYPE html >
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"-->
    <meta name="description" content="">
    <meta name="author" content="">
    
        <meta name="viewport" content="width=500, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        
    <title>Virtual Line</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/style2.css" rel="stylesheet" />
</head>
    <!--END HEAD SECTION -->
<body>   
     <!-- NAV SECTION -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="">
            <div class="navbar-header">
                <!--button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button-->
                <a class="navbar-brand">Llamame.tk</a>
            </div>
            <!--div id="menu" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#header-section"   onClick="menuClick();">INICIO</a></li>
                    <li><a href="#about-section"    onClick="menuClick();">QUE ES</a></li>
                    <li><a href="#services-section" onClick="menuClick();">COMO USAR</a></li>
                    <li><a href="#contact-section"  onClick="menuClick();">INICIAR SESSION</a></li>
                </ul>
            </div-->
           
        </div>
    </div>

	 <?php include 'home.html';?>
	 <?php include 'about-section.html';?>
     <!--?php include 'services-section.html';?-->
	 <!--?php include 'price-section.html';?-->
	 <!--?php include 'products-section.html';?-->
	 <!--?php include 'contact-section.html';?-->
	 <?php include 'footer.html';?>

    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/scrollReveal.js"></script>
    <script src="assets/js/custom.js"></script>
	
	<script>
		function menuClick(){
			$("#menu").attr("class", "navbar-collapse collapse");
			$("#menu").attr("style", "height: 1.11111px;");
		}
		
		function setContainerSize(){
			var height = getHeight();
            var width  = getWidth();

			$(".container").css("min-height",(height - 50) +  "px");

            //var img = $("#img");

            //img.css("height",(height - 214) +  "px");
            //img.css("width",(width - 491) +  "px");
		}
		
		function getHeight()
		{
			var y = 0;
			if (self.innerHeight){
				y = self.innerHeight;
			}else if (document.documentElement && document.documentElement.clientHeight){
				y = document.documentElement.clientHeight;
			}else if (document.body){
				y = document.body.clientHeight;
			}

			return y;
		}

        function getWidth()
        {
            var x = 0;
            if (self.innerWidth){
                    x = self.innerWidth;
            }else if (document.documentElement && document.documentElement.clientWidth){
                    x = document.documentElement.clientWidth;
            }else if (document.body){
                    x = document.body.clientWidth;
            }

            return x;
        }
		
		$( window ).resize(function() {
			setContainerSize();
		});
				
		$( document ).ready(function() {
			setContainerSize();
		});
		
		
		
	</script>
	
</body>
</html>

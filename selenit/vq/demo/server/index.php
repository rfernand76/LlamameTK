<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<style type="text/css">
	.chat
	{
	    list-style: none;
	    margin: 0;
	    padding: 0;
	}

	.chat li
	{
	    margin-bottom: 10px;
	    padding-bottom: 5px;
	    border-bottom: 1px dotted #B3A9A9;
	}

	.chat li.left .chat-body
	{
	    margin-left: 60px;
	}

	.chat li.right .chat-body
	{
	    margin-right: 60px;
	}


	.chat li .chat-body p
	{
	    margin: 0;
	    color: #777777;
	}

	.panel .slidedown .glyphicon, .chat .glyphicon
	{
	    margin-right: 5px;
	}

	.panel-body
	{
	    overflow-y: scroll;
	    max-height: 100%;
	    height: 400px;
	}

	::-webkit-scrollbar-track
	{
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	    background-color: #F5F5F5;
	}

	::-webkit-scrollbar
	{
	    width: 12px;
	    background-color: #F5F5F5;
	}

	::-webkit-scrollbar-thumb
	{
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
	    background-color: #555;
	}

	.state-icon {
	    left: -5px;
	}
	.list-group-item-primary {
	    color: rgb(255, 255, 255);
	    background-color: rgb(66, 139, 202);
	}

	/* DEMO ONLY - REMOVES UNWANTED MARGIN */
	.well .list-group {
	    margin-bottom: 0px;
	}
	</style>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="span6">
			<div class="container">
			    <div class="row">
			        <div class="col-md-5">
			            <div class="panel panel-primary">
			                <div class="panel-heading">
			                    <span class="glyphicon glyphicon-comment"></span> Chat
			                </div>
			                <div class="panel-body">
			                    <ul id="message_box" class="chat">
			                       
			                    </ul>
			                </div>
			                <div class="panel-footer">
			                    <div class="input-group">
			                    <input style="width:100px" id="name"      type="text" class="form-control input-sm" name="name"  placeholder="Your Name" maxlength="10"   />
								<input style="width:180px" id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
			                        <span class="input-group-btn">
			                            <button class="btn btn-warning btn-sm" id="btn-chat">
			                                Send</button>
			                        </span>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
   
$(document).ready(function(){
	
	//create a new WebSocket object. 
	var wsUri = "ws://www.sqltxt.cl:8080"; 	
	websocket = new WebSocket(wsUri); 
	var myip ;

	websocket.onopen = function(ev) {
		$('#message_box').append(createLi('System','conectado.png','Connected !!!')); 
	};
    
	websocket.onerror	= function(ev){
		$('#message_box').append(createLi('System','error.png','Error Occurred '+ev.data));
	};

	websocket.onclose 	= function(ev){
		$('#message_box').append(createLi('System','desconectado.png','Connection Closed'));
	};

    websocket.onmessage = function(ev) {
    	var msg = JSON.parse(ev.data); //PHP sends Json data
		var type = msg.type; //message type
		var umsg = msg.message; //message text
		var uname = msg.name; //user name 

		if(!uname){
			uname ='system' ;
		}

		$('#message_box').append(createMessage (type,umsg,uname)) ;
		$('#message').val(''); //reset text
	};


	function createMessage (type,msg,username) {
		
		var img = 'chrome.png' ;
		var myname = $('#name').val(); //get user name
		
		if(username == myname){
			img = 'firefox.png' ;
		}

		if(username == 'system'){
			var img = 'conectado.png' ;
			if(type=='desconectado'){
				img = 'desconectado.png' ;
			}	
		}
		return createLi(username,img,msg) ;
	}

	function createLi(username,img,text){
		var li = $(' <li class="left clearfix"><span class="chat-img pull-left"><img src="'+img+'" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font">'+username+'</strong> </div><p>'+text+'</p></div></li>');
		var myname = $('#name').val(); //get user name
		if(username == myname){
			li = $(' <li class="right clearfix"><span class="chat-img pull-right"><img src="'+img+'" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font">'+username+'</strong> </div><p>'+text+'</p></div></li>');
		}
		return li;
	}

	$('#btn-chat').click(function(){ 
		var mymessage = $('#btn-input').val();  //get message text
		var myname = $('#name').val(); //get user name
		
		if(myname == ""){ //empty name?
			alert("Enter your Name please!");
			return;
		}
		if(mymessage == ""){ //emtpy message?
			alert("Enter Some message Please!");
			return;
		}
		
		//prepare json data
		var msg = {
		message: mymessage,
		name: myname,
		};
		//convert and send data to server
		websocket.send(JSON.stringify(msg));

	});

});

</script>
</body>
</html>

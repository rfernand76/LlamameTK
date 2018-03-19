function PollClass(){
	this.width = 450;
	this.height = 400;

	this.properties = {
			id:"idPollClass_" + iContadorObjeto,
			disabled:'',
			name:'',
			style:'border:1px solid;',
			theClass:'ui-corner-all ui-tabs-panel ui-widget-content ui-corner-bottom ', 
			
			title: "Poll Test",
			nextTitle: "Next",
			previousTitle: "Prev",
			finishTitle: "Finish",
			onFinish:"",
			mobile:{action:1,name:'Pool'},
		  
			currentPageIndex: 0,
		  
			pages: 
			[
				{
					title    : "Identity",
					helpText : "Enter your data",onNext: "", onPrevious: "", url: "",
					questions: [
						{type: "text", requested: false, title: "Name",	name: "name"},
						{type: "email",requested: false, title: "Mail",	name: "email"},
					]
				},
				
				{
					title: "Page 2", 
					helpText: "Select", onNext: "", onPrevious: "", url: "",
					questions: [
						{type: "title", title: "Select"},
						{type: "radio", requested: true, name: "select1",
							"list": [
								{caption: "Yes", value: "0"},
								{caption: "Not", value: "100"},
							]
						},
					]
				}
			]
		};

	this.getHtml = function(){
		return this.__getHtml(0);
	}

	this.__getHtml = function(mode){
		var html = 	
		 '<div '+ getProperties(mode, this.properties) +'>\n'
		+'  <div class="headerPoll ui-widget-header ui-corner-all ui-widget">Titulo</div>\n'
		+'  <div class="bodyPoll ui-accordion-header ui-widget"></div>'
		+'  <div class="footerPoll ui-state-default ui-corner-all">'
		+'    <button class="butonPrevious">'+this.properties.previousTitle+'</button> <button class="butonNext"><span>'+this.properties.nextTitle+'</span></button>'
		+'  </div>\n'
		+'</div>\n';

		return html;
	}

	this.getJS = function(){
		var jsonStr = JSON.stringify(this.properties);
	
		var js = 
			'$("#'+this.properties.id+'").pool('+jsonStr+');';
			
		return js;
	}

	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idPoll_');

		var html = this.__getHtml(mode);
		var htmlObject = $(html);
		htmlObject.appendTo( padre );

		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "PollClass");

		var me = this;
		
		var prev = htmlObject.find('.butonPrevious').button({icons: {primary:   'ui-icon-triangle-1-w'}}).click(function( event ) {return false;});
		var next = htmlObject.find('.butonNext')    .button({icons: {secondary: 'ui-icon-triangle-1-e'}}).click(function( event ) {return false;});
		if(mode != 0){
			prev.click(function( event ) {me.previous(); return false;})
			next.click(function( event ) {me.next();     return false;})
		}
				
		this.show();
		return htmlObject;
	}
	
	this.next = function(){
		this.setValue(); //asigna los valores de la pagina al control
		
		if(!this.valid()){
			return;
		}
	
		if(this.properties.currentPageIndex == this.properties.pages.length-1){
			return this.finish();
		}
	
		var page = this.properties.pages[this.properties.currentPageIndex];
		if(page.onNext != undefined && page.onNext != null && page.onNext != ""){
			if(!page.onNext.call(this, 1)){
				return;
			}
		}
		
		if(page.url != null && page.url != ""){
			this.send();
		}
		
		this.properties.currentPageIndex++;
		this.show();
	}
	
	this.previous = function(){	
		this.setValue(); //asigna los valores de la pagina al control
		
		var page = this.properties.pages[this.properties.currentPageIndex];
		if(page.onPrevious != undefined && page.onPrevious != null && page.onPrevious != ""){
			if(!page.onPrevious.call(this, 1)){
				return;
			}
		}
		
		if(page.url != null && page.url != ""){
			this.send(this, 2);
		}
		
		this.properties.currentPageIndex--;
		this.show();
	}
	
	this.finish = function(){
		if(this.properties.onFinish != undefined && this.properties.onFinish != null && this.properties.onFinish != ""){
			return this.properties.onFinish.call(this);
		}
	}
	
	this.send = function(){
		var page = this.properties.pages[this.currentPageIndex];
		var url = page.url;

		$.ajax({
				url:   url,
				async: false,

				success:  function (response) {
					
				},
		});
	}
	
	this.show = function(){
		var html = ""
		var page = this.properties.pages[this.properties.currentPageIndex];
		var questions = page.questions;
		var htmlObject = $("#"+this.properties.id);
		var helpText = ""
		if(page.helpText != null && page.helpText != undefined && page.helpText != ""){
			helpText = page.helpText;
		}
		
		html = "<h2>"+page.title+"</h2> <h3>"+helpText+"</h3>";
		var header = htmlObject.find(".headerPoll");
		header.html(html);
		
		html = "";
		var body = htmlObject.find(".bodyPoll");		
		for(var i=0; i<questions.length; i++){
			html = html + "<div>"+this.getHtmlFromQuestions(questions[i], i)+"</div>";
		}
		body.html( html );
		
		if(this.properties.currentPageIndex == 0){
			htmlObject.find('.butonPrevious').attr("disabled", "disabled");
		}else{
			htmlObject.find('.butonPrevious').removeAttr("disabled");
		}
		
		if(this.properties.currentPageIndex == this.properties.pages.length-1){
			htmlObject.find('.butonNext span').text(this.properties.finishTitle);
		}else{
			htmlObject.find('.butonNext span').text(this.properties.nextTitle);
		}
	}
	
	this.editDialog = function(){
		var definition = new PollClassDefinition();
		var me = this;
		definition.execute(this);
	}
	
	this.setPropertis = function(properties){
		this.properties = properties;
		var htmlObject = $("#"+this.properties.id);
		var jsonStr = JSON.stringify(this.properties);
		
		htmlObject.attr("VIU", jsonStr);
		this.show();
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}

	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100-10)+"px");
		domElement.css("width", (widthResize100-1)+"px");
		
		var headerPoll = domElement.find(".headerPoll");
		var footerPoll = domElement.find(".footerPoll");
		
		var bodyPoll = domElement.find(".bodyPoll");
		bodyPoll.css("height", (heightResize100 -footerPoll.height() -headerPoll.height() -25)+"px");
		
	}

	this.getPropertisList = function(){
		var ret = new Array();
		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		return ret;
	}
		
	this.attr = function(name, value){
		this.properties = setAttribute(this.properties, name, value);
	}

	this.getAttr = function(name){
		eval("ret = this.properties."+name);
		return ret;
	}
	
	this.getHtmlFromQuestions = function(question, id){
		var html = "";
		var helpText = ""
		var me = this;
		
		if(question.helpText != null && question.helpText != undefined && question.helpText != ""){
			helpText = "<div>"+question.helpText + "<div><br/>";
		}
		var value = "";
		if(question.value != undefined && question.value != null){
			value = question.value;
		}
		
		if(question.type == "text"){
			html = "<br/><b>"+question.title +"</b><br/>"+ helpText +"<input class='pollInput' type='text' index='"+id+"' name='"+question.name+"' id='question_"+id+"' value='"+value+"'/><span id='valid_"+id+"'></span >";
		}else if(question.type == "email"){	
			html = "<br/><b>"+question.title +"</b><br/>"+ helpText +"<input class='pollInput' type='text' index='"+id+"' name='"+question.name+"' id='question_"+id+"' value='"+value+"'/><span id='valid_"+id+"'></span >";
		}else if(question.type == "radio"){
			var list = question.list;
			html = html + "<div><span class='' id='valid_"+id+"'></span ></div>";
			
			for(var i=0; i<question.list.length; i++){
				var checked = "";
				
				var radioId = 'radio_'+i;
				var typeChek =  question.list[i].type;
				if(typeChek == 'other'){
					var value = (question.list[i].value == undefined?"": question.list[i].value);
					if(question.value != undefined && question.value == question.list[i].value){
						checked = "checked";
					}
					var idText = 'idText'+i;
					var onkeyup  = "\"var v =this.value; var obj = $('#"+me.properties.id+" #"+radioId+id+"'); obj.val(v); if(v!=''){obj.attr('checked', true);}\"";

					html = html + "<input class='pollInput' type='radio' subtype='radio' "+checked+" index='"+id+"' subid='"+i+"' idtext='"+idText +"' typeChek='other' name='"+question.name+"' id='"+radioId+id+"' type='radio' value=''/>"+question.list[i].caption+"<input type'text' value='"+value+"' id='"+idText+"' onkeyup ="+onkeyup +"><br/>";
				}else{
					if(question.value != undefined && question.value == question.list[i].value){
						checked = "checked";
					}
					html = html + "<input class='pollInput' type='radio' subtype='radio' "+checked+" index='"+id+"' subid='"+i+"' name='"+question.name+"' id='"+radioId+id+"' type='radio' value='"+ question.list[i].value+"'/>"+question.list[i].caption+"<br/>";
				}
			}

		}else if(question.type == "checkbox"){
			var checked = "";
			if(question.value != undefined && question.value){
				checked = "checked";
			}
				
			var checkboxId = 'checkbox_'+id;
			html = html + "<input class='pollInput' type='checkbox' "+checked+" index='"+id+"' name='"+question.name+" id='"+checkboxId+"'/>"+question.title;

		}else if(question.type == "combobox"){
			var selectId = 'select_'+id;
			var multiple = (question.multiple ?"multiple" :"");
			
			html = "<br/><b>"+question.title +"</b><br/>"+ helpText +"<select class='pollInput' type='combobox' name='"+question.name+"' index='"+id+"' id='"+selectId+"' "+multiple+">";
			var list = question.list;
			for(var i=0; i<question.list.length; i++){
				var selected = (question.list[i].selected==true  ?'selected' :'');
				html = html + "<option "+selected+" value='"+ question.list[i].value+"'>"+question.list[i].caption+"</option>";
			}
			html = html + "</select><span id='valid_"+id+"'></span></br>";
		}else if(question.type == "grid"){
			var rows = question.rows;
			var cols = question.cols;
			
			var col1Width = "";
			
			if(question.col1Width != undefined && question.col1Width != ""){
				col1Width = question.col1Width + "px";
			}
			html = "<table width='100%' border='0'><tr> <td width='"+col1Width+"'></td>";
			
			for(var i=0; i<cols.length; i++){
				var width = getValueProperty(cols[i].width);
				if(width != ""){
					width = "0"+getValueProperty(question.width) + "px";
				}
			
				html = html + "<td align='center' width='"+width+"'>"+cols[i].caption+"</td>";
			}
			html = html + "<td align='left' width='80px'></td></tr>";
			for(var i=0; i<rows.length; i++){
				html = html + "<tr ><td>"+rows[i].caption+"</td>";
				
				for(var e=0; e<cols.length; e++){
					var checked = "";
					if(question.value != undefined){
						if(question.value[i] == cols[e].value){
							checked = "checked";
						}
					}
					
					var radioId = 'grid_'+i+"_"+e;
				
					html = html + "<td align='center'><input class='pollInput' type='radio' subtype='grid' "+checked
								+" index='"+id+"' subid='"+i+"' name='"+question.name+"["+i+"]' id='"+radioId+"' type='radio' value='"+ cols[e].value+"'/></td>";
				}
				html = html + "<td><span id='valid_"+id+"_"+i+"'></span></td></tr>";
			}
			html = html + "</table>";
			
		
		}else if(question.type == "title"){	
			html = "<div><b>"+question.title +"</b></div>";
			
		}else if(question.type == "separator"){	
			html =  "";
			
		}else{
			html = "Sorry, type not defined";
			
		}
		
		html = html + "<br/>"
		return html;
	}
	
	this.setValue = function(){
		var me = this;
		var page = this.properties.pages[this.properties.currentPageIndex];
		var htmlObjects = $("#"+me.properties.id);
		
		htmlObjects.find(".pollInput").each(function(){
			var obj = $(this);
			var type = obj.attr("type");
			var subtype = obj.attr("subtype");
			var index = obj.attr("index");
			
			if(type == "text"){
				page.questions[index].value = obj.val();
			}else if(type == "email"){
				page.questions[index].value = obj.val();
			}else if(type == "radio" && subtype == 'radio'){
				if(obj.attr("checked")){
					var typeChek = obj.attr("typeChek");
					if(typeChek == 'other'){
						var idtext = obj.attr("idtext");
						var subid = obj.attr("subid");
						page.questions[index].list[subid].value = htmlObjects.find("#"+idtext).val();
						obj.val(page.questions[index].list[subid].value);
					}
					page.questions[index].value = obj.val();
				}
			}else if(type == "checkbox"){
				page.questions[index].value = (obj.attr("checked")=='checked');
			}else if(type == "combobox"){
				var i = 0;
				obj.find("option").each(function () {
					var option = $(this);
					page.questions[index].list[i].selected = option.attr("selected")=='selected';
					i++;
				});
			}else if(type == "radio" && subtype == 'grid'){
				if(obj.attr("checked")){
					var typeChek = obj.attr("typeChek");
					var subid = obj.attr("subid");
					var rows = page.questions[index].rows;
					
					if(page.questions[index].value == undefined){
						page.questions[index].value = new Array(rows.length);
					}
					page.questions[index].value[subid] = obj.val();
				}
			}
		});
	
	}
	
	this.valid = function(){
		var page = this.properties.pages[this.properties.currentPageIndex];
		var questions = page.questions;
		var ret = true;
		var htmlObjects = $("#"+this.properties.id);
		
		var theClassError = 'ui-state-error ui-corner-all';
		for(var i=0; i<questions.length; i++){
			var type = questions[i].type;
			
			var valid = htmlObjects.find('#valid_'+i);
			valid.html('');
			valid.removeClass(theClassError);
			
			if(questions[i].requested == true || type == 'email'){
				if(type == "text"){
					if(questions[i].value == '') {
						ret = false;
						valid.html('El campo es requerido');
						valid.addClass(theClassError);
					}
				}else if(type == "email"){
					if(questions[i].value == '' && questions[i].requested == true) {
						ret = false;
						valid.html('El campo es requerido');
						valid.addClass(theClassError);
					}else if(questions[i].value != '') {
						if(!this.validEmail(questions[i].value)){
							valid.html('Invalid email');
							valid.addClass(theClassError);
							ret = false;
						}
					}
				}else if(type == "radio"){
					if(questions[i].value == undefined || questions[i].value == '') {
						ret = false;
						valid.html('Select element');
						valid.addClass(theClassError);
					}
				}else if(type == "combobox"){
					var continua = questions[i].list != undefined;
					var e=0;
					while(continua && e<questions[i].list.length){
						continua = !questions[i].list[e].selected || questions[i].list[e].value=="";
						e++;
					}
					if(continua){
						ret = false;
						valid.html('Select element');
						valid.addClass(theClassError);
					}
				}else if(type == "grid"){
					if(page.questions[i].value == undefined){
						ret = false;
						for(var e=0; e<page.questions[i].rows.length; e++){
							$('#valid_'+i+"_"+e).html('Select');
							$('#valid_'+i+"_"+e).addClass(theClassError);
						}
					}else{
						for(var e=0; e<page.questions[i].value.length ; e++){
							if(page.questions[i].value[e] == undefined){
								ret = false;
								htmlObjects.find('#valid_'+i+"_"+e).html('Select');
								htmlObjects.find('#valid_'+i+"_"+e).addClass(theClassError);
							}else{
								htmlObjects.find('#valid_'+i+"_"+e).html('');
								htmlObjects.find('#valid_'+i+"_"+e).removeClass(theClassError);
							}
						}
					}
					
				}
			}
		}
		
		return ret;
	}
	
	this.validEmail = function(val){
		var evaluar = val;
		var filter = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		
		if (filter.test(evaluar)){
			return true;
		}else{
			return false;
		}
		
	}
}

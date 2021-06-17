var WEBAPP= window.location.pathname.split("/")[1];

if(WEBAPP.indexOf("index.php") > -1){
	WEBAPP = WEBAPP;
}else{
	WEBAPP=WEBAPP+'/index.php/';
}

var http={
	requestParam:null,	
	postRequest:{ "send":function(action, data, callBackFunc, isLoaderShow){
							if(isLoaderShow){
								http.loader(true);
							}	
							var postRequest = new AjaxPostRequest();
							postRequest.url = "/"+WEBAPP+action ; 
							postRequest.data = data;
							postRequest.callBack = function(response){
								var invoker = eval(callBackFunc);
								invoker(response);
							};
							postRequest.call();   //this method is used to call the ajax request 
						 }
	},
	getRequest:{ "send":function(action,  callBackFunc){ 
					var  getRequest = new AjaxGetRequest();
					getRequest.url = "/"+WEBAPP+action;
					
					getRequest.callBack = function(response){
						callBackFunc(response);	
					};
					 
					getRequest.call();   //this method is used to call the ajax request 
				}
 	},
	fileRequest: { "send":function(action, formData, callBackFunc){ 
							var postRequest = new AjaxFileRequest();
							postRequest.url = "/"+WEBAPP+action;
							postRequest.data = formData;
							
							postRequest.callBack = function(response){
								callBackFunc(response);	
							};
							postRequest.call();   //this method is used to call the ajax request 
				 }
	},

	loadHTMLPage:{ "send":function(action,  callBackFunc){ 
					if (typeof keydownFunction === 'function') {
				 		window.removeEventListener("keydown", keydownFunction);
				 	}
					var  getRequest = new AjaxGetRequest();
					getRequest.url = "/"+WEBAPP+"/"+action;
					http.requestParam = null;
					if(action.indexOf("?")>0){
						http.requestParam = action.split("?")[1];
					}
					getRequest.callBack = function(response){
						callBackFunc(response);	
					};
					 
					getRequest.call();   //this method is used to call the ajax request 
		 	}

	} ,
	loader:function(state){
		if(state){
			$("#loader").css("display","block");
			$("#overlay").css("display","block");
		}else{
			$("#loader").css("display","none");
			$("#overlay").css("display","none");
		}
	}
};	


function AjaxGetRequest(){
	this.url= "";
	this.data =  "";
	this.callBack = "";
	this.paramForCallBack=""; 
	
	this.call= function(){
		$.ajax( {url: this.url,  
			type:'GET', 
			beforeSend: function (xhr) {
				             xhr.setRequestHeader("X-Ajax-call", "true");
			},
	  		data:'',
			accept:'application/json',	
			callBack : this.callBack ,	
		  	success:function(response) { 
				try
				{
					var res =JSON.parse(response);
					if(res.status == 'sessionexpired'){
						alert('Session has been expired');
						window.location.href =WEBAPP;
					}
				}catch (e) {}
				this.callBack( response);
			},
			error:function(errorMsg){  
				    console.log(errorMsg);
				 if(errorMsg.status==401){
					window.location.href = "/"+WEBAPP+"/pages/jsp/sessionexpired.html";
				 }
			} 
		});
	};
}
						 

function AjaxPostRequest(){
	this.url= "";
	this.data =  "";
	this.callBack = "";
	this.paramForCallBack=""; 
 	this.call= function(){
		 
		$.ajax({
			url: this.url,
			dataType:'json' ,   
			type:'POST', 
			beforeSend: function (xhr) {
				/*
				xhr.setRequestHeader("Content-Type","application/json");
       			xhr.setRequestHeader("Accept","application/json");
       			xhr.setRequestHeader("X-Ajax-call", "true");
       			*/
			},
	  		data:this.data,
			accept:'application/json',	
			callBack : this.callBack ,
		  	success:function(response) { 
				try{
					var res =JSON.parse(response);
				}catch(e){
						var res = response;
				}
				if(res.status == 'sessionexpired'){
					alert('Session has been expired');
					// window.location.href =WEBAPP;
				}
				this.callBack( response);
				
			},
			error:function(errorMsg){  
				  //  UIEle.alert.withTitle("Please try again.");
					//alert(errorMsg);
				    console.log(errorMsg);
			 
			}, 
			complete:function(){
				$("#loader").css("display","none");
				$("#overlay").css("display","none");
			} 
		});
	};
}				



function AjaxFileRequest(){
	this.url= "";
	this.data =  "";
	this.callBack = "";
	this.paramForCallBack=""; 
	
	this.call= function(){
		$.ajax( {url: this.url,  
			type:'POST', 
	  		data:this.data,
			processData:false,
	       contentType:false,
			callBack : this.callBack ,
		  	success:function(response) { 
				try{
					var res =JSON.parse(response);
				}catch(e){
						var res = response;
				}
				if(res.status == 'sessionexpired'){
					alert('Session has been expired');
					window.location.href =WEBAPP;
				}
				this.callBack( response);
			},
 			error:function(errorMsg){  
				    console.log(errorMsg);
			} ,
			complete:function(){
					$("#loader").hide();
					$("#uav-lean-overlay").hide();
			}
		});
	};
}


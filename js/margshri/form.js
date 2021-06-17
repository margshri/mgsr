var ajaxRequest ={
	execute: function(URL, parameters, callBackMethod,callBackArgs) {
		new Ajax.Request(URL, 
				{method: 'post',
			     parameters:parameters,
				 onSuccess: function(transport) {
					// console.log('in success');
					// console.log(transport.responseText);
				    try { 
				        if (transport.responseText.isJSON()) {
				            var response = transport.responseText.evalJSON();
				            if (response.error) {
				                alert(response.message);
				            }
				            if(response.ajaxExpired && response.ajaxRedirect) {
				                setLocation(response.ajaxRedirect);
				            }
				           var invoker= ajaxRequest.callBack(eval(callBackMethod),response, callBackArgs);
				           invoker();
				        } else {
							console.log('Not a Json Response');
							var responseArr = transport.responseText.split("<script"); 
							// console.log(responseArr);

							for(var key in responseArr){
								if(!isNaN(key)){
									// console.log("key" + key);
									var jsonStr = responseArr[key];
									var finaljsonStr = jsonStr.trim();
									if(finaljsonStr.isJSON()){
										// console.log(finaljsonStr);
										responseStr = finaljsonStr;
										var response = responseStr.evalJSON();
										if (response.error) {
										    alert(response.message);
										}
										if(response.ajaxExpired && response.ajaxRedirect) {
										    setLocation(response.ajaxRedirect);
										}
										var invoker= ajaxRequest.callBack(eval(callBackMethod),response, callBackArgs);
										invoker();
									}
								}
							}	
							
				        	// alert(transport.responseText);
				        	// window.location.reload();
				        }
				    }
				    catch (e) {
						// console.log('in catch');
						
					    alert(e);
				        $(tabContentElementId).replace(transport.responseText);
				    }
				 } , //on success
			     onFailure:  function(response){
					// console.log('in failure');
					// console.log(response.responseText);

               	 	 errorWindow=window.open();
                   	 newdocument=errorWindow.document;
                   	 newdocument.write(response.responseText);
                   	 newdocument.close();
	             } //onFailure																					 
			    });//  Method
	}, // execute function
	      
    callBack: function (callBackMethod,response, callBackArgs){
		 return function () {
	        return callBackMethod(response, callBackArgs);
	     };
	}
	      
};


function callBack(callBackMethod,response, callBackArgs){
	 return function () {
	        return callBackMethod(response, callBackArgs);
	 };
}

function show_props(obj, obj_name) {
    var result = "";
    for (var i in obj)
    result += obj_name + "." + i + " = " + obj[i] +"\n ";   
    alert(result);
}

var UTILITY = {
	parseToInt : function(value){
				  if( isNaN(parseInt(value,10)) ){
					   return 0 ;
				  }else {
					  return parseInt(value,10);
				  }
    },
    
    leftPadding:  function(value, length, character){
    	var pad = Array(length+1).join(character);
    	string =value.toString() ;
    	str= pad.substring(0, pad.length - string.length) + string;
    	
    	return str;
    },
    
    rightPadding:  function(value, length, character){
    	var pad = Array(length+1).join(character);
    	string =value.toString() ;
    	str=  string + pad.substring(0, pad.length - string.length) ;
    	
    	return str;
    },

    isNumber: function(string){
    	if(isNaN(string)===true){
    		return false;
    	}else{
    		return true;
    	}
    }
    
};


var MESSAGEHANDLER ={
	errorMessagePublish: function(msgArray, container){
		var wrapper  = "<ul class='messages'>";
		wrapper += "<li class='error-msg'>";

		for(var obj=0;  obj<msgArray.length; obj++){
			wrapper += "<ul><li><span>" +  msgArray[obj] + "</span></li></ul>";
		}
		container.innerHTML = wrapper;
	},
	
	successMessagePublish: function(msgArray, container){
		var wrapper  = "<ul class='messages'>";
		wrapper += "<li class='success-msg'>";

		for(var obj=0;  obj<msgArray.length; obj++){
			wrapper += "<ul><li><span>" +  msgArray[obj] + "</span></li></ul>";
		}
		container.innerHTML = wrapper;
	}	

};



var MYSQLDATETIMECONVERT={
		toJS:function($mysqlData){
			
			// Split timestamp into [ Y, M, D, h, m, s ]
			var t = $mysqlData.split(/[- :]/);

			// Apply each element to the Date function
			var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
			
			return UTILITY.leftPadding(d.getDay(), 2, 0) + "/" + UTILITY.leftPadding(d.getMonth()+1, 2, 0) +"/" +  UTILITY.leftPadding(d.getFullYear(), 4, 0) + " "+ UTILITY.leftPadding(d.getHours().toString(),2,0) + ":"+ UTILITY.leftPadding(d.getMinutes().toString(),2,0) + ":" + UTILITY.leftPadding(d.getSeconds().toString() ,2,0);
		}

		 

};


var MYSQLDATECONVERT={
		toJS:function($mysqlData){
			
			// Split timestamp into [ Y, M, D ]
			var t = $mysqlData.split(/[-]/);

			// Apply each element to the Date function
			var d = new Date(t[0], t[1]-1, t[2]);
			return UTILITY.leftPadding(d.getDay(), 2, 0) + "/" + UTILITY.leftPadding(d.getMonth()+1, 2, 0) +"/" +  UTILITY.leftPadding(d.getFullYear(), 4, 0);
		},
		
		toSQL:function($jsData){
			if($jsData=="") return "";
			// Split timestamp into [ Y, M, D ]
			
			//var t = $jsData.split(/[/]/);
			var t = $jsData.split('/');
		
			// Apply each element to the Date function
			
			var d = new Date(t[2] , t[1]-1, t[0] );
			
			if ( isNaN( d.getDay() ) ){
				return "";
			}
			return UTILITY.leftPadding(d.getFullYear(), 4, 0) + "-" + UTILITY.leftPadding(d.getMonth()+1, 2, 0) + "-" + UTILITY.leftPadding(d.getDay()-1, 2, 0) ;     
		}
};


var UI={
		 elementDisabled: function(el, state){
				try {
					    el.disabled = state ;
					}catch(E){}
					    
					if (el.childNodes && el.childNodes.length > 0) {
					        for (var x = 0; x < el.childNodes.length; x++) {
					        	this.elementDisabled(el.childNodes[x],state);
					        }
					}
		        	
					    
					    
			},
			elementVisibility: function(el, state){
				el.style.display = state;
			}
};

var Table = {
	truncateTableBody: function(tableBodyID){ 
		while($(tableBodyID).rows.length >0){
		          $(tableBodyID).deleteRow(0);
		}
	}
};


var DateTime = {
		
	toUnixTimeStamp: function(dateString){
		var unixTimeStamp = Date.parse(dateString);
		return unixTimeStamp;
	},

	
	toMySql: function(dateString){
		 
		// dateString in dd/mm/yyyy h:i:s format 
		var dateTimeParts = dateString.split('/');
		
		var date  = dateTimeParts[0];
		var month = dateTimeParts[1];
		var yearTimeParts = dateTimeParts[2].split(' ');
		var year = yearTimeParts[0];
		var timeString = yearTimeParts[1];
		
		dateString = year.toString() + '/' +  month.toString() + '/' + date.toString() + ' ' + timeString.toString();
		// now dateString yyyy/mm/dd H:i:s  format 
		
		
		 var dateObj = new Date(dateString);
		 
		 var year  = dateObj.getFullYear();
	     var month = dateObj.getMonth();
	     var date  = dateObj.getDate();
	     var hour  = dateObj.getHours();
	     var min   = dateObj.getMinutes();
	     var sec   = dateObj.getSeconds();
	     
	     var MySqlDateTime  =  ( UTILITY.leftPadding(year, 4, 0) ).toString() + '-' + ( UTILITY.leftPadding((month+1), 2, 0) ).toString() + '-'  + ( UTILITY.leftPadding(date, 2, 0) ).toString() + ' ' + ( UTILITY.leftPadding(hour, 2, 0) ).toString() + ':' + ( UTILITY.leftPadding(min, 2, 0) ).toString() + ':' + ( UTILITY.leftPadding(sec, 2, 0) ).toString() ;
	     // now yyyy-mm-dd H:i:s
	     
	     dateObj = null;
	     return MySqlDateTime;

	},
	
	toJS: function(dateString){
		//  dateString in yyyy-mm-dd h:i:s format
		var dateTimeParts = dateString.split('-');
		
		var year  = dateTimeParts[0];
		var month = dateTimeParts[1];
		
		var dayTimeParts = dateTimeParts[2].split(' ');
		var date = dayTimeParts[0];
		var timeString = dayTimeParts[1];
		
		dateString = year.toString() + '/' +  month.toString() + '/' + date.toString() + ' ' + timeString.toString();
		
		  
		 
		 var dateObj = new Date(dateString);
		 
		 var year  = dateObj.getFullYear();
	     var month = dateObj.getMonth();
	     var date  = dateObj.getDate();
	     var hour  = dateObj.getHours();
	     var min   = dateObj.getMinutes();
	     var sec   = dateObj.getSeconds();
	     
	     var JSDateTime  =  ( UTILITY.leftPadding(date, 2, 0) ).toString() + '/' + ( UTILITY.leftPadding((month+1), 2, 0) ).toString() + '/'  + ( UTILITY.leftPadding(year, 4, 0) ).toString() + ' ' + ( UTILITY.leftPadding(hour, 2, 0) ).toString() + ':' + ( UTILITY.leftPadding(min, 2, 0) ).toString() + ':' + ( UTILITY.leftPadding(sec, 2, 0) ).toString() ;
	     dateObj = null;
	     return JSDateTime;

	},
	
	toYmdFormat: function(dateString){
		
		var dateTimeParts = dateString.split('/');
		
		var date  = dateTimeParts[0];
		var month = dateTimeParts[1];
		var yearTimeParts = dateTimeParts[2].split(' ');
		var year = yearTimeParts[0];
		var timeString = yearTimeParts[1];
		
		dateString = year.toString() + '/' +  month.toString() + '/' + date.toString() + ' ' + timeString.toString();
		return dateString; 
		 
	},
	
	todmYFormat: function(dateString){
		
		var dateTimeParts = dateString.split('/');
		
		var year  = dateTimeParts[0];
		var month = dateTimeParts[1];
		
		var dayTimeParts = dateTimeParts[2].split(' ');
		var date = dayTimeParts[0];
		var timeString = dayTimeParts[1];
		
		dateString = date.toString() + '/' +  month.toString() + '/' + year.toString() + ' ' + timeString.toString();
		return dateString; 
		 
	},
	
    toMySqlDate: function(dateString){
		
		var dateTimeParts = dateString.split('/');
		
		var date  = dateTimeParts[0];
		var month = dateTimeParts[1];
		var year  = dateTimeParts[2];
		
		dateString = year.toString() + '-' +  month.toString() + '-' + date.toString();
		return dateString; 
		 
	},
	
	getDateTimeDiff: function(startDateTimeStr, endDateTimeStr){
		var startDateTime = new Date(startDateTimeStr).getTime();
		var endDateTime = new Date(endDateTimeStr).getTime();
		var differenceDateTime = endDateTime - startDateTime;
		var differenceDateTimeObj = new Object();
		// Time calculations for days, hours, minutes and seconds
		differenceDateTimeObj.Days = Math.floor(differenceDateTime / (1000 * 60 * 60 * 24));
		differenceDateTimeObj.Hours = Math.floor((differenceDateTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		differenceDateTimeObj.Minutes = Math.floor((differenceDateTime % (1000 * 60 * 60)) / (1000 * 60));
		differenceDateTimeObj.Seconds = Math.floor((differenceDateTime % (1000 * 60)) / 1000);
		return differenceDateTimeObj;
	}
	
};


var ImageView = {
		// Image Zooming 
        zoomImage: function(event){

	    	   var tr = Event.findElement(event, 'tr');
	    	   var rowIndex = (tr.children[0].children[0].id.split('_') )[3];
	    	   var imageSrc = $('dispatchplan_product_row_'+(rowIndex).toString()+'_Image').value;
	
	    	   var imageElement ='<div style="text-align:center;"><img src ="'+imageSrc+'" alt="product Image" width="300px" height="300px" style="margin:auto;" /></div>';  
	    	   Image.colorBox(imageElement);
	   	}
};



var DateTimeValidation={
		time: function(fieldvalue){
			var errorMsg = "";

		    // regular expression to match required time format
		    re = /^(\d{1,2}):(\d{2})(:00)?([ap]m)?$/;

		    if(fieldvalue != '') {
		      if(regs = fieldvalue.match(re)) {
		        if(regs[4]) {
		          // 12-hour time format with am/pm
		          if(regs[1] < 1 || regs[1] > 12) {
		            errorMsg = "Invalid value for hours: " + regs[1];
		          }
		        } else {
		          // 24-hour time format
		          if(regs[1] > 23) {
		            errorMsg = "Invalid value for hours: " + regs[1];
		          }
		        }
		        if(!errorMsg && regs[2] > 59) {
		          errorMsg = "Invalid value for minutes: " + regs[2];
		        }
		      } else {
		        errorMsg = "Invalid time format: " + fieldvalue;
		      }
		    }

		    if(errorMsg != "") {
		      return errorMsg;
		    }

		    return errorMsg;
		}
		
};

var Validate={
		isEmailValid: function(email){
			// regular expression to match email format
			var emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		    if(emailRegex.test(email) == false){
				return false;
			}else{
				return true;
			}
		},

		isMobileNOValid: function(mobileNO){
			// regular expression to match mobile format
			var mobileRegex = /^[0]?[456789]\d{9}$/;
		    if(mobileRegex.test(mobileNO) == false){
				return false;
			}else{
				return true;
			}
		}

			
};
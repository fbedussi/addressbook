function checkAll(formname, caller)
{
    var checkboxes = new Array();
    var checktoggle = caller.checked;
   
    checkboxes = document.getElementsByTagName('input');
	
    for (var i = 0; i < checkboxes.length; i++) {
	if (checkboxes[i].type === 'checkbox') {
	    checkboxes[i].checked = checktoggle;
	}
    }
    
}


function hideDetailWin() {
	var position = $('#enlargeWindow').css("top") ? $('#enlargeWindow').css("top") : "0px";
	//delete the "px" from the string
	position = position.substr(0,position.length-2);
	$(window).scrollTop(position);
	$('#enlargeWindow').hide();
	$('#curtain').addClass('hide');
}

function showDetailWin() {
    var position = $(window).scrollTop();
    $('#enlargeWindow').css("top",position).show();
    $('#curtain').removeClass('hide');
}

function showAllFields() {
	$('.no-mobile').removeClass('no-mobile').addClass('no-mobile-hided');
	$('#hide-fields').css('display' , 'inline');
	$('#show-all-fields').css('display', 'none');
}

function hideFields() {
	$('.no-mobile-hided').removeClass('no-mobile-hided').addClass('no-mobile');
	$('#hide-fields').css('display' , 'none');
	$('#show-all-fields').css('display', 'inline');
	
}

function applyDataTable() {
	var table = $('#search-results-table').DataTable({
		"paging": false,
		"autoWidth": true,
		responsive: true
		});
	//new $.fn.dataTable.FixedHeader(table);
	return(table);
}

function details(id) {
       showDetailWin();
       var xmlhttp=new XMLHttpRequest();
       xmlhttp.onreadystatechange=function() {
	   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	     document.getElementById("enlargeWindowInner").innerHTML=xmlhttp.responseText;
	   }
       }
       xmlhttp.open("GET","index.php?detail=1&id="+id,true);
       xmlhttp.send();
   }

function copyOrDeleteContact(id,name,action,message) {
        
	//if action is DELETE request confirmation
	//if (action =='del') {
	//	var txt = message+" "+name;
	//	var conf = confirm(txt);
	//} else { //if it's just copy go on
	//	conf = true;
	//}
	var conf = (action == 'del') ? confirm(message+" "+name) : true;
	
        if (conf) {
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    //get the table ordering
                    var order = $('#search-results-table').DataTable().order();
                    
                    //inject AJAX content
                    document.getElementById("searchResults").innerHTML=xmlhttp.responseText;
                    
                    hideDetailWin();
                    
                    //apply dataTable and table order again
                    applyDataTable().order(order).draw();
				
		    location.hash = "#searchResults";
                }
            }
            xmlhttp.open("GET","index.php?action="+action+"&id="+id,true);
            xmlhttp.send();
        }
    }
    
function deleteAll(message) {
        
	var conf = confirm(message);
	
        if (conf == true) {
		
		var idString = "";
		var checkboxes = new Array();
		checkboxes = document.getElementById('search-results-table').getElementsByTagName('input');
	    
		for (var i = 0; i < checkboxes.length; i++) {
			if ((checkboxes[i].type === 'checkbox') && (checkboxes[i].checked))  {
			    idString += checkboxes[i].value+",";
			}
		}
		
		//delete the final colon
		idString = idString.substring(0,idString.length-1);
		
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			//get the table ordering
			var order = $('#search-results-table').DataTable().order();
			
			//inject AJAX content
			document.getElementById("searchResults").innerHTML=xmlhttp.responseText;
			
			hideDetailWin();
			
			//apply dataTable and table order again
			applyDataTable().order(order).draw();
			}
		}
		xmlhttp.open("POST","index.php",true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("action=delall&id="+idString);
        }
    }
    
    
function filterSelected() {
	//reset the form because what is shown is no more the result of a research
	document.getElementById("search-form").reset();
	
	var idString = "";
	var checkboxes = new Array();
	
	checkboxes = document.getElementById('search-results-table').getElementsByTagName('input');
    
	for (var i = 0; i < checkboxes.length; i++) {
		if ((checkboxes[i].type === 'checkbox') && (checkboxes[i].checked))  {
		    idString += checkboxes[i].value+",";
		}
	}
	
	//delete the final colon
	idString = idString.substring(0,idString.length-1);
	
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			//get the table ordering
			var order = $('#search-results-table').DataTable().order();
			
			//inject AJAX content
			document.getElementById("searchResults").innerHTML=xmlhttp.responseText;
			
			hideDetailWin();
			
			//apply dataTable and table order again
			applyDataTable().order(order).draw();
			
			location.hash = "#searchResults";
		}
	}
	xmlhttp.open("POST","index.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("action=select&id="+idString);
}

function resetSearchForm() {
	document.getElementById("search-form").reset();
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("searchResults").innerHTML='';
			hideDetailWin();
            }
        }
 
	xmlhttp.open("GET","index.php?reset=1",true);
	xmlhttp.send();
	
};

function searchContacts(message) {
	//display curtesy message
	$('#alertBox').removeClass("hide");
	document.getElementById("alertBox").innerHTML="<p>"+message+"</p>";
	
	var dataString = "";
	var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			   document.getElementById("searchResults").innerHTML=xmlhttp.responseText;
		    
			   applyDataTable();
			   
			   $('#alertBox').addClass("hide");
			   
			   location.hash = "#searchResults";
			   
			   
			}
        }
        
	//receive the arguments in select tag
	selectTag = document.getElementById('search-form').getElementsByTagName('select');
	for(var i=0; i<selectTag.length; i++)
	{
		value = escape(selectTag[i].value);
		if (value !="") {
			dataString += '&'+selectTag[i].name+'='+value;
		}
	}
	
	//receive the arguments in input tag
	inputTag = document.getElementById('search-form').getElementsByTagName('input');
	for(var i=0; i<inputTag.length; i++)
	{
		value = escape(inputTag[i].value);
		if (value !="") {
			dataString += '&'+inputTag[i].name+'='+value;
		}
	}
	
	//send it to the script
	xmlhttp.open("POST","index.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        console.log(dataString);
	xmlhttp.send("search=1&"+dataString);
	
	location.hash = "#alert-box";
	
};
    
function add() {
	console.log('add');
       showDetailWin();
       var xmlhttp=new XMLHttpRequest();
       xmlhttp.onreadystatechange=function() {
	   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	     document.getElementById("enlargeWindowInner").innerHTML=xmlhttp.responseText;
	   }
       }
       xmlhttp.open("GET","index.php?add=1",true);
       xmlhttp.send();
   }
    
function addContact() {
	hideDetailWin();
	var dataString = "";
	var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("searchResults").innerHTML=xmlhttp.responseText;
			
			applyDataTable();
            }
        }
        
	//receive the arguments and build the query string
	for(var i=0; i<arguments.length; i++)
	{
		value = escape(document.getElementById(arguments[i]+"-value").value);
		if (value !="") {
			dataString += '&'+arguments[i]+'='+value;
		}
	}
	
	//send it to the script
	xmlhttp.open("POST","index.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        console.log(dataString);
	xmlhttp.send("add=1"+dataString);
	
};

function edit(id) {
	showDetailWin();
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
              document.getElementById("enlargeWindowInner").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","index.php?edit=1&id="+id,true);
        xmlhttp.send();
};

function editContact() {
	hideDetailWin();
	var dataString = "";
	var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
              //get the table ordering
		var order = $('#search-results-table').DataTable().order();
		
		//inject AJAX content
		document.getElementById("searchResults").innerHTML=xmlhttp.responseText;
		
		hideDetailWin();
		
		//apply dataTable and table order again
		applyDataTable().order(order).draw();  
            }
        }
        
	//receive the arguments and build the query string
	for(var i=0; i<arguments.length; i++)
	{
		console.log(arguments[i]);
		value = escape(document.getElementById(arguments[i]+"-value").value);
		if (value !="") {
			dataString += '&'+arguments[i]+'='+value;
		}	
	}	
	
	//send it to the script
	xmlhttp.open("POST","index.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send("edit=1"+dataString);
	
};



$(document).ready(function() {
	hideDetailWin();
	$('.close-button, #curtain').click(function(){
	    hideDetailWin()
	});
});
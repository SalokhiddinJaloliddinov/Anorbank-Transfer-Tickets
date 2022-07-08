// Sample JS function to be called from a custom menu item
function MyCustomJSFunction(sName)
{
	/* var settings = {
		"url": "https://testdesk.anorbank.uz/pages/transfer/process.php",
		"method": "POST",
		"timeout": 0,
		"headers": {
		  "Content-Type": "application/x-www-form-urlencoded",
		  "Cookie": "PHPSESSID=r1ulqjeomul1rm4nvupam4jbt0"
		},
		"data": {
		  "save": "",
		  "id": sName
		}
	  };
	  
	  $.ajax(settings).done(function (response) {
		console.log(response);
	  });

	  alert(sName + ' successed')
	  location.reload(); */


	  /* let $div = $("<div>", {id: "foo", "class": "modal", "role": "dialog", "tabindex": "-1"});
	  
	  $("body").append($div);
	  $("#foo").css({"width": "100%", "height": "200px", "background-color": "red", "z-index": "99999", "position": "absolute"}); */

	  
	let $div = $("<div>", {id: "dialog", "title": "Basic dialog"});
	let service_label = "<p>Выберите Услугу</p>";
	let servicesubcategory_label = "<p>Выберите Подкатегорию</p>";
	let transfer_button = $("<button>", {id: "transfer_button"});
	let select_service = $("<select>", {id: "select_service"});
	let select_servicesubcategory = $("<select>", {id: "select_servicesubcategory"});
	let transfer_to = $("<select>", {id: "transfer_to"});
	
	
	$("body").append($div);
	$("#dialog").append(transfer_to);
	$("#transfer_to").append("<option value='' selected>-- Выберите --</option>")
	if (sName.includes('D')) {
		$("#transfer_to").append("<option value='I'>Инцидент</option><option value='R'>Заявка</option>");
	} else if (sName.includes('R')) {
		$("#transfer_to").append("<option value='I'>Инцидент</option><option value='D'>Доставка Карт</option>");
	} else if (sName.includes('I')) {
		$("#transfer_to").append("<option value='R'>Заявка</option><option value='D'>Доставка Карт</option>");
	}
	$("#dialog").append(service_label, select_service, "<br><br>", servicesubcategory_label, select_servicesubcategory, "<br><br>", transfer_button);
	$("#transfer_button").append("<b>Трансфер</b>");
	$(function(){
		$("#dialog").dialog({
			minWidth: 700,
			title: "Перекидка тикетов"
		});
	})
	$("#select_service").append("<option value='' selected>-- Выберите --</option")


	$("#transfer_to").change(function() {
		var val_type = $("#transfer_to").val();
		if (val_type === "I") {
			var type = 'incident';
		} else if (val_type === "R") {
			var type = 'service_request';
		} else if (val_type === "D") {
			var type = 'delivery_request';
		}
		
		var service = {
			"url": "https://testdesk.anorbank.uz/sd_api/api/post/index.php?type="+type+"",
			"method": "POST",
			"timeout": 0,
		};

		$.ajax(service).done(function (response) {
			$("#select_service").children().remove();
			$("#select_service").append("<option value='' selected>-- Выберите --</option>");
			console.log(response);
			$.each(response, function(i,res) {
			$("#select_service").append("<option value='" + res.id + "'>" + res.name + "</option>");
			});		
		});
	})	  
	
	/* $.ajax(servicesubcategory).done(function (response) {
		console.log(response);
		$.each(response, function(i,res) {
			$("#select_servicesubcategory").append("<option value='" + res.id + "'>" + res.name + "</option>");
			
		});		
	}); */

	$("#select_service").change(function()
	  {
		var val = $("#select_service").val();
		var val_type = $("#transfer_to").val();
		if (val_type === "I") {
			var type = 'incident';
			alert(sName);
		} else if (val_type === "R") {
			var type = 'service_request';
		} else if (val_type === "D") {
			var type = 'delivery_request';
		}
		var settings = {
			"url": "https://testdesk.anorbank.uz/sd_api/api/post/servicesubcategory.php?id="+val+"&type=" + type +"",
			"method": "POST",
			"timeout": 0,
		  };
		  
		  $.ajax(settings).done(function (response) {
			$("#select_servicesubcategory").children().remove();
			console.log(response);
			$.each(response, function(i,res) {
				$("#select_servicesubcategory").append("<option value='" + res.id + "'>" + res.name + "</option>");
			});	
		  });
	  });	
	

	$("#transfer_button").click(function() {
		var attr_service_id = $("#select_service").val();
		var attr_servicesubcategory_id = $("#select_servicesubcategory").val();
		var transfer_to = $("#transfer_to").val();
		var settings = {
			"url": "https://testdesk.anorbank.uz/pages/transfer/process.php",
			"method": "POST",
			"timeout": 0,
			"headers": {
			  "Content-Type": "application/x-www-form-urlencoded"
			},
			"data": {
			  "save": "",
			  "id": sName,
			  "attr_service_id": attr_service_id,
			  "attr_servicesubcategory_id": attr_servicesubcategory_id,
			  "transfer_to": transfer_to
			}
		  };
		  
		  $.ajax(settings).done(function (response) {
			console.log(response);
		  });
	
		  alert(sName + ' успешно перекинулся');
		  location.reload();
	});
	$(".ui-dialog-titlebar-close").click(function(){
		location.reload();
	});
	
}

function MyCustomJSDeliveryFunction(sName) {
	if(sName.includes('D')) {
		alert(sName);
	} else 
	{
		alert('dududu');
	}
}

// Sample JS function to be called from a custom menu item
// on a list of objects
function MyCustomJSListFunction(iCount)
{
	alert('There are '+iCount+' element(s) in this list.');
}
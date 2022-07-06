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
	let pipi = "<p>Выберите Услугу и подкатегорию</p>";
	let pipi_button = $("<button>", {id: "pipi_button"});
	let pipi_select = $("<select>", {id: "pipi_select"});
	let pipi_select_2 = $("<select>", {id: "pipi_select_2"});
	
	$("body").append($div);
	if (sName.includes('D')) {
		$("#dialog").append("<select id='transfer_to'><option value='I'>Инцидент</option><option value='R'>Заявка</option></select>");
	} else if (sName.includes('R')) {
		$("#dialog").append("<select id='transfer_to'><option value='I'>Инцидент</option><option value='D'>Доставка Карт</option></select>");
	} else if (sName.includes('I')) {
		$("#dialog").append("<select id='transfer_to'><option value='R'>Заявка</option><option value='D'>Доставка Карт</option></select>");
	}
	$("#dialog").append(pipi, pipi_select, pipi_select_2, pipi_button);
	$("#pipi_button").append("<b>Трансфер</b>");
	$(function(){
		$("#dialog").dialog({
			minWidth: 700,
			title: "Перекидка тикетов"
		});
	})	
	var service = {
		"url": "https://testdesk.anorbank.uz/sd_api/api/post/",
		"method": "POST",
		"timeout": 0,
	};

	var servicesubcategory = {
		"url": "https://testdesk.anorbank.uz/sd_api/api/post/servicesubcategory.php",
		"method": "POST",
		"timeout": 0,
	};

		  
	$.ajax(service).done(function (response) {
		console.log(response);
		$.each(response, function(i,res) {
			$("#pipi_select").append("<option value='" + res.id + "'>" + res.name + "</option>");
		});		
	});

	$("#pipi_select").change(function() {
		let $selectval = $("#pipi_select").val();
	});
	$.ajax(servicesubcategory).done(function (response) {
		console.log(response);
		$.each(response, function(i,res) {
			$("#pipi_select_2").append("<option value='" + res.id + "'>" + res.name + "</option>");
			
		});		
	});

	$("#pipi_button").click(function() {
		var attr_service_id = $("#pipi_select").val();
		var attr_servicesubcategory_id = $("#pipi_select_2").val();
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
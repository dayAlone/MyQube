var Dashboard = {
	LiveCounterRegistrationsParams:{
		DateFrom:"",
		DateTo: "",
		IntervalID: ""
	},
	ChangeUserStatus:function(Obj){
		if($(Obj).attr("id") > 0){
			$.ajax({
				type: "POST",
				url: "/ajax/change_user_status.php",
				data: "id="+$(Obj).attr("id"),
				error:function(){
					alert("Произошла ошибка повторите попытку.");
				},
				success: function(Answer){
					var JsonParse = JSON.parse(Answer);
					$(Obj).parent().parent().children().eq(1).empty().append(JsonParse.Flag ? "Да" :"Нет");
					$(Obj).empty().append(JsonParse.Flag ? "Деактивировать" :"Активировать");
				}
			});
		}
	},
	GetStatisticsRegistrationsConsultant:function(Obj){
		if($(Obj).attr("id") > 0){
			$.fancybox.showLoading()
			$.ajax({
				type: "POST",
				url: "/ajax/get_statistics_registrations_consultant.php",
				data: "id="+$(Obj).attr("id"),
				error:function(){
					$.fancybox.hideLoading()
					alert("Произошла ошибка повторите попытку.");
				},
				success: function(Answer){
					var StrHtml = "";
					var j = 0;
					var JsonParse = JSON.parse(Answer);
					$.fancybox.hideLoading()
					StrHtml += "<table cellpadding=\"0\" cellspacing=\"0\">";
						StrHtml += "<thead>";
							StrHtml += "<tr>";
								StrHtml += "<td colspan='3'>Список консультантов</td>";
							StrHtml += "</tr>";
							StrHtml += "<tr>";
								StrHtml += "<td>Логин</td><td>Email</td><td>Дата регистрации</td>";
							StrHtml += "</tr>";
						StrHtml += "</thead>";
						StrHtml += "<tbody>";
						for(i in JsonParse){
							++j;
							StrHtml += "<tr>";
								StrHtml += "<td>";
								StrHtml += JsonParse[i]["Login"]+"</td>";
								StrHtml += "<td>";
								StrHtml += JsonParse[i]["Email"]+"</td>";
								StrHtml += "<td>";
								StrHtml += JsonParse[i]["DateRegister"]+"</td>";
							StrHtml += "</tr>";
						}
						if(j == 0) {
							StrHtml += "<tr>";
								StrHtml += "<td colspan=\"3\">Данных не найдено</td>";
							StrHtml += "</tr>";
						}
						StrHtml += "</tbody>";
					StrHtml += "</table>";
					$.fancybox.open({type:"inline",content:StrHtml})
				}
			});
		}
	},
	GetStatisticsRegistrationsSupervisor:function(Obj){
		if($(Obj).attr("id") > 0){
			$.fancybox.showLoading()
			$.ajax({
				type: "POST",
				url: "/ajax/get_statistics_registrations_supervisor.php",
				data: "id="+$(Obj).attr("id"),
				error:function(){
					$.fancybox.hideLoading()
					alert("Произошла ошибка повторите попытку.");
				},
				success: function(Answer){
					var StrHtml = "";
					var j = 0;
					var JsonParse = JSON.parse(Answer);
					$.fancybox.hideLoading()
					StrHtml += "<table cellpadding=\"0\" cellspacing=\"0\">";
						StrHtml += "<thead>";
							StrHtml += "<tr>";
								StrHtml += "<td>Id</td>";
								StrHtml += "<td>Имя</td>";
								StrHtml += "<td>Фамилия</td>";
								StrHtml += "<td>Login</td>";
								StrHtml += "<td>Имя консультанта</td>";
								StrHtml += "<td>Фамилия консультанта</td>";
							StrHtml += "</tr>";
						StrHtml += "</thead>";
						StrHtml += "<tbody>";
						for(i in JsonParse){
							++j;
							StrHtml += "<tr>";
								StrHtml += "<td>"+JsonParse[i]["Id"]+"</td>";
								StrHtml += "<td>"+JsonParse[i]["Name"]+"</td>";
								StrHtml += "<td>"+JsonParse[i]["LastName"]+"</td>";
								StrHtml += "<td>"+JsonParse[i]["Login"]+"</td>";
								StrHtml += "<td>"+JsonParse[i]["ConsultantName"]+"</td>";
								StrHtml += "<td>"+JsonParse[i]["ConsultantLastName"]+"</td>";
							StrHtml += "</tr>";
						}
						if(j == 0) {
							StrHtml += "<tr>";
								StrHtml += "<td colspan=\"4\">Данных не найдено</td>";
							StrHtml += "</tr>";
						}
						StrHtml += "</tbody>";
					StrHtml += "</table>";
					$.fancybox.open({type:"inline",content:StrHtml})
				}
			});
		}
	},
	GetListConsultant:function(Obj){
		if($(Obj).attr("id") > 0){
			$.ajax({
				type: "POST",
				url: "/ajax/get_list_consultant.php",
				data: "id="+$(Obj).attr("id"),
				error:function(){
					$.fancybox.hideLoading()
					alert("Произошла ошибка повторите попытку.");
				},
				success: function(Answer){
					var StrHtml = "";
					var j = 0;
					var JsonParse = JSON.parse(Answer);
					$.fancybox.hideLoading()
					StrHtml += "<table cellpadding=\"0\" cellspacing=\"0\">";
						StrHtml += "<thead>";
							StrHtml += "<tr>";
								StrHtml += "<td>Список консультантов</td>";
							StrHtml += "</tr>";
						StrHtml += "</thead>";
						StrHtml += "<tbody>";
						for(i in JsonParse){
							++j;
							StrHtml += "<tr>";
								StrHtml += "<td>"+JsonParse[i]["Login"]+"</td>";
							StrHtml += "</tr>";
						}
						if(j == 0) {
							StrHtml += "<tr>";
								StrHtml += "<td colspan=\"4\">Данных не найдено</td>";
							StrHtml += "</tr>";
						}
						StrHtml += "</tbody>";
					StrHtml += "</table>";
					$.fancybox.open({type:"inline",content:StrHtml})
				}
			});
		}
	},
	SetSupervisor:function(Obj,IdSupervisor){
		var StrHtml = "";
		if($(Obj).attr("id") > 0){
			Dashboard.GetSupervisor($(Obj).attr("id"),IdSupervisor);
			$.fancybox.open({type:"inline",content:"<h1>Идет загрузка супервайзеров.</h1>",modal:true})
		}
	},
	GetSupervisor:function(IdConsultant,IdSupervisor){
		$.ajax({
			type: "POST",
			url: "/ajax/get_supervisor.php",
			success: function(Answer){
				var StrHtml = "";
				var j = 0;
				var JsonParse = JSON.parse(Answer);
				StrHtml += "<div>";				
				for(i in JsonParse){
					++j;
					StrHtml += "<input onclick=\"Dashboard.SetSupervisorConsultant(this)\" type=\"radio\"  ";
					StrHtml += " name=\""+IdConsultant+"\""
					StrHtml += (JsonParse[i]["Id"] == IdSupervisor ? " checked=\"checked\" " : "");
					StrHtml += " value=\""+JsonParse[i]["Id"]+"\" />"
					StrHtml += JsonParse[i]["Name"]+"&nbsp;"+JsonParse[i]["LastName"]+"&nbsp;("+JsonParse[i]["Login"]+")";
					StrHtml += "<br />";
				}
				if(j == 0) {
					StrHtml += "<div>Данных не найдено</div>";
				}
				StrHtml += "</div>";
				$.fancybox.open({type:"inline",content:StrHtml})
			}
		});
	},
	SetSupervisorConsultant:function(Obj){
		if($(Obj).attr("name") > 0 && $(Obj).val() > 0){
			$.ajax({
				type: "POST",
				url: "/ajax/set_supervisor_consultant.php",
				data: "id_consultant="+$(Obj).attr("name")+"&id_supervisor="+$(Obj).val()
			});
			$.fancybox.close();
		}
	},
	SetLiveCounterRegistrations:function(){
		Dashboard.LiveCounterRegistrationsParams.DateFrom = $("#DateFrom").val();
		Dashboard.LiveCounterRegistrationsParams.DateTo = $("#DateTo").val();
		Dashboard.GetCounterRegistrations();
		Dashboard.LiveCounterRegistrationsParams.IntervalID = setInterval( Dashboard.GetCounterRegistrations , 60000);
	},
	GetCounterRegistrations:function(){
		$.ajax({
			type: "POST",
			url: "/ajax/get_counter_registrations.php",
			data: Dashboard.LiveCounterRegistrationsParams,
			success: function(Answer){
				var JsonParse = JSON.parse(Answer);			
				for(i in JsonParse){
					$("#live_c_r_"+JsonParse[i]["Id"]).empty().append(JsonParse[i]["Count"]);
				}
			}
		});
	}
}
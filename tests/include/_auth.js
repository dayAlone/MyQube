
var host        = 'http://myqube.ru';
var path        = '/app.php';
var url         = host + path;
var sessid      = null;
var userRole    = null;
var showPromo   = null;
var getZip      = "Y";

function make_base_auth(user, password) {
	var tok = user + ':' + password;
	var hash = btoa(tok);
	return "Basic " + hash;
}

function requestAuth(login, password) {

	var deferred = Q.defer();
	var auth = $.base64.encode(login + ':' + password);
	console.log('requestAuth() auth: ' + auth);

	$.ajax({
		url: url + '?mode=checkauth',
		method: 'POST',
		beforeSend: function( xhr ){
			xhr.setRequestHeader('Authorization', 'Basic ' + auth);
			//xhr.setRequestHeader('Method', 'POST');
		},
		success: function (data, status) {
			var objData = null;
			if (status === 'success') {
				console.log('requestAuth AJAX data: ' + data);
				data = JSON.parse(data);
				data = data[0];
				console.log('data after [0]: ' + JSON.stringify(data) );
				if ("OK" == data.status || "OK" == data.status) {
					sessid = data.sessid;
					userRole = data.role;
					showPromo = data.show_promo;
					deferred.resolve();
				} else {
					deferred.reject(new Error("Wrong status"));
				}               
			} else {
				deferred.reject(new Error("Status code was " + status));
			}
		},
		error: function( jqXHR, textStatus, errorThrown ) {
			deferred.reject(new Error("Can't XHR " + textStatus + "(" + errorThrown + ")" ));
		}
	});

	return deferred.promise;
};
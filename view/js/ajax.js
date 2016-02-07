var AjaxRequest = function(url, method, data, callback, errCallback, loadCallback, async) {

	this.url = url;
	this.method = (method.toUpperCase() == 'POST') ? 'POST' : 'GET';
	this.async = async;
	this.callback = callback;
	this.errCallback = errCallback;
	this.loadCallback = loadCallback;
	
	if(typeof data != 'undefined' && data != null) {
		this.data = data;
	}

	this.init = function() {
	};

	this.init();

	this.send = function() {

		var xhttp = new XMLHttpRequest();
		var t = this;
		xhttp.onreadystatechange = function() {
			t.execLoadCallback(xhttp.readyState);
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				t.execCallback(xhttp.responseText);
			}
			if (xhttp.readyState == 4 && xhttp.status != 200) {
				t.error(xhttp);
			}
		};
		xhttp.open(this.method, this.url, this.async);

		if (this.method == 'POST') {

			var qs = this.createQueryString();

			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(qs);

		} else {
			xhttp.send();
		}
	};

	this.createQueryString = function() {	
		
		var qs = '';
		for(var k in this.data) {
			qs += k + '=' + data[k];
		}
	};
	
	this.execCallback = function(res) {
		
		if(typeof this.callback != 'undefined') {
			
		//	try {
				this.callback(res);
			//} catch(e) {
				
				//console.log('Exception when calling callback for ajaxRequest: ' + e.message);
				//this.error(null);
			//}
		}
	};
	
	this.execLoadCallback = function(state) {
		if(typeof this.loadCallback != 'undefined' && this.loadCallback != null) {
			this.loadCallback(state);
		}
	};
	
	this.error = function(xhttpObj) {
		
		if(typeof this.errCallback != 'undefined' && this.errCallback != null) {
			this.errCallback(xhttpObj);
		}
		console.log('Ajax error: url: ' + this.url);
	};

	this.setCallback = function(func) {
		this.callback = func;
	};
	this.setErrorCallback = function(func) {
		this.errCallback = func;
	};
	this.setLoadCallback = function(func) {
		this.loadCallback = func;
	};
	this.setData = function(data) {
		this.data = data;
	};
	this.setAsync = function(async) {
		this.async = async;
	};
	this.appendAntiCacheVar = function(){
	};
};
function xwOutput(){
	var xw = new XMLWriter('UTF-8');
	xw.formatting = 'none';
	xw.encoding = 'UTF-8';

	xw.writeStartDocument( );
	xw.writeStartElement('root');
		xw.writeStartElement('city_id');
			xw.writeCDATA('tainan.gov.tw');
		xw.writeEndElement();
		xw.writeStartElement('area');
			xw.writeCDATA('北區');
		xw.writeEndElement();
		xw.writeStartElement('address_string');
			xw.writeCDATA('開元路與勝利路交叉口');
		xw.writeEndElement();
		xw.writeStartElement('lat');
			xw.writeCDATA('23.0066994');
		xw.writeEndElement();
		xw.writeStartElement('long');
			xw.writeCDATA('120.2184427');
		xw.writeEndElement();
		xw.writeStartElement('email');
			xw.writeCDATA('nobody@example.com');
		xw.writeEndElement();
		xw.writeStartElement('device_id');
			xw.writeCDATA('well?');
		xw.writeEndElement();
		xw.writeStartElement('name');
			xw.writeCDATA('沒有人');
		xw.writeEndElement();
		xw.writeStartElement('phone');
			xw.writeCDATA('0800092000');
		xw.writeEndElement();
		xw.writeStartElement('service_name');
			xw.writeCDATA('髒亂及汙染');
		xw.writeEndElement();
		xw.writeStartElement('subproject');
			xw.writeCDATA('其他汙染舉發');
		xw.writeEndElement();
		xw.writeStartElement('servicedescription');
			xw.writeCDATA('這是個測試，請忽略');
		xw.writeEndElement();
		xw.writeStartElement('description');
			xw.writeCDATA('這是個測試，請忽略');
		xw.writeEndElement();
		xw.writeStartElement('pictures');
			xw.writeStartElement('picture');
				xw.writeStartElement('description');
					xw.writeCDATA('這是 api 測試');
				xw.writeEndElement();
				xw.writeStartElement('filename');
					xw.writeCDATA('hello.jpg');
				xw.writeEndElement();
				xw.writeElementString('file', 'imagebase64');
			xw.writeEndElement();
		xw.writeEndElement();
	xw.writeEndElement();
	xw.writeEndDocument();

	var xwres = xw.flush();
	return xwres;
}

function base64Generate(){
	document.getElementById("imageUpload").addEventListener("change", function(event){
		var file = event.target.files[0];
		var reader = new FileReader();
		var base64str = "";
		if(file){
			reader.readAsDataURL(file);
		}else{
			base64str = "";
		}
		reader.onloadend = function () {
    	base64str = reader.result;
			document.getElementById("base64").innerText = base64str;
  	}
	});
}

function printxml(){
	var xml = xwOutput();
	var target = document.getElementById('output');
	target.innerText = xml;
}


function ajaxPost(){
	var xml = xwOutput();
	var method = "POST";
	var url = "http://open1999.tainan.gov.tw:82/ServiceRequestAdd.aspx";
	var xhr = new XMLHttpRequest();
	var result = document.getElementById('result').innerText;
  if ("withCredentials" in xhr) {
    xhr.open(method, url, true);
	} else if (typeof XDomainRequest != "undefined") {
    xhr = new XDomainRequest();
    xhr.open(method, url);
  } else {
    xhr = null;
  }
	xhr.setRequestHeader("Content-type","application/xml");
	xhr.send(xml);
	xhr.onload = function() {
 		var responseText = xhr.responseText;
		result = responseText;
 	};
 	xhr.onerror = function() {
		result = "出現錯誤，請查看console說明";
	};
}

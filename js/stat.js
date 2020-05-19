function download(text,type) {
	var a = document.getElementById("getstat_csv");
	var file = new Blob([text], {type: type});
	a.href = URL.createObjectURL(file);
	a.download = "stats";
}

function get_file_pdf()
{
	$.ajax({
	    url: 'statistics.php',
	    type: 'GET',
	    async: false,
	    success: function(response){

	    	var doc = new jsPDF();
	    	doc.setFontSize(10);
	    	doc.text(response.split("\n\n\n\n")[0], 10, 10);
			doc.addPage();
			doc.text(response.split("\n\n\n\n")[1], 10, 10);
			doc.addPage();
			doc.text(response.split("\n\n\n\n")[2], 10, 10);
			doc.addPage();
			doc.text(response.split("\n\n\n\n")[3], 10, 10);
			doc.addPage();
			doc.text(response.split("\n\n\n\n")[4], 10, 10);
			doc.save('stats.pdf')

	    	// download(response, "playlist");
	    }
	});
}

function get_file_csv()
{
	$.ajax({
	    url: 'statistics.php',
	    type: 'GET',
	    async: false,
	    success: function(response){
	    	console.log(response);
			download(response, "text/plain;charset=utf-8");
	    }
	});
}
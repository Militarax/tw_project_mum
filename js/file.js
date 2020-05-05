function loadFileAsText(){
  var fileToLoad = document.getElementById("fileToLoad").files[0];
  if(fileToLoad != null) {
	  var fileReader = new FileReader();
	  fileReader.onload = function(fileLoadedEvent){
	      var textFromFileLoaded = fileLoadedEvent.target.result;
	      $.ajax({
			    url: 'import.php',
			    type: 'post',
			    data: {'data' : textFromFileLoaded},
			    success: function(response){
			    	document.location.href = `/tw/profile.php`;
		    	}
			});
	  };
	  fileReader.readAsText(fileToLoad, "UTF-8");
	}
}

function download(text, name) {
	var a = document.getElementById("export_a");
	var file = new Blob([text], {type: "application/json"});
	a.href = URL.createObjectURL(file);
	a.download = name;
}

function get_file() {
	$.ajax({
	    url: 'export.php',
	    type: 'GET',
	    async: false,
	    success: function(response){
	    	download(response, "my_playlist");
	    }
	});
}


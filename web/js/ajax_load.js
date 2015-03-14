// -------------------------------------------   Ajax load function - Mission Andina  -----------------------------------------------

function displaySelectedArticle(path_chosen, id_toSet_active)
{
	$('#article_content').fadeOut('slow',loadContent);
	var toLoad = path_chosen +' #article_content';

	function loadContent() {
		$('#article_content').load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#article_content').fadeIn('slow');

				$('.article_link').attr('class', 'article_link');
				document.getElementById(id_toSet_active).className = "article_link li_article_active";
			}
			else {
	            alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
	}

	//to change the browser URL to 'path_chosen'
    if(path_chosen!=window.location){
        window.history.pushState({path:path_chosen},'',path_chosen);    
    }

	return false;
}

function displaySelectedVideo(path_chosen, id_content, id_toSet_active)
{
	var id_content_toLoad = '#'+id_content;
	$(id_content_toLoad).fadeOut('slow',loadContent);

	var toLoad = path_chosen +' '+id_content_toLoad;

	function loadContent() {
		$(id_content_toLoad).load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$(id_content_toLoad).fadeIn('slow');

				$('.video_link').attr('class', 'video_link');
				document.getElementById(id_toSet_active).className = "video_link li_video_active";
			}
			else {
	            alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
	}

	//to change the browser URL to 'path_chosen'
    if(path_chosen!=window.location){
        window.history.pushState({path:path_chosen},'',path_chosen);    
    }

	return false;
}



function loadContentAdmin(path_chosen)
{
	$('#section_admin').fadeOut('slow',loadContent);

	function loadContent() {
		document.getElementById('section_admin').innerHTML = '';
		var toLoad = path_chosen +' #section_admin';
		var headerChange = path_chosen +' #nav_admin';
		$('#section_admin').load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#section_admin').fadeIn('slow');
			}
			else {
	            alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
		$('#nav_admin').load(headerChange,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#nav_admin').fadeIn('slow');
			}
			else {
	            alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
	}

	//to change the browser URL to 'path_chosen'
    if(path_chosen!=window.location){
        window.history.pushState({path:path_chosen},'',path_chosen);    
    }

	return false;
}


function displaySelectedElement(path_chosen, id_toSet_active)
{
	$('#element_content').fadeOut('slow',loadContent);
	var toLoad = path_chosen +' #element_content';

	function loadContent() {
		$('#element_content').load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#element_content').fadeIn('slow');

				$('.element_link').attr('class', 'element_link');
				document.getElementById(id_toSet_active).className = "element_link li_element_active";
			}
			else {
	            alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
	}

	//to change the browser URL to 'path_chosen'
    if(path_chosen!=window.location){
        window.history.pushState({path:path_chosen},'',path_chosen);    
    }

	return false;
}
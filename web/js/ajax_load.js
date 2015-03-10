// -------------------------------------------   Ajax load function - Mission Andina  -----------------------------------------------

function displaySelectedArticle(path_chosen, id_toSet_active)
{
	$('#article_content').fadeOut('slow',loadContent);
	var toLoad = path_chosen +' #article_content';
	var script = path_chosen +' #article_photo_script script';

	function loadContent() {
		$('#article_content').load(toLoad,'',showNewContent());
	}
	function showNewContent() {
		$('#article_content').fadeIn('slow');

		$('.article_link').attr('class', 'article_link');
		document.getElementById(id_toSet_active).className = "article_link li_article_active";
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
		$(id_content_toLoad).load(toLoad,'',showNewContent());
	}
	function showNewContent() {
		$(id_content_toLoad).fadeIn('slow');

		$('.video_link').attr('class', 'video_link');
		document.getElementById(id_toSet_active).className = "video_link li_video_active";
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
		$('#section_admin').load(toLoad,'',showNewContent());
		$('#nav_admin').load(headerChange,'',showNewHeaderStatus());
	}
	function showNewContent() {
		$('#section_admin').fadeIn('slow');
	}
	function showNewHeaderStatus() {
		$('#nav_admin').fadeIn('slow');
	}


	//to change the browser URL to 'path_chosen'
    if(path_chosen!=window.location){
        window.history.pushState({path:path_chosen},'',path_chosen);    
    }

	return false;
}
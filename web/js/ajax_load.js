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
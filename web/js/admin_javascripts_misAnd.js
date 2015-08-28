function changeCSSsheet(selector, property, value) {
    for (var i=0; i < document.styleSheets.length;i++) { //Loop through all styles
        //Try add rule
        try { document.styleSheets[i].insertRule(selector+ ' {'+property+':'+value+'}', document.styleSheets[i].cssRules.length);
        } catch(err) {try { document.styleSheets[i].addRule(selector, property+':'+value);} catch(err) {}}//IE
    }
}

function convertHex(hex,opacity){
    hex = hex.replace('#','');
    r = parseInt(hex.substring(0,2), 16);
    g = parseInt(hex.substring(2,4), 16);
    b = parseInt(hex.substring(4,6), 16);

    result = 'rgba('+r+','+g+','+b+','+opacity/100+')';
    return result;
}

var cw = $('.article_photo_admin').width() * 0.5625;  // 16:9e
$('.article_photo_admin').css({'height': cw+'px'});
changeCSSsheet('.article_photo_admin', 'height', cw+'px');
var cw = $('.besoin_photo').width();
$('.besoin_photo').css({'height': cw+'px'});
changeCSSsheet('.besoin_photo', 'height', cw+'px');
var cw = $('.photo_default').width();
$('.photo_default').css({'height': cw+'px'});
changeCSSsheet('.photo_default', 'height', cw+'px');
var cw = $('.diapo_default').width();
$('.diapo_default').css({'height': cw+'px'});
changeCSSsheet('.diapo_default', 'height', cw+'px');

$(window).resize(function() {
  	var cw = $('.article_photo_admin').width() * 0.5625;  // 16:9e
  	$('.article_photo_admin').css({'height': cw+'px'});
  	changeCSSsheet('.article_photo_admin', 'height', cw+'px');
  	var cw = $('.besoin_photo').width();
	$('.besoin_photo').css({'height': cw+'px'});
	changeCSSsheet('.besoin_photo', 'height', cw+'px');
	var cw = $('.photo_default').width();
	$('.photo_default').css({'height': cw+'px'});
	changeCSSsheet('.photo_default', 'height', cw+'px');
});

// For collor background
var colorChangeDiv = $('.element_link');
var currentColor = $('.element_link').css('background-color');
var bgColor = convertHex(currentColor, 20);
colorChangeDiv.css({'background-color':bgColor});


var cw = $('.photo_default').width();
$('.photo_default').css({'height':cw+'px'});

	function areYouSureDeleteArticle(path) {
	if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
		window.location = path;
	}
}
function areYouSureDeletePhoto(path) {
	if (confirm('Êtes-vous sûr de vouloir supprimer cette photo ?')) {
		window.location = path;
	}
}
function areYouSureDeleteVideo(path) {
	if (confirm('Êtes-vous sûr de vouloir supprimer cette vidéo ?')) {
		window.location = path;
	}
}
function areYouSureDeletePerson(path) {
	if (confirm('Êtes-vous sûr de vouloir supprimer ce bénéficiaire ?')) {
		window.location = path;
	}
}
function areYouSureDeleteProject(path) {
	if (confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')) {
		window.location = path;
	}
}
function areYouSureDeleteDiapo(path) {
	if (confirm('Êtes-vous sûr de vouloir supprimer cette diapo ?')) {
		window.location = path;
	}
}
function areYouSureDeleteBGPhoto(path) {
	if (confirm('Êtes-vous sûr de vouloir supprimer ce fond de page ?')) {
		window.location = path;
	}
}
function areYouSureDeleteAide(path) {
	if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
		window.location = path;
	}
}
function areYouSureDeletePartner(path) {
	if (confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?')) {
		window.location = path;
	}
}


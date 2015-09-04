<?php

namespace MA\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MA\MainBundle\Entity\Article;
use MA\MainBundle\Form\ArticleType;

use MA\MainBundle\Entity\Photos;
use MA\MainBundle\Form\PhotosType;

use MA\MainBundle\Entity\Videos;
use MA\MainBundle\Form\VideosType;

use MA\MainBundle\Entity\Person;
use MA\MainBundle\Form\PersonType;

use MA\MainBundle\Entity\Project;
use MA\MainBundle\Form\ProjectType;
use MA\MainBundle\Form\ProjectEditType;

use MA\MainBundle\Entity\Diapo;
use MA\MainBundle\Form\DiapoType;

use MA\MainBundle\Entity\Page;
use MA\MainBundle\Form\PageType;

use MA\MainBundle\Entity\BGPhoto;
use MA\MainBundle\Form\BGPhotoType;

use MA\MainBundle\Entity\Aide;
use MA\MainBundle\Form\AideType;

use MA\MainBundle\Entity\Partner;
use MA\MainBundle\Form\PartnerType;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('MAUserBundle:User:indexUser.html.twig');
    }

    public function articlesAction($articleId = null)
    {
    	if ($articleId != null) {
	    	$articleAsked = $this ->getDoctrine()
	                        ->getManager()
	                        ->getRepository('MAMainBundle:Article')
	                        ->find($articleId);
    	}
    	else {
    		$articleAsked = $this ->getDoctrine()
	                        ->getManager()
	                        ->getRepository('MAMainBundle:Article')
	                        ->findLatestOne();

	        if (sizeof($articleAsked) > 0) {
		        $articleAsked = $articleAsked[0];
	        }
	        else {
	        	$articleAsked = new Article;
	        }
    	}

        $articles = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Article')
                        ->findAllByDate();

        return $this->render('MAUserBundle:User:articles.html.twig', array(
        	'articleAsked' => $articleAsked, 
        	'articles' => $articles
        	));
    }

    public function articleEditAction($articleId)
    {
    	$article = $this ->getDoctrine()
	                        ->getManager()
	                        ->getRepository('MAMainBundle:Article')
	                        ->find($articleId);

        // On utiliser le OrdersType
        $formNewArticle = $this->createForm(new ArticleType(), $article);

        // On récupère la requête
        $formNewArticle->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewArticle->isValid()) {
            $article->setUpdatedAt(new \Datetime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_articles'));
        }

        return $this->render('MAUserBundle:User:articleNew.html.twig', array(
            'formNewArticle' => $formNewArticle->createView()
        ));
    }

    public function articleNewAction()
    {
    	$article = new Article;

        // On utiliser le OrdersType
        $formNewArticle = $this->createForm(new ArticleType(), $article);

        // On récupère la requête
        $formNewArticle->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewArticle->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_articles'));
        }

        return $this->render('MAUserBundle:User:articleNew.html.twig', array(
            'formNewArticle' => $formNewArticle->createView()
        ));
    }

    public function articleDeleteAction($articleId)
    {
    	$article = $this ->getDoctrine()
	                        ->getManager()
	                        ->getRepository('MAMainBundle:Article')
	                        ->find($articleId);

	    if (!$article) {
	        throw $this->createNotFoundException("Aucun article à supprimer n'a été trouvé ...");
	    }

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_articles'));
    }


    public function photosAction($type = null)
    {
        $photos = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Photos')
                        ->findAllByDate();

        $photosEcoliers = array();
        $photosEtudiants = array();
        $photosJeunesPro = array();
        for ($i=0; $i < sizeof($photos); $i++) { 
            $photo = $photos[$i];
            if ($photo->getCategory() == 'ecoliers') {
                $photosEcoliers[] = $photo;
            } 
            else if ($photo->getCategory() == 'etudiants') {
                $photosEtudiants[] = $photo;
            }
            else if ($photo->getCategory() == 'jeunesPro') {
                $photosJeunesPro[] = $photo;
            }
            
        }

        if ($type) {
            if ($type == 'ecoliers') {
                $photos = $photosEcoliers;
            }
            else if ($type == 'etudiants') {
                $photos = $photosEtudiants;
            }
            else if ($type == 'jeunesPro') {
                $photos = $photosJeunesPro;
            }
        }
        else {
            $type = 'ecoliers';
            $photos = $photosEcoliers;
        }

        return $this->render('MAUserBundle:User:photos.html.twig', array(
            'type' => $type,
            'photos' => $photos
        ));
    }

    public function photoNewAction($type)
    {
        $photo = new Photos;

        $photo->setCategory($type);

        // On utiliser le OrdersType
        $formNewPhoto = $this->createForm(new PhotosType(), $photo);

        // On récupère la requête
        $formNewPhoto->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPhoto->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_photos_spe', array('type' => $type)));
        }

        return $this->render('MAUserBundle:User:photoNew.html.twig', array(
            'formNewPhoto' => $formNewPhoto->createView(),
            'type' => $type
        ));
    }

    public function photoDeleteAction($photoId, $type)
    {
        $photo = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Photos')
                            ->find($photoId);

        if (!$photo) {
            throw $this->createNotFoundException("Aucune photo à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($photo);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_photos_spe', array('type' => $type)));
    }

    public function videosAction($type = null, $videoId = null)
    {
        $videos = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Videos')
                        ->findAllByDate();

        $videosEcoliers = array();
        $videosEtudiants = array();
        $videosJeunesPro = array();
        for ($i=0; $i < sizeof($videos); $i++) { 
            $video = $videos[$i];

            if ($video->getCategory() == 'ecoliers') {
                $videosEcoliers[] = $video;
            } 
            else if ($video->getCategory() == 'etudiants') {
                $videosEtudiants[] = $video;
            }
            else if ($video->getCategory() == 'jeunesPro') {
                $videosJeunesPro[] = $video;
            }
            
        }

        if ($type) {
            if ($type == 'ecoliers') {
                $videos = $videosEcoliers;
            }
            else if ($type == 'etudiants') {
                $videos = $videosEtudiants;
            }
            else if ($type == 'jeunesPro') {
                $videos = $videosJeunesPro;
            }
        }
        else {
            $type = 'ecoliers';
            $videos = $videosEcoliers;
        }

        if ($videoId != null) {
            $videoSelect = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Videos')
                                ->find($videoId);
        }
        else {
            if ($type == 'ecoliers') {
                $videoSelect = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Videos')
                                ->findLatestOneByType('ecoliers');
            }
            else if ($type == 'etudiants') {
                $videoSelect = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Videos')
                                ->findLatestOneByType('etudiants');
            }
            else if ($type == 'jeunesPro') {
                $videoSelect = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Videos')
                                ->findLatestOneByType('jeunesPro');
            }
            else {
                $videoSelect = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Videos')
                                ->findLatestOne();

            }
            if (sizeof($videoSelect) > 0) {
                $videoSelect = $videoSelect[0];
            }
            else {
                $videoSelect = new Videos;
            }
        }

        return $this->render('MAUserBundle:User:videos.html.twig', array(
            'type' => $type,
            'videos' => $videos,
            'videoSelect' => $videoSelect
        ));
    }

    public function videoNewAction($type)
    {
        $video = new videos;

        $video->setCategory($type);

        // On utiliser le OrdersType
        $formNewVideo = $this->createForm(new VideosType(), $video);

        // On récupère la requête
        $formNewVideo->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewVideo->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_videos_spe', array('type' => $type)));
        }

        return $this->render('MAUserBundle:User:videoNew.html.twig', array(
            'formNewVideo' => $formNewVideo->createView(),
            'type' => $type
        ));
    }

    public function videoEditAction($type, $videoId)
    {
        $video = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Videos')
                            ->find($videoId);

        // On utiliser le OrdersType
        $formNewVideo = $this->createForm(new VideosType(), $video);

        // On récupère la requête
        $formNewVideo->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewVideo->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_videos_spe', array('type' => $type)));
        }

        return $this->render('MAUserBundle:User:videoNew.html.twig', array(
            'formNewVideo' => $formNewVideo->createView(),
            'type' => $type
        ));
    }

    public function videoDeleteAction($videoId, $type)
    {
        $video = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Videos')
                            ->find($videoId);

        if (!$video) {
            throw $this->createNotFoundException("Aucune video à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($video);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_videos_spe', array('type' => $type)));
    }

    public function nosBesoinsAction($elementType = null, $elementId = null)
    {
        $persons = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Person')
                            ->findBy([], ['orderList' => 'ASC']);

        $projects = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Project')
                            ->findBy([], ['orderList' => 'ASC']);

        if ($elementType == 'beneficiaires' and $elementId != null) {
                $elementAsked = $this ->getDoctrine()
                                        ->getManager()
                                        ->getRepository('MAMainBundle:Person')
                                        ->find($elementId);
        }
        else if ($elementType == 'projets' and $elementId != null) {
                $elementAsked = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Project')
                                ->find($elementId);
        }
        else {
            $elementAsked = '';
        }

        return $this->render('MAUserBundle:User:nosBesoins.html.twig', array(
            'elementAsked' => $elementAsked,
            'elementType' => $elementType,
            'persons' => $persons,
            'projects' => $projects
            ));
    }

    public function personNewAction()
    {
        $person = new Person;

        // On utiliser le OrdersType
        $formNewPerson = $this->createForm(new PersonType(), $person);

        // On récupère la requête
        $formNewPerson->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPerson->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_nosBesoins'));
        }

        return $this->render('MAUserBundle:User:personNew.html.twig', array(
            'formNewPerson' => $formNewPerson->createView()
        ));
    }

    public function personEditAction($personId)
    {
        $person = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Person')
                            ->find($personId);

        // On utiliser le OrdersType
        $formNewPerson = $this->createForm(new PersonType(), $person);

        // On récupère la requête
        $formNewPerson->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPerson->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_nosBesoins_elementAjax', array('elementType' => 'beneficiaires', 'elementId' => $personId)));
        }

        return $this->render('MAUserBundle:User:personNew.html.twig', array(
            'formNewPerson' => $formNewPerson->createView()
        ));
    }

    public function personDeleteAction($personId)
    {
        $person = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Person')
                            ->find($personId);

        if (!$person) {
            throw $this->createNotFoundException("Aucun bénéficiaire à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_nosBesoins'));
    }

    public function projectNewAction()
    {
        $project = new Project;

        // On utiliser le OrdersType
        $formNewProject = $this->createForm(new ProjectType(), $project);

        // On récupère la requête
        $formNewProject->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewProject->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_nosBesoins'));
        }

        return $this->render('MAUserBundle:User:projectNew.html.twig', array(
            'formNewProject' => $formNewProject->createView()
        ));
    }

    public function projectEditAction($projectId)
    {
        $project = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Project')
                            ->find($projectId);

        // On utiliser le OrdersType
        $formNewProject = $this->createForm(new projectEditType(), $project);

        // On récupère la requête
        $formNewProject->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewProject->isValid()) {

            if ($_POST['finished'] == 'no_finished') {
                $project->setCompletedAt(null);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_nosBesoins_elementAjax', array('elementType' => 'projets', 'elementId' => $projectId)));
        }

        return $this->render('MAUserBundle:User:projectNew.html.twig', array(
            'formNewProject' => $formNewProject->createView()
        ));
    }

    public function projectDeleteAction($projectId)
    {
        $project = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Project')
                            ->find($projectId);

        if (!$project) {
            throw $this->createNotFoundException("Aucun projet à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_nosBesoins'));
    }

    public function contentAction($pageId = null)
    {
        $pages = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Page')
                        ->findAll(['updatedAt' => 'DESC']);

        if ($pageId == null) {
            $pageAsked = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Page')
                                ->findLatestOne();
            if (sizeof($pageAsked) > 0) {
                $pageAsked = $pageAsked[0];
            }
            else {
                $pageAsked = new Page;
            }
        }
        else {
            $pageAsked = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Page')
                                ->find($pageId);
        }

        return $this->render('MAUserBundle:User:content.html.twig', array(
            'pages' => $pages,
            'pageAsked' => $pageAsked
            ));
    }

    public function contentNewAction($pageId = null)
    {
        if ($pageId == null) {
            $page = new Page;
        }
        else {
            $page = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Page')
                                ->find($pageId);
        }

        // On utiliser le OrdersType
        $formNewPage = $this->createForm(new pageType(), $page);

        // On récupère la requête
        $formNewPage->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPage->isValid()) {
            $page->setUpdatedAt(new \Datetime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_content'));
        }

        return $this->render('MAUserBundle:User:contentNew.html.twig', array(
            'formNewPage' => $formNewPage->createView()
        ));
    }

    public function contentDeleteAction($pageId)
    {
        $page = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Page')
                            ->find($pageId);

        if (!$page) {
            throw $this->createNotFoundException("Aucune page à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_content'));
    }

    public function diaposAction()
    {
        $diapos = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Diapo')
                        ->findAll();

        return $this->render('MAUserBundle:User:diapos.html.twig', array(
            'diapos' => $diapos
            ));
    }

    public function diapoNewAction()
    {
        $diapo = new Diapo;

        // On utiliser le OrdersType
        $formNewDiapo = $this->createForm(new diapoType(), $diapo);

        // On récupère la requête
        $formNewDiapo->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewDiapo->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($diapo);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_diapos'));
        }

        return $this->render('MAUserBundle:User:diapoNew.html.twig', array(
            'formNewDiapo' => $formNewDiapo->createView()
        ));
    }

    public function diapoDeleteAction($diapoId)
    {
        $diapo = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Diapo')
                            ->find($diapoId);

        if (!$diapo) {
            throw $this->createNotFoundException("Aucune diapo à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($diapo);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_diapos'));
    }

    public function BGPhotosAction()
    {
        $BGPhotos = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:BGPhoto')
                        ->findAll();

        return $this->render('MAUserBundle:User:BGPhotos.html.twig', array(
            'BGPhotos' => $BGPhotos
            ));
    }

    public function BGPhotoNewAction()
    {
        $BGPhoto = new BGPhoto;

        // On utiliser le OrdersType
        $formNewBGPhoto = $this->createForm(new BGPhotoType(), $BGPhoto);

        // On récupère la requête
        $formNewBGPhoto->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewBGPhoto->isValid()) {
            $BGPhoto->setUpdatedAt(new \Datetime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($BGPhoto);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_BG_photos'));
        }

        return $this->render('MAUserBundle:User:BGPhotoNew.html.twig', array(
            'formNewBGPhoto' => $formNewBGPhoto->createView()
        ));
    }

    public function BGPhotoDeleteAction($BGPhotoId)
    {
        $BGPhoto = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:BGPhoto')
                            ->find($BGPhotoId);

        if (!$BGPhoto) {
            throw $this->createNotFoundException("Aucune photo de fond de page à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($BGPhoto);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_BG_photos'));
    }

    public function aidesAction()
    {
        $aides = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Aide')
                        ->findAll(['orderList' => 'ASC']);

        return $this->render('MAUserBundle:User:aides.html.twig', array(
            'aides' => $aides
            ));
    }

    public function aideNewAction($aideId = null)
    {
        if ($aideId == null) {
            $aide = new Aide;
        }
        else {
            $aide = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Aide')
                                ->find($aideId);
        }

        // On utiliser le OrdersType
        $formNewAide = $this->createForm(new aideType(), $aide);

        // On récupère la requête
        $formNewAide->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewAide->isValid()) {
            $aide->setUpdatedAt(new \Datetime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($aide);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_aides'));
        }

        return $this->render('MAUserBundle:User:aideNew.html.twig', array(
            'formNewAide' => $formNewAide->createView()
        ));
    }

    public function aideDeleteAction($aideId)
    {
        $aide = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Aide')
                            ->find($aideId);

        if (!$aide) {
            throw $this->createNotFoundException("Aucune page à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($aide);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_aides'));
    }

    public function partnersAction()
    {
        $partners = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Partner')
                        ->findAll(['orderList' => 'ASC']);

        return $this->render('MAUserBundle:User:partners.html.twig', array(
            'partners' => $partners
            ));
    }

    public function partnerNewAction($partnerId = null)
    {
        if ($partnerId == null) {
            $partner = new Partner;
        }
        else {
            $partner = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Partner')
                                ->find($partnerId);
        }

        // On utiliser le OrdersType
        $formNewPartner = $this->createForm(new partnerType(), $partner);

        // On récupère la requête
        $formNewPartner->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPartner->isValid()) {
            $partner->setUpdatedAt(new \Datetime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($partner);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('ma_user_partners'));
        }

        return $this->render('MAUserBundle:User:partnerNew.html.twig', array(
            'formNewPartner' => $formNewPartner->createView()
        ));
    }

    public function partnerDeleteAction($partnerId)
    {
        $partner = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Partner')
                            ->find($partnerId);

        if (!$partner) {
            throw $this->createNotFoundException("Aucune page à supprimer n'a été trouvé ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($partner);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_user_partners'));
    }
}

<?php

namespace MA\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MA\MainBundle\Entity\Article;
use MA\MainBundle\Form\ArticleType;

use MA\MainBundle\Entity\Photos;
use MA\MainBundle\Form\PhotosType;

use MA\MainBundle\Entity\Videos;
use MA\MainBundle\Form\VideosType;

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
            else if ($photo->getCategory() == 'etudiants') {
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

    public function contentAction()
    {
        return $this->render('MAUserBundle:User:content.html.twig');
    }
}

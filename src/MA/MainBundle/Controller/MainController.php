<?php

namespace MA\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MA\MainBundle\Entity\Article;
use MA\MainBundle\Entity\Videos;
use MA\MainBundle\Entity\Photos;

class MainController extends Controller
{
    public function indexAction($elementType = null, $elementId = null)
    {
        if ($elementType == 'article' and $elementId != null) {
    	    	$articleAsked = $this ->getDoctrine()
    	                        ->getManager()
    	                        ->getRepository('MAMainBundle:Article')
    	                        ->find($elementId);
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
        
        if ($elementType == 'video' and $elementId != null) {
                $videoAsked = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('MAMainBundle:Videos')
                                ->find($elementId);
        }
        else {
            $videoAsked = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('MAMainBundle:Videos')
                            ->findLatestOne();

            if (sizeof($videoAsked) > 0) {
                $videoAsked = $videoAsked[0];
            }
            else {
                $videoAsked = new Videos;
            }
        }


        $articles = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Article')
                        ->findAllByDate();

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
            else if ($video->getCategory() == 'etudiants') {
                $videosJeunesPro[] = $video;
            }
            
        }


        return $this->render('MAMainBundle:Main:indexMain.html.twig', array(
            'articleAsked' => $articleAsked, 
            'articles' => $articles,
            'photosEcoliers' => $photosEcoliers,
            'photosEtudiants' => $photosEtudiants,
            'photosJeunesPro' => $photosJeunesPro,
            'videosEcoliers' => $videosEcoliers,
            'videosEtudiants' => $videosEtudiants,
            'videosJeunesPro' => $videosJeunesPro,
        	'videoAsked' => $videoAsked
        	));
        
    }

    public function helpUsAction()
    {
        return $this->render('MAMainBundle:Main:helpUs.html.twig');
    }
}

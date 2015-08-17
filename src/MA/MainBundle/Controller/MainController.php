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
            else if ($photo->getCategory() == 'jeunesPro') {
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
            else if ($video->getCategory() == 'jeunesPro') {
                $videosJeunesPro[] = $video;
            }
            
        }

        $people = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Person')
                        ->findAll();

        $projects = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Project')
                        ->findAll();


        return $this->render('MAMainBundle:Main:indexMain.html.twig', array(
            'articleAsked' => $articleAsked, 
            'articles' => $articles,
            'photosEcoliers' => $photosEcoliers,
            'photosEtudiants' => $photosEtudiants,
            'photosJeunesPro' => $photosJeunesPro,
            'videosEcoliers' => $videosEcoliers,
            'videosEtudiants' => $videosEtudiants,
            'videosJeunesPro' => $videosJeunesPro,
        	'videoAsked' => $videoAsked,
            'people' => $people,
            'projects' => $projects
        	));
        
    }

    public function helpUsAction()
    {
        return $this->render('MAMainBundle:Main:helpUs.html.twig');
    }

    public function footerContactAction() 
    {
        $senderName = $_POST['senderContact'];
        $senderEmail = $_POST['emailContact'];
        $senderContent = $_POST['corpsMail'];

        // Message for client
        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('[Mission Andina]')
            ->setFrom(array('contact@missionandina.org' => 'Mission Andina'))
            ->setTo($senderEmail)
            ->setBody(
                $this->renderView('MAMainBundle:Main:emailClient.html.twig',
                    array(  'senderName' => $senderName,
                            'senderEmail' => $senderEmail,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;

        // Message for manager/admin
        $messageAdmin = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('[Mission Andina] Nouveau message.')
            ->setFrom(array('contact@missionandina.org' => 'Mission Andina'))
            ->setTo('contact@missionandina.org')
            ->setBody(
                $this->renderView('MAMainBundle:Main:emailAdmin.html.twig',
                    array(  'senderName' => $senderName,
                            'senderEmail' => $senderEmail,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;

        $this->get('mailer')->send($message);
        $this->get('mailer')->send($messageAdmin);        

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_main_footer_contact_thankYou'));
    }

    public function footerContactThankYouAction() 
    {
        
        return $this->render('MAMainBundle:Main:contactThankYou.html.twig');
    }

    public function helpUsContactAction() 
    {
        $senderName = $_POST['senderContact'];
        $senderEmail = $_POST['emailContact'];
        $senderQuantity = $_POST['quantityContact'];
        $senderType = $_POST['orderContentType'];
        $senderContent = $_POST['corpsMail'];

        // Message for client
        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('[Mission Andina]')
            ->setFrom(array('contact@missionandina.org' => 'Mission Andina'))
            ->setTo($senderEmail)
            ->setBody(
                $this->renderView('MAMainBundle:Main:emailHelpUsClient.html.twig',
                    array(  'senderName' => $senderName,
                            'senderEmail' => $senderEmail,
                            'senderQuantity' => $senderQuantity,
                            'senderType' => $senderType,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;

        // Message for manager/admin
        $messageAdmin = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('[Mission Andina] Nouveau message.')
            ->setFrom(array('contact@missionandina.org' => 'Mission Andina'))
            ->setTo('contact@missionandina.org')
            ->setBody(
                $this->renderView('MAMainBundle:Main:emailHelpUsAdmin.html.twig',
                    array(  'senderName' => $senderName,
                            'senderEmail' => $senderEmail,
                            'senderQuantity' => $senderQuantity,
                            'senderType' => $senderType,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;

        $this->get('mailer')->send($message);
        $this->get('mailer')->send($messageAdmin);        

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('ma_main_helpUs_contact_thankYou'));
    }

    public function helpUsContactThankYouAction() 
    {
        return $this->render('MAMainBundle:Main:contactThankYou.html.twig');
    }
}

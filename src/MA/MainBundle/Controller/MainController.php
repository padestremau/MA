<?php

namespace MA\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction($articleId = null)
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
	        	$articleAsked = new Article();
	        }
    	}

        $articles = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('MAMainBundle:Article')
                        ->findAllByDate();

        return $this->render('MAMainBundle:Main:indexMain.html.twig', array(
        	'articleAsked' => $articleAsked, 
        	'articles' => $articles
        	));
        
    }

    public function donationAction()
    {
        return $this->render('MAMainBundle:Main:indexMain.html.twig');
    }
}

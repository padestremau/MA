<?php

namespace MA\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MA\MainBundle\Entity\Article;
use MA\MainBundle\Form\ArticleType;

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
	        	$articleAsked = new Article();
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
    	$article = new Article();

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


    public function photosAction()
    {
        return $this->render('MAUserBundle:User:photos.html.twig');
    }

    public function videosAction()
    {
        return $this->render('MAUserBundle:User:videos.html.twig');
    }

    public function contentAction()
    {
        return $this->render('MAUserBundle:User:content.html.twig');
    }
}

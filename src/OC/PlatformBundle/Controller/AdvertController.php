<?php


// src/OC/PlatformBundle/Controller/AdvertController.php


namespace OC\PlatformBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller ; 


class AdvertController extends Controller

{

	public function indexAction(){

	$content = $this->get('templating')->render('OCPlatformBundle:Advert:index.html.twig', array('nom'=>'Cindy')) ; 
		return new Response($content) ; 
	}

	//consulation d'une annonce 
	public function viewAction($id){

		return new Response("Affichage de l'annonce d'id:" .$id) ; 
	}

}

?>
<?php


// src/OC/PlatformBundle/Controller/AdvertController.php


namespace OC\PlatformBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller ; 


class AdvertController extends Controller

{

	public function indexAction($page){

	//il faut au moins une page 
		if($page <1){
			// on déclenche une erreur 404
			throw new NotFoundHttpException('Page "'. $page .'"inexistante.');
			
		}

	
		return $this->render('OCPlatformBundle:Advert:index.html.twig') ; 
	}

	//consulation d'une annonce 
	public function viewAction($id){

		return $this->render('OCPlatformBundle:Advert:view.html.twig', array('id' => $id )) ; 
	}

	//ajout d'une annonce 
	public function addAction(Request $request){

		if($request->isMethos('POST')){

			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistré') ; 

			return $this->redirectToRoute('oc_platform_view', array('id' => 5 )) ; 

		}

		return $this->render('OCPlatformBundle:Advert:add.html.twig') ; 

		
	}

	//edit d'une annonce 
	public function editAction($id, Request $request){

		if($request->isMethos('POST')){
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifié') ; 
			return $this->redirectToRoute('oc_platform_view', array('id' => 5 )) ; 

		}

		return $this->render('OCPlatformBundle:Advert:edit.html.twig') ; 
	}

	// supression d'une annonce 

	public function deleteAction($id){

		return $this->render('OCPlatformBundle:delete:edit.html.twig') ; 
	}

}

?>
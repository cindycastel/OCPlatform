<?php


// src/OC/PlatformBundle/Controller/AdvertController.php


namespace OC\PlatformBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller ; 
use Symfony\Component\HttpFoundation\Request;  
use  OC\PlatformBundle\Entity\Advert;
use  OC\PlatformBundle\Entity\Image;
use  OC\PlatformBundle\Entity\Application;

class AdvertController extends Controller

{

	//public function indexAction($page){

	
	
	//	return $this->render('OCPlatformBundle:Advert:index.html.twig', array('listAdverts'=> array())) ; 
	//}


public function indexAction($page)
  {
    // ...

    // Notre liste d'annonce en dur
    $listAdverts = array(
      array(
        'title'   => 'Recherche développpeur Symfony',
        'id'      => 1,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Mission de webmaster',
        'id'      => 2,
        'author'  => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 3,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime())
    );

    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts
    ));
  }



	//consulation d'une annonce 
	public function viewAction($id){

    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On récupère la liste des candidatures de cette annonce
    $listApplications = $em
      ->getRepository('OCPlatformBundle:Application')
      ->findBy(array('advert' => $advert))
    ;

    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
      'advert'           => $advert,
      'listApplications' => $listApplications
    ));
  }
	

	//ajout d'une annonce 
	public function addAction(Request $request){

		 // Création de l'entité Advert
    $advert = new Advert();
    $advert->setTitle('Recherche développeur Symfony.');
    $advert->setAuthor('Alexandre');
    $advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

    // Création d'une première candidature
    $application1 = new Application();
    $application1->setAuthor('Marine');
    $application1->setContent("J'ai toutes les qualités requises.");

    // Création d'une deuxième candidature par exemple
    $application2 = new Application();
    $application2->setAuthor('Pierre');
    $application2->setContent("Je suis très motivé.");

    // On lie les candidatures à l'annonce
    $application1->setAdvert($advert);
    $application2->setAdvert($advert);

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($advert);

    // Étape 1 ter : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
    // définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
    $em->persist($application1);
    $em->persist($application2);

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    $em->flush();

    // Reste de la méthode qu'on avait déjà écrit
    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      // Puis on redirige vers la page de visualisation de cettte annonce
      return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
    }

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('OCPlatformBundle:Advert:add.html.twig', array('advert' => $advert));

		
		
	}

	//edit d'une annonce 
	public function editAction($id, Request $request){


 $advert = array(
      'title'=> 'Recherche développeur Symfony',
      'id'=>$id, 
      'author'=> 'Cindy',
      'content'=>' Nous recherchons un developpeur',
      'date'=> new \Datetime()

     ); 

		/*if($request->isMethos('POST')){
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifié') ; 
			return $this->redirectToRoute('oc_platform_view', array('id' => 5 )) ; 

		}*/

		  return $this->render('OCPlatformBundle:Advert:edit.html.twig', array('advert' => $advert )) ; 
	}

	// supression d'une annonce 

	public function deleteAction($id){

		return $this->render('OCPlatformBundle:delete:delete.html.twig') ; 
	}


	//menu 
	  public function menuAction($limit)
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }



    public function editImageAction($advertId)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($advertId);

    // On modifie l'URL de l'image par exemple
    $advert->getImage()->setUrl('test.png');

    // On n'a pas besoin de persister l'annonce ni l'image.
    // Rappelez-vous, ces entités sont automatiquement persistées car
    // on les a récupérées depuis Doctrine lui-même
    
    // On déclenche la modification
    $em->flush();

    return new Response('OK');
  }



}

?>
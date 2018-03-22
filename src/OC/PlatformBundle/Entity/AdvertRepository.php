
<?php
// src/OC/PlatformBundle/Entity/AdvertRepository.php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AdvertRepository extends EntityRepository
{
  public function myFindAll()
  {
    // Méthode 1 : en passant par l'EntityManager
    $queryBuilder = $this->_em->createQueryBuilder()
      ->select('a')
      ->from($this->_entityName, 'a')
    ;
    // Dans un repository, $this->_entityName est le namespace de l'entité gérée
    // Ici, il vaut donc OC\PlatformBundle\Entity\Advert

    // Méthode 2 : en passant par le raccourci (je recommande)
    $queryBuilder = $this->createQueryBuilder('a');

    // On n'ajoute pas de critère ou tri particulier, la construction
    // de notre requête est finie

    // On récupère la Query à partir du QueryBuilder
    $query = $queryBuilder->getQuery();

    // On récupère les résultats à partir de la Query
    $results = $query->getResult();

    // On retourne ces résultats
    return $results;
  }


  public function myFindOne($id)
  {
  	$qb=$this->createQueryBuilder('a'); 
  	$qb->where('a.id=:id')
  		->setParameter('id',$id) ; 

  	return $qb->getQuery()->getResult() ; 


  }


  public function whereCurrentYear(QueryBuilder $qb)

  {

    $qb

      ->andWhere('a.date BETWEEN :start AND :end')

      ->setParameter('start', new \Datetime(date('Y').'-01-01'))  // Date entre le 1er janvier de cette année

      ->setParameter('end',   new \Datetime(date('Y').'-12-31'))  // Et le 31 décembre de cette année

    ;

  }



  public function myFind()
  {

  $qb = $this->createQueryBuilder('a');

  // On peut ajouter ce qu'on veut avant
  $qb->where('a.author = :author')->setParameter('author', 'Marine')  ;


  // On applique notre condition sur le QueryBuilder

  $this->whereCurrentYear($qb);

  // On peut ajouter ce qu'on veut après

  $qb->orderBy('a.date', 'DESC');
  return $qb->getQuery()->getResult() ;

	}


}


?>
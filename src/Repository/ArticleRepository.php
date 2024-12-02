<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function search(string $search):array //fonction de recherche
    {

        //
        return $this->createQueryBuilder('a')//$this(objet en cours) on insrancie le queryBuilder qui permet d'aller interroger la dateBase
            //quand on passe par le queryBuilder pour faire des requetes SQL on appelle les variables avec :nomVariables
            ->where('a.title LIKE :search') //On débutre mla requete SQL en précisant le WHERE = 1 conditiond
            ->orWhere('a.content LIKE :search')//On donne une seconde condition
            ->setParameter('search', '%'.$search.'%')//On parametre la variable "search3
            ->getQuery()//On construit la requete SQL a partie des données indiquées plus haut
            ->getResult();

        //SELECT     * FROM article AS a WHERE a.title LIKE '%search%' OR WHERE a.content LIKE '%search%'
    }

}
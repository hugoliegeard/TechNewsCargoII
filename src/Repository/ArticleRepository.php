<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{

    const MAX_RESULTS = 5;
    const MAX_SUGGESTIONS = 3;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * Récupère les derniers articles
     * @return mixed
     */
    public function findLatestArticles()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Récupère les suggestions d'articles
     * @param $idArticle
     * @param $idCategorie
     * @return mixed
     */
    public function findArticlesSuggestions($idArticle, $idCategorie)
    {
        return $this->createQueryBuilder('a')
            # Tous les articles d'une catégorie ($idCategorie)
            ->where('a.categorie = :categorie_id')
            ->setParameter('categorie_id', $idCategorie)
            # Sauf un Article ($idArticle)
            ->andWhere('a.id != :article_id')
            ->setParameter('article_id', $idArticle)
            # 3 articles MAX
            ->setMaxResults(self::MAX_SUGGESTIONS)
            # Par ordre décroissant
            ->orderBy('a.id', 'DESC')
            # On finalise
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Récupérer les articles en spotlight
     */
    public function findSpotlightArticles()
    {
        return $this->createQueryBuilder('a')
            ->where('a.spotlight = 1')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Récupérer les articles "special" sidebar
     */
    public function findSpecialArticles()
    {
        return $this->createQueryBuilder('a')
            ->where('a.special = 1')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult()
        ;
    }


}

<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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
            ->where('a.status LIKE :status')
            ->setParameter('status', "%published%")
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult();
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
            ->getResult();
    }

    /**
     * Récupérer les articles en spotlight
     */
    public function findPublishedArticles()
    {
        return $this->createQueryBuilder('a')
            ->where('a.status LIKE :status')
            ->setParameter('status', "%published%")
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupérer les articles en spotlight
     */
    public function findSpotlightArticles()
    {
        return $this->createQueryBuilder('a')
            ->where('a.spotlight = 1')
            ->andWhere('a.status LIKE :status')
            ->setParameter('status', "%published%")
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupérer les articles "special" sidebar
     */
    public function findSpecialArticles()
    {
        return $this->createQueryBuilder('a')
            ->where('a.special = 1')
            ->andWhere('a.status LIKE :status')
            ->setParameter('status', "%published%")
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupérer tous les articles d'un Auteur
     * par rapport à leur statut.
     * @param $idAuteur
     * @param $statut
     * @return mixed
     */
    public function findAuthorArticlesByStatus($idAuteur, $statut)
    {
        return $this->createQueryBuilder('a')
            ->where('a.membre = :membre_id')
            ->setParameter('membre_id', $idAuteur)
            ->andWhere('a.status LIKE :status ')
            ->setParameter('status', "%$statut%")
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Compter tous les articles d'un Auteur
     * par rapport à leur statut.
     * @param $idAuteur
     * @param $statut
     * @return mixed
     */
    public function countAuthorArticlesByStatus($idAuteur, $statut)
    {
        try {
            return $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->where('a.membre = :membre_id')
                ->setParameter('membre_id', $idAuteur)
                ->andWhere('a.status LIKE :status')
                ->setParameter('status', "%$statut%")
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }

    /**
     * Récupérer tous les articles
     * par rapport à leur statut.
     * @param $statut
     * @return mixed
     */
    public function findArticlesByStatus($statut)
    {
        return $this->createQueryBuilder('a')
            ->where('a.status LIKE :status ')
            ->setParameter('status', "%$statut%")
            ->andWhere('a.status NOT LIKE :refused')
            ->setParameter('refused', "%refused%")
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Compter tous les articles
     * par rapport à leur statut.
     * @param $statut
     * @return mixed
     */
    public function countArticlesByStatus($statut)
    {
        try {
            return $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->andWhere('a.status LIKE :status')
                ->setParameter('status', "%$statut%")
                ->andWhere('a.status NOT LIKE :refused')
                ->setParameter('refused', "%refused%")
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }

}

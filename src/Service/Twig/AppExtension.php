<?php

namespace App\Service\Twig;


use App\Entity\Article;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{

    private $em;
    private $session;
    private $auteur;
    public const NB_SUMMARY_CHAR = 170;

    /**
     * AppExtension constructor.
     * @param EntityManagerInterface $manager
     * @param TokenStorageInterface $tokenStorage
     * @param SessionInterface $session
     */
    public function __construct(EntityManagerInterface $manager,
                                TokenStorageInterface $tokenStorage,
                                SessionInterface $session)
    {
        # Récupération de Doctrine
        $this->em = $manager;

        # Récupération de la session
        $this->session = $session;

        # Récupération d'un Membre (Auteur) si un Token existe
        if($tokenStorage->getToken()) {
            $this->auteur = $tokenStorage->getToken()->getUser();
        }

    }

    public function getFilters()
    {
        return [
          new \Twig_Filter('summary', function($text) {

              # Suppression des Balises HTML
              $string = strip_tags($text);

              # Si mon string est supérieur à 170, je continue
              if(strlen($string) > self::NB_SUMMARY_CHAR) {

                  # Je coupe ma chaine à 170
                  $stringCut = substr($string, 0, self::NB_SUMMARY_CHAR);

                  $string = substr($stringCut, 0, strrpos($stringCut, ' ')). '...';

              }

              return $string;

          },['is_safe' => ['html']])
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('getCategories', function() {
                return $this->em->getRepository(Categorie::class)
                    ->findCategoriesHavingArticles();
            }),
            new \Twig_Function('isUserInvited', function() {
                return $this->session->get('inviteUserModal');
            }),
            new \Twig_Function('pendingArticles', function() {
                return $this->em->getRepository(Article::class)
                    ->countAuthorArticlesByStatus($this->auteur->getId(), 'review');
            }),
            new \Twig_Function('pendingArticles', function() {
                return $this->em->getRepository(Article::class)
                    ->countAuthorArticlesByStatus($this->auteur->getId(), 'review');
            }),
            new \Twig_Function('publishedArticles', function() {
                return $this->em->getRepository(Article::class)
                    ->countAuthorArticlesByStatus($this->auteur->getId(), 'published');
            }),
            new \Twig_Function('countArticlesByStatus', function(string $status) {
                return $this->em->getRepository(Article::class)
                    ->countArticlesByStatus($status);
            })
        ];
    }

}
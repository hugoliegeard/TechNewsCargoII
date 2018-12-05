<?php

namespace App\Service\Twig;


use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{

    private $em;
    public const NB_SUMMARY_CHAR = 170;

    /**
     * AppExtension constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
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
            })
        ];
    }

}
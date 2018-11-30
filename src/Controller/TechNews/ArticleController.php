<?php

namespace App\Controller\TechNews;


use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Membre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * Démonstration de l'ajout
     * d'un article avec Doctrine.
     * @Route("test/ajouter-un-article",
     *     name="article_test")
     */
    public function test()
    {
        # Création d'une Catégorie
        $categorie = new Categorie();
        $categorie->setNom('Politique');
        $categorie->setSlug('politique');

        # Création d'un Membre (Auteur de l'article)
        $membre = new Membre();
        $membre
            ->setPrenom('Hugo')
            ->setNom('LIEGEARD')
            ->setEmail('hugo.liegeard@tech.news')
            ->setPassword('test')
            ->setRoles(['ROLE_AUTEUR'])
        ;

        # Création de l'article
        $article = new Article();
        $article
            ->setTitre("\"On a vingt ans de retard\" : avant d'accueillir la COP24, Katowice fait mine de combattre la pollution")
            ->setSlug("on-a-vingt-ans-de-retard-avant-d-accueillir-la-cop24-katowice-fait-mine-de-combattre-la-pollution")
            ->setContenu("<p>Dix mètres, puis cinquante, puis cent-cinquante. Le drone déploie ses ailes dans le ciel de Katowice, en Pologne, qui accueillera la COP24 du 3 au 14 décembre. Bourré de capteurs, l'engin renifle tout ce qui passe sous son nez. Au sol, Sylwia Jarosławska-Sobór contrôle les résultats en temps réel sur l'écran d'un ordinateur portable. \"Ici, c'est le taux de monoxyde de carbone, là, c'est la poussière dans l'air… Rien ne lui échappe, assure cette ingénieure du Głównego Instytutu Górnictwa. Après un vol, il arrive que les absorbeurs soient tout sales à cause des particules fines que l'appareil a trouvées sur son passage. C'est assez incroyable.\"</p>")
            ->setFeaturedImage("16164503.jpg")
            ->setSpotlight(0)
            ->setSpecial(1)
            ->setCategorie($categorie)
            ->setMembre($membre)
        ;

        # On sauvegarde le tout avec Doctrine
        $em = $this->getDoctrine()->getManager();
        $em->persist($categorie);
        $em->persist($membre);
        $em->persist($article);
        $em->flush();

        # Affichage d'une réponse.
        return new Response(
          'Nouvel Article ID : '
          . $article->getId()
          . ' dans la catégorie : '
          . $categorie->getNom()
          . ' de l\'auteur : '
          . $membre->getPrenom()
        );
    }
}
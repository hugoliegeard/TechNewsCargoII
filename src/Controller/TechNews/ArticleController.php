<?php

namespace App\Controller\TechNews;


use App\Article\ArticleType;
use App\Controller\HelperTrait;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Membre;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{

    use HelperTrait;

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

    /**
     * Formulaire pour ajouter un Article
     * @Route("/creer-un-article",
     *     name="article_new")
     * @Security("has_role('ROLE_AUTEUR')")
     * @param Request $request
     * @return Response
     */
    public function newArticle(Request $request)
    {
        # Récupération d'un Membre
        # $membre = $this->getDoctrine()
        #    ->getRepository(Membre::class)
        #    ->find(2);

        $article = new Article();
        $article->setMembre($this->getUser());

        $form = $this->createForm(ArticleType::class, $article)
            ->handleRequest($request);

        # Traitement des données POST
        # $form->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if( $form->isSubmitted() && $form->isValid() ) {

            #dump($article);
            # 1. Traitement de l'upload de l'image

             /** @var UploadedFile $featuredImage */
            $featuredImage = $article->getFeaturedImage();

            $fileName = $this->slugify($article->getTitre())
                . '.' . $featuredImage->guessExtension();

            try {
                $featuredImage->move(
                    $this->getParameter('articles_assets_dir'),
                    $fileName
                );
            } catch (FileException $e) {

            }

            # Mise à jour de l'image
            $article->setFeaturedImage($fileName);

            # 2. Mise à jour du Slug
            $article->setSlug($this->slugify($article->getTitre()));

            # 3. Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            # 4. Notification
            $this->addFlash('notice',
                'Félicitation, votre article est en ligne !');

            # 5. Redirection vers l'article créé
            return $this->redirectToRoute('index_article', [
               'categorie' => $article->getCategorie()->getSlug(),
               'slug' => $article->getSlug(),
               'id' => $article->getId()
            ]);

        }

        # Affichage du Formulaire
        return $this->render('article/form.html.twig', [
           'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/editer-un-article/{id<\d+>}",
     *     name="article_edit")
     * @param Article $article
     * @param Request $request
     * @param Packages $packages
     * @return Response
     */
    public function editArticle(Article $article,
                                Request $request,
                                Packages $packages)
    {

        $options = [
            'image_url' => $packages->getUrl('images/product/'
                . $article->getFeaturedImage())
        ];

         $article->setFeaturedImage(
             new File($this->getParameter('articles_assets_dir')
                 .'/'.$article->getFeaturedImage())
         );

        $form = $this->createForm(ArticleType::class, $article, $options)
            ->handleRequest($request);

        # Affichage du Formulaire
        return $this->render('article/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
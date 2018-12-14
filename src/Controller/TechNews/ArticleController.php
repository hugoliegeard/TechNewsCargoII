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
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Registry;

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
            ->setRoles(['ROLE_AUTEUR']);

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
            ->setMembre($membre);

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
     * @param Registry $workflows
     * @return Response
     */
    public function newArticle(Request $request, Registry $workflows)
    {
        # Récupération d'un Membre
        # $membre = $this->getDoctrine()
        #    ->getRepository(Membre::class)
        #    ->find(2);

        $article = new Article();
        $article->setMembre($this->getUser());

        # Récupération du Workflow
        $workflow = $workflows->get($article);
        # dump($workflow->getEnabledTransitions($article));
        # exit();

        $form = $this->createForm(ArticleType::class, $article)
            ->handleRequest($request);

        # Traitement des données POST
        # $form->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            #dump($article);
            # 1. Traitement de l'upload de l'image

            /** @var UploadedFile $featuredImage */
            $featuredImage = $article->getFeaturedImage();

            if (null !== $featuredImage) {
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

                try {

                    # Changement du Workflow
                    $workflow->apply($article, 'to_review');

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

                } catch (LogicException $e) {

                    # Transition non autorisé...
                    $this->addFlash('error',
                        'Révision impossible, contactez votre rédacteur.');

                }

            } else {

                # 4. Notification
                $this->addFlash('error',
                    "N'oubliez pas de choisir une image d'illustration");
            }
        }

        # Affichage du Formulaire
        return $this->render('article/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/editer-un-article/{id<\d+>}",
     *     name="article_edit")
     * @Security("article.isAuteur(user) or has_role('ROLE_EDITEUR')")
     * @param Article $article
     * @param Request $request
     * @param Packages $packages
     * @return Response
     */
    public function editArticle(Article $article,
                                Request $request,
                                Packages $packages)
    {

        # On passe à notre formulaire l'URL de la featuredImage
        $options = [
            'image_url' => $packages->getUrl('images/product/'
                . $article->getFeaturedImage())
        ];

        # Récupération de l'image
        $featuredImageName = $article->getFeaturedImage();

        # Notre formulaire attend une instance de File pour l'edition
        # de la featuredImage
        $article->setFeaturedImage(
            new File($this->getParameter('articles_assets_dir')
                . '/' . $featuredImageName)
        );

        # Création / Récupération du Formulaire
        $form = $this->createForm(ArticleType::class, $article, $options)
            ->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            #dump($article);
            # 1. Traitement de l'upload de l'image

            /** @var UploadedFile $featuredImage */
            $featuredImage = $article->getFeaturedImage();

            if (null !== $featuredImage) {

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

            } else {
                $article->setFeaturedImage($featuredImageName);
            }

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
            return $this->redirectToRoute('article_edit', [
                'id' => $article->getId()
            ]);

        }

        # Affichage du Formulaire
        return $this->render('article/form.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * Afficher les articles d'un Auteur
     * @Route("/mes-articles/en-attente",
     *     name="article_en_attente")
     * @Security("has_role('ROLE_AUTEUR')")
     */
    public function mesArticlesEnAttente()
    {
        # Récupération de l'auteur
        $auteur = $this->getUser();

        # Récupération des articles
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAuthorArticlesByStatus($auteur->getId(), 'review');

        return $this->render('article/mesarticles.html.twig', [
            'title' => 'Mes Articles en Attente',
            'articles' => $articles
        ]);
    }

    /**
     * Afficher les articles d'un Auteur
     * @Route("/mes-articles",
     *     name="article_publies")
     * @Security("has_role('ROLE_AUTEUR')")
     */
    public function mesArticlesPublies()
    {
        # Récupération de l'auteur
        $auteur = $this->getUser();

        # Récupération des articles
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAuthorArticlesByStatus($auteur->getId(), 'published');

        return $this->render('article/mesarticles.html.twig', [
            'title' => 'Mes articles publiés',
            'articles' => $articles
        ]);
    }

    /**
     * Afficher les articles en attente d'approbation
     * @Route("/les-articles/en-attente-de-validation",
     *     name="article_to_approval")
     * @Security("has_role('ROLE_EDITEUR')")
     */
    public function toApproval()
    {
        # Récupération des articles
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findArticlesByStatus('editor');

        return $this->render('article/mesarticles.html.twig', [
            'title' => 'Mes articles en attente de validation',
            'articles' => $articles
        ]);
    }

    /**
     * Afficher les articles en attente de correction
     * @Route("/les-articles/en-attente-de-correction",
     *     name="article_to_corrector")
     * @Security("has_role('ROLE_CORRECTEUR')")
     */
    public function toCorrector()
    {
        # Récupération des articles
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findArticlesByStatus('corrector');

        return $this->render('article/mesarticles.html.twig', [
            'title' => 'Mes articles en attente de correction',
            'articles' => $articles
        ]);
    }

    /**
     * Afficher les articles en attente de publication
     * @Route("/les-articles/en-attente-de-publication",
     *     name="article_to_publisher")
     * @Security("has_role('ROLE_PUBLISHER')")
     */
    public function toPublisher()
    {
        # Récupération des articles
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findArticlesByStatus('publisher');

        return $this->render('article/mesarticles.html.twig', [
            'title' => 'Mes articles en attente de publication',
            'articles' => $articles
        ]);
    }

    /**
     * Permet de changer le status d'un Article
     * @Security("has_role('ROLE_AUTEUR')")
     * @Route("/workflow/{status}/{id}",
     *     name="article_workflow")
     * @param $status
     * @param Article le $article
     * @param Registry $registry
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function workflow($status,
                             Article $article,
                             Registry $registry,
                             Request $request)
    {
        # Récupération du Workflow
        $workflow = $registry->get($article);

        try {

            # Changement du Statut
            $workflow->apply($article, $status);

            # Insertion en BDD
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            # Notification
            $this->addFlash('notice',
                'Votre article a bien été transmis. Merci.');

        } catch (LogicException $e) {

            # Transition Non Autorisé
            $this->addFlash('error',
                'Changement de statut impossible.');

        }

        if($workflow->can($article, 'to_be_published')) {

            $workflow->apply($article, 'to_be_published');
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        # Récupération du Redirect
        $redirect = $request->get('redirect') ?? 'index';

        return $this->redirectToRoute($redirect);
    }

}
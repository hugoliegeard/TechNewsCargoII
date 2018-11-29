<?php

namespace App\Controller\TechNews;



use App\Article\Provider\YamlProvider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends Controller
{
    /**
     * Page d'accueil de notre site internet
     * @param YamlProvider $yamlProvider
     * @return Response
     */
    public function index(YamlProvider $yamlProvider)
    {

        # Récupération des articles depuis le YamlProvider
        $articles = $yamlProvider->getArticles();

        # return new Response("<html><body><h1>PAGE D'ACCUEIL</h1></body></html>");
        return $this->render('front/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * Page permettant d'afficher les articles
     * d'une catégorie.
     * @Route("/categorie/{slug<[a-zA-Z1-9\-_\/]+>}",
     *     name="index_categorie",
     *     defaults={"slug":"breaking-news"},
     *     methods={"GET"},
     *     requirements={"slug":"\w+"})
     * @param $slug
     * @return Response
     */
    public function categorie($slug)
    {
        # return new Response("<html><body><h1>PAGE CATEGORIE : $slug</h1></body></html>");
        return $this->render('front/categorie.html.twig');
    }

    /**
     * Afficher un Article
     * @Route("/{categorie<\w+>}/{slug<[a-zA-Z1-9\-_\/]+>}_{id<\d+>}.html",
     *     name="index_article")
     * @param $id
     * @param $slug
     * @param $categorie
     * @return Response
     */
    public function article($id, $slug, $categorie)
    {
        # Exemple d'URL
        # politique/les-gilets-jaunes-mettent-le-feu-a-l-elysee_684651.html

        return $this->render('front/article.html.twig');
    }
}
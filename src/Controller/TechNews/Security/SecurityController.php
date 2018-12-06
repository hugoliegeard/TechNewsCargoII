<?php

namespace App\Controller\TechNews\Security;


use App\Membre\MembreLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * Connexion d'un Membre
     * @Route("/connexion", name="security_connexion")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connexion(AuthenticationUtils $authenticationUtils)
    {
        /**
         * Si notre utilisateur est déjà authentifié,
         * on le redirige sur la page d'accueil
         */
        if($this->getUser()) {
            return $this->redirectToRoute('index');
        }

        # Récupération du Formulaire de Connexion
        $form = $this->createForm(MembreLoginType::class, [
            'email' => $authenticationUtils->getLastUsername()
        ]);

        # Récupération du message d'erreur
        $error = $authenticationUtils->getLastAuthenticationError();

        # Transmission à la Vue
        return $this->render('security/connexion.html.twig', [
            'form' => $form->createView(),
            'error'         => $error,
        ]);
    }

    /**
     * Déconnexion d'un Membre
     * @Route("/deconnexion", name="security_deconnexion")
     */
    public function deconnexion()
    {
    }

    /**
     * Vous pourriez définir ici,
     * votre logique mot de passe oublié,
     * réinitialisation du mot de passe,
     * Email de validation, ...
     */
}
<?php

namespace App\Controller\TechNews;


use App\Entity\Membre;
use App\Membre\MembreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MembreController extends Controller
{
    /**
     * @Route("/inscription",
     *     methods={"GET", "POST"},
     *     name="membre_inscription")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function inscription(Request $request,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        # Création d'un Utilisateur
        $membre = new Membre();

        # Création du Formulaire
        $form = $this->createForm(MembreType::class, $membre)
            ->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if( $form->isSubmitted() && $form->isValid() ) {

            $membre->setPassword($passwordEncoder
                ->encodePassword($membre, $membre->getPassword()));

            # Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();

            # 4. Notification
            $this->addFlash('notice',
                'Félicitation, vous pouvez vous connecter !');

            # 5. Redirection vers la page de connexion
            return $this->redirectToRoute('index');

        }

        # Affichage du Formulaire dans la Vue
        return $this->render('membre/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
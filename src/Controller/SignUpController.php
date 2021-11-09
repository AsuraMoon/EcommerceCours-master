<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\SignUpType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SignUpController extends AbstractController
{
    /**
     * @Route("/signup", name="signup")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em): Response
    {
            /**
         * 1 Créer une instance de User
         * 2 Créer un form
         * 3 Récupérer les resultats reçu depuis le form (avec request)
         * 4 Si User valid et soumis faire un coucou a l'utilisateur
         */

        // 1
        $user = new User();

        //2
        $form = $this->createForm(SignUpType::class, $user);

        //3
        $form->handleRequest($request);

        //4
        if($form->isSubmitted() && $form->isValid()){
            $pwd = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($pwd);
            $em->persist($user);
            $em->flush();
            //dd($form->getData());
            return $this->redirectToRoute('login');
        }   
             
        return $this->render('sign_up/index.html.twig', [
            'signUpUsers' => $form->createView(),
        ]);
    }
}
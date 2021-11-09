<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddAddressType;
use App\Form\ChangePasswordType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{


    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }


    /**
     * @Route("/changePWD", name="changePWD")
     */
    public function changePWD(
        Request $request,
        UserPasswordEncoderInterface $encoder
    ): Response
    {
        $notif= null; //sert a annoncer la modif reussi ou non
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $old_password = $form->get('old_password')->getData();

            if($encoder->isPasswordValid($user, $old_password)) {
                $new_password = $form->get('new_password')->getData();
                $pwd = $encoder->encodePassword($user, $new_password);
                $user->setPassword($pwd);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $notif= "Votre mot de passe a été modifié";
            } 
            else {
                $notif='Mot de passe incorrecte';
            }
        }

        return $this->render('account/changePWD.html.twig', [
            'formPWD' => $form->createView(),
            'notif' => $notif
        ]);
    }

    /**
     *  @Route ("/account/address", name="account_address")
     */
    public function address():Response
    {
        return $this->render("account/address.html.twig");
    }

    /**
     *  @Route ("/account/address/add", name="account_add_address")
     */

    public function AddAddress(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $address = new Address();

        $form = $this->createForm(AddAddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $address->setUser($this->getUser());
            $em->persist($address);
            $em->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/add_address.html.twig', [
            'addAddress' => $form->createView(),
        ]);
    }


    /**
     * @Route("/account/address/modify/{id}",name="account_modify_address")
     */


    public function modifyAddress(Request $request, AddressRepository $repo, $id, EntityManagerInterface $em){
        $address = $repo->findOneById($id);
        
        if(!$address || $address->getUser() != $this->getUser()){
            return $this->redirectToRoute(('account_address'));
        }

        $form = $this->createForm(AddAddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $address->setUser($this->getUser());
            $em->persist($address);
            $em->flush();
            return $this->redirectToRoute('account_address');
        }
        return $this->render('account/add_address.html.twig',[
            'addAddress' => $form->createView(),
        ]);
    }

    /**
     * @Route("/account/address/delete/{id}", name="account_delete_address")
     */
    
    public function deleteAddress(Address $address, EntityManagerInterface $em){
        
        if($address && $address->getUser() == $this->getUser()){
            $em ->remove($address);
            $em -> flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->redirectToRoute('account_address');
    }
}

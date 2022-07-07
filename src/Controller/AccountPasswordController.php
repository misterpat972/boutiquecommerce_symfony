<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountPasswordController extends AbstractController
{   
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {   
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/compte/modifier-mon-mot-de-passe", name="account_password")
     */
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher)
       
    {  
        $user = $this->getUser(); //getUser permet de récupérer l'utilisateur connecté //
        $form = $this->createForm(ChangePasswordType::class, $user); //createForm est une fonction qui permet de creer formulaire //

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $old_password = $form->get('old_password')->getData();
            
            if ($passwordHasher->isPasswordvalid($user,  $old_password)){
                $new_password = $form->get('new_password')->getData();
                $password = $passwordHasher->hashPassword($user, $new_password);

                $user->setPassword($password);                
                $this->entityManager->persist($user); // persit permet de figé la data user pour le flush aprés //
                $this->entityManager->flush(); //flush exécute la persitance pour l'envoyez en base de donnée //
            }

        }

        return $this->render('account/password.html.twig',[
            
            'form' => $form->createView() // permet de rendre la vue du formulaire dans la page password.twig //
        
        ]);

    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use function PHPSTORM_META\type;

class RegisterController extends AbstractController
{   
    private $entityManager;

   public function __construct(EntityManagerInterface $entityManager) // intuManager est la fonction de Doctrine qui nous permettra de faire notre persist et notre flush a la base de donnée
   {
      $this->entityManager = $entityManager;
   }

                                                            //UserPasswordEncoderInterface $encoder
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher) // le premier Request permet de mettre en place une instance symfony qui surveille le post //
    {                                          //Encoder sert a aché les mots de passe dans la base de donnée // 

        $user = new User();
        $form = $this->createForm( RegisterType::class, $user); // la fonction createForm est propre à Symfony elle permet de creer un formulaire lié a l'utilisateur //


        $form->handleRequest($request); // handleRequest permet d'écouter la requête du formulaire et de voir si tout va bien pour l'enregistrement en base de donnée //

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData(); //envoi dans la base de donnée l'inscription si tout est valid //
           
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword()); // permet d'encoder le mot de passe pour ne pas le laisser en clair //
            $user->setPassword($hashedPassword);


            $this->entityManager->persist($user); // persit permet de figé la data user pour le flush aprés //
            $this->entityManager->flush(); //flush exécute la persitance pour l'envoyez en base de donnée //
        }

           // dd($user);  dd permet de faire un var_dump //



        return $this->render( 'register/index.html.twig', [   //render fonction qui donne la direction du fichier vue //

            'form' => $form->createView()   //createView fonction qui permet de mettre en place la vue //
        ]);
      
    }
}

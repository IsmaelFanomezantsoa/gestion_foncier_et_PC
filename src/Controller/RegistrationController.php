<?php

namespace App\Controller;

use App\Entity\ProprietaireParcelle;
use App\Entity\ProprietaireTerrainCf;
use App\Entity\ProprietaireTerrainTitre;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(ManagerRegistry $doctrine , Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cin = $form->get('cin')->getData();
            $pwd = $form->get('plainPassword')->getData();
            $confirmation_pwd = $form->get('confirmation_password')->getData();

            if ($pwd != $confirmation_pwd){
                $this->addFlash('danger',"Les deux mots de passes ne se correspondent pas.");
                return $this->redirectToRoute('app_register');
            }else{
                $proprietaireTerrainTitreRepository = $doctrine->getRepository(ProprietaireTerrainTitre::class);
                $proprietaireTerrainTitre = $proprietaireTerrainTitreRepository->findOneBy(['cin'=> $cin ]);

                $proprietaireTerrainCfRepository = $doctrine->getRepository(ProprietaireTerrainCf::class);
                $proprietaireTerrainCf = $proprietaireTerrainCfRepository->findOneBy(['cin'=> $cin ]);

                $proprietairefParcelleReopository = $doctrine->getRepository(ProprietaireParcelle::class);
                $proprietaireParcelle = $proprietairefParcelleReopository->findOneBy(['cin'=> $cin ]);
                
                
                
                if ($proprietaireTerrainTitre || $proprietaireTerrainCf || $proprietaireParcelle){

                    if($proprietaireTerrainTitre){
                        $user->setNom($proprietaireTerrainTitre->getNom());
                        $user->setPrenom($proprietaireTerrainTitre->getPrenom());
                        $user->setAdresse($proprietaireTerrainTitre->getAdresse());
                        $user->setDateNaissance($proprietaireTerrainTitre->getDateNaissance());
                        $user->setTelephone($proprietaireTerrainTitre->getTelephone());
                        $user->setEmail($proprietaireTerrainTitre->getEmail());
                        $user->setDateNaissance($proprietaireTerrainTitre->getDateNaissance());
                        $user->setRoles(['ROLE_USER']);
                    }
                    if($proprietaireTerrainCf){
                        $user->setNom($proprietaireTerrainCf->getNom());
                        $user->setPrenom($proprietaireTerrainCf->getPrenom());
                        $user->setAdresse($proprietaireTerrainCf->getAdresse());
                        $user->setDateNaissance($proprietaireTerrainCf->getDateNaissance());
                        $user->setTelephone($proprietaireTerrainCf->getTelephone());
                        $user->setEmail($proprietaireTerrainCf->getEmail());
                        $user->setDateNaissance($proprietaireTerrainCf->getDateNaissance());
                        $user->setRoles(['ROLE_USER']);
                    }
                    if($proprietaireParcelle){
                        $user->setNom($proprietaireParcelle->getNom());
                        $user->setPrenom($proprietaireParcelle->getPrenom());
                        $user->setAdresse($proprietaireParcelle->getAdresse());
                        $user->setDateNaissance($proprietaireParcelle->getDateNaissance());
                        $user->setTelephone($proprietaireParcelle->getTelephone());
                        $user->setEmail($proprietaireParcelle->getEmail());
                        $user->setDateNaissance($proprietaireParcelle->getDateNaissance());
                        $user->setRoles(['ROLE_USER']);
                    }

                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                        )
                    );
        
                    $entityManager->persist($user);
                    $entityManager->flush();
        
                    return $userAuthenticator->authenticateUser(
                        $user,
                        $authenticator,
                        $request
                    );
                }else{
                    $this->addFlash('danger','Vous ne pouvez pas vous inscrire parceque vous ne possedez pas aucun terrain');
                    return $this->redirectToRoute('app_register');
                }
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

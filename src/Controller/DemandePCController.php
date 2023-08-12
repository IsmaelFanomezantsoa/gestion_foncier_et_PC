<?php

namespace App\Controller;

use App\Entity\DemandeEnvoye;
use App\Form\DemandePCType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandePCController extends AbstractController
{
    #[Route('/demande/p/c', name: 'app_demande_p_c')]
    public function envoyerDemandePC(HttpFoundationRequest $request): Response
    {
        $demandePC = new DemandeEnvoye();

        $form = $this->createForm(DemandePCType::class, $demandePC);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

        }

        return $this->render('demande_pc/demander pc.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Contenance;
use App\Entity\Parcelle;
use App\Entity\ProprietaireParcelle;
// use App\Entity\TerrainCadastre;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesTerrainsCadastresController extends AbstractController
{
    #[Route('user/mes/terrains/cadastres', name: 'user_app_mes_terrains_cadastres')]
    public function ToutMesTerrainsCadastres(ManagerRegistry $doctrine): Response
    {
        $cinProprietaire = $this->getUser()->getCin();

        $proprietaireParcelleRepository = $doctrine->getRepository(ProprietaireParcelle::class);
        $proprietaire = $proprietaireParcelleRepository->findOneBy(['cin' => $cinProprietaire]);

        if(!$proprietaire){
            $this->addFlash('danger', "Vous n'avez pas de terrain cadastre");
            $mesParcelles = null;//l'utilisateur en question n'a pas de terrain cadastre car il doit avoi au moins une parcelle pour avoir un terrain cadastre 
            return $this->render('mes_terrains_cadastres/mes terrains cadastres.html.twig', [
                'mesParcelles' => $mesParcelles,
            ]);
        }else{
            $mesParcellesRepository = $doctrine->getRepository(Parcelle::class);
            $mesParcelles = $mesParcellesRepository->findBy(['proprietaireParcelle' => $proprietaire->getId()]);

            return $this->render('mes_terrains_cadastres/mes terrains cadastres.html.twig', [
                'mesParcelles' => $mesParcelles,
                'compteur' => 0,
                'nCadastres' => [],
            ]);
        }   
    }

    #[Route('user/show/terrainCadastre/{id?0}', 'app_user_show_terrain_cadastre')]
    public function showTerrainCadastre($id, Parcelle $parcelle = null, ManagerRegistry $doctrine)//param converter
    {
        if(!$parcelle){
            $this->addFlash('danger' , "Le terrain n'existe pas");
            return $this->redirectToRoute("app_user_mes_terrains_cadastres");
        }

        $repository = $doctrine->getRepository(Contenance::class);
        $contenance = $repository->findBy(['parcelle' => $id]);

        return $this->render('mes_terrains_cadastres/show terrain cadastre.html.twig', [
            'parcelle' => $parcelle, 
            'contenances'=> $contenance,
        ]);
    }
}

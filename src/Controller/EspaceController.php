<?php

namespace App\Controller;

use App\Entity\Espace;
use App\Form\EspaceSupprimerType;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use App\Form\EspaceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EspaceController extends AbstractController
{
    #[Route('/', name: 'app_espace')]
    public function index(\Doctrine\Persistence\ManagerRegistry $doctrine, Request $request): Response
    {
        $espace = new Espace();
        $form = $this->createForm(EspaceType::class, $espace);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ((($form->getData()->getDateOuverture() !== null && $form->getData()->getDateFermeture() !== null) && $form->getData()->getDateOuverture() < $form->getData()->getDateFermeture())
                || ($form->getData()->getDateOuverture() === null && $form->getData()->getDateFermeture() === null)
            ) {
                $em = $doctrine->getManager();
                $em->persist($espace);
                $em->flush();
            } else {
                throw $this->createNotFoundException("Les champs : 'Date d'ouverture' et 'Date de fermeture' doivent être mals remplis");
            }
        }

        $repo = $doctrine->getRepository(Espace::class);
        $espaces = $repo->findAll();

        return $this->render('espace/index.html.twig', [
            'espaces' => $espaces,
            'formulaire'=> $form->createView()
        ]);
    }

    /**
     * @Route("/espace/supprimer/{id}", name="espace_supprimer")
     */
    public function supprimerEspace($id, \Doctrine\Persistence\ManagerRegistry $doctrine, Request $request)
    {
        $espace = $doctrine->getRepository(Espace::class)->find($id);
        if (!$espace) {
            throw $this->createNotFoundException("Aucune catégorie avec l'id $id");
        }
        $form = $this->createForm(EspaceSupprimerType::class, $espace);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->remove($espace);
            $em->flush();
            return $this->redirectToRoute("app_espace");
        }
        return $this->render('espace/supprimerEspace.html.twig', [
            'espace' => $espace,
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/espace/modifier/{id}", name="espace_modifier")
     */
    public function modifierEspace($id, \Doctrine\Persistence\ManagerRegistry $doctrine, Request $request){
        $espace = $doctrine->getRepository(Espace::class)->find($id);
        if(!$espace){
            throw $this->createNotFoundException("Aucune catégorie avec l'id $id");
        }
        $form = $this->createForm(EspaceType::class, $espace);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ((($form->getData()->getDateOuverture() !== null && $form->getData()->getDateFermeture() !== null) && $form->getData()->getDateOuverture() < $form->getData()->getDateFermeture())
                || ($form->getData()->getDateOuverture() === null && $form->getData()->getDateFermeture() === null)
            ) {
                $em = $doctrine->getManager();
                $em->persist($espace);
                $em->flush();
                return $this->redirectToRoute("app_espace");
            } else {
                throw $this->createNotFoundException("Les champs : 'Date d'ouverture' et 'Date de fermeture' doivent être mals remplis");
            }
        }
        return $this->render('espace/modifierEspace.html.twig', [
            'espace' => $espace,
            'formulaire'=> $form->createView()
        ]);


    }
}

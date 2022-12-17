<?php

namespace App\Controller;

use App\Entity\Enclos;
use App\Entity\Espace;
use App\Form\EnclosSupprimerType;
use App\Form\EnclosType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnclosController extends AbstractController
{
    #[Route('/enclos', name: 'app_enclos')]
    public function index(): Response
    {
        return $this->render('enclos/index.html.twig', [
            'controller_name' => 'EnclosController',
        ]);
    }

    #[Route('/enclos/ajouter', name: 'enclos_ajouter')]
    public function ajouterEnclos(\Doctrine\Persistence\ManagerRegistry $doctrine, Request $request){
        $enclos = new Enclos();
        $form = $this->createForm(EnclosType::class, $enclos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($enclos);
            $em->flush();
            $repo = $doctrine->getRepository(Enclos::class);
            $enclos = $repo->findAll();
            return $this->redirectToRoute("app_espace");
        }
        return $this->render('enclos/ajouterEnclos.html.twig', [
            'enclos' => $enclos,
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/enclos/{id}", name="enclos_afficher")
     */
    public function afficherEnclos($id, \Doctrine\Persistence\ManagerRegistry $doctrine, Request $request)
    {
        $espace = $doctrine->getRepository(Espace::class)->find($id);
        if (!$espace) {
            throw $this->createNotFoundException("Aucun espace avec l'id $id");
        }
        $enclos = $espace->getEnclos();
        return $this->render('enclos/afficherEnclos.html.twig', [
            'espace' => $espace,
            'enclos' => $enclos,
        ]);
    }

    /**
     * @Route("/enclos/modifier/{id}", name="modifier_enclos")
     */
    public function modifierEnclos($id, \Doctrine\Persistence\ManagerRegistry $doctrine, Request $request)
    {
        $enclos = $doctrine->getRepository(Enclos::class)->find($id);
        if (!$enclos) {
            throw $this->createNotFoundException("Aucun enclos avec l'id $id");
        }
        $form = $this->createForm(EnclosType::class, $enclos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($enclos);
            $em->flush();
            return $this->redirectToRoute("app_espace");
        }
        return $this->render('enclos/modifierEnclos.html.twig', [
            'enclos' => $enclos,
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/enclos/supprimer/{id}", name="enclos_supprimer")
     */
    public function supprimerEnclos($id, \Doctrine\Persistence\ManagerRegistry $doctrine, Request $request)
    {
        $enclos = $doctrine->getRepository(Enclos::class)->find($id);
        $espace = $enclos->getEspace();
        $espaceId = $espace->getId();
        if (!$enclos) {
            throw $this->createNotFoundException("Aucun enclos avec l'id $id");
        }
        $form = $this->createForm(EnclosSupprimerType::class, $enclos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($enclos->getAnimaux()->isEmpty()) {

                $em = $doctrine->getManager();
                $em->remove($enclos);
                $em->flush();
                return $this->redirectToRoute("app_espace");

            }
            else throw $this->createNotFoundException("L'enclos contient des animaux");
        }
        return $this->render('enclos/supprimerEnclos.html.twig', [
            'enclos' => $enclos,
            'espace' => $espaceId,
            'formulaire' => $form->createView()
        ]);
    }


}

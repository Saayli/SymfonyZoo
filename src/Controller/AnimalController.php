<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Enclos;
use App\Form\AnimalSupprimerType;
use App\Form\AnimalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    #[Route('/animal', name: 'app_animal')]
    public function index(): Response
    {

        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }

    #[Route('/animal/ajouter', name: 'animal_ajouter')]
    public function ajouterAnimal(\Doctrine\Persistence\ManagerRegistry $doctrine, Request $request)
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $enclosAnimal = $animal->getEnclo();
            $enclosId = $enclosAnimal->getId();
            $enclos = $doctrine->getRepository(Enclos::class)->find($enclosId);
            $enclosMax = $enclos->getAnimauxMax();
            $animaux = $doctrine->getRepository(Animal::class)->findAll();
            $nbAnimauxEnclos = 0;

            foreach ($animaux as $a) {
                if ($a->getEnclo()->getId() == $enclosId) $nbAnimauxEnclos += 1;
            }

            $lenNumId = strlen($animal->getNumId());

            if ($lenNumId == 14 && is_numeric($animal->getNumId())) {

                if ($animal->getDateDepart() > $animal->getDateArrivee()) {

                    if ($nbAnimauxEnclos < $enclosMax) {

                        if ($enclos->isQuarantaine()) {
                            $animauxQuarantaine = true;
                            foreach ($enclos->getAnimaux() as $a) {
                                $a->isQuarantaine() && $animauxQuarantaine = false;
                            }

                            if ($animauxQuarantaine) {
                                $enclos->setQuarantaine(false);
                            }
                        } else {
                            if ($animal->isQuarantaine()) $enclos->setQuarantaine(true);
                        }
                        $em = $doctrine->getManager();
                        $em->persist($animal);
                        $em->flush();
                        $repo = $doctrine->getRepository(Animal::class);
                        $animal = $repo->findAll();
                        return $this->redirectToRoute("app_espace");

                    } else throw $this->createNotFoundException("Il y a trop d'animaux dans cet enclos !");
                } else throw $this->createNotFoundException("L'animal ne peut partir du zoo avant d'être arrivé");
            } else $lenNumId != 14 ? throw $this->createNotFoundException("Le numéro d'identification doit être de 14 chiffres") : throw $this->createNotFoundException("Le numéro d'identification doit seulement être des chiffres !");

        }
        return $this->render('animal/ajouterAnimal.html.twig', [
            'animal' => $animal,
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/animal/{id}", name="animal_afficher")
     */
    public function afficherAnimal($id, \Doctrine\Persistence\ManagerRegistry $doctrine, Request $request)
    {
        $enclos = $doctrine->getRepository(Enclos::class)->find($id);
        if (!$enclos) {
            throw $this->createNotFoundException("Aucun enclos avec l'id $id");
        }
        $animal = $enclos->getAnimaux();
        return $this->render('animal/afficherAnimal.html.twig', [
            'animal' => $animal,
            'enclos' => $enclos,
        ]);
    }

    /**
     * @Route("/animal/modifier/{id}", name="modifier_animal")
     */
    public function modifierAnimal($id, \Doctrine\Persistence\ManagerRegistry $doctrine, Request $request)
    {
        $animal = $doctrine->getRepository(Animal::class)->find($id);
        if (!$animal) {
            throw $this->createNotFoundException("Aucun animal avec l'id $id");
        }
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $enclosAnimal = $animal->getEnclo();
            $enclosId = $enclosAnimal->getId();
            $enclos = $doctrine->getRepository(Enclos::class)->find($enclosId);
            $enclosMax = $enclos->getAnimauxMax();
            $animaux = $doctrine->getRepository(Animal::class)->findAll();
            $nbAnimauxEnclos = 0;

            foreach ($animaux as $a) {
                if ($a->getEnclo()->getId() == $enclosId) $nbAnimauxEnclos += 1;
            }

            $lenNumId = strlen($animal->getNumId());

            if ($lenNumId == 14 && is_numeric($animal->getNumId())) {

                if ($animal->getDateDepart() > $animal->getDateArrivee()) {

                    if ($nbAnimauxEnclos < $enclosMax) {

                        if ($enclos->isQuarantaine()) {
                            $animauxQuarantaine = true;
                            foreach ($enclos->getAnimaux() as $a) {
                                $a->isQuarantaine() && $animauxQuarantaine = false;
                            }

                            if ($animauxQuarantaine) {
                                $enclos->setQuarantaine(false);
                            }
                        } else {
                            if ($animal->isQuarantaine()) $enclos->setQuarantaine(true);
                        }
                        $em = $doctrine->getManager();
                        $em->persist($animal);
                        $em->flush();
                        $repo = $doctrine->getRepository(Animal::class);
                        $animal = $repo->findAll();
                        return $this->redirectToRoute("app_espace");

                    } else throw $this->createNotFoundException("Il y a trop d'animaux dans cet enclos !");
                } else throw $this->createNotFoundException("L'animal ne peut partir du zoo avant d'être arrivé");
            } else $lenNumId != 14 ? throw $this->createNotFoundException("Le numéro d'identification doit être de 14 chiffres") : throw $this->createNotFoundException("Le numéro d'identification doit seulement être des chiffres !");

        }
        return $this->render('animal/modifierAnimal.html.twig', [
            'animal' => $animal,
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/animal/supprimer/{id}", name="animal_supprimer")
     */
    public function supprimerAnimal($id, \Doctrine\Persistence\ManagerRegistry $doctrine, Request $request)
    {
        $animal = $doctrine->getRepository(Animal::class)->find($id);
        $enclosAnimal = $animal->getEnclo();
        $enclosId = $enclosAnimal->getId();
        if (!$animal) {
            throw $this->createNotFoundException("Aucun animal avec l'id $id");
        }
        $form = $this->createForm(AnimalSupprimerType::class, $animal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->remove($animal);
            $em->flush();
            return $this->redirectToRoute("app_espace");
        }
        return $this->render('animal/supprimerAnimal.html.twig', [
            'enclos' => $enclosId,
            'animal' => $animal,
            'formulaire' => $form->createView()
        ]);
    }
}

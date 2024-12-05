<?php

namespace App\Controller;

use App\Entity\Produit;

use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();
        return $this->render('accueil/accueil.html.twig', [
            'produitList' => $produits,
        ]);
    }

    #[Route('/produit', name: 'app_produit')]
    public function afficher(ProduitRepository $produitRepository): Response
    {

        $produits = $produitRepository->findAll();
        return $this->render('produit.html.twig', [
            "produitList" => $produits
        ]);
    }
    #[Route('/article/{id}', name: 'app_article')]
    public function detail(EntityManagerInterface $entityManager, int $id): Response
    {

        $repository = $entityManager->getRepository(Produit::class);
        $afficherProduit = $repository->find($id);
        
        return $this->render('article.html.twig', [
            "produit" => $afficherProduit
        ]);
    }

    #[Route('/nous', name: 'app_nous')]
    public function dire(): Response
    {

        $nousSommes = "infoPresentation";
        return $this->render('accueil/nous.html.twig', [
            "infoPresentation" => $nousSommes
        ]);
    }
    #[Route('/inscription', name: 'app_inscription')]
    public function ajouter(): Response
    {

        $inscription = "inscription";
        return $this->render('accueil/inscription.html.twig', [
            "infoInscription" => $inscription
        ]);
    }
    #[Route('/connexion', name: 'app_connexion')]
    public function connexion(): Response
    {

        $connexion = "connexion";
        return $this->render('accueil/connexion.html.twig', [
            "infoConnexion" => $connexion
        ]);
    }

    #[Route('/ajouter', name: 'app_ajouter')]
    public function appro(EntityManagerInterface $em, Request $request, #[Autowire('%photo_dir%')] string $photoDir): Response
    {

        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();
            if($photo = $form['photo']->getData()) {
        $fileName = uniqid().'.'.$photo->guessExtension();
        $photo->move($photoDir, $fileName);
        }  
        $produit->setImageFilename($fileName);

           // $em = $produit->getManager();

          $em->persist($produit);
          $em->flush();
          $this->addFlash(
            'notice',
            'Produit ajouté avec succès”!'
    );
    // return $this->redirectToRoute('app_catalog');

         }
        return $this->render('ajouter.html.twig', [
            "formAjouter" => $form
        ]);
    }
    #[Route('/catalog', name: 'app_catalog')]
    public function voir(ProduitRepository $produitRepository): Response
    {

        $produits = $produitRepository->findAll();
        return $this->render('catalog.html.twig', [
            "produitList" => $produits
        ]);
    }
    #[Route('/modifier/{id}', name: 'app_modifier')]
    public function modifier(EntityManagerInterface $entityManager, int $id, Request $request): Response
    {

        $repository = $entityManager->getRepository(produit::class);
        $modifierContact = $repository->find($id);

        $form = $this->createForm(ProduitType::class, $modifierContact );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $entityManager->flush();
          $this->addFlash(
                'notice',
                'produit modifié avec succès!'
        );
            return $this->redirectToRoute('app_catalog');
        }

        return $this->render('modifier.html.twig', [
        "formModifier" => $form
    ]);
    }

    #[Route('/supprimer/{id}', name: 'app_supprimer')]
    public function supprimer(EntityManagerInterface $entityManager, int $id): Response
    {
        $repository = $entityManager->getRepository(Produit::class);
        $produit = $repository->find($id);

        $entityManager->remove($produit);
        $entityManager->flush();

        return $this->redirectToRoute('app_catalog');
           
  

     
    }

}

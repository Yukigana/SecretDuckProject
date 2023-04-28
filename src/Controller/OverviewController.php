<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\IsInCommande;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'overview')]
class OverviewController extends AbstractController
{
    #[Route('', name: '')]
    public function indexAction(): Response
    {
        return $this->render('/Overview/Accueil.html.twig');
    }

    #[Route('magasin/gestion', name: '_magasin_gestion')]
    public function gestionProduitsAction(EntityManagerInterface $em): Response
    {
        $produitRepository = $em->getRepository(Produit::class);
        $produits = $produitRepository->findAll(); // récupère toutes les lignes de la BD (sinon find($id) => récupère la ligne correspondant à l'id)
        $args = array(
            'produits' => $produits,
        );
        return $this->render('Overview/ListProduit.html.twig', $args);
    }

    #[Route('user/gestion', name: '_user_gestion')]
    public function gestionUsersAction(EntityManagerInterface $em): Response
    {
        $userRepository = $em->getRepository(User::class);
        $users = $userRepository->findAll(); // récupère toutes les lignes de la BD (sinon find($id) => récupère la ligne correspondant à l'id)
        $args = array(
            'users' => $users,
        );
        return $this->render('Overview/ListUser.html.twig', $args);
    }

    // Affiche le panier du client
    #[Route('user/panier', name: '_user_panier')]
    public function userPanierAction(EntityManagerInterface $em): Response
    {
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->find($this->getUser()->getId()); // récupère toutes les lignes de la BD (sinon find($id) => récupère la ligne correspondant à l'id)
        
        $args = array(
            'produits' => array(),
            'prixTot' => 0,
        );

        $panierRepository = $em->getRepository(IsInCommande::class);
        $panier = $panierRepository->findAll();

        $produitRepository = $em->getRepository(Produit::class);

        foreach($panier as $article){
            if($user->getId() == $article->getUser()->getId()){
                $args['prixTot'] += ($produitRepository->find($article->getProduit()))->getPrix() * $article->getQuantite();
                $data = array(
                    'produit' => $produitRepository->find($article->getProduit()),
                    'quantite' => $article->getQuantite(),
                );

                array_push($args['produits'], $data);
            }
        }

        return $this->render('Overview/ListPanier.html.twig', $args);
    }

    #[Route('/panier/add/{id_produit}/',
        name: '_panier_add',
        requirements: [
            'id_produit' => '[1-9]\d*',
        ],
    )]
    public function panierAddAction(int $id_produit, EntityManagerInterface $em): Response
    {
        $produitRepository = $em->getRepository(Produit::class);
        $produit = $produitRepository->find($id_produit);

        // si le produit est en stock
        if($produit->getQuantite() > 0){
            $panierRepository = $em->getRepository(IsInCommande::class);
            $panier = $panierRepository->findAll();

            // on passe sur tous les articles de tous les paniers
            $exist = false;
            foreach($panier as $article){
                if(($article->getUser()->getId() == $this->getUser()->getId()) && ($article->getProduit()->getId() == $id_produit)){
                    $exist = true;
                
                    $article->setQuantite($article->getQuantite() + 1); // le panier augmente
                    $produit->setQuantite($produit->getQuantite() - 1); // le stock diminue


                    $em->persist($article);
                    $em->persist($produit);
                    $em->flush();
                }
            }

            // si l'article n'est pas déjà dans le panier 
            if($exist == false){
                $userRepository = $em->getRepository(User::class);

                $panierProduit = new IsInCommande();
                $panierProduit->setQuantite(1);
                $panierProduit->setId($userRepository->find($this->getUser()->getId()));
                $panierProduit->setProduit($produit);

                $produit->setQuantite($produit->getQuantite() - 1); // le stock diminue

                $em->persist($produit);
                $em->persist($panierProduit);
                $em->flush();
            }
        }

        return $this->redirectToRoute('overview_magasin_gestion');
    }

    #[Route('/panier/suppArticle/{id_produit}/',
        name: '_panier_suppArticle',
        requirements: [
            'id_produit' => '[1-9]\d*',
        ],
    )]
    public function panierSuppArticleAction(int $id_produit, EntityManagerInterface $em): Response
    {
        $produitRepository = $em->getRepository(Produit::class);
        $produit = $produitRepository->find($id_produit);

        $panierRepository = $em->getRepository(IsInCommande::class);
        $panier = $panierRepository->findAll();
        
        foreach($panier as $article){
            if(($article->getUser()->getId() == $this->getUser()->getId()) && ($article->getProduit()== $produit)){
                
                $produit->setQuantite($produit->getQuantite() + $article->getQuantite()); // le stock diminue

                $em->remove($article);
                $em->persist($produit);
                $em->flush();
            }
        }

        return $this->redirectToRoute('overview_user_panier');
    }

    #[Route('/panier/delete/{id_user}/',
        name: '_panier_delete',
        requirements: [
            'id_user' => '[1-9]\d*',
        ],
    )]
    public function panierDeleteAction(int $id_user, EntityManagerInterface $em): Response
    {
        $panierRepository = $em->getRepository(IsInCommande::class);
        $panier = $panierRepository->findAll();

        foreach($panier as $article){
            if($article->getUser()->getId() == $id_user){
                $produitRepository = $em->getRepository(Produit::class);
                $produit = $produitRepository->find($article->getProduit()->getId());

                $produit->setQuantite($produit->getQuantite() + $article->getQuantite()); // le stock augmente

                $em->remove($article);
                $em->persist($produit);
                $em->flush();
            }
        }
        return $this->redirectToRoute('overview_user_panier');
    }

    #[Route('/panier/deleteUser/{id_user}/',
        name: '_panier_delete_user',
        requirements: [
            'id_user' => '[1-9]\d*',
        ],
    )]
    public function panierDeleteUserAction(int $id_user, EntityManagerInterface $em): Response
    {
        $panierRepository = $em->getRepository(IsInCommande::class);
        $panier = $panierRepository->findAll();

        foreach($panier as $article){
            if($article->getUser()->getId() == $id_user){
                $produitRepository = $em->getRepository(Produit::class);
                $produit = $produitRepository->find($article->getProduit()->getId());

                $produit->setQuantite($produit->getQuantite() + $article->getQuantite()); // le stock augmente

                $em->remove($article);
                $em->persist($produit);
                $em->flush();
            }
        }
        return $this->redirectToRoute('overview_user_gestion');
    }
    
    #[Route('/panier/commande',
        name: '_panier_commande',
        requirements: [
            'id_user' => '[1-9]\d*',
        ],
    )]
    public function panierCommandeAction(EntityManagerInterface $em): Response
    {
        $panierRepository = $em->getRepository(IsInCommande::class);
        $panier = $panierRepository->findAll();

        foreach($panier as $article){
            if($article->getUser()->getId() == $this->getUser()->getId()){
                $em->remove($article);
                $em->flush();
            }
        }
        return $this->redirectToRoute('overview_user_panier');
    }
}

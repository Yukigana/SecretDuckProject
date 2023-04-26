<?php

namespace App\Controller;

use App\Entity\Produit;
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
}

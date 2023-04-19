<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/form', name: 'form')]
class FormController extends AbstractController
{
    #[Route(
        '/produit/edit/{id}',
        name: '_produit_edit',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function produitEditAction(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $produitRepository = $em->getRepository(Produit::class);
        $produit = $produitRepository->find($id);

        if (is_null($produit))
            throw new NotFoundHttpException('produit ' . $id . ' inexistant');

        $form = $this->createForm(ProduitType::class, $produit);
        $form->add('send', SubmitType::class, ['label' => 'edit produit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            $this->addFlash('info', 'édition produit réussie');
            return $this->redirectToRoute('overview_magasin_gestion');
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire produit incorrect');

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Form/produitEdit.html.twig', $args);
    }


    #[Route('/produit/add', name: '_produit_add')]
    public function produitAddAction(EntityManagerInterface $em, Request $request): Response
    {
        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->add('send', SubmitType::class, ['label' => 'add produit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($produit);
            $em->flush();
            $this->addFlash('info', 'ajout produit réussi');
            return $this->redirectToRoute('overview_magasin_gestion');
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire ajout produit incorrect');

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Form/produitAdd.html.twig', $args);
    }


    #[Route(
        'produit/delete/{id}',
        name: '_produit_delete',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function produitDeleteAction(int $id, EntityManagerInterface $em): Response
    {
        $produitRepository = $em->getRepository(Produit::class);
        $produit = $produitRepository->find($id);

        if (is_null($produit))
            throw new NotFoundHttpException('erreur suppression produit ' . $id);

        $em->remove($produit);
        $em->flush();
        $this->addFlash('info', 'suppression produit ' . $id . ' réussie');

        return $this->redirectToRoute('overview_magasin_gestion');
    }


    #[Route('/nouveaucompte', name: '_nouveaucompte')]
    public function userAddAction(EntityManagerInterface $em, Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->add('send', SubmitType::class, ['label' => 'add user']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($user);
            $em->flush();
            $this->addFlash('info', 'ajout user réussi');
            return $this->redirectToRoute('overview');
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire ajout user incorrect');

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Form/userAdd.html.twig', $args);
    }
}
<?php

namespace App\Controller;

use App\Entity\IsInCommande;
use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\ProduitShopType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/form', name: 'form')]
class FormController extends AbstractController
{
    #[Route(
        '/produit/list',
        name: '_produit_list',
    )]
    public function produitListAction(EntityManagerInterface $em, Request $request): Response
    {
        // Récupération de tous les produits du magasin
        $produitsRepository = $em->getRepository(Produit::class);
        $produits = $produitsRepository->findAll();

        $args = array(
            'produits' => array(),
        );

        // On passe par chaque produit pour leur créer un formulaire perso
        foreach ($produits as $produit){
            $data = array();
            // Si la quantité disponible alors on ne met pas de formulaire
            /*if($produit.getQuantite() > 0){
                array_push($data, $produit);
            }
            else */
            
            $form = $this->createForm(ProduitShopType::class, $produit);
            $form->add('send', SubmitType::class, ['label' => 'edit produit']);

            array_push($data, $produit);
            array_push($data, $form);

            array_push($args['produits'], $data);
        }
        
        //$form->handleRequest($request);

        return $this->render('Form/produitShop.html.twig', $args);
    }

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


    #[Route('/admin/add', name: '_admin_add')]
    public function adminAddAction(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->add('send', SubmitType::class, ['label' => 'add user']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword ($passwordHasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_ADMIN']);

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


    #[Route('/nouveaucompte', name: '_nouveaucompte')]
    public function userAddAction(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->add('send', SubmitType::class, ['label' => 'add user']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword ($passwordHasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);

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


    #[Route(
        '/user/edit/{id}',
        name: '_user_edit',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function userEditAction(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->find($id);

        if (is_null($user))
            throw new NotFoundHttpException('user ' . $id . ' inexistant');

        $form = $this->createForm(UserEditType::class, $user);
        $form->add('send', SubmitType::class, ['label' => 'edit user']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            $this->addFlash('info', 'édition user réussie');
            return $this->redirectToRoute('overview');
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire user incorrect');

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Form/userEdit.html.twig', $args);
    }

    #[Route(
        'user/delete/{id}',
        name: '_user_delete',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function userDeleteAction(int $id, EntityManagerInterface $em): Response
    {
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->find($id);

        if (is_null($user))
            throw new NotFoundHttpException('erreur suppression user ' . $id);

        $em->remove($user);
        $em->flush();
        $this->addFlash('info', 'suppression user ' . $id . ' réussie');

        return $this->redirectToRoute('overview_panier_delete', ['id_user' => $id]);
    }
}
<?php

namespace App\Controller;

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

        $form = $this->createForm(ProduiType::class, $produit);
        $form->add('send', SubmitType::class, ['label' => 'edit produit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            $this->addFlash('info', 'édition produit réussie');
            return $this->redirectToRoute('overview_list');
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
            return $this->redirectToRoute('overview_list');
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire ajout produit incorrect');

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Form/produitAdd.html.twig', $args);
    }


}

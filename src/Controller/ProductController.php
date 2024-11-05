<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $ProductRepository): Response
    {
        $products = $ProductRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/user', name: 'app_user')]
    public function index_user(): Response
    {
        return $this->render('product/index_user.html.twig');
    }




    #[Route('/product/create', name: 'app_product_create', methods: ['GET', 'POST'])]
    public function create(request $request ,EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('product/create.html.twig', [
            'form' =>  $form
        ]);
    }

    #[Route('/product/edit/{id}', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(request $request, ProductRepository $ProductRepository , int $id ,EntityManagerInterface $entityManager): Response
    {

        $product = $ProductRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }
        
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' =>  $form
        ]);
    }


    #[Route('/product/show/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show( ProductRepository $ProductRepository , int $id ): Response
    {

        $product = $ProductRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }
        
        return $this->renderForm('product/show.html.twig', [
            'product' => $product,
        ]);
    }


    #[Route('/delete/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, ProductRepository $ProductRepository , int $id , EntityManagerInterface $entityManager): Response
    {

        $product = $ProductRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }


        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product', [], Response::HTTP_SEE_OTHER);
    }

}

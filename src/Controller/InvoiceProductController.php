<?php

namespace App\Controller;

use App\Entity\InvoiceProduct;
use App\Form\InvoiceProductType;
use App\Repository\InvoiceProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/invoice_product")
 */
class InvoiceProductController extends AbstractController
{
    /**
     * @Route("/", name="app_invoice_product_index", methods={"GET"})
     */
    public function index(InvoiceProductRepository $invoiceProductRepository): Response
    {
        return $this->render('invoice_product/index.html.twig', [
            'invoice_products' => $invoiceProductRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_invoice_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, InvoiceProductRepository $invoiceProductRepository): Response
    {
        $invoiceProduct = new InvoiceProduct();
        $form = $this->createForm(InvoiceProductType::class, $invoiceProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoiceProductRepository->add($invoiceProduct, true);

            return $this->redirectToRoute('app_invoice_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('invoice_product/new.html.twig', [
            'invoice_product' => $invoiceProduct,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_invoice_product_show", methods={"GET"})
     */
    public function show(InvoiceProduct $invoiceProduct): Response
    {
        return $this->render('invoice_product/show.html.twig', [
            'invoice_product' => $invoiceProduct,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_invoice_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, InvoiceProduct $invoiceProduct, InvoiceProductRepository $invoiceProductRepository): Response
    {
        $form = $this->createForm(InvoiceProductType::class, $invoiceProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoiceProductRepository->add($invoiceProduct, true);

            return $this->redirectToRoute('app_invoice_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('invoice_product/edit.html.twig', [
            'invoice_product' => $invoiceProduct,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_invoice_product_delete", methods={"POST"})
     */
    public function delete(Request $request, InvoiceProduct $invoiceProduct, InvoiceProductRepository $invoiceProductRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$invoiceProduct->getId(), $request->request->get('_token'))) {
            $invoiceProductRepository->remove($invoiceProduct, true);
        }

        return $this->redirectToRoute('app_invoice_product_index', [], Response::HTTP_SEE_OTHER);
    }
}

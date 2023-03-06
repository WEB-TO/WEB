<?php

namespace App\Controller;

use App\Entity\InvoiceDetail;
use App\Form\InvoiceDetailType;
use App\Repository\InvoiceDetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/invoice_detail")
 */
class InvoiceDetailController extends AbstractController
{
    /**
     * @Route("/", name="app_invoice_detail_index", methods={"GET"})
     */
    public function index(InvoiceDetailRepository $invoiceDetailRepository): Response
    {
        return $this->render('invoice_detail/index.html.twig', [
            'invoice_details' => $invoiceDetailRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_invoice_detail_new", methods={"GET", "POST"})
     */
    public function new(Request $request, InvoiceDetailRepository $invoiceDetailRepository): Response
    {
        $invoiceDetail = new InvoiceDetail();
        $form = $this->createForm(InvoiceDetailType::class, $invoiceDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoiceDetailRepository->add($invoiceDetail, true);

            return $this->redirectToRoute('app_invoice_detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('invoice_detail/new.html.twig', [
            'invoice_detail' => $invoiceDetail,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_invoice_detail_show", methods={"GET"})
     */
    public function show(InvoiceDetail $invoiceDetail): Response
    {
        return $this->render('invoice_detail/show.html.twig', [
            'invoice_detail' => $invoiceDetail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_invoice_detail_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, InvoiceDetail $invoiceDetail, InvoiceDetailRepository $invoiceDetailRepository): Response
    {
        $form = $this->createForm(InvoiceDetailType::class, $invoiceDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoiceDetailRepository->add($invoiceDetail, true);

            return $this->redirectToRoute('app_invoice_detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('invoice_detail/edit.html.twig', [
            'invoice_detail' => $invoiceDetail,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_invoice_detail_delete", methods={"POST"})
     */
    public function delete(Request $request, InvoiceDetail $invoiceDetail, InvoiceDetailRepository $invoiceDetailRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$invoiceDetail->getId(), $request->request->get('_token'))) {
            $invoiceDetailRepository->remove($invoiceDetail, true);
        }

        return $this->redirectToRoute('app_invoice_detail_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Form\SaleType;
use App\Repository\SaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sale")
 */
class SaleController extends AbstractController
{
    /**
     * @Route("/", name="sale_index", methods={"GET"})
     */
    public function index(SaleRepository $saleRepository): Response
    {
        return $this->render('sale/index.html.twig', [
            'sales' => $saleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sale_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sale = new Sale();
        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sale);
            $entityManager->flush();

            return $this->redirectToRoute('sale_index');
        }

        return $this->render('sale/new.html.twig', [
            'sale' => $sale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sale_show", methods={"GET"})
     */
    public function show(Sale $sale): Response
    {
        return $this->render('sale/show.html.twig', [
            'sale' => $sale,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sale_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sale $sale): Response
    {
        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sale_index');
        }

        return $this->render('sale/edit.html.twig', [
            'sale' => $sale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sale_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sale $sale): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sale->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sale_index');
    }

  /*  public function findByDate($value1, $value2)
    {
        $sb = $this->getDoctrine()->getManager();
        $sb = $sb->createQueryBuilder();
        $sb->select('node')
            ->from('App\Entity\Sale', 'node')
            ->where('(node.sale_date)->format(\'Y\') == :value1')
            ->andWhere('(node.sale_date)->format(\'m\') == :value2')
            ->orderBy('node.sale_date', 'ASC');
        $answ = $sb->getQuery()->getResult();
        return $this->render('home/index.html.twig', ['answ' => $answ]);
    }
*/
    public function findGreaterThanAmount(Request $request)
    {
        $am = $request->$request->getInt('am');
        $query = $this->getDoctrine()->getManager();
        $query = $query->createQueryBuilder();
        $query->select('node')
            ->from('App\Enity\Pet', 'node')
            ->where('node.amount > :am')
            ->setParameter('amount', $am);
            $b = $query->getQuery()->getResult();


        return $this->render('home/index.html.twig', ['query' => $b]);
    }
}

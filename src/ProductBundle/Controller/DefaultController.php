<?php

namespace ProductBundle\Controller;

use ProductBundle\Form\BuyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProductBundle\Entity\Product;
use ProductBundle\Entity\Historia;
use ProductBundle\Form\AddType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $products = $this->getDoctrine()->
        getRepository('ProductBundle:Product')
            ->findAllOrderedByName();
        return $this->render('ProductBundle:Default:index.html.twig',
            array(
                'products' => $products,
            ));
    }

    public function addAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(AddType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_homepage');
        }

        return $this->render('ProductBundle:Default:product_form.html.twig',
            array(
                'form' => $form->createView(),
            ));
    }

    public function buyAction(Request $request, $id)
    {
        $history = new Historia();

        $product = $this->getDoctrine()->getRepository('ProductBundle:Product')->find($id);

        if(!$product)
        {

        } else
        {
            $form = $this->createForm(BuyType::class, $history);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $history->setProduct($product);
                $product->addHistory($history);
                $history->setDate();
                $em->persist($history);
                $em->flush();

                return $this->redirectToRoute('product_homepage');
            }
        }

        return $this->render('ProductBundle:Default:product_buy.html.twig',
            array(
                'form' => $form->createView(),
            ));
    }

    public function showHistoryAction()
    {
        $history = $this->getDoctrine()->getRepository('ProductBundle:Historia')->findAll();

        return $this->render('ProductBundle:Default:product_buy_stories.html.twig', array(
            'history' => isset($history) ? $history : NULL,
        ));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ProductBundle:Product')->find($id);
        if (!$product) {
            throw $this->createNoFoundException(
                'No product found for id ' . $id
            );
        }
        $form = $this->createForm(AddType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('product_homepage');
        }
        return $this->
        render('ProductBundle:Default:product_form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ProductBundle:Product')->find($id);
        if ($product) {
            $em->remove($product);
            $em->flush();
        } else {
            throw $this->createNoFoundException(
                'No product found for id ' . $id
            );
        }
        return $this->redirectToRoute('product_homepage');
    }
}

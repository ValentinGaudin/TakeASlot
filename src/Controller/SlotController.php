<?php

namespace App\Controller;

use App\Entity\Slot;
use App\Form\SlotType;
use App\Repository\SlotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/slot")
 */
class SlotController extends AbstractController
{
    /**
     * @Route("/", name="slot_index", methods={"GET"})
     */
    public function index(SlotRepository $SlotRepository): Response
    {

        return $this->render('Slot/Slot.html.twig',);
    }

    /**
     * @Route("/new", name="slot_new", methods={"GET", "POST"})
     */
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $slot = new Slot();
    //     $form = $this->createForm(SlotType::class, $slot);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($slot);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('activity_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('slot/new.html.twig', [
    //         'slot' => $slot,
    //         'form' => $form,
    //     ]);
    // }

    /**
     * @Route("/{id}", name="slot_show", methods={"GET"})
     */
    public function show(Slot $Slot): Response
    {
        return $this->render('Slot/show.html.twig', [
            'Slot' => $Slot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="slot_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Slot $Slot, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SlotType::class, $Slot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('Slot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Slot/edit.html.twig', [
            'Slot' => $Slot,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="Slot_delete", methods={"POST"})
     */
    public function delete(Request $request, Slot $Slot, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $Slot->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Slot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Slot_index', [], Response::HTTP_SEE_OTHER);
    }
}

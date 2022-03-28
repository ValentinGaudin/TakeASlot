<?php

namespace App\Controller;

use App\Entity\Slot;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
    }
    /**
     * @Route("/profil", name="app_profil", methods={"GET"})
     */
    public function showProfil()
    {
        $user = $this->getUser();

        $slot = $user->getAppointments();

        $event = [];
        try {
            $event[] = [
                'id' => $slot->getId(),
                'start' => $slot->getStart()->format('Y-m-d H:i'),
                'end' => $slot->getEnd()->format('Y-m-d H:i'),
                'title' => $slot->getTitle(),
                'description' => $slot->getDescription(),
                'backgroundColor' => $slot->getBackgroundColor(),
                'borderColor' => $slot->getBorderColor(),
                'textColor' => $slot->getTextColor(),
            ];
        } catch (\Throwable $th) {
            //throw $th;
        }
        $data = json_encode($event);

        return $this->render('login/profil.html.twig', [
            'data' => $data
        ]);
    }

    /**
     * @Route("/getappointment/{id}", name="get_app", methods={"GET","POST"})
     */
    public function addAppointment(Slot $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->isInAppointment($appointment)) {
            $this->getUser()->removeAppointment($appointment);
        } else {
            $this->getUser()->addAppointment($appointment);
        }
        $entityManager->flush();

        return $this->json([
            'isInAppointment' => $this->getUser()->isInAppointment($appointment)
        ]);
    }

}

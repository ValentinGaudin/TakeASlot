<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        $calendars = $user->getUserRDV();
        $event = [];
        try {
            $event[] = [
                'id' => $calendars->getId(),
                'start' => $calendars->getStart()->format('Y-m-d H:i'),
                'end' => $calendars->getEnd()->format('Y-m-d H:i'),
                'title' => $calendars->getTitle(),
                'description' => $calendars->getDescription(),
                'backgroundColor' => $calendars->getBackgroundColor(),
                'borderColor' => $calendars->getBorderColor(),
                'textColor' => $calendars->getTextColor(),
            ];
        } catch (\Throwable $th) {
            //throw $th;
        }
        $data = json_encode($event);

        return $this->render('login/profil.html.twig', [
            'data' => $data
        ]);
    }
}

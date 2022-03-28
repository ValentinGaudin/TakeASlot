<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Coach;
use App\Entity\Slot;
use App\Form\ActivityType;
use App\Form\SlotType;
use App\Repository\ActivityRepository;
use App\Repository\SlotRepository;
use App\Service\ControlUpload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/activity")
 */
class ActivityController extends AbstractController
{
    /**
     * @Route("/", name="activity_index", methods={"GET"})
     */
    public function index(ActivityRepository $activityRepository): Response
    {
        return $this->render('activity/index.html.twig', [
            'activities' => $activityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="activity_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ControlUpload $controlUpload): Response
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $activity->setOwner($this->getUser());
            $activity->setUpdateAt(new \DateTime('now'));
            if ($activity->getCreatedAt() === null) {
                $activity->setCreatedAt(new \DateTime('now'));
            }
            if (null !== $activity->getPosterFile()) {
                $extension = $controlUpload->extensionValidity($activity);
            }
            $authorizedTypes = ['image', 'video', 'pdf'];
            if (in_array($extension, $authorizedTypes) || $extension === "") {
                $activity->setType($extension);
                $entityManager->persist($activity);

                $entityManager->flush();
                return $this->redirectToRoute('activity_index', [], Response::HTTP_SEE_OTHER);
            } else {
                if ($extension) {
                    $form->addError(new FormError($extension));
                }
            }
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="activity_show", methods={"GET", "POST"})
     */
    public function show(Activity $activity, EntityManagerInterface $entityManager, Request $request): Response
    {
        $slots = $activity->getSlots();
        $user = $this->getUser();

        $events = [];
        foreach ($slots as $slot) {
            try {
                $events[] = [
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
        }

        $slot = new Slot();
        $form = $this->createForm(SlotType::class, $slot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slot->setActivity($activity);
            $entityManager->persist($slot);
            $entityManager->flush();
            return $this->redirectToRoute('activity_show', ['id' => $activity->getId()], Response::HTTP_SEE_OTHER);
        }

        // $data = json_encode($event);

        $coaches = $activity->getCoaches();

        $appointments = $this->getUser()->getAppointments();

        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
            'coaches' => $coaches,
            'events' => $events,
            'user' => $user,
            'appointment' => $appointments,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activity_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Activity $activity, EntityManagerInterface $entityManager): Response
    {
        // Check wether the logged in user is the owner of the program
        if (!($this->getUser() == $activity->getOwner())) {
            // If not the owner, throws a 403 Access Denied exception
            throw new AccessDeniedException('Only the owner can edit the program!');
        }
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="activity_delete", methods={"POST"})
     */
    public function delete(Request $request, Activity $activity, EntityManagerInterface $entityManager): Response
    {
        // Check wether the logged in user is the owner of the program
        if (!($this->getUser() == $activity->getOwner())) {
            // If not the owner, throws a 403 Access Denied exception
            throw new AccessDeniedException('Only the owner can edit the program!');
        }
        if ($this->isCsrfTokenValid('delete' . $activity->getId(), $request->request->get('_token'))) {
            $entityManager->remove($activity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activity_index', [], Response::HTTP_SEE_OTHER);
    }
}

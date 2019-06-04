<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\User;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddAnnouncementController extends Controller
{


    /**
     * New action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\AddAnnouncementRepository $repository Announcement repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "announcement/add",
     *     methods={"GET", "POST"},
     *     name="announcement_new",
     * )
     */
    public function new(Request $request, AnnouncementRepository $repository): Response
    {
        $announcement = new Announcement();
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $announcement->setCreatedAt(new \DateTime());
            $currentUser = $this->getDoctrine()->getRepository(User::class)->find(1);
            $announcement->setUser($currentUser); // todo: Zmienić po stworzeniu zalogowania
            $announcement->setAccepted(false);
//            //$announcement->setCategoryId(1);

            $repository->save($announcement);

            $this->addFlash('success', 'Ogłoszenie dodano prawidłowo');
            return $this->redirectToRoute('all_announcement');
        }

        return $this->render(
            'add_announcement/index.html.twig',
            ['form' => $form->createView()]
        );
    }

}

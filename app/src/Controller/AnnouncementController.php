<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\User;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncementController extends Controller
{


    /**
     * New action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\AnnouncementRepository $repository Announcement repository
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
            $announcement->setUser($this->getUser());
            $announcement->setAccepted(false);

            $repository->save($announcement);

            $this->addFlash('success', 'Ogłoszenie dodano prawidłowo');
            return $this->redirectToRoute('all_announcement');
        }

        return $this->render(
            'add_announcement/index.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Announcement                         $announcement      Announceemnt entity
     * @param \App\Repository\AnnouncementRepository            $repository Announcement repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "home/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="announcement_edit",
     * )
     */
    public function edit(Request $request, Announcement $announcement, AnnouncementRepository $repository): Response
    {

        $form = $this->createForm(AnnouncementType::class, $announcement, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($announcement);

            $this->addFlash('success', 'Ogłoszenie zostało ');

            return $this->redirectToRoute('all_announcement');
        }

        return $this->render(
            'home/edit.html.twig',
            [
                'form' => $form->createView(),
                'announcement' => $announcement,
                'page_title' => 'Edycja ogłoszenia',

            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Announcement                          $announcement       Announcement entity
     * @param \App\Repository\AnnouncementRepository            $repository Announcement repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "home/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="announcement_delete",
     * )
     */
    public function delete(Request $request, Announcement $announcement, AnnouncementRepository $repository): Response
    {
        $form = $this->createForm(AnnouncementType::class, $announcement, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($announcement);
            $this->addFlash('success', 'Ogłoszenie zostało usunięte');

            return $this->redirectToRoute('all_announcement');
        }

        return $this->render(
            'home/user_delete.html.twig',
            [
                'form' => $form->createView(),
                'announcement' => $announcement,
                'page_title' => 'Potwierdź skasowanie ogłoszenia',

            ]
        );
    }
    /**
     * * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\AnnouncementRepository      $announcementRepository Repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator  Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route("/home/user/announcements", name="user_announcements")
     */

    public function userAnnouncements(Request $request, AnnouncementRepository $announcementRepository, PaginatorInterface $paginator): Response

    {
        $pagination = $paginator->paginate(
            $announcementRepository->findByUserId($this->getUser()->getId()),
            $request->query->getInt('page', 1),
            Announcement::NUMBER_OF_ITEMS
        );

        return $this->render(
            'home/all.html.twig',
            ['pagination' => $pagination]

        );
    }
    /**
     * Accept action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Announcement                          $announcement       Announcement entity
     * @param \App\Repository\AnnouncementRepository            $repository Announcement repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "home/{id}/accept",
     *     methods={"GET"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="accept_announcement",
     * )
     */
    public function accept(Request $request, Announcement $announcement, AnnouncementRepository $repository): Response
    {

            $announcement->setAccepted(1);
            $repository->save($announcement);

            $this->addFlash('success', 'Ogłoszenie zostało zaakceptowane');

            return $this->redirectToRoute('all_announcement');

    }

}

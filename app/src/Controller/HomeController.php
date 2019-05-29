<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\AnnouncementType;
use App\Form\CommentType;
use App\Repository\AnnouncementRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="home")
     */
    public function index(AnnouncementRepository $announcementRepository)
    {


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',


        ]);
    }

    /**
     * @Route("/home/all", name="all_announcement")
     */

    public function allAnnouncements(AnnouncementRepository $announcementRepository)
    {

        return $this->render('home/all.html.twig', [
            'controller_name' => 'AllAnnouncement',
            'announcements' => $announcementRepository->findAll()
        ]);
    }

    /**
     *
     * View action.
     * @Route(
     *  "/home/{id}",
     *   name="one_announcement",
     *  requirements={"id": "[1-9]\d*"},
     * )
     */
    public function oneAnnouncement(Request $request, AnnouncementRepository $announcementRepository, int $id)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment, ['id'=>$id]);
        $form->handleRequest($request);

        /** @var Announcement $item */
        $item = $announcementRepository->findById($id);
//        var_dump(count($item[0]->getComments()));
//        die;
        if (count($item)) {
            return $this->render(
                'home/one.html.twig',
                [
                    'item' => $item[0],
                    'form' => $form->createView()
                ]
            );
        }
        return $this->render(
            'home/one.html.twig',
            ['item' => []]
        );
    }

    /**
     *
     *
     *
     *
     *
     * @Route(
     *     "comment/add",
     *     methods={"GET", "POST"},
     *     name="comment_new",
     * )
     */
    public function newComment(Request $request, CommentRepository $repository): Response
    {
        $currentAnnouncementId =(int)$_POST['comment'] ['announcement'];
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new\DateTime());
            $currentAnnouncement = $this->getDoctrine()->getRepository(Announcement::class)->find($currentAnnouncementId);
            $comment->setAnnouncement($currentAnnouncement);

//            $currentUser = $this->getDoctrine()->getRepository(User::class)->find(1);
            $comment->setUserId(1); // todo: Zmienić po stworzeniu zalogowania
            $repository->save($comment);

            $this->addFlash('success', 'Komentarz dodano prawidłowo');
            return $this->redirectToRoute('one_announcement',['id'=> $currentAnnouncementId]);
        }

        return $this->render(
            'home/add_comment.html.twig',
            ['form' => $form->createView()]
        );
    }

}

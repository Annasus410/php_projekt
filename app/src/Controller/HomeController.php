<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\AnnouncementType;
use App\Form\CommentType;
use App\Repository\AnnouncementRepository;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
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
     * * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\AnnouncementRepository      $announcementRepository Repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator  Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route("/home/all", name="all_announcement")
     */

    public function allAnnouncements(Request $request, AnnouncementRepository $announcementRepository, PaginatorInterface $paginator): Response

    {
        if(!empty($this->getUser()) && in_array("ROLE_ADMIN", $this->getUser()->getRoles())){

            $pagination = $paginator->paginate(
                $announcementRepository->queryAll(),
                $request->query->getInt('page', 1),
                Announcement::NUMBER_OF_ITEMS
            );
        } else{
            $pagination = $paginator->paginate(
                $announcementRepository->findAccepted(),
                $request->query->getInt('page', 1),
                Announcement::NUMBER_OF_ITEMS
            );

        }

        return $this->render(
            'home/all.html.twig',
            ['pagination' => $pagination]

        );
    }

    /**
     *
     * OneAmmouncement action.
     *
     *
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
                    'form' => $form->createView(),
                    'comments' => $item[0]->getComments(),
                    'user' => $this->getUser()
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
            $comment->setUser($this->getUser());
            $currentAnnouncement = $this->getDoctrine()->getRepository(Announcement::class)->find($currentAnnouncementId);
            $comment->setAnnouncement($currentAnnouncement);

            $comment->setUser($this->getUser());
            $repository->save($comment);

            $this->addFlash('success', 'Komentarz dodano prawidłowo');
            return $this->redirectToRoute('one_announcement',['id'=> $currentAnnouncementId]);
        }

        return $this->render(
            'home/add_comment.html.twig',
            ['form' => $form->createView()]
        );
    }
    /**
     * * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\CommentRepository     $commentRepository Repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator  Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route("/home/user/comments", name="user_comments")
     */

    public function userAnnouncements(Request $request, CommentRepository $commentRepository, PaginatorInterface $paginator): Response

    {
        $pagination = $paginator->paginate(
            $commentRepository->findByUserId($this->getUser()->getId()),
            $request->query->getInt('page', 1),
            Comment::NUMBER_OF_ITEMS
        );

        return $this->render(
            'home/one.html.twig',
            ['pagination' => $pagination]

        );
    }

}

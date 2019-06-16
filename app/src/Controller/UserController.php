<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\AnnouncementType;
use App\Form\CommentType;
use App\Form\RegistrationType;
use App\Repository\AnnouncementRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{


    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     *
     * @return Response
     *
     * * @Route("/user/all", name="all_users")
     *
     */

    public function allUsers(Request $request, UserRepository $userRepository, PaginatorInterface $paginator)
    {
        $pagination = $paginator->paginate(
            $userRepository->findAll(),
            $request->query->getInt('page', 1),
            User::NUMBER_OF_ITEMS
        );

        return $this->render(
            'user/all_users.html.twig',
            ['pagination' => $pagination]
        );
    }


    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param int $id
     * @return Response
     *
     * @Route(
     *  "/user",
     *   name="one_user",
     *  requirements={"id": "[1-9]\d*"},
     * )
     *
     */
    public function oneUser(Request $request, UserRepository $userRepository)
    {




            return $this->render(
                'user/one_user.html.twig',
                [
                    'user' => $this->getUser()
                ]

            );
        }

        /**
         * Delete action.
         *
         * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
         * @param \App\Entity\User                         $user User entity
         * @param \App\Repository\UserRepository            $repository User repository
         *
         * @return \Symfony\Component\HttpFoundation\Response HTTP response
         *
         * @throws \Doctrine\ORM\ORMException
         * @throws \Doctrine\ORM\OptimisticLockException
         *
         * @Route(
         *     "user/{id}/delete",
         *     methods={"GET", "DELETE"},
         *     requirements={"id": "[1-9]\d*"},
         *     name="user_delete",
         * )
         */
        public function delete(Request $request, User $user, UserRepository $repository): Response
        {
        $form = $this->createForm(RegistrationType::class, $user, ['method' => 'DELETE']);
            $form->handleRequest($request);

            if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
                $form->submit($request->request->get($form->getName()));
            }

            if ($form->isSubmitted() && $form->isValid()) {
                $repository->delete($user);
                $this->addFlash('success', 'Użytkownik usunięty');

                return $this->redirectToRoute('all_users');
            }

            return $this->render(
                'user/user_delete.html.twig',
                [
                    'form' => $form->createView(),
                    'user' => $user,
                    'page_title' => 'Potwierdź skasowanie użytkownika',

                ]
            );
        }

//    /**
//     * @param Request $request
//     * @param UserRepository $userRepository
//     *
//     * @return Response
//     *
//     * * @Route("/user", name="all_users")
//     *
//     */
//
//    public function allUsers(UserRepository $userRepository): Response
//
//    {
//
//
//        return $this->render(
//            'user/all_users.html.twig',
//            [
//                'controller_name' => 'UserController',
//                'users' => $userRepository->findAll()]
//        );
//    }


}
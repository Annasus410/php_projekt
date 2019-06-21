<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserData;
use App\Form\UserType;
use App\Form\UserDataType;
use App\Form\RegistrationType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use App\Repository\UserRepository;
use App\Repository\UserDataRepository;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\CommentRepository;
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

            [
                'pagination' => $pagination,


            ]

        );
    }


    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param int $id
     * @return Response
     *
     * @Route(
     *  "/user/{id}",
     *   name="one_user",
     *  requirements={"id": "[1-9]\d*"},
     * )
     *
     */
    public function oneUser(User $user)
    {


        return $this->render(
            'user/one_user.html.twig',
            [
                'user' => $user
            ]

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
     *   name="account_user",
     *  requirements={"id": "[1-9]\d*"},
     * )
     *
     */
    public function accountUser()
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
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param UserData $userdata
     * @param \App\Repository\UserRepository $repository User repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route(
     *     "user/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_delete",
     * )
     */
    public function delete(Request $request, UserData $userdata, UserRepository $repository): Response
    {

        $form = $this->createForm(UserType::class, $userdata, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($userdata);
            $this->addFlash('success', 'Użytkownik usunięty');

            return $this->redirectToRoute('account');
        }

        return $this->render(
            'user/user_delete.html.twig',
            [
                'form' => $form->createView(),
                'userdata' => $userdata,
                'page_title' => 'Potwierdź skasowanie użytkownika',

            ]
        );
    }

    /**
     * @param Request $request
     * @param \App\Controller\User $user
     * @param \App\Repository\UserRepository $repository
     * @return Response
     *
     *
     *
     *
     *
     * @Route(
     *     "user/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="edit_user",
     * )
     *
     */
    public function edit(Request $request, User $user, UserRepository $repository): Response
    {

        $form = $this->createForm(UserType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($user);

            $this->addFlash('success', 'Dane zostały zedytowane');

            return $this->redirectToRoute('account_user');
        }

        return $this->render(
            'user/edit.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
                'page_title' => 'Edycja loginu',

            ]
        );
    }


    /**
     * @param Request $request
     * @param UserData $userdata
     * @param UserDataRepository $repository
     * @return Response
     *
     *
     * @Route(
     *     "user/{id}/editdata",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="edit_user_data",
     * )
     *
     */
    public function editdata(Request $request, UserData $userdata, UserDataRepository $repository, User $user): Response
    {

        $form = $this->createForm(UserDataType::class, $userdata, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($userdata);

            $this->addFlash('success', 'Dane zostały zedytowane');

            return $this->redirectToRoute('account_user');
        }


        return $this->render(
            'user/edit_user_data.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
                'page_title' => 'Edycja danych',

            ]
        );

    }
}
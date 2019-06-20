<?php

namespace App\Controller;

use App\Entity\UserData;
use App\Form\UserDataType;
use App\Repository\UserRepository;
use App\Repository\UserDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserDataController extends Controller
{

//    /**
//     * @param Request            $request
//     * @param UserData           $userdata
//     * @param UserDataRepository $repository
//     *
//     * @return Response
//     *
//     * * @Route(
//     *     "user/{id}/editdata",
//     *     methods={"GET", "PUT"},
//     *     requirements={"id": "[1-9]\d*"},
//     *     name="edit_user_data",
//     * )
//     */
//    public function edit(Request $request, UserData $userdata, UserDataRepository $repository): Response
//    {
//
//        $form = $this->createForm(UserDataType::class, $userdata, ['method' => 'PUT']);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $repository->save($userdata);
//
//            $this->addFlash('success', 'Dane zostały zedytowane');
//
//            return $this->redirectToRoute('account_user');
//        }
//
//        return $this->render(
//            'user/edit_user_data.html.twig',
//            [
//            'form' => $form->createView(),
//            'userdata' => $userdata,
//            'page_title' => 'Edycja danych',
//
//            ]
//        );
//    }
}

<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Form\OpinionType;
use App\Repository\AnnouncementRepository;
use App\Repository\OpinionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OpinionController extends Controller

{


    /**
     * @param Request $request
     * @param OpinionRepository $opinionRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * * @Route("/home/opinion/index", name="all_opinion")
     */
    public function allOpinions(Request $request, OpinionRepository $opinionRepository, PaginatorInterface $paginator): Response

    {
        $pagination = $paginator->paginate(
            $opinionRepository->findAll(),
            $request->query->getInt('page', 1),
            Opinion::NUMBER_OF_ITEMS
        );

        return $this->render(
            'opinion/index.html.twig',
            ['pagination' => $pagination ]

        );
    }

    /**
     * @param Request $request
     * @param OpinionRepository $repository
     * @return Response
     *
     * @Route(
     *     "opinion/add",
     *     methods={"GET", "POST"},
     *     name="opinion_new",
     * )
     */

    public function newOpinion(Request $request, OpinionRepository $repository): Response
    {


        $opinion = new Opinion();
        $form = $this->createForm(OpinionType::class, $opinion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $opinion->setCreatedAt(new \DateTime());
            $opinion->setAuthor($this->getUser());


            $repository->save($opinion);

            $this->addFlash('success', 'Opinie dodano prawidłowo');
            return $this->redirectToRoute('all_opinion');
        }

        return $this->render(
            'opinion/add.html.twig',
            ['form' => $form->createView()]
        );

    }


    /**
     * Delete action.
     *
     * @param Request $request
     * @param Opinion $opinion
     * @param OpinionRepository $repository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     *  @Route(
     *     "opinion/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="opinion_delete",
     *     )
     *
     */
    public function delete(Request $request, Opinion $opinion, OpinionRepository $repository): Response
    {
        $form = $this->createForm(OpinionType::class, $opinion, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($opinion);
            $this->addFlash('success', 'Opinia usunięta');

            return $this->redirectToRoute('all_opinion');
        }

        return $this->render(
            'opinion/user_delete.html.twig',
            [
                'form' => $form->createView(),
                'opinion' => $opinion,
                'page_title' => 'Potwierdź skasowanie ogłoszenia',

            ]
        );
    }





}

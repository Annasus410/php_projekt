<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function oneAnnouncement(AnnouncementRepository $announcementRepository, int $id)
    {
//        var_dump($announcementRepository->findById($id));
//
//        die();

        $item=$announcementRepository->findById($id);
        if(count($item))
        {
            return $this->render(
                'home/one.html.twig',
                ['item' => $item[0]]
            );
        }
        return $this->render(
            'home/one.html.twig',
            ['item' => []]
        );
    }

}

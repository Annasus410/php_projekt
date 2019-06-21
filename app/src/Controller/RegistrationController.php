<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\UserData;
use App\Form\ChangePasswordType;
use App\Form\Model\ChangePassword;
use App\Form\RegistrationType;
use App\Form\UserDataType;
use App\Repository\UserDataRepository;
use App\Repository\UserRepository;
use Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistrationController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     *
     * @Route("/register", name="user_register")
     *
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('all_announcement');
        };
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new \DateTime());
            $user->setUpdatedAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();


            $entityManager->persist($user);
            $entityManager->flush();

//            return $this->render(
//                'registration/register_finish.html.twig',
//                [
//                    'user' => $this->getUser()
//                ]
//
//            );

            return $this->redirectToRoute('user_finish_register',['id'=>$user->getId()]);


        }
        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Register UserData action.
     *
     * @param Request $request
     * @param UserDataRepository $repository
     * @return Response
     * @throws \Exception
     *
     *  * @Route("/register/finish/{id}", name="user_finish_register")
     */

    public function registerUserData(Request $request, UserRepository $userRepository): Response
    {


        $userdata=new UserData();
        $form = $this->createForm(UserDataType::class, $userdata);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($userRepository->findByUserId($request->get('id'))->setUserData($userdata));



            $this->addFlash('success', 'Użytkownik został zarejestowany');
            return $this->redirectToRoute('all_announcement');
        }

        return $this->render(
            'registration/register_finish.html.twig',
            ['form' => $form->createView(), 'id'=>$request->get('id')]
        );
    }

    /**

     * @param Request $request
     * @param User $user
     * @param UserRepository $repository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * * @Route(
     *      "/change_password/",
     *      name="user_password",
     *      methods={"GET", "POST"},
     * )
     */
    public function changePassword(Request $request, UserRepository $repository, UserPasswordEncoderInterface $passwordEncoder )
    {
        $user = $this->getUser();
        $changePassword = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $changePassword, [ 'method' => 'POST' ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $changePassword->getPassword());
            $user->setPassword($password);
            $repository->save($user);
            $this->addFlash('success', 'Hasło zostało zmienione');
            return $this->redirectToRoute('all_announcement');
        }
        return $this->render(
            'registration/change.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
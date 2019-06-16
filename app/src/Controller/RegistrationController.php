<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\RegistrationType;
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
            return $this->redirectToRoute('article_index');
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

            $this->addFlash('success', 'Użytkownik został zarejestowany');
            return $this->redirectToRoute('security_login');
        }
        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
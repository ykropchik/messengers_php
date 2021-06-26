<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Entity\Message;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_messages');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/messages", name="app_messages")
     */
    public function messages()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->getAllExcept($this->getUser()->getId());
        return $this->render('messages.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/messages/getMessages", methods={"POST"})
     */
    public function getMessages(Request $request): Response
    {
        $login = $request->request->get('userLogin');

//        $messages = $this->getDoctrine()
//            ->getRepository(Message::class)
//            ->findBy(array('author' => $this->getUser()->getId(), 'addresse' => $id));

        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findByTwoUsers($this->getUser()->getLogin(), $login);

        $messagesArray = [];
        foreach ($messages as $message) {
            array_push($messagesArray, [
                'author' => $message->getAuthor(),
                'addresse' => $message->getAddresse(),
                'date_create' => $message->getDateCreate(),
                'text' => $message->getText()]);
        }

        $response = new JsonResponse($messagesArray);
        return $response->send();
    }

    /**
     * @Route("/messages/sendMessage", methods={"POST"})
     */
    public function saveMessage(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $message = new Message();
        $message->setAuthor($this->getUser()->getLogin())
                ->setAddresse($request->request->get('addresse'))
                ->setDateCreate(new \DateTime())
                ->setText($request->request->get('text'));
        $entityManager->persist($message);
        $entityManager->flush();

        $response = new JsonResponse([
            'author' => $message->getAuthor(),
            'addresse' => $message->getAddresse(),
            'date_create' => $message->getDateCreate(),
            'text' => $message->getText()]);
        //$response = new JsonResponse(array("datetime" => ));
        return $response->send();
    }
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use AppBundle\Entity\User;

class CommentController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function homeAction(Request $request)
    {
        return $this->redirectToRoute('comment_list');
    }

    /**
     * @Route("/comment", name="comment_list")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Comment:index.html.twig');
    }

    /**
     * @Route("/comment/{login}", name="comment_add")
     */
    public function editAction(Request $request, $login)
    {
        $em  = $this->get('doctrine.orm.entity_manager');
        $git = $this->get('github.client');

        try {
            $user = $this->get('github.client')->api('user')->show($login);
        } catch (\Github\Exception\RuntimeException $e) {
            $request->getSession()->getFlashBag()->add('error', "No user found for login $login");

            return $this->redirectToRoute('comment_list');
        }

        $comment = (new Comment())->setLogin($login);

        $form = $this->get('form.factory')->create(CommentType::class, $comment, [
            'login' => $login,
        ]);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $comment = $form->getData();
            try {
                $repo = $git->api('repo')->show($login, $comment->getRepo());
            } catch (\Github\Exception\RuntimeException $e) {
                $request->getSession()->getFlashBag()->add('error', 'No repo "' . $comment->getRepo() . '" found for user ' . $login);

                return $this->redirectToRoute('comment_list');
            }

            $em->persist($form->getData());
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Comment has been saved.');

            return $this->redirectToRoute('comment_list');
        }

        return $this->render('AppBundle:Comment:add.html.twig', [
            'form'     => $form->createView(),
            'user'     => $user,
            'comments' => $em->getRepository('AppBundle:Comment')->findByLogin($login),
        ]);
    }

    /**
     * @Route("/search/{login}", name="comment_search", defaults={"login" = null})
     */
    public function searchAction(Request $request, $login = null)
    {
        $error = false;
        $git = $this->get('github.client');

        try {
            $users = $login ? $git->api('user')->find($login) : $git->api('user')->all();
        } catch (\Github\Exception\RuntimeException $e) {
            $error = true;
            $users = [];
        }

        if (isset($users['users'])) {
            $users = $users['users'];
        }

        return $this->render('AppBundle:Comment:search.html.twig', [
            'users' => $users,
            'error' => $error,
        ]);
    }
}

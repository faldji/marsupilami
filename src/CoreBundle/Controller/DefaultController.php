<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\User;
use CoreBundle\Form\CarnetType;
use CoreBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute("marsupilami_core_after_login");
        }else{
            return $this->redirectToRoute("fos_user_security_login");
        }
    }

    public function profileAction(Request $request)
    {
        return $this->render("CoreBundle:profile:index.html.twig");
    }

    public function editAction(Request $request)
    {
        $utilisateur = $this->getUser();

        $form = $this->createForm(UserType::class, $utilisateur);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $this->getDoctrine()->getManager()->flush();
                $request->getSession()->getFlashBag()->add('notice_success', 'Vos informations ont bien été mises à jour');
                return $this->redirectToRoute("marsupilami_core_after_login");
            }
            else
            {
                $request->getSession()->getFlashBag()->add('notice_error', 'Le formulaire est mal rempli');
            }
        }

        return $this->render('CoreBundle:profile:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function carnetAdresseAction(Request $request)
    {
        $utilisateur = $this->getUser();

        $form = $this->createForm(CarnetType::class, $utilisateur);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $utilisateur->addMyFriend($utilisateur->getTmpFriend());
                $utilisateur->addFriendsWithMe($utilisateur->getTmpFriend());

                $this->getDoctrine()->getManager()->flush();
                $request->getSession()->getFlashBag()->add('notice_success', 'Le nouveau contact a bien été ajouté');
            }
            else
            {
                $request->getSession()->getFlashBag()->add('notice_error', 'Le formulaire est mal rempli');
            }
        }


        return $this->render('CoreBundle:profile:carnet.html.twig', array('form' => $form->createView()));
    }

    public function carnetAdresseSupprimerAction(Request $request, User $user)
    {
        $this->getUser()->removeFriendsWithMe($user);
        $this->getUser()->removeMyFriend($user);

        $this->getDoctrine()->getManager()->flush();

        $request->getSession()->getFlashBag()->add('notice_success', 'Le contact a bien été supprimé du carnet d\'adresse');

        return $this->redirectToRoute('marsupilami_core_add_friend');
    }
}

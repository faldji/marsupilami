<?php

namespace CoreBundle\Controller;

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
}

<?php

namespace Zeega\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Zeega\DataBundle\Entity\User;
use Zeega\DataBundle\Entity\Project;
use Zeega\DataBundle\Entity\Site;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        return $this->render('ZeegaUserBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'header' => $request->query->get('header')
        ));
        
        
    }
	
	public function successAction()
    {
			$user = $this->get('security.context')->getToken()->getUser();
			if(is_object($user)){
				$displayName = $user->getDisplayName();
				$userId = $user->getId();
			}
			else{
				$displayName='none';
				$userId=0;	
			}

    	 	return $this->render('ZeegaUserBundle:Security:confirmed.html.twig', array(
    	 		'displayname'=>$displayName,
    	 		'id'=>$userId,
    	 
    	 ));
    }

}
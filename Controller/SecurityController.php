<?php
namespace Dreimweb\UserBundle\Controller;
use Dreimweb\UserBundle\Entity\Email;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Dreimweb\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
class SecurityController extends Controller
{
    /**
     * @Route("/auth/login", name="_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        // get the login error if there is one
        $error = $session->get(Security::AUTHENTICATION_ERROR);
        $session->remove(Security::AUTHENTICATION_ERROR);
        return array(
            // last username entered by the user
            'last_username' => $session->get(Security::LAST_USERNAME),
            'error' => $error,
        );
    }
    /**
     * @Route("/auth/login_check", name="login_check")
     * @Template()
     */
    public function loginCheckAction()
    {
        return array(// ...
        );
    }
    /**
     * @Route("/auth/logout", name="_logout")
     */
    public function logoutAction(Request $request)
    {
        $this->container->get('security.context')->setToken(null);
        $uri = $this->get('router')->generate('homepage');
        return $this->redirect($uri);
    }
    /**
     * @Route("/auth/activation/{ident_key}", name="_user_activation")
     */
    public function activationAction(Request $request, $ident_key)
    {
        // load session manager
        $session = $this->get('session');
        // load doctrine manager
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('DreimwebUserBundle:User');
        /** @var User $user */
        $user = $userRepo->findOneBy(['ident_key' => $ident_key]);
        if ($user) {
            $user->setFlagstate(true);
            $user->setIsActive(true);
            $em->persist($user);
            $em->flush();
            $session->getFlashBag()->add('notice', 'Ihr Benutzerkonto wurde erfolgreich aktiviert');
        } else {
            $session->getFlashBag()->add('error', 'Kein Benutzer mit diesen Daten gefunden');
        }
        $uri = $this->get('router')->generate('_login');
        return $this->redirect($uri);
    }
}
<?php

namespace Touki\ChatBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Chat controller
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class ChatController extends Controller
{
    /**
     * Index
     *
     * @Route("/{nickname}")
     * @Method({"GET"})
     * @Template
     */
    public function indexAction($nickname)
    {
        return [
            'nickname' => $nickname
        ];
    }
}

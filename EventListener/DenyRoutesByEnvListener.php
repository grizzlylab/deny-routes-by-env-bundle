<?php

namespace Grizzlylab\Bundle\DenyRoutesByEnvBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class DenyRoutesByEnvListener
 * @package Grizzlylab\Bundle\DenyRoutesByEnvBundle\EventListener
 * @author  Jean-Louis Pirson <jl.pirson@grizzlylab.be>
 */
class DenyRoutesByEnvListener
{
    private $router;
    private $translator;
    private $environment;
    private $config;

    /**
     * DisabledRoutesByEnvironmentListener constructor.
     *
     * @param RouterInterface     $router
     * @param TranslatorInterface $translator
     * @param string              $environment
     * @param array               $config
     */
    public function __construct(
        RouterInterface $router,
        TranslatorInterface $translator,
        string $environment,
        $config
    ) {
        $this->router = $router;
        $this->translator = $translator;
        $this->environment = $environment;
        $this->config = $config;
    }

    /**
     * onKernelRequest
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (is_array($this->config)) {
            $request = $event->getRequest();
            $routeName = $request->get('_route');

            /** @var \Symfony\Component\HttpFoundation\Session\Session $session */
            $session = $request->getSession();

            if (in_array($routeName, $this->config['denied_routes'])) {
                // Forbid access
                $session->getFlashBag()->add($this->config['message_type'], $this->translator->trans('route_is_denied', ['%uri%' => $request->getRequestUri(), '%environment%' => $this->environment], 'grizzlylab_deny_routes_by_env'));
                $event->setResponse(new RedirectResponse($this->router->generate($this->config['redirection_route']['name'], $this->config['redirection_route']['parameters'])));
            }
        }
    }
}

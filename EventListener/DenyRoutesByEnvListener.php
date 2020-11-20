<?php

namespace Grizzlylab\Bundle\DenyRoutesByEnvBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author  Jean-Louis Pirson <jl.pirson@grizzlylab.be>
 */
class DenyRoutesByEnvListener
{
    private RouterInterface $router;
    private TranslatorInterface $translator;
    private string $environment;
    private array $config;

    public function __construct(
        RouterInterface $router,
        TranslatorInterface $translator,
        string $environment,
        array $config
    ) {
        $this->router = $router;
        $this->translator = $translator;
        $this->environment = $environment;
        $this->config = $config;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (is_array($this->config)) {
            $request = $event->getRequest();
            $routeName = $request->get('_route');

            /** @var \Symfony\Component\HttpFoundation\Session\Session $session */
            $session = $request->getSession();

            if (in_array($routeName, $this->config['denied_routes'])) {
                // Deny access
                $session->getFlashBag()->add(
                    $this->config['message_type'],
                    $this->translator->trans(
                        'route_is_denied',
                        [
                            '%uri%' => $request->getRequestUri(),
                            '%environment%' => $this->environment
                        ],
                        'grizzlylab_deny_routes_by_env'
                    )
                )
                ;
                $event->setResponse(
                    new RedirectResponse(
                        $this->router->generate(
                            $this->config['redirection_route']['name'],
                            $this->config['redirection_route']['parameters']
                        )
                    )
                );
            }
        }
    }
}

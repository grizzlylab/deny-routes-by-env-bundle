DenyRoutesByEnvBundle
======================

This bundle for Symfony allows you to deny some routes for a specific environment.
When a route is denied, it will create a flash message and redirect the user to the "redirection route".

Example: You don't want your users to be able to access the route "acme_xyz" when the environment is "dev" or "demo".

###1. Installation

- ```composer require 'grizzlylab/deny-routes-by-env-bundle@dev-master'```
- in AppKernel.php: ```new Grizzlylab\Bundle\DenyRoutesByEnvBundle\GrizzlylabDenyRoutesByEnvBundle()```

###2. Configuration

a) Configure your main configuration file (app/config/config.yml):
```
#app/config/config.yml
grizzlylab_deny_routes_by_env:
    message_type:         grizzlylab_deny_routes_by_env.danger
    denied_routes:        [] # Required
    redirection_route:    # Required
        name:                 ~
        parameters:           []
```

b) Then configure each config file related to the concerned environments (e.g. app/config/config_dev.yml)
```
#app/config/config_dev.yml
grizzlylab_deny_routes_by_env:
    # deny these routes for the environment "dev"
    denied_routes:        ['first_route', 'second_route'] # Required
```

License
-------
This bundle is under the MIT license.

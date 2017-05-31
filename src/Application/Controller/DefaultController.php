<?php

namespace DeliveryArretado\Controller;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 
 * Description of DefaultController
 * 
 * @package Application
 * @author Anderson Emanuel <contato@andersonemanuel.com.br>
 * @copyright (c) 2017, Anderson Emanuel
 * @version 1.0
 */
class DefaultController implements ControllerProviderInterface {

    /**
     * 
     * @param Application $app
     * @return ControllerCollection $controllers
     */
    public function connect(Application $app): ControllerCollection {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'DeliveryArretado\Controller\DefaultController::indexAction')->bind('default.index');

        return $controllers;
    }

    /**
     * 
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function indexAction(Application $app, Request $request) {
        //$controller = sprintf('Application\Controller\%sController', $controller);
        //call_user_func(array(new $controller($app, $request), $action), $params);
        return filter_input(INPUT_SERVER, 'TMP');
    }

}

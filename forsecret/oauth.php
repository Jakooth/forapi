<?php
/**
 * Include required sources from composer.
 */
require __DIR__ . '/../vendor/autoload.php';

/**
 * Create simple router to check the request url.
 */
$router = new \Bramus\Router\Router();

/**
 * This to validate secure requests and set user permissions.
 */
$router->before('GET|POST', '(log.*|save.*|imgs.*|google.*)', 
        function  ()
        {
            global $events;
            global $user;
            
            /**
             * Validate Apache authorization hader with token.
             */
            
            $requestHeaders = apache_request_headers();
            $authorizationHeader = isset($requestHeaders['Authorization']) ? $requestHeaders['Authorization'] : null;
            
            if ($authorizationHeader == null) {
                header('HTTP/1.0 401 Unauthorized');
                
                /**
                 * No authorization header sent.
                 */
                
                $events['auth0']['method'] = 'secure';
                $events['auth0']['authorized'] = false;
                $events['auth0']['api'] = true;
                $events['auth0']['user'] = false;
                $events['auth0']['message'] = 'No authorization header sent.';
                
                echo json_encode(
                        array(
                                'events' => $events
                        ));
                
                exit();
            }
            
            /**
             * Validate token.
             */
            
            $token = str_replace('Bearer ', '', $authorizationHeader);
            $secret = '<--!secret-->';
            $client = '<--!client-->';
            $domain = "<--!forplay.eu.auth0.com-->";
            
            $decodedToken = null;
            $api = new \Auth0\SDK\Auth0Api($token, $domain);
            
            try {
                $decodedToken = \Auth0\SDK\Auth0JWT::decode($token, $client, 
                        $secret);
            } catch (\Auth0\SDK\Exception\CoreException $e) {
                header('HTTP/1.0 401 Unauthorized');
                
                /**
                 * Invalid token.
                 */
                
                $events['auth0']['method'] = 'secure';
                $events['auth0']['authorized'] = false;
                $events['auth0']['api'] = true;
                $events['auth0']['user'] = false;
                $events['auth0']['message'] = 'Invalid token.';
                
                echo json_encode(
                        array(
                                'events' => $events
                        ));
                
                exit();
            }
            
            try {
                $user = $api->users->get($decodedToken->sub);
            } catch (\Auth0\SDK\Exception\CoreException $e) {
                header('HTTP/1.0 401 Unauthorized');
                
                /**
                 * Invalid user.
                 */
                
                $events['auth0']['method'] = 'secure';
                $events['auth0']['authorized'] = false;
                $events['auth0']['api'] = true;
                $events['auth0']['user'] = false;
                $events['auth0']['message'] = 'Invalid user.';
                
                echo json_encode(
                        array(
                                'events' => $events
                        ));
                
                exit();
            }
            
            if ($user['app_metadata']['roles'][0] != 'admin' &&
                     $user['app_metadata']['roles'][0] != 'superadmin') {
                header('HTTP/1.0 401 Unauthorized');
                
                /**
                 * No permissions.
                 */
                
                $events['auth0']['method'] = 'secure';
                $events['auth0']['authorized'] = false;
                $events['auth0']['api'] = true;
                $events['auth0']['user'] = true;
                $events['auth0']['message'] = 'No permissions.';
                
                echo json_encode(
                        array(
                                'events' => $events
                        ));
                exit();
            }
        });

/**
 * These is the public API to get Forplay content.
 */
$router->match('POST|GET', '(get.*|search.*|forplay.*|google.*)', 
        function  ()
        {
            global $events;
            
            $events['auth0']['method'] = 'public';
            $events['auth0']['authorized'] = true;
            $events['auth0']['api'] = true;
            $events['auth0']['user'] = true;
        });

/**
 * These is the private API save Forplay content and see the log.
 */
$router->match('POST|GET', '(log.*|save.*|imgs.*|sitemap.*)', 
        function  ()
        {
            global $events;
            
            $events['auth0']['method'] = 'secure';
            $events['auth0']['authorized'] = true;
            $events['auth0']['api'] = true;
            $events['auth0']['user'] = true;
        });

/**
 * If someone tries to access unknown API.
 */
$router->set404(
        function  ()
        {
            global $events;
            
            header('HTTP/1.1 404 Not Found');
            
            $events['auth0']['method'] = false;
            $events['auth0']['authorized'] = true;
            $events['auth0']['api'] = false;
            $events['auth0']['user'] = true;
        });

/**
 * Run the router.
 */
$router->run();
?>

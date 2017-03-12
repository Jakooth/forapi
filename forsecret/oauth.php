<?php
use Auth0\SDK\JWTVerifier;
use Auth0\SDK\Auth0Api;
use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\API\Management;

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
$router->before('GET|POST', 
        '(log.*|save.*|imgs.*|google.*|profiles.*|comment.*)', 
        function ()
        {
            global $events;
            global $user;
            
            /**
             * Validate Apache authorization hader with token.
             */
            
            $requestUri = $_SERVER['REQUEST_URI'];
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
            $domain = '<--!forplay.eu.auth0.com-->';
            $domainUrl = '<--!https://forplay.eu.auth0.com/-->';
            
            $decodedToken = null;
            $auth0Api = new Management($token, $domain);
            
            $verifier = new JWTVerifier(
                    [
                            'suported_algs' => [
                                    'RS256',
                                    'HS256'
                            ],
                            'valid_audiences' => [
                                    $client
                            ],
                            'authorized_iss' => [
                                    $domainUrl
                            ],
                            'client_secret' => $secret
                    ]);
            
            try {
                $decodedToken = $verifier->verifyAndDecode($token);
            } catch (CoreException $e) {
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
                $user = $auth0Api->users->get($decodedToken->sub);
            } catch (CoreException $e) {
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
            
            /**
             * For profiles and comments APIs the user is always authorized
             * and the permissions are validated after based on admin rights.
             */
            
            if ($user['app_metadata']['roles'][0] != 'admin' &&
                     $user['app_metadata']['roles'][0] != 'superadmin' && ! (strpos(
                            $requestUri, 'profiles.php') ||
                     strpos($requestUri, 'comment.php'))) {
                
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
$router->match('POST|GET', '(tags.*|search.*|forplay.*|sitemap.*)', 
        function ()
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
$router->match('POST|GET', '(log.*|save.*|imgs.*|google.*|profile.*|comment.*)', 
        function ()
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
        function ()
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

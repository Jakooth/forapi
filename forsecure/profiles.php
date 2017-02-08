<?php
include ('../../../forsecret/db.php');

/**
 * Get user's profile by id.
 */

if (getenv('REQUEST_METHOD') == 'GET') {
    $get_profile = isset($_GET['email']) ? "'{$_GET ['email']}'" : false;
    
    if ($user['app_metadata']['roles'][0] != 'admin' &&
             $user['app_metadata']['roles'][0] != 'superadmin') {
        
        if (! $get_profile) {
            header('HTTP/1.0 401 Unauthorized');
            
            $events['auth0']['method'] = 'secure';
            $events['auth0']['authorized'] = false;
            $events['auth0']['api'] = true;
            $events['auth0']['user'] = true;
            $events['auth0']['message'] = 'You do not have parmission ot view all profiles.';
            
            echo json_encode(
                    array(
                            'events' => $events
                    ));
            exit();
        }
        
        $profile_sql = "SELECT * FROM for_profiles
                        WHERE email = $get_profile
                        ORDER BY nickname ASC;";
        
        $profile_result = mysqli_query($link, $profile_sql);
        
        if (! $profile_result) {
            header('HTTP/1.0 404 Not Found');
            
            $events['mysql']['result'] = false;
            $events['mysql']['code'] = mysqli_errno($link);
            $events['mysql']['error'] = mysqli_error($link);
            
            echo json_encode(
                    array(
                            'events' => $events
                    ));
            exit();
        }
        
        $profiles = mysqli_fetch_assoc($profile_result);
        
        if ($profiles && $user['email'] != $profiles[0]['email']) {
            header('HTTP/1.0 401 Unauthorized');
            
            $events['auth0']['method'] = 'secure';
            $events['auth0']['authorized'] = false;
            $events['auth0']['api'] = true;
            $events['auth0']['user'] = true;
            $events['auth0']['message'] = 'You do not have permission to view other profiles.';
            
            echo json_encode(
                    array(
                            'events' => $events
                    ));
            exit();
        }
    } else {
        if (! $get_profile) {
            $get_profile = "ANY (SELECT email FROM for_profiles)";
        }
        
        $profile_sql = "SELECT * FROM for_profiles
                        WHERE email = $get_profile
                        ORDER BY nickname ASC;";
        
        $profile_result = mysqli_query($link, $profile_sql);
        
        if (! $profile_result) {
            header('HTTP/1.0 404 Not Found');
            
            $events['mysql']['result'] = false;
            $events['mysql']['code'] = mysqli_errno($link);
            $events['mysql']['error'] = mysqli_error($link);
            
            echo json_encode(
                    array(
                            'events' => $events
                    ));
            exit();
        }
        
        $profiles = mysqli_fetch_assoc($profile_result);
    }
    
    $events['mysql']['result'] = true;
    
    echo json_encode(
            array(
                    'profiles' => $profiles,
                    'events' => $events
            ));
    
    mysqli_close($link);
}

/**
 * Create new user profile or update profile by id.
 * Only names and nickname is allowed for overwrite.
 */

if (getenv('REQUEST_METHOD') == 'POST') {
    $json = file_get_contents("php://input");
    $profile = json_decode($json, true);
    
    $profile['nickname'] = isset($profile['nickname']) ? "{$profile['nickname']}" : isset(
            $user['nickname']) ? "'{$user['nickname']}'" : "null";
    $profile['given_name'] = isset($profile['given_name']) ? "'{$profile['given_name']}'" : isset(
            $user['given_name']) ? "'{$user['given_name']}'" : "null";
    $profile['family_name'] = isset($profile['family_name']) ? "'{$profile['family_name']}'" : isset(
            $user['family_name']) ? "'{$user['family_name']}'" : "null";
    
    switch ($user['identities'][0]['provider']) {
        case 'facebook':
            $profile['provider'] = "facebook_id = '{$user['identities'][0]['user_id']}'";
            
            break;
        case 'google-oauth2':
            $profile['provider'] = "google_id = '{$user['identities'][0]['user_id']}'";
            
            break;
        case 'auth0':
            $profile['provider'] = "auth0_id = '{$user['identities'][0]['user_id']}'";
            
            break;
    }
    
    $profile['facebook_id'] = isset($user['facebook_id']) ? "'{$user['facebook_id']}'" : "null";
    $profile['google_id'] = isset($user['google_id']) ? "'{$user['google_id']}'" : "null";
    $profile['auth0_id'] = isset($user['auth0_id']) ? "'{$user['auth0_id']}'" : "null";
    
    $profile_sql = "SELECT * FROM for_profiles
                    WHERE email = {$profile['email']}
                    ORDER BY nickname ASC;";
    
    $profile_result = mysqli_query($link, $profile_sql);
    
    if ($profile_result) {
        $profile_sql = "UPDATE for_profiles
    					SET nickname = '{$profile['nickname']}',
    						given_name = '{$profile['given_name']}',
    						family_name = '{$profile['family_name']}'
    						{$profile['provider']}
    					WHERE email = '{$user['email']}';";
        
        $profile['profile_id'] = '';
        $events['mysql']['operation'] = 'update';
        
        $profile['profile_id'] = mysqli_fetch_assoc($profile_result)[0]['profile_id'];
    } else {
        $profile_sql = "INSERT INTO for_profiles
                        (nickname, given_name, family_name, facebook_id, google_id, auth0_id)
                        VALUES
                        ('{$profile['nickname']}',
                         '{$profile['given_name']}',
                         '{$profile['family_name']}',
                         '{$profile['facebook_id']}',
                         '{$profile['google_id']}',
                         '{$profile['auth0_id']}');";
        
        $events['mysql']['operation'] = 'insert';
    }
    
    $profile_result = mysqli_query($link, $profile_sql);
    
    if ($events['mysql']['operation'] == 'insert') {
        $profile['profile_id'] = mysqli_insert_id($link);
    }
    
    if (! $tag_result) {
        header('HTTP/1.0 404 Not Found');
        
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        
        echo json_encode(
                array(
                        'events' => $events
                ));
        
        exit();
    }
    
    $events['mysql']['result'] = true;
    
    echo json_encode(
            array(
                    'profiles' => $profile,
                    'events' => $events
            ));
    
    mysqli_close($link);
}
?>

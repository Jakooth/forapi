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
        
        if ($profiles && $user['email'] != $profiles['email']) {
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
    $post_profile = json_decode($json, true);
    $profile;
    
    /**
     * TODO: Remove profile variable and replace it other variables.
     * E.g. $profile['nickname'] to $sql_nickname,
     * $profile['facebook_id'] to $sql_fecebook_id, etc.
     * Remember to also include the clean values after INSERT.
     * On UPDATE return return the returned profile plus the new clean values.
     */
    
    $nickname_sql = isset($post_profile['nickname']) ? "'{$post_profile['nickname']}'" : (isset(
            $user['nickname']) ? "'{$user['nickname']}'" : "null");
    $given_name_sql = isset($post_profile['given_name']) ? "'{$post_profile['given_name']}'" : (isset(
            $user['given_name']) ? "'{$user['given_name']}'" : "null");
    $family_name_sql = isset($post_profile['family_name']) ? "'{$post_profile['family_name']}'" : (isset(
            $user['family_name']) ? "'{$user['family_name']}'" : "null");
    $facebook_sql = "null";
    $google_sql = "null";
    $auth0_sql = "null";
    $provider_sql = "null";
    
    $profile['nickname'] = "null";
    $profile['given_name'] = "null";
    $profile['family_name'] = "null";
    $profile['facebook_id'] = "null";
    $profile['google_id'] = "null";
    $profile['auth0_id'] = "null";
    
    switch ($user['identities'][0]['provider']) {
        case 'facebook':
            $provider_sql = "facebook_id = '{$user['identities'][0]['user_id']}'";
            $facebook_sql = "'{$user['identities'][0]['user_id']}'";
            
            break;
        case 'google-oauth2':
            $provider_sql = "google_id = '{$user['identities'][0]['user_id']}'";
            $google_sql = "'{$user['identities'][0]['user_id']}'";
            
            break;
        case 'auth0':
            $provider_sql = "auth0_id = '{$user['identities'][0]['user_id']}'";
            $auth0_sql = "'{$user['identities'][0]['user_id']}'";
            
            break;
    }
    
    $profile_sql = "SELECT * FROM for_profiles
                    WHERE email = '{$user['email']}'
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
    
    $profile = mysqli_fetch_assoc($profile_result);
    
    if ($profile) {
        $profile_sql = "UPDATE for_profiles
    					SET nickname = $nickname_sql,
    						given_name = $given_name_sql,
    						family_name = $family_name_sql,
    						$provider_sql
    					WHERE email = '{$user['email']}';";
        
        $events['mysql']['operation'] = 'update';
    } else {
        $profile_sql = "INSERT INTO for_profiles
                            (email, nickname, given_name, family_name, facebook_id, google_id, auth0_id)
                        VALUES
                            ('{$user['email']}',
                             $nickname_sql,
                             $given_name_sql,
                             $family_name_sql,
                             $facebook_sql,
                             $google_sql,
                             $auth0_sql);";
        
        $events['mysql']['operation'] = 'insert';
    }
    
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
    
    /**
     * One last fetch from the data base to get the updated profile.
     * One can update this here in PHP based on the JSON,
     * but I prefer to get the real thing from the data base.
     */
    
    $profile_sql = "SELECT * FROM for_profiles
                    WHERE email = '{$user['email']}'
                    ORDER BY nickname ASC;";
    
    $profile_result = mysqli_query($link, $profile_sql);
    
    $events['mysql']['result'] = true;
    
    $profile = mysqli_fetch_assoc($profile_result);
    
    echo json_encode(
            array(
                    'profiles' => $profile,
                    'events' => $events
            ));
    
    mysqli_close($link);
}
?>

<?php
include ('../../../forsecret/db.php');
require_once ('../phplib/php-image-magician/php_image_magician.php');

function compressPng ($file)
{
    $png = imagecreatefromstring(file_get_contents($file));
    
    imagealphablending($png, false);
    imagesavealpha($png, true);
    
    imagepng($png, $file, 9);
    imagedestroy($png);
}

if (getenv('REQUEST_METHOD') == 'DELETE') {
    
    /**
     * In verison 5.6 of PHP ajax calls are no longer in POST.
     * The request is POST but variables are stored in php://input.
     */
    
    $json_forimg = file_get_contents("php://input");
    $php_forimg = json_decode($json_forimg, true);
    
    $folder = "$root/assets/articles/{$php_forimg['tag']}";
    $file = "$folder/{$php_forimg['img']}";
    
    unlink($file);
    
    /**
     * Send the response back to the browser in JSON format.
     * And finally close the connection.
     */
    
    echo json_encode(array(
            'events' => $events
    ));
    
    mysqli_close($link);
}

if (getenv('REQUEST_METHOD') == 'GET') {
    $folder = "$root/assets/articles/{$_GET['tag']}";
    
    /**
     * List files to get the last index.
     * Note it will always return '.' and '..'.
     * Also it will return _extras folder.
     * If the directory does not exists retunr empty array.
     */
    
    if (! file_exists($folder)) {
        $files = array();
    } else {
        $files = scandir($folder, 1);
    }
    
    /**
     * Send the response back to the browser in JSON format.
     * And finally close the connection.
     */
    
    echo json_encode(
            array(
                    'events' => $events,
                    'imgs' => $files
            ));
    
    mysqli_close($link);
}

if (getenv('REQUEST_METHOD') == 'POST') {
    $folder = "$root/assets/articles";
    $file = "";
    $mime = explode("/", $_FILES['img']['type']);
    $extension = array_pop($mime);
    $mime = $extension == 'jpeg' ? 'jpg' : $extension;
    $width = 1920;
    $height = 1080;
    
    /**
     * We will execute all queries frist and then submit the transaction.
     */
    
    mysqli_autocommit($link, FALSE);
    
    if ($_FILES['img']['size'] <= 0) {
        $events['upload']['img'] = false;
        $events['upload']['error'] = 'Image is too big. ' .
                 'Resize it to no more than 1920x1920 and compress it using Photoshop Save for Web feature. ' .
                 'Set JPG quality to 100% or use PNG-24 format.';
        
        goto end;
    }
    
    if ($mime != 'png' && $mime != 'jpg') {
        $events['upload']['img'] = false;
        $events['upload']['error'] = 'Images must in JPG or PNG format. ' .
                 'Convert it using Photoshop Save for Web feature. ' .
                 'Set JPG quality to 100% or use PNG-24 format.';
        
        goto end;
    }
    
    switch ($_POST['type']) {
        case 'shot':
            $folder = "$root/assets/articles/{$_POST['path']}";
            $file = "";
            $i = "01";
            
            /**
             * Check if driectory exists.
             */
            
            if (! file_exists($folder)) {
                mkdir($folder);
            }
            
            /**
             * List files to get the last index.
             */
            
            $files = scandir($folder, 1);
            
            /**
             * Note it will always return '.' and '..'.
             * Also it will return _extras folder.
             * Start the idnex from 0 and increment.
             * If the increment is more than 99 + 2, clean up it manually.
             * TODO: Check for gaps in the index and try to solve automatically.
             */
            
            if (sizeof($files) >= 101) {
                $events['upload']['img'] = false;
                $events['upload']['error'] = 'No more than 99 images can be associated with a tag.';
                
                goto end;
            }
            
            if (sizeof($files) <= 2) {
                $file = "$folder/{$_POST['path']}-01.$mime";
            } else {
                $i = intval(array_pop((explode("-", $files[0]))));
                
                $i ++;
                
                if ($i <= 9) {
                    $i = "0$i";
                }
                
                $file = "$folder/{$_POST['path']}-$i.$mime";
            }
            
            move_uploaded_file($_FILES['img']['tmp_name'], $file);
            
            /**
             * Now do the image resize and conversion.
             * 16:9 format is FULL HD, HD or Vita.
             * 16:10 format is Desktop or Notebook.
             */
            
            $magic = new imageLib($file);
            $w = $magic->getOriginalWidth();
            $h = $magic->getOriginalHeight();
            
            /**
             * Do not accept small images.
             */
            
            if ($w < 640) {
                unlink($file);
                
                $events['upload']['img'] = false;
                $events['upload']['error'] = 'Image must be above 640px width.';
                
                goto end;
            }
            
            /**
             * Do not resize images, if they are in the correct size.
             * PHP will greatly increase size, epecally for transparent PNG.
             */
            
            if (($w == '1920' && $h == '1080') || ($w == '1280' && $h == '720') ||
                     ($w == '960' && $h == '544') ||
                     ($w == '1280' && $h == '800') ||
                     ($w == '1680' && $h == '1050')) {
                
                /**
                 * Better compression for PNG images.
                 */
                
                if ($mime == 'png') {
                    compressPng($file);
                }
                
                goto end;
            }
            
            if ($w / $h == 1.6) {
                if ($w >= 1440) {
                    $magic->resizeImage(1680, 1050, 'crop');
                }
                
                if ($w <= 1440 && $w >= 640) {
                    $magic->resizeImage(1280, 720, 'crop');
                }
            } else {
                if ($w >= 1600) {
                    $magic->resizeImage(1920, 1080, 'crop');
                }
                
                if ($w <= 1600 && $w >= 1024) {
                    $magic->resizeImage(1280, 720, 'crop');
                }
                
                if ($w <= 1024 && $w >= 640) {
                    $magic->resizeImage(960, 544, 'crop');
                }
            }
            
            $magic->saveImage($file, 100);
            
            /**
             * Better compression for PNG images.
             */
            
            if ($mime == 'png') {
                compressPng($file);
            }
            
            /**
             * Insert activity log event for images which are resized.
             */
            
            $log_sql = "INSERT INTO for_log
                            (`event`, `table`, tag, object, user, created, acknowledged)
                        VALUES
                            ('upload',
                            '{$_POST['path']}',
                            '{$_POST['path']}-$i.$mime',
                            '{$_POST['type']}',
                            '{$user['email']}',
                            now(),
                            null);";
            
            $log_result = mysqli_query($link, $log_sql);
            
            if (! $log_result) {
                $events['mysql']['result'] = false;
                $events['mysql']['code'] = mysqli_errno($link);
                $events['mysql']['error'] = mysqli_error($link);
                
                goto end;
            }
            
            break;
        case 'tag':
            $folder = "$root/assets/tags";
            
            $file = "$folder/{$_POST['path']}.$mime";
            move_uploaded_file($_FILES['img']['tmp_name'], $file);
            
            /**
             * Now do the image resize and conversion.
             * 128x128 for a tag image.
             */
            
            $magic = new imageLib($file);
            $w = $magic->getOriginalWidth();
            $h = $magic->getOriginalHeight();
            
            if (($w == '128' && $h == '128')) {
                /**
                 * Better compression for PNG images.
                 */
                
                if ($mime == 'png') {
                    compressPng($file);
                }
                
                goto end;
            }
            
            $magic->resizeImage(128, 128, 'crop');
            $magic->saveImage($file, 100);
            
            /**
             * Better compression for PNG images.
             */
            
            if ($mime == 'png') {
                compressPng($file);
            }
            
            /**
             * Insert activity log event for images which are resized.
             */
            
            $log_sql = "INSERT INTO for_log
                            (`event`, `table`, tag, object, user, created, acknowledged)
                        VALUES
                            ('upload',
                            'tags',
                            '{$_POST['path']}.$mime',
                            '{$_POST['type']}',
                            '{$user['email']}',
                            now(),
                            null);";
            
            $log_result = mysqli_query($link, $log_sql);
            
            if (! $log_result) {
                $events['mysql']['result'] = false;
                $events['mysql']['code'] = mysqli_errno($link);
                $events['mysql']['error'] = mysqli_error($link);
                
                goto end;
            }
            
            break;
        case 'caret':
            $tagFolder = "$root/assets/articles/{$_POST['path']}";
            $folder = "$root/assets/articles/{$_POST['path']}/_extras";
            $file = "$folder/{$_POST['path']}-{$_POST['type']}.$mime";
            
            /**
             * Check if driectory exists.
             */
            
            if (! file_exists($tagFolder)) {
                mkdir($tagFolder);
            }
            
            if (! file_exists($folder)) {
                mkdir($folder);
            }
            
            move_uploaded_file($_FILES['img']['tmp_name'], $file);
            
            /**
             * Now do the image resize and conversion.
             */
            
            $magic = new imageLib($file);
            $w = $magic->getOriginalWidth();
            $h = $magic->getOriginalHeight();
            
            if (($w == '512' && $h == '512')) {
                /**
                 * Better compression for PNG images.
                 */
                
                compressPng($file);
                
                goto end;
            }
            
            $magic->resizeImage(512, 512, 'crop');
            $magic->saveImage($file, 100);
            
            /**
             * Better compression for PNG images.
             */
            
            if ($mime == 'png') {
                compressPng($file);
            }
            
            /**
             * Insert activity log event for images which are resized.
             */
            
            $log_sql = "INSERT INTO for_log
                            (`event`, `table`, tag, object, user, created, acknowledged)
                        VALUES
                            ('upload',
                            'extras',
                            '{$_POST['path']}.$mime',
                            '{$_POST['type']}',
                            '{$user['email']}',
                            now(),
                            null);";
            
            $log_result = mysqli_query($link, $log_sql);
            
            if (! $log_result) {
                $events['mysql']['result'] = false;
                $events['mysql']['code'] = mysqli_errno($link);
                $events['mysql']['error'] = mysqli_error($link);
                
                goto end;
            }
            
            break;
        case 'game':
        case 'movie':
        case 'tv':
        case 'event':
        case 'album':
        case 'book':
        case 'board':
            $tagFolder = "$root/assets/articles/{$_POST['path']}";
            $folder = "$root/assets/articles/{$_POST['path']}/_extras";
            $file = "$folder/{$_POST['path']}-{$_POST['subtype']}.$mime";
            $convertFile = "$folder/{$_POST['path']}-{$_POST['subtype']}.jpg";
            
            /**
             * Check if driectory exists.
             */
            
            if (! file_exists($tagFolder)) {
                mkdir($tagFolder);
            }
            
            if (! file_exists($folder)) {
                mkdir($folder);
            }
            
            move_uploaded_file($_FILES['img']['tmp_name'], $file);
            
            /**
             * Now do the image resize and conversion.
             */
            
            $magic = new imageLib($file);
            $w = $magic->getOriginalWidth();
            $h = $magic->getOriginalHeight();
            
            switch ($_POST['subtype']) {
                case 'ps3':
                    if (($w == '445' && $h == '512')) {
                        goto end;
                    }
                    
                    $magic->resizeImage(445, 512, 'crop');
                    break;
                case 'ps4':
                case 'one':
                    if (($w == '410' && $h == '512')) {
                        goto end;
                    }
                    
                    $magic->resizeImage(410, 512, 'crop');
                    break;
                case '360':
                    if (($w == '362' && $h == '512')) {
                        goto end;
                    }
                    
                    $magic->resizeImage(362, 512, 'crop');
                    break;
                case 'win':
                    if (($w == '356' && $h == '512')) {
                        goto end;
                    }
                    
                    $magic->resizeImage(356, 512, 'crop');
                    break;
                case 'poster':
                case 'cover':
                    if ($_POST['type'] == 'album') {
                        if (($w == '512' && $h == '512')) {
                            goto end;
                        }
                        
                        $magic->resizeImage(512, 512, 'crop');
                    } else {
                        if (($w == '345' && $h == '512')) {
                            goto end;
                        }
                        
                        $magic->resizeImage(345, 512, 'crop');
                    }
                    
                    break;
                default:
                    if (($w == '512' && $h == '512')) {
                        goto end;
                    }
                    
                    $magic->resizeImage(512, 512, 'crop');
                    break;
            }
            
            $magic->saveImage($convertFile, 100);
            
            if ($mime == 'png') {
                unlink($file);
            }
            
            /**
             * Insert activity log event for images which are resized.
             */
            
            $log_sql = "INSERT INTO for_log
                            (`event`, `table`, tag, object, user, created, acknowledged)
                        VALUES
                            ('upload',
                            'extras',
                            '{$_POST['path']}.jpg',
                            '{$_POST['subtype']}',
                            '{$user['email']}',
                            now(),
                            null);";
            
            $log_result = mysqli_query($link, $log_sql);
            
            if (! $log_result) {
                $events['mysql']['result'] = false;
                $events['mysql']['code'] = mysqli_errno($link);
                $events['mysql']['error'] = mysqli_error($link);
                
                goto end;
            }
            
            break;
    }
    
    /**
     * Only accept the transaction, if all results are successuful.
     * Note, on rollback auto-increment for successful transfers is not reset.
     */
    
    if ($log_result) {
        mysqli_commit($link);
        
        $events['mysql']['result'] = true;
    } else {
        mysqli_rollback($link);
    }
    
    end:
    
    /**
     * Send the response back to the browser in JSON format.
     * And finally close the connection.
     */
    
    echo json_encode(array(
            'events' => $events
    ));
    
    mysqli_close($link);
}

?>
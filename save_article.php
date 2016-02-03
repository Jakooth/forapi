<?php
include ('db.php');

if (getenv('REQUEST_METHOD') == 'POST') {
    
    /**
     * In verison 5.6 of PHP ajax calls are no longer in POST.
     * The request is POST but variables are stored in php://input.
     */
    
    $json_forarticle = file_get_contents("php://input");
    $php_forarticle = json_decode($json_forarticle, true);
    
    /**
     * Making some of the optional variable null.
     * Note for date it is required to being date format or null.
     */
    
    $php_forarticle_subtitle = isset($php_forarticle['subtitle']) ? "'{$php_forarticle ['subtitle']}'" : "null";
    $php_forarticle_wide = isset($php_forarticle['wide']) ? "'{$php_forarticle ['wide']}'" : "null";
    $php_forarticle_caret = isset($php_forarticle['caret']) ? "'{$php_forarticle ['caret']}'" : "null";
    $php_forarticle_priority = isset($php_forarticle['priority']) ? "'{$php_forarticle ['priority']}'" : "null";
    $php_forarticle_preview = isset($php_forarticle['preview']) ? "'{$php_forarticle ['preview']}'" : "null";
    $php_forarticle_videotech = isset($php_forarticle['videoTech']) ? "'{$php_forarticle ['videoTech']}'" : "null";
    $php_forarticle_videourl = isset($php_forarticle['videoUrl']) ? "'{$php_forarticle ['videoUrl']}'" : "null";
    $php_forarticle_audiotech = isset($php_forarticle['audioTech']) ? "'{$php_forarticle ['audioTech']}'" : "null";
    $php_forarticle_audiourl = isset($php_forarticle['audioUrl']) ? "'{$php_forarticle ['audioUrl']}'" : "null";
    $php_forarticle_audioframe = isset($php_forarticle['audioFrame']) ? "'{$php_forarticle ['audioFrame']}'" : "null";
    $php_forarticle_cover = isset($php_forarticle['cover']) ? "'{$php_forarticle ['cover']}'" : "null";
    $php_forarticle_coveralign = isset($php_forarticle['coverAlign']) ? "'{$php_forarticle ['coverAlign']}'" : "null";
    $php_forarticle_covervalign = isset($php_forarticle['coverValign']) ? "'{$php_forarticle ['coverValign']}'" : "null";
    $php_forarticle_theme = isset($php_forarticle['theme']) ? "'{$php_forarticle ['theme']}'" : "null";
    $php_forarticle_subtheme = isset($php_forarticle['subtheme']) ? "'{$php_forarticle ['subtheme']}'" : "null";
    $php_forarticle_hype = isset($php_forarticle['hype']) ? "'{$php_forarticle ['hype']}'" : "null";
    $php_forarticle_platform = isset($php_forarticle['platform']) ? "'{$php_forarticle ['platform']}'" : "null";
    $php_forarticle_better = isset($php_forarticle['better']) ? "'{$php_forarticle ['better']['tag_id']}'" : "null";
    $php_forarticle_worse = isset($php_forarticle['worse']) ? "'{$php_forarticle ['worse']['tag_id']}'" : "null";
    $php_forarticle_equal = isset($php_forarticle['equal']) ? "'{$php_forarticle ['equal']['tag_id']}'" : "null";
    $php_forarticle_bettertext = isset($php_forarticle['betterText']) ? "'{$php_forarticle ['betterText']}'" : "null";
    $php_forarticle_worsetext = isset($php_forarticle['worseText']) ? "'{$php_forarticle ['worseText']}'" : "null";
    $php_forarticle_equaltext = isset($php_forarticle['equalText']) ? "'{$php_forarticle ['equalText']}'" : "null";
    $php_forarticle_isupdate = isset($php_forarticle['_saveId']);
    
    /**
     * Date is always send from the script,
     * but we need to format it in MySQL pattern.
     */
    
    $php_forarticle_date = date(' Y-m-d H:i:s', 
            strtotime($php_forarticle['date']));
    
    if ($php_forarticle_isupdate) {
        $article_sql = "UPDATE for_articles
                        SET `type` = '{$php_forarticle['type']}',
                            subtype = '{$php_forarticle['subtype']}',
                            title = '{$php_forarticle['title']}',
                            subtitle = $php_forarticle_subtitle,
                            shot_img = '{$php_forarticle['shot']}',
                            wide_img = $php_forarticle_wide,
                            caret_img = $php_forarticle_caret,
                            site = '{$php_forarticle['site']}',
                            url = '{$php_forarticle['url']}',
                            date = '$php_forarticle_date',
                            priority = $php_forarticle_priority,
                            preview = $php_forarticle_preview,
                            video_tech = $php_forarticle_videotech,
                            video_url = $php_forarticle_videourl,
                            audio_tech = $php_forarticle_audiotech,
                            audio_url = $php_forarticle_audiourl,
                            audio_frame = $php_forarticle_audioframe,
                            cover_img = $php_forarticle_cover,
                            cover_align = $php_forarticle_coveralign,
                            cover_valign = $php_forarticle_covervalign,
                            theme = $php_forarticle_theme,
                            subtheme = $php_forarticle_subtheme,
                            hype = $php_forarticle_hype,
                            platform = $php_forarticle_platform,
                            better = $php_forarticle_better,
                            worse = $php_forarticle_worse,
                            equal = $php_forarticle_equal,
                            better_text = $php_forarticle_bettertext,
                            worse_text = $php_forarticle_worsetext,
                            equal_text = $php_forarticle_equaltext
                        WHERE article_id = {$php_forarticle ['_saveId']};";
        
        $events['mysql']['operation'] = 'update';
    } else {
        
        /**
         * First row of the sql string is for general properties,
         * Second are main images,
         * Third is for publish settings and preview,
         * Fourth are video an audio for news,
         * Fifth are cover images and settings,
         * Last if review score and information.
         * Authors, tags, prime and issue are stored in relational table.
         * Stickers, if any are later get from the prime by tag and tag_id.
         */
        
        $article_sql = "INSERT INTO for_articles
                            (`type`, subtype, title, subtitle,
                             shot_img, wide_img, caret_img,
                             site, url, `date`, priority, preview,
                             video_tech, video_url, audio_tech, audio_url, audio_frame,
                             cover_img, cover_align, cover_valign, theme, subtheme,
                             hype, platform, better, worse, equal, better_text, worse_text, equal_text)
                        VALUES
                            ('{$php_forarticle['type']}',
                             '{$php_forarticle['subtype']}',
                             '{$php_forarticle['title']}',
                             $php_forarticle_subtitle,
                             '{$php_forarticle['shot']}',
                             $php_forarticle_wide,
                             $php_forarticle_caret,
                             '{$php_forarticle['site']}',
                             '{$php_forarticle['url']}',
                             '$php_forarticle_date',
                             $php_forarticle_priority,
                             $php_forarticle_preview,
                             $php_forarticle_videotech,
                             $php_forarticle_videourl,
                             $php_forarticle_audiotech,
                             $php_forarticle_audiourl,
                             $php_forarticle_audioframe,
                             $php_forarticle_cover,
                             $php_forarticle_coveralign,
                             $php_forarticle_covervalign,
                             $php_forarticle_theme,
                             $php_forarticle_subtheme,
                             $php_forarticle_hype,
                             $php_forarticle_platform,
                             $php_forarticle_better,
                             $php_forarticle_worse,
                             $php_forarticle_equal,
                             $php_forarticle_bettertext,
                             $php_forarticle_worsetext,
                             $php_forarticle_equaltext);";
        
        $events['mysql']['operation'] = 'insert';
    }
    
    $log_sql = "INSERT INTO for_log
					(`event`, `table`, tag, object, user, created, acknowledged)
				VALUES
					('{$events ['mysql'] ['operation']}',
					 'for_articles',
					 '{$php_forarticle['url']}',
					 '{$php_forarticle['subtype']}',
					 0,
					 now(),
					 null);";
    
    /**
     * We will execute all queries first and then submit the transaction.
     */
    
    mysqli_autocommit($link, FALSE);
    
    /**
     * The most important thing is the tag, so we send it first.
     * On failure, there is no point to continue and we can have id gaps.
     */
    
    $article_result = mysqli_query($link, $article_sql);
    $related_result = true;
    $img_result = true;
    $log_result = true;
    
    /**
     * Response values used to update later.
     */
    
    $operation['saveId'] = null;
    $operation['saveAuthors'] = array();
    $authors_arr = array();
    $operation['saveTags'] = array();
    $tags_arr = array();
    $operation['saveLayouts'] = array();
    $layouts_arr = array();
    $imgs_arr = array();
    
    if (! $article_result) {
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
    } else {
        
        /**
         * Next we query the log, but we do not stop on failure.
         * Note the chance for error here is almost impossible,
         * Because we generate the values here and not from user input.
         */
        
        if ($php_forarticle_isupdate) {
            $article_last = $php_forarticle['_saveId'];
        } else {
            $article_last = mysqli_insert_id($link);
        }
        
        $log_result = mysqli_query($link, $log_sql);
        
        if (! $log_result) {
            $events['mysql']['result'] = false;
            $events['mysql']['code'] = mysqli_errno($link);
            $events['mysql']['error'] = mysqli_error($link);
        }
        
        /**
         * Insert or update authors.
         */
        
        if (isset($php_forarticle['author'])) {
            $authors_arr = $php_forarticle['author'];
        }
        
        if (isset($php_forarticle['_saveAuthors'])) {
            $saveAuthorsCount = count($php_forarticle['_saveAuthors']);
            $authorsCount = count($authors_arr);
            
            if ($saveAuthorsCount > $authorsCount) {
                for ($i = $authorsCount; $i < $saveAuthorsCount; $i ++) {
                    $related_sql = "DELETE FROM for_rel_authors
                                    WHERE article_id = {$php_forarticle ['_saveId']}
                                    AND author_id = {$php_forarticle ['_saveAuthors'] [$i]}
                                    LIMIT 1;";
                    
                    $related_result = mysqli_query($link, $related_sql);
                    
                    if (! $related_result) {
                        goto end;
                    }
                }
            }
        }
        
        if (count($authors_arr) > 0) {
            foreach ($authors_arr as $key => $value) {
                $id = isset($value['author_id']) ? "{$value['author_id']}" : "null";
                
                if (isset($php_forarticle['_saveAuthors'])) {
                    if ($key < count($php_forarticle['_saveAuthors'])) {
                        $related_sql = "UPDATE for_rel_authors
                                        SET author_id = $id
                                        WHERE article_id = {$php_forarticle ['_saveId']}
                                        AND author_id = {$php_forarticle ['_saveAuthors'] [$key]}
                                        LIMIT 1;";
                        
                        goto author_update;
                    } else {
                        goto author_insert;
                    }
                } else {
                    goto author_insert;
                }
                
                /**
                 * Do insert.
                 */
                
                author_insert:
                
                $related_sql = "INSERT INTO for_rel_authors 
                                    (article_id, author_id)
								VALUES
							        ($article_last, $id);";
                
                /**
                 * Do update.
                 */
                
                author_update:
                
                $related_result = mysqli_query($link, $related_sql);
                
                /**
                 * We end up on the first sign of error.
                 */
                
                if (! $related_result) {
                    goto end;
                }
                
                array_push($operation['saveAuthors'], $id);
            }
        }
        
        /**
         * Insert and update tags.
         */
        
        if (isset($php_forarticle['tags'])) {
            $tags_arr = $php_forarticle['tags'];
        }
        
        if (isset($php_forarticle['_saveTags'])) {
            $saveTagsCount = count($php_forarticle['_saveTags']);
            $tagsCount = count($tags_arr);
            
            if ($saveTagsCount > $tagsCount) {
                for ($i = $tagsCount; $i < $saveTagsCount; $i ++) {
                    $related_sql = "DELETE FROM for_rel_tags
                                    WHERE article_id = {$php_forarticle ['_saveId']}
                                    AND tag_id = {$php_forarticle ['_saveTags'] [$i]}
                                    LIMIT 1;";
                    
                    $related_result = mysqli_query($link, $related_sql);
                    
                    if (! $related_result) {
                        goto end;
                    }
                }
            }
        }
        
        if (count($tags_arr) > 0) {
            foreach ($tags_arr as $key => $value) {
                $id = isset($value['tag_id']) ? "{$value['tag_id']}" : "null";
                $prime = 0;
                
                if ($php_forarticle['prime']['tag_id'] == $value['tag_id']) {
                    $prime = 1;
                }
                
                if (isset($php_forarticle['_saveTags'])) {
                    if ($key < count($php_forarticle['_saveTags'])) {
                        $related_sql = "UPDATE for_rel_tags
                                        SET tag_id = $id,
                                            prime = $prime
                                        WHERE article_id = {$php_forarticle ['_saveId']}
                                        AND tag_id = {$php_forarticle ['_saveTags'] [$key]}
                                        LIMIT 1;";
                        
                        goto tag_update;
                    } else {
                        goto tag_insert;
                    }
                } else {
                    goto tag_insert;
                }
                
                /**
                 * Do insert.
                 */
                
                tag_insert:
                
                $related_sql = "INSERT INTO for_rel_tags
                                    (tag_id, article_id, prime)
								VALUES 
								    ($id, $article_last, $prime);";
                
                /**
                 * Do update.
                 */
                
                tag_update:
                
                $related_result = mysqli_query($link, $related_sql);
                
                /**
                 * We end up on the first sign of error.
                 */
                
                if (! $related_result) {
                    goto end;
                }
                
                array_push($operation['saveTags'], $id);
            }
        }
        
        /**
         * Insert and update layouts.
         */
        
        if (isset($php_forarticle['layouts'])) {
            $layouts_arr = $php_forarticle['layouts'];
        }
        
        if (isset($php_forarticle['layouts'])) {
            $layouts_arr = $php_forarticle['layouts'];
            
            if (isset($php_forarticle['_saveLayouts'])) {
                $saveLayoutsCount = count($php_forarticle['_saveLayouts']);
                $layoutsCount = count($layouts_arr);
                
                if ($saveLayoutsCount > $layoutsCount) {
                    for ($i = $layoutsCount; $i < $saveLayoutsCount; $i ++) {
                        $related_sql = "DELETE FROM for_layouts
                                        WHERE article_id = {$php_forarticle ['_saveId']}
                                        AND layout_id = {$php_forarticle ['_saveLayouts'] [$i]}
                                        LIMIT 1;";
                        
                        $related_result = mysqli_query($link, $related_sql);
                        
                        if (! $related_result) {
                            goto end;
                        }
                        
                        $related_sql = "DELETE FROM for_rel_imgs
                                        WHERE layout_id = {$php_forarticle ['_saveLayouts'] [$i]};";
                        
                        $related_result = mysqli_query($link, $related_sql);
                        
                        if (! $related_result) {
                            goto end;
                        }
                    }
                }
            }
        }
        
        if (count($layouts_arr) > 0) {
            foreach ($layouts_arr as $key => $layout) {
                $layout_subtype = isset($layout['subtype']) ? "'{$layout['subtype']}'" : "null";
                $layout_center = isset($layout['center']) ? "'{$layout['center']}'" : "null";
                $layout_left = isset($layout['left']) ? "'{$layout['left']['url']}'" : "null";
                $layout_left_valign = isset($layout['left']) ? "'{$layout['left']['valign']}'" : "null";
                $layout_left_object = isset($layout['left']) ? "'{$layout['left']['object']}'" : "null";
                $layout_right = isset($layout['right']) ? "'{$layout['right']['url']}'" : "null";
                $layout_right_valign = isset($layout['right']) ? "'{$layout['right']['valign']}'" : "null";
                $layout_right_object = isset($layout['right']) ? "'{$layout['right']['object']}'" : "null";
                
                /**
                 * We do this to know, if we need to insert some images.
                 * The problem is we have one result for update and insert.
                 */
                
                $isUpdate = false;
                
                if (isset($php_forarticle['_saveLayouts'])) {
                    if ($key < count($php_forarticle['_saveLayouts'])) {
                        $related_sql = "UPDATE for_layouts
                                        SET `type` = '{$layout['type']}', 
                                            subtype = $layout_subtype,
                                            center = $layout_center, 
                                            `left` =  $layout_left, 
                                            left_valign = $layout_left_valign, 
                                            left_object = $layout_left_object, 
									        `right` = $layout_right, 
                                            right_valign = $layout_right_valign, 
                                            right_object = $layout_right_object,
									        ratio = '{$layout['ratio']}', 
                                            `order` = $key
                                        WHERE article_id = {$php_forarticle ['_saveId']} 
                                        AND layout_id = {$php_forarticle ['_saveLayouts'] [$key]}
                                        LIMIT 1;";
                        
                        /**
                         * Insert and update images.
                         */
                        
                        if (isset($layout['imgs'])) {
                            $imgs_arr = $layout['imgs'];
                        } else {
                            $imgs_arr = array();
                        }
                        
                        /**
                         * Delete imgs.
                         */
                        
                        if (isset($layout['imgs'])) {
                            if (isset($layout['_saveImgs'])) {
                                $saveImgsCount = $layout['_saveImgs'];
                                $imgsCount = count($imgs_arr);
                            }
                            
                            if ($saveImgsCount > $imgsCount) {
                                for ($j = $imgsCount; $j < $saveImgsCount; $j ++) {
                                    $img_sql = "DELETE FROM for_rel_imgs
                                                WHERE layout_id = {$php_forarticle ['_saveLayouts'] [$key]}
                                                LIMIT 1;";
                                    
                                    $img_result = mysqli_query($link, $img_sql);
                                    
                                    if (! $img_result) {
                                        goto end;
                                    }
                                }
                            }
                        }
                        
                        /**
                         * Update imgs.
                         */
                        
                        if (count($imgs_arr) > 0) {
                            foreach ($imgs_arr as $imgKey => $img) {
                                $img_tag = isset($img['tag']) ? "'{$img['tag']}'" : "null";
                                $img_index = isset($img['index']) ? "'{$img['index']}'" : "null";
                                $img_center = isset($img['center']) ? "'{$img['center']}'" : "null";
                                $img_author = isset($img['author']) ? "'{$img['author']}'" : "null";
                                
                                /**
                                 * Tracklist is the prime tag.
                                 * From the tag we can get the full list of
                                 * songs.
                                 */
                                
                                $img_tracklist = isset($img['tracklist']) ? "'{$php_forarticle ['prime'] ['tag_id']}'" : "null";
                                $img_align = isset($img['align']) ? "'{$img ['align']}'" : "null";
                                $img_valign = isset($img['valign']) ? "'{$img ['valign']}'" : "null";
                                $img_video = isset($img['video']) ? "'{$img ['video']}'" : "null";
                                
                                /**
                                 * Use nagative value and negate to positive
                                 * after all is updated.
                                 * The goal is to avoid temporary duplicates.
                                 */
                                
                                if (isset($layout['_saveImgs'])) {
                                    if ($imgKey < $layout['_saveImgs']) {
                                        $img_sql = "UPDATE for_rel_imgs
                                                    SET article_id = {$php_forarticle ['_saveId']},
                                                        layout_id = -{$php_forarticle ['_saveLayouts'] [$key]},
                                                        alt = '{$img['alt']}',
                                                        pointer = '{$img['pointer']}',
                                                        tag = $img_tag,
                                                        `index` = $img_index,
                                                        center = $img_center,
                                                        author = $img_author,
                                                        tracklist = $img_tracklist,
                                                        align = $img_align,
                                                        valign = $img_valign,
                                                        video = $img_video,
                                                        ratio = '{$img['ratio']}',
                                                        `order` = $imgKey
                                                    WHERE layout_id = {$php_forarticle ['_saveLayouts'] [$key]}
                                                    LIMIT 1;";
                                        
                                        goto img_update;
                                    } else {
                                        goto img_insert;
                                    }
                                } else {
                                    goto img_insert;
                                }
                                
                                img_insert:
                                
                                $img_sql = "INSERT INTO for_rel_imgs
                                                (article_id, layout_id,
                                                 alt, pointer,
                                                 tag, `index`,
                                                 center, author,
                                                 tracklist, align, valign,
                                                 video,
                                                 ratio,
                                                 `order`)
                                            VALUES
                                                ({$php_forarticle ['_saveId']},
                                                 {$php_forarticle ['_saveLayouts'] [$key]},
                                                 '{$img['alt']}',
                                                 '{$img['pointer']}',
                                                 $img_tag, $img_index,
                                                 $img_center, $img_author,
                                                 $img_tracklist, $img_align, $img_valign,
                                                 $img_video,
                                                 '{$img['ratio']}',
                                                 $imgKey);";
                                
                                img_update:
                                
                                $img_result = mysqli_query($link, $img_sql);
                                
                                if (! $img_result) {
                                    goto end;
                                }
                            }
                        }
                        
                        $isUpdate = true;
                        
                        goto layout_update;
                    } else {
                        $isUpdate = false;
                        
                        goto layout_insert;
                    }
                } else {
                    $isUpdate = false;
                    
                    goto layout_insert;
                }
                
                /**
                 * Do insert.
                 */
                
                layout_insert:
                
                $related_sql = "INSERT INTO for_layouts
									(article_id, 
									 `type`, subtype, 
									 center, 
									 `left`, left_valign, left_object, 
									 `right`, right_valign, right_object,
									 ratio, `order`)
								VALUES
									($article_last, 
									 '{$layout['type']}', $layout_subtype,
									 $layout_center,
									 $layout_left, $layout_left_valign, $layout_left_object,
									 $layout_right, $layout_right_valign, $layout_right_object,
									 '{$layout['ratio']}', $key);";
                
                /**
                 * Do update.
                 */
                
                layout_update:
                
                $related_result = mysqli_query($link, $related_sql);
                
                if (! $related_result) {
                    goto end;
                }
                
                layout_end:
                
                if (isset($php_forarticle['_saveLayouts'])) {
                    if ($key < count($php_forarticle['_saveLayouts'])) {
                        $layout_last = $php_forarticle['_saveLayouts'][$key];
                    } else {
                        $layout_last = mysqli_insert_id($link);
                    }
                } else {
                    $layout_last = mysqli_insert_id($link);
                }
                
                /**
                 * Now we insert the related images, but only for new layouts.
                 */
                
                if (! $isUpdate) {
                    if (isset($layout['imgs'])) {
                        foreach ($layout['imgs'] as $imgKey => $img) {
                            $img_tag = isset($img['tag']) ? "'{$img['tag']}'" : "null";
                            $img_index = isset($img['index']) ? "'{$img['index']}'" : "null";
                            $img_center = isset($img['center']) ? "'{$img['center']}'" : "null";
                            $img_author = isset($img['author']) ? "'{$img['author']}'" : "null";
                            
                            /**
                             * Tracklist is the prime tag.
                             * From the tag we can get the full list of songs.
                             */
                            
                            $img_tracklist = isset($img['tracklist']) ? "'{$php_forarticle ['prime'] ['tag_id']}'" : "null";
                            $img_align = isset($img['align']) ? "'{$img ['align']}'" : "null";
                            $img_valign = isset($img['valign']) ? "'{$img ['valign']}'" : "null";
                            $img_video = isset($img['video']) ? "'{$img ['video']}'" : "null";
                            
                            $img_sql = "INSERT INTO for_rel_imgs
                                            (article_id, layout_id,
                                             alt, pointer,
                                             tag, `index`,
                                             center, author,
                                             tracklist, align, valign,
                                             video,
                                             ratio,
                                             `order`)
                                        VALUES
                                            ($article_last, $layout_last,
                                             '{$img['alt']}', '{$img['pointer']}',
                                             $img_tag, $img_index,
                                             $img_center, $img_author,
                                             $img_tracklist, $img_align, $img_valign,
                                             $img_video,
                                             '{$img['ratio']}',
                                             $imgKey);";
                            
                            $img_result = mysqli_query($link, $img_sql);
                            
                            if (! $img_result) {
                                goto end;
                            }
                        }
                    }
                } else {
                    
                    /**
                     * Negate the new indices.
                     */
                    
                    $img_sql = "UPDATE for_rel_imgs
                    			SET layout_id = -layout_id
                    			WHERE layout_id < 0;";
                    
                    $img_result = mysqli_query($link, $img_sql);
                    
                    if (! $img_result) {
                        goto end;
                    }
                }
                
                array_push($operation['saveLayouts'], $layout_last);
            }
        }
        
        /**
         * Insert and update issue.
         * It is just one issue, but the JSON is still passing it in array.
         */
        
        if (isset($php_forarticle['issue'])) {
            foreach ($php_forarticle['issue'] as $value) {
                $id = isset($value['issue_id']) ? "{$value['issue_id']}" : "null";
                
                $related_sql = "SELECT * 
                                FROM for_rel_issues 
                                WHERE article_id = $article_last";
                
                $related_result = mysqli_query($link, $related_sql);
                
                if (! $related_result) {
                    goto end;
                }
                
                if (mysqli_num_rows($related_result) > 0) {
                    $related_sql = "UPDATE for_rel_issues
                                    SET issue_id = $id
    								WHERE article_id = $article_last;";
                } else {
                    $related_sql = "INSERT INTO for_rel_issues
                                        (article_id, issue_id)
                                    VALUES
                                        ($article_last, $id);";
                }
                
                $related_result = mysqli_query($link, $related_sql);
                
                if (! $related_result) {
                    goto end;
                }
            }
        }
        
        end:
        
        if (! $related_result || ! $img_result) {
            $events['mysql']['result'] = false;
            $events['mysql']['code'] = mysqli_errno($link);
            $events['mysql']['error'] = mysqli_error($link);
        }
    }
    
    /**
     * Only accept the transaction, if all results are successuful.
     * Note, on rollback auto-increment for successful transfers is not reset.
     */
    
    if ($article_result && $log_result && $related_result && $img_result) {
        $events['mysql']['result'] = true;
        
        mysqli_commit($link);
        
        $operation['saveId'] = $article_last;
    } else {
        mysqli_rollback($link);
    }
    
    /**
     * Send the response back to the browser in JSON format.
     * And finally close the connection.
     */
    
    echo json_encode(
            array(
                    'events' => $events,
                    'operation' => $operation
            ));
    
    mysqli_close($link);
}
?>
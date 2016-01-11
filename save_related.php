<?php
$related_arr = array();

/**
 * FORTAG
 */

if (isset($php_fortag['related'])) {
    $related_arr = array_merge($related_arr, $php_fortag['related']);
}

/**
 * FORMAIN
 */

if (isset($php_fortag['stickers'])) {
    $related_arr = array_merge($related_arr, $php_fortag['stickers']);
}

if (isset($php_fortag['genres'])) {
    $related_arr = array_merge($related_arr, $php_fortag['genres']);
}

if (isset($php_fortag['country'])) {
    $related_arr = array_merge($related_arr, $php_fortag['country']);
}

if (isset($php_fortag['serie'])) {
    $related_arr = array_merge($related_arr, $php_fortag['serie']);
}

/**
 * GAME
 */

if (isset($php_fortag['platforms'])) {
    $related_arr = array_merge($related_arr, $php_fortag['platforms']);
}

if (isset($php_fortag['publisher'])) {
    $related_arr = array_merge($related_arr, $php_fortag['publisher']);
}

if (isset($php_fortag['developer'])) {
    $related_arr = array_merge($related_arr, $php_fortag['developer']);
}

/**
 * MOVIE
 */

if (isset($php_fortag['cast'])) {
    $related_arr = array_merge($related_arr, $php_fortag['cast']);
}

if (isset($php_fortag['director'])) {
    $related_arr = array_merge($related_arr, $php_fortag['director']);
}

if (isset($php_fortag['writer'])) {
    $related_arr = array_merge($related_arr, $php_fortag['writer']);
}

if (isset($php_fortag['camera'])) {
    $related_arr = array_merge($related_arr, $php_fortag['camera']);
}

if (isset($php_fortag['music'])) {
    $related_arr = array_merge($related_arr, $php_fortag['music']);
}

/**
 * ALBUM, EVENT
 */

if (isset($php_fortag['artists'])) {
    $related_arr = array_merge($related_arr, $php_fortag['artists']);
}

/**
 * BOOK
 */

if (isset($php_fortag['author'])) {
    $related_arr = array_merge($related_arr, $php_fortag['author']);
}

if (isset($php_fortag['translator'])) {
    $related_arr = array_merge($related_arr, $php_fortag['translator']);
}

/**
 * When we update the first task is to delete as many existing entries,
 * as is the difference between the old save count and the new one.
 * This order is very important, because otherwise you can delete something,
 * after it is already updated.
 * TODO: What if id and related_id match?
 * Note the table is unique by 3 criterias.
 */

if (isset($php_fortag['_saveRelated'])) {
    $saveRelatedCount = count($php_fortag['_saveRelated']);
    $relatedCount = count($related_arr);
    
    if ($saveRelatedCount > $relatedCount) {
        for ($i = $relatedCount; $i < $saveRelatedCount; $i ++) {
            $related_delete_sql = "DELETE FROM for_rel_relative
								   WHERE tag_id = {$php_fortag ['_saveId']}
								   AND related_tag_id = {$php_fortag ['_saveRelated'] [$i]}
								   LIMIT 1;";
            
            $related_result = mysqli_query($link, $related_delete_sql);
            
            if (! $related_result) {
                $events['mysql']['result'] = false;
                $events['mysql']['code'] = mysqli_errno($link);
                $events['mysql']['error'] = mysqli_error($link);
                
                goto end;
            }
        }
    }
}

/**
 * Insert every related tag id, but only if there are any.
 * Also check if the operation is update and not insert.
 * The goal is to update existing entries as much as possible
 * and to prevent generting bigger primary key.
 */

if (count($related_arr) > 0) {
    foreach ($related_arr as $key => $value) {
        
        /**
         * Null is not accepted in the DB, but we use it to generate error
         * and validate empty strings.
         * Note tags are passed to the user interface from the DB,
         * so the chance to have a tag withou id near impossible.
         */
        
        $id = isset($value['tag_id']) ? "{$value['tag_id']}" : "null";
        $subtype = isset($value['subtype']) ? "'{$value['subtype']}'" : "null";
        
        /**
         * Some objects like sticker have different id indentifyer.
         */
        
        switch ($subtype) {
            case "'sticker'":
                $id = isset($value['sticker_id']) ? "{$value['sticker_id']}" : "null";
                
                break;
        }
        
        /**
         * Note when updating there is a minimal chance to genrate error,
         * if you swap two existing values.
         * The problem is that cobmination of tag and related tag is defined
         * as unique to avoid duplicates.
         * If you swap two tags it will update them in order, thus
         * when you change the first one for a moment it will be the same
         * as the second, because the database does not know yet about
         * the next update.
         * To resolve this we use nagative value and negate to positive after
         * all is updated:
         * http://stackoverflow.com/questions/11207574/how-to-swap-values-of-two-rows-in-mysql-without-violating-unique-constraint
         * TODO: What if id and related_id match?
         * Note the table is unique by 3 criterias.
         */
        
        if (isset($php_fortag['_saveRelated'])) {
            if ($key < count($php_fortag['_saveRelated'])) {
                $related_sql = "UPDATE for_rel_relative
								SET related_tag_id = -{$id}, related_subtype = {$subtype}
								WHERE tag_id = {$php_fortag ['_saveId']}
								AND related_tag_id = {$php_fortag ['_saveRelated'] [$key]}
								LIMIT 1;";
                
                goto related_update;
            } else {
                goto related_insert;
            }
        } else {
            goto related_insert;
        }
        
        /**
         * Do insert.
         */
        
        related_insert:
        
        $related_sql = "INSERT INTO for_rel_relative
							(tag_id, related_tag_id, related_subtype)
						VALUES
							({$tag_last}, {$id}, {$subtype});";
        
        /**
         * Do update.
         */
        
        related_update:
        
        $related_result = mysqli_query($link, $related_sql);
        
        /**
         * We end up on the first sign of error.
         */
        
        if (! $related_result) {
            $events['mysql']['result'] = false;
            $events['mysql']['code'] = mysqli_errno($link);
            $events['mysql']['error'] = mysqli_error($link);
            
            goto end;
        }
        
        array_push($operation['saveRelated'], $id);
    }
    
    /**
     * Negate the new indices.
     * Note we need to cheat and use tag_id priary key in WHERE.
     * Otherwise it is not possible to update in safe mode.
     */
    
    $related_sql = "UPDATE for_rel_relative
    				SET related_tag_id = -related_tag_id
    				WHERE related_tag_id < 0
    				AND tag_id > 0;";
    
    $related_result = mysqli_query($link, $related_sql);
    
    if (! $related_result) {
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        
        goto end;
    }
}

end:
?>
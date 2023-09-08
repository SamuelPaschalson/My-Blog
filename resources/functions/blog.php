<?php
function add_post($mysqli, $title, $contents, $category){
    $title      = $mysqli->real_escape_string($title);
    $contents   = $mysqli->real_escape_string($contents);
    $category   = (int)$category;
    
    $mysqli->query("INSERT INTO `posts` SET
                `cat_id`     = {$category},
                `title`      = '{$title}',
                `contents`   = '{$contents}',
                `date_posted`= NOW()");
}

function edit_post($id, $title, $contents, $category, $mysqli){
    $id         = (int)$id;
    $title      = $mysqli->real_escape_string($title);
    $contents   = $mysqli->real_escape_string($contents);
    $category   = (int)$category;
    
    $mysqli->query("UPDATE `posts` SET
                `cat_id`     = {$category},
                `title`      = '{$title}',
                `contents`   = '{$contents}'
                WHERE `id` = {$id}");
}

function add_category($mysqli, $name){
    $name = $mysqli->real_escape_string($name);
  
    $mysqli->query("INSERT INTO `categories` SET `name` = '{$name}'");
}

function delete($table, $id, $mysqli){
    $table = $mysqli->real_escape_string($table);
    $id    = (int)$id;
    
    $mysqli->query("DELETE FROM `{$table}` WHERE `id`= {$id} ");
}

function get_posts($mysqli, $id = null, $cat_id = null){
    $posts = array();
    $query = "SELECT
              `posts`.`id` AS `post_id` ,
               `categories`.`id` AS `category_id`,
               `title`,`contents`,`date_posted`,
               `categories`.`name`
               FROM `posts`
               INNER JOIN `categories` ON `categories`.`id` = `posts`.`cat_id` " ;
    if(isset($id)){
        $id = (int)$id;
        $query .= " WHERE `posts`.`id` = {$id} ";
    }
    if(isset($cat_id)){
        $cat_id = (int)$cat_id;
        $query .= " WHERE `cat_id` = {$cat_id} ";
    }
        
    $query .= "ORDER BY `post_id` DESC";
    
    $result = $mysqli->query($query);
    
    while($row = $result->fetch_assoc()){
        $posts[] = $row;
    }
    return $posts;
}

function get_categories($mysqli, $id = null){
    $categories = array();
   
    $query = $mysqli->query("SELECT `id`,`name` FROM `categories`");
   
    while($row = $query->fetch_assoc()){
        $categories[] = $row;
    }
   
    return $categories;
}

function category_exists($mysqli, $field, $name){
    $name = $mysqli->real_escape_string($name);
    $field = $mysqli->real_escape_string($field);
    
    $query = $mysqli->query("SELECT COUNT(1) FROM categories WHERE `{$field}` = '{$name}'");
    
    return ($query->fetch_row()[0] == 0) ? false : true;
}
<?php

    require_once './core.inc.php';
    require_once './dbconnect.inc.php';

    if(is_logged_in() && isset($_POST['unique_id']) && !empty($_POST['unique_id']) && isset($_POST['type']) && !empty($_POST['type']) && isset($_POST['message']) && !empty($_POST['message']))
    {
        if($_POST['type'] == 'comment') {
            $table = 'comment';
        } else if($_POST['type'] == 'reply') {
            $table = 'reply';
        } else {
            return NULL;
        }

        $user_id = user_id();
        $id = $_POST['unique_id'];
        $message = $_POST['message'];

        # QUERY
        $query = "SELECT `id` FROM `" . $table . "` WHERE `" . $table ."`.`id` = '" . mysqli_real_escape_string($dbconnection, $id) ."' AND `" . $table ."`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

        $result = mysqli_query($dbconnection, $query);
        $result_rows = mysqli_num_rows($result);

        if($result_rows == 1)
        {
            # QUERY
            $query = "UPDATE `" . $table . "` SET `message` = '" . mysqli_real_escape_string($dbconnection, $message) . "' WHERE `" . $table . "`.`id` = '" . mysqli_real_escape_string($dbconnection ,$id) . "'";

            $result = mysqli_query($dbconnection, $query);

            if($result)
                echo '{"comment":"edited"}';
            else 
                echo '{"comment":"not edited"}';
        }

    } else {
        return NULL;
    }
?>
<?php
require('../app/app.php');

$data = [];  // Initialize an empty array to store response data
session_start();

if (isset($_POST['type'], $_POST['postID'])) {
    $type = $_POST['type'];
    $postID = $_POST['postID'];

    if ($type === 'add' && user_logged()) {
        Data::put_favourite($_SESSION['login'], $postID, 1);

    }else if($type === 'delete' && user_logged()){
        Data::delete_favourite($_SESSION['login'], $postID, -1);
    }

} else {
    $data['error'] = 'Missing type or postID in the request.';
}
session_write_close();
echo json_encode($data);
?>

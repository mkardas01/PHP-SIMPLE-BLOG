<?php
function view($name, $model = '', $diffCss = null){
    global $view_bag;
    require ("views/layout.view.php");
}

function redirect($url){
    header("Location: $url.php");
    die();
}

function user_logged(){
    return isset($_SESSION['login']);
}

function send_status($message, $color = 'text-danger', $redirect = false){
    $data['status'] = $message;
    $data['text-color'] = $color;
    $data['redirect'] = $redirect;
    echo json_encode($data);
    session_write_close();
    die();
}

function prepare_comments($comments, $login){

    $preparedComments = [];  // Initialize the array
    $preparedID = [];  // Initialize the array
    

    foreach($comments as $comment){
         $commentHTML = "
            <div id=\"c{$comment['CommentID']}\" class=\"comment\" >
                <span class=\"user-name\"><i class=\"fa-regular fa-user\"></i> {$comment['login']} |</span>
                <span class=\"date\"> {$comment['date']}</span>
                <p class=\"pcomment\">{$comment['comment']}</p>";

        
        if ((!empty($login) && $comment['login'] == $login) || isset($_SESSION['admin']) ) {
            $editButton = '<i class="editButton fa-solid fa-pen-to-square" data-commentid="' . $comment['CommentID'] . '"></i>';
            $deleteButton = '<i class="deleteButton fa-solid fa-trash" data-commentid="' . $comment['CommentID'] . '"></i>';
            
            $commentHTML .= $editButton;
            $commentHTML .= $deleteButton;
        }
                       

        $commentHTML .= '</div>';

        array_push($preparedComments, $commentHTML);
        array_push($preparedID, $comment['CommentID']);

    }
    
    return [
        'comments' => $preparedComments,
        'ID' => $preparedID
    ];
}
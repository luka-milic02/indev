<?php

//Login Functions
function secure() {
    // Check if the session ID is set (indicating the user is logged in)
    if (!isset($_SESSION['id'])) {
        set_message('Please, log in first!');  // Set the message
        header('Location: secure.php');         // Redirect to login page
        exit();                                // Stop further script execution
    }
};


function set_message($message){
    {
        $_SESSION['message'] = $message;
    }
};

function get_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
};

?>
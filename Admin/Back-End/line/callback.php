<?php
session_start();

include_once('./LineLogin.php');

$line = new LineLogin();
$get = $_GET;

// Check if the "code" and "state" parameters are set
if (isset($get['code']) && isset($get['state'])) {
    $code = $get['code'];
    $state = $get['state'];

    $token = $line->token($code, $state);

    // Check if the token retrieval was successful
    if (is_object($token) && property_exists($token, 'error')) {
        $errorMessage = $token->error_description;
        // Display the error message on the callback.php page
        echo "Error: $errorMessage";
        exit();
    }
    if ($token && isset($token->id_token)) {
        $profile = $line->profileFormIdToken($token);
        $_SESSION['profile'] = $profile;
        header('Location: ../../pages/broadcast.php?treeview=3.3&menu=3');
        exit();
    }
}

// If the code reaches this point, there might be an unexpected situation
header('Location: index.php');
exit();
?>

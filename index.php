<?php
header("Content-Type: application/json;charset=utf-8");
header('Cache-Control: no-cache, must-revalidate');

// user stored successfully
if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];
    // include db handler
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();
    // response Array
    $response = array('tag' => $tag, 'error' => FALSE);
    // check for tag type
    if ($tag == 'login') {
        // Request type is check Login
        $email = $_POST['email'];
        $password = $_POST['password'];
        // check for user
        $user = $db->getUserByEmailAndPassword($email, $password);
        if ($user != false) {
            // user found
            $response['error'] = FALSE;
            $response['id'] = $user['id'];
            $response['user']['uid'] = $user['unique_id'];
            $response['user']['chatuid'] = $user['chatuid'];
            $response['user']['name'] = $user['name'];
            $response['user']['email'] = $user['email'];
            $response['user']['password'] = $user['encrypted_password'];
            $response['user']['created_at'] = $user['created_at'];
            $response['user']['updated_at'] = $user['updated_at'];
			header("Content-Length: " . strlen(json_encode($response)), true);
            echo json_encode($response);
        } else {
            // user not found
            // echo json with error = 1
            $response['error'] = TRUE;
            $response['error_msg'] = 'Incorrect email or password!';
			header("Content-Length: " . strlen(json_encode($response)), true);	
            echo json_encode($response);
        }
    } else if ($tag == 'register') {
        //Request type is Register new user
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        //check if user is already existed
        if ($db->isUserExisted($email)) {
            //user is already existed - error response
            $response['error'] = TRUE;
            $response['error_msg'] = 'User already existed';
			header("Content-Length: " . strlen(json_encode($response)), true);
            echo json_encode($response);
        } else {
            //store user
            $user = $db->storeUser($name, $email, $password);
            if ($user) {		
                //user stored successfully
                $response['error'] = FALSE;
                $response['user']['name'] = $user['name'];
                $response['user']['email'] = $user['email'];
                $response['user']['created_at'] = $user['created_at'];
                $response['user']['updated_at'] = $user['updated_at'];
				header("Content-Length: " . strlen(json_encode($response)), true);
                echo json_encode($response);
            } else {
                //user failed to store
                $response['error'] = TRUE;
                $response['error_msg'] = 'Error occured in Registration';
				header("Content-Length: " . strlen(json_encode($response)), true);
                //echo json_encode($response);
            }
        }
    } else {
        // user failed to store
        $response['error'] = TRUE;
        $response['error_msg'] = 'Unknow "tag" value. It should be either "login" or "register"';
		header("Content-Length: " . strlen(json_encode($response)), true);
        echo json_encode($response);
    }
} else {
    $response['error'] = TRUE;
    $response['error_msg'] = 'Required parameter "tag" is missing!';
	header("Content-Length: " . strlen(json_encode($response)), true);
    echo json_encode($response);
}
?>

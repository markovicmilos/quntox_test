<?php
namespace App\Controllers;

require 'vendor/mustache/mustache/src/Mustache/Autoloader.php';
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\Capsule\Manager as Capsule;
use Respect\Validation\Validator as validator;
use Respect\Validation\Exceptions\NestedValidationException;



class UserController extends Controller
{

    private $view;

    public function __construct()
    {
        session_start();
    }


    public function login()
    {
        if(!($valitation_result = $this->validateLogin($_POST))){
            if(($user = $this->checkAuth($_POST))){
                $_SESSION['active'] = true;
                return json_encode(['user' => $user[0]->name]);
            }else{
                return 'Error logging';
            }
        }else{
            return $this->prepareValidationErrors($valitation_result);
        }
    }

    public function logout()
    {
        session_unset('active');
    }

    public function register()
    {


        if(!($valitation_result = $this->validateRegistration($_POST))){
            if($this->isEmailUnique($_POST['email'])){
                $user = Capsule::table('users')->insert(
                    [
                        'email' => htmlspecialchars($_POST['email']),
                        'name' => htmlspecialchars($_POST['name']),
                        'password' => sha1($_POST['password']),
                    ]
                );
            }else{
                echo 'email is already taken';
            }
        }else{
            return $this->prepareValidationErrors($valitation_result);
        }
    }

    public function searchUser()
    {
        $this->checkValidSession();
        if(!is_null($search = $_POST['search']))
        {
            $result = Capsule::table('users')->select('name', 'email')->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%")->get();
            if(empty($result)){
                return 'Found 0 users.';
            }else{
                return json_encode($result);
            }
        }
    }

    private function validateRegistration($input)
    {
        $registerRequest = validator::key('email', validator::email())
            ->key('name', validator::stringType()->length(2,32))
            ->key('password', validator::stringType()->length(8,32))
            ->key('confirm_password', validator::equals($input['password']));

        if($registerRequest->validate($input) === false){
            try {
                $registerRequest->assert($input);
            } catch(NestedValidationException $exception) {
                return $exception->getMessages();
            }
        }else{
            return false;
        }
    }

    private function validateLogin($input)
    {
        $registerRequest = validator::key('email', validator::email())
            ->key('password', validator::stringType()->length(8,32));

        if($registerRequest->validate($input) === false){
            try {
                $registerRequest->assert($input);
            } catch(NestedValidationException $exception) {
                return $exception->getMessages();
            }
        }else{
            return false;
        }
    }

    private function isEmailUnique($email)
    {
        $result = Capsule::table('users')->where('email', $email)->get();
        if(empty($result))
            return true;
        else
            return false;
    }

    private function checkAuth($input)
    {
        $result = Capsule::table('users')->where('email', $input['email'])->where('password', sha1($input['password']))->get();
        if(!empty($result))
            return $result;
        else
            return false;
    }

    private function prepareValidationErrors($errors)
    {
        $html = "";
        foreach($errors as $error){
            $html .= '<p>' . $error . '</p>';
        }
        return $html;
    }

    private function checkValidSession()
    {
        if(!isset($_SESSION['active'])){
            echo 'Please login';
            exit;
        }
    }
}
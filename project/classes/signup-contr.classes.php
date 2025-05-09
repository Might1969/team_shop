<?php

class SignupContr extends Signup{
    private $uid;
    private $pwd;
    private $pwdRepeat;
    private $email;
    
    public function __construct($uid, $pwd, $pwdRepeat, $email) {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;
    }
    
    public function signupUser(){
        if($this->notEmptyInput() == false){
            //echo "Empty input!";
            header("location: ../index.php?error=emptyinput");
            exit();
        }
        if($this->validUid() == false){
            //echo "Invalid Uid!";
            header("location: ../index.php?error=invalidusername");
            exit();
        }
        if($this->validEmail() == false){
            //echo "Invalid email!";
            header("location: ../index.php?error=invalidemail");
            exit();
        }
        if($this->pwdMatch() == false){
            //echo "password not match!";
            header("location: ../index.php?error=passwordnotmatch");
            exit();
        }
        if($this->userNotAlreadySign() == false){
            //echo "user already sign!";
            header("location: ../index.php?error=useralreadysign");
            exit();
        }
        
        $this->setUser($this->uid, $this->pwd, $this->email);
    }
    
    private function notEmptyInput(){
        $result;
        if(empty($this->uid) || empty($this->pwd) || empty($this->pwdRepeat) || empty($this->email)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }
    
    private function validUid(){
        $result;
        if(preg_match("/^[a-zA-Z0-9]*$/", $this->uid)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    
    private function validEmail(){
        $result;
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    
    private function pwdMatch(){
        $result;
        if($this->pwd == $this->pwdRepeat){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    
    private function userNotAlreadySign(){
        $result;
        if(!$this->userExist($this->uid, $this->email)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
}
?>

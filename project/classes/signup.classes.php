<?php

class Signup extends Dbh{
    
    protected function userExist($uid, $email){
        $stmt = $this->connect()->prepare('SELECT users_uid 
FROM users WHERE users_uid = ? OR users_email = ?;');
        
        if(!$stmt->execute(array($uid,$email))){
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        $resultCheck;
        if($stmt->rowCount() > 0){
            $resultCheck = true;          
        }
        else{
            $resultCheck = false;
        }        
        return $resultCheck;
    }
    
    protected function setUser($uid, $pwd, $email){
        $stmt = $this->connect()->prepare(
            'INSERT INTO users (users_uid, users_pwd, users_email) 
             VALUES (?,?,?);');
        
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        
        if(!$stmt->execute(array($uid, $hashedPwd, $email))){
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
}
?>

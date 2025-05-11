<?php
if (isset($_POST['signup-submit'])) {
    require 'dbh.inc.php';

    $username = $_POST['uid'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];

    // 错误处理
    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
        header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invaliduidmail");
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invaliduid&mail=".$email);
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidmail&uid=".$username);
        exit();
    } elseif ($password !== $passwordRepeat) {
        header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
        exit();
    } else {
        // 检查用户名是否已存在
        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCount = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);

        if ($resultCount > 0) {
            header("Location: ../signup.php?error=usertaken&mail=".$email);
            exit();
        } else {
            // 开始事务
            mysqli_begin_transaction($conn);

            try {
                // 插入用户
                $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    throw new Exception("SQL error");
                }

                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
                mysqli_stmt_execute($stmt);
                $userId = mysqli_insert_id($conn); // 获取新用户ID

                // 插入空profile
                $sqlProfile = "INSERT INTO profiles (profiles_about, profiles_introtitle, profiles_introtext, users_id) 
                              VALUES (?, ?, ?, ?)";
                $stmtProfile = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmtProfile, $sqlProfile)) {
                    throw new Exception("SQL error");
                }

                $empty = '';
                mysqli_stmt_bind_param($stmtProfile, "sssi", $empty, $empty, $empty, $userId);
                mysqli_stmt_execute($stmtProfile);

                // 提交事务
                mysqli_commit($conn);

                header("Location: ../signup.php?signup=success");
                exit();
            } catch (Exception $e) {
                // 回滚事务
                mysqli_rollback($conn);
                header("Location: ../signup.php?error=sqlerror");
                exit();
            } finally {
                // 清理资源
                if (isset($stmt)) mysqli_stmt_close($stmt);
                if (isset($stmtProfile)) mysqli_stmt_close($stmtProfile);
                mysqli_close($conn);
            }
        }
    }
} else {
    header("Location: ../signup.php");
    exit();
}
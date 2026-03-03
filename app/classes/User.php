<?php
ob_start();

class User extends Objects {
	protected $pdo;

	// construct $pdo
	function __construct($pdo) {
		$this->pdo = $pdo;
	}

	// user login method to dashboard
	public function login($email, $pass) {
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE username = :username");
		$stmt->bindValue(":username", $email, PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_OBJ);
		
		if ($user) {
            // Check password
            $passwordValid = false;
            $rehash = false;

            // Check if password is MD5 (legacy)
            if (strlen($user->password) === 32 && md5($pass) === $user->password) {
                $passwordValid = true;
                $rehash = true; // Upgrade to bcrypt
            } 
            // Check if password is hash
            else if (password_verify($pass, $user->password)) {
                $passwordValid = true;
                if (password_needs_rehash($user->password, PASSWORD_DEFAULT)) {
                    $rehash = true;
                }
            }

            if ($passwordValid) {
                if (session_status() === PHP_SESSION_ACTIVE) {
                    session_regenerate_id(true);
                }
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_role'] = $user->user_role;
                $_SESSION['user_name'] = $user->username;

                // Upgrade password hash if needed
                if ($rehash) {
                    $newHash = password_hash($pass, PASSWORD_DEFAULT);
                    $update = $this->pdo->prepare("UPDATE user SET password = :pass WHERE id = :id");
                    $update->bindValue(":pass", $newHash, PDO::PARAM_STR);
                    $update->bindValue(":id", $user->id, PDO::PARAM_INT);
                    $update->execute();
                }

                redirect("index.php?page=dashboard");
                return true;
            }
		}
        
        $_SESSION['login_error'] = "Invalid Email or Password";
        redirect("login.php");
        return false;
	}

	public function is_admin(){
		if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
			return true;
		} else {
			return false;
		}
	}

	public function redirect_unauth_users($page){
		if ($this->is_admin()) {
			return true;
		} else {
			redirect($page);
		}
	}

	//is user loged in or not
	public function is_login() {
		return !empty($_SESSION['user_id']);
	}


	public function logOut() {
		unset($_SESSION['user_id']);
		unset($_SESSION['user_role']);
        unset($_SESSION['user_name']);
		$_SESSION = array();
		if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
		redirect("login.php");
	}

	public function checkUser($username)
	{
	  $stmt = $this->pdo->prepare("SELECT username FROM user WHERE username = :username");
	  $stmt->bindParam(":username", $username, PDO::PARAM_STR);
	  $stmt->execute();
	  $count = $stmt->rowCount();
	  return ($count > 0);
	}


	//check email if it is alrady sign up (mapped to username)
	public function checkEmail($email)
	{
	  return $this->checkUser($email);
	}

    // Logs table might not exist in ample.sql, removing or keeping basic
	public function userLog(){
        // Check if logs table exists first or return empty
        try {
		    $stmt = $this->pdo->prepare("SELECT * FROM logs ORDER BY id DESC LIMIT 5");
		    $stmt->execute();
		    return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            return [];
        }
	}
}

ob_end_clean();
?>

<?php
session_start();
 
class AuthClass {
    private $_login = "user";
    private $_password = "qwerty";

    public function isAuth() {
        if (isset($_SESSION["is_auth"])) {
            return $_SESSION["is_auth"];
        }
        else return false;
    }
    public function auth($login, $passwors) {
        if ($login == $this->_login && $passwors == $this->_password) {
            $_SESSION["is_auth"] = true;
            $_SESSION["login"] = $login;
            return true;
        }
        else {
            $_SESSION["is_auth"] = false;
            return false; 
        }
    }
    public function getLogin() {
        if ($this->isAuth()) {
            return $_SESSION["login"];
        }
    }
    public function out() {
        $_SESSION = array();
        session_destroy();
    }
}

$auth = new AuthClass();

if (isset($_POST["login"]) && isset($_POST["password"])) {
    if (!$auth->auth($_POST["login"], $_POST["password"])) {
        echo "<h2>Invalid login or password</h2>";
    }
}

if (isset($_GET["is_exit"])) {
    if ($_GET["is_exit"] == 1) {
        $auth->out();
        header("Location: ShoppingTerminal.php");
    }
}
?>

<?php if ($auth->isAuth()) {  
    echo "You are signed as, " . $auth->getLogin();
    echo "<br/><br/><a href=\"?is_exit=1\">Continue</a>";
}
else {
?>
<form method="post" action="">
    Login: <input type="text" name="login" value="<?php echo (isset($_POST["login"])) ? $_POST["login"] : null;?>" /><br/>
    Password: <input type="password" name="password" value="" /><br/>
    <input type="submit" value="Sign in" />
</form>
<?php } ?>
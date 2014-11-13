<?php
/**
 * Created by PhpStorm.
 * User: sonbv
 * Date: 06/11/2014
 * Time: 19:20
 */
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
//include 'vendor/autoload.php';
include 'ExecCommand.php';

define('SERVER', 'local');
define('HOSTNAME', 'xd.smartosc.com');
define('USERNAME', 'xdc1xpos');
define('PASSWORD', 'lrOKkT#98');

$exec = ExecCommand::getInstance();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="" method="POST">
    <input type="text" name="commands" placeholder="Command here"/>
    <input type="submit" value="Deploy"/>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <pre>
    <?php
    if (isset($_POST['commands']) && ('' != trim($_POST['commands']))) {
        $exec->addCommand($_POST['commands']);
    } else {
        $exec->addCommand('pwd;');
    }
    try {
        echo $exec->run();
        echo "\nFinnish!!!!!!!!!!!!!";
    } catch (Exception $e) {
        echo "\nError!!!!!!!!!!!!\n";
        echo $e->getMessage();
    }
    ?>
</pre>
<?php endif ?>
</body>
</html>


<?php
/**
 * Created by PhpStorm.
 * User: sonbv
 * Date: 13/11/2014
 * Time: 14:46
 */
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'App.php';
use SonBV\App;
App::run();

?>
<div class="ui modal">
    <i class="close icon"></i>
    <div class="header">
        Report
    </div>
    <div class="content">
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?php
            try {
                $branch = '';
                if (isset($_POST['branch']) && !empty($_POST['branch'])) {
                    $branch = $_POST['branch'];
                }
                $gitCheckoutMessage = App::getGit()->checkOutBranch($branch);
                $currentBranch = App::getGit()->getCurrentBranch();

               ?>
                <h3 class="ui dividing header">Git update</h3>
                <p><?php echo 'Current branch: ' . $currentBranch; ?></p>
                <code><?php echo $gitCheckoutMessage ?></code>

            <?php
            } catch (Exception $e) { ?>
                <h3 class="ui dividing header">Warring</h3>
                <pre><?php echo $e->getMessage() ?></pre>
            <?php }
            ?>
        <?php else: ?>
            <h3 class="ui dividing header">No content</h3>
            <p>No content post from client</p>
        <?php endif; ?>
    </div>
    <div class="actions">
        <div class="ui button">
            Okay
        </div>
    </div>
</div>

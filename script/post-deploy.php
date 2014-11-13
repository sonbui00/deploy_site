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
                $gitPullMessage = App::getGit()->pull($branch);
                $currentBranch = App::getGit()->getCurrentBranch();

                $clearCacheMessages = array();
                if (isset($_POST['clear_cache'])) {
                    foreach ($_POST['clear_cache'] as $code) {
                        $clearCacheMessages[$code] = App::clearCache($code);
                    }
                }
            ?>
            <h3 class="ui dividing header">Git update</h3>
            <p><?php echo 'Current branch: ' . $currentBranch; ?></p>
            <code><?php echo $gitPullMessage ?></code>

            <?php if (!empty($clearCacheMessages)): ?>
            <h3 class="ui dividing header">Clear Cache</h3>
            <div class="ui divided list">
                <?php foreach ($clearCacheMessages as $code => $message): ?>
                <div class="item">
                    <div class="content">
                        <div class="header">Clear cache for <?php echo strtoupper($code) ?></div>
                        <p><code><?php echo $message ?></code></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        <?php
        } catch (Exception $e) { ?>
            <h3 class="ui dividing header">Error</h3>
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

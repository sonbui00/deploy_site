<?php
/**
 * Created by PhpStorm.
 * User: sonbv
 * Date: 13/11/2014
 * Time: 11:02
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'App.php';
use SonBV\App;
App::run();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deploy site</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.19.3/css/semantic.min.css"/>
    <link rel="stylesheet" href="assets/css/sweet-alert.css"/>
</head>
<body>
    <div class="ui form segment">
        <form id="git-form" action="script/post-git.php" method="POST" class="ui form segment">
            <h2 class="ui dividing header">Git</h2>
            <h4 class="ui header">Current Branch:</h4>
            <p><?php echo App::getGit()->getCurrentBranch(); ?></p>
            <div class="inline fields">
                <div class="field">
                    <div class="ui selection dropdown">
                        <input type="hidden" name="branch">
                        <div class="default text">Select other Branch</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <?php foreach (App::getGit()->getOtherBranches() as $branch): ?>
                                <div class="item" data-value="<?php echo $branch ?>"><?php echo $branch ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <button type="submit" class="ui blue submit button">Switch branch</button>
                </div>
            </div>
            <div class="ui error message"></div>
        </form>
        <form id="deploy-form" action="script/post-deploy.php" method="POST" class="ui form segment">
                <h2 class="ui dividing header">Pull Code and Clear Cache</h2>
                <div class="inline field">
                    <div class="ui toggle checkbox">
                        <input type="checkbox" name="clear_cache[]" value="ce18" checked>
                        <label>Clear cache in CE18</label>
                    </div>
                </div>
                <div class="inline field">
                    <div class="ui toggle checkbox">
                        <input type="checkbox" name="clear_cache[]" value="ce19" checked>
                        <label>Clear cache in CE19</label>
                    </div>
                    <label></label>
                </div>
                <div class="inline field">
                    <div class="ui toggle checkbox">
                        <input type="checkbox" name="clear_cache[]" value="ee13" checked>
                        <label>Clear cache in EE13</label>
                    </div>
                </div>
                <div class="inline field">
                    <div class="ui toggle checkbox">
                        <input type="checkbox" name="clear_cache[]" value="ee14" checked>
                        <label>Clear cache in EE14</label>
                    </div>
                </div>
            <button type="submit" class="ui blue submit button">Update</button>
        </form>
    </div>

<div id="ajax-report">

</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.19.3/javascript/semantic.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
<script src="assets/js/sweet-alert.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
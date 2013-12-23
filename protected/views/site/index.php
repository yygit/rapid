<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

    <h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i> (<span id="browser_version" style="color:red;"><?php echo Yii::app()->user->getState('mobile')?'mobile':'desktop';?></span>)</h1>

    <p>Congratulations! You have successfully created your Yii application.</p>

    <p>You may change the content of this page by modifying the following two files:</p>
    <ul>
        <li>View file: <code><?php echo __FILE__; ?></code></li>
        <li>Layout file: <code><?php echo $this->getLayoutFile($this->layout); ?></code></li>
    </ul>

<?php
/*    Yii::app()->clientScript->registerScript('showversion', "
        if (isMobileBrowser(navigator.userAgent||navigator.vendor||window.opera)) {
            // alert('Mobile');
            document.getElementById('browser_version').innerHTML='Mobile browser detected';
        }
        else {
            // alert('Non-Mobile');
            document.getElementById('browser_version').innerHTML='Desktop browser detected';
        }
    ", CClientScript::POS_READY);
*/?>

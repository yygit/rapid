<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>

    <?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/detectmobilebrowser.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/url_param_proc.js');
    Yii::app()->clientScript->registerScript('detectmobilebrowser', "
        if (isMobileBrowser(navigator.userAgent||navigator.vendor||window.opera)) {
            var param_array = get_param_array();
            if (!('mobile' in param_array)) {
                param_array['mobile'] = 'on';
                window.location.replace(get_base_uri() + build_query_string(param_array));
            }
        }
    ", CClientScript::POS_READY);
    ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div>
    <!-- header -->

    <div id="mainmenu">
        <?php
        $this->widget('application.components.YiiSmartMenu', array(
            'activeCssClass' => 'active',
            'activateParents' => true,
            'items' => array(
                array('label' => 'Home', 'url' => array('/site/index'), 'visible' => true),
                array('label' => 'Turn on mobile view', 'url' => array('', 'mobile' => 'on'), 'visible' => 'true'),
                array(
                    'label' => 'Comic Books',
                    'url' => array('/book'),
                    'items' => array(
                        array('label' => 'Publishers', 'url' => array('/publisher'), 'authItemName' => 'managePublisher', 'itemOptions' => array('class' => 'item')),
                        array('label' => 'WishList', 'url' => array('/wish'), 'authItemName' => 'manageWish', 'itemOptions' => array('class' => 'item')),
                        array('label' => 'Library', 'url' => array('/library'), 'authItemName' => 'borrower', 'itemOptions' => array('class' => 'item')),
                    ),
                    'authItemName' => 'WishlistAccess',
                ),
                array('label' => 'Edit Profile', 'url' => array('/user/update', 'id' => Yii::app()->user->getId()), 'authItemName' => 'UpdateOwnUser', 'authParams' => array('id' => Yii::app()->user->getId())),
                array(
                    'label' => 'APIs',
                    'url' => array('/'),
                    'items' => array(
                        array('label' => 'Google+ Feed', 'url' => array('/gpf/index'), 'authItemName' => 'viewer', 'itemOptions' => array('class' => 'item tall40')),
                        array('label' => 'Comic Vine', 'url' => array('/cv/index'), 'authItemName' => 'viewer', 'itemOptions' => array('class' => 'item')),
                    ),
                    'authItemName' => 'viewer',
                    'linkOptions' => array('onclick' => 'return false;'),
                ),
                array(
                    'label' => 'Games',
                    'url' => array('/'),
                    'items' => array(
                        array(
                            'label' => 'Play',
                            'url' => array('/hangman/token'),
                            'authItemName' => 'viewer',
                            'itemOptions' => array('class' => 'item')
                        ),
                        array(
                            'label' => 'Hangman - New Game',
                            'url' => array('/hangman/create'),
                            'authItemName' => 'admin',
                            'itemOptions' => array('class' => 'item tall60'),
                        ),
                        array(
                            'label' => 'WroteIt - New Game',
                            'url' => array('/wroteit/create'),
                            'authItemName' => 'admin',
                            'itemOptions' => array('class' => 'item'),
                        ),
                    ),
                    'authItemName' => 'viewer',
                    'linkOptions' => array('onclick' => 'return false;'),
                ),
                array(
                    'label' => 'Admin',
                    'url' => array('/'),
                    'visible' => Yii::app()->user->checkAccess('Authority') || Yii::app()->user->checkAccess('manageUser') || Yii::app()->user->checkAccess('JobScheduledIndex') || Yii::app()->user->checkAccess('ReportIndex'),
                    'linkOptions' => array('onclick' => 'return false;'),
                    'items' => array(
                        array('label' => 'Srbac', 'url' => array('/srbac'), 'authItemName' => 'Authority', 'itemOptions' => array('class' => 'item')),
                        array('label' => 'Users', 'url' => array('/user'), 'authItemName' => 'manageUser', 'itemOptions' => array('class' => 'item')),
                        array('label' => 'AuditTrail', 'url' => array('/auditTrail/admin'), 'authItemName' => 'Authority', 'itemOptions' => array('class' => 'item')),
                        array('label' => 'Jobs', 'url' => array('/jobScheduled/index'), 'authItemName' => 'JobScheduledIndex', 'itemOptions' => array('class' => 'item')),
                        array('label' => 'Reports', 'url' => array('/report/index'), 'authItemName' => 'ReportIndex', 'itemOptions' => array('class' => 'item')),
                    ),
                ),
                array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
            ),
        ));
        ?>
    </div>
    <!-- mainmenu -->

    <?php if (isset($this->breadcrumbs)): ?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
    <?php endif ?>

    <?php echo $content; ?>

    <div class="clear"></div>

    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
        All Rights Reserved.<br/>
        <?php echo Yii::powered(); ?>
    </div>
    <!-- footer -->

</div>
<!-- page -->

</body>
</html>

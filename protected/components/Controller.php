<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends SBaseController{
//class Controller extends CController{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();


    /**
     * Override beforeAction() to change to the mobile layout if URL param['mobile'] == 'on'
     */
    protected function beforeAction($action) {
        if(!parent::beforeAction($action))
            return false;
        $mobile = Yii::app()->getRequest()->getQuery('mobile');
        if ($mobile == 'on') {
            Yii::app()->user->setState('mobile', true);
        } else if ($mobile == 'off') {
            Yii::app()->user->setState('mobile', false);
        }
        if (Yii::app()->user->getState('mobile')) {
            $this->layout = '//layouts/mobile';
        }
        return true;
    }

    /**
     * if available, use different views for mobile browsers
     * @param string $viewName
     * @return string
     */
    public function getViewFile($viewName) {
        if (Yii::app()->user->getState('mobile')) {
            $newViewName = 'mobile_' . $viewName;
            $newViewFile = parent::getViewFile($newViewName);
            if($newViewFile){
                return $newViewFile;
            }
        }
        return parent::getViewFile($viewName);
    }

}

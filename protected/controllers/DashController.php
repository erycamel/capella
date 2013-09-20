<?php

/**
 * @author Serg.Kosiy <serg.kosiy@gmail.com>
 */
class DashController extends UIDashboardController
{
    // uncomment the following to apply new layout for the controller view.
    //public $layout = '//layouts/column2';

    public function init()
    {
        parent::init();

        // Create new field in your users table for store dashboard preference
        // Set table name, user ID field name, user preference field name
        $this->setTableParams('dashboard_page', 'user_id', 'title');

		$model=new Usertodo('search');
		$model1=new Userinbox('search');
		$model2=new Userfav('searchwuser');

        // set array of portlets
        $this->setPortlets(
                array(
                    array('id' => 1, 'title' => 'User Favourite Menu', 'content' => $this->renderPartial('/dashportlet/viewfav', array('model'=>$model2), true)),
                    array('id' => 2, 'title' => 'To Do', 'content' => $this->renderPartial('/dashportlet/viewtodo', array('model'=>$model), true)),
                    array('id' => 3, 'title' => 'User Inbox', 'content' => $this->renderPartial('/dashportlet/viewinbox', array('model'=>$model1), true)),
                )
        );

        //set content BEFORE dashboard
        $this->setContentBefore(
                //Pay attension: ExtController looking view in current dir!!!
                //$this->renderPartial('/../views/dash/before', null, true)
                );

        //set content AFTER dashboard
        //$this->setContentAfter('<br><div align="center"><a href="http://kosiy.blogspot.com/p/donate.html">Donate next release</a></div>');

        // uncomment the following to apply jQuery UI theme
        // from protected/components/assets/themes folder
        $this->applyTheme('redmond');

        // uncomment the following to change columns count
        //$this->setColumns(4);

        // uncomment the following to enable autosave
        $this->setAutosave(true);

        // uncomment the following to disable dashboard header
        //$this->setShowHeaders(false);

        // uncomment the following to enable context menu and add needed items
        /*
        $this->menu = array(
            array('label' => 'Index', 'url' => array('index')),
        );
        */
    }

}

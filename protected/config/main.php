<?php
//require_once("../phpgrid/conf.php");

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Capella ERP Indonesia',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
    'application.controllers.*',
		'application.components.*',
	'application.extensions.OpenFlashChart2Widget.*',
	'ext.mail.YiiMailMessage',
'application.extensions.fpdf.*',
'application.extensions.IReport.*',
//'ext.EAjaxUpload.qqFileUploader',
//'ext.JasPHP.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
	  'gii'=>array(
		'class'=>'system.gii.GiiModule',
		'generatorPaths'=>array(
        'ext.giix-core'
      ),
		'password'=>'123456',
		// If removed, Gii defaults to localhost only. Edit carefully to taste.
		'ipFilters'=>array('127.0.0.1','::1'),
	  ),
	),
	// application components
	'components'=>array(
    'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
		'excel'=>array(
      'class'=>'application.extensions.PHPExcel',
    ),
    'session'=>array(
      'class' => 'system.web.CDbHttpSession',
      'connectionID' => 'db',
'autoStart' => true
    ),
	'user'=>array(
		// enable cookie-based authentication
		'allowAutoLogin'=>true,
	),
	'db'=>array(
		'connectionString' => 'mysql:host=localhost;dbname=smlive',
		'emulatePrepare' => true,
		'username' => 'smlive',
		'password' => 'smlive',
		'charset' => 'utf8',
		'initSQLs'=>array('set names utf8'),
		//'enableProfiling'=>true,
	'enableParamLogging' => true,
	'schemaCachingDuration' => 3600,
	),
	'errorHandler'=>array(
		// use 'site/error' action to display errors
		'errorAction'=>'site/error',
	),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'siskalandre@yahoo.com',
		'defaultPageSize'=>5,
		'defaultYearFrom'=>date('Y')-1,
		'defaultYearTo'=>date('Y'),
		'sizeLimit'=>10*1024*1024,
        'allowedext'=>array("xls","csv","xlsx","vsd","pdf","gdb","doc","docx","jpg","gif","png","rar","zip"),
            'language'=>1,
'defaultnumberqty'=>'#,##0.00',
'defaultnumberprice'=>'#,##0.00',
        'dateviewfromdb'=>'d-M-Y',
        'dateviewcjui'=>'dd-mm-yy',
        'dateviewgrid'=>'dd-MM-yyyy',
        'datetodb'=>'Y-m-d',
        'timeviewfromdb'=>'h:m',
        'datetimeviewfromdb'=>'d-M-Y h:i',
        'timeviewcjui'=>'h:m',
        'datetimeviewgrid'=>'dd-MM-yyyy H:m',
        'datetimetodb'=>'Y-m-d h:i',
	),
);



<?php

/**
 * This is the model class for table "usertodo".
 *
 * The followings are the available columns in table 'usertodo':
 * @property integer $usertodoid
 * @property integer $username
 * @property string $tododate
 * @property integer $menuname
 * @property string $description
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Useraccess $useraccess
 * @property Menuaccess $menuaccess
 */
class Usertodo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Usertodo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usertodo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, tododate, description, recordstatus', 'required'),
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usertodoid, username, tododate, menuname, description, recordstatus', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'usertodoid' => 'ID',
			'username' => 'User ',
			'tododate' => 'Date',
			'menuname' => 'Menu ',
			'description' => 'Description',
			'recordstatus' => 'Record Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order='tododate desc';
		$criteria->condition="username = '".Yii::app()->user->id."'";
		$criteria->compare('usertodoid',$this->usertodoid);
		$criteria->compare('useraccess.username',$this->username,true);
		$criteria->compare('tododate',$this->tododate,true);
		$criteria->compare('menuname',$this->menuname);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}

	public function behaviors()
  {
    return array(
        // Classname => path to Class
        'ActiveRecordLogableBehavior'=>
            'application.behaviors.ActiveRecordLogableBehavior'
    );
  }
}
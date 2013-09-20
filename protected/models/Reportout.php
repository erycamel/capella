<?php

/**
 * This is the model class for table "reportout".
 *
 * The followings are the available columns in table 'reportout':
 * @property integer $reportoutid
 * @property integer $employeeid
 * @property string $newnik
 * @property string $fullname
 * @property string $fulldivision
 * @property integer $month
 * @property integer $year
 * @property string $s1
 * @property string $d1
 * @property string $s2
 * @property string $d2
 * @property string $s3
 * @property string $d3
 * @property string $s4
 * @property string $d4
 * @property string $s5
 * @property string $d5
 * @property string $s6
 * @property string $d6
 * @property string $s7
 * @property string $d7
 * @property string $s8
 * @property string $d8
 * @property string $s9
 * @property string $d9
 * @property string $s10
 * @property string $d10
 * @property string $s11
 * @property string $d11
 * @property string $s12
 * @property string $d12
 * @property string $s13
 * @property string $d13
 * @property string $s14
 * @property string $d14
 * @property string $s15
 * @property string $d15
 * @property string $s16
 * @property string $d16
 * @property string $s17
 * @property string $d17
 * @property string $s18
 * @property string $d18
 * @property string $s19
 * @property string $d19
 * @property string $s20
 * @property string $d20
 * @property string $s21
 * @property string $d21
 * @property string $s22
 * @property string $d22
 * @property string $s23
 * @property string $d23
 * @property string $s24
 * @property string $d24
 * @property string $s25
 * @property string $d25
 * @property string $s26
 * @property string $d26
 * @property string $s27
 * @property string $d27
 * @property string $s28
 * @property string $d28
 * @property string $s29
 * @property string $d29
 * @property string $s30
 * @property string $d30
 * @property string $s31
 * @property string $d31
 */
class Reportout extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Reportout the static model class
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
		return 'reportout';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, newnik, fullname, fulldivision, month, year, s1, d1, s2, d2, s3, d3, s4, d4, s5, d5, s6, d6, s7, d7, s8, d8, s9, d9, s10, d10, s11, d11, s12, d12, s13, d13, s14, d14, s15, d15, s16, d16, s17, d17, s18, d18, s19, d19, s20, d20, s21, d21, s22, d22, s23, d23, s24, d24, s25, d25, s26, d26, s27, d27, s28, d28, s29, d29, s30, d30, s31, d31', 'required'),
			array('employeeid, month, year', 'numerical', 'integerOnly'=>true),
			array('newnik, fullname', 'length', 'max'=>50),
			array('fulldivision', 'length', 'max'=>500),
			array('s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, d12, s13, s14, s15, s16, s17, s18, s19, s20, s21, s22, s23, s24, s25, s26, s27, s28, s29, s30, s31, d31', 'length', 'max'=>5),
			array('d1, d2, d3, d4, d5, d6, d7, d8, d9, d10, d11, d13, d14, d15, d16, d17, d18, d19, d20, d21, d22, d23, d24, d25, d26, d27, d28, d29, d30', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reportoutid, employeeid, newnik, fullname, fulldivision, month, year', 'safe', 'on'=>'search'),
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
			'reportoutid' => 'ID',
			'employeeid' => 'Employee',
			'newnik' => 'Newnik',
			'fullname' => 'Name ',
			'fulldivision' => 'Fulldivision',
			'month' => 'Month',
			'year' => 'Year',
			's1' => 'S1',
			'd1' => '1',
			's2' => 'S2',
			'd2' => '2',
			's3' => 'S3',
			'd3' => '3',
			's4' => 'S4',
			'd4' => '4',
			's5' => 'S5',
			'd5' => '5',
			's6' => 'S6',
			'd6' => '6',
			's7' => 'S7',
			'd7' => '7',
			's8' => 'S8',
			'd8' => '8',
			's9' => 'S9',
			'd9' => '9',
			's10' => 'S10',
			'd10' => '10',
			's11' => 'S11',
			'd11' => '11',
			's12' => 'S12',
			'd12' => '12',
			's13' => 'S13',
			'd13' => '13',
			's14' => 'S14',
			'd14' => '14',
			's15' => 'S15',
			'd15' => '15',
			's16' => 'S16',
			'd16' => '16',
			's17' => 'S17',
			'd17' => '17',
			's18' => 'S18',
			'd18' => '18',
			's19' => 'S19',
			'd19' => '19',
			's20' => 'S20',
			'd20' => '20',
			's21' => 'S21',
			'd21' => '21',
			's22' => 'S22',
			'd22' => '22',
			's23' => 'S23',
			'd23' => '23',
			's24' => 'S24',
			'd24' => '24',
			's25' => 'S25',
			'd25' => '25',
			's26' => 'S26',
			'd26' => '26',
			's27' => 'S27',
			'd27' => '27',
			's28' => 'S28',
			'd28' => '28',
			's29' => 'S29',
			'd29' => '29',
			's30' => 'S30',
			'd30' => '30',
			's31' => 'S31',
			'd31' => '31',
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

		$criteria->compare('reportoutid',$this->reportoutid);
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('newnik',$this->newnik,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('fulldivision',$this->fulldivision,true);
		$criteria->compare('month',$this->month);
		$criteria->compare('year',$this->year);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
}
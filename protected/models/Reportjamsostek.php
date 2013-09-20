<?php

/**
 * This is the model class for table "reportjamsostek".
 *
 * The followings are the available columns in table 'reportjamsostek':
 * @property integer $reportjamsostekid
 * @property integer $employeeid
 * @property string $oldnik
 * @property string $newnik
 * @property string $fullname
 * @property string $fulldivision
 * @property integer $month
 * @property integer $year
 * @property integer $sc1
 * @property string $s1
 * @property string $d1
 * @property integer $sc2
 * @property string $s2
 * @property string $d2
 * @property integer $sc3
 * @property string $s3
 * @property string $d3
 * @property integer $sc4
 * @property string $s4
 * @property string $d4
 * @property integer $sc5
 * @property string $s5
 * @property string $d5
 * @property integer $sc6
 * @property string $s6
 * @property string $d6
 * @property integer $sc7
 * @property string $s7
 * @property string $d7
 * @property integer $sc8
 * @property string $s8
 * @property string $d8
 * @property integer $sc9
 * @property string $s9
 * @property string $d9
 * @property integer $sc10
 * @property string $s10
 * @property string $d10
 * @property integer $sc11
 * @property string $s11
 * @property string $d11
 * @property integer $sc12
 * @property string $s12
 * @property string $d12
 * @property integer $sc13
 * @property string $s13
 * @property string $d13
 * @property integer $sc14
 * @property string $s14
 * @property string $d14
 * @property integer $sc15
 * @property string $s15
 * @property string $d15
 * @property integer $sc16
 * @property string $s16
 * @property string $d16
 * @property integer $sc17
 * @property string $s17
 * @property string $d17
 * @property integer $sc18
 * @property string $s18
 * @property string $d18
 * @property integer $sc19
 * @property string $s19
 * @property string $d19
 * @property integer $sc20
 * @property string $s20
 * @property string $d20
 * @property integer $sc21
 * @property string $s21
 * @property string $d21
 * @property integer $sc22
 * @property string $s22
 * @property string $d22
 * @property integer $sc23
 * @property string $s23
 * @property string $d23
 * @property integer $sc24
 * @property string $s24
 * @property string $d24
 * @property integer $sc25
 * @property string $s25
 * @property string $d25
 * @property integer $sc26
 * @property string $s26
 * @property string $d26
 * @property integer $sc27
 * @property string $s27
 * @property string $d27
 * @property integer $sc28
 * @property string $s28
 * @property string $d28
 * @property integer $sc29
 * @property string $s29
 * @property string $d29
 * @property integer $sc30
 * @property string $s30
 * @property string $d30
 * @property integer $sc31
 * @property string $s31
 * @property string $d31
 */
class Reportjamsostek extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Reportjamsostek the static model class
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
		return 'reportjamsostek';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, oldnik, newnik, fullname, fulldivision, month, year, sc1, s1, d1, sc2, s2, d2, sc3, s3, d3, sc4, s4, d4, sc5, s5, d5, sc6, s6, d6, sc7, s7, d7, sc8, s8, d8, sc9, s9, d9, sc10, s10, d10, sc11, s11, d11, sc12, s12, d12, sc13, s13, d13, sc14, s14, d14, sc15, s15, d15, sc16, s16, d16, sc17, s17, d17, sc18, s18, d18, sc19, s19, d19, sc20, s20, d20, sc21, s21, d21, sc22, s22, d22, sc23, s23, d23, sc24, s24, d24, sc25, s25, d25, sc26, s26, d26, sc27, s27, d27, sc28, s28, d28, sc29, s29, d29, sc30, s30, d30, sc31, s31, d31', 'required'),
			array('employeeid, month, year, sc1, sc2, sc3, sc4, sc5, sc6, sc7, sc8, sc9, sc10, sc11, sc12, sc13, sc14, sc15, sc16, sc17, sc18, sc19, sc20, sc21, sc22, sc23, sc24, sc25, sc26, sc27, sc28, sc29, sc30, sc31', 'numerical', 'integerOnly'=>true),
			array('oldnik, newnik, fullname', 'length', 'max'=>50),
			array('fulldivision', 'length', 'max'=>500),
			array('s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, d12, s13, s14, s15, s16, s17, s18, s19, s20, s21, s22, s23, s24, s25, s26, s27, s28, s29, s30, s31, d31', 'length', 'max'=>5),
			array('d1, d2, d3, d4, d5, d6, d7, d8, d9, d10, d11, d13, d14, d15, d16, d17, d18, d19, d20, d21, d22, d23, d24, d25, d26, d27, d28, d29, d30', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reportjamsostekid, employeeid, oldnik, newnik, fullname, fulldivision, month, year, sc1, s1, d1, sc2, s2, d2, sc3, s3, d3, sc4, s4, d4, sc5, s5, d5, sc6, s6, d6, sc7, s7, d7, sc8, s8, d8, sc9, s9, d9, sc10, s10, d10, sc11, s11, d11, sc12, s12, d12, sc13, s13, d13, sc14, s14, d14, sc15, s15, d15, sc16, s16, d16, sc17, s17, d17, sc18, s18, d18, sc19, s19, d19, sc20, s20, d20, sc21, s21, d21, sc22, s22, d22, sc23, s23, d23, sc24, s24, d24, sc25, s25, d25, sc26, s26, d26, sc27, s27, d27, sc28, s28, d28, sc29, s29, d29, sc30, s30, d30, sc31, s31, d31', 'safe', 'on'=>'search'),
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
			'reportjamsostekid' => 'Reportjamsostekid',
			'employeeid' => 'Employeeid',
			'oldnik' => 'Oldnik',
			'newnik' => 'Newnik',
			'fullname' => 'Fullname',
			'fulldivision' => 'Fulldivision',
			'month' => 'Month',
			'year' => 'Year',
			'sc1' => 'Sc1',
			's1' => 'S1',
			'd1' => 'D1',
			'sc2' => 'Sc2',
			's2' => 'S2',
			'd2' => 'D2',
			'sc3' => 'Sc3',
			's3' => 'S3',
			'd3' => 'D3',
			'sc4' => 'Sc4',
			's4' => 'S4',
			'd4' => 'D4',
			'sc5' => 'Sc5',
			's5' => 'S5',
			'd5' => 'D5',
			'sc6' => 'Sc6',
			's6' => 'S6',
			'd6' => 'D6',
			'sc7' => 'Sc7',
			's7' => 'S7',
			'd7' => 'D7',
			'sc8' => 'Sc8',
			's8' => 'S8',
			'd8' => 'D8',
			'sc9' => 'Sc9',
			's9' => 'S9',
			'd9' => 'D9',
			'sc10' => 'Sc10',
			's10' => 'S10',
			'd10' => 'D10',
			'sc11' => 'Sc11',
			's11' => 'S11',
			'd11' => 'D11',
			'sc12' => 'Sc12',
			's12' => 'S12',
			'd12' => 'D12',
			'sc13' => 'Sc13',
			's13' => 'S13',
			'd13' => 'D13',
			'sc14' => 'Sc14',
			's14' => 'S14',
			'd14' => 'D14',
			'sc15' => 'Sc15',
			's15' => 'S15',
			'd15' => 'D15',
			'sc16' => 'Sc16',
			's16' => 'S16',
			'd16' => 'D16',
			'sc17' => 'Sc17',
			's17' => 'S17',
			'd17' => 'D17',
			'sc18' => 'Sc18',
			's18' => 'S18',
			'd18' => 'D18',
			'sc19' => 'Sc19',
			's19' => 'S19',
			'd19' => 'D19',
			'sc20' => 'Sc20',
			's20' => 'S20',
			'd20' => 'D20',
			'sc21' => 'Sc21',
			's21' => 'S21',
			'd21' => 'D21',
			'sc22' => 'Sc22',
			's22' => 'S22',
			'd22' => 'D22',
			'sc23' => 'Sc23',
			's23' => 'S23',
			'd23' => 'D23',
			'sc24' => 'Sc24',
			's24' => 'S24',
			'd24' => 'D24',
			'sc25' => 'Sc25',
			's25' => 'S25',
			'd25' => 'D25',
			'sc26' => 'Sc26',
			's26' => 'S26',
			'd26' => 'D26',
			'sc27' => 'Sc27',
			's27' => 'S27',
			'd27' => 'D27',
			'sc28' => 'Sc28',
			's28' => 'S28',
			'd28' => 'D28',
			'sc29' => 'Sc29',
			's29' => 'S29',
			'd29' => 'D29',
			'sc30' => 'Sc30',
			's30' => 'S30',
			'd30' => 'D30',
			'sc31' => 'Sc31',
			's31' => 'S31',
			'd31' => 'D31',
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

		$criteria->compare('reportjamsostekid',$this->reportjamsostekid);
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('oldnik',$this->oldnik,true);
		$criteria->compare('newnik',$this->newnik,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('fulldivision',$this->fulldivision,true);
		$criteria->compare('month',$this->month);
		$criteria->compare('year',$this->year);
		$criteria->compare('sc1',$this->sc1);
		$criteria->compare('s1',$this->s1,true);
		$criteria->compare('d1',$this->d1,true);
		$criteria->compare('sc2',$this->sc2);
		$criteria->compare('s2',$this->s2,true);
		$criteria->compare('d2',$this->d2,true);
		$criteria->compare('sc3',$this->sc3);
		$criteria->compare('s3',$this->s3,true);
		$criteria->compare('d3',$this->d3,true);
		$criteria->compare('sc4',$this->sc4);
		$criteria->compare('s4',$this->s4,true);
		$criteria->compare('d4',$this->d4,true);
		$criteria->compare('sc5',$this->sc5);
		$criteria->compare('s5',$this->s5,true);
		$criteria->compare('d5',$this->d5,true);
		$criteria->compare('sc6',$this->sc6);
		$criteria->compare('s6',$this->s6,true);
		$criteria->compare('d6',$this->d6,true);
		$criteria->compare('sc7',$this->sc7);
		$criteria->compare('s7',$this->s7,true);
		$criteria->compare('d7',$this->d7,true);
		$criteria->compare('sc8',$this->sc8);
		$criteria->compare('s8',$this->s8,true);
		$criteria->compare('d8',$this->d8,true);
		$criteria->compare('sc9',$this->sc9);
		$criteria->compare('s9',$this->s9,true);
		$criteria->compare('d9',$this->d9,true);
		$criteria->compare('sc10',$this->sc10);
		$criteria->compare('s10',$this->s10,true);
		$criteria->compare('d10',$this->d10,true);
		$criteria->compare('sc11',$this->sc11);
		$criteria->compare('s11',$this->s11,true);
		$criteria->compare('d11',$this->d11,true);
		$criteria->compare('sc12',$this->sc12);
		$criteria->compare('s12',$this->s12,true);
		$criteria->compare('d12',$this->d12,true);
		$criteria->compare('sc13',$this->sc13);
		$criteria->compare('s13',$this->s13,true);
		$criteria->compare('d13',$this->d13,true);
		$criteria->compare('sc14',$this->sc14);
		$criteria->compare('s14',$this->s14,true);
		$criteria->compare('d14',$this->d14,true);
		$criteria->compare('sc15',$this->sc15);
		$criteria->compare('s15',$this->s15,true);
		$criteria->compare('d15',$this->d15,true);
		$criteria->compare('sc16',$this->sc16);
		$criteria->compare('s16',$this->s16,true);
		$criteria->compare('d16',$this->d16,true);
		$criteria->compare('sc17',$this->sc17);
		$criteria->compare('s17',$this->s17,true);
		$criteria->compare('d17',$this->d17,true);
		$criteria->compare('sc18',$this->sc18);
		$criteria->compare('s18',$this->s18,true);
		$criteria->compare('d18',$this->d18,true);
		$criteria->compare('sc19',$this->sc19);
		$criteria->compare('s19',$this->s19,true);
		$criteria->compare('d19',$this->d19,true);
		$criteria->compare('sc20',$this->sc20);
		$criteria->compare('s20',$this->s20,true);
		$criteria->compare('d20',$this->d20,true);
		$criteria->compare('sc21',$this->sc21);
		$criteria->compare('s21',$this->s21,true);
		$criteria->compare('d21',$this->d21,true);
		$criteria->compare('sc22',$this->sc22);
		$criteria->compare('s22',$this->s22,true);
		$criteria->compare('d22',$this->d22,true);
		$criteria->compare('sc23',$this->sc23);
		$criteria->compare('s23',$this->s23,true);
		$criteria->compare('d23',$this->d23,true);
		$criteria->compare('sc24',$this->sc24);
		$criteria->compare('s24',$this->s24,true);
		$criteria->compare('d24',$this->d24,true);
		$criteria->compare('sc25',$this->sc25);
		$criteria->compare('s25',$this->s25,true);
		$criteria->compare('d25',$this->d25,true);
		$criteria->compare('sc26',$this->sc26);
		$criteria->compare('s26',$this->s26,true);
		$criteria->compare('d26',$this->d26,true);
		$criteria->compare('sc27',$this->sc27);
		$criteria->compare('s27',$this->s27,true);
		$criteria->compare('d27',$this->d27,true);
		$criteria->compare('sc28',$this->sc28);
		$criteria->compare('s28',$this->s28,true);
		$criteria->compare('d28',$this->d28,true);
		$criteria->compare('sc29',$this->sc29);
		$criteria->compare('s29',$this->s29,true);
		$criteria->compare('d29',$this->d29,true);
		$criteria->compare('sc30',$this->sc30);
		$criteria->compare('s30',$this->s30,true);
		$criteria->compare('d30',$this->d30,true);
		$criteria->compare('sc31',$this->sc31);
		$criteria->compare('s31',$this->s31,true);
		$criteria->compare('d31',$this->d31,true);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
}
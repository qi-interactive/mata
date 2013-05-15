<?php

/**
 * This is the model class for table "projectsetting".
 *
 * The followings are the available columns in table 'projectsetting':
 * @property string $Key
 * @property string $Value
 * @property string $ProjectKey
 *
 * The followings are the available model relations:
 * @property Project $projectKey
 */
class ProjectSetting extends MataActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProjectSetting the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'projectsetting';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Key, Value, ProjectKey', 'required'),
            array('Key', 'length', 'max' => 255),
            array('ProjectKey', 'length', 'max' => 32),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Key, Value, ProjectKey', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'projectKey' => array(self::BELONGS_TO, 'Project', 'ProjectKey'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Key' => 'Key',
            'Value' => 'Value',
            'ProjectKey' => 'Project Key',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('Key', $this->Key, true);
        $criteria->compare('Value', $this->Value, true);
        $criteria->compare('ProjectKey', $this->ProjectKey, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function findValueByKey($key) {
        $model = $this->findByAttributes(array(
            "Key" => $key
        ));

        // Try the generic way, which removes context (controller::action)
        if ($model == null && preg_match_all('/[a-z]*::[a-z]*::([a-z]*::[a-z]*::[a-z]*)/', $key, $genericKey))
            $model = $this->findByAttributes(array(
                "Key" => $genericKey[1]
            ));

        return $model != null ? $model->Value : null;
    }

    public function findAllValuesByKey($key) {
        $value = $this->findValueByKey($key);
        return $value != null ? explode("|", $value) : array();
    }

    public function settingExists($key) {
        return $this->countByAttributes(array(
                    "Key" => $key
                )) == 1;
    }

}
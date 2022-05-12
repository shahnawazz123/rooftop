<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "artist".
 *
 * @property int $id
 * @property string $name
 * @property string $timezone
 * @property string $day_of_week
 * @property string $available_at
 * @property string $available_until
 */
class Artist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $localTimeZone;
    public static function tableName()
    {
        return 'artist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'timezone', 'day_of_week', 'available_at', 'available_until'], 'required'],
            [['available_at', 'available_until','id'], 'safe'],
            [['name', 'day_of_week'], 'string', 'max' => 20],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'timezone' => 'Timezone',
            'day_of_week' => 'Day Of Week',
            'available_at' => 'Available At',
            'available_until' => 'Available Until',
        ];
    }
    public function getAllRecards($where =null)
    {
        $query = Artist::find();
        if (!empty($where)) {
            $query->where(['day_of_week'=> $where]);
        }
        $records = $query->all();
        return $records;
    }

    public function getLocalTime($records)
    {
        $result = [];
        foreach ($records as $key => $record) {
        $gmt        = $record->timezone;
        $start      = strpos($gmt,'(GMT-')+5;
        $global_timezone   = substr($gmt,$start,strpos($gmt,':00)')-$start);
        //echo $global_timezone;die;
        if ($this->localTimeZone < $global_timezone) {
            $hours = '+'.($global_timezone - $this->localTimeZone).' hours';
            $record->available_at    = date('H:i:s', strtotime($record->available_at . $hours));
            $record->available_until = date('H:i:s', strtotime($record->available_until . $hours));
            }
        }
        return $records;
        
    }

    public function getCoaches($where=null)
    {
        $records = $this->getAllRecards($where);
        return $this->getLocalTime($records);
    }
}

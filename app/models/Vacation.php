<?php

class Vacation extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(column="uid", type="integer", length=11, nullable=false)
     */
    public $uid;

    /**
     *
     * @var string
     * @Column(column="type", type="string", length=255, nullable=false)
     */
    public $type;

    /**
     *
     * @var integer
     * @Column(column="count_day", type="integer", length=11, nullable=false)
     */
    public $count_day;

    /**
     *
     * @var string
     * @Column(column="date_start", type="string", nullable=false)
     */
    public $date_start;

    /**
     *
     * @var string
     * @Column(column="date_end", type="string", nullable=false)
     */
    public $date_end;

    /**
     *
     * @var integer
     * @Column(column="oid", type="integer", length=11, nullable=false)
     */
    public $oid;

    /**
     *
     * @var string
     * @Column(column="note", type="string", length=255, nullable=true)
     */
    public $note;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("security_app_db");
        $this->setSource("vacation");
        $this->belongsTo('uid', '\Users', 'id', ['alias' => 'Users']);
        $this->belongsTo('oid', '\Orders', 'id', ['alias' => 'Orders']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Vacation[]|Vacation|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Vacation|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'uid' => 'uid',
            'type' => 'type',
            'count_day' => 'count_day',
            'date_start' => 'date_start',
            'date_end' => 'date_end',
            'oid' => 'oid',
            'note' => 'note'
        ];
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'vacation';
    }

}

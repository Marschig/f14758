<?php

class Transfers extends \Phalcon\Mvc\Model
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
     * @Column(column="date", type="string", nullable=false)
     */
    public $date;

    /**
     *
     * @var integer
     * @Column(column="aid", type="integer", length=11, nullable=false)
     */
    public $aid;

    /**
     *
     * @var integer
     * @Column(column="pid", type="integer", length=11, nullable=false)
     */
    public $pid;

    /**
     *
     * @var integer
     * @Column(column="cid", type="integer", length=11, nullable=false)
     */
    public $cid;

    /**
     *
     * @var string
     * @Column(column="salary", type="string", length=255, nullable=false)
     */
    public $salary;

    /**
     *
     * @var integer
     * @Column(column="oid", type="integer", length=11, nullable=false)
     */
    public $oid;

    /**
     *
     * @var integer
     * @Column(column="cause", type="integer", length=11, nullable=false)
     */
    public $cause;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("security_app_db");
        $this->setSource("transfers");
        $this->belongsTo('aid', '\Areas', 'id', ['alias' => 'Areas']);
        $this->belongsTo('cause', '\TransferCause', 'id', ['alias' => 'TransferCause']);
        $this->belongsTo('cid', '\Categories', 'id', ['alias' => 'Categories']);
        $this->belongsTo('oid', '\Orders', 'id', ['alias' => 'Orders']);
        $this->belongsTo('pid', '\Professions', 'id', ['alias' => 'Professions']);
        $this->belongsTo('uid', '\Users', 'id', ['alias' => 'Users']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Transfers[]|Transfers|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Transfers|\Phalcon\Mvc\Model\ResultInterface
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
            'date' => 'date',
            'aid' => 'aid',
            'pid' => 'pid',
            'cid' => 'cid',
            'salary' => 'salary',
            'oid' => 'oid',
            'cause' => 'cause'
        ];
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'transfers';
    }

}

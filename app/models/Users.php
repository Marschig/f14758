<?php

class Users extends \Phalcon\Mvc\Model
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
     * @Column(column="t_number", type="integer", length=11, nullable=false)
     */
    public $t_number;

    /**
     *
     * @var string
     * @Column(column="fio", type="string", length=255, nullable=false)
     */
    public $fio;

    /**
     *
     * @var string
     * @Column(column="pass", type="string", length=255, nullable=false)
     */
    public $pass;

    /**
     *
     * @var integer
     * @Column(column="reg_number", type="integer", length=11, nullable=false)
     */
    public $reg_number;

    /**
     *
     * @var integer
     * @Column(column="identity_code", type="integer", length=11, nullable=false)
     */
    public $identity_code;

    /**
     *
     * @var string
     * @Column(column="gender", type="string", length=50, nullable=false)
     */
    public $gender;

    /**
     *
     * @var string
     * @Column(column="birth_date", type="string", nullable=false)
     */
    public $birth_date;

    /**
     *
     * @var string
     * @Column(column="date_rec", type="string", nullable=false)
     */
    public $date_rec;

    /**
     *
     * @var integer
     * @Column(column="oid_rec", type="integer", length=11, nullable=false)
     */
    public $oid_rec;

    /**
     *
     * @var integer
     * @Column(column="pid", type="integer", length=11, nullable=false)
     */
    public $pid;

    /**
     *
     * @var integer
     * @Column(column="aid", type="integer", length=11, nullable=false)
     */
    public $aid;

    /**
     *
     * @var integer
     * @Column(column="cid", type="integer", length=11, nullable=false)
     */
    public $cid;

    /**
     *
     * @var string
     * @Column(column="date_dis", type="string", nullable=true)
     */
    public $date_dis;

    /**
     *
     * @var string
     * @Column(column="cause_dis", type="string", length=255, nullable=true)
     */
    public $cause_dis;

    /**
     *
     * @var integer
     * @Column(column="oid_dis", type="integer", length=11, nullable=true)
     */
    public $oid_dis;

    /**
     *
     * @var integer
     * @Column(column="status", type="integer", length=11, nullable=false)
     */
    public $status;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("security_app_db");
        $this->setSource("users");
        $this->hasMany('id', 'UserRoles', 'uid', ['alias' => 'UserRoles']);
        $this->belongsTo('oid_rec', '\Orders', 'id', ['alias' => 'Orders']);
        $this->belongsTo('pid', '\Professions', 'id', ['alias' => 'Professions']);
        $this->belongsTo('aid', '\Areas', 'id', ['alias' => 'Areas']);
        $this->belongsTo('cid', '\Categories', 'id', ['alias' => 'Categories']);
        $this->belongsTo('oid_dis', '\Orders', 'id', ['alias' => 'Orders']);
        $this->belongsTo('status', '\Status', 'id', ['alias' => 'Status']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
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
            't_number' => 't_number',
            'fio' => 'fio',
            'pass' => 'pass',
            'reg_number' => 'reg_number',
            'identity_code' => 'identity_code',
            'gender' => 'gender',
            'birth_date' => 'birth_date',
            'date_rec' => 'date_rec',
            'oid_rec' => 'oid_rec',
            'pid' => 'pid',
            'aid' => 'aid',
            'cid' => 'cid',
            'date_dis' => 'date_dis',
            'cause_dis' => 'cause_dis',
            'oid_dis' => 'oid_dis',
            'status' => 'status'
        ];
    }

}

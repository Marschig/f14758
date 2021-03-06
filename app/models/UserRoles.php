<?php

class UserRoles extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(column="rid", type="integer", length=11, nullable=false)
     */
    public $rid;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("security_app_db");
        $this->setSource("user_roles");
        $this->belongsTo('uid', '\Users', 'id', ['alias' => 'Users']);
        $this->belongsTo('rid', '\Roles', 'id', ['alias' => 'Roles']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserRoles[]|UserRoles|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserRoles|\Phalcon\Mvc\Model\ResultInterface
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
            'rid' => 'rid'
        ];
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_roles';
    }

}

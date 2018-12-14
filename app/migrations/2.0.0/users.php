<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class UsersMigration_200
 */
class UsersMigration_200 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('users', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        't_number',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'size' => 11,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'fio',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 't_number'
                        ]
                    ),
                    new Column(
                        'pass',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'fio'
                        ]
                    ),
                    new Column(
                        'reg_number',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'pass'
                        ]
                    ),
                    new Column(
                        'identity_code',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'reg_number'
                        ]
                    ),
                    new Column(
                        'gender',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 50,
                            'after' => 'identity_code'
                        ]
                    ),
                    new Column(
                        'birth_date',
                        [
                            'type' => Column::TYPE_DATE,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'gender'
                        ]
                    ),
                    new Column(
                        'date_rec',
                        [
                            'type' => Column::TYPE_DATE,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'birth_date'
                        ]
                    ),
                    new Column(
                        'oid_rec',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'date_rec'
                        ]
                    ),
                    new Column(
                        'pid',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'oid_rec'
                        ]
                    ),
                    new Column(
                        'aid',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'pid'
                        ]
                    ),
                    new Column(
                        'cid',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'aid'
                        ]
                    ),
                    new Column(
                        'date_dis',
                        [
                            'type' => Column::TYPE_DATE,
                            'size' => 1,
                            'after' => 'cid'
                        ]
                    ),
                    new Column(
                        'cause_dis',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 255,
                            'after' => 'date_dis'
                        ]
                    ),
                    new Column(
                        'oid_dis',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'size' => 11,
                            'after' => 'cause_dis'
                        ]
                    ),
                    new Column(
                        'status',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'oid_dis'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('reg_number', ['reg_number'], 'UNIQUE'),
                    new Index('oid_rec', ['oid_rec'], null),
                    new Index('pid', ['pid'], null),
                    new Index('aid', ['aid'], null),
                    new Index('cid', ['cid'], null),
                    new Index('oid_dis', ['oid_dis'], null),
                    new Index('status', ['status'], null)
                ],
                'references' => [
                    new Reference(
                        'users_ibfk_1',
                        [
                            'referencedTable' => 'orders',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['oid_rec'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'users_ibfk_2',
                        [
                            'referencedTable' => 'professions',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['pid'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'users_ibfk_3',
                        [
                            'referencedTable' => 'areas',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['aid'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'users_ibfk_4',
                        [
                            'referencedTable' => 'categories',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['cid'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'users_ibfk_5',
                        [
                            'referencedTable' => 'orders',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['oid_dis'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'users_ibfk_6',
                        [
                            'referencedTable' => 'status',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['status'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    )
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '4',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {
        $this->batchInsert('users', [
                'id',
                't_number',
                'fio',
                'pass',
                'reg_number',
                'identity_code',
                'gender',
                'birth_date',
                'date_rec',
                'oid_rec',
                'pid',
                'aid',
                'cid',
                'date_dis',
                'cause_dis',
                'oid_dis',
                'status'
            ]
        );
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
        $this->batchDelete('users');
    }

}

<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class TransfersMigration_300
 */
class TransfersMigration_300 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('transfers', [
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
                        'uid',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'date',
                        [
                            'type' => Column::TYPE_DATE,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'uid'
                        ]
                    ),
                    new Column(
                        'aid',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'date'
                        ]
                    ),
                    new Column(
                        'pid',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'aid'
                        ]
                    ),
                    new Column(
                        'cid',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'pid'
                        ]
                    ),
                    new Column(
                        'salary',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'cid'
                        ]
                    ),
                    new Column(
                        'oid',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'salary'
                        ]
                    ),
                    new Column(
                        'cause',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'oid'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('uid', ['uid'], null),
                    new Index('aid', ['aid'], null),
                    new Index('pid', ['pid'], null),
                    new Index('cid', ['cid'], null),
                    new Index('oid', ['oid'], null),
                    new Index('cause', ['cause'], null)
                ],
                'references' => [
                    new Reference(
                        'transfers_ibfk_1',
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
                        'transfers_ibfk_2',
                        [
                            'referencedTable' => 'transfer_cause',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['cause'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'transfers_ibfk_3',
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
                        'transfers_ibfk_4',
                        [
                            'referencedTable' => 'orders',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['oid'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'transfers_ibfk_5',
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
                        'transfers_ibfk_6',
                        [
                            'referencedTable' => 'users',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['uid'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    )
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '2',
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
        $this->batchInsert('transfers', [
                'id',
                'uid',
                'date',
                'aid',
                'pid',
                'cid',
                'salary',
                'oid',
                'cause'
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
        $this->batchDelete('transfers');
    }

}

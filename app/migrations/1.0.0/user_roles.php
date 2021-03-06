<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class UserRolesMigration_100
 */
class UserRolesMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('user_roles', [
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
                        'rid',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'uid'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('uid', ['uid'], null),
                    new Index('rid', ['rid'], null)
                ],
                'references' => [
                    new Reference(
                        'user_roles_ibfk_1',
                        [
                            'referencedTable' => 'users',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['uid'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'user_roles_ibfk_2',
                        [
                            'referencedTable' => 'roles',
                            'referencedSchema' => 'security_app_db',
                            'columns' => ['rid'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    )
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '3',
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
        $this->batchInsert('user_roles', [
                'id',
                'uid',
                'rid'
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
        $this->batchDelete('user_roles');
    }

}

<?php

use Phinx\Migration\AbstractMigration;

class CreateOrdersTable extends AbstractMigration {
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up() {
        $orders = $this->table('orders');
        $orders->addColumn('user_id', 'integer', ['null' => false])
            ->addColumn('amount', 'decimal', ['null' => false, 'precision' => 12, 'scale' => 2,
                'signed' => true, 'default' => 0.00])
            ->addColumn('status', 'smallinteger', ['limit' => 1, 'default' => 1])->create();

        $orders_product = $this->table('orders_product');
        $orders_product->addColumn('order_id', 'integer', ['null' => false])
            ->addColumn('product_id', 'integer', ['null' => false])
            ->addColumn('quantity', 'integer', ['signed' => true, 'default' => 1])->create();
    }

    /**
     * Migrate Down.
     */
    public function down() {
        $this->table('orders_product')->drop()->save();
        $this->table('orders')->drop()->save();
    }
}

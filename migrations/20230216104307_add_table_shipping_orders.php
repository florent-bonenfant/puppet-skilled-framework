<?php

class AddTableShippingOrders extends PuppetSkilledMigration
{
    const SHIPING_TRACKING = 'App\Model\ShippingTrackings';
    const SHIPING_SLIP = 'App\Model\ShippingSlips';

    public function up()
    {
        $this->table('shippings_orders', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', ['null' => false, 'limit' => 36])
            ->addColumn('order_id', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('entity_id', 'string', ['null' => false, 'limit' => 36])
            ->addColumn('resource_type', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['order_id', 'entity_id', 'resource_type'], [
                'unique' => true,
            ])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();

        $this->changeData('shippings_trackings', self::SHIPING_TRACKING);
        $this->changeData('shippings_slips', self::SHIPING_SLIP);


        $this->table('shippings_trackings')->dropForeignKey('order_id')->save();
        $this->table('shippings_trackings')
            ->removeColumn('order_id')
            ->save();

        $this->table('shippings_slips')->dropForeignKey('order_id')->save();
        $this->table('shippings_slips')
            ->removeColumn('order_id')
            ->save();
    }

    public function changeData($readTable, $resource)
    {
        $previous_data = $this->fetchAll('
            SELECT id, order_id, number
            FROM `' . $readTable . '`
        ');
        $mapping = [];
        foreach ($previous_data as $data) {
            if (empty($data['order_id'])) {
                continue;
            }
            if (!array_key_exists($data['number'], $mapping)) {
                $mapping[$data['number']] = $data['id'];
                $entityId = $data['id'];
            } else {
                $entityId = $mapping[$data['number']];
            }


            // On associe les commandes
            $row = [
                'id'             => $this->uuid(),
                'order_id'       => $data['order_id'],
                'entity_id'      => $entityId,
                'resource_type'  => $resource,
            ];
            try {
                $this->table('shippings_orders')->insert($row)->save();
            } catch (\PDOException $e) {
                if (preg_match('/Duplicate entry/', $e->getMessage())) {
                    // no-op
                } else {
                    throw $e;
                }
            }
        }

        if (!empty($mapping)) {
            // On supprime les doublons
            $this->execute("DELETE FROM $readTable WHERE id NOT IN (" . implode(
                ',',
                array_map(
                    function ($elem) {
                        return "'$elem'";
                    },
                    $mapping
                )
            )
                . ")");
        }
    }

    public function down()
    {
        $this->table('shippings_orders')
            ->dropForeignKey('order_id')
            ->save();
        $this->table('shippings_orders')->drop();

        $this->table('shippings_trackings')
            ->addColumn('order_id', 'string', ['null' => true, 'limit' => 36])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->update();
        $this->table('shippings_slips')
            ->addColumn('order_id', 'string', ['null' => true, 'limit' => 36])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->update();
    }
}

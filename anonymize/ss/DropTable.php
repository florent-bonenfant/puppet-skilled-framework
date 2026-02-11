<?php

use HideMe\Model;
use Illuminate\Database\Capsule\Manager as Capsule;

class DropTable extends Model
{
    protected $table = 'sessions';
    public $dropTables = [
        'orders_invoices_backup',
        'notifications_backup',
        'users_delegates_bkp',
        'users_roles2',
        'users_roles_old',
    ];
    public $eraseData = true;
    public $timestamps = true;
    public $columns = [];
    private $schema;

    public function __construct()
    {
        parent::__construct();
        $this->schema = Capsule::schema();
        $this->dropTables();
    }

    private function dropTables()
    {
        foreach ($this->dropTables as $table) {
            $this->schema->dropIfExists($table);
        }
    }
}


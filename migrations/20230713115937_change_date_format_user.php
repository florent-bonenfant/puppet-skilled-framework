<?php

class ChangeDateFormatUser extends PuppetSkilledMigration
{
    public function up()
    {
        $this->table('applications_families')
            ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->removeColumn('id')
            ->update();
        $this->table('cgvs_families')
            ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->update();
        $this->table('commercial_conditions_companies')
            ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->update();

        // Conversion du format des dates dans les profils pour PHP8
        $this->execute("UPDATE users
            SET date_format = REPLACE(date_format, '%d', 'DD'),
            date_format = REPLACE(date_format, '%B', 'MMMM'),
            date_format = REPLACE(date_format, '%Y', 'YYYY'),

            datetime_format = REPLACE(datetime_format, '%d', 'DD'),
            datetime_format = REPLACE(datetime_format, '%B', 'MMMM'),
            datetime_format = REPLACE(datetime_format, '%Y', 'YYYY'),
            datetime_format = REPLACE(datetime_format, '%H', 'HH'),
            datetime_format = REPLACE(datetime_format, '%M', 'mm'),
            datetime_format = REPLACE(datetime_format, '%S', 'ss')
        ");
    }

    public function down()
    {
        $this->table('applications_families')
            ->removeColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('id', 'string', ['limit' => 36])
            ->update();
        $this->table('cgvs_families')
            ->removeColumn('updated_at')
            ->update();
        $this->table('commercial_conditions_companies')
            ->removeColumn('updated_at')
            ->update();

        $this->execute("UPDATE users
            SET date_format = REPLACE(date_format, 'DD', '%d'),
            date_format = REPLACE(date_format, 'MMMM', '%B'),
            date_format = REPLACE(date_format, 'YYYY', '%Y'),

            datetime_format = REPLACE(datetime_format, 'DD', '%d'),
            datetime_format = REPLACE(datetime_format, 'MMMM', '%B'),
            datetime_format = REPLACE(datetime_format, 'YYYY', '%Y'),
            datetime_format = REPLACE(datetime_format, 'HH', '%H'),
            datetime_format = REPLACE(datetime_format, 'mm', '%M'),
            datetime_format = REPLACE(datetime_format, 'ss', '%s')
        ");
    }
}

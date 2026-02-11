<?php

use HideMe\Model;

/**
 * Exemple d'utilisationp
 */
class User extends Model
{
    protected $table = 'users';
    public $columns = [
        'id' => 'uuid',
        'first_name' => 'firstName',
        'last_name' => 'lastName',
        'active' => 1,
        'login_tries' => 0,
        'must_change_password' => 0,
        'password_reset_token' => null,
        'language' => 'fr',
        'timezone' => 'Europe/Berlin',
        'date_format' => '%d %B %Y',
        'datetime_format' => '%d %B %Y, %H:%M',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->columns['username'] = function () {
            $this->tmpUsername = $this->faker->email;
            return $this->tmpUsername;
        };
        $this->columns['email'] = function () {
            return $this->tmpUsername;
        };
        $this->columns['password'] = function () {
            return password_hash('password', PASSWORD_BCRYPT, ['cost' => 12]);
        };
    }
}

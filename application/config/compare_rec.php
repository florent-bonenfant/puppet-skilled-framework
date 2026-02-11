recette
string(5) "nb : "
int(1)
string(6) "parent"
array(1) {
  [0]=>
  object(App\Model\UsersDelegates)#122 (24) {
    ["table":protected]=>
    string(15) "users_delegates"
    ["primaryKey":protected]=>
    string(2) "id"
    ["incrementing"]=>
    bool(true)
    ["keyType":protected]=>
    string(6) "string"
    ["timestamps"]=>
    bool(false)
    ["connection":protected]=>
    object(CI_DB_mysqli_driver)#34 (46) {
      ["dbdriver"]=>
      string(6) "mysqli"
      ["compress"]=>
      bool(false)
      ["delete_hack"]=>
      bool(true)
      ["stricton"]=>
      bool(false)
      ["_escape_char":protected]=>
      string(1) "`"
      ["_mysqli":protected]=>
      object(mysqli)#35 (19) {
        ["affected_rows"]=>
        int(1)
        ["client_info"]=>
        string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
        ["client_version"]=>
        int(50012)
        ["connect_errno"]=>
        int(0)
        ["connect_error"]=>
        NULL
        ["errno"]=>
        int(0)
        ["error"]=>
        string(0) ""
        ["error_list"]=>
        array(0) {
        }
        ["field_count"]=>
        int(4)
        ["host_info"]=>
        string(25) "Localhost via UNIX socket"
        ["info"]=>
        NULL
        ["insert_id"]=>
        int(0)
        ["server_info"]=>
        string(23) "8.0.42-0ubuntu0.24.04.1"
        ["server_version"]=>
        int(80042)
        ["stat"]=>
        string(142) "Uptime: 348330  Threads: 2  Questions: 803842  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
        ["sqlstate"]=>
        string(5) "00000"
        ["protocol_version"]=>
        int(10)
        ["thread_id"]=>
        int(4156)
        ["warning_count"]=>
        int(0)
      }
      ["dsn"]=>
      string(0) ""
      ["username"]=>
      string(4) "user"
      ["password"]=>
      string(8) "password"
      ["hostname"]=>
      string(9) "localhost"
      ["database"]=>
      string(18) "guinot_portail_rec"
      ["subdriver"]=>
      NULL
      ["dbprefix"]=>
      string(0) ""
      ["char_set"]=>
      string(4) "utf8"
      ["dbcollat"]=>
      string(15) "utf8_general_ci"
      ["encrypt"]=>
      bool(false)
      ["swap_pre"]=>
      string(0) ""
      ["port"]=>
      string(0) ""
      ["pconnect"]=>
      bool(false)
      ["conn_id"]=>
      object(mysqli)#35 (19) {
        ["affected_rows"]=>
        int(-1)
        ["client_info"]=>
        string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
        ["client_version"]=>
        int(50012)
        ["connect_errno"]=>
        int(0)
        ["connect_error"]=>
        NULL
        ["errno"]=>
        int(0)
        ["error"]=>
        string(0) ""
        ["error_list"]=>
        array(0) {
        }
        ["field_count"]=>
        int(4)
        ["host_info"]=>
        string(25) "Localhost via UNIX socket"
        ["info"]=>
        NULL
        ["insert_id"]=>
        int(0)
        ["server_info"]=>
        string(23) "8.0.42-0ubuntu0.24.04.1"
        ["server_version"]=>
        int(80042)
        ["stat"]=>
        string(142) "Uptime: 348330  Threads: 2  Questions: 803843  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
        ["sqlstate"]=>
        string(5) "00000"
        ["protocol_version"]=>
        int(10)
        ["thread_id"]=>
        int(4156)
        ["warning_count"]=>
        int(0)
      }
      ["result_id"]=>
      object(mysqli_result)#49 (5) {
        ["current_field"]=>
        int(0)
        ["field_count"]=>
        int(4)
        ["lengths"]=>
        NULL
        ["num_rows"]=>
        int(1)
        ["type"]=>
        int(0)
      }
      ["db_debug"]=>
      bool(true)
      ["benchmark"]=>
      float(0.028590440750122)
      ["query_count"]=>
      int(33)
      ["bind_marker"]=>
      string(1) "?"
      ["save_queries"]=>
      bool(true)
      ["queries"]=>
      array(33) {
        [0]=>
        string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
        [1]=>
        string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
        [2]=>
        string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
        [3]=>
        string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
        [4]=>
        string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
        [5]=>
        string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
        [6]=>
        string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
        [7]=>
        string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
        [8]=>
        string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
        [9]=>
        string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
        [10]=>
        string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
        [11]=>
        string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
        [12]=>
        string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
        [13]=>
        string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
        [14]=>
        string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
        [15]=>
        string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
        [16]=>
        string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
        [17]=>
        string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
        [18]=>
        string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
        [19]=>
        string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
        [20]=>
        string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
        [21]=>
        string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
        [22]=>
        string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
        [23]=>
        string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
        [24]=>
        string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
        [25]=>
        string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
        [26]=>
        string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
        [27]=>
        string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
        [28]=>
        string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
        [29]=>
        string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
        [30]=>
        string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
        [31]=>
        string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
        [32]=>
        string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
      }
      ["query_times"]=>
      array(33) {
        [0]=>
        float(0.00030183792114258)
        [1]=>
        float(0.00043296813964844)
        [2]=>
        float(0.00072407722473145)
        [3]=>
        float(0.00080490112304688)
        [4]=>
        float(0.00021886825561523)
        [5]=>
        float(0.00030303001403809)
        [6]=>
        float(0.010481119155884)
        [7]=>
        float(0.0019140243530273)
        [8]=>
        float(0.0045070648193359)
        [9]=>
        float(0.00099086761474609)
        [10]=>
        float(0.00025010108947754)
        [11]=>
        float(0.00019598007202148)
        [12]=>
        float(0.00017595291137695)
        [13]=>
        float(0.00020813941955566)
        [14]=>
        float(0.0001671314239502)
        [15]=>
        float(0.00042915344238281)
        [16]=>
        float(0.0015599727630615)
        [17]=>
        float(0.00019407272338867)
        [18]=>
        float(0.0001680850982666)
        [19]=>
        float(0.00015616416931152)
        [20]=>
        float(0.00017094612121582)
        [21]=>
        float(0.00016307830810547)
        [22]=>
        float(0.00014996528625488)
        [23]=>
        float(0.00088620185852051)
        [24]=>
        float(0.00064206123352051)
        [25]=>
        float(0.00022196769714355)
        [26]=>
        float(0.00037789344787598)
        [27]=>
        float(0.00017285346984863)
        [28]=>
        float(0.00018119812011719)
        [29]=>
        float(0.00017380714416504)
        [30]=>
        float(0.00028491020202637)
        [31]=>
        float(0.00028610229492188)
        [32]=>
        float(0.00069594383239746)
      }
      ["data_cache"]=>
      array(0) {
      }
      ["trans_enabled"]=>
      bool(true)
      ["trans_strict"]=>
      bool(true)
      ["_trans_depth":protected]=>
      int(0)
      ["_trans_status":protected]=>
      bool(true)
      ["_trans_failure":protected]=>
      bool(false)
      ["cache_on"]=>
      bool(false)
      ["cachedir"]=>
      string(0) ""
      ["cache_autodel"]=>
      bool(false)
      ["CACHE"]=>
      NULL
      ["_protect_identifiers":protected]=>
      bool(true)
      ["_reserved_identifiers":protected]=>
      array(1) {
        [0]=>
        string(1) "*"
      }
      ["_like_escape_str":protected]=>
      string(13) " ESCAPE '%s' "
      ["_like_escape_chr":protected]=>
      string(1) "!"
      ["_random_keyword":protected]=>
      array(2) {
        [0]=>
        string(6) "RAND()"
        [1]=>
        string(8) "RAND(%d)"
      }
      ["_count_string":protected]=>
      string(19) "SELECT COUNT(*) AS "
      ["failover"]=>
      array(0) {
      }
      ["getQueryGrammar"]=>
      object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
        ["selectComponents":protected]=>
        array(11) {
          [0]=>
          string(9) "aggregate"
          [1]=>
          string(7) "columns"
          [2]=>
          string(4) "from"
          [3]=>
          string(5) "joins"
          [4]=>
          string(6) "wheres"
          [5]=>
          string(6) "groups"
          [6]=>
          string(7) "havings"
          [7]=>
          string(6) "orders"
          [8]=>
          string(5) "limit"
          [9]=>
          string(6) "offset"
          [10]=>
          string(4) "lock"
        }
        ["operators":protected]=>
        array(0) {
        }
        ["tablePrefix":protected]=>
        string(0) ""
      }
    }
    ["with":protected]=>
    array(0) {
    }
    ["withCount":protected]=>
    array(0) {
    }
    ["perPage":protected]=>
    int(15)
    ["attributes":protected]=>
    array(4) {
      ["id"]=>
      string(36) "259ffa23-4e11-4926-9fc9-86065133d028"
      ["user_id"]=>
      string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
      ["parent_user_id"]=>
      string(36) "bb26d4e0-36cf-4a4e-90a6-d9c908dbbaa5"
      ["customer_id"]=>
      string(7) "PY20840"
    }
    ["original":protected]=>
    array(4) {
      ["id"]=>
      string(36) "259ffa23-4e11-4926-9fc9-86065133d028"
      ["user_id"]=>
      string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
      ["parent_user_id"]=>
      string(36) "bb26d4e0-36cf-4a4e-90a6-d9c908dbbaa5"
      ["customer_id"]=>
      string(7) "PY20840"
    }
    ["relations":protected]=>
    array(0) {
    }
    ["hidden":protected]=>
    array(0) {
    }
    ["visible":protected]=>
    array(0) {
    }
    ["appends":protected]=>
    array(0) {
    }
    ["fillable":protected]=>
    array(0) {
    }
    ["guarded":protected]=>
    array(1) {
      [0]=>
      string(1) "*"
    }
    ["dates":protected]=>
    array(0) {
    }
    ["dateFormat":protected]=>
    NULL
    ["casts":protected]=>
    array(0) {
    }
    ["touches":protected]=>
    array(0) {
    }
    ["observables":protected]=>
    array(0) {
    }
    ["exists"]=>
    bool(true)
    ["wasRecentlyCreated"]=>
    bool(false)
  }
}
string(7) "role : "
object(App\Model\Role)#80 (24) {
  ["table":protected]=>
  string(5) "roles"
  ["incrementing"]=>
  bool(true)
  ["keyType":protected]=>
  string(6) "string"
  ["timestamps"]=>
  bool(true)
  ["connection":protected]=>
  object(CI_DB_mysqli_driver)#34 (46) {
    ["dbdriver"]=>
    string(6) "mysqli"
    ["compress"]=>
    bool(false)
    ["delete_hack"]=>
    bool(true)
    ["stricton"]=>
    bool(false)
    ["_escape_char":protected]=>
    string(1) "`"
    ["_mysqli":protected]=>
    object(mysqli)#35 (19) {
      ["affected_rows"]=>
      int(1)
      ["client_info"]=>
      string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
      ["client_version"]=>
      int(50012)
      ["connect_errno"]=>
      int(0)
      ["connect_error"]=>
      NULL
      ["errno"]=>
      int(0)
      ["error"]=>
      string(0) ""
      ["error_list"]=>
      array(0) {
      }
      ["field_count"]=>
      int(4)
      ["host_info"]=>
      string(25) "Localhost via UNIX socket"
      ["info"]=>
      NULL
      ["insert_id"]=>
      int(0)
      ["server_info"]=>
      string(23) "8.0.42-0ubuntu0.24.04.1"
      ["server_version"]=>
      int(80042)
      ["stat"]=>
      string(142) "Uptime: 348330  Threads: 2  Questions: 803845  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
      ["sqlstate"]=>
      string(5) "00000"
      ["protocol_version"]=>
      int(10)
      ["thread_id"]=>
      int(4156)
      ["warning_count"]=>
      int(0)
    }
    ["dsn"]=>
    string(0) ""
    ["username"]=>
    string(4) "user"
    ["password"]=>
    string(8) "password"
    ["hostname"]=>
    string(9) "localhost"
    ["database"]=>
    string(18) "guinot_portail_rec"
    ["subdriver"]=>
    NULL
    ["dbprefix"]=>
    string(0) ""
    ["char_set"]=>
    string(4) "utf8"
    ["dbcollat"]=>
    string(15) "utf8_general_ci"
    ["encrypt"]=>
    bool(false)
    ["swap_pre"]=>
    string(0) ""
    ["port"]=>
    string(0) ""
    ["pconnect"]=>
    bool(false)
    ["conn_id"]=>
    object(mysqli)#35 (19) {
      ["affected_rows"]=>
      int(-1)
      ["client_info"]=>
      string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
      ["client_version"]=>
      int(50012)
      ["connect_errno"]=>
      int(0)
      ["connect_error"]=>
      NULL
      ["errno"]=>
      int(0)
      ["error"]=>
      string(0) ""
      ["error_list"]=>
      array(0) {
      }
      ["field_count"]=>
      int(4)
      ["host_info"]=>
      string(25) "Localhost via UNIX socket"
      ["info"]=>
      NULL
      ["insert_id"]=>
      int(0)
      ["server_info"]=>
      string(23) "8.0.42-0ubuntu0.24.04.1"
      ["server_version"]=>
      int(80042)
      ["stat"]=>
      string(142) "Uptime: 348330  Threads: 2  Questions: 803846  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
      ["sqlstate"]=>
      string(5) "00000"
      ["protocol_version"]=>
      int(10)
      ["thread_id"]=>
      int(4156)
      ["warning_count"]=>
      int(0)
    }
    ["result_id"]=>
    object(mysqli_result)#114 (5) {
      ["current_field"]=>
      int(0)
      ["field_count"]=>
      int(4)
      ["lengths"]=>
      NULL
      ["num_rows"]=>
      int(1)
      ["type"]=>
      int(0)
    }
    ["db_debug"]=>
    bool(true)
    ["benchmark"]=>
    float(0.028876543045044)
    ["query_count"]=>
    int(34)
    ["bind_marker"]=>
    string(1) "?"
    ["save_queries"]=>
    bool(true)
    ["queries"]=>
    array(34) {
      [0]=>
      string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
      [1]=>
      string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
      [2]=>
      string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
      [3]=>
      string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
      [4]=>
      string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
      [5]=>
      string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
      [6]=>
      string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
      [7]=>
      string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
      [8]=>
      string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
      [9]=>
      string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
      [10]=>
      string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
      [11]=>
      string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
      [12]=>
      string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
      [13]=>
      string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
      [14]=>
      string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
      [15]=>
      string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
      [16]=>
      string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
      [17]=>
      string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
      [18]=>
      string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
      [19]=>
      string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
      [20]=>
      string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
      [21]=>
      string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
      [22]=>
      string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
      [23]=>
      string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
      [24]=>
      string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
      [25]=>
      string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
      [26]=>
      string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
      [27]=>
      string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
      [28]=>
      string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
      [29]=>
      string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
      [30]=>
      string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
      [31]=>
      string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
      [32]=>
      string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
      [33]=>
      string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
    }
    ["query_times"]=>
    array(34) {
      [0]=>
      float(0.00030183792114258)
      [1]=>
      float(0.00043296813964844)
      [2]=>
      float(0.00072407722473145)
      [3]=>
      float(0.00080490112304688)
      [4]=>
      float(0.00021886825561523)
      [5]=>
      float(0.00030303001403809)
      [6]=>
      float(0.010481119155884)
      [7]=>
      float(0.0019140243530273)
      [8]=>
      float(0.0045070648193359)
      [9]=>
      float(0.00099086761474609)
      [10]=>
      float(0.00025010108947754)
      [11]=>
      float(0.00019598007202148)
      [12]=>
      float(0.00017595291137695)
      [13]=>
      float(0.00020813941955566)
      [14]=>
      float(0.0001671314239502)
      [15]=>
      float(0.00042915344238281)
      [16]=>
      float(0.0015599727630615)
      [17]=>
      float(0.00019407272338867)
      [18]=>
      float(0.0001680850982666)
      [19]=>
      float(0.00015616416931152)
      [20]=>
      float(0.00017094612121582)
      [21]=>
      float(0.00016307830810547)
      [22]=>
      float(0.00014996528625488)
      [23]=>
      float(0.00088620185852051)
      [24]=>
      float(0.00064206123352051)
      [25]=>
      float(0.00022196769714355)
      [26]=>
      float(0.00037789344787598)
      [27]=>
      float(0.00017285346984863)
      [28]=>
      float(0.00018119812011719)
      [29]=>
      float(0.00017380714416504)
      [30]=>
      float(0.00028491020202637)
      [31]=>
      float(0.00028610229492188)
      [32]=>
      float(0.00069594383239746)
      [33]=>
      float(0.00028610229492188)
    }
    ["data_cache"]=>
    array(0) {
    }
    ["trans_enabled"]=>
    bool(true)
    ["trans_strict"]=>
    bool(true)
    ["_trans_depth":protected]=>
    int(0)
    ["_trans_status":protected]=>
    bool(true)
    ["_trans_failure":protected]=>
    bool(false)
    ["cache_on"]=>
    bool(false)
    ["cachedir"]=>
    string(0) ""
    ["cache_autodel"]=>
    bool(false)
    ["CACHE"]=>
    NULL
    ["_protect_identifiers":protected]=>
    bool(true)
    ["_reserved_identifiers":protected]=>
    array(1) {
      [0]=>
      string(1) "*"
    }
    ["_like_escape_str":protected]=>
    string(13) " ESCAPE '%s' "
    ["_like_escape_chr":protected]=>
    string(1) "!"
    ["_random_keyword":protected]=>
    array(2) {
      [0]=>
      string(6) "RAND()"
      [1]=>
      string(8) "RAND(%d)"
    }
    ["_count_string":protected]=>
    string(19) "SELECT COUNT(*) AS "
    ["failover"]=>
    array(0) {
    }
    ["getQueryGrammar"]=>
    object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
      ["selectComponents":protected]=>
      array(11) {
        [0]=>
        string(9) "aggregate"
        [1]=>
        string(7) "columns"
        [2]=>
        string(4) "from"
        [3]=>
        string(5) "joins"
        [4]=>
        string(6) "wheres"
        [5]=>
        string(6) "groups"
        [6]=>
        string(7) "havings"
        [7]=>
        string(6) "orders"
        [8]=>
        string(5) "limit"
        [9]=>
        string(6) "offset"
        [10]=>
        string(4) "lock"
      }
      ["operators":protected]=>
      array(0) {
      }
      ["tablePrefix":protected]=>
      string(0) ""
    }
  }
  ["primaryKey":protected]=>
  string(2) "id"
  ["with":protected]=>
  array(0) {
  }
  ["withCount":protected]=>
  array(0) {
  }
  ["perPage":protected]=>
  int(15)
  ["attributes":protected]=>
  array(7) {
    ["id"]=>
    string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
    ["slug"]=>
    string(13) "role_delegate"
    ["type"]=>
    string(7) "modules"
    ["resources_support"]=>
    NULL
    ["created_at"]=>
    string(19) "2022-03-10 10:12:48"
    ["updated_at"]=>
    string(19) "2022-03-10 10:12:48"
    ["deleted_at"]=>
    NULL
  }
  ["original":protected]=>
  array(9) {
    ["id"]=>
    string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
    ["slug"]=>
    string(13) "role_delegate"
    ["type"]=>
    string(7) "modules"
    ["resources_support"]=>
    NULL
    ["created_at"]=>
    string(19) "2022-03-10 10:12:48"
    ["updated_at"]=>
    string(19) "2022-03-10 10:12:48"
    ["deleted_at"]=>
    NULL
    ["pivot_user_id"]=>
    string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
    ["pivot_role_id"]=>
    string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
  }
  ["relations":protected]=>
  array(2) {
    ["pivot"]=>
    object(App\Model\UsersRoles)#74 (28) {
      ["table":protected]=>
      string(11) "users_roles"
      ["incrementing"]=>
      bool(true)
      ["keyType":protected]=>
      string(6) "string"
      ["timestamps"]=>
      bool(false)
      ["parent":protected]=>
      object(App\Model\User)#54 (25) {
        ["table":protected]=>
        string(5) "users"
        ["primaryKey":protected]=>
        string(2) "id"
        ["incrementing"]=>
        bool(true)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(true)
        ["casts":protected]=>
        array(2) {
          ["allow_email"]=>
          string(7) "integer"
          ["allow_notification"]=>
          string(7) "integer"
        }
        ["fillable":protected]=>
        array(4) {
          [0]=>
          string(10) "first_name"
          [1]=>
          string(9) "last_name"
          [2]=>
          string(5) "email"
          [3]=>
          string(8) "password"
        }
        ["hidden":protected]=>
        array(1) {
          [0]=>
          string(8) "password"
        }
        ["nonRevisionable":protected]=>
        array(4) {
          [0]=>
          string(10) "session_id"
          [1]=>
          string(10) "created_at"
          [2]=>
          string(10) "updated_at"
          [3]=>
          string(10) "deleted_at"
        }
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803847  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803848  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(25) {
          ["id"]=>
          string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
          ["username"]=>
          string(26) "institutboulogne@gmail.com"
          ["password"]=>
          string(60) "$2y$12$Nm.DUduWp1uptsnJifatZuDa6f1C3WpJ.NUvz91e8arKdRSlrvt9m"
          ["first_name"]=>
          string(1) "-"
          ["last_name"]=>
          string(9) "DELPIERRE"
          ["email"]=>
          string(26) "institutboulogne@gmail.com"
          ["allow_email"]=>
          string(1) "1"
          ["allow_notification"]=>
          string(1) "1"
          ["language"]=>
          string(0) ""
          ["timezone"]=>
          string(0) ""
          ["date_format"]=>
          string(0) ""
          ["datetime_format"]=>
          string(0) ""
          ["active"]=>
          string(1) "1"
          ["visible"]=>
          string(1) "0"
          ["session_id"]=>
          string(40) "b9101ab97b023380a09fc407401d1abc975d3ca4"
          ["password_reset_token"]=>
          string(40) "b0fa0da5a027ff0f87065d720912bcef2661154c"
          ["password_reset_datetime"]=>
          string(19) "2021-04-07 10:05:20"
          ["must_change_password"]=>
          string(1) "0"
          ["login_tries"]=>
          NULL
          ["admin_token"]=>
          NULL
          ["admin_token_datetime"]=>
          NULL
          ["has_accepted_eula"]=>
          string(1) "1"
          ["created_at"]=>
          string(19) "2019-11-14 23:00:03"
          ["updated_at"]=>
          string(19) "2025-07-21 10:05:42"
          ["deleted_at"]=>
          NULL
        }
        ["original":protected]=>
        array(25) {
          ["id"]=>
          string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
          ["username"]=>
          string(26) "institutboulogne@gmail.com"
          ["password"]=>
          string(60) "$2y$12$Nm.DUduWp1uptsnJifatZuDa6f1C3WpJ.NUvz91e8arKdRSlrvt9m"
          ["first_name"]=>
          string(1) "-"
          ["last_name"]=>
          string(9) "DELPIERRE"
          ["email"]=>
          string(26) "institutboulogne@gmail.com"
          ["allow_email"]=>
          string(1) "1"
          ["allow_notification"]=>
          string(1) "1"
          ["language"]=>
          string(0) ""
          ["timezone"]=>
          string(0) ""
          ["date_format"]=>
          string(0) ""
          ["datetime_format"]=>
          string(0) ""
          ["active"]=>
          string(1) "1"
          ["visible"]=>
          string(1) "0"
          ["session_id"]=>
          string(40) "b9101ab97b023380a09fc407401d1abc975d3ca4"
          ["password_reset_token"]=>
          string(40) "b0fa0da5a027ff0f87065d720912bcef2661154c"
          ["password_reset_datetime"]=>
          string(19) "2021-04-07 10:05:20"
          ["must_change_password"]=>
          string(1) "0"
          ["login_tries"]=>
          NULL
          ["admin_token"]=>
          NULL
          ["admin_token_datetime"]=>
          NULL
          ["has_accepted_eula"]=>
          string(1) "1"
          ["created_at"]=>
          string(19) "2019-11-14 23:00:03"
          ["updated_at"]=>
          string(19) "2025-07-21 10:05:42"
          ["deleted_at"]=>
          NULL
        }
        ["relations":protected]=>
        array(1) {
          ["roles"]=>
          array(3) {
            [0]=>
            object(App\Model\Role)#79 (24) {
              ["table":protected]=>
              string(5) "roles"
              ["incrementing"]=>
              bool(true)
              ["keyType":protected]=>
              string(6) "string"
              ["timestamps"]=>
              bool(true)
              ["connection":protected]=>
              object(CI_DB_mysqli_driver)#34 (46) {
                ["dbdriver"]=>
                string(6) "mysqli"
                ["compress"]=>
                bool(false)
                ["delete_hack"]=>
                bool(true)
                ["stricton"]=>
                bool(false)
                ["_escape_char":protected]=>
                string(1) "`"
                ["_mysqli":protected]=>
                object(mysqli)#35 (19) {
                  ["affected_rows"]=>
                  int(-1)
                  ["client_info"]=>
                  string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                  ["client_version"]=>
                  int(50012)
                  ["connect_errno"]=>
                  int(0)
                  ["connect_error"]=>
                  NULL
                  ["errno"]=>
                  int(0)
                  ["error"]=>
                  string(0) ""
                  ["error_list"]=>
                  array(0) {
                  }
                  ["field_count"]=>
                  int(4)
                  ["host_info"]=>
                  string(25) "Localhost via UNIX socket"
                  ["info"]=>
                  NULL
                  ["insert_id"]=>
                  int(0)
                  ["server_info"]=>
                  string(23) "8.0.42-0ubuntu0.24.04.1"
                  ["server_version"]=>
                  int(80042)
                  ["stat"]=>
                  string(142) "Uptime: 348330  Threads: 2  Questions: 803849  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                  ["sqlstate"]=>
                  string(5) "00000"
                  ["protocol_version"]=>
                  int(10)
                  ["thread_id"]=>
                  int(4156)
                  ["warning_count"]=>
                  int(0)
                }
                ["dsn"]=>
                string(0) ""
                ["username"]=>
                string(4) "user"
                ["password"]=>
                string(8) "password"
                ["hostname"]=>
                string(9) "localhost"
                ["database"]=>
                string(18) "guinot_portail_rec"
                ["subdriver"]=>
                NULL
                ["dbprefix"]=>
                string(0) ""
                ["char_set"]=>
                string(4) "utf8"
                ["dbcollat"]=>
                string(15) "utf8_general_ci"
                ["encrypt"]=>
                bool(false)
                ["swap_pre"]=>
                string(0) ""
                ["port"]=>
                string(0) ""
                ["pconnect"]=>
                bool(false)
                ["conn_id"]=>
                object(mysqli)#35 (19) {
                  ["affected_rows"]=>
                  int(-1)
                  ["client_info"]=>
                  string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                  ["client_version"]=>
                  int(50012)
                  ["connect_errno"]=>
                  int(0)
                  ["connect_error"]=>
                  NULL
                  ["errno"]=>
                  int(0)
                  ["error"]=>
                  string(0) ""
                  ["error_list"]=>
                  array(0) {
                  }
                  ["field_count"]=>
                  int(4)
                  ["host_info"]=>
                  string(25) "Localhost via UNIX socket"
                  ["info"]=>
                  NULL
                  ["insert_id"]=>
                  int(0)
                  ["server_info"]=>
                  string(23) "8.0.42-0ubuntu0.24.04.1"
                  ["server_version"]=>
                  int(80042)
                  ["stat"]=>
                  string(142) "Uptime: 348330  Threads: 2  Questions: 803850  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                  ["sqlstate"]=>
                  string(5) "00000"
                  ["protocol_version"]=>
                  int(10)
                  ["thread_id"]=>
                  int(4156)
                  ["warning_count"]=>
                  int(0)
                }
                ["result_id"]=>
                object(mysqli_result)#114 (5) {
                  ["current_field"]=>
                  int(0)
                  ["field_count"]=>
                  int(4)
                  ["lengths"]=>
                  NULL
                  ["num_rows"]=>
                  int(1)
                  ["type"]=>
                  int(0)
                }
                ["db_debug"]=>
                bool(true)
                ["benchmark"]=>
                float(0.028876543045044)
                ["query_count"]=>
                int(34)
                ["bind_marker"]=>
                string(1) "?"
                ["save_queries"]=>
                bool(true)
                ["queries"]=>
                array(34) {
                  [0]=>
                  string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
                  [1]=>
                  string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
                  [2]=>
                  string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
                  [3]=>
                  string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
                  [4]=>
                  string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
                  [5]=>
                  string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
                  [6]=>
                  string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
                  [7]=>
                  string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
                  [8]=>
                  string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
                  [9]=>
                  string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
                  [10]=>
                  string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                  [11]=>
                  string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                  [12]=>
                  string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                  [13]=>
                  string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                  [14]=>
                  string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                  [15]=>
                  string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                  [16]=>
                  string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                  [17]=>
                  string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                  [18]=>
                  string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                  [19]=>
                  string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                  [20]=>
                  string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                  [21]=>
                  string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                  [22]=>
                  string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                  [23]=>
                  string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                  [24]=>
                  string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                  [25]=>
                  string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                  [26]=>
                  string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                  [27]=>
                  string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
                  [28]=>
                  string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                  [29]=>
                  string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                  [30]=>
                  string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
                  [31]=>
                  string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
                  [32]=>
                  string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                  [33]=>
                  string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
                }
                ["query_times"]=>
                array(34) {
                  [0]=>
                  float(0.00030183792114258)
                  [1]=>
                  float(0.00043296813964844)
                  [2]=>
                  float(0.00072407722473145)
                  [3]=>
                  float(0.00080490112304688)
                  [4]=>
                  float(0.00021886825561523)
                  [5]=>
                  float(0.00030303001403809)
                  [6]=>
                  float(0.010481119155884)
                  [7]=>
                  float(0.0019140243530273)
                  [8]=>
                  float(0.0045070648193359)
                  [9]=>
                  float(0.00099086761474609)
                  [10]=>
                  float(0.00025010108947754)
                  [11]=>
                  float(0.00019598007202148)
                  [12]=>
                  float(0.00017595291137695)
                  [13]=>
                  float(0.00020813941955566)
                  [14]=>
                  float(0.0001671314239502)
                  [15]=>
                  float(0.00042915344238281)
                  [16]=>
                  float(0.0015599727630615)
                  [17]=>
                  float(0.00019407272338867)
                  [18]=>
                  float(0.0001680850982666)
                  [19]=>
                  float(0.00015616416931152)
                  [20]=>
                  float(0.00017094612121582)
                  [21]=>
                  float(0.00016307830810547)
                  [22]=>
                  float(0.00014996528625488)
                  [23]=>
                  float(0.00088620185852051)
                  [24]=>
                  float(0.00064206123352051)
                  [25]=>
                  float(0.00022196769714355)
                  [26]=>
                  float(0.00037789344787598)
                  [27]=>
                  float(0.00017285346984863)
                  [28]=>
                  float(0.00018119812011719)
                  [29]=>
                  float(0.00017380714416504)
                  [30]=>
                  float(0.00028491020202637)
                  [31]=>
                  float(0.00028610229492188)
                  [32]=>
                  float(0.00069594383239746)
                  [33]=>
                  float(0.00028610229492188)
                }
                ["data_cache"]=>
                array(0) {
                }
                ["trans_enabled"]=>
                bool(true)
                ["trans_strict"]=>
                bool(true)
                ["_trans_depth":protected]=>
                int(0)
                ["_trans_status":protected]=>
                bool(true)
                ["_trans_failure":protected]=>
                bool(false)
                ["cache_on"]=>
                bool(false)
                ["cachedir"]=>
                string(0) ""
                ["cache_autodel"]=>
                bool(false)
                ["CACHE"]=>
                NULL
                ["_protect_identifiers":protected]=>
                bool(true)
                ["_reserved_identifiers":protected]=>
                array(1) {
                  [0]=>
                  string(1) "*"
                }
                ["_like_escape_str":protected]=>
                string(13) " ESCAPE '%s' "
                ["_like_escape_chr":protected]=>
                string(1) "!"
                ["_random_keyword":protected]=>
                array(2) {
                  [0]=>
                  string(6) "RAND()"
                  [1]=>
                  string(8) "RAND(%d)"
                }
                ["_count_string":protected]=>
                string(19) "SELECT COUNT(*) AS "
                ["failover"]=>
                array(0) {
                }
                ["getQueryGrammar"]=>
                object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
                  ["selectComponents":protected]=>
                  array(11) {
                    [0]=>
                    string(9) "aggregate"
                    [1]=>
                    string(7) "columns"
                    [2]=>
                    string(4) "from"
                    [3]=>
                    string(5) "joins"
                    [4]=>
                    string(6) "wheres"
                    [5]=>
                    string(6) "groups"
                    [6]=>
                    string(7) "havings"
                    [7]=>
                    string(6) "orders"
                    [8]=>
                    string(5) "limit"
                    [9]=>
                    string(6) "offset"
                    [10]=>
                    string(4) "lock"
                  }
                  ["operators":protected]=>
                  array(0) {
                  }
                  ["tablePrefix":protected]=>
                  string(0) ""
                }
              }
              ["primaryKey":protected]=>
              string(2) "id"
              ["with":protected]=>
              array(0) {
              }
              ["withCount":protected]=>
              array(0) {
              }
              ["perPage":protected]=>
              int(15)
              ["attributes":protected]=>
              array(7) {
                ["id"]=>
                string(8) "customer"
                ["slug"]=>
                string(13) "role_customer"
                ["type"]=>
                string(7) "default"
                ["resources_support"]=>
                string(55) "a:1:{i:0;s:37:"\App\Service\Secure\Resource\Customer";}"
                ["created_at"]=>
                string(19) "2017-06-19 15:54:00"
                ["updated_at"]=>
                string(19) "2017-06-19 15:54:00"
                ["deleted_at"]=>
                NULL
              }
              ["original":protected]=>
              array(9) {
                ["id"]=>
                string(8) "customer"
                ["slug"]=>
                string(13) "role_customer"
                ["type"]=>
                string(7) "default"
                ["resources_support"]=>
                string(55) "a:1:{i:0;s:37:"\App\Service\Secure\Resource\Customer";}"
                ["created_at"]=>
                string(19) "2017-06-19 15:54:00"
                ["updated_at"]=>
                string(19) "2017-06-19 15:54:00"
                ["deleted_at"]=>
                NULL
                ["pivot_user_id"]=>
                string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
                ["pivot_role_id"]=>
                string(8) "customer"
              }
              ["relations":protected]=>
              array(2) {
                ["pivot"]=>
                object(App\Model\UsersRoles)#75 (28) {
                  ["table":protected]=>
                  string(11) "users_roles"
                  ["incrementing"]=>
                  bool(true)
                  ["keyType":protected]=>
                  string(6) "string"
                  ["timestamps"]=>
                  bool(false)
                  ["parent":protected]=>
                  *RECURSION*
                  ["foreignKey":protected]=>
                  string(7) "user_id"
                  ["relatedKey":protected]=>
                  string(7) "role_id"
                  ["guarded":protected]=>
                  array(0) {
                  }
                  ["include":protected]=>
                  array(0) {
                  }
                  ["connection":protected]=>
                  object(CI_DB_mysqli_driver)#34 (46) {
                    ["dbdriver"]=>
                    string(6) "mysqli"
                    ["compress"]=>
                    bool(false)
                    ["delete_hack"]=>
                    bool(true)
                    ["stricton"]=>
                    bool(false)
                    ["_escape_char":protected]=>
                    string(1) "`"
                    ["_mysqli":protected]=>
                    object(mysqli)#35 (19) {
                      ["affected_rows"]=>
                      int(-1)
                      ["client_info"]=>
                      string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                      ["client_version"]=>
                      int(50012)
                      ["connect_errno"]=>
                      int(0)
                      ["connect_error"]=>
                      NULL
                      ["errno"]=>
                      int(0)
                      ["error"]=>
                      string(0) ""
                      ["error_list"]=>
                      array(0) {
                      }
                      ["field_count"]=>
                      int(4)
                      ["host_info"]=>
                      string(25) "Localhost via UNIX socket"
                      ["info"]=>
                      NULL
                      ["insert_id"]=>
                      int(0)
                      ["server_info"]=>
                      string(23) "8.0.42-0ubuntu0.24.04.1"
                      ["server_version"]=>
                      int(80042)
                      ["stat"]=>
                      string(142) "Uptime: 348330  Threads: 2  Questions: 803851  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                      ["sqlstate"]=>
                      string(5) "00000"
                      ["protocol_version"]=>
                      int(10)
                      ["thread_id"]=>
                      int(4156)
                      ["warning_count"]=>
                      int(0)
                    }
                    ["dsn"]=>
                    string(0) ""
                    ["username"]=>
                    string(4) "user"
                    ["password"]=>
                    string(8) "password"
                    ["hostname"]=>
                    string(9) "localhost"
                    ["database"]=>
                    string(18) "guinot_portail_rec"
                    ["subdriver"]=>
                    NULL
                    ["dbprefix"]=>
                    string(0) ""
                    ["char_set"]=>
                    string(4) "utf8"
                    ["dbcollat"]=>
                    string(15) "utf8_general_ci"
                    ["encrypt"]=>
                    bool(false)
                    ["swap_pre"]=>
                    string(0) ""
                    ["port"]=>
                    string(0) ""
                    ["pconnect"]=>
                    bool(false)
                    ["conn_id"]=>
                    object(mysqli)#35 (19) {
                      ["affected_rows"]=>
                      int(-1)
                      ["client_info"]=>
                      string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                      ["client_version"]=>
                      int(50012)
                      ["connect_errno"]=>
                      int(0)
                      ["connect_error"]=>
                      NULL
                      ["errno"]=>
                      int(0)
                      ["error"]=>
                      string(0) ""
                      ["error_list"]=>
                      array(0) {
                      }
                      ["field_count"]=>
                      int(4)
                      ["host_info"]=>
                      string(25) "Localhost via UNIX socket"
                      ["info"]=>
                      NULL
                      ["insert_id"]=>
                      int(0)
                      ["server_info"]=>
                      string(23) "8.0.42-0ubuntu0.24.04.1"
                      ["server_version"]=>
                      int(80042)
                      ["stat"]=>
                      string(142) "Uptime: 348330  Threads: 2  Questions: 803852  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                      ["sqlstate"]=>
                      string(5) "00000"
                      ["protocol_version"]=>
                      int(10)
                      ["thread_id"]=>
                      int(4156)
                      ["warning_count"]=>
                      int(0)
                    }
                    ["result_id"]=>
                    object(mysqli_result)#114 (5) {
                      ["current_field"]=>
                      int(0)
                      ["field_count"]=>
                      int(4)
                      ["lengths"]=>
                      NULL
                      ["num_rows"]=>
                      int(1)
                      ["type"]=>
                      int(0)
                    }
                    ["db_debug"]=>
                    bool(true)
                    ["benchmark"]=>
                    float(0.028876543045044)
                    ["query_count"]=>
                    int(34)
                    ["bind_marker"]=>
                    string(1) "?"
                    ["save_queries"]=>
                    bool(true)
                    ["queries"]=>
                    array(34) {
                      [0]=>
                      string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
                      [1]=>
                      string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
                      [2]=>
                      string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
                      [3]=>
                      string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
                      [4]=>
                      string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
                      [5]=>
                      string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
                      [6]=>
                      string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
                      [7]=>
                      string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
                      [8]=>
                      string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
                      [9]=>
                      string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
                      [10]=>
                      string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                      [11]=>
                      string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                      [12]=>
                      string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                      [13]=>
                      string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                      [14]=>
                      string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                      [15]=>
                      string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                      [16]=>
                      string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                      [17]=>
                      string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                      [18]=>
                      string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                      [19]=>
                      string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                      [20]=>
                      string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                      [21]=>
                      string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                      [22]=>
                      string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                      [23]=>
                      string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                      [24]=>
                      string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                      [25]=>
                      string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                      [26]=>
                      string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                      [27]=>
                      string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
                      [28]=>
                      string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                      [29]=>
                      string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                      [30]=>
                      string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
                      [31]=>
                      string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
                      [32]=>
                      string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                      [33]=>
                      string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
                    }
                    ["query_times"]=>
                    array(34) {
                      [0]=>
                      float(0.00030183792114258)
                      [1]=>
                      float(0.00043296813964844)
                      [2]=>
                      float(0.00072407722473145)
                      [3]=>
                      float(0.00080490112304688)
                      [4]=>
                      float(0.00021886825561523)
                      [5]=>
                      float(0.00030303001403809)
                      [6]=>
                      float(0.010481119155884)
                      [7]=>
                      float(0.0019140243530273)
                      [8]=>
                      float(0.0045070648193359)
                      [9]=>
                      float(0.00099086761474609)
                      [10]=>
                      float(0.00025010108947754)
                      [11]=>
                      float(0.00019598007202148)
                      [12]=>
                      float(0.00017595291137695)
                      [13]=>
                      float(0.00020813941955566)
                      [14]=>
                      float(0.0001671314239502)
                      [15]=>
                      float(0.00042915344238281)
                      [16]=>
                      float(0.0015599727630615)
                      [17]=>
                      float(0.00019407272338867)
                      [18]=>
                      float(0.0001680850982666)
                      [19]=>
                      float(0.00015616416931152)
                      [20]=>
                      float(0.00017094612121582)
                      [21]=>
                      float(0.00016307830810547)
                      [22]=>
                      float(0.00014996528625488)
                      [23]=>
                      float(0.00088620185852051)
                      [24]=>
                      float(0.00064206123352051)
                      [25]=>
                      float(0.00022196769714355)
                      [26]=>
                      float(0.00037789344787598)
                      [27]=>
                      float(0.00017285346984863)
                      [28]=>
                      float(0.00018119812011719)
                      [29]=>
                      float(0.00017380714416504)
                      [30]=>
                      float(0.00028491020202637)
                      [31]=>
                      float(0.00028610229492188)
                      [32]=>
                      float(0.00069594383239746)
                      [33]=>
                      float(0.00028610229492188)
                    }
                    ["data_cache"]=>
                    array(0) {
                    }
                    ["trans_enabled"]=>
                    bool(true)
                    ["trans_strict"]=>
                    bool(true)
                    ["_trans_depth":protected]=>
                    int(0)
                    ["_trans_status":protected]=>
                    bool(true)
                    ["_trans_failure":protected]=>
                    bool(false)
                    ["cache_on"]=>
                    bool(false)
                    ["cachedir"]=>
                    string(0) ""
                    ["cache_autodel"]=>
                    bool(false)
                    ["CACHE"]=>
                    NULL
                    ["_protect_identifiers":protected]=>
                    bool(true)
                    ["_reserved_identifiers":protected]=>
                    array(1) {
                      [0]=>
                      string(1) "*"
                    }
                    ["_like_escape_str":protected]=>
                    string(13) " ESCAPE '%s' "
                    ["_like_escape_chr":protected]=>
                    string(1) "!"
                    ["_random_keyword":protected]=>
                    array(2) {
                      [0]=>
                      string(6) "RAND()"
                      [1]=>
                      string(8) "RAND(%d)"
                    }
                    ["_count_string":protected]=>
                    string(19) "SELECT COUNT(*) AS "
                    ["failover"]=>
                    array(0) {
                    }
                    ["getQueryGrammar"]=>
                    object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
                      ["selectComponents":protected]=>
                      array(11) {
                        [0]=>
                        string(9) "aggregate"
                        [1]=>
                        string(7) "columns"
                        [2]=>
                        string(4) "from"
                        [3]=>
                        string(5) "joins"
                        [4]=>
                        string(6) "wheres"
                        [5]=>
                        string(6) "groups"
                        [6]=>
                        string(7) "havings"
                        [7]=>
                        string(6) "orders"
                        [8]=>
                        string(5) "limit"
                        [9]=>
                        string(6) "offset"
                        [10]=>
                        string(4) "lock"
                      }
                      ["operators":protected]=>
                      array(0) {
                      }
                      ["tablePrefix":protected]=>
                      string(0) ""
                    }
                  }
                  ["primaryKey":protected]=>
                  string(2) "id"
                  ["with":protected]=>
                  array(0) {
                  }
                  ["withCount":protected]=>
                  array(0) {
                  }
                  ["perPage":protected]=>
                  int(15)
                  ["attributes":protected]=>
                  array(2) {
                    ["user_id"]=>
                    string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
                    ["role_id"]=>
                    string(8) "customer"
                  }
                  ["original":protected]=>
                  array(2) {
                    ["user_id"]=>
                    string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
                    ["role_id"]=>
                    string(8) "customer"
                  }
                  ["relations":protected]=>
                  array(0) {
                  }
                  ["hidden":protected]=>
                  array(0) {
                  }
                  ["visible":protected]=>
                  array(0) {
                  }
                  ["appends":protected]=>
                  array(0) {
                  }
                  ["fillable":protected]=>
                  array(0) {
                  }
                  ["dates":protected]=>
                  array(0) {
                  }
                  ["dateFormat":protected]=>
                  NULL
                  ["casts":protected]=>
                  array(0) {
                  }
                  ["touches":protected]=>
                  array(0) {
                  }
                  ["observables":protected]=>
                  array(0) {
                  }
                  ["exists"]=>
                  bool(true)
                  ["wasRecentlyCreated"]=>
                  bool(false)
                }
                ["permissions"]=>
                array(1) {
                  [0]=>
                  object(App\Model\Permissions)#83 (24) {
                    ["table":protected]=>
                    string(17) "roles_permissions"
                    ["incrementing"]=>
                    bool(false)
                    ["keyType":protected]=>
                    string(6) "string"
                    ["timestamps"]=>
                    bool(false)
                    ["connection":protected]=>
                    object(CI_DB_mysqli_driver)#34 (46) {
                      ["dbdriver"]=>
                      string(6) "mysqli"
                      ["compress"]=>
                      bool(false)
                      ["delete_hack"]=>
                      bool(true)
                      ["stricton"]=>
                      bool(false)
                      ["_escape_char":protected]=>
                      string(1) "`"
                      ["_mysqli":protected]=>
                      object(mysqli)#35 (19) {
                        ["affected_rows"]=>
                        int(-1)
                        ["client_info"]=>
                        string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                        ["client_version"]=>
                        int(50012)
                        ["connect_errno"]=>
                        int(0)
                        ["connect_error"]=>
                        NULL
                        ["errno"]=>
                        int(0)
                        ["error"]=>
                        string(0) ""
                        ["error_list"]=>
                        array(0) {
                        }
                        ["field_count"]=>
                        int(4)
                        ["host_info"]=>
                        string(25) "Localhost via UNIX socket"
                        ["info"]=>
                        NULL
                        ["insert_id"]=>
                        int(0)
                        ["server_info"]=>
                        string(23) "8.0.42-0ubuntu0.24.04.1"
                        ["server_version"]=>
                        int(80042)
                        ["stat"]=>
                        string(142) "Uptime: 348330  Threads: 2  Questions: 803853  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                        ["sqlstate"]=>
                        string(5) "00000"
                        ["protocol_version"]=>
                        int(10)
                        ["thread_id"]=>
                        int(4156)
                        ["warning_count"]=>
                        int(0)
                      }
                      ["dsn"]=>
                      string(0) ""
                      ["username"]=>
                      string(4) "user"
                      ["password"]=>
                      string(8) "password"
                      ["hostname"]=>
                      string(9) "localhost"
                      ["database"]=>
                      string(18) "guinot_portail_rec"
                      ["subdriver"]=>
                      NULL
                      ["dbprefix"]=>
                      string(0) ""
                      ["char_set"]=>
                      string(4) "utf8"
                      ["dbcollat"]=>
                      string(15) "utf8_general_ci"
                      ["encrypt"]=>
                      bool(false)
                      ["swap_pre"]=>
                      string(0) ""
                      ["port"]=>
                      string(0) ""
                      ["pconnect"]=>
                      bool(false)
                      ["conn_id"]=>
                      object(mysqli)#35 (19) {
                        ["affected_rows"]=>
                        int(-1)
                        ["client_info"]=>
                        string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                        ["client_version"]=>
                        int(50012)
                        ["connect_errno"]=>
                        int(0)
                        ["connect_error"]=>
                        NULL
                        ["errno"]=>
                        int(0)
                        ["error"]=>
                        string(0) ""
                        ["error_list"]=>
                        array(0) {
                        }
                        ["field_count"]=>
                        int(4)
                        ["host_info"]=>
                        string(25) "Localhost via UNIX socket"
                        ["info"]=>
                        NULL
                        ["insert_id"]=>
                        int(0)
                        ["server_info"]=>
                        string(23) "8.0.42-0ubuntu0.24.04.1"
                        ["server_version"]=>
                        int(80042)
                        ["stat"]=>
                        string(142) "Uptime: 348330  Threads: 2  Questions: 803854  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                        ["sqlstate"]=>
                        string(5) "00000"
                        ["protocol_version"]=>
                        int(10)
                        ["thread_id"]=>
                        int(4156)
                        ["warning_count"]=>
                        int(0)
                      }
                      ["result_id"]=>
                      object(mysqli_result)#114 (5) {
                        ["current_field"]=>
                        int(0)
                        ["field_count"]=>
                        int(4)
                        ["lengths"]=>
                        NULL
                        ["num_rows"]=>
                        int(1)
                        ["type"]=>
                        int(0)
                      }
                      ["db_debug"]=>
                      bool(true)
                      ["benchmark"]=>
                      float(0.028876543045044)
                      ["query_count"]=>
                      int(34)
                      ["bind_marker"]=>
                      string(1) "?"
                      ["save_queries"]=>
                      bool(true)
                      ["queries"]=>
                      array(34) {
                        [0]=>
                        string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
                        [1]=>
                        string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
                        [2]=>
                        string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
                        [3]=>
                        string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
                        [4]=>
                        string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
                        [5]=>
                        string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
                        [6]=>
                        string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
                        [7]=>
                        string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
                        [8]=>
                        string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
                        [9]=>
                        string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
                        [10]=>
                        string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                        [11]=>
                        string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                        [12]=>
                        string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                        [13]=>
                        string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                        [14]=>
                        string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                        [15]=>
                        string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                        [16]=>
                        string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                        [17]=>
                        string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                        [18]=>
                        string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                        [19]=>
                        string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                        [20]=>
                        string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                        [21]=>
                        string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                        [22]=>
                        string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                        [23]=>
                        string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                        [24]=>
                        string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                        [25]=>
                        string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                        [26]=>
                        string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                        [27]=>
                        string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
                        [28]=>
                        string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                        [29]=>
                        string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                        [30]=>
                        string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
                        [31]=>
                        string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
                        [32]=>
                        string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                        [33]=>
                        string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
                      }
                      ["query_times"]=>
                      array(34) {
                        [0]=>
                        float(0.00030183792114258)
                        [1]=>
                        float(0.00043296813964844)
                        [2]=>
                        float(0.00072407722473145)
                        [3]=>
                        float(0.00080490112304688)
                        [4]=>
                        float(0.00021886825561523)
                        [5]=>
                        float(0.00030303001403809)
                        [6]=>
                        float(0.010481119155884)
                        [7]=>
                        float(0.0019140243530273)
                        [8]=>
                        float(0.0045070648193359)
                        [9]=>
                        float(0.00099086761474609)
                        [10]=>
                        float(0.00025010108947754)
                        [11]=>
                        float(0.00019598007202148)
                        [12]=>
                        float(0.00017595291137695)
                        [13]=>
                        float(0.00020813941955566)
                        [14]=>
                        float(0.0001671314239502)
                        [15]=>
                        float(0.00042915344238281)
                        [16]=>
                        float(0.0015599727630615)
                        [17]=>
                        float(0.00019407272338867)
                        [18]=>
                        float(0.0001680850982666)
                        [19]=>
                        float(0.00015616416931152)
                        [20]=>
                        float(0.00017094612121582)
                        [21]=>
                        float(0.00016307830810547)
                        [22]=>
                        float(0.00014996528625488)
                        [23]=>
                        float(0.00088620185852051)
                        [24]=>
                        float(0.00064206123352051)
                        [25]=>
                        float(0.00022196769714355)
                        [26]=>
                        float(0.00037789344787598)
                        [27]=>
                        float(0.00017285346984863)
                        [28]=>
                        float(0.00018119812011719)
                        [29]=>
                        float(0.00017380714416504)
                        [30]=>
                        float(0.00028491020202637)
                        [31]=>
                        float(0.00028610229492188)
                        [32]=>
                        float(0.00069594383239746)
                        [33]=>
                        float(0.00028610229492188)
                      }
                      ["data_cache"]=>
                      array(0) {
                      }
                      ["trans_enabled"]=>
                      bool(true)
                      ["trans_strict"]=>
                      bool(true)
                      ["_trans_depth":protected]=>
                      int(0)
                      ["_trans_status":protected]=>
                      bool(true)
                      ["_trans_failure":protected]=>
                      bool(false)
                      ["cache_on"]=>
                      bool(false)
                      ["cachedir"]=>
                      string(0) ""
                      ["cache_autodel"]=>
                      bool(false)
                      ["CACHE"]=>
                      NULL
                      ["_protect_identifiers":protected]=>
                      bool(true)
                      ["_reserved_identifiers":protected]=>
                      array(1) {
                        [0]=>
                        string(1) "*"
                      }
                      ["_like_escape_str":protected]=>
                      string(13) " ESCAPE '%s' "
                      ["_like_escape_chr":protected]=>
                      string(1) "!"
                      ["_random_keyword":protected]=>
                      array(2) {
                        [0]=>
                        string(6) "RAND()"
                        [1]=>
                        string(8) "RAND(%d)"
                      }
                      ["_count_string":protected]=>
                      string(19) "SELECT COUNT(*) AS "
                      ["failover"]=>
                      array(0) {
                      }
                      ["getQueryGrammar"]=>
                      object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
                        ["selectComponents":protected]=>
                        array(11) {
                          [0]=>
                          string(9) "aggregate"
                          [1]=>
                          string(7) "columns"
                          [2]=>
                          string(4) "from"
                          [3]=>
                          string(5) "joins"
                          [4]=>
                          string(6) "wheres"
                          [5]=>
                          string(6) "groups"
                          [6]=>
                          string(7) "havings"
                          [7]=>
                          string(6) "orders"
                          [8]=>
                          string(5) "limit"
                          [9]=>
                          string(6) "offset"
                          [10]=>
                          string(4) "lock"
                        }
                        ["operators":protected]=>
                        array(0) {
                        }
                        ["tablePrefix":protected]=>
                        string(0) ""
                      }
                    }
                    ["primaryKey":protected]=>
                    string(2) "id"
                    ["with":protected]=>
                    array(0) {
                    }
                    ["withCount":protected]=>
                    array(0) {
                    }
                    ["perPage":protected]=>
                    int(15)
                    ["attributes":protected]=>
                    array(2) {
                      ["role_id"]=>
                      string(8) "customer"
                      ["permission_name"]=>
                      string(10) "webservice"
                    }
                    ["original":protected]=>
                    array(2) {
                      ["role_id"]=>
                      string(8) "customer"
                      ["permission_name"]=>
                      string(10) "webservice"
                    }
                    ["relations":protected]=>
                    array(0) {
                    }
                    ["hidden":protected]=>
                    array(0) {
                    }
                    ["visible":protected]=>
                    array(0) {
                    }
                    ["appends":protected]=>
                    array(0) {
                    }
                    ["fillable":protected]=>
                    array(0) {
                    }
                    ["guarded":protected]=>
                    array(1) {
                      [0]=>
                      string(1) "*"
                    }
                    ["dates":protected]=>
                    array(0) {
                    }
                    ["dateFormat":protected]=>
                    NULL
                    ["casts":protected]=>
                    array(0) {
                    }
                    ["touches":protected]=>
                    array(0) {
                    }
                    ["observables":protected]=>
                    array(0) {
                    }
                    ["exists"]=>
                    bool(true)
                    ["wasRecentlyCreated"]=>
                    bool(false)
                  }
                }
              }
              ["hidden":protected]=>
              array(0) {
              }
              ["visible":protected]=>
              array(0) {
              }
              ["appends":protected]=>
              array(0) {
              }
              ["fillable":protected]=>
              array(0) {
              }
              ["guarded":protected]=>
              array(1) {
                [0]=>
                string(1) "*"
              }
              ["dates":protected]=>
              array(0) {
              }
              ["dateFormat":protected]=>
              NULL
              ["casts":protected]=>
              array(0) {
              }
              ["touches":protected]=>
              array(0) {
              }
              ["observables":protected]=>
              array(0) {
              }
              ["exists"]=>
              bool(true)
              ["wasRecentlyCreated"]=>
              bool(false)
            }
            [1]=>
            *RECURSION*
            [2]=>
            object(App\Model\Role)#81 (24) {
              ["table":protected]=>
              string(5) "roles"
              ["incrementing"]=>
              bool(true)
              ["keyType":protected]=>
              string(6) "string"
              ["timestamps"]=>
              bool(true)
              ["connection":protected]=>
              object(CI_DB_mysqli_driver)#34 (46) {
                ["dbdriver"]=>
                string(6) "mysqli"
                ["compress"]=>
                bool(false)
                ["delete_hack"]=>
                bool(true)
                ["stricton"]=>
                bool(false)
                ["_escape_char":protected]=>
                string(1) "`"
                ["_mysqli":protected]=>
                object(mysqli)#35 (19) {
                  ["affected_rows"]=>
                  int(-1)
                  ["client_info"]=>
                  string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                  ["client_version"]=>
                  int(50012)
                  ["connect_errno"]=>
                  int(0)
                  ["connect_error"]=>
                  NULL
                  ["errno"]=>
                  int(0)
                  ["error"]=>
                  string(0) ""
                  ["error_list"]=>
                  array(0) {
                  }
                  ["field_count"]=>
                  int(4)
                  ["host_info"]=>
                  string(25) "Localhost via UNIX socket"
                  ["info"]=>
                  NULL
                  ["insert_id"]=>
                  int(0)
                  ["server_info"]=>
                  string(23) "8.0.42-0ubuntu0.24.04.1"
                  ["server_version"]=>
                  int(80042)
                  ["stat"]=>
                  string(142) "Uptime: 348330  Threads: 2  Questions: 803855  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                  ["sqlstate"]=>
                  string(5) "00000"
                  ["protocol_version"]=>
                  int(10)
                  ["thread_id"]=>
                  int(4156)
                  ["warning_count"]=>
                  int(0)
                }
                ["dsn"]=>
                string(0) ""
                ["username"]=>
                string(4) "user"
                ["password"]=>
                string(8) "password"
                ["hostname"]=>
                string(9) "localhost"
                ["database"]=>
                string(18) "guinot_portail_rec"
                ["subdriver"]=>
                NULL
                ["dbprefix"]=>
                string(0) ""
                ["char_set"]=>
                string(4) "utf8"
                ["dbcollat"]=>
                string(15) "utf8_general_ci"
                ["encrypt"]=>
                bool(false)
                ["swap_pre"]=>
                string(0) ""
                ["port"]=>
                string(0) ""
                ["pconnect"]=>
                bool(false)
                ["conn_id"]=>
                object(mysqli)#35 (19) {
                  ["affected_rows"]=>
                  int(-1)
                  ["client_info"]=>
                  string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                  ["client_version"]=>
                  int(50012)
                  ["connect_errno"]=>
                  int(0)
                  ["connect_error"]=>
                  NULL
                  ["errno"]=>
                  int(0)
                  ["error"]=>
                  string(0) ""
                  ["error_list"]=>
                  array(0) {
                  }
                  ["field_count"]=>
                  int(4)
                  ["host_info"]=>
                  string(25) "Localhost via UNIX socket"
                  ["info"]=>
                  NULL
                  ["insert_id"]=>
                  int(0)
                  ["server_info"]=>
                  string(23) "8.0.42-0ubuntu0.24.04.1"
                  ["server_version"]=>
                  int(80042)
                  ["stat"]=>
                  string(142) "Uptime: 348330  Threads: 2  Questions: 803856  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                  ["sqlstate"]=>
                  string(5) "00000"
                  ["protocol_version"]=>
                  int(10)
                  ["thread_id"]=>
                  int(4156)
                  ["warning_count"]=>
                  int(0)
                }
                ["result_id"]=>
                object(mysqli_result)#114 (5) {
                  ["current_field"]=>
                  int(0)
                  ["field_count"]=>
                  int(4)
                  ["lengths"]=>
                  NULL
                  ["num_rows"]=>
                  int(1)
                  ["type"]=>
                  int(0)
                }
                ["db_debug"]=>
                bool(true)
                ["benchmark"]=>
                float(0.028876543045044)
                ["query_count"]=>
                int(34)
                ["bind_marker"]=>
                string(1) "?"
                ["save_queries"]=>
                bool(true)
                ["queries"]=>
                array(34) {
                  [0]=>
                  string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
                  [1]=>
                  string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
                  [2]=>
                  string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
                  [3]=>
                  string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
                  [4]=>
                  string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
                  [5]=>
                  string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
                  [6]=>
                  string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
                  [7]=>
                  string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
                  [8]=>
                  string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
                  [9]=>
                  string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
                  [10]=>
                  string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                  [11]=>
                  string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                  [12]=>
                  string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                  [13]=>
                  string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                  [14]=>
                  string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                  [15]=>
                  string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                  [16]=>
                  string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                  [17]=>
                  string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                  [18]=>
                  string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                  [19]=>
                  string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                  [20]=>
                  string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                  [21]=>
                  string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                  [22]=>
                  string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                  [23]=>
                  string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                  [24]=>
                  string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                  [25]=>
                  string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                  [26]=>
                  string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                  [27]=>
                  string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
                  [28]=>
                  string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                  [29]=>
                  string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                  [30]=>
                  string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
                  [31]=>
                  string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
                  [32]=>
                  string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                  [33]=>
                  string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
                }
                ["query_times"]=>
                array(34) {
                  [0]=>
                  float(0.00030183792114258)
                  [1]=>
                  float(0.00043296813964844)
                  [2]=>
                  float(0.00072407722473145)
                  [3]=>
                  float(0.00080490112304688)
                  [4]=>
                  float(0.00021886825561523)
                  [5]=>
                  float(0.00030303001403809)
                  [6]=>
                  float(0.010481119155884)
                  [7]=>
                  float(0.0019140243530273)
                  [8]=>
                  float(0.0045070648193359)
                  [9]=>
                  float(0.00099086761474609)
                  [10]=>
                  float(0.00025010108947754)
                  [11]=>
                  float(0.00019598007202148)
                  [12]=>
                  float(0.00017595291137695)
                  [13]=>
                  float(0.00020813941955566)
                  [14]=>
                  float(0.0001671314239502)
                  [15]=>
                  float(0.00042915344238281)
                  [16]=>
                  float(0.0015599727630615)
                  [17]=>
                  float(0.00019407272338867)
                  [18]=>
                  float(0.0001680850982666)
                  [19]=>
                  float(0.00015616416931152)
                  [20]=>
                  float(0.00017094612121582)
                  [21]=>
                  float(0.00016307830810547)
                  [22]=>
                  float(0.00014996528625488)
                  [23]=>
                  float(0.00088620185852051)
                  [24]=>
                  float(0.00064206123352051)
                  [25]=>
                  float(0.00022196769714355)
                  [26]=>
                  float(0.00037789344787598)
                  [27]=>
                  float(0.00017285346984863)
                  [28]=>
                  float(0.00018119812011719)
                  [29]=>
                  float(0.00017380714416504)
                  [30]=>
                  float(0.00028491020202637)
                  [31]=>
                  float(0.00028610229492188)
                  [32]=>
                  float(0.00069594383239746)
                  [33]=>
                  float(0.00028610229492188)
                }
                ["data_cache"]=>
                array(0) {
                }
                ["trans_enabled"]=>
                bool(true)
                ["trans_strict"]=>
                bool(true)
                ["_trans_depth":protected]=>
                int(0)
                ["_trans_status":protected]=>
                bool(true)
                ["_trans_failure":protected]=>
                bool(false)
                ["cache_on"]=>
                bool(false)
                ["cachedir"]=>
                string(0) ""
                ["cache_autodel"]=>
                bool(false)
                ["CACHE"]=>
                NULL
                ["_protect_identifiers":protected]=>
                bool(true)
                ["_reserved_identifiers":protected]=>
                array(1) {
                  [0]=>
                  string(1) "*"
                }
                ["_like_escape_str":protected]=>
                string(13) " ESCAPE '%s' "
                ["_like_escape_chr":protected]=>
                string(1) "!"
                ["_random_keyword":protected]=>
                array(2) {
                  [0]=>
                  string(6) "RAND()"
                  [1]=>
                  string(8) "RAND(%d)"
                }
                ["_count_string":protected]=>
                string(19) "SELECT COUNT(*) AS "
                ["failover"]=>
                array(0) {
                }
                ["getQueryGrammar"]=>
                object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
                  ["selectComponents":protected]=>
                  array(11) {
                    [0]=>
                    string(9) "aggregate"
                    [1]=>
                    string(7) "columns"
                    [2]=>
                    string(4) "from"
                    [3]=>
                    string(5) "joins"
                    [4]=>
                    string(6) "wheres"
                    [5]=>
                    string(6) "groups"
                    [6]=>
                    string(7) "havings"
                    [7]=>
                    string(6) "orders"
                    [8]=>
                    string(5) "limit"
                    [9]=>
                    string(6) "offset"
                    [10]=>
                    string(4) "lock"
                  }
                  ["operators":protected]=>
                  array(0) {
                  }
                  ["tablePrefix":protected]=>
                  string(0) ""
                }
              }
              ["primaryKey":protected]=>
              string(2) "id"
              ["with":protected]=>
              array(0) {
              }
              ["withCount":protected]=>
              array(0) {
              }
              ["perPage":protected]=>
              int(15)
              ["attributes":protected]=>
              array(7) {
                ["id"]=>
                string(8) "customer"
                ["slug"]=>
                string(13) "role_customer"
                ["type"]=>
                string(7) "default"
                ["resources_support"]=>
                string(55) "a:1:{i:0;s:37:"\App\Service\Secure\Resource\Customer";}"
                ["created_at"]=>
                string(19) "2017-06-19 15:54:00"
                ["updated_at"]=>
                string(19) "2017-06-19 15:54:00"
                ["deleted_at"]=>
                NULL
              }
              ["original":protected]=>
              array(9) {
                ["id"]=>
                string(8) "customer"
                ["slug"]=>
                string(13) "role_customer"
                ["type"]=>
                string(7) "default"
                ["resources_support"]=>
                string(55) "a:1:{i:0;s:37:"\App\Service\Secure\Resource\Customer";}"
                ["created_at"]=>
                string(19) "2017-06-19 15:54:00"
                ["updated_at"]=>
                string(19) "2017-06-19 15:54:00"
                ["deleted_at"]=>
                NULL
                ["pivot_user_id"]=>
                string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
                ["pivot_role_id"]=>
                string(8) "customer"
              }
              ["relations":protected]=>
              array(2) {
                ["pivot"]=>
                object(App\Model\UsersRoles)#57 (28) {
                  ["table":protected]=>
                  string(11) "users_roles"
                  ["incrementing"]=>
                  bool(true)
                  ["keyType":protected]=>
                  string(6) "string"
                  ["timestamps"]=>
                  bool(false)
                  ["parent":protected]=>
                  *RECURSION*
                  ["foreignKey":protected]=>
                  string(7) "user_id"
                  ["relatedKey":protected]=>
                  string(7) "role_id"
                  ["guarded":protected]=>
                  array(0) {
                  }
                  ["include":protected]=>
                  array(0) {
                  }
                  ["connection":protected]=>
                  object(CI_DB_mysqli_driver)#34 (46) {
                    ["dbdriver"]=>
                    string(6) "mysqli"
                    ["compress"]=>
                    bool(false)
                    ["delete_hack"]=>
                    bool(true)
                    ["stricton"]=>
                    bool(false)
                    ["_escape_char":protected]=>
                    string(1) "`"
                    ["_mysqli":protected]=>
                    object(mysqli)#35 (19) {
                      ["affected_rows"]=>
                      int(-1)
                      ["client_info"]=>
                      string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                      ["client_version"]=>
                      int(50012)
                      ["connect_errno"]=>
                      int(0)
                      ["connect_error"]=>
                      NULL
                      ["errno"]=>
                      int(0)
                      ["error"]=>
                      string(0) ""
                      ["error_list"]=>
                      array(0) {
                      }
                      ["field_count"]=>
                      int(4)
                      ["host_info"]=>
                      string(25) "Localhost via UNIX socket"
                      ["info"]=>
                      NULL
                      ["insert_id"]=>
                      int(0)
                      ["server_info"]=>
                      string(23) "8.0.42-0ubuntu0.24.04.1"
                      ["server_version"]=>
                      int(80042)
                      ["stat"]=>
                      string(142) "Uptime: 348330  Threads: 2  Questions: 803857  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                      ["sqlstate"]=>
                      string(5) "00000"
                      ["protocol_version"]=>
                      int(10)
                      ["thread_id"]=>
                      int(4156)
                      ["warning_count"]=>
                      int(0)
                    }
                    ["dsn"]=>
                    string(0) ""
                    ["username"]=>
                    string(4) "user"
                    ["password"]=>
                    string(8) "password"
                    ["hostname"]=>
                    string(9) "localhost"
                    ["database"]=>
                    string(18) "guinot_portail_rec"
                    ["subdriver"]=>
                    NULL
                    ["dbprefix"]=>
                    string(0) ""
                    ["char_set"]=>
                    string(4) "utf8"
                    ["dbcollat"]=>
                    string(15) "utf8_general_ci"
                    ["encrypt"]=>
                    bool(false)
                    ["swap_pre"]=>
                    string(0) ""
                    ["port"]=>
                    string(0) ""
                    ["pconnect"]=>
                    bool(false)
                    ["conn_id"]=>
                    object(mysqli)#35 (19) {
                      ["affected_rows"]=>
                      int(-1)
                      ["client_info"]=>
                      string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                      ["client_version"]=>
                      int(50012)
                      ["connect_errno"]=>
                      int(0)
                      ["connect_error"]=>
                      NULL
                      ["errno"]=>
                      int(0)
                      ["error"]=>
                      string(0) ""
                      ["error_list"]=>
                      array(0) {
                      }
                      ["field_count"]=>
                      int(4)
                      ["host_info"]=>
                      string(25) "Localhost via UNIX socket"
                      ["info"]=>
                      NULL
                      ["insert_id"]=>
                      int(0)
                      ["server_info"]=>
                      string(23) "8.0.42-0ubuntu0.24.04.1"
                      ["server_version"]=>
                      int(80042)
                      ["stat"]=>
                      string(142) "Uptime: 348330  Threads: 2  Questions: 803858  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                      ["sqlstate"]=>
                      string(5) "00000"
                      ["protocol_version"]=>
                      int(10)
                      ["thread_id"]=>
                      int(4156)
                      ["warning_count"]=>
                      int(0)
                    }
                    ["result_id"]=>
                    object(mysqli_result)#114 (5) {
                      ["current_field"]=>
                      int(0)
                      ["field_count"]=>
                      int(4)
                      ["lengths"]=>
                      NULL
                      ["num_rows"]=>
                      int(1)
                      ["type"]=>
                      int(0)
                    }
                    ["db_debug"]=>
                    bool(true)
                    ["benchmark"]=>
                    float(0.028876543045044)
                    ["query_count"]=>
                    int(34)
                    ["bind_marker"]=>
                    string(1) "?"
                    ["save_queries"]=>
                    bool(true)
                    ["queries"]=>
                    array(34) {
                      [0]=>
                      string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
                      [1]=>
                      string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
                      [2]=>
                      string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
                      [3]=>
                      string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
                      [4]=>
                      string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
                      [5]=>
                      string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
                      [6]=>
                      string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
                      [7]=>
                      string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
                      [8]=>
                      string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
                      [9]=>
                      string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
                      [10]=>
                      string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                      [11]=>
                      string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                      [12]=>
                      string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                      [13]=>
                      string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                      [14]=>
                      string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                      [15]=>
                      string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                      [16]=>
                      string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                      [17]=>
                      string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                      [18]=>
                      string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                      [19]=>
                      string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                      [20]=>
                      string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                      [21]=>
                      string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                      [22]=>
                      string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                      [23]=>
                      string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                      [24]=>
                      string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                      [25]=>
                      string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                      [26]=>
                      string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                      [27]=>
                      string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
                      [28]=>
                      string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                      [29]=>
                      string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                      [30]=>
                      string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
                      [31]=>
                      string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
                      [32]=>
                      string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                      [33]=>
                      string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
                    }
                    ["query_times"]=>
                    array(34) {
                      [0]=>
                      float(0.00030183792114258)
                      [1]=>
                      float(0.00043296813964844)
                      [2]=>
                      float(0.00072407722473145)
                      [3]=>
                      float(0.00080490112304688)
                      [4]=>
                      float(0.00021886825561523)
                      [5]=>
                      float(0.00030303001403809)
                      [6]=>
                      float(0.010481119155884)
                      [7]=>
                      float(0.0019140243530273)
                      [8]=>
                      float(0.0045070648193359)
                      [9]=>
                      float(0.00099086761474609)
                      [10]=>
                      float(0.00025010108947754)
                      [11]=>
                      float(0.00019598007202148)
                      [12]=>
                      float(0.00017595291137695)
                      [13]=>
                      float(0.00020813941955566)
                      [14]=>
                      float(0.0001671314239502)
                      [15]=>
                      float(0.00042915344238281)
                      [16]=>
                      float(0.0015599727630615)
                      [17]=>
                      float(0.00019407272338867)
                      [18]=>
                      float(0.0001680850982666)
                      [19]=>
                      float(0.00015616416931152)
                      [20]=>
                      float(0.00017094612121582)
                      [21]=>
                      float(0.00016307830810547)
                      [22]=>
                      float(0.00014996528625488)
                      [23]=>
                      float(0.00088620185852051)
                      [24]=>
                      float(0.00064206123352051)
                      [25]=>
                      float(0.00022196769714355)
                      [26]=>
                      float(0.00037789344787598)
                      [27]=>
                      float(0.00017285346984863)
                      [28]=>
                      float(0.00018119812011719)
                      [29]=>
                      float(0.00017380714416504)
                      [30]=>
                      float(0.00028491020202637)
                      [31]=>
                      float(0.00028610229492188)
                      [32]=>
                      float(0.00069594383239746)
                      [33]=>
                      float(0.00028610229492188)
                    }
                    ["data_cache"]=>
                    array(0) {
                    }
                    ["trans_enabled"]=>
                    bool(true)
                    ["trans_strict"]=>
                    bool(true)
                    ["_trans_depth":protected]=>
                    int(0)
                    ["_trans_status":protected]=>
                    bool(true)
                    ["_trans_failure":protected]=>
                    bool(false)
                    ["cache_on"]=>
                    bool(false)
                    ["cachedir"]=>
                    string(0) ""
                    ["cache_autodel"]=>
                    bool(false)
                    ["CACHE"]=>
                    NULL
                    ["_protect_identifiers":protected]=>
                    bool(true)
                    ["_reserved_identifiers":protected]=>
                    array(1) {
                      [0]=>
                      string(1) "*"
                    }
                    ["_like_escape_str":protected]=>
                    string(13) " ESCAPE '%s' "
                    ["_like_escape_chr":protected]=>
                    string(1) "!"
                    ["_random_keyword":protected]=>
                    array(2) {
                      [0]=>
                      string(6) "RAND()"
                      [1]=>
                      string(8) "RAND(%d)"
                    }
                    ["_count_string":protected]=>
                    string(19) "SELECT COUNT(*) AS "
                    ["failover"]=>
                    array(0) {
                    }
                    ["getQueryGrammar"]=>
                    object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
                      ["selectComponents":protected]=>
                      array(11) {
                        [0]=>
                        string(9) "aggregate"
                        [1]=>
                        string(7) "columns"
                        [2]=>
                        string(4) "from"
                        [3]=>
                        string(5) "joins"
                        [4]=>
                        string(6) "wheres"
                        [5]=>
                        string(6) "groups"
                        [6]=>
                        string(7) "havings"
                        [7]=>
                        string(6) "orders"
                        [8]=>
                        string(5) "limit"
                        [9]=>
                        string(6) "offset"
                        [10]=>
                        string(4) "lock"
                      }
                      ["operators":protected]=>
                      array(0) {
                      }
                      ["tablePrefix":protected]=>
                      string(0) ""
                    }
                  }
                  ["primaryKey":protected]=>
                  string(2) "id"
                  ["with":protected]=>
                  array(0) {
                  }
                  ["withCount":protected]=>
                  array(0) {
                  }
                  ["perPage":protected]=>
                  int(15)
                  ["attributes":protected]=>
                  array(2) {
                    ["user_id"]=>
                    string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
                    ["role_id"]=>
                    string(8) "customer"
                  }
                  ["original":protected]=>
                  array(2) {
                    ["user_id"]=>
                    string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
                    ["role_id"]=>
                    string(8) "customer"
                  }
                  ["relations":protected]=>
                  array(0) {
                  }
                  ["hidden":protected]=>
                  array(0) {
                  }
                  ["visible":protected]=>
                  array(0) {
                  }
                  ["appends":protected]=>
                  array(0) {
                  }
                  ["fillable":protected]=>
                  array(0) {
                  }
                  ["dates":protected]=>
                  array(0) {
                  }
                  ["dateFormat":protected]=>
                  NULL
                  ["casts":protected]=>
                  array(0) {
                  }
                  ["touches":protected]=>
                  array(0) {
                  }
                  ["observables":protected]=>
                  array(0) {
                  }
                  ["exists"]=>
                  bool(true)
                  ["wasRecentlyCreated"]=>
                  bool(false)
                }
                ["permissions"]=>
                array(1) {
                  [0]=>
                  object(App\Model\Permissions)#113 (24) {
                    ["table":protected]=>
                    string(17) "roles_permissions"
                    ["incrementing"]=>
                    bool(false)
                    ["keyType":protected]=>
                    string(6) "string"
                    ["timestamps"]=>
                    bool(false)
                    ["connection":protected]=>
                    object(CI_DB_mysqli_driver)#34 (46) {
                      ["dbdriver"]=>
                      string(6) "mysqli"
                      ["compress"]=>
                      bool(false)
                      ["delete_hack"]=>
                      bool(true)
                      ["stricton"]=>
                      bool(false)
                      ["_escape_char":protected]=>
                      string(1) "`"
                      ["_mysqli":protected]=>
                      object(mysqli)#35 (19) {
                        ["affected_rows"]=>
                        int(-1)
                        ["client_info"]=>
                        string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                        ["client_version"]=>
                        int(50012)
                        ["connect_errno"]=>
                        int(0)
                        ["connect_error"]=>
                        NULL
                        ["errno"]=>
                        int(0)
                        ["error"]=>
                        string(0) ""
                        ["error_list"]=>
                        array(0) {
                        }
                        ["field_count"]=>
                        int(4)
                        ["host_info"]=>
                        string(25) "Localhost via UNIX socket"
                        ["info"]=>
                        NULL
                        ["insert_id"]=>
                        int(0)
                        ["server_info"]=>
                        string(23) "8.0.42-0ubuntu0.24.04.1"
                        ["server_version"]=>
                        int(80042)
                        ["stat"]=>
                        string(142) "Uptime: 348330  Threads: 2  Questions: 803859  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                        ["sqlstate"]=>
                        string(5) "00000"
                        ["protocol_version"]=>
                        int(10)
                        ["thread_id"]=>
                        int(4156)
                        ["warning_count"]=>
                        int(0)
                      }
                      ["dsn"]=>
                      string(0) ""
                      ["username"]=>
                      string(4) "user"
                      ["password"]=>
                      string(8) "password"
                      ["hostname"]=>
                      string(9) "localhost"
                      ["database"]=>
                      string(18) "guinot_portail_rec"
                      ["subdriver"]=>
                      NULL
                      ["dbprefix"]=>
                      string(0) ""
                      ["char_set"]=>
                      string(4) "utf8"
                      ["dbcollat"]=>
                      string(15) "utf8_general_ci"
                      ["encrypt"]=>
                      bool(false)
                      ["swap_pre"]=>
                      string(0) ""
                      ["port"]=>
                      string(0) ""
                      ["pconnect"]=>
                      bool(false)
                      ["conn_id"]=>
                      object(mysqli)#35 (19) {
                        ["affected_rows"]=>
                        int(-1)
                        ["client_info"]=>
                        string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
                        ["client_version"]=>
                        int(50012)
                        ["connect_errno"]=>
                        int(0)
                        ["connect_error"]=>
                        NULL
                        ["errno"]=>
                        int(0)
                        ["error"]=>
                        string(0) ""
                        ["error_list"]=>
                        array(0) {
                        }
                        ["field_count"]=>
                        int(4)
                        ["host_info"]=>
                        string(25) "Localhost via UNIX socket"
                        ["info"]=>
                        NULL
                        ["insert_id"]=>
                        int(0)
                        ["server_info"]=>
                        string(23) "8.0.42-0ubuntu0.24.04.1"
                        ["server_version"]=>
                        int(80042)
                        ["stat"]=>
                        string(142) "Uptime: 348330  Threads: 2  Questions: 803860  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
                        ["sqlstate"]=>
                        string(5) "00000"
                        ["protocol_version"]=>
                        int(10)
                        ["thread_id"]=>
                        int(4156)
                        ["warning_count"]=>
                        int(0)
                      }
                      ["result_id"]=>
                      object(mysqli_result)#114 (5) {
                        ["current_field"]=>
                        int(0)
                        ["field_count"]=>
                        int(4)
                        ["lengths"]=>
                        NULL
                        ["num_rows"]=>
                        int(1)
                        ["type"]=>
                        int(0)
                      }
                      ["db_debug"]=>
                      bool(true)
                      ["benchmark"]=>
                      float(0.028876543045044)
                      ["query_count"]=>
                      int(34)
                      ["bind_marker"]=>
                      string(1) "?"
                      ["save_queries"]=>
                      bool(true)
                      ["queries"]=>
                      array(34) {
                        [0]=>
                        string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
                        [1]=>
                        string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
                        [2]=>
                        string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
                        [3]=>
                        string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
                        [4]=>
                        string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
                        [5]=>
                        string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
                        [6]=>
                        string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
                        [7]=>
                        string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
                        [8]=>
                        string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
                        [9]=>
                        string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
                        [10]=>
                        string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                        [11]=>
                        string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                        [12]=>
                        string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                        [13]=>
                        string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                        [14]=>
                        string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                        [15]=>
                        string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                        [16]=>
                        string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                        [17]=>
                        string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
                        [18]=>
                        string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
                        [19]=>
                        string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
                        [20]=>
                        string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
                        [21]=>
                        string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
                        [22]=>
                        string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
                        [23]=>
                        string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
                        [24]=>
                        string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                        [25]=>
                        string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                        [26]=>
                        string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                        [27]=>
                        string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
                        [28]=>
                        string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                        [29]=>
                        string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
                        [30]=>
                        string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
                        [31]=>
                        string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
                        [32]=>
                        string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
                        [33]=>
                        string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
                      }
                      ["query_times"]=>
                      array(34) {
                        [0]=>
                        float(0.00030183792114258)
                        [1]=>
                        float(0.00043296813964844)
                        [2]=>
                        float(0.00072407722473145)
                        [3]=>
                        float(0.00080490112304688)
                        [4]=>
                        float(0.00021886825561523)
                        [5]=>
                        float(0.00030303001403809)
                        [6]=>
                        float(0.010481119155884)
                        [7]=>
                        float(0.0019140243530273)
                        [8]=>
                        float(0.0045070648193359)
                        [9]=>
                        float(0.00099086761474609)
                        [10]=>
                        float(0.00025010108947754)
                        [11]=>
                        float(0.00019598007202148)
                        [12]=>
                        float(0.00017595291137695)
                        [13]=>
                        float(0.00020813941955566)
                        [14]=>
                        float(0.0001671314239502)
                        [15]=>
                        float(0.00042915344238281)
                        [16]=>
                        float(0.0015599727630615)
                        [17]=>
                        float(0.00019407272338867)
                        [18]=>
                        float(0.0001680850982666)
                        [19]=>
                        float(0.00015616416931152)
                        [20]=>
                        float(0.00017094612121582)
                        [21]=>
                        float(0.00016307830810547)
                        [22]=>
                        float(0.00014996528625488)
                        [23]=>
                        float(0.00088620185852051)
                        [24]=>
                        float(0.00064206123352051)
                        [25]=>
                        float(0.00022196769714355)
                        [26]=>
                        float(0.00037789344787598)
                        [27]=>
                        float(0.00017285346984863)
                        [28]=>
                        float(0.00018119812011719)
                        [29]=>
                        float(0.00017380714416504)
                        [30]=>
                        float(0.00028491020202637)
                        [31]=>
                        float(0.00028610229492188)
                        [32]=>
                        float(0.00069594383239746)
                        [33]=>
                        float(0.00028610229492188)
                      }
                      ["data_cache"]=>
                      array(0) {
                      }
                      ["trans_enabled"]=>
                      bool(true)
                      ["trans_strict"]=>
                      bool(true)
                      ["_trans_depth":protected]=>
                      int(0)
                      ["_trans_status":protected]=>
                      bool(true)
                      ["_trans_failure":protected]=>
                      bool(false)
                      ["cache_on"]=>
                      bool(false)
                      ["cachedir"]=>
                      string(0) ""
                      ["cache_autodel"]=>
                      bool(false)
                      ["CACHE"]=>
                      NULL
                      ["_protect_identifiers":protected]=>
                      bool(true)
                      ["_reserved_identifiers":protected]=>
                      array(1) {
                        [0]=>
                        string(1) "*"
                      }
                      ["_like_escape_str":protected]=>
                      string(13) " ESCAPE '%s' "
                      ["_like_escape_chr":protected]=>
                      string(1) "!"
                      ["_random_keyword":protected]=>
                      array(2) {
                        [0]=>
                        string(6) "RAND()"
                        [1]=>
                        string(8) "RAND(%d)"
                      }
                      ["_count_string":protected]=>
                      string(19) "SELECT COUNT(*) AS "
                      ["failover"]=>
                      array(0) {
                      }
                      ["getQueryGrammar"]=>
                      object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
                        ["selectComponents":protected]=>
                        array(11) {
                          [0]=>
                          string(9) "aggregate"
                          [1]=>
                          string(7) "columns"
                          [2]=>
                          string(4) "from"
                          [3]=>
                          string(5) "joins"
                          [4]=>
                          string(6) "wheres"
                          [5]=>
                          string(6) "groups"
                          [6]=>
                          string(7) "havings"
                          [7]=>
                          string(6) "orders"
                          [8]=>
                          string(5) "limit"
                          [9]=>
                          string(6) "offset"
                          [10]=>
                          string(4) "lock"
                        }
                        ["operators":protected]=>
                        array(0) {
                        }
                        ["tablePrefix":protected]=>
                        string(0) ""
                      }
                    }
                    ["primaryKey":protected]=>
                    string(2) "id"
                    ["with":protected]=>
                    array(0) {
                    }
                    ["withCount":protected]=>
                    array(0) {
                    }
                    ["perPage":protected]=>
                    int(15)
                    ["attributes":protected]=>
                    array(2) {
                      ["role_id"]=>
                      string(8) "customer"
                      ["permission_name"]=>
                      string(10) "webservice"
                    }
                    ["original":protected]=>
                    array(2) {
                      ["role_id"]=>
                      string(8) "customer"
                      ["permission_name"]=>
                      string(10) "webservice"
                    }
                    ["relations":protected]=>
                    array(0) {
                    }
                    ["hidden":protected]=>
                    array(0) {
                    }
                    ["visible":protected]=>
                    array(0) {
                    }
                    ["appends":protected]=>
                    array(0) {
                    }
                    ["fillable":protected]=>
                    array(0) {
                    }
                    ["guarded":protected]=>
                    array(1) {
                      [0]=>
                      string(1) "*"
                    }
                    ["dates":protected]=>
                    array(0) {
                    }
                    ["dateFormat":protected]=>
                    NULL
                    ["casts":protected]=>
                    array(0) {
                    }
                    ["touches":protected]=>
                    array(0) {
                    }
                    ["observables":protected]=>
                    array(0) {
                    }
                    ["exists"]=>
                    bool(true)
                    ["wasRecentlyCreated"]=>
                    bool(false)
                  }
                }
              }
              ["hidden":protected]=>
              array(0) {
              }
              ["visible":protected]=>
              array(0) {
              }
              ["appends":protected]=>
              array(0) {
              }
              ["fillable":protected]=>
              array(0) {
              }
              ["guarded":protected]=>
              array(1) {
                [0]=>
                string(1) "*"
              }
              ["dates":protected]=>
              array(0) {
              }
              ["dateFormat":protected]=>
              NULL
              ["casts":protected]=>
              array(0) {
              }
              ["touches":protected]=>
              array(0) {
              }
              ["observables":protected]=>
              array(0) {
              }
              ["exists"]=>
              bool(true)
              ["wasRecentlyCreated"]=>
              bool(false)
            }
          }
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      ["foreignKey":protected]=>
      string(7) "user_id"
      ["relatedKey":protected]=>
      string(7) "role_id"
      ["guarded":protected]=>
      array(0) {
      }
      ["include":protected]=>
      array(0) {
      }
      ["connection":protected]=>
      object(CI_DB_mysqli_driver)#34 (46) {
        ["dbdriver"]=>
        string(6) "mysqli"
        ["compress"]=>
        bool(false)
        ["delete_hack"]=>
        bool(true)
        ["stricton"]=>
        bool(false)
        ["_escape_char":protected]=>
        string(1) "`"
        ["_mysqli":protected]=>
        object(mysqli)#35 (19) {
          ["affected_rows"]=>
          int(-1)
          ["client_info"]=>
          string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
          ["client_version"]=>
          int(50012)
          ["connect_errno"]=>
          int(0)
          ["connect_error"]=>
          NULL
          ["errno"]=>
          int(0)
          ["error"]=>
          string(0) ""
          ["error_list"]=>
          array(0) {
          }
          ["field_count"]=>
          int(4)
          ["host_info"]=>
          string(25) "Localhost via UNIX socket"
          ["info"]=>
          NULL
          ["insert_id"]=>
          int(0)
          ["server_info"]=>
          string(23) "8.0.42-0ubuntu0.24.04.1"
          ["server_version"]=>
          int(80042)
          ["stat"]=>
          string(142) "Uptime: 348330  Threads: 2  Questions: 803861  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
          ["sqlstate"]=>
          string(5) "00000"
          ["protocol_version"]=>
          int(10)
          ["thread_id"]=>
          int(4156)
          ["warning_count"]=>
          int(0)
        }
        ["dsn"]=>
        string(0) ""
        ["username"]=>
        string(4) "user"
        ["password"]=>
        string(8) "password"
        ["hostname"]=>
        string(9) "localhost"
        ["database"]=>
        string(18) "guinot_portail_rec"
        ["subdriver"]=>
        NULL
        ["dbprefix"]=>
        string(0) ""
        ["char_set"]=>
        string(4) "utf8"
        ["dbcollat"]=>
        string(15) "utf8_general_ci"
        ["encrypt"]=>
        bool(false)
        ["swap_pre"]=>
        string(0) ""
        ["port"]=>
        string(0) ""
        ["pconnect"]=>
        bool(false)
        ["conn_id"]=>
        object(mysqli)#35 (19) {
          ["affected_rows"]=>
          int(-1)
          ["client_info"]=>
          string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
          ["client_version"]=>
          int(50012)
          ["connect_errno"]=>
          int(0)
          ["connect_error"]=>
          NULL
          ["errno"]=>
          int(0)
          ["error"]=>
          string(0) ""
          ["error_list"]=>
          array(0) {
          }
          ["field_count"]=>
          int(4)
          ["host_info"]=>
          string(25) "Localhost via UNIX socket"
          ["info"]=>
          NULL
          ["insert_id"]=>
          int(0)
          ["server_info"]=>
          string(23) "8.0.42-0ubuntu0.24.04.1"
          ["server_version"]=>
          int(80042)
          ["stat"]=>
          string(142) "Uptime: 348330  Threads: 2  Questions: 803862  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
          ["sqlstate"]=>
          string(5) "00000"
          ["protocol_version"]=>
          int(10)
          ["thread_id"]=>
          int(4156)
          ["warning_count"]=>
          int(0)
        }
        ["result_id"]=>
        object(mysqli_result)#114 (5) {
          ["current_field"]=>
          int(0)
          ["field_count"]=>
          int(4)
          ["lengths"]=>
          NULL
          ["num_rows"]=>
          int(1)
          ["type"]=>
          int(0)
        }
        ["db_debug"]=>
        bool(true)
        ["benchmark"]=>
        float(0.028876543045044)
        ["query_count"]=>
        int(34)
        ["bind_marker"]=>
        string(1) "?"
        ["save_queries"]=>
        bool(true)
        ["queries"]=>
        array(34) {
          [0]=>
          string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
          [1]=>
          string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
          [2]=>
          string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
          [3]=>
          string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
          [4]=>
          string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
          [5]=>
          string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
          [6]=>
          string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
          [7]=>
          string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
          [8]=>
          string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
          [9]=>
          string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
          [10]=>
          string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
          [11]=>
          string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
          [12]=>
          string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
          [13]=>
          string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
          [14]=>
          string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
          [15]=>
          string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
          [16]=>
          string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
          [17]=>
          string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
          [18]=>
          string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
          [19]=>
          string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
          [20]=>
          string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
          [21]=>
          string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
          [22]=>
          string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
          [23]=>
          string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
          [24]=>
          string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
          [25]=>
          string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
          [26]=>
          string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
          [27]=>
          string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
          [28]=>
          string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
          [29]=>
          string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
          [30]=>
          string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
          [31]=>
          string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
          [32]=>
          string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
          [33]=>
          string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
        }
        ["query_times"]=>
        array(34) {
          [0]=>
          float(0.00030183792114258)
          [1]=>
          float(0.00043296813964844)
          [2]=>
          float(0.00072407722473145)
          [3]=>
          float(0.00080490112304688)
          [4]=>
          float(0.00021886825561523)
          [5]=>
          float(0.00030303001403809)
          [6]=>
          float(0.010481119155884)
          [7]=>
          float(0.0019140243530273)
          [8]=>
          float(0.0045070648193359)
          [9]=>
          float(0.00099086761474609)
          [10]=>
          float(0.00025010108947754)
          [11]=>
          float(0.00019598007202148)
          [12]=>
          float(0.00017595291137695)
          [13]=>
          float(0.00020813941955566)
          [14]=>
          float(0.0001671314239502)
          [15]=>
          float(0.00042915344238281)
          [16]=>
          float(0.0015599727630615)
          [17]=>
          float(0.00019407272338867)
          [18]=>
          float(0.0001680850982666)
          [19]=>
          float(0.00015616416931152)
          [20]=>
          float(0.00017094612121582)
          [21]=>
          float(0.00016307830810547)
          [22]=>
          float(0.00014996528625488)
          [23]=>
          float(0.00088620185852051)
          [24]=>
          float(0.00064206123352051)
          [25]=>
          float(0.00022196769714355)
          [26]=>
          float(0.00037789344787598)
          [27]=>
          float(0.00017285346984863)
          [28]=>
          float(0.00018119812011719)
          [29]=>
          float(0.00017380714416504)
          [30]=>
          float(0.00028491020202637)
          [31]=>
          float(0.00028610229492188)
          [32]=>
          float(0.00069594383239746)
          [33]=>
          float(0.00028610229492188)
        }
        ["data_cache"]=>
        array(0) {
        }
        ["trans_enabled"]=>
        bool(true)
        ["trans_strict"]=>
        bool(true)
        ["_trans_depth":protected]=>
        int(0)
        ["_trans_status":protected]=>
        bool(true)
        ["_trans_failure":protected]=>
        bool(false)
        ["cache_on"]=>
        bool(false)
        ["cachedir"]=>
        string(0) ""
        ["cache_autodel"]=>
        bool(false)
        ["CACHE"]=>
        NULL
        ["_protect_identifiers":protected]=>
        bool(true)
        ["_reserved_identifiers":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["_like_escape_str":protected]=>
        string(13) " ESCAPE '%s' "
        ["_like_escape_chr":protected]=>
        string(1) "!"
        ["_random_keyword":protected]=>
        array(2) {
          [0]=>
          string(6) "RAND()"
          [1]=>
          string(8) "RAND(%d)"
        }
        ["_count_string":protected]=>
        string(19) "SELECT COUNT(*) AS "
        ["failover"]=>
        array(0) {
        }
        ["getQueryGrammar"]=>
        object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
          ["selectComponents":protected]=>
          array(11) {
            [0]=>
            string(9) "aggregate"
            [1]=>
            string(7) "columns"
            [2]=>
            string(4) "from"
            [3]=>
            string(5) "joins"
            [4]=>
            string(6) "wheres"
            [5]=>
            string(6) "groups"
            [6]=>
            string(7) "havings"
            [7]=>
            string(6) "orders"
            [8]=>
            string(5) "limit"
            [9]=>
            string(6) "offset"
            [10]=>
            string(4) "lock"
          }
          ["operators":protected]=>
          array(0) {
          }
          ["tablePrefix":protected]=>
          string(0) ""
        }
      }
      ["primaryKey":protected]=>
      string(2) "id"
      ["with":protected]=>
      array(0) {
      }
      ["withCount":protected]=>
      array(0) {
      }
      ["perPage":protected]=>
      int(15)
      ["attributes":protected]=>
      array(2) {
        ["user_id"]=>
        string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
        ["role_id"]=>
        string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
      }
      ["original":protected]=>
      array(2) {
        ["user_id"]=>
        string(36) "9ed711ac-b047-4a00-ae96-592682927eb1"
        ["role_id"]=>
        string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
      }
      ["relations":protected]=>
      array(0) {
      }
      ["hidden":protected]=>
      array(0) {
      }
      ["visible":protected]=>
      array(0) {
      }
      ["appends":protected]=>
      array(0) {
      }
      ["fillable":protected]=>
      array(0) {
      }
      ["dates":protected]=>
      array(0) {
      }
      ["dateFormat":protected]=>
      NULL
      ["casts":protected]=>
      array(0) {
      }
      ["touches":protected]=>
      array(0) {
      }
      ["observables":protected]=>
      array(0) {
      }
      ["exists"]=>
      bool(true)
      ["wasRecentlyCreated"]=>
      bool(false)
    }
    ["permissions"]=>
    array(13) {
      [0]=>
      object(App\Model\Permissions)#100 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803863  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803864  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(22) "webservice.application"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(22) "webservice.application"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [1]=>
      object(App\Model\Permissions)#101 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803865  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803866  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(14) "webservice.cgv"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(14) "webservice.cgv"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [2]=>
      object(App\Model\Permissions)#102 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803867  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803868  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(31) "webservice.commercial_condition"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(31) "webservice.commercial_condition"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [3]=>
      object(App\Model\Permissions)#103 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803869  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803870  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(18) "webservice.contrat"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(18) "webservice.contrat"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [4]=>
      object(App\Model\Permissions)#104 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803871  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803872  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(20) "webservice.furniture"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(20) "webservice.furniture"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [5]=>
      object(App\Model\Permissions)#105 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803873  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803874  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(19) "webservice.institut"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(19) "webservice.institut"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [6]=>
      object(App\Model\Permissions)#106 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803875  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803876  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(18) "webservice.invoice"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(18) "webservice.invoice"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [7]=>
      object(App\Model\Permissions)#107 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803877  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803878  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(14) "webservice.log"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(14) "webservice.log"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [8]=>
      object(App\Model\Permissions)#108 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803879  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803880  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(18) "webservice.message"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(18) "webservice.message"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [9]=>
      object(App\Model\Permissions)#109 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803881  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803882  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(16) "webservice.order"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(16) "webservice.order"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [10]=>
      object(App\Model\Permissions)#110 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803883  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803884  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(20) "webservice.shipping2"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(20) "webservice.shipping2"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [11]=>
      object(App\Model\Permissions)#111 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803885  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803886  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(16) "webservice.solde"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(16) "webservice.solde"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
      [12]=>
      object(App\Model\Permissions)#112 (24) {
        ["table":protected]=>
        string(17) "roles_permissions"
        ["incrementing"]=>
        bool(false)
        ["keyType":protected]=>
        string(6) "string"
        ["timestamps"]=>
        bool(false)
        ["connection":protected]=>
        object(CI_DB_mysqli_driver)#34 (46) {
          ["dbdriver"]=>
          string(6) "mysqli"
          ["compress"]=>
          bool(false)
          ["delete_hack"]=>
          bool(true)
          ["stricton"]=>
          bool(false)
          ["_escape_char":protected]=>
          string(1) "`"
          ["_mysqli":protected]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803887  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["dsn"]=>
          string(0) ""
          ["username"]=>
          string(4) "user"
          ["password"]=>
          string(8) "password"
          ["hostname"]=>
          string(9) "localhost"
          ["database"]=>
          string(18) "guinot_portail_rec"
          ["subdriver"]=>
          NULL
          ["dbprefix"]=>
          string(0) ""
          ["char_set"]=>
          string(4) "utf8"
          ["dbcollat"]=>
          string(15) "utf8_general_ci"
          ["encrypt"]=>
          bool(false)
          ["swap_pre"]=>
          string(0) ""
          ["port"]=>
          string(0) ""
          ["pconnect"]=>
          bool(false)
          ["conn_id"]=>
          object(mysqli)#35 (19) {
            ["affected_rows"]=>
            int(-1)
            ["client_info"]=>
            string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: b5c5906d452ec590732a93b051f3827e02749b83 $"
            ["client_version"]=>
            int(50012)
            ["connect_errno"]=>
            int(0)
            ["connect_error"]=>
            NULL
            ["errno"]=>
            int(0)
            ["error"]=>
            string(0) ""
            ["error_list"]=>
            array(0) {
            }
            ["field_count"]=>
            int(4)
            ["host_info"]=>
            string(25) "Localhost via UNIX socket"
            ["info"]=>
            NULL
            ["insert_id"]=>
            int(0)
            ["server_info"]=>
            string(23) "8.0.42-0ubuntu0.24.04.1"
            ["server_version"]=>
            int(80042)
            ["stat"]=>
            string(142) "Uptime: 348330  Threads: 2  Questions: 803888  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4156)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#114 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(1)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.028876543045044)
          ["query_count"]=>
          int(34)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(34) {
            [0]=>
            string(75) "SELECT GET_LOCK('e97194dc58abef5ede34f960414a48ff', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '32eae0a39b12d9bbd1d8b971d95a3a73dd2f2949'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e97194dc58abef5ede34f960414a48ff') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('b1eb14057ddd974e25db35cb53096aed', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '3293eb60bf5d1841b498a8865f15a03304571be1' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'da93c8fb5e68dc6ae4ba32fe30f54e87ce8891a5' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `active` = 1"
            [10]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [11]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [12]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [13]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [14]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [15]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [16]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [17]=>
            string(97) "select * from `companies` where `companies`.`id` = '6db33c1e-cacd-4c1d-858d-3b7c1df93521' limit 1"
            [18]=>
            string(95) "select * from `families` where `families`.`id` = 'ca016af5-6967-4310-b9a3-a520f950b5f8' limit 1"
            [19]=>
            string(63) "select * from `contents` where `contents`.`slug` = 'DE' limit 1"
            [20]=>
            string(144) "select * from `contents_translations` where `contents_translations`.`content_slug` = 'DE' and `contents_translations`.`content_slug` is not null"
            [21]=>
            string(114) "select `value` from `contents_metas` as `content_meta` where `key` = 'variables' and `content_slug` = 'DE' limit 1"
            [22]=>
            string(81) "select * from `customers_support` where `customers_support`.`id` = '2353' limit 1"
            [23]=>
            string(140) "select * from `notifications` where `notifications`.`customer_id` = 'PY20840' and `notifications`.`customer_id` is not null and `read` = '0'"
            [24]=>
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [25]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [26]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [27]=>
            string(156) "select * from `roles_permissions` where `roles_permissions`.`role_id` = '778be7cd-4e95-4c2a-8230-ae2861edc561' and `roles_permissions`.`role_id` is not null"
            [28]=>
            string(84) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [29]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [30]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1"
            [31]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [32]=>
            string(88) "select * from `users_delegates` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1'"
            [33]=>
            string(122) "select * from `users_roles` where `user_id` = '9ed711ac-b047-4a00-ae96-592682927eb1' and `customer_id` = 'PY20840' limit 1"
          }
          ["query_times"]=>
          array(34) {
            [0]=>
            float(0.00030183792114258)
            [1]=>
            float(0.00043296813964844)
            [2]=>
            float(0.00072407722473145)
            [3]=>
            float(0.00080490112304688)
            [4]=>
            float(0.00021886825561523)
            [5]=>
            float(0.00030303001403809)
            [6]=>
            float(0.010481119155884)
            [7]=>
            float(0.0019140243530273)
            [8]=>
            float(0.0045070648193359)
            [9]=>
            float(0.00099086761474609)
            [10]=>
            float(0.00025010108947754)
            [11]=>
            float(0.00019598007202148)
            [12]=>
            float(0.00017595291137695)
            [13]=>
            float(0.00020813941955566)
            [14]=>
            float(0.0001671314239502)
            [15]=>
            float(0.00042915344238281)
            [16]=>
            float(0.0015599727630615)
            [17]=>
            float(0.00019407272338867)
            [18]=>
            float(0.0001680850982666)
            [19]=>
            float(0.00015616416931152)
            [20]=>
            float(0.00017094612121582)
            [21]=>
            float(0.00016307830810547)
            [22]=>
            float(0.00014996528625488)
            [23]=>
            float(0.00088620185852051)
            [24]=>
            float(0.00064206123352051)
            [25]=>
            float(0.00022196769714355)
            [26]=>
            float(0.00037789344787598)
            [27]=>
            float(0.00017285346984863)
            [28]=>
            float(0.00018119812011719)
            [29]=>
            float(0.00017380714416504)
            [30]=>
            float(0.00028491020202637)
            [31]=>
            float(0.00028610229492188)
            [32]=>
            float(0.00069594383239746)
            [33]=>
            float(0.00028610229492188)
          }
          ["data_cache"]=>
          array(0) {
          }
          ["trans_enabled"]=>
          bool(true)
          ["trans_strict"]=>
          bool(true)
          ["_trans_depth":protected]=>
          int(0)
          ["_trans_status":protected]=>
          bool(true)
          ["_trans_failure":protected]=>
          bool(false)
          ["cache_on"]=>
          bool(false)
          ["cachedir"]=>
          string(0) ""
          ["cache_autodel"]=>
          bool(false)
          ["CACHE"]=>
          NULL
          ["_protect_identifiers":protected]=>
          bool(true)
          ["_reserved_identifiers":protected]=>
          array(1) {
            [0]=>
            string(1) "*"
          }
          ["_like_escape_str":protected]=>
          string(13) " ESCAPE '%s' "
          ["_like_escape_chr":protected]=>
          string(1) "!"
          ["_random_keyword":protected]=>
          array(2) {
            [0]=>
            string(6) "RAND()"
            [1]=>
            string(8) "RAND(%d)"
          }
          ["_count_string":protected]=>
          string(19) "SELECT COUNT(*) AS "
          ["failover"]=>
          array(0) {
          }
          ["getQueryGrammar"]=>
          object(Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar)#36 (3) {
            ["selectComponents":protected]=>
            array(11) {
              [0]=>
              string(9) "aggregate"
              [1]=>
              string(7) "columns"
              [2]=>
              string(4) "from"
              [3]=>
              string(5) "joins"
              [4]=>
              string(6) "wheres"
              [5]=>
              string(6) "groups"
              [6]=>
              string(7) "havings"
              [7]=>
              string(6) "orders"
              [8]=>
              string(5) "limit"
              [9]=>
              string(6) "offset"
              [10]=>
              string(4) "lock"
            }
            ["operators":protected]=>
            array(0) {
            }
            ["tablePrefix":protected]=>
            string(0) ""
          }
        }
        ["primaryKey":protected]=>
        string(2) "id"
        ["with":protected]=>
        array(0) {
        }
        ["withCount":protected]=>
        array(0) {
        }
        ["perPage":protected]=>
        int(15)
        ["attributes":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(20) "webservice.statistic"
        }
        ["original":protected]=>
        array(2) {
          ["role_id"]=>
          string(36) "778be7cd-4e95-4c2a-8230-ae2861edc561"
          ["permission_name"]=>
          string(20) "webservice.statistic"
        }
        ["relations":protected]=>
        array(0) {
        }
        ["hidden":protected]=>
        array(0) {
        }
        ["visible":protected]=>
        array(0) {
        }
        ["appends":protected]=>
        array(0) {
        }
        ["fillable":protected]=>
        array(0) {
        }
        ["guarded":protected]=>
        array(1) {
          [0]=>
          string(1) "*"
        }
        ["dates":protected]=>
        array(0) {
        }
        ["dateFormat":protected]=>
        NULL
        ["casts":protected]=>
        array(0) {
        }
        ["touches":protected]=>
        array(0) {
        }
        ["observables":protected]=>
        array(0) {
        }
        ["exists"]=>
        bool(true)
        ["wasRecentlyCreated"]=>
        bool(false)
      }
    }
  }
  ["hidden":protected]=>
  array(0) {
  }
  ["visible":protected]=>
  array(0) {
  }
  ["appends":protected]=>
  array(0) {
  }
  ["fillable":protected]=>
  array(0) {
  }
  ["guarded":protected]=>
  array(1) {
    [0]=>
    string(1) "*"
  }
  ["dates":protected]=>
  array(0) {
  }
  ["dateFormat":protected]=>
  NULL
  ["casts":protected]=>
  array(0) {
  }
  ["touches":protected]=>
  array(0) {
  }
  ["observables":protected]=>
  array(0) {
  }
  ["exists"]=>
  bool(true)
  ["wasRecentlyCreated"]=>
  bool(false)
}

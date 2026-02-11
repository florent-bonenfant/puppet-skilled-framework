fonctionne
string(5) "nb : "
int(1)
string(7) "role : "
object(App\Model\Role)#70 (24) {
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
      int(0)
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
      string(142) "Uptime: 348471  Threads: 2  Questions: 804050  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
      ["sqlstate"]=>
      string(5) "00000"
      ["protocol_version"]=>
      int(10)
      ["thread_id"]=>
      int(4161)
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
    string(14) "guinot_portail"
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
      string(142) "Uptime: 348471  Threads: 2  Questions: 804051  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
      ["sqlstate"]=>
      string(5) "00000"
      ["protocol_version"]=>
      int(10)
      ["thread_id"]=>
      int(4161)
      ["warning_count"]=>
      int(0)
    }
    ["result_id"]=>
    object(mysqli_result)#77 (5) {
      ["current_field"]=>
      int(0)
      ["field_count"]=>
      int(4)
      ["lengths"]=>
      NULL
      ["num_rows"]=>
      int(0)
      ["type"]=>
      int(0)
    }
    ["db_debug"]=>
    bool(true)
    ["benchmark"]=>
    float(0.030656814575195)
    ["query_count"]=>
    int(23)
    ["bind_marker"]=>
    string(1) "?"
    ["save_queries"]=>
    bool(true)
    ["queries"]=>
    array(23) {
      [0]=>
      string(75) "SELECT GET_LOCK('e8a3cd98c9616a26552c493172e2c02d', 300) AS ci_session_lock"
      [1]=>
      string(106) "select `timestamp`, `data` from `sessions` where `id` = '825a2a353d69dcf41015a0ddbee6b5a894c940e3' limit 1"
      [2]=>
      string(78) "delete from `sessions` where `id` = '825a2a353d69dcf41015a0ddbee6b5a894c940e3'"
      [3]=>
      string(74) "SELECT RELEASE_LOCK('e8a3cd98c9616a26552c493172e2c02d') AS ci_session_lock"
      [4]=>
      string(75) "SELECT GET_LOCK('48ed7e4c19162d304caa56d5591ca096', 300) AS ci_session_lock"
      [5]=>
      string(106) "select `timestamp`, `data` from `sessions` where `id` = 'cb136859318265215178bbfea14516e18e76998c' limit 1"
      [6]=>
      string(94) "select * from `users` where `admin_token` = 'c787411b988bddf9e5fdbf3bc6fbc8bc212b465f' limit 1"
      [7]=>
      string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
      [8]=>
      string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
      [9]=>
      string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `active` = 1"
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
      string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
      [18]=>
      string(84) "select * from `users_roles` where `user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
      [19]=>
      string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
      [20]=>
      string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `customers`.`id` = 'PY20840' and `active` = 1"
      [21]=>
      string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
      [22]=>
      string(88) "select * from `users_delegates` where `user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
    }
    ["query_times"]=>
    array(23) {
      [0]=>
      float(0.00027918815612793)
      [1]=>
      float(0.00032496452331543)
      [2]=>
      float(0.00083017349243164)
      [3]=>
      float(0.00035595893859863)
      [4]=>
      float(0.00023198127746582)
      [5]=>
      float(0.00027799606323242)
      [6]=>
      float(0.0099678039550781)
      [7]=>
      float(0.00091004371643066)
      [8]=>
      float(0.0015299320220947)
      [9]=>
      float(0.0012998580932617)
      [10]=>
      float(0.0003809928894043)
      [11]=>
      float(0.0003969669342041)
      [12]=>
      float(0.0014181137084961)
      [13]=>
      float(0.00124192237854)
      [14]=>
      float(0.00059008598327637)
      [15]=>
      float(0.0008540153503418)
      [16]=>
      float(0.0041909217834473)
      [17]=>
      float(0.0017669200897217)
      [18]=>
      float(0.00051593780517578)
      [19]=>
      float(0.00084710121154785)
      [20]=>
      float(0.00065493583679199)
      [21]=>
      float(0.00061893463134766)
      [22]=>
      float(0.0011720657348633)
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
    string(36) "16251c53-462b-4f0f-916a-dbf6b805fd4f"
    ["pivot_role_id"]=>
    string(8) "customer"
  }
  ["relations":protected]=>
  array(2) {
    ["pivot"]=>
    object(App\Model\UsersRoles)#65 (28) {
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
            string(142) "Uptime: 348471  Threads: 2  Questions: 804052  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4161)
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
          string(14) "guinot_portail"
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
            string(142) "Uptime: 348471  Threads: 2  Questions: 804053  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4161)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#77 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(0)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.030656814575195)
          ["query_count"]=>
          int(23)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(23) {
            [0]=>
            string(75) "SELECT GET_LOCK('e8a3cd98c9616a26552c493172e2c02d', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '825a2a353d69dcf41015a0ddbee6b5a894c940e3' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '825a2a353d69dcf41015a0ddbee6b5a894c940e3'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e8a3cd98c9616a26552c493172e2c02d') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('48ed7e4c19162d304caa56d5591ca096', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = 'cb136859318265215178bbfea14516e18e76998c' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'c787411b988bddf9e5fdbf3bc6fbc8bc212b465f' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `active` = 1"
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
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
            [18]=>
            string(84) "select * from `users_roles` where `user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
            [19]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [20]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `customers`.`id` = 'PY20840' and `active` = 1"
            [21]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [22]=>
            string(88) "select * from `users_delegates` where `user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
          }
          ["query_times"]=>
          array(23) {
            [0]=>
            float(0.00027918815612793)
            [1]=>
            float(0.00032496452331543)
            [2]=>
            float(0.00083017349243164)
            [3]=>
            float(0.00035595893859863)
            [4]=>
            float(0.00023198127746582)
            [5]=>
            float(0.00027799606323242)
            [6]=>
            float(0.0099678039550781)
            [7]=>
            float(0.00091004371643066)
            [8]=>
            float(0.0015299320220947)
            [9]=>
            float(0.0012998580932617)
            [10]=>
            float(0.0003809928894043)
            [11]=>
            float(0.0003969669342041)
            [12]=>
            float(0.0014181137084961)
            [13]=>
            float(0.00124192237854)
            [14]=>
            float(0.00059008598327637)
            [15]=>
            float(0.0008540153503418)
            [16]=>
            float(0.0041909217834473)
            [17]=>
            float(0.0017669200897217)
            [18]=>
            float(0.00051593780517578)
            [19]=>
            float(0.00084710121154785)
            [20]=>
            float(0.00065493583679199)
            [21]=>
            float(0.00061893463134766)
            [22]=>
            float(0.0011720657348633)
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
          string(36) "16251c53-462b-4f0f-916a-dbf6b805fd4f"
          ["username"]=>
          string(26) "institutboulogne@gmail.com"
          ["password"]=>
          string(60) "$2y$12$E9XuEVHDM0iiLW.EDEBMqu75ayJZgtsCULFT2tcYc1JhN.rX40mz2"
          ["first_name"]=>
          string(1) "-"
          ["last_name"]=>
          string(9) "DELPIERRE"
          ["email"]=>
          string(26) "institutboulogne@gmail.com"
          ["allow_email"]=>
          string(1) "0"
          ["allow_notification"]=>
          string(1) "1"
          ["language"]=>
          string(2) "fr"
          ["timezone"]=>
          string(13) "Europe/Berlin"
          ["date_format"]=>
          string(8) "%d %B %Y"
          ["datetime_format"]=>
          string(15) "%d %B %Y, %H:%M"
          ["active"]=>
          string(1) "1"
          ["visible"]=>
          string(1) "0"
          ["session_id"]=>
          string(40) "a5db6239873b31344cc533ede7a2fec232b9dd75"
          ["password_reset_token"]=>
          string(40) "d7c6d131c84fd406dd8b50ed11d7a9f7513d44c2"
          ["password_reset_datetime"]=>
          string(19) "2023-02-28 16:13:05"
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
          string(19) "2023-02-28 16:13:06"
          ["updated_at"]=>
          string(19) "2025-07-21 10:05:18"
          ["deleted_at"]=>
          NULL
        }
        ["original":protected]=>
        array(25) {
          ["id"]=>
          string(36) "16251c53-462b-4f0f-916a-dbf6b805fd4f"
          ["username"]=>
          string(26) "institutboulogne@gmail.com"
          ["password"]=>
          string(60) "$2y$12$E9XuEVHDM0iiLW.EDEBMqu75ayJZgtsCULFT2tcYc1JhN.rX40mz2"
          ["first_name"]=>
          string(1) "-"
          ["last_name"]=>
          string(9) "DELPIERRE"
          ["email"]=>
          string(26) "institutboulogne@gmail.com"
          ["allow_email"]=>
          string(1) "0"
          ["allow_notification"]=>
          string(1) "1"
          ["language"]=>
          string(2) "fr"
          ["timezone"]=>
          string(13) "Europe/Berlin"
          ["date_format"]=>
          string(8) "%d %B %Y"
          ["datetime_format"]=>
          string(15) "%d %B %Y, %H:%M"
          ["active"]=>
          string(1) "1"
          ["visible"]=>
          string(1) "0"
          ["session_id"]=>
          string(40) "a5db6239873b31344cc533ede7a2fec232b9dd75"
          ["password_reset_token"]=>
          string(40) "d7c6d131c84fd406dd8b50ed11d7a9f7513d44c2"
          ["password_reset_datetime"]=>
          string(19) "2023-02-28 16:13:05"
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
          string(19) "2023-02-28 16:13:06"
          ["updated_at"]=>
          string(19) "2025-07-21 10:05:18"
          ["deleted_at"]=>
          NULL
        }
        ["relations":protected]=>
        array(1) {
          ["roles"]=>
          array(1) {
            [0]=>
            *RECURSION*
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
          string(142) "Uptime: 348471  Threads: 2  Questions: 804054  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
          ["sqlstate"]=>
          string(5) "00000"
          ["protocol_version"]=>
          int(10)
          ["thread_id"]=>
          int(4161)
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
        string(14) "guinot_portail"
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
          string(142) "Uptime: 348471  Threads: 2  Questions: 804055  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
          ["sqlstate"]=>
          string(5) "00000"
          ["protocol_version"]=>
          int(10)
          ["thread_id"]=>
          int(4161)
          ["warning_count"]=>
          int(0)
        }
        ["result_id"]=>
        object(mysqli_result)#77 (5) {
          ["current_field"]=>
          int(0)
          ["field_count"]=>
          int(4)
          ["lengths"]=>
          NULL
          ["num_rows"]=>
          int(0)
          ["type"]=>
          int(0)
        }
        ["db_debug"]=>
        bool(true)
        ["benchmark"]=>
        float(0.030656814575195)
        ["query_count"]=>
        int(23)
        ["bind_marker"]=>
        string(1) "?"
        ["save_queries"]=>
        bool(true)
        ["queries"]=>
        array(23) {
          [0]=>
          string(75) "SELECT GET_LOCK('e8a3cd98c9616a26552c493172e2c02d', 300) AS ci_session_lock"
          [1]=>
          string(106) "select `timestamp`, `data` from `sessions` where `id` = '825a2a353d69dcf41015a0ddbee6b5a894c940e3' limit 1"
          [2]=>
          string(78) "delete from `sessions` where `id` = '825a2a353d69dcf41015a0ddbee6b5a894c940e3'"
          [3]=>
          string(74) "SELECT RELEASE_LOCK('e8a3cd98c9616a26552c493172e2c02d') AS ci_session_lock"
          [4]=>
          string(75) "SELECT GET_LOCK('48ed7e4c19162d304caa56d5591ca096', 300) AS ci_session_lock"
          [5]=>
          string(106) "select `timestamp`, `data` from `sessions` where `id` = 'cb136859318265215178bbfea14516e18e76998c' limit 1"
          [6]=>
          string(94) "select * from `users` where `admin_token` = 'c787411b988bddf9e5fdbf3bc6fbc8bc212b465f' limit 1"
          [7]=>
          string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
          [8]=>
          string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
          [9]=>
          string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `active` = 1"
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
          string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
          [18]=>
          string(84) "select * from `users_roles` where `user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
          [19]=>
          string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
          [20]=>
          string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `customers`.`id` = 'PY20840' and `active` = 1"
          [21]=>
          string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
          [22]=>
          string(88) "select * from `users_delegates` where `user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
        }
        ["query_times"]=>
        array(23) {
          [0]=>
          float(0.00027918815612793)
          [1]=>
          float(0.00032496452331543)
          [2]=>
          float(0.00083017349243164)
          [3]=>
          float(0.00035595893859863)
          [4]=>
          float(0.00023198127746582)
          [5]=>
          float(0.00027799606323242)
          [6]=>
          float(0.0099678039550781)
          [7]=>
          float(0.00091004371643066)
          [8]=>
          float(0.0015299320220947)
          [9]=>
          float(0.0012998580932617)
          [10]=>
          float(0.0003809928894043)
          [11]=>
          float(0.0003969669342041)
          [12]=>
          float(0.0014181137084961)
          [13]=>
          float(0.00124192237854)
          [14]=>
          float(0.00059008598327637)
          [15]=>
          float(0.0008540153503418)
          [16]=>
          float(0.0041909217834473)
          [17]=>
          float(0.0017669200897217)
          [18]=>
          float(0.00051593780517578)
          [19]=>
          float(0.00084710121154785)
          [20]=>
          float(0.00065493583679199)
          [21]=>
          float(0.00061893463134766)
          [22]=>
          float(0.0011720657348633)
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
        string(36) "16251c53-462b-4f0f-916a-dbf6b805fd4f"
        ["role_id"]=>
        string(8) "customer"
      }
      ["original":protected]=>
      array(2) {
        ["user_id"]=>
        string(36) "16251c53-462b-4f0f-916a-dbf6b805fd4f"
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
      object(App\Model\Permissions)#74 (24) {
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
            string(142) "Uptime: 348471  Threads: 2  Questions: 804056  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4161)
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
          string(14) "guinot_portail"
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
            string(142) "Uptime: 348471  Threads: 2  Questions: 804057  Slow queries: 0  Opens: 3616  Flush tables: 3  Open tables: 3431  Queries per second avg: 2.307"
            ["sqlstate"]=>
            string(5) "00000"
            ["protocol_version"]=>
            int(10)
            ["thread_id"]=>
            int(4161)
            ["warning_count"]=>
            int(0)
          }
          ["result_id"]=>
          object(mysqli_result)#77 (5) {
            ["current_field"]=>
            int(0)
            ["field_count"]=>
            int(4)
            ["lengths"]=>
            NULL
            ["num_rows"]=>
            int(0)
            ["type"]=>
            int(0)
          }
          ["db_debug"]=>
          bool(true)
          ["benchmark"]=>
          float(0.030656814575195)
          ["query_count"]=>
          int(23)
          ["bind_marker"]=>
          string(1) "?"
          ["save_queries"]=>
          bool(true)
          ["queries"]=>
          array(23) {
            [0]=>
            string(75) "SELECT GET_LOCK('e8a3cd98c9616a26552c493172e2c02d', 300) AS ci_session_lock"
            [1]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = '825a2a353d69dcf41015a0ddbee6b5a894c940e3' limit 1"
            [2]=>
            string(78) "delete from `sessions` where `id` = '825a2a353d69dcf41015a0ddbee6b5a894c940e3'"
            [3]=>
            string(74) "SELECT RELEASE_LOCK('e8a3cd98c9616a26552c493172e2c02d') AS ci_session_lock"
            [4]=>
            string(75) "SELECT GET_LOCK('48ed7e4c19162d304caa56d5591ca096', 300) AS ci_session_lock"
            [5]=>
            string(106) "select `timestamp`, `data` from `sessions` where `id` = 'cb136859318265215178bbfea14516e18e76998c' limit 1"
            [6]=>
            string(94) "select * from `users` where `admin_token` = 'c787411b988bddf9e5fdbf3bc6fbc8bc212b465f' limit 1"
            [7]=>
            string(75) "select * from `customers` where `id` = 'PY20840' and `active` = '1' limit 1"
            [8]=>
            string(93) "select * from `users` where `email` = 'institutboulogne@gmail.com' and `active` = '1' limit 1"
            [9]=>
            string(330) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `active` = 1"
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
            string(255) "select `roles`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`role_id` as `pivot_role_id` from `roles` inner join `users_roles` on `roles`.`id` = `users_roles`.`role_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
            [18]=>
            string(84) "select * from `users_roles` where `user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
            [19]=>
            string(128) "select * from `roles_permissions` where `roles_permissions`.`role_id` = 'customer' and `roles_permissions`.`role_id` is not null"
            [20]=>
            string(241) "select count(*) as aggregate from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `customers`.`id` = 'PY20840' and `active` = 1"
            [21]=>
            string(371) "select `customers`.*, `users_roles`.`user_id` as `pivot_user_id`, `users_roles`.`customer_id` as `pivot_customer_id`, `users_roles`.`id` as `pivot_id` from `customers` inner join `users_roles` on `customers`.`id` = `users_roles`.`customer_id` where `users_roles`.`user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f' and `customers`.`id` = 'PY20840' and `active` = 1 limit 1"
            [22]=>
            string(88) "select * from `users_delegates` where `user_id` = '16251c53-462b-4f0f-916a-dbf6b805fd4f'"
          }
          ["query_times"]=>
          array(23) {
            [0]=>
            float(0.00027918815612793)
            [1]=>
            float(0.00032496452331543)
            [2]=>
            float(0.00083017349243164)
            [3]=>
            float(0.00035595893859863)
            [4]=>
            float(0.00023198127746582)
            [5]=>
            float(0.00027799606323242)
            [6]=>
            float(0.0099678039550781)
            [7]=>
            float(0.00091004371643066)
            [8]=>
            float(0.0015299320220947)
            [9]=>
            float(0.0012998580932617)
            [10]=>
            float(0.0003809928894043)
            [11]=>
            float(0.0003969669342041)
            [12]=>
            float(0.0014181137084961)
            [13]=>
            float(0.00124192237854)
            [14]=>
            float(0.00059008598327637)
            [15]=>
            float(0.0008540153503418)
            [16]=>
            float(0.0041909217834473)
            [17]=>
            float(0.0017669200897217)
            [18]=>
            float(0.00051593780517578)
            [19]=>
            float(0.00084710121154785)
            [20]=>
            float(0.00065493583679199)
            [21]=>
            float(0.00061893463134766)
            [22]=>
            float(0.0011720657348633)
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

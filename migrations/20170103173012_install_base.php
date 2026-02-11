<?php

use Phinx\Db\Adapter\MysqlAdapter;

class InstallBase extends PuppetSkilledMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `cgvs` (
              `id` varchar(36) NOT NULL,
              `label` varchar(36) NOT NULL,
              `document` varchar(255) NOT NULL,
              `publication_date` date DEFAULT NULL,
              `end_publication_date` date DEFAULT NULL,
              `created_by` varchar(36) DEFAULT NULL,
              `updated_by` varchar(36) DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `deleted_at` datetime DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `created_by` (`created_by`),
              KEY `updated_by` (`updated_by`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            CREATE TABLE IF NOT EXISTS `cgvs_companies` (
              `id` varchar(36) NOT NULL,
              `cgv_id` varchar(36) NOT NULL,
              `company_id` varchar(36) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `cgv_id` (`cgv_id`),
              KEY `company_id` (`company_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `cgvs_families` (
              `id` varchar(36) NOT NULL,
              `cgv_id` varchar(36) NOT NULL,
              `family_id` varchar(36) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `cgv_id` (`cgv_id`),
              KEY `family_id` (`family_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `commercial_conditions` (
              `id` varchar(36) NOT NULL,
              `label` varchar(36) NOT NULL,
              `document` varchar(255) NOT NULL,
              `publication_date` date DEFAULT NULL,
              `end_publication_date` date DEFAULT NULL,
              `created_by` varchar(36) DEFAULT NULL,
              `updated_by` varchar(36) DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `deleted_at` datetime DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `created_by` (`created_by`),
              KEY `updated_by` (`updated_by`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `commercial_conditions_companies` (
              `id` varchar(36) NOT NULL,
              `commercial_condition_id` varchar(36) NOT NULL,
              `company_id` varchar(36) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `commercial_condition_id` (`commercial_condition_id`),
              KEY `company_id` (`company_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `commercial_conditions_families` (
              `id` varchar(36) NOT NULL,
              `commercial_condition_id` varchar(36) NOT NULL,
              `family_id` varchar(36) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `commercial_condition_id` (`commercial_condition_id`),
              KEY `family_id` (`family_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `companies` (
              `id` varchar(36) NOT NULL,
              `name` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `contents` (
              `slug` varchar(255) NOT NULL,
              `type` varchar(127) NOT NULL,
              `title_key` varchar(255) NOT NULL,
              `description_key` varchar(255) DEFAULT NULL,
              `active` int(1) NOT NULL DEFAULT '1',
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `modified_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`slug`),
              KEY `slug` (`slug`,`active`),
              KEY `active` (`active`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `contents_metas` (
              `content_slug` varchar(255) NOT NULL,
              `key` varchar(255) NOT NULL,
              `value` longblob,
              PRIMARY KEY (`content_slug`,`key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `contents_translations` (
              `content_slug` varchar(255) NOT NULL,
              `local` varchar(255) NOT NULL,
              `title` text,
              `content` longtext NOT NULL,
              `excerpt` text,
              PRIMARY KEY (`content_slug`,`local`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `customers` (
              `id` varchar(36) NOT NULL,
              `family_id` varchar(36) DEFAULT NULL,
              `company_id` varchar(36) DEFAULT NULL,
              `support_id` varchar(36) DEFAULT NULL,
              `email` varchar(255) DEFAULT NULL,
              `first_name` varchar(255) DEFAULT NULL,
              `last_name` varchar(255) DEFAULT NULL,
              `type` varchar(255) DEFAULT NULL,
              `title` varchar(255) DEFAULT NULL,
              `sign` varchar(255) DEFAULT NULL,
              `address` varchar(255) DEFAULT NULL,
              `address2` varchar(255) DEFAULT NULL,
              `zip` varchar(255) DEFAULT NULL,
              `city` varchar(255) DEFAULT NULL,
              `phone` varchar(255) DEFAULT NULL,
              `active` tinyint(1) NOT NULL DEFAULT '0',
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `customers_support` (
              `id` varchar(36) NOT NULL,
              `name` varchar(255) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `families` (
              `id` varchar(36) NOT NULL,
              `slug` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `furnitures` (
              `id` varchar(36) NOT NULL,
              `customer_id` varchar(36) DEFAULT NULL,
              `code` varchar(50) NOT NULL,
              `label` varchar(255) NOT NULL,
              `series` varchar(50) DEFAULT NULL,
              `initial_date` date DEFAULT NULL,
              `end_date` date DEFAULT NULL,
              `contract_number` varchar(50) NOT NULL,
              `file_name` varchar(255) DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `customer_id` (`customer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `invoices` (
              `id` varchar(36) NOT NULL,
              `customer_id` varchar(36) DEFAULT NULL,
              `company_id` varchar(36) DEFAULT NULL,
              `document_number` varchar(36) NOT NULL,
              `document_type` varchar(255) DEFAULT NULL,
              `file_name` varchar(255) DEFAULT NULL,
              `delivery_sheet` varchar(255) DEFAULT NULL,
              `amount` decimal(10,2) DEFAULT NULL,
              `date` date DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              UNIQUE KEY `customer_id_2` (`customer_id`,`document_number`),
              KEY `customer_id` (`customer_id`),
              KEY `company_id` (`company_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `invoices_lines` (
              `id` varchar(36) NOT NULL,
              `number` varchar(255) NOT NULL,
              `description` varchar(255) NOT NULL,
              `batch` varchar(255) NOT NULL,
              `invoice_id` varchar(36) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `amount` decimal(10,2) DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `invoice_id` (`invoice_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `jobs` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `queue` varchar(255) NOT NULL,
              `payload` longblob NOT NULL,
              `attempts` int(11) UNSIGNED NOT NULL,
              `reserved_at` int(11) UNSIGNED DEFAULT NULL,
              `available_at` int(11) UNSIGNED NOT NULL,
              `created_at` int(11) UNSIGNED NOT NULL,
              PRIMARY KEY (`id`),
              KEY `queue` (`queue`,`reserved_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `locks` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `lockable_type` varchar(255) NOT NULL,
              `row_id` varchar(255) NOT NULL,
              `user_id` varchar(36) DEFAULT NULL,
              `expired_at` datetime DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `lockable_type` (`lockable_type`,`row_id`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `logs` (
              `id` varchar(36) NOT NULL,
              `customer_id` varchar(36) NOT NULL,
              `location_slug` varchar(255) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `customer_id` (`customer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `messages` (
              `id` varchar(36) NOT NULL,
              `title` text NOT NULL,
              `content` longtext NOT NULL,
              `order` int(11) UNSIGNED NOT NULL,
              `publication_date` date DEFAULT NULL,
              `end_publication_date` date DEFAULT NULL,
              `created_by` varchar(36) DEFAULT NULL,
              `updated_by` varchar(36) DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `deleted_at` datetime DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `created_by` (`created_by`),
              KEY `updated_by` (`updated_by`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `messages_companies` (
              `id` varchar(36) NOT NULL,
              `message_id` varchar(36) NOT NULL,
              `company_id` varchar(36) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `message_id` (`message_id`),
              KEY `company_id` (`company_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `messages_families` (
              `id` varchar(36) NOT NULL,
              `message_id` varchar(36) NOT NULL,
              `family_id` varchar(36) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `message_id` (`message_id`),
              KEY `family_id` (`family_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `modules` (
              `slug` varchar(255) NOT NULL,
              `permission` varchar(255) NOT NULL,
              `title_key` varchar(255) NOT NULL,
              PRIMARY KEY (`slug`),
              KEY `slug` (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `notifications` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `customer_id` varchar(36) NOT NULL,
              `content_slug` varchar(255) NOT NULL,
              `data` longblob,
              `read` int(1) NOT NULL DEFAULT '0',
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `content_slug` (`content_slug`),
              KEY `customer_id` (`customer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `reset_tokens` (
              `token` varchar(40) NOT NULL,
              `user_id` varchar(36) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`token`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `revisions` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `action` varchar(255) NOT NULL,
              `table_name` varchar(255) NOT NULL,
              `row_id` varchar(255) NOT NULL,
              `revisionable_type` varchar(255) NOT NULL,
              `old` longblob,
              `new` longblob,
              `user` longblob,
              `user_id` varchar(36) DEFAULT NULL,
              `ip` varchar(255) DEFAULT NULL,
              `ip_forwarded` varchar(255) DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `table_name` (`table_name`,`row_id`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `roles` (
              `id` varchar(36) NOT NULL,
              `slug` varchar(255) NOT NULL,
              `type` varchar(50) NOT NULL,
              `resources_support` longblob,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `deleted_at` datetime DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `deleted_at` (`deleted_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `roles_permissions` (
              `role_id` varchar(36) NOT NULL,
              `permission_name` varchar(255) NOT NULL,
              PRIMARY KEY (`role_id`,`permission_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `sessions` (
              `id` varchar(128) NOT NULL,
              `ip_address` varchar(45) NOT NULL,
              `timestamp` int(10) NOT NULL,
              `data` longblob NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `settings` (
              `name` varchar(255) NOT NULL,
              `value` longblob NOT NULL,
              `autoload` tinyint(1) NOT NULL,
              PRIMARY KEY (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `users` (
              `id` varchar(36) NOT NULL,
              `username` varchar(255) NOT NULL,
              `password` varchar(255) DEFAULT NULL,
              `first_name` varchar(255) NOT NULL,
              `last_name` varchar(255) NOT NULL,
              `email` varchar(255) NOT NULL,
              `language` varchar(5) NOT NULL,
              `timezone` varchar(255) NOT NULL,
              `date_format` varchar(30) NOT NULL,
              `datetime_format` varchar(30) NOT NULL,
              `active` tinyint(1) NOT NULL DEFAULT '1',
              `visible` tinyint(1) NOT NULL DEFAULT '1',
              `session_id` varchar(128) DEFAULT NULL,
              `password_reset_token` varchar(40) DEFAULT NULL,
              `password_reset_datetime` datetime DEFAULT NULL,
              `admin_token` varchar(40) DEFAULT NULL,
              `admin_token_datetime` datetime DEFAULT NULL,
              `has_accepted_eula` tinyint(1) DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `deleted_at` datetime DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `username` (`username`,`deleted_at`),
              KEY `deleted_at` (`deleted_at`),
              KEY `session_id` (`session_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS `users_roles` (
              `id` varchar(36) NOT NULL,
              `user_id` varchar(36) NOT NULL,
              `customer_id` varchar(36) DEFAULT NULL,
              `role_id` varchar(36) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `user_id` (`user_id`,`customer_id`,`role_id`),
              KEY `customer_id` (`customer_id`),
              KEY `role_id` (`role_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            ALTER TABLE `cgvs`
              ADD CONSTRAINT `cgvs_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              ADD CONSTRAINT `cgvs_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `cgvs_companies`
              ADD CONSTRAINT `cgvs_companies_ibfk_1` FOREIGN KEY (`cgv_id`) REFERENCES `cgvs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `cgvs_companies_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `cgvs_families`
              ADD CONSTRAINT `cgvs_families_ibfk_1` FOREIGN KEY (`cgv_id`) REFERENCES `cgvs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `cgvs_families_ibfk_2` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `commercial_conditions`
              ADD CONSTRAINT `commercial_conditions_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              ADD CONSTRAINT `commercial_conditions_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `commercial_conditions_companies`
              ADD CONSTRAINT `commercial_conditions_companies_ibfk_1` FOREIGN KEY (`commercial_condition_id`) REFERENCES `commercial_conditions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `commercial_conditions_companies_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `commercial_conditions_families`
              ADD CONSTRAINT `commercial_conditions_families_ibfk_1` FOREIGN KEY (`commercial_condition_id`) REFERENCES `commercial_conditions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `commercial_conditions_families_ibfk_2` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `contents_metas`
              ADD CONSTRAINT `contents_metas_ibfk_1` FOREIGN KEY (`content_slug`) REFERENCES `contents` (`slug`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `contents_translations`
              ADD CONSTRAINT `contents_translations_ibfk_1` FOREIGN KEY (`content_slug`) REFERENCES `contents` (`slug`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `furnitures`
              ADD CONSTRAINT `furnitures_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `invoices`
              ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `invoices_lines`
              ADD CONSTRAINT `invoices_lines_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `locks`
              ADD CONSTRAINT `locks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `logs`
              ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `messages`
              ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `messages_companies`
              ADD CONSTRAINT `messages_companies_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `messages_companies_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `messages_families`
              ADD CONSTRAINT `messages_families_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `messages_families_ibfk_2` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `notifications`
              ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`content_slug`) REFERENCES `contents` (`slug`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `reset_tokens`
              ADD CONSTRAINT `reset_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `revisions`
              ADD CONSTRAINT `revisions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `roles_permissions`
              ADD CONSTRAINT `roles_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `users`
              ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `users_roles`
              ADD CONSTRAINT `users_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `users_roles_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `users_roles_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");
    }

    public function down()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        
        $this->execute("DROP TABLE `cgvs`");
        $this->execute("DROP TABLE `cgvs_companies`");
        $this->execute("DROP TABLE `cgvs_families`");
        $this->execute("DROP TABLE `commercial_conditions`");
        $this->execute("DROP TABLE `commercial_conditions_companies`");
        $this->execute("DROP TABLE `commercial_conditions_families`");
        $this->execute("DROP TABLE `companies`");
        $this->execute("DROP TABLE `contents`");
        $this->execute("DROP TABLE `contents_metas`");
        $this->execute("DROP TABLE `contents_translations`");
        $this->execute("DROP TABLE `customers`");
        $this->execute("DROP TABLE `customers_support`");
        $this->execute("DROP TABLE `families`");
        $this->execute("DROP TABLE `furnitures`");
        $this->execute("DROP TABLE `invoices`");
        $this->execute("DROP TABLE `invoices_lines`");
        $this->execute("DROP TABLE `jobs`");
        $this->execute("DROP TABLE `locks`");
        $this->execute("DROP TABLE `logs`");
        $this->execute("DROP TABLE `messages`");
        $this->execute("DROP TABLE `messages_companies`");
        $this->execute("DROP TABLE `messages_families`");
        $this->execute("DROP TABLE `modules`");
        $this->execute("DROP TABLE `notifications`");
        $this->execute("DROP TABLE `reset_tokens`");
        $this->execute("DROP TABLE `revisions`");
        $this->execute("DROP TABLE `roles`");
        $this->execute("DROP TABLE `roles_permissions`");
        $this->execute("DROP TABLE `sessions`");
        $this->execute("DROP TABLE `settings`");
        $this->execute("DROP TABLE `users`");
        $this->execute("DROP TABLE `users_roles`");

        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }
}

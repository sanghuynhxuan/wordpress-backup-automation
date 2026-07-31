<?php
if (! defined('WP_UNINSTALL_PLUGIN')) { exit; }
delete_option('wordpress_backup_automation_enabled');

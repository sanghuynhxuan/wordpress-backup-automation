<?php
declare(strict_types=1);
namespace SangPortfolio\WordpressBackupAutomation;
if (! defined('ABSPATH')) { exit; }
final class Feature {
    private const OPTION = 'wordpress_backup_automation_enabled';
    private const SLUG = 'wordpress-backup-automation';
    private const TITLE = 'WordPress Backup Automation';
    public function register(): void {
        add_action('admin_init', [$this, 'registerSettings']);
        add_action('admin_menu', [$this, 'registerPage']);
        if (Support::enabled(self::OPTION)) { $this->registerFeature(); }
    }
    public function registerSettings(): void { register_setting(self::SLUG, self::OPTION, ['sanitize_callback' => static fn($value): string => empty($value) ? '0' : '1']); }
    public function registerPage(): void { add_options_page(self::TITLE, self::TITLE, 'manage_options', self::SLUG, [$this, 'renderPage']); }
    public function renderPage(): void { if (! current_user_can('manage_options')) { return; } echo '<div class="wrap"><h1>' . esc_html(self::TITLE) . '</h1><form method="post" action="options.php">'; settings_fields(self::SLUG); echo '<label><input type="checkbox" name="' . esc_attr(self::OPTION) . '" value="1" ' . checked(Support::enabled(self::OPTION), true, false) . '> ' . esc_html__('Enable feature', 'sang-portfolio') . '</label>'; submit_button(); echo '</form></div>'; }
    private function registerFeature(): void { add_filter('cron_schedules', [$this, 'addSchedule']); add_action('init', [$this, 'scheduleHealthCheck']); add_action('sang_portfolio_backup_health', [$this, 'recordHealthCheck']); }
    public function addSchedule(array $schedules): array { $schedules['sang_daily'] = ['interval' => DAY_IN_SECONDS, 'display' => __('Once Daily', 'sang-portfolio')]; return $schedules; } public function scheduleHealthCheck(): void { if (! wp_next_scheduled('sang_portfolio_backup_health')) { wp_schedule_event(time() + HOUR_IN_SECONDS, 'sang_daily', 'sang_portfolio_backup_health'); } } public function recordHealthCheck(): void { update_option('sang_portfolio_backup_last_check', time(), false); }
}

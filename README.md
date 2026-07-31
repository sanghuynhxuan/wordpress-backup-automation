# WordPress Backup Automation

A scheduled backup-health check foundation using WordPress Cron.

## Functional scope

- Runs as a standalone WordPress plugin
- Includes an admin settings screen and an enable/disable option
- Implements real WordPress or WooCommerce hooks for the stated workflow
- Cleans up its option on uninstall

## Installation

Copy this repository into `wp-content/plugins/wordpress-backup-automation`, activate it, then open **Settings → WordPress Backup Automation**.

## Production note

This is a working reference implementation intended for discovery and adaptation to a client’s requirements. Test on staging before deployment.

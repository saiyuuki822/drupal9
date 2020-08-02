<?php

namespace Drupal\Tests\backup_migrate\Functional;

use Drupal\Core\File\FileSystemInterface;
use Drupal\Tests\BrowserTestBase;

/**
 * Checks if pages loads successfully.
 *
 * @group backup_migrate
 */
class BackupMigratePageLoadTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['backup_migrate'];

  /**
   * {@inheritdoc}
   */
  protected $strictConfigSchema = FALSE;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->container->get('router.builder')->rebuild();

    // Ensure backup_migrate folder exists, the
    // `admin/config/development/backup_migrate/backups` path will fail without
    // this.
    $path = 'private://backup_migrate/';
    \Drupal::service('file_system')->prepareDirectory($path, FileSystemInterface::CREATE_DIRECTORY);

    // Log in an admin user.
    $account = $this->drupalCreateUser([
      'access backup files',
      'administer backup and migrate',
      'perform backup',
      'restore from backup',
    ]);
    $this->drupalLogin($account);
  }

  /**
   * Tests if site quick backup function loads.
   *
   * @param string $path
   *   The path to check.
   * @param string $string_on_page
   *   A string to look for on the page above..
   *
   * @dataProvider pagesListProvider
   */
  public function testPages($path, $string_on_page) {
    $this->drupalGet($path);
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->pageTextContains($string_on_page);
  }

  /**
   * A list of paths to check and a string that should be present on that page.
   *
   * @return array
   *   A list of paths with a string that should be present on that page.
   */
  public function pagesListProvider() {
    return [
      ['admin/config/development/backup_migrate', 'Quick Backup'],
      ['admin/config/development/backup_migrate/advanced', 'Advanced Backup'],
      ['admin/config/development/backup_migrate/restore', 'Restore'],
      ['admin/config/development/backup_migrate/backups', 'Backups'],
      ['admin/config/development/backup_migrate/schedule', 'Schedule'],
      ['admin/config/development/backup_migrate/schedule/add', 'Add schedule'],
      ['admin/config/development/backup_migrate/settings', 'Settings'],
      ['admin/config/development/backup_migrate/settings/add', 'Add settings profile'],
      ['admin/config/development/backup_migrate/settings/destination', 'Backup Destination'],
      ['admin/config/development/backup_migrate/settings/destination/add', 'Add destination'],
      ['admin/config/development/backup_migrate/settings/source', 'Backup sources'],
      ['admin/config/development/backup_migrate/settings/source/add', 'Add Backup Source'],
    ];
  }

}

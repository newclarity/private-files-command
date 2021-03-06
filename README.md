# Private Files Command

This is a WP CLI command to list, move, remove files in subdirectories of uploads/private.

Supported sub-commands:
 * `wp private-files list`
 * `wp private-files move <file> <destination>`
 * `wp private-files remove <file>`

---
To make it available in your WP CLI environment, you can install it from Git:
```
wp package install https://github.com/newclarity/private-files-command.git
```

You can also install it from a local directory:
```
wp package install /var/www/private-files-command
```

You can make it available in your WP runtime by simply requiring `class-private-files-command.php` and adding command this way:
```
if ( defined( 'WP_CLI' ) && WP_CLI ) {
    require_once dirname( __FILE__ ) . '/lib/private-files-command/class-private-files-command.php';
    WP_CLI::add_command('private-files', 'Private_Files_Command' );
}
```

---
You can add it to your project via `composer.json`:
```
  "repositories": [
      {
          "type": "git",
          "url": "https://github.com/newclarity/private-files-command.git"
      }
  ],
  ...
  "require": {
    "newclarity/private-files-command": "0.1.0"
  }
```

This command might also be included in `wp-composer-dependencies` repository:
```
  "repositories": [
      {
          "type": "composer",
          "url": "https://wplib.github.io/wp-composer-dependencies"
      }
  ],
  ...
  "require": {
    "newclarity/private-files-command": "0.1.0"
  }
```

In both cases, it will be placed in your `vendor` directory and can be included from there:
```
wp package install /var/www/vendor/newclarity/private-files-command
```
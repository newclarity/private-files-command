# Private Files Command

You can make these commands available

Make it available in your WP CLI environment installing it from Git:
```
wp package install https://github.com/newclarity/private-files-command.git
```

Make it available in your WP CLI environment by installing it from local directory:
```
wp package install <directory>/private-files-command
```

You can also make it available in your WP runtime by requiring `private-files-command.php`
```
require_once "<directory>private-files-command.php";
```

Supported sub-commands:
 * `wp private-files list`
 * `wp private-files move <file> <destination>`
 * `wp private-files remove <file>`
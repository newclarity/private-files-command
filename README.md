# Private Files Command

You can make these commands available

Make it available in your WP CLI environment by importing it via `wp package import`.

Import from Git:
```
wp package import https://github.com/newclarity/private-files-command
```

Import from local directory:
```
wp package import <directory>/private-files-command
```

You can also make it available in your WP runtime by requiring `private-files-command.php`
```
require_once "<directory>private-files-command.php";
```

Supported sub-commands:
 * `wp private-files list`
 * `wp private-files move <file> <destination>`
 * `wp private-files remove <file>`
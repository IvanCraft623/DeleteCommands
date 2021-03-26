# DeleteCommands
A plugin for pocketmine that allows you to delete / unload unwanted commands. The commands of the config.yml are deleted when starting the server, the message in the console only happens if a command could not be eliminated.

# Config
``` YAML
---
#Welcome to DeleteCommands configs! :D
#This plugin was made by IvanCraft623

#Commands to be deleted
Commands:
  - "example" #This is an example of how you should place the command (You should not put the command with "/").
...
```
# Simple API
### Import the class
You'll need to import these classes in order to easily use it within our code.
```php
<?php

use IvanCraft623\DeleteCommands\DeleteCommands;
```
### Code to delete a command
```php
DeleteCommands::unregister("THE COMMAND HERE"); // You should not write the command with "/"
```
And ready! You have deleted the command from your server.

# Features
- You can delete commands you don't want

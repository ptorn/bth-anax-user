Anax user module Readme
==================================

About
------------------
This is a user module for Anax. With this you can handle the users stored in your database. And validate a user and login the user.

You can also create new users, edit users and delete users.

Installation
-------------------
This installation depends on a working db object loaded into DI. Which means you need to already have a configured database that is loaded into the DI-container.

You also need the session loaded into the DI-container.

With these dependencies taken care off you can continue by installing the module through composer by running the following command.

```
composer require ptorn/user
```

After the ptorn/user module is downloaded into your vendor-folder by running the command above we can start copying the needed files.

### Router
The route file `/vendor/ptorn/bth-anax-user/config/route/userController.php` needs to be copied into `/config/route/`
This way the new routes will be automaticly loaded with all the other routes.

### DI
Now we need to add the module to the DI-container.
Copy `/vendor/ptorn/bth-anax-user/config/di-user.php` into `/config/di/`

### Database
Now we need a table in the database to store the users. In `/config/sql/setup.sql` you will find the query needed to setup your database table. Don't forget to set your own database in the `setup.sql`

### Views
The last step is to copy the views from `/vendor/ptorn/user/bth-anax-user/view/user/` into `/view/`

Usage
------------------
Once installation is done there will be some new routes available.
`/user/login`
`/user/logout`
`/user/create`
`/user/delete/{Id}`



License
------------------

This software carries a MIT license.



```
 .  
..:  Copyright (c) 2017 Peder Tornberg (peder.tornberg@gmail.com)
```

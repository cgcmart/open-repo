# INSTALL

* This is for __new installation only__
* These instructions are for a manual installation using FTP, cPanel or other web hosting Control Panel.


If you are __upgrading your existing cart__, be sure to read the [upgrade instructions](UPGRADE.md) instead


## Linux Install

1. cd /your-web-base-directory, e.g. /public_html, or /www, or /httpdocs.
2. run `git clone https://github.com/cgcmart/open-repo.git`
3. Rename config-dist.php to config.php and admin/config-dist.php to admin/config.php
4. Make sure you have installed a MySQL Database which has a user name and password assigned to it when a web server adds your domain. Write down your website database name, user name, and password, that are needed during open cart installation.
	* do not use your `root` username and root password
5. Visit the store homepage e.g. http://www.example.com or http://www.example.com/store/
6. You should be taken to the installer page. Follow the on screen instructions.
7. After successful install, delete the /install/ directory from ftp.

## Windows Install

1. cd /your-web-base-directory,  e.g. /wwwroot/store or /wwwroot.
2. run `git clone https://github.com/cgcmart/open-repo.git`
3. Rename config-dist.php to config.php and admin/config-dist.php to admin/config.php
4. For Windows make sure the following folders and files permissions allow Read and Write.

		config.php
		admin/config.php

5. Make sure you have installed a MySQL Database which has a user name and password assigned to it when a web server adds your domain. Write down your website database name, user name, and password, that are needed during open cart installation.
	* do not use your `root` username and root password
6. You should be taken to the installer page. Follow the on screen instructions.
7. After successful install, delete the /install/ directory.

## Going live
When your site is ready to go live open file system/config/default.php 

**Find:**

`$_['error_display'] = true;`

**Replace with:**

`$_['error_display'] = false;`
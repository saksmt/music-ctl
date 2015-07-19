music-ctl
=========

 * Firstly, it's just an experiment in PHP and symfony.
 * This is **not** ready-to-use code;
 * This is **not** player;
 * This is mostly just my own training in symfony;
 * This is just CLI tool to track favorites and todo's of music;
 
If you are still here, then you can read requirements and installation sections.

Requirements
------------

 * `php-cli` - >=5.5;
 * Any database, for less configuring use `sqlite`;
 * MPC and known MPD server (for favorites functionality);
 
Installation
------------

 * `$ cp sources/app/config/user.parameters.yml{.dist,}`;
 * Change copied file for usage with your MPD;
 * `# ./install rebuild-vendor`;
 * You can also specify `INSTALLATION_PREFIX` for installation in non-standard path (ex: `# INSTALLATION_PREFIX=/usr/local install rebuild-vendor`);
 
Extended Installation
---------------------

Database parameters can be changed in `sources/app/config/database.xml`.

Command List
------------

 * `music-ctl todo:add` and alias `music-ctl todo add`
 * `music-ctl todo:list` and alias `music-ctl todo list`
 * `music-ctl todo:edit` and alias `music-ctl todo edit`
 * `music-ctl favorites:add`
 * `music-ctl favorites:list`
 * `music-ctl favorites:remove`
 * `music-ctl favorites:export`
 * `music-ctl favorites:import`

Explanation
-----------

This section is only for developers, especially on symfony.

Yep, I've packed all my sources in one `.phar` and vendors in another and also linked them. And yes it really works well... Somehow...

Anyway, you can find all the related code in `createPhar`, `runner.php` and `sources/src/Application/Kernel.php`.

The only bug I've found while trying to set it up is in DoctrineBridge, but it is automatically fixed by patch `DoctrineBridge-fix.patch` that now is in pull-request for symfony/symfony.

Developer Notes
---------------

If anyone knows good way to remove some commands|options (doctrine, cache, ... and --env, ...) from help without breaking the whole app, I'd be glad to listen or read about it.
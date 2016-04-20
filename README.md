WordPress, Timber, Gulp, Stylus and Babel Starter Kit

### Why? ###

This Starter Kit provides you with the ability to produce clean themes using an ultra-modern language stack. See [What you need to know](what-you-need-to-know) for details.

### How this works ###

The Kit was made to satisfy the barebones dependencies of a WordPress build. The entire WordPress directory is ignored by Git, as the theme is the only area of the site relevant to development work. The theme is based on an ultra-modern front-end stack and requires that a build step be used ahead of deployment. This is facilitated by Gulp. Although the theme does not assume a working knowledge of Gulp or NPM, knowledge of both may come in handy when bootstrapping to your environment.

The entire WordPress site will deploy to a subfolder from the repo root called `wordpress`, which will be ignored by Git. Remember to use the root level `.gitignore` to *unignore* any files that *should* be committed to the repo. Also remember *never* to commit `wp-config.php` to your Git repos.

Point your virtual host at the `wordpress` subdirectory, then run one

### The WordPress Gulp Starter Kit was built to be deployable on... ###

1. PHP > 5.6 (PHP >= 7.0 recommended)
2. MySQL > 5.5 (MariaDB >= 10.1 recommended)
3. Apache > 2.4 (Nginx >= 1.9 recommended)

### What you need to know ###

1. Basic [Gulp](http://gulpjs.com/)
2. Basic [NPM](https://npmjs.com)
3. A little [ES2015](https://babeljs.io/docs/learn-es2015/)
4. [Twig](http://twig.sensiolabs.org/)
5. [Stylus](http://stylus-lang.com/)
6. [Timber](http://upstatement.com/timber/)

### Building the Theme ###

1. Download and install [Node.js](https://nodejs.org) >= 5.6.0.
2. Navigate to the site's root directory.
3. Use `npm install` to install dependencies.
4. For a once-off build, use `npm run make`.
5. For a continuous build that leverages BrowserSync, use `npm run dev`.
6. Theme files are built and deployed to `./wordpress/wp-content/themes/hearst-trails`.
7. Be aware that you may need to change the port on which Browser Sync runs. This can be done within `gulpfile.js`.

### Bootstrapping the Site ###

_This will install a fresh copy of WordPress along with a fresh_

1. Download and install [Composer](https://getcomposer.org/) for PHP.
2. Navigate to the site's root directory.
3. In a terminal window, type `composer install`.
4. Point a virtual host at the freshly created `wordpress` directory.
5. Remove the `.git` folder, then [create a new repo](http://stackoverflow.com/a/3311824) in the root folder.

### Deploying the live site ###

1. Use `tar` via SSH to tar.gz the staging site.
2. Use SCP to copy the staging archive to the live server via your machine.
3. Use `tar` via SSH to untar on the live server.
4. Use Adminer to dump the database from the staging server.
5. Use PHPMyAdmin (or Adminer, or Sequel Pro) to import the database to the live server.
6. Use [this method](https://codex.wordpress.org/Changing_The_Site_URL#Edit_functions.php) to change the WordPress site's address.
7. Log into the admin panel:
    1. Go to _Settings > General_ and hit **Save Changes**.
    2. Go to _Settings > Permalink_ and hit **Save Changes**.
    3. Go to _Settings > Languages > Settings > URL Modifications_ and hit **Save Changes**.
    4. Finally, go to _Appearance > Customize_ and remove the Header Image. Then upload or choose the header image. This is a WordPress bug.

<?php
namespace Deployer;

require 'recipe/laravel.php';

set('bin/php', function () {
    return '/usr/local/bin/php74';
});

set('http_user', 'bszala');

// Project name
set('application', 'Tabatatool.pl');

// Project repository
set('repository', 'git@github.com:bSzala/tabata.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('tabatatool.pl')
    ->stage('production')
    ->user('bszala')
    ->port(222)
    ->set('deploy_path', '/home/bszala/domains/tabatatool.pl/public_html/deployer')
    ->set('writable_mode', 'chmod');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});



// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');


// Migrate database before symlink new release.

//before('deploy:symlink', 'artisan:migrate');
//before('deploy:symlink', 'artisan:db:seed');


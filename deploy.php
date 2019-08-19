<?php
namespace Deployer;

require 'vendor/deployer/deployer/recipe/symfony4.php';
require 'vendor/deployer/recipes/recipe/slack.php';

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Exception\ProcessFailedException;

// Project name
set('application', 'EDITME');

// Project repository
set('repository', 'EDITME');

// Default stage
set('default_stage', 'staging');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', ['public/media']);
add('writable_dirs', ['public/media']);

// Slack
/*set('allow_anonymous_stats', false);
set('slack_webhook', 'EDITME');
set('slack_text', '{{user}} is deploying to *{{stage}}*');
set('slack_success_text', 'Deploy to *{{stage}}* successful');
set('slack_failure_text', 'Deploy to *{{stage}}* failed');*/

// Arguments and options
option('commit-message', null, InputOption::VALUE_OPTIONAL, 'The commit message. This commit will do a git commit and push');

// Hosts
host('staging.editme')
    ->stage('staging')
    ->user('root')
    ->identityFile('~/.ssh/key')
    ->set('deploy_path', '/var/www/{{application}}/staging')
    ->set('branch', 'master')
;
host('editme')
    ->stage('production')
    ->user('root')
    ->identityFile('~/.ssh/key')
    ->set('deploy_path', '/var/www/{{application}}/production')
    ->set('branch', 'production')
;

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

task('assets:install', function () {
    if (has('previous_release')) {
        run('cp -R {{previous_release}}/node_modules {{release_path}}/node_modules');
    }

    run('cd {{release_path}} && npm install && npm run prod');
});

task('database:cache-clear', function () {
    run('{{bin/console}} doctrine:cache:clear-query');
    run('{{bin/console}} doctrine:cache:clear-result');
    run('{{bin/console}} doctrine:cache:clear-metadata');
})->onStage('production');

task('git:push-changes', function () {
    $commitMessage = null;
    if (input()->hasOption('commit-message')) {
        $commitMessage = input()->getOption('commit-message');

        if ($commitMessage) {
            try {
                writeln(runLocally('git commit -a -m "'.$commitMessage.'" && git push'));
            } catch (ProcessFailedException $e)
            {
                writeln('<fg=yellow>✘</fg=yellow> Nothing to commit.');
            }
        }
    }
})->local();

task('cachetool:clear:opcache', function () {
    run('cachetool opcache:reset --fcgi=/var/run/php/php7.2-fpm.sock');
});

/* No hace falta porque Deployer deja activo el current mientras hace el deploy en releases.
 *
 * task('deploy:maintenance:on', function () {
    run('cd {{current_path}} && touch maintenance.enable');
});

task('deploy:maintenance:off', function () {
    run('cd {{current_path}} && rm -rf maintenance.enable');
});*/

// Before callbacks
before('deploy:prepare', 'git:push-changes');
before('deploy:symlink', 'database:migrate');
before('deploy:symlink', 'assets:install');
//before('deploy', 'slack:notify');

// After callbacks
after('database:migrate', 'database:cache-clear');
//after('deploy:symlink', 'cachetool:clear:opcache');
//after('success', 'slack:notify:success');
after('deploy:failed', 'deploy:unlock');
//after('deploy:failed', 'slack:notify:failure');
//after('deploy:failed', 'deploy:maintenance:off');

<?php

require 'vendor/voodoo-rocks/deployer/recipe/yii2-app-vm.php';

env('project', 'wedo');
set('repository', 'git@bitbucket.org:voodoo-rocks/{{project}}-web.git');

server('dev.voodoo.pub', 'dev.voodoo.pub', 22)
    ->user('ubuntu')
    ->identityFile()
    ->stage('develop')
    ->env('deploy_path', '/home/ubuntu/{{project}}');

server('wedoweddingapp.com', 'wedoweddingapp.com', 22)
    ->user('wedoweddingapp')
    ->identityFile()
    ->stage('production')
    ->env('deploy_path', '/home/wedoweddingapp/{{project}}');

task('deploy:publish', function () {
    $stages = env('stages');
    foreach ($stages as $stage) {
        run("cd {{release_path}}/web && [[ -e index-{$stage}.php ]] && cp -f index-{$stage}.php index.php");
    }
})->desc('Publishing to www');
import random

from decouple import config
from fabric.api import cd, run, local, sudo
from fabric.contrib.files import exists, append

REPO_URL = 'git@github.com:alice-njoroge/RATST.git'


def deploy():
    site_folder = f'/home/nanoafrika/RATST'
    run(f'mkdir  -p {site_folder}')
    with cd(site_folder):
        _get_latest_source()
        _update_composer_packages()
        _create_or_update_dotenv_live()
        _update_database()
        _optimize()
        _configure_folders()
        _create_main_server_folders()
        _create_main_webserver_files()


def _get_latest_source():
    if exists('.git'):
        run('git fetch')
    else:
        run(f'git init')
        run(f'git remote add origin {REPO_URL}')
        run('git fetch')
    current_commit = local("git log -n 1 --format=%H", capture=True)
    run(f'git reset --hard {current_commit}')

def _update_composer_packages():
    run('composer install')

def _create_or_update_dotenv_live():

    append('.env', f'APP_NAME=RATST')
    append('.env', f'APP_ENV=production')

    app_key = local("php artisan --no-ansi key:generate --show", capture=True)

    append('.env', f'APP_DEBUG=false')
    append('.env', f'APP_KEY={app_key}')
    append('.env', f'APP_URL=https://ratst.alicewn.me')
    append('.env', f'DB_DATABASE=ratst')
    append('.env', f'DB_USERNAME={config("LIVE_DB_USERNAME")}')
    append('.env', f'DB_PASSWORD={config("LIVE_DB_PASSWORD")}')


def _update_database():
    run('php artisan migrate --force')

def _optimize():
    run('php artisan optimize')

def _configure_folders():
    """
    This function will own the storage and bootstrap/cache folder
    """
    sudo('chgrp -R www-data storage bootstrap/cache')
    sudo('chmod -R ug+rwx storage bootstrap/cache')


def _create_main_server_folders():
    run(f'mkdir  -p /home/nanoafrika/logs')


def _create_main_webserver_files():
    if not exists('/etc/nginx/sites-available/ratst'):
        sudo('cp nginx.template.conf /etc/nginx/sites-available/nanocomputing')
        sudo('ln -s /etc/nginx/sites-available/nanocomputing /etc/nginx/sites-enabled/nanocomputing')
        sudo('service nginx restart')


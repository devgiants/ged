# config valid only for current version of Capistrano
lock '3.4.0'


load "config/deploy/tasks/database.rb"

set :application, 'ged'
set :repo_url, 'git.devgiants:devgiants/ged.git'

set :ssh_user, 'nbonniot'
server 'devgiants', user: fetch(:ssh_user), roles: %w{web app db}, :primary => true

set :scm, :git

set :format, :pretty
set :log_level, :info
# set :log_level, :debug

set :composer_install_flags, '--prefer-dist --no-interaction --optimize-autoloader'

# Name used by the Web Server (i.e. www-data for Apache)
set :file_permissions_users, ['psacln']

# Name used by the Web Server (i.e. www-data for Apache)
set :webserver_user,        "nbonniot"

set :linked_files, %w{app/config/parameters.yml}
set :linked_dirs, %w{app/logs web/uploads vendor}

set :keep_releases, 3

after 'deploy:finishing', 'deploy:cleanup'

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
# set :deploy_to, '/var/www/my_app_name'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# set :linked_files, fetch(:linked_files, []).push('config/database.yml', 'config/secrets.yml')

# Default value for linked_dirs is []
# set :linked_dirs, fetch(:linked_dirs, []).push('log', 'tmp/pids', 'tmp/cache', 'tmp/sockets', 'public/system')

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
# set :keep_releases, 5

# namespace :deploy do

#  after :restart, :clear_cache do
#    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
#    end
#  end

# end

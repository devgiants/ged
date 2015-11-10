namespace :ged do
  desc 'Force database update'
  task :database do
    on roles(:app) do
      invoke 'symfony:run', :'doctrine:schema:update', '--force'
    end
  end
  after 'deploy:updated', 'ged:database'
end
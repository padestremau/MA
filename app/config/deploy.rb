set :application, "MA"
set :domain,      "missionandina.org"
set :deploy_to,   "/var/www/#{application}"
set :app_path,    "app"
set :user,        "root"
ssh_options[:forward_agent] = true
set :scm,         :git
set :repository,    "git@github.com:padestremau/MA.git"
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`
set :model_manager, "doctrine"
# Or: `propel`
role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server
set  :keep_releases,  3

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL

set :shared_files,      ["app/config/parameters.yml"]
set :use_composer, true
# set :update_vendors, false

# share vendors dir between deploys
set :copy_vendors, false

set :use_sudo, true
set :dump_assetic_assets, true
set :writable_dirs,       ["app/cache", "app/logs"]
set :webserver_user,      "www-data"
set :permission_method,   :chmod_alt
set :use_set_permissions, true
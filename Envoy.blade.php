@servers(['web' => 'localhost'])

@task('deploy')
    cd /path/to/site
    git pull origin master
@endtask

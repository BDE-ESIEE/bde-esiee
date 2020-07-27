#/bin/bash

# define path to custom docker environment
DOCKER_ENVVARS=/etc/apache2/docker_envvars

# write variables to DOCKER_ENVVARS
cat << EOF > "$DOCKER_ENVVARS"
export APACHE_RUN_USER=www-data
export APACHE_RUN_GROUP=www-data
export APACHE_LOG_DIR=/var/log/apache2
export APACHE_LOCK_DIR=/var/lock/apache2
export APACHE_PID_FILE=/var/run/apache2.pid
export APACHE_RUN_DIR=/var/run/apache2
export APACHE_DOCUMENT_ROOT=/bde/web
EOF

PARAMETERS_FILE=app/config/parameters.yml

cat << EOF > "$PARAMETERS_FILE"
parameters:
    database_driver:   pdo_mysql
    database_host:     $DB_HOST
    database_port:     ~
    database_name:     $DB_NAME
    database_user:     $DB_USER
    database_password: $DB_PASSWORD

    mailer_transport:  smtp
    mailer_host:       $MAILER_HOST
    mailer_user:       $MAILER_USER
    mailer_password:   $MAILER_PASSWORD

    locale:            fr
    secret:            $SECRET_KEY
    application_version: 1.0.0
    hostname: $HOSTNAME
    piwik_id: $PIWIK_ID
    piwik_url: $PIWIK_URL
    use_proxy: false

    wkhtmltopdf_binary: /usr/local/bin/wkhtmltopdf

    client_id     : $GOOGLE_CLIENT_ID
    client_secret : $GOOGLE_CLIENT_SECRET
    proxy: ""
EOF

chown www-data:www-data /bde/app/logs/ -R
mkdir /bde/app/cache/
chown www-data:www-data /bde/app/cache/ -R

# source environment variables to get APACHE_PID_FILE
. "$DOCKER_ENVVARS"

# only delete pidfile if APACHE_PID_FILE is defined
if [ -n "$APACHE_PID_FILE" ]; then
   rm -f "$APACHE_PID_FILE"
fi

# line copied from /etc/init.d/apache2
ENV="env -i LANG=C PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"

# use apache2ctl instead of /usr/sbin/apache2
$ENV APACHE_ENVVARS="$DOCKER_ENVVARS" apache2ctl -DFOREGROUND
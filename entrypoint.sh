#!/usr/bin/env bash

# setup
VOLUME=/srv/shared

# nginx sites
cd /etc/nginx/conf.d
if [ ! -h ./publishera.conf ]; then
    ln -s $VOLUME/nginx/publishera.conf publishera.conf
    ln -s $VOLUME/nginx/publisherb.conf publisherb.conf
    ln -s $VOLUME/nginx/advertisera.conf advertisera.conf
    ln -s $VOLUME/nginx/advertiserb.conf advertiserb.conf
    ln -s $VOLUME/nginx/tracker.conf tracker.conf
fi

# site roots
mkdir -p /var/www && cd /var/www
if [ ! -h ./publishera ]; then
    ln -s $VOLUME/www/publishera/ publishera
    ln -s $VOLUME/www/publisherb/ publisherb
    ln -s $VOLUME/www/advertisera/ advertisera
    ln -s $VOLUME/www/advertiserb/ advertiserb
    ln -s $VOLUME/www/tracker/ tracker
fi

# do not need to update /etc/resolv.conf, it's mounted from host machine

# launch main process
exec /usr/bin/supervisord -n -c /etc/supervisord.conf

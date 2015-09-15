#!/bin/bash

# setup
# command
CMD="/usr/sbin/named -g -c /etc/bind/named.conf -u bind"

# dns zones
DONE=$(grep "firstparty" /etc/bind/named.conf.local)
if [[ $? -eq 1 ]]; then
    echo 'include "/etc/bind/zones.firstparty";' >> /etc/bind/named.conf.local
fi

# do not need to update /etc/resolv.conf, it's mounted from host machine

# launch main process
exec $CMD

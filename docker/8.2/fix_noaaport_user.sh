#!/bin/bash
WWWUSER=$(grep ^sail /etc/passwd | awk -F: '{print $3}')
WWWGROUP=$(grep ^sail /etc/passwd | awk -F: '{print $4}')
sed -i'' "/^noaaport:/d" /etc/passwd
sed -i'' "/^noaaport:/d" /etc/group
echo "noaaport:x:$WWWUSER:$WWWGROUP::/var/npemwin:/usr/sbin/nologin" >>/etc/passwd
echo "noaaport:x:$WWWGROUP:" >>/etc/group
chown sail:$WWWGROUP /usr/local/etc/npemwin/servers.conf
chown -R sail:$WWWGROUP /var/npemwin/ /var/run/npemwin/ /var/log/npemwin/

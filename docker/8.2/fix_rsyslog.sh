#!/bin/bash
NUM=$(grep -n imklog /etc/rsyslog.conf | awk -F: '{print $1}')
sed -i "$NUM s/^/#/" /etc/rsyslog.conf

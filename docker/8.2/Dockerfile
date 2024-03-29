FROM ubuntu:22.04

LABEL maintainer="Jim Buitt"

ARG WWWGROUP
ARG NODE_VERSION=18
ARG POSTGRES_VERSION=15

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 dnsutils \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.2-cli php8.2-dev \
       php8.2-pgsql php8.2-sqlite3 php8.2-gd php8.2-imagick \
       php8.2-curl \
       php8.2-imap php8.2-mysql php8.2-mbstring \
       php8.2-xml php8.2-zip php8.2-bcmath php8.2-soap \
       php8.2-intl php8.2-readline \
       php8.2-ldap \
       php8.2-msgpack php8.2-igbinary php8.2-redis php8.2-swoole \
       php8.2-memcached php8.2-pcov php8.2-xdebug \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_${NODE_VERSION}.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list \
    && apt-get update && apt-get install -y nodejs \
    && npm install -g npm \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | tee /etc/apt/keyrings/yarn.gpg >/dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/yarn.gpg] https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && curl -sS https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor | tee /etc/apt/keyrings/pgdg.gpg >/dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/pgdg.gpg] http://apt.postgresql.org/pub/repos/apt jammy-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
    && apt-get update \
    && apt-get install -y yarn \
    && apt-get install -y mysql-client \
    && apt-get install -y postgresql-client-$POSTGRES_VERSION \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN apt-get update && apt-get install rsyslog rsyslog-mysql dos2unix -y
COPY rsyslogd/rsyslog.conf /etc/rsyslog.conf
COPY rsyslogd/mysql.conf /etc/rsyslog.d/
COPY npemwin/npemwin_3.0.1p1-1_amd64.deb /tmp/
COPY npemwin/npemwin_3.0.1p1-1_arm64.deb /tmp/

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.2

RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

# Install npemwin & its dependencies
RUN apt-get update
RUN apt-get install -y libtcl8.6 libwrap0 tcl8.6 tcllib gnuplot
RUN dpkg -i /tmp/npemwin_3.0.1p1-1_$(dpkg --print-architecture).deb

# Copy npemwin config files over
COPY npemwin/site/features.conf /usr/local/etc/npemwin/site/
COPY npemwin/site/panfilter.conf /usr/local/etc/npemwin/site/
COPY npemwin/site/panfilter.rc /usr/local/etc/npemwin/site/
COPY npemwin/servers.conf /usr/local/etc/npemwin/

# Copy over script to fix noaaport user
COPY fix_noaaport_user.sh /usr/local/bin/

# Disable npemwin from start-up (the old way since the npemwin doesn't create a systemd service file)
RUN update-rc.d npemwin remove

# Add sudoers file for sail
RUN mkdir /etc/sudoers.d/
RUN chmod 750 /etc/sudoers.d/
RUN echo "sail ALL=(ALL:ALL) SETENV:NOPASSWD: /usr/bin/systemctl reload php8.2-fpm.service" >/etc/sudoers.d/sail
RUN chmod 440 /etc/sudoers.d/sail

# Copy crontab for EMWIN Controller
COPY etc/cron.d/emwin-controller /etc/cron.d/emwin-controller

COPY install_php_deps.sh /usr/local/bin/install_php_deps.sh
COPY install_fe_deps.sh /usr/local/bin/install_fe_deps.sh
COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.2/cli/conf.d/99-sail.ini
RUN chmod +x /usr/local/bin/start-container

EXPOSE 80

ENTRYPOINT ["start-container"]

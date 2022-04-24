FROM nginxinc/nginx-unprivileged

USER root

RUN /bin/cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

RUN apt-get upgrade

RUN adduser -D -H -u 1000 -s /bin/bash www-data -G www-data

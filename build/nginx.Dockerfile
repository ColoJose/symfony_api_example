
FROM nginx:1.18

WORKDIR /var/www/html/public

COPY assets assets

COPY build/nginx.conf /etc/nginx/conf.d/default.conf




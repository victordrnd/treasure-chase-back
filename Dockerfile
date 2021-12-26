FROM nginx as BDE_backend
COPY --chown=www-data:www-data . /usr/share/nginx/html/
WORKDIR /usr/share/nginx/html/
EXPOSE 80

ARG IMAGE_NAME=leatotech/php
ARG IMAGE_TAG=latest

FROM ${IMAGE_NAME}:${IMAGE_TAG}

ARG APP_ENV=''
ARG APP_NAME=weroad

ENV APP_ENV=${APP_ENV}
ENV APP_NAME=${APP_NAME}

COPY ./infra/docker/php/entrypoint.sh /usr/local/sbin/entrypoint.sh
COPY ./infra/docker/php/conf.d/${APP_ENV}/*.ini /usr/local/etc/php/conf.d/
COPY ./infra/docker/nginx/app-${APP_NAME}.conf /etc/nginx/http.d/default.conf


WORKDIR /app/app-${APP_NAME}

COPY .env ./.env
COPY app app/
COPY bootstrap bootstrap/
COPY config config/
COPY database database/
COPY public public/
COPY resources resources/
COPY routes routes/
COPY vendor vendor/
COPY storage storage/

RUN chmod -R 0777 storage/logs

RUN chmod +x /usr/local/sbin/entrypoint.sh

ENTRYPOINT ["/usr/local/sbin/entrypoint.sh"]

EXPOSE 8000

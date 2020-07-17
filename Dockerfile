FROM quay.io/presslabs/wordpress-runtime:bedrock as builder
ARG COMPOSER_AUTH={}
ENV COMPOSER_AUTH=${COMPOSER_AUTH}

USER root

WORKDIR /src

# warm-up composer cache
COPY --chown=www-data:www-data composer.json composer.lock /src/
RUN composer install --no-dev --no-interaction --no-progress --no-ansi --no-scripts


# wipe everything and composer install
COPY --chown=www-data:www-data . /src
RUN composer install --no-dev --no-interaction --no-progress --no-ansi --no-scripts

RUN cp -a /src/. /app


FROM quay.io/presslabs/wordpress-runtime:bedrock

USER root
RUN set -ex \
    && apt-get update \
    && apt-get install --no-install-recommends -y vim

USER www-data

COPY --from=builder --chown=www-data:www-data /app /app

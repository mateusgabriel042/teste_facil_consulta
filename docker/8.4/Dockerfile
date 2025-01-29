FROM ubuntu:24.04

LABEL maintainer="Taylor Otwell"

ARG WWWGROUP
ARG NODE_VERSION=22
ARG MYSQL_CLIENT="mysql-client"

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Adiciona o repositório do PHP de Ondřej Surý (substituindo $(lsb_release -sc) por 'lunar' ou 'jammy')
RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y gnupg curl ca-certificates lsb-release software-properties-common \
    && curl -sS https://packages.sury.org/php/apt.gpg | gpg --dearmor -o /usr/share/keyrings/ondrej-php.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/ondrej-php.gpg] https://packages.sury.org/php lunar main" > /etc/apt/sources.list.d/ondrej-php.list \
    && apt-get update

# Instala PHP e extensões essenciais
RUN apt-get install -y php8.4-cli php8.4-mysql php8.4-mbstring php8.4-xml php8.4-bcmath php8.4-zip \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Instala Node.js e gerenciadores de pacotes
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /usr/share/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm yarn pnpm bun

# Configura usuário do Laravel Sail
RUN groupadd --force -g $WWWGROUP sail \
    && useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

EXPOSE 80/tcp

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]

FROM php:8.2-fpm

# xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install ngrok
RUN curl -s https://ngrok-agent.s3.amazonaws.com/ngrok.asc \
  | tee /etc/apt/trusted.gpg.d/ngrok.asc >/dev/null && echo "deb https://ngrok-agent.s3.amazonaws.com buster main" \
  | tee /etc/apt/sources.list.d/ngrok.list && apt update && apt install ngrok

# tools for debug
RUN apt-get update && apt-get install -y --no-install-recommends procps make less lsof vim htop dnsutils iputils-ping sudo curl nmap iproute2 procps gpg software-properties-common wget build-essential autoconf libtool git

WORKDIR /app/xsolla-example/public

CMD bash -c 'echo ===================================\n=\n= You site on: http://localhost:8080 \n=\n=================================== ; php -S 0.0.0.0:8080 index.php'
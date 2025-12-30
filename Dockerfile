FROM php:8.2-fpm

ARG user
ARG uid

# Instalar dependências do sistema + Node.js + npm
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário não-root
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar o projeto Laravel (necessário antes do composer install)
COPY . .

# Permissões corretas
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Instalar dependências do Laravel e Node.js
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install

# Criar script que roda o npm run dev e o php-fpm juntos
RUN echo '#!/bin/bash\nnpm run dev &\nphp-fpm' > /usr/local/bin/start-container \
    && chmod +x /usr/local/bin/start-container

USER $user



CMD ["start-container"]

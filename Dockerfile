# Imagem base
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório
WORKDIR /var/www/html

# Copiar TODO o projeto primeiro
COPY . .

# Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar Node e gerar build do Vite
RUN npm install
RUN npm run build

# Permissões
RUN chown -R www-data:www-data storage bootstrap/cache

# Expor porta
EXPOSE 8000

# Rodar Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000


# 1️⃣ Imagem base
FROM php:8.2-fpm

# 2️⃣ Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql zip

# 3️⃣ Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4️⃣ Definir diretório
WORKDIR /var/www/html

# 5️⃣ Copiar TODO o projeto primeiro
COPY . .

# 6️⃣ Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader

# 7️⃣ Instalar Node e gerar build do Vite
RUN npm install
RUN npm run build

# 8️⃣ Permissões
RUN chown -R www-data:www-data storage bootstrap/cache

# 9️⃣ Expor porta
EXPOSE 8000

# 🔟 Rodar Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000

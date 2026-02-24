# 1️⃣ Imagem base do PHP com extensões necessárias
FROM php:8.2-fpm

# 2️⃣ Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql zip mbstring bcmath

# 3️⃣ Configurar diretório de trabalho
WORKDIR /var/www/html

# 4️⃣ Copiar composer.json e composer.lock e instalar dependências PHP
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# 5️⃣ Copiar todo o código do Laravel
COPY . .

# 6️⃣ Instalar dependências Node e build do Vite
RUN npm install
RUN npm run build

# 7️⃣ Ajustar permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8️⃣ Expor porta (para PHP-FPM, render irá mapear automaticamente)
EXPOSE 9000

# 9️⃣ Comando para rodar PHP-FPM
CMD ["php-fpm"]

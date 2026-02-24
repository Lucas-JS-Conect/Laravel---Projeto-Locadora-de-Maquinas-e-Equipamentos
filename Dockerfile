# 1. Imagem base com PHP 8.2
FROM php:8.2-fpm

# 2. Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql

# 3. Configurar diretório de trabalho
WORKDIR /var/www/html

# 4. Copiar arquivos do projeto
COPY . .

# 5. Instalar dependências do PHP e Node
RUN composer install --no-dev --optimize-autoloader
RUN npm install

# 6. Build dos assets do Vite
RUN npm run build

# 7. Otimizações do Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# 8. Expor porta 8000
EXPOSE 8000

# 9. Comando para iniciar o servidor Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

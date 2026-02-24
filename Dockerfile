# Use imagem oficial PHP + Nginx
FROM richarvey/nginx-php-fpm:3.1.6

# Define o diretório do app
WORKDIR /var/www/html

# Copia todos os arquivos do projeto
COPY . .

# Instala dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Ajusta permissões da pasta storage e cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expõe a porta que o Render vai usar
EXPOSE 10000

# Comando para rodar o Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000
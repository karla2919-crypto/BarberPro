
FROM dunglas/frankenphp:1-php8.4-bookworm

# Instalar el controlador de MySQL para PHP
RUN install-php-extensions pdo_mysql

# Directorio de la aplicación
WORKDIR /app/public

# Copiar los archivos del proyecto
COPY . /app/public

# Iniciar FrankenPHP usando el puerto de Railway
CMD ["sh", "-c", "export SERVER_NAME=\":${PORT:-8080}\" && frankenphp run --config /etc/caddy/Caddyfile"]

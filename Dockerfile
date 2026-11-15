
FROM dunglas/frankenphp:1-php8.4-bookworm

# Instalar conexión MySQL para PHP
RUN install-php-extensions pdo_mysql

# Directorio principal
WORKDIR /app

# Copiar el proyecto
COPY . /app/public

# Indicar dónde están los archivos PHP
ENV SERVER_ROOT=/app/public

# Iniciar servidor en el puerto de Railway
CMD ["sh", "-c", "export SERVER_NAME=\":${PORT:-8080}\"; exec frankenphp run --config /etc/frankenphp/Caddyfile"]

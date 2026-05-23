FROM php:8.2-apache     

# Copia el proyecto completo a la ruta por defecto de Apache
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80 que es el estándar HTTP
EXPOSE 80

CMD ["apache2-foreground"]


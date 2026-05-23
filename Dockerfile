FROM php:8.2-apache     

# Copia el proyecto completo
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# 🚀 NUEVA LÍNEA: Le dice a Apache que index.php es el archivo principal de arranque
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
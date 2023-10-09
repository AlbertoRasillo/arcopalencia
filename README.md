Website Arco Palencia web service for local and proximity products

# Deployment

```
chown -R www-data:www-data /var/www/html/arcopalencia
find /var/www/html/arcopalencia -type d -exec chmod 755 {} \; 
find /var/www/html/arcopalencia -type f -exec chmod 644 {} \; 
chmod 600 /var/www/html/arcopalencia/conectar.php;
sudo chown -R usuario_git:usuario_git /var/www/html/arcopalencia/.git
```

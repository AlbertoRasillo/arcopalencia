#Fichero de migración de versión PHP para las funciones obsoletas

#Aplicar permisos carpetas y ficheros

find . -type d -exec chmod 755 -- {} +
find . -type f -exec chmod 644 -- {} +


#Con estos comandos de terminal cambiamos las funciones de php para que sean soportadas en PHP7

grep -rl --exclude=migracionphp.sh 'mysql_real_escape_string(' . | xargs sed -i 's/mysql_real_escape_string(/mysqli_real_escape_string($con,/g'

grep -rl --exclude=migracionphp.sh 'mysql_fetch_array($fila)' . | xargs sed -i 's/mysql_fetch_array($fila)/mysqli_fetch_array($fila,MYSQLI_ASSOC)/g'

grep -rl --exclude=migracionphp.sh 'mysql_fetch_array($buscar)' . | xargs sed -i 's/mysql_fetch_array($buscar)/mysqli_fetch_array($buscar,MYSQLI_ASSOC)/g'

grep -rl --exclude=migracionphp.sh 'mysql_fetch_array($idproductor)' . | xargs sed -i 's/mysql_fetch_array($idproductor)/mysqli_fetch_array($idproductor,MYSQLI_ASSOC)/g'

grep -rl --exclude=migracionphp.sh 'mysql_fetch_array($categoria)' . | xargs sed -i 's/mysql_fetch_array($categoria)/mysqli_fetch_array($categoria,MYSQLI_ASSOC)/g'

grep -rl --exclude=migracionphp.sh 'mysql_query(' . | xargs sed -i 's/mysql_query(/mysqli_query($con,/g'

grep -rl --exclude=migracionphp.sh 'mysql_error' . | xargs sed -i 's/mysql_error/mysqli_error/g'

grep -rl --exclude=migracionphp.sh 'mysql_close()' . | xargs sed -i 's/mysql_close()/mysqli_close($con)/g'

grep -rl --exclude=migracionphp.sh 'mysql_fetch_assoc' . | xargs sed -i 's/mysql_fetch_assoc/mysqli_fetch_assoc/g'

grep -rl --exclude=migracionphp.sh 'mysql_close()' . | xargs sed -i 's/mysql_close()/mysqli_close($con)/g'



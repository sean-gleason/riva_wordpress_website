docker build -t riva-wordpress:latest .
id=$(docker run -ti --rm --detach riva-wordpress:latest)
sleep 10
docker cp $id:/var/www/html/wp-config-sample.php ./wp-config.php
docker stop $id
cd ..
docker-compose up

docker build -t riva-wordpress:latest .
id=$(docker run -ti --rm --detach riva-wordpress:latest)
sleep 10
docker cp $id:/var/www/html/wp-config-sample.php ./wp-config.php
docker stop $id
sh sed_comm.sh
cd ..
docker-compose up

# update wp_options set option_value = 'https://localhost:8001' where option_id = 1;
# update wp_options set option_value = 'https://localhost:8001' where option_id = 2;
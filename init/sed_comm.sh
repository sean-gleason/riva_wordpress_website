Var='$_ENV'
sed -i '' -e "s/'database_name_here'/$Var[\"MYSQL_DATABASE\"]/g" wp-config.php
sed -i '' -e "s/'username_here'/$Var[\"MYSQL_USER\"]/g" wp-config.php
sed -i '' -e "s/'password_here'/$Var[\"MYSQL_PASSWORD\"]/g" wp-config.php
sed -i '' -e "s/'localhost'/$Var[\"MYSQL_HOST\"]/g" wp-config.php

# define( 'DB_NAME', $_ENV["MYSQL_DATABASE"] );
# define( 'DB_USER', $_ENV["MYSQL_USER"] );
# define( 'DB_PASSWORD', $_ENV["MYSQL_PASSWORD"] );
# define( 'DB_HOST', $_ENV["MYSQL_HOST"]);

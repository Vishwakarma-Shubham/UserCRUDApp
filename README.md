# UserCRUDApp

# Getting Started 

# Intall the dependencies

sudo yum/dnf install php php-fpm php-mysqlnd php-pdo  # AlmaLinux, CentOS
sudo apt install php php-fpm php-mysql php-pdo # Ubuntu, Debian

# Verfiy the php installation
php -v

# Install Mariadb Server
sudo yum/dnf install mariadb-server   # AlmaLinux, CentOS
sudo apt install mariadb-server   # Ubuntu, Debian

# Start and enable the Mariadb Server
systemctl enable mariadb --now

# Initail setup of the Mariadb Server, set the password and remote login, make sure the mariadb service is runnig before this
mysql_secure_installation

# Install Nginx
sudo yum/dnf install nginx   # AlmaLinux, CentOS
sudo apt install nginx   # Ubuntu, Debian

# Start enable and veriffy the nginx status 
systemctl enable nginx --now 
systemctl status nginx


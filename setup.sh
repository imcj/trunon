apt-get update
apt-get install python python-pip php5 php5-cli php5-curl php5-sqlite \
libapache2-mod-php5 apache2 -y
apt-get install composer
pip install supervisor
service apache2 start
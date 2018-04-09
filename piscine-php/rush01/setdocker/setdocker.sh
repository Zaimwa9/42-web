docker run -d --restart on-failure -p 3306:3306 -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=rush00 --name stock mysql
docker run -p 8100:80 --link stock:mysql -v $HOME/http/MyWebSite:/var/www/html --name lamp fauria/lamp
$db = new PDO("mysql:host=192.168.99.100;port=3306;dbname=rush00", "root", "root");

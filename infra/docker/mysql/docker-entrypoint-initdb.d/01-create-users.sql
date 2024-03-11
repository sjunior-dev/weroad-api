CREATE USER 'weroad_admin'@'%' IDENTIFIED WITH mysql_native_password BY 'c6fc76ed515c1ec91f7f8534';
GRANT ALL ON *.* TO 'weroad_admin'@'%';
GRANT ALL ON weroad_db.* TO 'root'@'%';

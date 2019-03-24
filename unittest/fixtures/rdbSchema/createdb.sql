CREATE USER IF NOT EXISTS 'dbuser'@'%' IDENTIFIED WITH mysql_native_password BY 'dbpass';

CREATE DATABASE IF NOT EXISTS dddStudy01 DEFAULT CHARACTER SET utf8mb4;
GRANT ALL ON dddStudy01.* TO 'dbuser'@'%';

use dddStudy01;
CREATE TABLE IF NOT EXISTS items(
  id int AUTO_INCREMENT COMMENT '商品ID',
  name varchar(100) NOT NULL COMMENT '商品名',
  price int NOT NULL COMMENT '商品価格',
  stock int NOT NULL COMMENT '商品個数',
  PRIMARY KEY(id)
) engine=InnoDB;


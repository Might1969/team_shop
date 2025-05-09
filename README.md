# !!
Please put the indi_shop folder under htdocs: ...../htdocs/indi_shop/
That is to say, if the path is correct, this file is located at: ...../htdocs/indi_shop/README.md

请将indi_shop文件夹置于htdocs下：...../htdocs/indi_shop/
也就是说如果路径正确，那么本文件位于：...../htdocs/indi_shop/README.md
 ---
# Part A 
## Functions: 
Manage products; 
Manage shopping carts; 
Manage accounts

## Location:
The file of the Nth exercise of part B is located in indi_shop/ProjectAssgn-Ind-PartA

## Create a database:
Start MySQL through XAMPP, create a new database in phpMyAdmin (name it "indi_shop_db", sorting rule "utf8mb4_general_ci")
Import indi_shop/ProjectAssgn-Ind-PartA/createTable.sql and execute it.

## Use:
Access localhost/indi_shop/ProjectAssgn-Ind-PartA/project/index.php through a browser

  ---
# Part B
##Location:
The file of the Nth exercise of part B is located in indi_shop/ProjectAssgn-Ind-PartB-0N

## Create a database:
Start MySQL through XAMPP, create a new database in phpMyAdmin (name it "b0Ndb", sorting rule "utf8mb4_general_ci")
Import indi_shop/ProjectAssgn-Ind-PartB-0N/createTable.sql and execute it.

## Use:
Access localhost/indi_shop/ProjectAssgn-Ind-PartB-0N/index.php through a browser

## For example: 
Practice001 is located in indi_shop/ProjectAssgn-Ind-PartB-01, and you need to create a database "b01db", import indi_shop/ProjectAssgn-Ind-PartB-01/createTable.sql and execute it.
Access localhost/indi_shop/ProjectAssgn-Ind-PartB-01/index.php through a browser

## For Practice005:
The program has the following path by default: htdocs/indi_shop/ProjectAssgn-Ind-PartB-05/includes/reset-request.inc.php
If you change the path, please make sure that in indi_shop/ProjectAssgn-Ind-PartB-05/includes/reset-request.inc.php, line 15: $url = "http://".$_SERVER['HTTP_HOST']."/indi_shop/ProjectAssgn-Ind-PartB-05/create-new-password.php?selector=".$selector."&validator=".$validator; the path can correctly lead to ProjectAssgn-Ind-PartB-05/create-new-password.php, otherwise the reset password link will cause the URL to be unable to be found

## 位置：
part B 第N个练习的文件位于indi_shop/ProjectAssgn-Ind-PartB-0N

## 创建数据库：
通过XAMPP启动MySQL,在phpMyAdmin中新建数据库（命名为“b0Ndb”，排序规则“utf8mb4_general_ci”）
导入indi_shop/ProjectAssgn-Ind-PartB-0N/createTable.sql并执行.

## 使用：
通过浏览器访问localhost/indi_shop/ProjectAssgn-Ind-PartB-0N/index.php

## 如：
Practice001位于indi_shop/ProjectAssgn-Ind-PartB-01,需要创建数据库“b01db”，导入indi_shop/ProjectAssgn-Ind-PartB-01/createTable.sql并执行.
通过浏览器访问localhost/indi_shop/ProjectAssgn-Ind-PartB-01/index.php

## 对于Practice005：
程序默认存在以下路径htdocs/indi_shop/ProjectAssgn-Ind-PartB-05/includes/reset-request.inc.php
如果你修改了路径，请确保indi_shop/ProjectAssgn-Ind-PartB-05/includes/reset-request.inc.php中第15行$url = "http://".$_SERVER['HTTP_HOST']."/indi_shop/ProjectAssgn-Ind-PartB-05/create-new-password.php?selector=".$selector."&validator=".$validator;路径能正确导向ProjectAssgn-Ind-PartB-05/create-new-password.php，否则重置密码链接会导致无法找到url

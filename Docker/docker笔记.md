## Mysql

```bash
docker pull mysql:5.7.41
```

```bash
docker run -d -p 3307:3306 --privileged=true -v /home/aaron/docker/mysql/log:/var/log -v /home/aaron/docker/mysql/data:/var/lib/mysql -v /home/aaron/docker/mysql/conf:/etc/mysql/conf.d -e MYSQL_ROOT_PASSWORD=123456 --restart=always --net lanNet --name mysql mysql:5.7.41

参数：
--privileged     //Give extended privileges to this container。使用该参数，container内的root拥有真正的root权限。否则，container内的root只是外部的一个普通用户权限。
--name="名称"	// 设置容器名
-d 				// 后台方式运行
-it             // 使用交互方式运行，可以进入容器查看内容
-p				//（小p）, 指定容器端口
	-p ip:主机端口:容器端口
	-p 主机端口:容器端口（常用）
	-p 容器端口
-P				//（大P）, 随机指定容器端口
-v              //本地挂载。linux（宿主机）目录路径:docker容器中的目录路径。挂载了三个目录，分别是日志、数据、配置文件
--restart=always //docker启动时自动启动容器
/mnt/d/         //挂载到Windows的D盘
```

```bash
cd /etc
vim my.cnf
```

```bash
[client]
default_character_set=utf8
[mysqld]
collation_server=utf8_general_ci
character_set_server=utf8
```

## Nginx

> 启动前需要先创建 Nginx 外部挂载的配置文件（ /home/nginx/conf/nginx.conf）
> 之所以要先创建 , 是因为 Nginx 本身容器只存在/etc/nginx 目录 ,
> 本身就不创建 nginx.conf 文件
> 当服务器和容器都不存在 nginx.conf 文件时, 执行启动命令的时候
> docker 会将 nginx.conf 作为目录创建 , 这并不是我们想要的结果 。

```bash
 docker run --name nginx -p 80:80 -d nginx:latest
 docker cp nginx:/etc/nginx/nginx.conf D:/docker/nginx/conf/nginx.conf
 docker cp nginx:/etc/nginx/conf.d D:/docker/nginx/conf/conf.d/
 docker cp nginx:/usr/share/nginx/html D:/docker/nginx/
```

```bash
# 直接执行docker rm nginx或者以容器id方式关闭容器
# 找到nginx对应的容器id
docker ps -a
# 关闭该容器
docker stop nginx
# 删除该容器
docker rm nginx

# 删除正在运行的nginx容器
docker rm -f nginx
```

```bash
docker run -p 80:80 --name nginx -v /home/aaron/docker/nginx/conf/nginx.conf:/etc/nginx/nginx.conf -v /home/aaron/docker/nginx/conf/conf.d:/etc/nginx/conf.d -v /home/aaron/docker/nginx/log:/var/log/nginx -v /home/aaron/docker/nginx/html:/usr/share/nginx/html --restart=always --net lanNet -d nginx:latest

–name nginx		//启动容器的名字
-d				//后台运行
-p 8001:80		//映射端口，格式为“宿主机端口:容器端口”
-v /home/nginx/conf/nginx.conf:/etc/nginx/nginx.conf //挂载nginx.conf配置文件
-v /home/nginx/conf/conf.d:/etc/nginx/conf.d	//挂载nginx配置文件
-v /home/nginx/log:/var/log/nginx	//挂载nginx日志文件
-v /home/nginx/html:/usr/share/nginx/html	//挂载nginx内容
nginx:latest	//本地运行的版本
--restart=always //docker启动时自动启动容器
```

## Redis

```bash
docker run -p 6380:6379 --name redis -v /home/aaron/docker/redis/conf/redis.conf:/usr/redis/redis.conf -v /home/aaron/docker/redis/data:/data --restart=always --net lanNet -d redis:latest redis-server /usr/redis/redis.conf --appendonly yes --requirepass 123456

--restart=always 	//总是开机启动
-p 6379:6379 	//将6379端口挂载出去
--name 		//给这个容器取一个名字
-v 		//数据卷挂载
- /home/redis/myredis/myredis.conf:/etc/redis/redis.conf //这里是将 liunx 路径下的myredis.conf 和redis下的redis.conf 挂载在一起。
- /home/redis/myredis/data:/data //这个同上
-d redis //表示后台启动redis
redis-server /etc/redis/redis.conf //以配置文件启动redis，加载容器内的conf文件，最终找到的是挂载的目录 /etc/redis/redis.conf 也就是liunx下的/home/redis/myredis/myredis.conf
–appendonly yes //开启redis 持久化
–requirepass 000415 //设置密码 （如果你是通过docker 容器内部连接的话，就随意，可设可不设。但是如果想向外开放的话，一定要设置，/
```

```bash
//修改配置
requirepass 123456
daemonize yes
#如果3600s内，如果至少有1个key进行了修改，我们即进行持久化操作
save 3600 1
#如果300s内，如果至少100个 key进行了修改，我们即进行持久化操作
save 300 100
# 如果60s内，如果至少1000个 key进行了修改，我们即进行持久化操作
save 60 10000

允许 redis 外地连接 必须
注释掉 # bind 127.0.0.1

daemonize no
将 daemonize yes 注释起来或者 daemonize no 设置，因为该配置和 docker run 中-d 参数冲突，会导致容器一直启动失败

```

## Hyperf

```bash
docker run --name hyperf -v /home/aaron/docker/hyperf/project:/data/project -p 9501:9501 -it --restart=always --net lanNet -d --privileged -u root --entrypoint /bin/bash hyperf/hyperf:latest
```

```bash
# 查看端口上的进程pid号
netstat -anp | grep 9501
tcp        0      0 0.0.0.0:9501            0.0.0.0:*               LISTEN      20852/skeleton.Mast

# 根据上面查看到的进程号kill掉
kill -9 20852

php /data/project/hyperf/bin/hyperf.php start
```

```bash
bash-4.4# //这里面没有/etc/skel/目录文件，所以需要从外部复制进去
docker cp /home/aaron/docker/skel/.bashrc hyperf:/root/

docker exec -it hyperf /bin/bash
apk update
composer -v  //如果版本是1.xx版本太低了需要升级
composer self-update --2  //composer版本升级到2.xx就可以使用了
```

## Docker

> https://docs.docker.com/desktop/windows/wsl/

> https://learn.microsoft.com/en-us/windows/wsl/tutorials/wsl-containers

```bash
docker run --help   //帮助命令
docker run  -it mysql:5.7.41 /bin/bash   //新建并启动容器
docker exec -it mysql /bin/bash   //进入已运行的容器
docker logs -f docker-mongo  //查看容器日志信息
service docker start   //启动docker命令
cat /proc/version   //查看Linux版本
docker version   //查看docker版本
```

```bash
docker network ls
docker network create --driver bridge --subnet 10.10.0.0/16 --gateway 10.10.0.1 lanNet
docker network inspect lanNet
```

```bash
//docker进入容器显示bash-4.2解决方案
aaron@Aaron:~$ docker exec -it mysql /bin/bash
bash-4.2# cd /etc/skel/
bash-4.2# cp .bash_profile /root/
bash-4.2# cp .bashrc /root/
bash-4.2# exit
exit
```
```bash
//启动docker
sudo service docker start
//停止docker
sudo service docker stop
//重启docker
sudo service docker restart
```
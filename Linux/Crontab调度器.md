### Crontab 指定执行用户

> linux下可以通过配置crontab来定时执行任务，执行体可以是一条系统命令或自己写的一个脚本，同时可以指派用户来执行。配置crontab有两种方法。

1. 使用crontab命令，例如添加一个新的或编辑已有的。
	```bash
	crontab -e # 此时配置crontab的执行者是当前登入用户。
	crontab -e -u 用户名 # 如果当前用户是root，需要为其他用户配置使用这个命令
	```
	例子：
	```bash
	crontab -e -u nginx #nginx是用户

	#执行laravel的任务调度

	* * * * * cd /usr/share/nginx/html/project/ && php artisan schedule:run >> /dev/null 2>&1
	```
2. 直接在/etc/crontab文件中添加，不过只有root身份才行。
	```bash
	vi   /etc/crontab # 打开文件
	# 文件内大致信息内容
	SHELL=/bin/bash
	PATH=/sbin:/bin:/usr/sbin:/usr/bin
	MAILTO=root
	HOME=/

	# For details see man 4 crontabs

	# Example of job definition:
	# .---------------- minute (0 - 59)
	# |  .------------- hour (0 - 23)
	# |  |  .---------- day of month (1 - 31)
	# |  |  |  .------- month (1 - 12) OR jan,feb,mar,apr ...
	# |  |  |  |  .---- day of week (0 - 6) (Sunday=0 or 7) OR 			sun,mon,tue,wed,thu,fri,sat
	# |  |  |  |  |
	# *  *  *  *  * user-name command to be executed
	
	#   run-parts
	
	01 * * * * root   nice   -n   19     run-parts   /etc/cron.hourly
	02 4 * * * root   nice   -n   19    run-parts   /etc/cron.daily
	22 4 * * * root    nice   -n   19   run-parts   /etc/cron.weekly
	42 4 1 * * root   nice   -n    19  run-parts   /etc/cron.monthly
	```


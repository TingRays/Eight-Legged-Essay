cat ~/.ssh/id_rsa.pub  获取密钥 没有则生成 ssh-keygen -t rsa

创建文件夹:mkdir ~/.ssh

创建文件:touch ~/.ssh/authorized_keys

把id_rsa.pub的内容粘贴到.ssh/authorized_keys里面去

然后修改权限

chmod 700 ~/.ssh

chmod 600 ~/.ssh/authorized_keys

登录： ssh root@公网IP -p 端口
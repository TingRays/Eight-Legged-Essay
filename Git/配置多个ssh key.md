### 在同一电脑上生成配置多个ssh key 公钥 私钥

> https://blog.csdn.net/qq_55558061/article/details/124117445 

```bash
Host codeup.aliyun.com
IdentityFile ~/.ssh/id_rsa.project01
User yunnitec01
Host project.codeup.aliyun.com
Hostname codeup.aliyun.com
IdentityFile ~/.ssh/id_rsa.project02
User project02
```
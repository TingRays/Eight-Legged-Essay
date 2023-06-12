####  配置示例

> 重点在于`ssl`的配置，和`路由重新`。当然也可以根据需求不用重写路由。`http`和`https`都能访问，不强跳`https`
```nginx
server {
      listen 443 ssl;
      server_name fxt.baidu.com;
      
      root /www/projects/baidu/fxt.baidu.com;
      index index.html index.htm index.php;

      ssl_certificate  /www/ssl/baidu/fxt.baidu.com/7531563_console.ceciadjk.cn.pem;
      ssl_certificate_key /www/ssl/baidu/fxt.baidu.com/7531563_console.ceciadjk.cn.key;
      ssl_session_timeout 10m;
      ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
      ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
      ssl_prefer_server_ciphers on;

      access_log  /var/log/nginx/fxt_baidu_com/access.log  main;
      charset utf-8;
      server_tokens off;

      add_header X-Content-Type-Options nosniff;
      add_header X-XSS-Protection "1; mode=block";
      

      location = /favicon.ico { access_log off; log_not_found off; }
      location = /robots.txt  { access_log off; log_not_found off; }

      location ~ \.php$ {
          fastcgi_pass 127.0.0.1:9000;
          fastcgi_index index.php;
          fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
          fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
      fastcgi_param PATH_INFO $fastcgi_path_info;
          fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
          include fastcgi_params;
          fastcgi_hide_header X-Powered-By;
          fastcgi_hide_header X-CF-Powered-By;
          fastcgi_connect_timeout 600;
          fastcgi_send_timeout 600;
          fastcgi_read_timeout 600;
          fastcgi_buffer_size 64k;
          fastcgi_buffers 4 64k;
          fastcgi_busy_buffers_size 128k;
          fastcgi_temp_file_write_size 512k;
          fastcgi_intercept_errors on;
          try_files $uri = 404;
      }

      location ~ /\.(?!well-known).* { deny all; }

      location ~* \.(ico|jpe?g|gif|png|bmp|swf|flv)$ { expires 30d; access_log off; }

      location ~* \.(js|css)$ { expires 7d; log_not_found off;  access_log off; }
} 

server {
    listen 80;
    server_name fxt.baidu.com;
    rewrite ^(.*)$ https://fxt.baidu.com$1 permanent;
}
```
# CentOSのver.6を指定
FROM centos:6

# 変数の定義
ENV code_root /code
ENV httpd_conf ${code_root}/httpd.conf

# Apacheのインストール
RUN yum install -y httpd

# phpとPEARのインストール
RUN yum install -y php php-mbstring php-mysql php-gd php-pear
RUN pear install MDB2 MDB2_Driver_mysql
RUN sed -i -e "s|^;date.timezone =.*$|date.timezone = Asia/Tokyo|" /etc/php.ini

# ルートディレクトリを変更（http.confファイルに追記）
ADD . $code_root
RUN test -e $httpd_conf && echo "Include $httpd_conf" >> /etc/httpd/conf/httpd.conf

# 外部に公開するコンテナのポートを指定
EXPOSE 80

# イメージからコンテナを起動するときに実行するコマンドを指定
CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]

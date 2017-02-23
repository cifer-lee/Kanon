Kanon
=====

Bitmain Hire Test --- PHP-exchange

本测验直接基于我当年写的 Kanon 框架完成的, 总共大概花了 3 小时, 其中写后台代码大约 30 分钟, 剩下两个半小时在复习 JQuery, CSS 等前端知识, 以及各种费劲的调前端样式.

## 运行说明

经过分析, 后端采用 MongoDB 数据库存储下单队列和成交队列, 分别为 exchange.orders 和 exchange.matches.

由于 PDO 并没有支持 MongoDB, 所以用 composer 下载了 MongoDB PHP Lib, 为方便起见我将 vendor/ 目录也提交了.

执行 `php populate_roder.php` 这个脚本会在后台不断的生成随机的 order 信息填充 exchange.orders.

部署环境是典型的 Nginx + PHP-FPM, 部署时需要注意的一点是, 我的 Kanon 框架的路由并不依赖于 PATH_INFO 而是依赖于 REQUEST_URI, 无需纠结 nginx 中 path_info 的配置问题:

	location / {
		#try_files $uri $uri/ =404;
		try_files $uri $uri/ /index.php;
    }

部署好之后直接访问网站主页, 即可看到效果.

网页采用 Bootstrap + JQuery. 用 Ajax 技术每隔 3s 向后端请求 order 信息和成交信息.

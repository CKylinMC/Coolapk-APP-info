# Coolapk-APP-info
抓取网页版酷安的应用信息

# 使用方法
```php
require('coolapk_get.php');
get('com.coolapk.market');
```
将会返回JSON格式信息
包括：

* 应用名
* 简介
* 下载链接
* 需求版本（文字）
* 大小 （xxM）
* 最后更新（xx前更新）
* 当前版本
* 评分

* 包名
* 网页地址

TODO：

* 图标地址
* 截屏地址
* 关注数量
* 下载数量
* 评论数量
* 权限
* 版本历史
* 更新详情

返回值例如：
```json

{"status":0,"pkg":"com.coolapk.market","url":"http:\/\/www.coolapk.com\/apk\/com.coolapk.market","msg":{"ver":"7.9","description":"\u9177\u5b89(com.coolapk.market) 7.9\uff1a\u662f\u4e0d\u662f\u611f\u89c9\u65b0\u7248\u9177\u5b89\u66f4\u597d\u73a9\u4e86\uff0c\u6ca1\u9519\uff0c\u5c31\u662f\u66f4\u597d\u73a9\uff0c\u6211\u4eec\u5176\u5b9e\u662f\u4e00\u4e2a\u6302\u7740\u5e94\u7528\u5e02\u573a\u7684\u4ea4\u53cb\u793e\u533a\u3002","size":"6.56M","req":"5.0\u53ca\u66f4\u9ad8\u7248\u672c","vote":"4.5","update":"5\u5929\u524d\u66f4\u65b0","download":"https:\/\/dl.coolapk.com\/down?pn=com.coolapk.market&v=NDU5OQ&h=9f73ed1foqwky5"}}
```

成功的时候`status`为`0`，失败的时候为`err`，如：
```json

{"status":"err","code":"HttpErr:APP not found or no permissions.(404)"}
```

考虑到酷安有的app必须登录才能查看，加上了`or no permissions`的提示。

# 示例：一个信息获取api
coolgettest.php:
```php

<?php
$pkg = empty($_GET['pkg']) ? 'com.coolapk.market' : $_GET['pkg'];
require('coolapk_get.php');
$arr = get($pkg);
echo($arr);
```
访问`http://localhost:8080/coolgettest.php?pkg=com.coolapk.market`可获得json格式的酷安app信息

ThinkPHP 6.0
===============

> 运行环境要求PHP7.1+。基于tp6开发，目前部分功能还在完善中，本项目适合新手学习
微博：@沙坪坝韩宇

## 支持

[米醋儿网](http://www.micuer.com)
## 開發進度
# 前台
* 首頁
* 列表
* 詳情
* 評論
* 個人中心[一部分]
* 修改頭像
* 修改基礎信息
* 我的留言
# 後台
* 完成文章的增刪改查
* 完成視頻的增刪改查
* 完成軟件的增刪改查
* 完成後台個人信息的修改
* 完成密碼的修改
* 清理緩存
* RBAC待完善 -角色管理
* RBAC待完善 -分组管理
# 用到的框架
* 光年後台模板
* layui
* jquery
* layer
* thinkphp6
* 其他個人整理插件
* 等等

## 主要新特性

* 采用`PHP7`强类型（严格模式）
* 支持更多的`PSR`规范
* 原生多应用支持
* 更强大和易用的查询
* 全新的事件系统
* 模型事件和数据库事件统一纳入事件系统
* 模板引擎分离出核心
* 内部功能中间件化
* SESSION/Cookie机制改进
* 对Swoole以及协程支持改进
* 对IDE更加友好
* 统一和精简大量用法

## 安装

~~~
composer create-project topthink/think tp 6.0.*-dev
~~~

如果需要更新框架使用
~~~
composer update topthink/framework
~~~

## 文档

[完全开发手册](https://www.kancloud.cn/manual/thinkphp6_0/content)

## 参与开发

请参阅 [ThinkPHP 核心框架包](https://github.com/top-think/framework)。

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2019 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)

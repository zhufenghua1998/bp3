<h2 align="center"><a href="#">B</a>aidu Interface <a href="#">P</a>an Version<a href="#">3</a></h2>

<p align="center"><a href="https://github.com/zhufenghua1998/bp3/network"><img alt="GitHub forks" src="https://img.shields.io/github/forks/zhufenghua1998/bp3"></a> <a href="https://github.com/zhufenghua1998/bp3/stargazers"><img alt="GitHub stars" src="https://img.shields.io/github/stars/zhufenghua1998/bp3"></a> <a href="https://github.com/zhufenghua1998/bp3/issues"><img alt="GitHub issues" src="https://img.shields.io/github/issues/zhufenghua1998/bp3"></a> <a href="https://github.com/zhufenghua1998/bp3/blob/main/LICENSE"><img alt="GitHub license" src="https://img.shields.io/github/license/zhufenghua1998/bp3"></a></p>

## 删库

项目不再更新维护，相关代码已全部删除【包括所有Releases】，感谢关注，since 2021-09。

【已下载用户可继续使用，删库仅开源环境太差，开源很多时候并没有真正帮到任何人，而是被太多别有心机的人利用，作者心累，用户也付出了远比实际更多的成本，整个过程中也只有投机取巧者获利，时代的眼泪，我们的青春，再会！（技术交流请添加作者qq 1344694396@qq.com，备注bp3）】

## 📚简介

bp3是一款网盘程序，使用php开发，任意支持php的服务器均可以部署，包括虚拟主机

bp3本身并不存储数据，而是对接百度网盘，完全使用官方接口，长期稳定

如何用一句话描述bp3能做什么？

- 百度云会员用户：bp3=百度云+高速下载站
- 百度云普通用户：bp3=百度云+蓝奏云（单文件100MB不限速）
- 百度云开发者：bp3有强大的授权系统，可为控制台程序或Web程序快速授权

随着bp3的不断发展，当前也是最强大的百度网盘目录树生成工具，系统大部分功能都需要登录才能使用，说再多不如一试，请部署安装后自行体验。

## 📥安装
下载代码到服务器上（应该直接使用源码，releases仅用于记录每个大版本的更新），

已推出免app系统和内置app系统，最快只需要动动鼠标点击几下即可配置完毕，这是非常惊人的配置效率。

当然，你也可以使用正规配置（推荐），申请百度网盘开发者app，并填入信息即可。

另外，你需要注意的是：本程序编写环境为linux、php74（版本不可低于php7，支持到php8最新版本，需要curl以及zip扩展），因环境问题请尽量自行排查，若无法解决可求助。

尽管安装部署已经十分简单，但仍给出一个参考文档：[bp3简易使用手册](https://www.52dixiaowo.com/post-3261.html)

## ⛪demo
参考网站：

- <a href="https://bp3.52dixiaowo.com" target="_blank">bp3官方demo站点</a>
- [Windows系统镜像 | 高速下载 (okduang.com)](http://pan.okduang.com/)

首页示例图：

<div align="center"><a href="https://bp3.52dixiaowo.com"><img alt="huoniao" src="https://user-images.githubusercontent.com/66166878/202613658-174292fb-99c5-4802-8c11-ee2c807a93fd.png"></a></div>

## ✈特点与使用技巧

本程序完全使用百度网盘官方接口，无任何违规行为，程序非常稳定

本程序可以直接从百度网盘下载文件，这意味着可以合理的利用百度网盘的大存储容量

另外，即使你没有百度网盘会员，对于100MB以内的单个文件，仍然享有不限速服务，足以应对一般场景，如果你本身有百度网盘会员，可以拥有更畅快的体验

bp3是很棒的网盘系统，之所以这么说是有原因的：

- bp3内置了列表展示（同类程序基本都有）
- bp3内置了文件搜索，在应对海量数据时非常有用（同类程序几乎没有）
- 对文件、文件夹进行移动或重命名后，下载链接依然不会失效，这是因为文件是根据ID进行识别的（同类程序几乎都不能）

bp3能够对用户权限进行控制，你可以使用它作为目录展示工具，而不是一定要提供下载。

【支持绑定无限账户、每个账户绑定无限目录，支持极速导入无限制大小的百度网盘缓存DB，支持跨网盘搜索，自动同步百度网盘数据等，导入DB用于列表展示和数据搜索，千万级数据秒搜】。

bp3能够中转下载，或取得百度网盘直链（这里的直链，并非破解而来，而是官方接口，长期稳定可用）用于下载等。

## ☔版本更新

系统的稳定与可用是bp3的根基，bp3是长期维护项目，会不定期更新。

尽管已经做了很多努力，但是仍不确定更新后的新版本是否带来新bug。

如果你不喜欢折腾，而且下载到的程序没有bug且功能满足，您可以备份该源码并长期使用。

如果你是一个活跃用户，项目自动检测最新，请阅读新版本返回的注意事项，并安装给出的操作更新，有问题及时在群内反馈。

【支持国内国外服务器一键升级，支持导入压缩包一键升级等】

## ❤帮助与支持

悉知：我们无法保证程序中没有任何一个bug，或满足任何需求。

既然做了开源，就会努力做好，你可以参考前面的帮助手册，或程序后台的帮助页面。

你可以基于bp3二次开发，或做一些自定义，支持自定义编写主题页面等。

或者，你可以向我们反馈bug，以及提交建议，都会考虑。

你可以放心，程序中没有广告弹窗、也没有捐赠二维码，开源协议为最宽松的MIT，支持商用。

在这里，由衷地感谢各位用户、开发者、赞助商对本项目给予的建议、帮助与支持。

为了项目的良性发展，提出了以下思路：
- 提供了QQ交流群：1150064636。你可以在群里获得一些帮助。如果通过其他渠道，即使是github发布issue，也因为网络缓慢无法及时回复【本仓库Github和Gitee双库同步，也可在Gitee求职】。
- 如果你是小白，可付费9.9元，一年内安装部署升级提供技术服务，确保100%能使用，无需焦头烂额自己琢磨，节省时间或许是你想要的。
- 现有功能不满足，可提供建议并等待更新，或付费以快速定制功能。即使和 bp3 无关，也可以在群里寻求付费技术支持。

-- 支持我们，任意一种或多种方式，①分享本项目给好友，②点赞项目，③加群给群主发红包等方式【这里就不放赞助二维码了】，完。

特别赞助：

<div align="center"><a href="https://www.kumanyun.com/"><img alt="huoniao" src="https://user-images.githubusercontent.com/66166878/155361171-be2a7b63-b065-4257-807c-a54a98e6c069.png"></a></div>

其他赞助：

<div><a href="http://a.big2035.com"><img width="20%" alt="mb" src="https://user-images.githubusercontent.com/66166878/155515884-4a8036a1-05d4-43e3-a821-95dcf3ba0978.jpg"></a> <a href="https://coresns.com/"><img width="20%" alt="coresns" src="https://user-images.githubusercontent.com/66166878/175356167-bc9d1b9b-b8be-435f-a49a-60fe222c3eb8.jpg" alt=""></a></div>


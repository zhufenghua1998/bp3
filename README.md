<h2 align="center"><a href="#">B</a>aidu Interface <a href="#">P</a>an Version<a href="#">3</a></h2>

<p align="center"><a href="https://github.com/zhufenghua1998/bp3/network"><img alt="GitHub forks" src="https://img.shields.io/github/forks/zhufenghua1998/bp3"></a> <a href="https://github.com/zhufenghua1998/bp3/stargazers"><img alt="GitHub stars" src="https://img.shields.io/github/stars/zhufenghua1998/bp3"></a> <a href="https://github.com/zhufenghua1998/bp3/issues"><img alt="GitHub issues" src="https://img.shields.io/github/issues/zhufenghua1998/bp3"></a> <a href="https://github.com/zhufenghua1998/bp3/blob/main/LICENSE"><img alt="GitHub license" src="https://img.shields.io/github/license/zhufenghua1998/bp3"></a></p>

## 📚简介

bp3是一款网盘程序，使用php开发，任意支持php的服务器均可以部署，包括虚拟主机

bp3本身并不存储数据，而是对接百度网盘，完全使用官方接口，长期稳定

如何用一句话描述bp3能做什么？

- 百度云会员用户：bp3=百度云+高速下载站
- 百度云普通用户：bp3=百度云+蓝奏云（单文件100MB不限速）
- 百度云开发者：bp3有强大的授权系统，可为控制台程序或Web程序快速授权

另外，bp3是一个创新设计作品，它有一些新颖的设计、功能，请相信它会给你带来惊喜。

## 📥安装
下载代码到服务器上（直接使用源代码就是最新的，而releases可能延迟发布），

已推出免app系统，最快只需要动动鼠标点击几下即可配置完毕，这是非常惊人的配置效率。

当然，你也可以使用正规配置，申请百度网盘开发者app，并填入信息即可。

另外，你需要注意的是：本程序编写环境php74，如果版本过高因语法问题php可能发出警告。

尽管安装部署已经十分简单，但仍给出一个参考文档：[bp3简易使用手册](https://www.52dixiaowo.com/post-3261.html)

## ⛪demo
参考网站：

- <a href="https://bp3.52dixiaowo.com" target="_blank">bp3官方demo站点</a>
- [bp3官方海外备用demo站点 ](http://bp3.rbusoft.com/)
- [Windows系统镜像 | 高速下载 (okduang.com)](http://pan.okduang.com/)

## ✈️特点与使用技巧

本程序完全使用百度网盘官方接口，无任何违规行为，程序非常稳定

本程序可以直接从百度网盘下载文件，这意味着可以合理的利用百度网盘的大存储容量

另外，即使你没有百度网盘会员，对于100MB以内的单个文件，仍然享有不限速服务，足以应对一般场景，如果你本身有百度网盘会员，可以拥有更畅快的体验

bp3是很棒的网盘系统，之所以这么说是有原因的：

- bp3内置了列表展示（同类程序基本都有）
- bp3内置了文件搜索，在应对海量数据时非常有用（同类程序几乎没有）
- 对文件、文件夹进行移动或重命名后，下载链接依然不会失效，这是因为文件是根据ID进行识别的（同类程序几乎都不能）
- 当然，它也能生成有期限的下载链接

基于以上几点，相信你已经明白bp3的强大之处，它完全不是你所常见的一个简单的文件列表展示程序。但话说回来，我们还是希望您亲自尝试一下，以便做出更客观的评价。

## ☔版本更新

bp3是长期维护项目，会不定期更新，但目前来说，每一个版本的迭代都没有更新推送，这一点比较遗憾，如果你发现程序更新，且确切需要新版本功能，我们首先声明：

- 所有的配置信息，均保存在config.php文件中，其他文件与升级均不相关。
- 未安装前的配置文件与conf_base.php文件一致（以下简称base）

那么，一个安全、完美的升级做法是：

- 先对比新版本、你当前版本中的base文件
- 如果base一致，则说明配置文件没有升级，那么保留config.php，其他文件全部覆盖即可。
- 否则，你应该在config.php中添加base新增的默认数据，其他文件全部覆盖即可。

上述只是告诉你，一般文件直接覆盖即可，而重要的信息的config.php中，如果config.php也升级了（通过base识别），那么手动添加这些新增的信息。

当然你可以整站覆盖，并重新配置，bp3的配置已经非常简单了，您无须为升级产生顾虑。

## ❤️帮助与支持

你的建议对bp3的发展至关重要，感谢提交bug或建议

这里有必要重新声明，bp3是免费、开源的，你也没必要捐赠，并且在所有地方都找不到捐赠二维码

此外，即使你没有任何疑惑，仍可以添加QQ交流群来唠嗑：1150064636

延伸或相关项目推荐：

- [dylanbai8/start_chrome_with_useragent ](https://github.com/dylanbai8/start_chrome_with_useragent)

最后，感谢各位开发者对本项目给予的建议、帮助与支持

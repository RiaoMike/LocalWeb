# Linux 
---
## 第七章 系统管理

### Service 服务管理（CentOS 6-了解）

#### 1. systemctl

> systemctl start | stop | restart |status service-name

用**systemctl**管理的服务都放在/usr/lib/systemd/system目录下

**systemctl**控制服务开机自启动或开机不自动启动
> systemctl enable | disable service-name

列出所有管理单元
> systemctl list-unit-files

#### 2. setup

进入系统服务配置界面，带*号即为开机自启动服务，用空格进行选择或取消

> 开机后运行顺序：开机--BIOS--/boot--init进程--运行级别--运行对应级别的服务

#### 3. CentOS7 运行级别
1. multi-user.target 等价于运行级别3（多用户有网，无图形界面）
2. graphical.target 等价于运行级别5（多用户有网，由图形界面）

查看当前运行级别
> systemctl get-default

更改默认运行级别
> systemctl set-default TARGET.target(这里TARGET是multi-user或graphical)

#### 4. 防火墙配置
> centos6及之前用*iptables*进行管理，而在centos7中改用**firewalld**进行管理

#### 5. 关机
关机前养成数据同步的习惯
> sync(**shutdown自带了sync操作**)

关机（默认一分钟后）
> shutdown 也可以跟一个数字，表示几分钟后关机 shutdown 3
> 定时关机 shutdown 15:38

取消关机
> shutdown -c

现在关机（常用）
> shutdown now
> 重启reboot 相当于 shutdown -r now

---
## 第八章 常用基本了命令
### 帮助命令
#### 1. man

基本语法
> man command

#### 2. help
命令分为外部命令和内置命令(built-in)，内置命令直接嵌入到shell中，写在shell源码里

**help 只能用于内置命令**(但是可以用command --help查看)
比如**cd**,**exit**,**history**,这些命令可用**help**进行查看
> help command

> man -f command
```bash
[root@centos100 ~]# man -f cd
cd (1)               - bash built-in commands, see bash(1)
cd (1p)              - change the working directory
[root@centos100 ~]# man 1p cd
```

#### 3. type
显示命令的类型
> type cd | ls | ...

```bash
[root@centos100 ~]# type cd
cd is a shell builtin
[root@centos100 ~]# type ls
ls is aliased to `ls --color=auto'
[root@centos100 ~]# type mkdir
mkdir is /usr/bin/mkdir
 ```

#### 4. 常用快捷键
1. ctrl+c: 停止当前进程
2. ctrl+l: 清屏，相当于clear
3. tab: 输入命令/文件提示
4. 上下键: 用于输入或查找已经输入过的命令

### 文件目录类
#### 1. pwd
> pwd:print working directory,打印的是绝对路径

#### 2. cd
这个命令应该很熟悉
> 1. cd 绝对路径/相对路径
> 2. cd - 进入上一次所在目录
> 3. cd ~ 进入当前用户的家目录（等同于直接输入cd）

这里注意管理员用户和普通用户的家目录不同
```bash
[root@centos100 ~]# pwd
/root
[root@centos100 ~]# su epicr
[epicr@centos100 root]$ cd
[epicr@centos100 ~]$ pwd
/home/epicr
```

#### 3. ls
这个命令也很常用
> 1. ls -l
> 2. ls -a
> 3. ls 绝对目录/相对目录

#### 4. mkdir
一般操作就是直接加上文件名，但是不能递归创建，要递归创建可以加上参数  -p
> mkdir -p a/b/c/d

也可以同时创建多个，直接用空格隔开即可
> mkdir a b c

#### 5. rmdir
这个和mkdir使用类似

但是要注意的是不能删除非空的目录
> mkdir -p g/h/i/j 递归删除，先删除j，如果此时i空，则删除i，以此类推

#### 6. touch 
创建一个新文件

#### 7. cp
基本语法：
> cp [选项] source destination
> 复制文件source到destination
> destination 可以是绝对路径也可以是相对路径
> 如果destination路径下是一个文件，则会进行覆盖

这里进行文件覆盖时会进行提醒，如果不想要提醒可以使用反斜杠
```bash
[root@centos100 ~]# touch hello1 hello2
[root@centos100 ~]# cp hello1 user/
[root@centos100 ~]# cp hello2 user/hello1
cp: overwrite ‘user/hello1’? 
[root@centos100 ~]# touch hello3
[root@centos100 ~]# \cp hello3 user/hello2
```
反斜杠代表使用该命令的原生命令

还有一种常用用法，当source也是一个文件夹时，可以使用参数-r进行递归的复制
```bash
[root@centos100 user]# tree
.
├── newtmp
└── tmpr
    └── world

2 directories, 1 file
[root@centos100 user]# cp tmpr newtmp
cp: omitting directory ‘tmpr’
[root@centos100 user]# cp -r tmpr newtmp
[root@centos100 user]# tree
.
├── newtmp
│   └── tmpr
│       └── world
└── tmpr
    └── world

3 directories, 2 files
```
> 注意用-r复制整个文件夹时，destination不能是文件

#### 8. rm

删除文件或目录，直接加路径
几个常用选项
> 1. rm -f 强制删除
> 2. rm -r 递归删除，可以用于删除文件夹
> 3. rm -rf 混合使用，功能很神奇，可以和/*打出组合技

#### 9. mv
移动文件位置，可以直接移动到某个文件夹下，也可以在路径最后使用另外一个名字，这时起到重命名的作用
```bash
[root@centos100 tmpr]# tree ..
..
└── tmpr
    └── world

1 directory, 1 file
[root@centos100 tmpr]# mv world ../wide
[root@centos100 tmpr]# tree ..
..
├── tmpr
└── wide

1 directory, 1 file
```
> 当在同一文件夹中操作时，相当于只进行重命名

#### 10. cat
查看文件内容
当文件过大时，不适合使用cat命令

#### 11. more/less
以全屏的方式按页显示文本文件
常用操作
> 1. space: 代表向下翻一页
> 2. enter: 代表向下翻一行
> 3. q: 表示离开该显示
> ... 具体可以man命令查看

区别：more 显示完后内容会显示在命令行中，到达文件末尾查看就会结束，不能使用vim jk进行查看
而less会进入一个单独的页面进行查看，只能用q进行退出，且内容不会显示在命令行中
less 的功能比more更强大
> 本人更常用的还是less

#### 12. echo
输出内容到控制台

> ehco -e "hello\nworld" 支持转义

查看系统变量
> echo $[name]

#### 13* 输出重定向> 追加>>
> 重定向是覆盖写，追加是把内容添加到文件末尾

eg:
```bash
[root@centos100 ~]# ll > rootfile.txt
[root@centos100 ~]# cat rootfile.txt
total 8
-rw-------. 1 root root 1894 Mar  5 02:53 anaconda-ks.cfg
drwxr-xr-x. 2 root root    6 Mar  5 06:50 Desktop
...
[root@centos100 ~]# echo hello linux >> rootfile.txt
[root@centos100 ~]# cat rootfile.txt
total 8
-rw-------. 1 root root 1894 Mar  5 02:53 anaconda-ks.cfg
drwxr-xr-x. 2 root root    6 Mar  5 06:50 Desktop
...
drwxr-xr-x. 2 root root    6 Mar  5 02:56 Videos
hello linux
```

#### 14. head/tail
用于查看文件的前10行(默认)
> head filename

可选选项-n用于指定显示头部内容的行数
> head -n 5 filename 显示文件的前5行

tail除了-n外还有一个-f选项，用于实时追踪文件新增的内容
由于进行了监控，因此会创建一个不会自动结束的进程，常用于日志监控

#### 15. ln 软连接


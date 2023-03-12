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

#### 15*. ln 软连接

软连接也称为符号链接，类似于windows里面的快捷方式，有自己的数据块（inode），主要存放了链接其他文件的**路径**

> ln -s [原文件或目录] [软链接名] 给原文件创建一个软连接

！删除软链接应该使用rm -rf 软链接名， 而不能是rm -rf 软链接名/

**加上斜杠后会把链接目录下的文件都删除**

如果不加-s创建出来的就是硬链接
主要区别是硬链接没有自己的数据块，两个文件名为同一个inode，可以理解为只是名字不同

实际使用中主要创建的是软链接

#### 16. history

> history number 显示前number条命令

history还有一种有趣的用法，用!加上命令前的数字能直接执行
```bash
[root@centos100 ~]# history 5
  244  mkdir hello
  245  cd -
  246  clear
  247  ls
  248  history 5
[root@centos100 ~]# !244
mkdir hello
[root@centos100 ~]# ls | grep hello
hello
```
> history -c 清空历史

### 时间日期类

#### 1. date

> date +格式 建议用到时再google

```bash
[root@centos100 ~]# date +%Y-%m-%d-%H:%M:%S
2023-03-08-07:40:31
```
如果格式中要出现空格，则要用双引号将整个格式包含
> date +%s 小s显示当前的时间戳

#### 2. cal

显示当前的日历
> cal 2022 显示2022年所有日期

### 用户管理命令(以下命令只有超级管理员能操作)

#### 1. useradd
> useradd 用户名    添加新用户
> useradd -g 组名 用户名    添加新用户到某个组

创建的普通用户的主目录在/home下
> 可以用-d命令修改主文件夹（默认为用户名）

所有用户可以在/etc/passwd中查看，除了root和其他普通用户，还包含很多的系统用户，也成为伪用户

#### 2. passwd
给用户设置密码
> passwd username

#### 3. su(switch user)

切换用户
root用户可以随意su普通用户，普通用户su需要相应密码

#### 4. whoami/who am i

合在一起是不一样的
whoami显示目前是哪个用户,who am i 显示的是最开始登陆的用户，即使su过也会显示最开始的

#### 4*. sudo

给普通用户root权限
```bash
[root@centos100 ~]# su epicr
[epicr@centos100 root]$ ls
ls: cannot open directory .: Permission denied
[epicr@centos100 root]$ sudo ls

We trust you have received the usual lecture from the local System
Administrator. It usually boils down to these three things:

    #1) Respect the privacy of others.
    #2) Think before you type.
    #3) With great power comes great responsibility.

[sudo] password for epicr: 
epicr is not in the sudoers file.  This incident will be reported.
```
可以看到需要该用户在sudoers文件中才可以执行sudo命令
> 路径为 /etc/sudoers 只有root用户才可以修改sudoers文件

#### 5. userdel

> userdel username

!只是删除了该用户，并不会删除该用户的主文件夹，可以保留该用户的工作
如果想在删除用户的同时删除相应的主目录，可以带上参数-r
> userdel -r username

### 用户组管理命令
每个用户默认都有一个用户组，系统可以对一个用户组中所有的用户进行集中管理
对应目录为/etc/group
#### 1. groupadd/groupdel
新增/删除一个组

#### 2. usermod
修改用户所在组
> usermod -g 组名 用户名 

#### 3. groupmod
修改组名

### 文件权限类
#### 1*. chmod
> 1. chmod [{guoa}{+-=}{rwx}] 文件或目录
> 2. chmod [mode] 文件或目录
> chmod 644 filename

#### 2. chown
改变所有者
> chown user file

#### 3. chgrp
改变所属组

### 搜索查找类

#### 1. find
> find [搜索范围] [选项] 没有搜索范围默认为当前目录

选项说明：
1. -name
2. -user
3. -size

```bash
[root@centos100 ~]# find /root -name "*.cfg"
/root/anaconda-ks.cfg
/root/.config/yelp/yelp.cfg
/root/initial-setup-ks.cfg
/root/.local/share/telepathy/mission-control/accounts.cfg
/root/.local/share/telepathy/mission-control/accounts-goa.cfg
```

#### 2. locate(quick)
locate 指令利用实现建立的系统中所有文件名称及路径的locate数据库实现快速定位给定的文件.Locate指令无需遍历整个文件系统，查询速度较快，为了保证查询结果的准确度，管理员必须定期更新locate时刻
> locate 搜索文件

为了保证查询的准确性，每次运行locate前必须进行Updatedb指令更新数据库
```bash
[root@centos100 ~]# updatedb
[root@centos100 ~]# locate .bashrc
/etc/skel/.bashrc
/home/epicr/.bashrc
/home/xiaohong/.bashrc
/home/xiaohua/.bashrc
/home/xiaolan/.bashrc
/home/xiaoming/.bashrc
/home/yu/.bashrc
/root/.bashrc
```

#### 3. which
#### 4. whereis

#### 5*. grep(linux三剑客)
> grep 选项 查找内容 源文件

```bash
[root@centos100 ~]# grep -n boot initial-setup-ks.cfg 
3:xconfig  --startxonboot
12:# Run the Setup Agent on first boot
13:firstboot --enable
23:network  --bootproto=dhcp --device=ens33 --ipv6=auto --activate
31:# System bootloader configuration
32:bootloader --location=mbr --boot-drive=sda
37:part /boot --fstype="xfs" --ondisk=sda --size=500
```
结合管道命令更加强大
```bash
[root@centos100 ~]# ls | grep .cfg
anaconda-ks.cfg
initial-setup-ks.cfg
```
> wc 统计行数、单词数、字符数

```bash
[root@centos100 ~]# grep -n boot initial-setup-ks.cfg | wc
      7      29     290
```

### 压缩和解压类
#### 1. gzip/gunzip
> 1. gzip file  压缩文件，只能将文件压缩为*.gz文件
> 2. gunzip file.gz 解压缩文件

注意：
    1. 只能压缩文件不能压缩目录
    2. 不保留原来的文件
    3. 同时多个文件会产生多个压缩包

#### 2. zip/unzip
##### 1)基本语法
> zip [选项] XXX.zip 要压缩的文件或目录
> unzip [选项] XXX.zip

#### 2)选项说明
> zip -r    压缩目录
> unzip -d  指定解压后文件的存放目录

```bash
[root@centos100 ~]# zip -r user.zip user
  adding: user/ (stored 0%)
  adding: user/tmpr/ (stored 0%)
  adding: user/tmpr/hello/ (stored 0%)
  adding: user/wide (deflated 82%)
  adding: user/date.txt (deflated 33%)
  adding: user/rootfile.txt (deflated 67%)
[root@centos100 ~]# ls
anaconda-ks.cfg  Downloads             Pictures   tmpr      Videos
Desktop          initial-setup-ks.cfg  Public     user
Documents        Music                 Templates  user.zip

[root@centos100 ~]# unzip -d /tmp user.zip
Archive:  user.zip
   creating: /tmp/user/
   creating: /tmp/user/tmpr/
   creating: /tmp/user/tmpr/hello/
  inflating: /tmp/user/wide          
  inflating: /tmp/user/date.txt      
  inflating: /tmp/user/rootfile.txt
```

#### 3. tar
打包文件，他本身并不做压缩,解决了gzip只能压缩单个文件的缺陷，先把多个文件打包，再进行压缩
> tar [选项] XXX.tar.gz 将要打包进去的内容

选项说明：
    1. -c 产生.tar打包文件
    2. -v 显示详细信息
    3. -f 指定压缩后的文件名
    4. -z 打包的同时压缩
    5. -x 解包.tar文件
    6. -C 解压到指定目录

**常用选项**
    1. 压缩： tar -zcvf filename.tar.gz file1 file2 ...
    2. 解压： tar -zxvf filename.tar.gz -C 'dir'

```bash
[root@centos100 ~]# ls
anaconda-ks.cfg  Documents  initial-setup-ks.cfg  Pictures  Templates  user
Desktop          Downloads  Music                 Public    tmpr       Videos
[root@centos100 ~]# tar -zcvf cf-user.tar.gz *.cfg user
anaconda-ks.cfg
initial-setup-ks.cfg
user/
user/tmpr/
user/tmpr/hello/
user/wide
user/date.txt
user/rootfile.txt
[root@centos100 ~]# ls | grep *.tar.gz
cf-user.tar.gz
```

### 进程管理类
#### 1. ps
常用命令
> 1. ps aux | grep  xxx 查看系统中所有进程
> 2. ps -ef | grep xxx 可以查看子父进程之间的关系

选项说明
> 1. a: 列出带有终端的所有用户的进程
> 2. x: 列出当前用户的所有进程，包括没有终端的进程
> 3. u: 面向用户友好的显示风格
> 4. -e:    列出所有进程
> 5. -u:    列出某个用户关联的所有进程
> 6. -f:    希纳是完整格式的进程列表

1*. **如果想看进程的CUP占用率和内存占用率，使用aux**
2*. **如果想查看进程的父进程ID可以使用-ef**

#### 2. kill
基本语法
> 1. kill [选项] 进程号 通过进程号杀死进程
> 2. killall 进程名称   通过进程名称杀死进程，支持通配符

kill父进程，子进程还能存在
选项
> -9    强迫进程立即停止

关于系统信号值，可以用kill -l进行查看
```bash
[root@centos100 ~]# kill -l
 1) SIGHUP	 2) SIGINT	 3) SIGQUIT	 4) SIGILL	 5) SIGTRAP
 6) SIGABRT	 7) SIGBUS	 8) SIGFPE	 9) SIGKILL	10) SIGUSR1
11) SIGSEGV	12) SIGUSR2	13) SIGPIPE	14) SIGALRM	15) SIGTERM
16) SIGSTKFLT	17) SIGCHLD	18) SIGCONT	19) SIGSTOP	20) SIGTSTP
21) SIGTTIN	22) SIGTTOU	23) SIGURG	24) SIGXCPU	25) SIGXFSZ
26) SIGVTALRM	27) SIGPROF	28) SIGWINCH	29) SIGIO	30) SIGPWR
31) SIGSYS	34) SIGRTMIN	35) SIGRTMIN+1	36) SIGRTMIN+2	37) SIGRTMIN+3
38) SIGRTMIN+4	39) SIGRTMIN+5	40) SIGRTMIN+6	41) SIGRTMIN+7	42) SIGRTMIN+8
43) SIGRTMIN+9	44) SIGRTMIN+10	45) SIGRTMIN+11	46) SIGRTMIN+12	47) SIGRTMIN+13
48) SIGRTMIN+14	49) SIGRTMIN+15	50) SIGRTMAX-14	51) SIGRTMAX-13	52) SIGRTMAX-12
53) SIGRTMAX-11	54) SIGRTMAX-10	55) SIGRTMAX-9	56) SIGRTMAX-8	57) SIGRTMAX-7
58) SIGRTMAX-6	59) SIGRTMAX-5	60) SIGRTMAX-4	61) SIGRTMAX-3	62) SIGRTMAX-2
63) SIGRTMAX-1	64) SIGRTMAX	
```

#### 3. pstree
查看当前的进程树
选项：
    1. -p 显示进程的PID
    2. -u 显示进程的所属用户

#### 4**. top
实时监控系统进程状态
基本命令：
> top [选项]

选项说明：
> 1. -d 秒数    指定top每隔几秒更新，默认3秒
> 2. -i         使top不显示任何闲置或僵尸进程
> 3. -p         通过指定监控进程ID来仅仅监控某个进程的状态

操作说明：
> 1. P 按照CPU使用率进行排序
> 2. M 以内存使用率排序
> 3. N 以PID排序
> 4. u 指定查看某个用户的进程
> 5. k 用于杀死某个进程
> 6. q 退出

#### 5. netstat
显示网络状态和端口占用信息
> netstat -anp | grep 进程号    查看该进程网络信息
> netstat -nlp | grep 端口号    查看网络端口号占用情况

选项说明：
> 1. -a 显示所有正在监听和未监听的套接字(socket)
> 2. -n 拒绝显示别名，能显示数字的全部转化成数字
> 3. -l 仅列出在监听的服务状态
> 4. -p 表示显示哪个进程在调用

#### 6. crontab
系统定时任务
crond是crontab的守护进程
> systemctl restart crond

基本语法：
> crontab [选项]
> 1. -e 编辑rontab定时任务
> 2. -l 查询crontab任务
> 3. -r 删除当前用户**所有**的crontab任务

> ***** 执行的任务

| 项目|含义|范围|
|:----|:----|:----|
|第一个“*”|一个小时当中的第几分钟|0-59|
|第二个“*”|一天当中的第几小时|0-23|
|第三个“*”|一个月中的第几天|1-31|
|第四个“*”|一年当中的第几月|1-12|
|第五个“*”|一周当中星期几|0-7（0，7都代表星期日）|
特殊符号
|符号|含义|
|:----|:----|
|*|代表任何时间|
|,|代表不连续的时间"0 8,12,16 * * * cmd"代表每天的8:00,12:00,16:00都执行一次命令|
|-|代表连续的时间范围|
|*/n|代表每隔多久执行一次|
*具体用法可以google

### 软件包管理(centOS7)
#### RPM(RedHat Package Manager)
debian:apt
arch:pacman
RPM包的名称格式
> Apache-1.3.23-11.i386.rpm
> - "apache"软件名称
> - ”1.3.23-11“软件的版本号，主版本和此版本
> - "i386"软件所运行的硬件平台
> - "rpm"文件扩展名

##### 1. 查询
> rpm -qa   查询所安装的所有rpm软件包
> 由于软件包比较多，一般用grep命令筛选
```bash
[root@centos100 ~]# rpm -qa | grep firefox
firefox-102.8.0-2.el7.centos.x86_64
```
> rpm -qi 软件包名  
> 查询某个软件的详细信息

#### 2. 删除
> rpm -e 软件名称

#### 3. 安装
> rpm -i 软件包名

一些选项说明：
1. -i install
2. -v --verbose显示详细信息
3. -h --hash进度条

> rpm -ivh rpm包**全名**

#### YUM(Yellow dog Updater,Modified)
红帽系包管理工具，可以自动主力依赖关系，并且一次安装所有依赖的软件包
> yum [选项] [参数]
> -y 对所有提问都回答'yes'
> install   安装
> update    更新
> check-update  检查是否有可用的更新
> remove    删除
> list      显示安装的所有软件包信息
> clean     清楚yum过期的缓存
> deplist   显示yum软件包的所有依赖关系

更改yum源
1. 安装wget
> yum install wget

2. 在/etc/yum.repos.d/目录下，备份默认的repos文件
> cp CentOS-Base.repo CentOS-Base

3. 下载网易163或者是aliyun的repos文件
> wget http://mirrors.aliyun.com/repo/Centos-7.repo

4. 使用下载好的repos文件替换默认的repos文件
> mv Centos-7.repo VentOS-Base.repo

5. 清理旧缓存文件，缓存新数据
> yum clean all
> yum makecache








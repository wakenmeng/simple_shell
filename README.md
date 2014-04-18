Simple Shell
===============================
unix shell and file system
简单的模拟unixshell和文件系统，使用javascript和PHP
### 文件类型定义

type file:1 direcotry: 0

### 文件存储结构

id  name    lvl    type    pid
0	/		0		0		-1
1   root    1       0       0

### 指令

cd: 绝对路径
	子文件夹
	cd .. 回到上级目录
	cd /  回到文件根目录
	判错
ls: 显示当前目录内文件
mkdir：创建文件夹
		同名文件夹判错
		
### 更新
使用上下键可以调用历史指令
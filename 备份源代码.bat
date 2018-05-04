::自动备份文件夹 backups
::by luomg, 21:15 2010-10-13
::minguiluo@163.com
@echo off

echo 根据当前日期时间，生成文件名称，......
set "filename=%date:~0,4%%date:~5,2%%date:~8,2%%h%%time:~3,2%%time:~6,2%"
echo %filename%

rd /s /Q F:\Github2018\TickyPHP\runtime
md F:\Github2018\TickyPHP\runtime

set "source=F:\Github2018\TickyPHP"
set "target=F:\Github2018\backups\TickyPHP-Src-%filename%"
md %target%
@echo 将%source%自动备份到
@echo %target%

xcopy /e /y %source% %target%

@echo 数据备份完成，3秒后程序退出。
ping /n 3 127.0.0.1 >nul
::exit
@pause





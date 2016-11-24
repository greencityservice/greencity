# greencity
Calendar System

－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－

iPhone Chrome 无法导入Calendar的问题应该是无解的，可能因为Chrome没有权限。

bug行：
export_handler.php 201行   
```php 
header ( 'Content-Type: ' . $mime );
```
无法将Content-Type设置为text/calendar

网上帖子：

http://stackoverflow.com/questions/15972628/ics-file-download-fails-on-iphone-chrome-with-unknown-file-type

http://stackoverflow.com/questions/17681951/icalendar-transferred-with-text-calendar-mime-type

http://primarypcsolutions.com/showthread.php?id=150637

应该是无解的。

哪里导出是乱码来着？，忘记了，Android Chrome？
可以试试：
```php 
header ( 'Content-Type: text/calendar; charset=utf-8' . $mime );
```
桌面和iPhone的导出是正常的，所以应该不关数据库的事。
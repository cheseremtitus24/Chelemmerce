Oracle PHP integration
https://adevait.com/laravel/how-to-use-laravel-with-oracle-database
https://www.oracle.com/database/technologies/instant-client/linux-x86-64-downloads.html
https://ubuntuforums.org/archive/index.php/t-92528.html

# Getting Started
1. Download and Install the OCI8 Extension
You cannot use oci8_19 unless the correct Oracle Instant Client is installed.

Go to: https://www.oracle.com/database/technologies/instant-client/winx64-64-downloads.html

Download version 19.27.0.0.0:

```
Basic Package

SDK Package
```

Extract both into a folder like C:\oracle\instantclient_19_27

2. Add to System Environment Variables
```Add the path to your system environment:
Name: PATH
Value: C:\oracle\instantclient_19_27
```
Also, set:
```
TNS_ADMIN=C:\oracle\instantclient_19_11
```
3. Install php_oci8_19.dll
Copy php_oci8_19.dll (matching your PHP version) into C:\xampp\php\ext\

If you don't have this DLL, download it from the PECL repository, matching your PHP version and architecture (x64).

4. Enable the Extension in php.ini
Open C:\xampp\php\php.ini and ensure:

```ini

extension=oci8_19  ; Use with Oracle 19c client
```
5. Restart Apache
Restart Apache from XAMPP to apply changes.

6. Verify Extension Installation
Run:

```bash
php -m | findstr oci8
```


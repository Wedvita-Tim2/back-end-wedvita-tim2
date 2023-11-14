A. Migration:
------------
Step 1 : php artisan migrate

B. Seeding:
------------
Step 1 : php artisan db:seed

D. Migration Ulang (jika diperlukan):
---------------------
Step 1 : php artisan migrate:refresh
*jika error, hapus manual semua tabel di dbeaver/pgadmin dan lakukan ulang step A.

C. Connect Storage ke Public
----------------------------
Step 1 : php artisan storage:link

E. Konfigurasi php.ini (lokasi: C:/tools/php82/php.ini)
--------------------------------------------------------
hapus tanda (;) di:
1. extension=fileinfo
2. extension=gd
3. extension=pgsql
4. extension=pdo_pgsql
5. extension=zip

F. Konfigurasi SSL perm (lokasi: C:/tools/php82/php.ini)

1. Download cacert.pem file ('https://curl.se/docs/caextract.html')
2. Pindahkan file cacert.pem ke 'C:\tools\php\extras\ssl\'
3. Php.ini atur hapus(;)
    a. curl.cainfo = "C:\tools\php\extras\ssl\cacert.pem"
    b. openssl.cafile= "C:\tools\php\extras\ssl\cacert.pem"
!!Lakukan Semua!!



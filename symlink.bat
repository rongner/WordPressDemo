@echo off
set WP=C:\Users\micha\Local Sites\wordpress-demo\app\public\wp-content
set SRC=C:\Source\WordPressDemo

mklink /D "%WP%\plugins\info-card-block" "%SRC%\plugins\info-card-block"
mklink /D "%WP%\themes\wp-restaurant" "%SRC%\themes\wp-restaurant"
mklink /D "%WP%\themes\wp-droffice" "%SRC%\themes\wp-droffice"

echo Done.
pause

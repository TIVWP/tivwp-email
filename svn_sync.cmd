@echo off
rem in case DelayedExpansion is on and a path contains !
SetLocal DisableDelayedExpansion

Set me=tivwp-email
Set plugin_dir=%~dp0
Set my_dir=%plugin_dir%wpsvn
echo %my_dir%

cd %my_dir%

rsync -avcW --delete --exclude-from=../svn_exclude.txt .. ./%me%/trunk
rsync -avcW --delete  ../assets ./%me%/

cd %me%
svn status

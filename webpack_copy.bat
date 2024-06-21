@echo off

copy resources/js/app.js public/js/.
copy resources/js/* public/js/.
copy resources/images/* public/images/.
copy resources/css/app.css public/css/.
copy resources/css/styles.css public/css/.

@REM composer config -g -- disable-tls true

@REM composer config --global disable-tls true
@REM composer config --global secure-http false

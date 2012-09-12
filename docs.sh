#phpdoc -d . -t docs -i libraries/Imagine/  --title "thumburl"
apigen --source . --destination docs --exclude "*libraries/Imagine/*" --exclude "*docs*" --template-config /usr/share/php/data/ApiGen/templates/bootstrap/config.neon --title thumburl

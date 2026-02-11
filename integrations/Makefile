# General configuration
# --------------------
# constants
NPM_GLOBAL = $(shell if [ -d "node_modules" ]; then echo "false"; else echo "true"; fi)
ifeq ($(NPM_GLOBAL), true)
	NPM_PREFIX = ''
else
	NPM_PREFIX = 'node_modules/.bin/'
endif

# browser-sync
host = "http://localhost"
port = 3000
sync = true

# install
global = false
docs = false



# Dev tools
# --------------------
.PHONY: compile watch install

compile: ../public/styles/main.css\
	../public/styles/debug.css\
	../public/scripts/main.js\
	../public/scripts/locales.js
	@ cp -r ../public/** ../public

# Watch
# NOTE On OSX, overwrite watch native command:
# brew install watch
# brew info watch # read watch path
# sudo mv <path_to_watch>/bin/watch /usr/local/bin
watch:
ifeq ($(sync), true)
	@ $(NPM_PREFIX)browser-sync start -p $(host) --port $(port) --files "index.html" "public" --no-open &> /dev/null | \
	watch -t -n 1 "make compile && echo '-- Browser-sync listening on $(host):$(port)'"
else
	@ watch -t -n 1 make compile
endif

# Concat & minify styles & scripts
../public/styles/main.css: assets/styles/*.scss assets/styles/**/*.scss
	@ $(NPM_PREFIX)node-sass --output-style=compressed assets/styles/main.scss -o ../public/styles/ --source-map ../public/styles/
	@ echo "› $@ has been updated"

../public/styles/debug.css: assets/styles/*.scss assets/styles/**/*.scss
	@ $(NPM_PREFIX)node-sass --output-style=compressed assets/styles/debug.scss -o ../public/styles/ --source-map ../public/styles/
	@ echo "› $@ has been updated"

../public/scripts/main.js: assets/scripts/*.js
	@ $(NPM_PREFIX)uglifyjs assets/scripts/*.js -o ../public/scripts/main.js --source-map ../public/scripts/main.js.map -p relative
	@ echo "› $@ has been updated"

../public/scripts/locales.js: assets/scripts/locales/*.js
	@ $(NPM_PREFIX)uglifyjs assets/scripts/locales/*.js -o ../public/scripts/locales.js --source-map ../public/scripts/locales.js.map -p relative
	@ echo "› $@ has been updated"

# Install dependencies
install:
ifeq ($(global), true)
	@ echo "› Global mode: make sure NPM dependencies are installed globally (check package.json)."
else
	@ echo "› Checking NPM dependencies:"
	@ npm install
endif
	@ echo "› Done. Installing frond-end dependencies:"
	@ bower install --allow-root
	@ echo "› Done. Creating folders:"
	@ for dir in "../public/styles" "../public/scripts";do mkdir -p $$dir && echo "$$dir created.";done
	@ echo "› Installation done, start with \"make watch\"."



# Build commands
# --------------------
.PHONY: build styles scripts vendor plugins fonts images

build:
	@ make styles
	@ make scripts
	@ make fonts
	@ make images
	@ make plugins

styles:
	@ echo "› Building styles:"
	@ rm -rf ../public/styles && mkdir -p ../public/styles
	@ make ../public/styles/main.css
	@ make ../public/styles/debug.css
	@ cp bower_components/flatpickr/../public/flatpickr.min.css ../public/styles/flatpickr.css
	@ cp -r ../public/styles ../public
	@ echo "› Done."

scripts:
	@ echo "› Building scripts:"
	@ rm -rf ../public/scripts && mkdir -p ../public/scripts
	@ cp bower_components/flatpickr/../public/l10n/fr.js assets/scripts/locales/flatpickr.fr.js
	@ make ../public/scripts/main.js
	@ make ../public/scripts/locales.js
	cp -r assets/scripts/lib ../public/scripts
	@ make vendor
	@ cp -r ../public/scripts ../public
	@ echo "› Done."

plugins:
	@ echo "› Moving plugins:"
	@ rm -rf ../public/plugins
	cp -r assets/plugins dist
	@ cp -r ../public/plugins ../public
	@ echo "› Done."

vendor:
	@ echo "› Building Bower vendor scripts:"
	@ $(eval files=$(shell $(NPM_PREFIX)bower-files js))
	@ [ -z "$(files)" ] || $(NPM_PREFIX)uglifyjs $(files) -o ../public/scripts/vendor.js --source-map ../public/scripts/vendor.js.map -p relative
	@ [ -z "$(files)" ] && echo "› no vendor scripts" || echo "› ../public/scripts/vendor.js has been updated"

fonts:
	@ echo "› Moving fonts:"
	cp -r bower_components/material-iconfont/iconfont/* assets/fonts/
	@ rm -rf ../public/fonts
	cp -r assets/fonts dist
	@ cp -r ../public/fonts ../public
	@ echo "› Done."

images:
	@ echo "› Optimizing images:"
	@ rm -rf ../public/images
	@ for dir in $$(find assets/images -type d);do mkdir -p ../public/$${dir#*/} && echo ../public/$${dir#*/} && $(NPM_PREFIX)imagemin $${dir}/* -o ../public/$${dir#*/};done
	@ cp -r ../public/images ../public
	@ echo "› Done."

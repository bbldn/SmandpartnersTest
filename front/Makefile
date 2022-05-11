dist_js_path=dist/js
dist_css_path=dist/css
public_js_path=../public/js
public_css_path=../public/css

all: build

build:
	npm run build

install:
	mkdir -p $(public_js_path)
	mkdir -p $(public_css_path)
	cp $(dist_js_path)/app.js $(public_js_path)/index.js
	cp $(dist_js_path)/app.js.map $(public_js_path)/index.js.map
	cp $(dist_js_path)/chunk-vendors.js $(public_js_path)/vendors.js
	cp $(dist_js_path)/chunk-vendors.js.map $(public_js_path)/vendors.js.map
	cp $(dist_css_path)/app.css $(public_css_path)/index.css
	cp $(dist_css_path)/chunk-vendors.css  $(public_css_path)/vendors.css
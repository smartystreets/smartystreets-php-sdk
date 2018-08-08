#!/usr/bin/make -f

SOURCE_VERSION := 4.5
VERSION_FILE = src/Version.php

local-test:
	phpunit tests

publish: version tag 
	git add $(VERSION_FILE)
	# git commit -m "Incremented version number to $(shell git describe)"
	git push origin master --tags

version:
	$(eval PREFIX := $(SOURCE_VERSION).)
	$(eval CURRENT := $(shell git describe 2>/dev/null))
	$(eval EXPECTED := $(PREFIX)$(shell git tag -l "$(PREFIX)*" | wc -l | xargs expr -1 +))
	$(eval INCREMENTED := $(PREFIX)$(shell git tag -l "$(PREFIX)*" | wc -l | xargs expr 0 +))
	@if [ "$(CURRENT)" != "$(EXPECTED)" ]; then git commit -m "Incremented version number to $(shell git describe)" && git tag -a "$(INCREMENTED)" -m "" 2>/dev/null || true; fi

############################################################

test:
	docker-compose run sdk make local-test	

tag:
	docker-compose run sdk sed -i "s/[0-9]*\.[0-9]*\.[0-9]*/$(shell git describe)/" "$(VERSION_FILE)"	

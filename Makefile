#!/usr/bin/make -f

SOURCE_VERSION := 4.5
VERSION_FILE = src/Version.php

local-test:
	phpunit tests

publish:
	$(eval VERSION := $(shell $(MAKE) calculate-version))	
	@echo "<?php namespace SmartyStreets\PhpSdk;const VERSION = '$(VERSION)';" > $(VERSION_FILE)
	git add $(VERSION_FILE)
	git commit -m "Incremented version number to $(VERSION)"
	git tag -a "$(VERSION)" -m ""
	git push origin master --tags

calculate-version:
	$(eval PREFIX := $(SOURCE_VERSION).)
	$(eval CURRENT := $(shell git describe 2>/dev/null))
	$(eval EXPECTED := $(PREFIX)$(shell git tag -l "$(PREFIX)*" | wc -l | xargs expr -1 +))
	$(eval INCREMENTED := $(PREFIX)$(shell git tag -l "$(PREFIX)*" | wc -l | xargs expr 0 +))
	@if [ "$(CURRENT)" != "$(EXPECTED)" ]; then echo $(INCREMENTED) ; else echo $(CURRENT); fi


############################################################

test:
	docker-compose run sdk make local-test	


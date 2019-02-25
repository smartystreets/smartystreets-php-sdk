#!/usr/bin/make -f

VERSION_FILE := src/Version.php
VERSION      := $(shell tagit -p --dryrun)

test:
	phpunit tests

package: test
	@echo "<?php namespace SmartyStreets\PhpSdk;const VERSION = '$(VERSION)';" > $(VERSION_FILE)

############################################################

workspace:
	docker-compose run sdk /bin/sh

release:
	docker-compose run sdk make package \
		&& git commit -am "Incremented version." \
		&& tagit -p \
		&& git push origin master --tags

.PHONY: test package workspace release

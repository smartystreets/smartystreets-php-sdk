#!/usr/bin/make -f

VERSION_FILE := src/Version.php
VERSION      := $(shell tagit -p --dryrun)

test:
	phpunit tests

publish: test
	@echo "<?php namespace SmartyStreets\PhpSdk;const VERSION = '$(VERSION)';" > $(VERSION_FILE)

############################################################

workspace:
	docker-compose run sdk /bin/sh

release:
	docker-compose run sdk make publish \
		&& git commit -am "Incremented version to $(VERSION)" \
		&& tagit -p

.PHONY: test publish workspace release

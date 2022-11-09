#!/usr/bin/make -f

VERSION_FILE := src/Version.php

test:
	phpunit tests

package:
	@echo "<?php namespace SmartyStreets\PhpSdk;const VERSION = '${VERSION}';" > $(VERSION_FILE)

############################################################

workspace:
	docker-compose run sdk /bin/sh

release:
	docker-compose run sdk echo "<?php namespace SmartyStreets\PhpSdk;const VERSION = '${VERSION}';" > $(VERSION_FILE)
#		&& git commit -am "Incremented version." \
#		&& tagit -p \
#		&& git push origin master --tags

.PHONY: test package workspace release

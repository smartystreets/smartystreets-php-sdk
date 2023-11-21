#!/usr/bin/make -f

test:
	phpunit tests --display-warnings

package: test
	#@echo -n ""

release: package
	#@echo -n ""

.PHONY: test package release

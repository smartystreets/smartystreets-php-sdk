#!/usr/bin/make -f

test:
	phpunit tests

package: test
	#@echo -n ""

release: package
	#@echo -n ""

.PHONY: test package release

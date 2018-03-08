#!/usr/bin/make -f

test:
	phpunit tests

push:
	git push origin master

publish-patch: push
	@python tag.py patch

publish-minor: push
	@python tag.py minor

publish-major: push
	@python tag.py major
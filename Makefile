#!/usr/bin/make -f

INCREMENT='patch' # or 'minor' or 'major'

test:
	phpunit .

publish:
	@python tag.py $(INCREMENT)
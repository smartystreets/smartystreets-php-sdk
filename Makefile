#!/usr/bin/make -f

test:
	phpunit tests

package: test
	#@echo -n ""

release: package
	#@echo -n ""

international_autocomplete_api:
	php examples/InternationalAutocompleteExample.php

international_street_api:
	php examples/InternationalExample.php

us_autocomplete_pro_api:
	php examples/USAutocompleteProExample.php

us_enrichment_api:
	php examples/USEnrichmentExample.php

us_extract_api:
	php examples/USExtractExample.php

us_reverse_geo_api:
	php examples/USReverseGeoExample.php

us_street_api:
	php examples/UsStreetSingleAddressExample.php && php examples/UsStreetMultipleAddressesExample.php

us_zipcode_api:
	php examples/UsZIPCodeSingleLookupExample.php && php examples/UsZIPCodeMultipleLookupsExample.php

examples: international_autocomplete_api international_street_api us_autocomplete_pro_api us_enrichment_api us_extract_api us_reverse_geo_api us_street_api us_zipcode_api

.PHONY: test package release examples international_autocomplete_api international_street_api us_autocomplete_pro_api us_enrichment_api us_extract_api us_reverse_geo_api us_street_api us_zipcode_api

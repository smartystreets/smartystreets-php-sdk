<?php

namespace SmartyStreets;

interface Serializer {
    function serialize($obj);
    function deserialize($payload);
}
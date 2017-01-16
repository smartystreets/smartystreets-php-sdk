<?php

namespace smartystreets\api;

interface Serializer {
    function serialize($obj, $classType);
    function deserialize($payload, $classType);

}
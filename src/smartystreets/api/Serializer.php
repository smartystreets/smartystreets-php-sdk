<?php

namespace smartystreets\api;

interface Serializer {
    function serialize($obj);
    function deserialize($payload);
}
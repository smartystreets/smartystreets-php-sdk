<?php

namespace smartystreets\api;

interface Sender {
    function send(Request $request);
}
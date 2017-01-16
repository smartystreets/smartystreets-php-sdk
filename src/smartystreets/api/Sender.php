<?php

namespace smartystreets\api;

interface Sender {
    function sign(Request $request);
}
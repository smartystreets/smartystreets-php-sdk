<?php

namespace smartystreets\api;

interface Credentials {
    public function sign(Request $request);
}
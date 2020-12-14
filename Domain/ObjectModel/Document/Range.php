<?php

class Range {

    private int $rangeStart;
    private int $rangeEnd;

    public function __construct (int $rangeStart = 1, int $rangeEnd = 0) {
        $this->rangeStart = $rangeStart;
        $this->rangeEnd = $rangeEnd;
    }

    public function getRangeStart() : int {
        return $this->rangeStart;
    }

    public function getRangeEnd() : int {
        return $this->rangeEnd;
    }    
}

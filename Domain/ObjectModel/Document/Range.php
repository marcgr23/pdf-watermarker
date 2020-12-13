<?php

class Range {

    private int $rangeStart;
    private int $rangeEnd;

    public function __construct (int $rangeStart = 1, int $rangeEnd = null) {
        $this->x = $rangeStart;
        $this->y = $rangeEnd;
    }

    public function getRangeStart() : int {
        return $this->rangeStart;
    }

    public function getRangeEnd() : int {
        return $this->rangeEnd;
    }    
}

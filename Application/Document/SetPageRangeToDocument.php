<?php

include_once( dirname(__FILE__) . '/../../Domain/ObjectModel/Document/Document.php');
include_once( dirname(__FILE__) . '/../../Domain/ObjectModel/Document/Range.php');
include_once( dirname(__FILE__) . '/../../Domain/Document/SetRangeToDocumentPages.php');

class SetPageRangeToDocument {
    private SetRangeToDocumentPages $setRangeToDocumentPages;

    public function __construct(SetRangeToDocumentPages $setRangeToDocumentPages) {
        $this->setRangeToDocumentPages = $setRangeToDocumentPages;
    }

    public function execute(Range $range, Document &$document) : void {
        $this->setRangeToDocumentPages->execute($range, $document);
    }
}
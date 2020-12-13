<?php

include_once( dirname(__FILE__) . '/../ObjectModel/Document/Document.php');
include_once( dirname(__FILE__) . '/GetTotalPagesFromDocumentInterface.php');
include_once( dirname(__FILE__) . '/ImportPageInterface.php');
include_once( dirname(__FILE__) . '/AddWatermarkInterface.php');

class ApplyWatermarkToDocumentForEachPage {
    private AddWatermarkInterface $addWatermark;
    private AddWatermarkInterface $addWatermarkInvisible;
    private GetTotalPagesFromDocumentInterface $getTotalPagesFromDocument;
    private ImportPageInterface $importPage;

    public function __construct(AddWatermarkInterface $addWatermark,
                                AddWatermarkInterface $addWatermarkInvisible,
                                GetTotalPagesFromDocumentInterface $getTotalPagesFromDocument,
                                ImportPageInterface $importPage) {

        $this->addWatermark = $addWatermark;
        $this->addWatermarkInvisible = $addWatermarkInvisible;
        $this->getTotalPagesFromDocument = $getTotalPagesFromDocument;
        $this->importPage = $importPage;
    }


    public function execute(Document &$document) : void {
        $totalPages = $this->getTotalPagesFromDocument->execute($document);
		for($ctr = 1; $ctr <= $totalPages; $ctr++) {
			$currentPage = $document->pages[$ctr-1];
			$this->importPage->execute($currentPage, $document);
			
			if ( $currentPage->isWatermarkVisible() ) {
				 $this->addWatermark->execute($document, $currentPage);
			}
			else {
				$this->addWatermarkInvisible->execute($document, $currentPage);
			}
		}
    }
}
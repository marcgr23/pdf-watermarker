<?php

include_once( dirname(__FILE__) . '/../../../Domain/Document.php');
include_once( dirname(__FILE__) . '/../../../Domain/Interfaces/GetTotalPagesFromDocumentInterface.php');
include_once( dirname(__FILE__) . '/../../../Domain/Interfaces/ImportPageInterface.php');
include_once( dirname(__FILE__) . '/../../../Domain/Interfaces/AddWatermarkServiceInterface.php');

class ApplyWatermarkToDocumentService {
    private AddWatermarkServiceInterface $addWatermarkService;
    private AddWatermarkServiceInterface $addWatermarkInvisibleService;
    private GetTotalPagesFromDocumentInterface $getTotalPagesFromDocumentService;
    private ImportPageInterface $importPageService;

    public function __construct(AddWatermarkServiceInterface $addWatermarkService,
                                AddWatermarkServiceInterface $addWatermarkInvisibleService,
                                GetTotalPagesFromDocumentInterface $getTotalPagesFromDocumentService,
                                ImportPageInterface $importPageService) {

        $this->addWatermarkService = $addWatermarkService;
        $this->addWatermarkInvisibleService = $addWatermarkInvisibleService;
        $this->getTotalPagesFromDocumentService = $getTotalPagesFromDocumentService;
        $this->importPageService = $importPageService;
    }
    
    public function execute(Document &$document) : void {
        $totalPages = $this->getTotalPagesFromDocumentService->execute($document);
		for($ctr = 1; $ctr <= $totalPages; $ctr++) {
			$currentPage = $document->pages[$ctr-1];
			$this->importPageService->execute($currentPage, $document);
			
			if ( $currentPage->isWatermarkVisible() ) {
				 $this->addWatermarkService->execute($document, $ctr);
			}
			else {
				$this->addWatermarkInvisibleService->execute($document, $ctr);
			}
		}
    }
}
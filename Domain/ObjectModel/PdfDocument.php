<?php

class PdfDocument implements DocumentHandlerInterface {

    private const OUTPUT_FILE_VALUE   = "F";
    private const WIDTH_COLUMN_NAME   = 'w';
    private const HEIGHT_COLUMN_NAME  = 'h';
    private const ORIENTATION_LANDSCAPE  = "L";
    private const ORIENTATION_PORTRAIT  = "P";
    
    private FPDI $pdfInstace;
    private PdfAddWatermarkServiceInterface $addWatermarkService;
    private PdfAddWatermarkServiceInterface $addWatermarkInvisibleService;
    private DocumentPathHandler $pathHandler;

    private $specificPages;

    public function __construct(DocumentPathHandler $pathHandler, 
                                FPDI $pdfInstance,
                                PdfAddWatermarkServiceInterface $addWatermarkService,
                                PdfAddWatermarkServiceInterface $addWatermarkInvisibleService) {

        $this->pdfInstace = $pdfInstance;
        $this->addWatermarkService = $addWatermarkService;
        $this->addWatermarkInvisibleService = $addWatermarkInvisibleService; 
        $this->pathHandler = $pathHandler;

        $this->specificPages = array();
    }

    private function importPage(int $page_number) : void {
		
		$templateId = $this->pdfInstance->importPage($page_number);
		$templateDimension = $this->pdfInstance->getTemplateSize($templateId);
        $orientation = '';

		if ( $templateDimension[self::WIDTH_COLUMN_NAME] > $templateDimension[self::HEIGHT_COLUMN_NAME] ) {
			$orientation = self::ORIENTATION_LANDSCAPE;
		}
		else {
			$orientation = self::ORIENTATION_PORTRAIT;
		}
		
        $this->pdfInstance->addPage($orientation, 
                                    array($templateDimension[self::WIDTH_COLUMN_NAME],
                                          $templateDimension[self::HEIGHT_COLUMN_NAME])
        );
	}

    private function getTotalPages() : int {
		return $this->pdfInstace->setSourceFile($this->pathHandler->getOriginPath());
    }

    public function applyWatermarksToDocument() : void {
        $totalPages = $this->getTotalPages();
		
		for($ctr = 1; $ctr <= $totalPages; $ctr++) {
			
			$this->importPage($ctr);
			
			if ( $this->specificPages[$ctr]->isWatermarkVisible() ) {
				 $this->addWatermarkService->execute($ctr);
			}
			else {
				$this->addWatermarkInvisibleService->execute($ctr);
			}
		}
    }

    public function setPageRangesToDocument(int $startPage=1, int $endPage=null) : void {
        $end = $endPage !== null ? $endPage : $this->getTotalPages();
		
		$this->specificPages = array();

		for ($ctr = $startPage; $ctr <= $this->pdfInstace->getTotalPages(); $ctr++ ) {
            $this->specificPages[] = new DocumentPage($ctr, $ctr <= $end);
		}
    }

    public function saveChangesToDocument() : void {
        
        $this->pdfInstace->Output(self::OUTPUT_FILE_VALUE, $this->pathHandler->getDestinyPath());
    }
}
<?php

include '../../Services/AddWatermarkService.php';
include '../../Services/AddWatermarkInvisibleService.php';

class PdfDocument implements DocumentHandlerInterface, DocumentFactory {

    private const OUTPUT_FILE_VALUE   = "F";
    private const WIDTH_COLUMN_NAME   = 'w';
    private const HEIGHT_COLUMN_NAME  = 'h';
    private const ORIENTATION_LANDSCAPE  = "L";
    private const ORIENTATION_PORTRAIT  = "P";
    
    private PDFI $pdfInstace;
    private AddWatermarkService $addWatermarkService;
    private AddWatermarkInvisibleService $addWatermarkInvisibleService;
    private DocumentPathHandler $pathHandler;

    private $specificPages;

    public function __construct(DocumentPathHandler $pathHandler, 
                                PDFI $pdfInstance,
                                AddWatermarkPDFService $addWatermarkService,
                                AddWatermarkInvisibleService $addWatermarkInvisibleService) {

        $this->pdfInstace = $pdfInstace;
        $this->addWatermarkService = $addWatermarkService;
        $this->addWatermarkInvisibleService = $addWatermarkInvisibleService; 
        $this->pathHandler = $pathHandler;

        $this->specificPages = array();
    }

    public function importPage(int $page_number) : void {
		
		$templateId = $this->pdfInstance->importPage($page_number);
		$templateDimension = $this->pdfInstance->getTemplateSize($templateId);
        $orientation; //████ ◄ WARNING - AÑADIR O QUITAR ███

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

    public function getTotalPages() : int {
		return $this->pdfInstace->setSourceFile($this->pathHandler->getOriginPath());
    }

    public function applyWatermarksToDocument() : void {
        $totalPages = $this->pdfInstace->getTotalPages();
		
		for($ctr = 1; $ctr <= $totalPages; $ctr++) {
			
			$this->pdfInstace->importPage($ctr);
			
			if ( $this->specificPages[ctr]->isWatermarkVisible() ) {
				 $this->addWatermarkService->execute($ctr);
			}
			else {
				$this->addWatermarkInvisibleService->execute($ctr);
			}
		}
    }

    public function setPageRangesToDocument(int $startPage=1, int $endPage=null) : void {
        $end = $endPage !== null ? $endPage : $this->pdfInstace->getTotalPages();
		
		$this->specificPages = array();
        
        //AÑADIR STARTPAGE

		for ($ctr = $startPage; $ctr <= $this->pdfInstace->getTotalPages(); $ctr++ ) {
            $this->specificPages[] = new DocumentPage(ctr, ctr <= end);
		}
    }

    public function saveChangesToDocument() : void {
        
        $this->pdfInstace->Output(self::OUTPUT_FILE_VALUE, $this->pathHandler->getDestinyPath());
    }
}
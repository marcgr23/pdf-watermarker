<?php

class ImportPageToPDFService implements ImportPageInterface {
    private const WIDTH_COLUMN_NAME   = 'width';
    private const HEIGHT_COLUMN_NAME  = 'height';
    private const ORIENTATION_LANDSCAPE  = "L";
    private const ORIENTATION_PORTRAIT  = "P";

    public function execute(DocumentPage $page, Document &$document) : void {
        $templateId = $document->pdfInstance->importPage($page->getPageNumber());
		$templateDimension = $document->pdfInstance->getTemplateSize($templateId);
        
		if ( $templateDimension[self::WIDTH_COLUMN_NAME] > $templateDimension[self::HEIGHT_COLUMN_NAME] ) {
			$orientation = self::ORIENTATION_LANDSCAPE;
		}
		else {
			$orientation = self::ORIENTATION_PORTRAIT;
		}
		
        $document->pdfInstance->addPage($orientation, 
                                    array($templateDimension[self::WIDTH_COLUMN_NAME],
                                          $templateDimension[self::HEIGHT_COLUMN_NAME])
        );
    }
}
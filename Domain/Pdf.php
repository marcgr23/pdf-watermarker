<?php



class Pdf {

    private $pdfInstance;
    private $originalPdfPath;

    public function __construct ($originalPdfPath, 
                                 $newPdfPath) {
        $this->pdfInstace = new FPDI();
        $this->originalPdfPath = $originalPdfPath;
    }
    
    public function importPage($page_number) {
		
		$templateId = $this->pdfInstance->importPage($page_number);
		$templateDimension = $this->pdfInstance->getTemplateSize($templateId);
		
		if ( $templateDimension['w'] > $templateDimension['h'] ) {
			$orientation = "L";
		}
		else {
			$orientation = "P";
		}
		
		$this->pdfInstance->addPage($orientation,array($templateDimension['w'],$templateDimension['h']));
	}


    public function getTotalPages() {
		return $this->pdfInstace->setSourceFile($this->originalPdfPath);
    }
    
    public function savePdf() {
		$this->pdfInstace->Output("F",$this->pdfInstace);
    }
	
	public function getTemplateSize($templateId) {
		return $this->pdfInstance->getTemplateSize($templateId);
	}

	// //IMAGE
	// public function Image($filePath, $coord_x, $coord_y, $val) {
	// 	return $this->pdfInstance->Image($filePath, $coord_x, $coord_y, $val);
	// }

	// //USETEMPLATE
	// public function useTemplate($templateId) {
	// 	return $this->pdfInstance->useTemplate($templateId);
	// }


    // public function setPageRange($startPage=1, $endPage=null) {
		
	// 	$end = $endPage !== null ? $endPage : $this->getTotalPages();
	// 	$this->_specificPages = array();
		
	// 	for ($ctr = $startPage; $ctr <= $end; $ctr++ ) {
	// 		$this->_specificPages[] = $ctr;
	// 	}
	// }
}
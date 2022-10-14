<?php

class MYPDF extends TCPDF {

    public function Footer() {

        $footer = '';
        
        $this->SetY(-15);
        $this->SetFont('helvetica', '', 10);
        $this->writeHTMLCell(0, 0, '', '', $footer, 0, 0, false, true, '', true);
    }

}

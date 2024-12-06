<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use Illuminate\Support\Facades\View;
trait EmployerPrintTrait
{
    public static function setViewerPreferences():array{
        $ref=[
            'HideToolbar'=>true,
            'HideMenubar'=>true,
            'HideWindowUi'=>true,
            'FitWindow'>true,
            'CenterWindow'=>true,
            'DisplayDocTitle'=>false
        ];
        return $ref;
    }
    public static function PdfMosama_JobNames(){
        //dd(self::$dataWithRels);
        $config=config('Amer.TCPDF');
        $pdf = new \Amerhendy\Pdf\Helpers\AmerPdf($config['PageOrientation'],$config['PDFUnit'],$config['PageSize'], true, 'UTF-8', false);
        $pdf->SetCreator($config['PDFCreator']);
        $pdf->SetAuthor(config('Amer.Amer.co_name'));
        if(count(self::$dataWithRels) !== 1){
            $title=self::$dataWithRels[0]->text;
        }else{
            $title=__('EMPLANG::Mosama_JobNames.Mosama_JobNames');
        }
        $pdf->SetTitle($title);
        $pdf->SetSubject($title) ;
        $pdf->SetKeywords(implode(',',explode(' ',$title." ".config('Amer.Amer.co_name'))));
        $arr=self::$dataWithRels;
        $pageFooter=View::make("Employment::admin.pdfFooter",['config'=>$config])->render();

        $pdf->setFooterHtml($font=['aealarabiya', 'B', 10],$hs=$pageFooter, $tc=array(0,0,0), $lc=array(0,0,0),$line=true);
        $pdf->setFooterFont(Array($config['Font']['Date']['name'], '', $config['Font']['Date']['Size']));
        $pdf->SetDefaultMonospacedFont($config['Font']['MONOSPACED']);
        $pdf->SetMargins(10,20,10);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(20);
        $pdf->SetAutoPageBreak(TRUE, $config['PdfMargin']['MarginBottom']);
        $pdf->setImageScale($config['ImageScaleRatio']);
        if (@file_exists($config['packagePath'].'lang/ara.php')) {
            require_once($config['packagePath'].'lang/ara.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('aealarabiya', '', 12, '', true);
        $pdf->setRTL(true);
        $pdf->setViewerPreferences(self::setViewerPreferences());
        if (self::$request->input('table') == 'tableForCollection') {
            $pdf->setPageOrientation('L');
            $tablewidth=255;
        }else{
            $tablewidth=190;
        }
        $css=View::make("Employment::admin.seatings.CssTable",['data'=>['tablewidth'=>$tablewidth]])->render();
        //dd(self::$dataWithRels);
        foreach (self::$dataWithRels as $key => $value) {
            $pageheader=View::make("Employment::admin.pdfheader",['config'=>$config])->render();
            $pdf->setHeaderData($ln='', $lw=0, $ht='', $hs=$pageheader, $tc=array(0,0,0), $lc=array(0,0,0));
            $pdf->AddPage();
            $html= View::make("Employers::Employers.PDFPrint",['data'=>$value,'pdf'=>$pdf])->render();
            $tagvs = [
                'div' => [
                    ['h' => 0.5, 'n' => 0.01],['h' => 0.5, 'n' => 0.01]
                ]
            ];
            $pdf->setHtmlVSpace($tagvs);
            $pdf->writeHTML($css.$html, true, false, false, false, 'right');
        }




        $filename=$title.".pdf";
        self::$pdfString=$pdf->Output($filename, 'E');
    }

}

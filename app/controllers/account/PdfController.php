<?php

namespace Controllers\Account;

use BaseController;
use FormRequests;
use PDF;
use View;
use Ocr;
use Sentry;
use LinkedinRecommendation;
use User;
use mPDF;
use URL;

class PdfController extends BaseController {

    public function getSubmission($id = null) {

        $request = FormRequests::where('id', $id)->where('submission_status', 1)->first();
        $seeker = $request->seeker()->first();
        $writer = $request->writer()->first();

        $form = $request->form()->first();
        $tabs = $request->form()->first()->fields()->get();
        $fields = $request->form()->first()->fields()->get();

        //return View::make('pdf.submission', compact('request' , 'seeker' , 'writer' , 'form' , 'tabs' , 'fields') );
        //  $organization=Sentry::getUser()->hasAccess('organization');
        $header = View::make('pdf.pdf_header');
        $footer = View::make('pdf.pdf_footer');
        $html = View::make('pdf.pdf_body', compact('request', 'seeker', 'writer', 'form', 'tabs', 'fields', 'organization'));
        $pdf = new mPDF('utf-8', 'A4', 0, '', $mgl = 0, $mgr = 0, $mgt = 35, $mgb = 35, $mgh = 0, $mgf = 0, $orientation = 'P');
        $pdf->SetHTMLHeader($header->render());
        $pdf->SetWatermarkImage(asset('assets/pdf/watermark.png'));
        $pdf->showWatermarkImage = true;
        $pdf->watermarkImageAlpha = 0.2;
        $pdf->writeHTML($html->render());
        $pdf->SetHTMLFooter($footer->render());
        $filename .= $form->name."_" . date("m_d_Y") . ".pdf";
        $pdf->output($filename, 'D');
        exit;
    }

    public function getSubmissions($id = null) {

        $ocr = Ocr::where('id', $id)->first();


        //return View::make('pdf.submission', compact('request' , 'seeker' , 'writer' , 'form' , 'tabs' , 'fields') );
        // $organization=Sentry::getUser()->hasAccess('organization'); 
        return PDF::load(View::make('pdf.submissions', compact('ocr', 'organization')), 'A4', 'portrait')->download('submissionOcr');
    }

    public function getRecommendation($id = null) {

        $recommendation = LinkedinRecommendation::where('id', $id)->first();
        $user = User::where('id', $recommendation->user_id)->first();

        //return View::make('pdf.recommendation', compact('recommendation' , 'user') );
        return PDF::load(View::make('pdf.recommendation', compact('recommendation', 'user')), 'A4', 'portrait')->download('LinkedinRecommendation');
    }

}

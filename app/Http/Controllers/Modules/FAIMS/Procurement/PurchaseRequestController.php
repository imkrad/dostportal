<?php

namespace App\Http\Controllers\Modules\FAIMS\Procurement;

use Illuminate\Http\Request;
use App\Services\FAIMS\Procurement\PurchaseRequestClass;
use App\Services\FAIMS\DropdownClass;
use App\Http\Requests\FAIMS\Procurement\PurchaseRequest;
use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use setasign\Fpdi\Fpdi;

class PurchaseRequestController extends Controller
{
    use HandlesTransaction;

    public function __construct(PurchaseRequestClass $purchase_request, DropdownClass $dropdown){
        $this->purchase_request = $purchase_request;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'purchase_request':
                return $this->purchase_request->lists($request);
            break;
            case 'unit_type':
                return $this->dropdown->unit_type($request);
            break;
            case 'sections':
                return $this->dropdown->sections($request);
            break;

            case 'print_preview':
                dd($request->all());
                return $this->print();
            break;

            case 'create_purchase_request':
                return inertia('Modules/FAIMS/Procurement/Purchase-Request/Components/CreatePage', [
                    'dropdowns' => [
                       'unit_types' => $this->dropdown->unit_types(),
                       'divisions' => $this->dropdown->divisions(),
                       'fund_clusters' => $this->dropdown->fund_clusters(),
                       'requesters' => $this->dropdown->requesters(),
                       'approvers' => $this->dropdown->approvers(),
                    ],
                ]); 
            break;
            default:
                return inertia('Modules/FAIMS/Index', [
                    'dropdowns' => [
                      
                    ],
                ]); 
        }   
    }

    public function store(Request $request) {
        $result = $this->handleTransaction(function () use ($request) {
            return $this->purchase_request->save($request);
        });

            return redirect()->route('purchase_request.index')->with([
                'data' => $result['data'],
                'message' => $result['message'],
                'info' => $result['info'],
                'status' => $result['status'],
            ]);

    }

    
    // public function print(){
    //     $array = [
    //         'data' => 'test',
    //     ];

    //     $pdf = \PDF::loadView('FAIMS.Procurement.print',$array)->setPaper('a4', 'landscape');
    //     return $pdf->stream('pdfname.pdf');
    // }
    
    public function print()
    {
        $array = [
            'data' => 'test',
        ];
    
        // Generate first page (Portrait) as a string
        $pdfPortrait = \PDF::loadView('FAIMS.Procurement.print_portrait', $array)
                          ->setPaper('a4', 'portrait')
                          ->output(); // Store the PDF as a string
    
        // Generate second page (Landscape) as a string
        $pdfLandscape = \PDF::loadView('FAIMS.Procurement.print_landscape', $array)
                           ->setPaper('a4', 'landscape')
                           ->output(); // Store the PDF as a string
    
        // Write PDFs to temporary files
        $tempFilePortrait = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($tempFilePortrait, $pdfPortrait);

        $tempFileLandscape = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($tempFileLandscape, $pdfLandscape);

        // Create a new FPDI instance
        $fpdi = new Fpdi();

        // Add the portrait page
        $fpdi->setSourceFile($tempFilePortrait); // Load the portrait file
        $templateId = $fpdi->importPage(1);
        $fpdi->addPage('P'); // Add a portrait page
        $fpdi->useTemplate($templateId);

        // Add the landscape page
        $fpdi->setSourceFile($tempFileLandscape); // Load the landscape file
        $templateId = $fpdi->importPage(1);
        $fpdi->addPage('L'); // Add a landscape page
        $fpdi->useTemplate($templateId);

        // Clean up the temporary files
        unlink($tempFilePortrait);
        unlink($tempFileLandscape);

        // Output the merged PDF
        return response($fpdi->output(), 200)
                ->header('Content-Type', 'application/pdf');
    }
}

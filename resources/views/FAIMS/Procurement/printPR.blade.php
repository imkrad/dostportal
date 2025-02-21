<!DOCTYPE html>
<html>
<head>
    <title>Quotation Request</title>
    <style>


        html, body {
            font-family: Arial, sans-serif;
            margin: 15px 15px 15px 15px;
            padding: 0;
            height: 100%;
            font-size: 12px;
        }

        .header {
            margin-bottom: 10px;
        }
        h1 {
            margin: 10px 0;
        }
        .subheader span {
            display: block;
            margin: 5px 0;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right ;
            line-height: 0.1;
        }
        .text-left{
            text-align: left ;
            line-height: 0.5;
        }


        .text-right-date {
            text-align: left;
            position:absolute;
            right:0;
            line-height: 0.5;
        }
        .border-container {
            margin-top: 0px;
            border: solid 1px black;
            padding: 2px 8px 2px 8px;
            display: inline-block; /* Keeps the border close to the content */
            margin-right: 20px;
        }

        .border-container2 {
            margin-top:-20px;
            border: solid 1px black;

        }

        .border-container3 {
            border: solid 1px black;
            font-size: 11px;
            margin-bottom: 20px;

        }

        .bold {
            font-weight: bold;
            font-size:11px;
        }
        .small-text {
            font-size: 8px;
            padding-right: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            border: 1px solid ;
            border-collapse: collapse;
            padding: 0px;
            vertical-align: top;
        }

        th {
            border: 1px solid ;
            border-collapse: collapse;
            padding: 2px;
            vertical-align: top;
        }

        .page-break {
            page-break-before: always; /* Forces a new page when printing */
        }

        . text-left{
            background: gray;
            color: white;
        }

        .footer {
            bottom: 10px; /* Distance from bottom of the page */
            width: 100%;
            font-size: 12px;
            color: black;
            text-align: left;
            padding:0px
        }

        .border-none{
            border: none; 
        }
        .table2 td{
            text-align: center
        }

        .table3 td{
            border: none;
        }

        .table3{
            border: 1px solid;
            break-inside: avoid
        }

    </style>
</head>
<body>
    <div class="text-right">
        <div class="border-container">
            <p class="bold">FASS-PUR F08</p>
            <p class="small-text">Rev.1/07-01-2023</p>
        </div>
    </div>

    <br> 
    <h2 style="text-align:center; margin-top:-10px; font-size:15px">
        <b > PURCHASE REQUEST</b>
    </h2> 
    
  <table style="margin-bottom: -10px">
    <tr>
        <td style="border:none;">
            <p>Entity Name: <u>Department of Science and Technology - IX</u></p>
        </td>
        <td style="border:none; vertical:align; center; text-align:right">
            <p>Fund Cluster: <u>{{ $pr->fundCluster->name }}</u></p>
        </td>
    </tr>

    
  </table> 

 
  
  <table>
    <tr>
        <td rowspan="2" style="padding: 5px; vertical-align: middle"">
            Office/Section: <u> {{ $pr->section->name }} </u>
        </td>
        <td  style="padding: 5px;">
            PR No.:<u> {{ $pr->purchase_request_number }} </u>
        </td>
        <td rowspan="2" style="padding: 5px; vertical-align: middle">
            Date:<u> {{ date('m/d/Y', strtotime($pr->purchase_request_date)) }} </u>
        </td>
    </tr>
    <tr>
        <td  style="padding: 5px;">
            Responsibility Center Code: <br><u> {{ $pr->section->responsibility_center_code }} </u>
        </td>
    </tr>
</table> 

<table class="table2">
    <tr>
            <th>Stock No.</th>
            <th>Quantity/Unit</th>
            <th colspan="3">Item Description</th>
            <th>Unit Cost</th>
            <th>Total Cost</th>
        </tr>
        @foreach ($data as $index => $item)
        <tr>
            <td> {{ $index+1 }}</td>
            <td>    {{ $item->item_quantity }} {{ $item->unit_type->name_long }}</td>
            <td colspan="3" style="padding:5px;  text-align: left ; ">
                <?php
                        $fontSize = str_word_count($item->item_description) > 100 ? '10px' : '10px';
                    ?>
                    <div style="margin-top:-15px;font-size: {{ $fontSize }};">
                        {!! $item->item_description !!}
                    </div>
                </td>
            </td>
            <td> {{ number_format($item->item_price) }}</td>
            <td> {{ number_format($item->item_price*$item->item_quantity) }} </td>
            
        </tr>
        @endforeach

      <tr>
        <td colspan="7" style="padding:5px; text-align: left">
        {{ $pr->purchase_request_purpose }}
        </td>
      </tr>
      </table> 
    <table class="table3"> 
      <tr >
        <td colspan="2"></td>
        <td  colspan="3" style="padding-top:20px;padding-bottom:20px">Requested By:</td>
        <td colspan="2" style="padding-top:20px;padding-bottom:20px">Approved By:</td>
      </tr>
      <tr>
         <td colspan="2" style="padding-left:10px">
            Signature
         </td>
         <td colspan="3">______________________</td>
         <td colspan="2" style=" padding-bottom:10px">______________________</td>
      </tr>
      <tr>
        <td  colspan="2" style="padding-left:10px">
            Printed Name
        </td>
        <td colspan="3"><b><u>  {{ $pr->requester->firstname }} {{ $pr->requester->middlename[0] }}. {{ $pr->requester->lastname }} {{ $pr->requester->suffix }} </u></b></td>
        <td colspan="2" style=" padding-bottom:10px"><b><u>{{ $pr->approver->firstname }} {{ $pr->approver->middlename[0] }}. {{ $pr->approver->lastname }} {{ $pr->approver->suffix }}</u></b></td>
      </tr>
      <tr >
        <td  colspan="2" style="padding-left:10px">
            Designation
        </td>
        <td colspan="3">{{ $pr->requester->user_organization->position->administrative->name }}</td>
        <td colspan="2" style=" padding-bottom:10px">{{ $pr->approver->user_organization->position->administrative->name  }}</td>
      </tr>
  </table>
    

  
  
          
   
 
  
</body>
</html>

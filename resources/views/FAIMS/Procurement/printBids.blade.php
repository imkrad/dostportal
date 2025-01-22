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
            font-size: 10px;
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
            text-align: left;;
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

    </style>
</head>
<body>
    <div class="text-right">
        <div class="border-container">
            <p class="bold">FASS-PUR F06</p>
            <p class="small-text">Rev.1/07-01-2023</p>
        </div>
    </div>
    <div class="text-center" style="margin-top:-40px;">
        <span style="font-size: 12px">Republic of the Philippines</span>
        <h3 style="line-height: .1; font-size: 12px">DEPARTMENT OF SCIENCE AND TECHNOLOGY</h3>
        <p style="line-height: .1; font-size: 12px">Regional Office No. IX</p>

        <span >
            <p>
                <span style="position:absolute; left:10 ">
                    Standard Form Number : <u>SF-GOOD-40</u>
                </span>
                <span style="position:absolute; right:10 ">
                    Project Reference No. : _________________              
            </p>
            <p>
                <span style="position:absolute; left:10 ">
                    Revised : <u>May 20, 2004 </u>
                </span>
                <span style="position:absolute; right:10 ">
                    Project Name: ____________________
                </span>   
                <p>
                <span style="position:absolute; right:10 ;">
                    Project Location:__________________
                </span>
                </p>
               
            <p >
            </p>
        </span>
    </div>
    <br> 
    <h2 style="text-align:center; margin-top:-10px;">
        <b > ABSTRACT OF BIDS</b>
    </h2>    
    <table >
        <thead>
                <tr>
                    <th  style="width: 5px;">ITEM NO.</th>
                    <th style="width: 10px;">QTY</th>
                    <th style="width: 10px;">UNIT</th>
                    <th style="width: 200px;">DESCRIPTION</th>
                    @foreach ($data as $supplier)
                        @foreach ($supplier as $bid)
                        <th style="width: 20px;">
                            {{  $bid->bids->supplier->name }}        
                        </th>
                        @endforeach 
                        @break 
                    @endforeach
                </tr>      
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td style="text-align:center;padding:5px">
                        {{ $index+1 }}
                    </td>
                    <td style="text-align:center;padding:5px">
                        {{ $item[0]->bids_quantity }}
                    </td>
                    <td style="text-align:center;padding:5px">
                        {{ $item[0]->unit_type->name_long }}
                    </td>
                    <td style="padding:5px">
                        <?php
                            $fontSize = str_word_count($item[0]->bids_description) > 100 ? '8px' : '10px';
                        ?>
                        <div style="margin-top:-10px;font-size: {{ $fontSize }};">
                            {!! $item[0]->bids_description !!}
                        </div>
                    </td>
                        
                    </td>
                    @foreach ($item as $bid)
                    <td style="text-align:center;padding:5px">
                        {{ $bid->bids_price }}          
                    </td>
                    @endforeach  
                </tr>
                
            @endforeach
            
        </tbody>
    </table>

    <div style="font-size:11px;" class="footer">
        <h4 class="text-left">Awarding Committee</h4>
            <table style="margin-top: 50px">
                <thead >
                        <th style="border:none">
                            ROSEMARIE SALAZAR
                        </th >
                        <th style="border:none">
                            THELMA E. DIEGO
                        </th>
                        <th style="border:none">
                            JALI J. BADIOLA
                        </th >
                        <th style="border:none">
                            JULIUS T. FOJAS
                        </th>
                        <th style="border:none">
                            TEFFANIE MAE M. CATALYA
                        </th style="border:none">

                        <th style="border:none">
                            MARTIN A. WEE
                        </th>

                </thead>
            <tbody class="text-center">
                
                    <tr >
                        <td style="border:none">
                            Chairperson
                        </td >
                        <td style="border:none">
                            Member
                        </td>
                        <td style="border:none">
                            Member
                        </td>
                        <td style="border:none">
                            Member
                        </td>
                        <td style="border:none">
                            Member
                        </td>
                        <td style="border:none">
                            Regional Director
                        </td>

                    </tr>
                
            </tbody>
        </table>
        <div style="margin-top:20px">
            {{ $pr_no }}
        </div>
    </div>
  
</body>
</html>

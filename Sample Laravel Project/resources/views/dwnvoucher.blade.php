<html>
    <head>
        <style>
            table.body td {
				padding: 12px 15px;
				font-size:17px;
			}
			table.body {
				width:100%;
			}
			table.body tr:nth-child(even) {background-color: #8b5050; color:#fff;}
			table.body tr:nth-child(odd) {background-color: #26237a; color:#fff;}
			td.lable_text {
				text-align: center;
				background-color: #009688;
				color:#fff;
				padding: 5px 0;
			}
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 2cm;
                margin-left: 0cm;
                margin-right:0cm;
                margin-bottom: 2cm;
				font-family: sans-serif;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;
				font-family: sans-serif;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 130px;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
				font-family: sans-serif;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
			<div style="float:left; padding:5px;">
				<img src="{{ URL::asset('asset/images/logo/Panorama.jpg') }}" alt="Logo" width="120px;"/>By <img src="{{ URL::asset('asset/images/logo/Ensober.jpg') }}" alt="logo" width="120px;"/>
			</div>
			<div style="float:right; padding:5px;">
				Resort Address: Teda Village, Ramnagar – 244715
			</div>
        </header>

        <footer>
            <p>
				*Kindly follow the Social distancing and Covid-19 guidelines as per Govt.<br>
				This is a computer generated voucher and does not require signature.<br>
				Standard Check In Time : 12:00 PM<br>
				Standard Check Out Time: 10:00 PM<br>
				Stay Safe! Stay Healthy!
			</p>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table class="body">
				<tr>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td class="lable_text" colspan="2"><h3>Reservation Voucher</h3></td>
				</tr>
				<tr>
					<td>Reservation No</td>
					
					<td>PAN/200902</td>
				</tr>
				<tr>
					<td>Date</td>
					
					<td>06-Oct 2020</td>
				</tr>
				<tr>
					<td>Hotel Name</td>
					
					<td>Panorama Resort, Corbett</td>
				</tr>
				<tr>
					<td>Agent Name</td>
					
					<td>Direct</td>
				</tr>
				<tr>
					<td>Confirmation No. / Confirmed By</td>
					
					<td>Mrs. Pragya</td>
				</tr>
				<tr>
					<td>Client Name</td>
					
					<td>Mr. Jatin Kumar Tanwar</td>
				</tr>
				<tr>
					<td>Check In </td>
					
					<td>09 October 2020</td>
				</tr>
				<tr>
					<td>Check Out</td>
					
					<td>11 October 2020</td>
				</tr>
				<tr>
					<td>No Of Nights</td>
					
					<td>2 Nights</td>
				</tr>
				<tr>
					<td>No Of Pax</td>
					
					<td>2 Adults</td>
				</tr>
				<tr>
					<td>Kids</td>
					
					<td>N/A</td>
				</tr>
				<tr>
					<td>No Of Room</td>
					
					<td>01</td>
				</tr>
				<tr>
					<td>Room Type</td>
					
					<td>Whirlpool</td>
				</tr>
				<tr>
					<td>Package / Tariff Include</td>
					
					<td>AP</td>
				</tr>
				<tr>
					<td>Cost</td>
					
					<td>Rs. 9500/- Net</td>
				</tr>
				<tr>
					<td>Advance Received</td>
					
					<td>Rs. 3000/-</td>
				</tr>
				<tr>
					<td>Balance</td>
					
					<td>Payable at the Time of Check in</td>
				</tr>
			</table>
        </main>
    </body>
</html>
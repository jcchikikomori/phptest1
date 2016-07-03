<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="description" content="">
    <title>PHP APP TEST 1</title>

    <style type="text/css">
    	html {
    		font-family: 'Arial', serif;
    	}

    	@media print {
		    @page
		    {
		        size: auto;   /* auto is the current printer page size */
		        margin: 20px;  /* this affects the margin in the printer settings */
		        counter-increment: page;
		        counter-reset: pages 1;
		        content: "Page " counter(page) " of " counter(pages);
		    }
		    /* CUSTOM */
		    .no-border-print {
		        border: 0;
		    }
		    #print-header {
		        
		    }
		    #print-footer > .container:after {
		        
		    }
		    .no-print {
	    		display: none;
	        	content: none;
	    	}
		    .page-break {
		        page-break-before: right;
		    }
		    table { page-break-inside : auto; }
		}
    </style>

</head>

<body>

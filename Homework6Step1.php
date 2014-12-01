<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "
    http://www.w3.org/TR/htm14/strict.dtd">

<html>

    <head>

        <title> Homework 6 - Step 1: Server Side Controls - Easy </title>

        <!-- Embedded Styles: only have to define once -->
        <style type="text/css">

            body 
            {
                font-family: Arial;
                font-size: 11pt;
            }

            div.BlackBar 
            {
                background-color: black;
                color: white;
                height: 28px;
                font-size: 14pt;
                padding-top: 5px;
                padding-left: 3px;
            }

            /* Form */
            #frmSimpleCalculator 
            {
                background-color: #DDDDDD;
                width: 215px;
                text-align:center;
                line-height: 28px;
            }

            fieldset 
            {
                color: #00f;
                background-color: #ddd;
            }

            legend 
            {   
                color: black;
                text-align: left;
            }

            /* Label */
            label 
            {
                display: inline-block;      /* otherwise ignores height and width */
                width: 70px;
                text-align: left;
                color: black;
            }

            /* TextBox */
            input[type=text] 
            {
                text-align:right;
            }

            hr 
            {
                border-color: #ddd
            }

            /* Buttons */
            input[type=button]
           ,input[type=submit]  
            {
                width: 150px;
                margin-top: 5px;
            }
        </style>
        
        <!-- PHP -->       
        <?php  
         
            include 'modUtilities.php';

            $intTotal = "";
            
            // Non-procedurized piece of code at the top.
            if (IsValidData( ) == true )
            {
               $intTotal = DoCalculations( );
            }



            // --------------------------------------------------------------------------------
            // Name: Validation
            // Abstract:  Validate the data in the textboxes
            // --------------------------------------------------------------------------------
            function IsValidData(  )
            {
                $intValue1 = GetFormValue( "txtValue1", "" );
                $intValue2 = GetFormValue( "txtValue2", "" );
                
                // echo "Value 1 = '" . $intValue1 . "'<br />\n";
                
                // Get the value of the textbox's and combobox
                $blnIsValidData = true;
                $strErrorValues = "Server says, Please correct the following error(s): " . '\n';
                
                // txtValue1
                if ( empty($intValue1) == false )
                {
                    // Numeric?
                    if ( is_numeric($intValue1) == false )
                    {
                        // No
                        $strErrorValues .= "-Value 1 must be numeric!!!" . '\n';			
                        $blnIsValidData = false;   
                    }      
                }
                if ( empty($intValue2) == false )
                {
                    if ( is_numeric($intValue2) == false )
                    {
                        $strErrorValues .= "-Value 2 must be numeric!!!" . '\n';			
                        $blnIsValidData = false;   
                    }      
                }             

                // Send an error message to the user.
                if ($blnIsValidData == false)
                {
                    //SendMessageToClient( $strErrorValues );
                    echo "<script type='text/javascript'>alert('$strErrorValues');</script>";
                }               

                return $blnIsValidData;
            }        



            // --------------------------------------------------------------------------------
            // Name: Do the math
            // Abstract:  Calculate the input from the form
            // -------------------------------------------------------------------------------
            function DoCalculations( )
            {       
                $intValue1 = GetFormValue( "txtValue1", "" );
                $intOperation = GetFormValue("cmbOperation", "");
                $intValue2 = GetFormValue( "txtValue2", "" ); 
                $intTotal = "";
                
                if ( empty($intValue2) == false || $intValue2 == '0' ) 
                {
                    switch ($intOperation)
                    {
                        case 1: 
                            $intTotal = $intValue1 + $intValue2;
                            break;

                        case 2: 
                            $intTotal = $intValue1 - $intValue2;               
                            break;

                        case 3: 
                            $intTotal = $intValue1 * $intValue2;               
                        break;

                        case 4: 
                        // Only Chuck Norris can divide by zero
                        if ($intValue2 != '0' ) 
                        {
                            $intTotal = $intValue1 / $intValue2;
                        }
                        else
                        {
                            $strMessage = "Only Chuck Norris can divide by zero, broseph!!!";			
                            echo "<script type='text/javascript'>alert('$strMessage');</script>";
                        }    
                    }
                }
                return $intTotal;                
            }
        ?>
        
        <!-- JavaScript -->
        <script language="javascript" type="text/javascript">
            
        
            // --------------------------------------------------------------------------------
            // Name: Body_OnLoad
            // Abstract:  Body OnLoad
            // --------------------------------------------------------------------------------
            function Body_OnLoad()
            {
                var frmSimpleCalculator = document.getElementById("frmSimpleCalculator");

                frmSimpleCalculator.txtValue1.value = "<?php echo GetFormValue( "txtValue1", "" ) ?>";
                frmSimpleCalculator.cmbOperation.value = "<?php echo GetFormValue( "cmbOperation", "" ) ?>";
                frmSimpleCalculator.txtValue2.value = "<?php echo GetFormValue( "txtValue2", "" ) ?>";
                frmSimpleCalculator.txtTotal.value = "<?php echo $intTotal ?>";				
            }



            // --------------------------------------------------------------------------------
            // Name: btnCalculateTotal_Click
            // Abstract:  Do the math if the data is good
            // --------------------------------------------------------------------------------
            function btnCalculateTotal_Click()
            {
                var frmSimpleCalculator = document.getElementById("frmSimpleCalculator");

                if (IsValidData() === true)
                {
                    frmSimpleCalculator.submit();
                    
                }
            }			
				


            // --------------------------------------------------------------------------------
            // Name: IsValidData
            // Abstract:  Is the data valid
            // --------------------------------------------------------------------------------
            function IsValidData() 
			{
                var blnIsValidData = true;
                var strErrorMessage = "Please correct the following error(s):\n";
                var frmSimpleCalculator = document.getElementById("frmSimpleCalculator");

                // Value 1
                    if(frmSimpleCalculator.txtValue1.value === "")
                    {
                            strErrorMessage += "-Value 1 can not be blank\n";
                            blnIsValidData = false;	
                    }

                    if (isNaN(frmSimpleCalculator.txtValue1.value) === true)
                    {
                            strErrorMessage += "-Value 1 must be numberic\n";
                            blnIsValidData = false;
                    }

                    // Value 2
                    if(frmSimpleCalculator.txtValue2.value === "")
                    {
                            strErrorMessage += "-Value 2 can not be blank\n";
                            blnIsValidData = false;	
                    }

                    // Value 2 
                    if (isNaN(frmSimpleCalculator.txtValue2.value) === true)
                    {
                            strErrorMessage += "-Value 2 must be numberic\n";
                            blnIsValidData = false;
                    }

                    // Bad data?
                    if (blnIsValidData === false)
                    {
                            // Yes, warn the user 
                            alert(strErrorMessage);
                    }
	
                return blnIsValidData;

            }



            // --------------------------------------------------------------------------------
            // Name: btnClear_Click
            // Abstract:  Clear the form programatically
            // --------------------------------------------------------------------------------
            function btnClear_Click()
            {
                var frmSimpleCalculator = document.getElementById("frmSimpleCalculator");                               

                frmSimpleCalculator.txtValue1.value = "";
                frmSimpleCalculator.cmbOperation.selectedIndex = 0;                
                frmSimpleCalculator.txtValue2.value = "";
                frmSimpleCalculator.txtTotal.value = "";
            }  
        </script>
        
    </head>
    
    <body onload="Body_OnLoad();">

        Name: Brandon Roberts <br />
        Class: PHP <br />
        Abstract: Homework #6 - Step 1 - Interactive Dynamic Content - Hard <br />
        <br />
        <div class="BlackBar"> Homework#6 - Come to the Server Side </div>
        <br />

        <form name="frmSimpleCalculator" id="frmSimpleCalculator" action="Homework6Step1.php" method="post">

            <fieldset>

                <legend> Simple Calculator </legend>

                <!-- Value 1 -->
                <label for="txtValue1"> Value 1: </label> 
                <input type="text" name="txtValue1" id="txtValue1" value="" 
                 size="10" maxlength="5" /> <br />

                <!-- Operation -->
                <select name="cmbOperation" id="cmbOperation">
                    <option value="1"> + </option>
                    <option value="2"> - </option>
                    <option value="3"> * </option>
                    <option value="4"> / </option>
                </select> <br />

                <!-- Value 2 -->
                <label for="txtValue2"> Value 2: </label> <input type="text" name="txtValue2" 
                 id="txtValue2" value="" size="10" maxlength="5" /> <br />

                <hr style="width: 95%"/>

                <!-- Total -->
                <label for="txtTotal"> Total: </label> 
            	<input type="text" name="txtTotal" id="txtTotal" value="" 
            	 size="10" readonly /> <br />

                <!-- Calculate Total -->
                <input type="submit" name="btnCalculateTotal" id="btnCalculateTotal" 
                	value="Calculate Total" onclick="return xIsValidData();" /> <br />

                <!-- Clear -->
                <input type="button" name="btnClear" id="btnClear"
                    value="Clear" onclick="btnClear_Click();" /> <br />

            </fieldset>

        </form>

    </body>

</html>
        
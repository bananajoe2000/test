<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brutto-Netto Calculator</title>
    <style>
        /* General styles */
        html, body {
            margin: 0;
            padding: 0;
            max-width: 100%;
            font-family: Arial, sans-serif;
            overflow-x: hidden; /* Prevent horizontal scrolling */
        }

        body {
            min-height: 100vh;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
        }

        form {
            width: 100%;
            max-width: 600px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px;
            vertical-align: middle;
        }

        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            /* Ensures text is selected smoothly */
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            td label {
                display: block;
                margin-bottom: 5px;
            }

            td input {
                margin-bottom: 10px;
            }

            tr {
                display: block;
                margin-bottom: 15px;
            }
        }
    </style>
    
    <script>
    	function clearInput(input) {
            input.value = '';
        }
    	
        function calculate() {
            const bruttoInput = document.getElementById('brutto');
            const nettoInput = document.getElementById('nettoInklMwst');

            const brutto = parseFloat(bruttoInput.value) || 0;
            const nettoInklMwst = parseFloat(nettoInput.value) || 0;
            const rabatt = parseFloat(document.getElementById('rabatt').value) || 0;
            const skonto = parseFloat(document.getElementById('skonto').value) || 0;
            const allgAbzuege = parseFloat(document.getElementById('allgAbzuege').value) || 0;
            const mwst = parseFloat(document.getElementById('mwst').value) || 0;

            let isBruttoInput = bruttoInput === document.activeElement;
            let isNettoInput = nettoInput === document.activeElement;

            if (isBruttoInput || (!isBruttoInput && !isNettoInput)) {
                // Calculate Netto from Brutto
                const rabattAmount = brutto * (rabatt / 100);
                const subtotal1 = brutto - rabattAmount;

                const skontoAmount = subtotal1 * (skonto / 100);
                const subtotal2 = subtotal1 - skontoAmount;

                const allgAbzuegeAmount = subtotal2 * (allgAbzuege / 100);
                const subtotal3 = subtotal2 - allgAbzuegeAmount;

                const mwstAmount = subtotal3 * (mwst / 100);
                const nettoInklMwstCalculated = subtotal3 + mwstAmount;

                // Update the fields
                document.getElementById('rabattAmount').value = rabattAmount.toFixed(2);
                document.getElementById('subtotal1').value = subtotal1.toFixed(2);
                document.getElementById('skontoAmount').value = skontoAmount.toFixed(2);
                document.getElementById('subtotal2').value = subtotal2.toFixed(2);
                document.getElementById('allgAbzuegeAmount').value = allgAbzuegeAmount.toFixed(2);
                document.getElementById('subtotal3').value = subtotal3.toFixed(2);
                document.getElementById('mwstAmount').value = mwstAmount.toFixed(2);
                nettoInput.value = nettoInklMwstCalculated.toFixed(2);

            } else if (isNettoInput) {
                // Calculate Brutto from Netto inkl. MwSt
                const subtotal3 = nettoInklMwst / (1 + mwst / 100);
                const allgAbzuegeAmount = subtotal3 * (allgAbzuege / 100);
                const subtotal2 = subtotal3 + allgAbzuegeAmount;
                const skontoAmount = subtotal2 * (skonto / 100);
                const subtotal1 = subtotal2 + skontoAmount;
                const rabattAmount = subtotal1 * (rabatt / 100);
                const bruttoCalculated = subtotal1 + rabattAmount;

                // Update the fields
                document.getElementById('mwstAmount').value = (nettoInklMwst - subtotal3).toFixed(2);
                document.getElementById('allgAbzuegeAmount').value = allgAbzuegeAmount.toFixed(2);
                document.getElementById('subtotal3').value = subtotal3.toFixed(2);
                document.getElementById('skontoAmount').value = skontoAmount.toFixed(2);
                document.getElementById('subtotal2').value = subtotal2.toFixed(2);
                document.getElementById('rabattAmount').value = rabattAmount.toFixed(2);
                document.getElementById('subtotal1').value = subtotal1.toFixed(2);
                bruttoInput.value = bruttoCalculated.toFixed(2);
            }
        }

        function resetValues() {
            document.getElementById('brutto').value = '0.00';
            document.getElementById('nettoInklMwst').value = '0.00';
            document.getElementById('rabatt').value = '0.00';
            document.getElementById('skonto').value = '0.00';
            document.getElementById('allgAbzuege').value = '1.65';
            document.getElementById('mwst').value = '8.10';
            calculate(); // Recalculate to reset all other fields
        }
    </script>
</head>
<body onload="resetValues()">
    <h1>Brutto-Netto Calculator</h1>
    <form>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <td><label for="brutto">Brutto:</label></td>
                <td></td>
                <td><input type="number" id="brutto" name="brutto" step="0.1" onfocus="clearInput(this)" oninput="calculate()" style="background-color: yellow"></td>
            </tr>
            <tr>
                <td><label for="rabatt">- Rabatt (%):</label></td>
                <td><input type="number" id="rabatt" name="rabatt" step="0.1" value="0.00" onfocus="clearInput(this)" oninput="calculate()" style="background-color: yellow"></td>
                <td><input type="text" id="rabattAmount" name="rabattAmount" value="0.00" readonly></td>
            </tr>
            <tr style="background-color: lightgrey">
                <td><label>Zwischentotal:</label></td>
                <td></td>
                <td><input type="text" id="subtotal1" step="0.01" readonly></td>
            </tr>
            <tr>
                <td><label for="skonto">- Skonto (%):</label></td>
                <td><input type="number" id="skonto" name="skonto" step="0.1" value="0.00" onfocus="clearInput(this)" oninput="calculate()" style="background-color: yellow"></td>
                <td><input type="text" id="skontoAmount" name="skontoAmount" value="0.00" readonly></td>
            </tr>
            <tr style="background-color: lightgrey">
                <td><label>Zwischentotal:</label></td>
                <td></td>
                <td><input type="text" id="subtotal2" step="0.01" readonly></td>
            </tr>
            <tr>
                <td><label for="allgAbzuege">- Allg. Abzüge (%):</label></td>
                <td><input type="number" id="allgAbzuege" name="allgAbzuege" step="0.01" value="1.65" onfocus="clearInput(this)" oninput="calculate()" style="background-color: yellow"></td>
                <td><input type="text" id="allgAbzuegeAmount" name="allgAbzuegeAmount" value="0.00" readonly></td>
            </tr>
            <tr style="background-color: lightgrey">
                <td><label>Zwischentotal:</label></td>
                <td></td>
                <td><input type="text" id="subtotal3" step="0.01" readonly></td>
            </tr>
            <tr>
                <td><label for="mwst">+ MWST (%):</label></td>
                <td><input type="number" id="mwst" name="mwst" step="0.01" value="8.10" onfocus="clearInput(this)" oninput="calculate()" style="background-color: yellow"></td>
                <td><input type="text" id="mwstAmount" name="mwstAmount" value="0.00" readonly></td>
            </tr>
            <tr>
                <td><label for="nettoInklMwst">Netto inkl. MwSt:</label></td>
                <td></td>
                <td><input type="number" id="nettoInklMwst" name="nettoInklMwst" step="0.1" onfocus="clearInput(this)" oninput="calculate()" style="background-color: yellow"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:center;">
                    <button type="button" onclick="resetValues()">Werte zurücksetzen</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>

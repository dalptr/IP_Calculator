<?php
global $defaultPrefixLengthOption;
include "ip_rules.php";
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/images/logo.webp">
    <link rel="stylesheet" href="assets/style.css">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IP Calculator</title>
</head>
<body>

<div class="wrapper">

    <form action="" method="post" class="flex-column full-width">
        <span class="title text-center mb-10">IP SUBNET CALCULATOR</span>
        <label for="ip-address" class="full-width">
            <input type="text" id="ip-address-input" name="ip-address-input" class="text-center padding-10 full-width mb-10"
                   placeholder="IP Address">
            <select class="text-center padding-10 full-width mb-10"  id="prefix-length" name="prefix-length">
                <?php
                echo "<option value='$defaultPrefixLengthOption'>Default Prefix Length</option>";

                for ($i = 1; $i <= 32; $i++) {
                    $subnetMask = prefixLengthToDecimalSubnetMask($i);
                    echo "<option value='$i'>$subnetMask / $i</option>";
                }
                ?>
            </select>
            <button type="submit" style="background-color: #0079FF" class="text-white padding-10 full-width mb-10"
                    id="calculate" name="calculate">Calculate
            </button>
    </form>


    <div class="table-resul">
        <table>
            <thead>
            <tr>
                <td style="background-color: #00DFA2" class="text-center text-white">Attribute</td>
                <td style="background-color: #00DFA2" class="text-center text-white">Value</td>
            </tr>
            </thead>

            <tbody>
            <?php
            if (!isset($_POST['calculate'])) return;
            handleCalculateButtonClick();
            ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
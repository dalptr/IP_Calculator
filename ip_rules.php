<?php
// how to define const variable
$defaultPrefixLengthOption = 0;
function prefixLengthToDecimalSubnetMask($prefixLength): string
{
    $subnetMask = str_repeat("1", $prefixLength);
    $subnetMask .= str_repeat("0", 32 - $prefixLength);
    $subnetMaskDecimal = "";
    for ($i = 0; $i < 32; $i += 8) {
        $subnetMaskDecimal .= bindec(substr($subnetMask, $i, 8)) . ".";
    }
    return substr($subnetMaskDecimal, 0, -1);
}

function getIpClass($prefixLength): string
{
    if ($prefixLength >= 1 && $prefixLength <= 8) {
        return "A";
    } elseif ($prefixLength >= 9 && $prefixLength <= 16) {
        return "B";
    } elseif ($prefixLength >= 17 && $prefixLength <= 24) {
        return "C";
    } elseif ($prefixLength >= 25 && $prefixLength <= 32) {
        return "D";
    }
    return "Invalid IP Address";
}

function debug($data): void
{
//    print data to debug.txt
    $file = fopen("debug.txt", "a");
    fwrite($file, print_r($data, true));
    fclose($file);
}

function getBroadCastAddress($ipAddress, $prefixLength): string
{
    debug($ipAddress);
    debug($prefixLength);
    $ipAddress = explode(".", $ipAddress);
    $firstOctet = $ipAddress[0];
    $secondOctet = $ipAddress[1];
    $thirdOctet = $ipAddress[2];
    $fourthOctet = $ipAddress[3];
    $subnetMask = prefixLengthToDecimalSubnetMask($prefixLength);
    $subnetMask = explode(".", $subnetMask);
    $firstOctetSubnetMask = $subnetMask[0];
    $secondOctetSubnetMask = $subnetMask[1];
    $thirdOctetSubnetMask = $subnetMask[2];
    $fourthOctetSubnetMask = $subnetMask[3];
    $firstOctetBroadCastAddress = $firstOctet | $firstOctetSubnetMask;
    $secondOctetBroadCastAddress = $secondOctet | $secondOctetSubnetMask;
    $thirdOctetBroadCastAddress = $thirdOctet | $thirdOctetSubnetMask;
    $fourthOctetBroadCastAddress = $fourthOctet | $fourthOctetSubnetMask;
    return "$firstOctetBroadCastAddress.$secondOctetBroadCastAddress.$thirdOctetBroadCastAddress.$fourthOctetBroadCastAddress";
}

function maxHosts($prefixLength): int
{
    return pow(2, 32 - $prefixLength) - 2;
}

// check Ip public or private
function getIpType($ipAddress): string
{
    $ipAddress = explode(".", $ipAddress);
    $firstOctet = $ipAddress[0];
    if ($firstOctet == 10) {
        return "Private";
    } elseif ($firstOctet == 172 && $ipAddress[1] >= 16 && $ipAddress[1] <= 31) {
        return "Private";
    } elseif ($firstOctet == 192 && $ipAddress[1] == 168) {
        return "Private";
    } elseif ($firstOctet >= 1 && $firstOctet <= 126) {
        return "Public";
    } elseif ($firstOctet >= 128 && $firstOctet <= 191) {
        return "Public";
    } elseif ($firstOctet >= 192 && $firstOctet <= 223) {
        return "Public";
    } elseif ($firstOctet >= 224 && $firstOctet <= 239) {
        return "Public";
    } elseif ($firstOctet >= 240 && $firstOctet <= 255) {
        return "Public";
    }
    return "Invalid IP Address";
}

function validPrefixLengthForIpAddress($ipAddress, $prefixLength): bool
{
    $ipAddress = explode(".", $ipAddress);
    $firstOctet = $ipAddress[0];
    if ($firstOctet >= 1 && $firstOctet <= 126 && $prefixLength >= 8 && $prefixLength <= 32) {
        return true;
    } elseif ($firstOctet >= 128 && $firstOctet <= 191 && $prefixLength >= 16 && $prefixLength <= 32) {
        return true;
    } elseif ($firstOctet >= 192 && $firstOctet <= 223 && $prefixLength >= 24 && $prefixLength <= 32) {
        return true;
    } elseif ($firstOctet >= 224 && $firstOctet <= 239 && $prefixLength >= 32 && $prefixLength <= 32) {
        return true;
    } elseif ($firstOctet >= 240 && $firstOctet <= 255 && $prefixLength >= 32 && $prefixLength <= 32) {
        return true;
    }
    return false;
}

function getDefaultPrefixLengthFromIpAddress($ipAddress): int
{
    $ipAddress = explode(".", $ipAddress);
    $firstOctet = $ipAddress[0];
    if ($firstOctet >= 1 && $firstOctet <= 126) {
        return 8;
    } elseif ($firstOctet >= 128 && $firstOctet <= 191) {
        return 16;
    } elseif ($firstOctet >= 192 && $firstOctet <= 223) {
        return 24;
    } elseif ($firstOctet >= 224 && $firstOctet <= 239) {
        return 32;
    } elseif ($firstOctet >= 240 && $firstOctet <= 255) {
        return 32;
    }
    return -1;
}

function getIPAdressInfo($ipAddress, $prefixLength): array
{
    $res = [];
    $res['IP Address'] = $ipAddress;
    $res['Prefix Length'] = $prefixLength;
    $res['IP Class'] = getIpClass($prefixLength);
    $res['Subnet Mask'] = prefixLengthToDecimalSubnetMask($prefixLength);
    $res['Wildcard Mask'] = prefixLengthToDecimalSubnetMask(32 - $prefixLength);
    $res['Maximum Hosts'] = maxHosts($prefixLength);
    $res['Broadcast Address'] = getBroadCastAddress($ipAddress, $prefixLength);
    $res['IP Type'] = getIpType($ipAddress);
    return $res;
}

function isValidIpAddress($ipAddress): bool
{
    $regex = "/^([1-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])){3}$/";
    return preg_match($regex, $ipAddress);
}

function handleCalculateButtonClick(): void
{
    $ipAddress = $_POST['ip-address-input'] ?? "";
    if (!isValidIpAddress($_POST['ip-address-input'])) {
        echo "<script>alert('Invalid IP Address')</script>";
        return;
    }
    $prefixLength = $_POST['prefix-length'] ?? -1;
    if ($prefixLength == 0) {
        $prefixLength = getDefaultPrefixLengthFromIpAddress($ipAddress);
    }

    if (!validPrefixLengthForIpAddress($ipAddress, $prefixLength)) {
        echo "<script>alert('Invalid IP Address or Prefix Length')</script>";
        return;
    }

    $ipAddressInfo = getIPAdressInfo($ipAddress, $prefixLength);
    foreach ($ipAddressInfo as $key => $value) {
        echo "<tr>";
        echo "<td>" . $key . "</td>";
        echo "<td>" . $value . "</td>";
        echo "</tr>";
    }

}
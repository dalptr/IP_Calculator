function prefixLengthToDecimalSubnetMask(prefixLength) {
    let subnetMask = "";
    let numberOfOnes = prefixLength;
    let numberOfZeroes = 32 - prefixLength;
    for (let i = 0; i < numberOfOnes; i++) subnetMask += "1";
    for (let i = 0; i < numberOfZeroes; i++) subnetMask += "0";
    let subnetMaskDecimal = "";
    for (let i = 0; i < 32; i += 8) {
        subnetMaskDecimal += parseInt(subnetMask.substr(i, 8), 2) + ".";
    }
    return subnetMaskDecimal.substr(0, subnetMaskDecimal.length - 1);
}

function getIPAdress() {
    return document.getElementById('ip-address-input').value;
}


const {isValidPrefixLength} = require('./ip_rules.js');

function convertPrefixLengthToNetmask(prefixLength) {
    if (!isValidPrefixLength(prefixLength)) return "";
    let netmask = "1".repeat(prefixLength) + "0".repeat(32 - prefixLength);

    function convertBinaryToDecimal(s) {
        // have leading zeros
        return parseInt(s, 2).toString(10).padStart(3, "0");
    }

    const binaryOctetArray = [
        netmask.slice(0, 8),
        netmask.slice(8, 16),
        netmask.slice(16, 24),
        netmask.slice(24, 32)
    ];
    const decimalOctetArray = binaryOctetArray.map(convertBinaryToDecimal);
    return decimalOctetArray.join(".");
}


function generatePrefixLengthAndSubnetMaskOption(prefixLength) {
    if (!isValidPrefixLength(prefixLength)) return "";
    const label = `Prefix Length = ${prefixLength}, Subnet Mask = ${convertPrefixLengthToNetmask(prefixLength)}`
    return `<option value="${prefixLength}">${label}</option>`
}

function getnerateAllPrefixLengthAndSubnetMaskOptions() {
    let options = "";
    for (let i = 0; i <= 32; i++) {
        options += generatePrefixLengthAndSubnetMaskOption(i);
    }
    return options;
}

console.log(convertPrefixLengthToNetmask(5));
console.log(generatePrefixLengthAndSubnetMaskOption(5))
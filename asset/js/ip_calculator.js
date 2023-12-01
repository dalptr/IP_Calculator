function convertPrefixLengthToNetmask(prefixLength) {
    if (prefixLength < 0 || prefixLength > 32) {
        return "";
    }
    let netmask = "1".repeat(prefixLength) + "0".repeat(32 - prefixLength);

    function convertBinaryToDecimal(s) {
        return parseInt(s, 2);
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

console.log(convertPrefixLengthToNetmask(8));
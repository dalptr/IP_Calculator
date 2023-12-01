const BINARY_OCTET_LENGTH = 8;
const MAX_DECIMAL_OCTET_VALUE = 255;
const MIN_DECIMAL_OCTET_VALUE = 0;
const MAX_PREFIX_LENGTH = 32;
const MIN_PREFIX_LENGTH = 0;

function isValidPrefixLength(prefixLength) {
    return prefixLength >= MIN_PREFIX_LENGTH && prefixLength <= MAX_PREFIX_LENGTH;
}

function isValidBinaryOctet(binaryOctet) {
    if (binaryOctet.length !== BINARY_OCTET_LENGTH) return false;
    for (let i = 0; i < BINARY_OCTET_LENGTH; i++) {
        if (binaryOctet[i] !== "0" && binaryOctet[i] !== "1") return false;
    }
    return true;
}

function isValidDecimalOctet(decimalOctet) {
    return decimalOctet >= MIN_DECIMAL_OCTET_VALUE && decimalOctet <= MAX_DECIMAL_OCTET_VALUE;
}

module.exports = {
    isValidPrefixLength,
    isValidDecimalOctet
}
/* /* eslint-disable */
// Patrones para validaciones!
const url =
        /^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/,
    tel = /^(?:\+53|0053|53)?([1-9]\d{7})$/, ///^\d{10}$/,
    email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    creditCard = /^[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}$/,
    monthYear = /^[0-9]{2}\/[0-9]{4}$/,
    ipv4 =
        /^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/,
    ipv6 = /^([0-9a-fA-F]{1,4}:){7}[0-9a-fA-F]{1,4}$/,
    mac = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/,
    numeric = /^[0-9.]+$/,
    alpha = /^[a-zA-Z]+$/,
    alphanum = /^[a-zA-Z0-9]+$/,
    hex = /^#[0-9a-fA-F]{3}([0-9a-fA-F]{3})?$/,
    hexa = /^#[0-9a-fA-F]{4}([0-9a-fA-F]{4})?$/,
    hexOrHexa =
        /^#([0-9a-fA-F]{3}|[0-9a-fA-F]{4}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/,
    rgb =
        /^rgb\(((0|[1-9][\d]?|1[\d]{0,2}|2[\d]?|2[0-4][\d]|25[0-5]),){2}(0|[1-9][\d]?|1[\d]{0,2}|2[\d]?|2[0-4][\d]|25[0-5])\)$/,
    rgba =
        /^rgba\(((0|[1-9][\d]?|1[\d]{0,2}|2[\d]?|2[0-4][\d]|25[0-5]),){2}(0|[1-9][\d]?|1[\d]{0,2}|2[\d]?|2[0-4][\d]|25[0-5]),(0|0\.[0-9]+[1-9]|0\.[1-9]+|1)\)$/;

// Keep in sync with ui/types/api/validation.d.ts
export const testPattern = {
    hex: (v) => hex.test(v),
    url: (v) => url.test(v),
    tel: (v) => tel.test(v),
    email: (v) => email.test(v),
    ipv4: (v) => ipv4.test(v),
    ipv6: (v) => ipv6.test(v),
    mac: (v) => mac.test(v),
    numeric: (v) => numeric.test(v),
    alpha: (v) => alpha.test(v),
    alphanum: (v) => alphanum.test(v),
    date: (v) => /^-?[\d]+\/[0-1]\d\/[0-3]\d$/.test(v),
    time: (v) => /^([0-1]?\d|2[0-3]):[0-5]\d$/.test(v),
    fulltime: (v) => /^([0-1]?\d|2[0-3]):[0-5]\d:[0-5]\d$/.test(v),
    timeOrFulltime: (v) => /^([0-1]?\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/.test(v),
    creditCard: (v) => creditCard.test(v),
    monthYear: (v) => monthYear.test(v),
    // -- RFC 5322 --
    // -- Added in v2.6.6 --
    // This is a basic helper validation.
    // For something more complex (like RFC 822) you should write and use your own rule.
    // We won't be accepting PRs to enhance the one below because of the reason above.
    // eslint-disable-next-line

    hexColor: (v) => hex.test(v),
    hexaColor: (v) => hexa.test(v),
    hexOrHexaColor: (v) => hexOrHexa.test(v),

    rgbColor: (v) => rgb.test(v),
    rgbaColor: (v) => rgba.test(v),
    rgbOrRgbaColor: (v) => rgb.test(v) || rgba.test(v),

    hexOrRgbColor: (v) => hex.test(v) || rgb.test(v),
    hexaOrRgbaColor: (v) => hexa.test(v) || rgba.test(v),
    anyColor: (v) => hexOrHexa.test(v) || rgb.test(v) || rgba.test(v),
};

export default {
    testPattern,
};

const getPhoneCodesFromCountry = (opt) => {
    let codes = [];
    opt.phonecode.split(" ").forEach((c) => {
        codes.push({
            label: c,
            value: c,
        });
    });
    return codes;
};

export function useUtils() {
    return {
        getPhoneCodesFromCountry,
    };
}

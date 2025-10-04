import { testPattern } from "./patterns";
import { date } from "quasar";

const isValidUrl = (url) => {
    try {
        if (url === null || url.trim() === "") {
            return true;
        }
        new URL(url);
        return true;
    } catch (e) {
        return false;
    }
};

export const rules = {
    required: (val) => !!val || "requerido",
    numeric: (val) => testPattern.numeric(val) || "numerico",
    minLength: (val, min = 0) =>
        val.length >= min || `minimo ${min} caracteres`,
    maxLength: (val, max) => val.length <= max || `maximo ${max} caracteres`,
    minValue: (val, min = 0) => val < min || `tamaño mininimo ${min}`,
    maxValue: (val, max = 0) => val > max || `tamaño maximo ${max}`,
    ipAddress: (val) => testPattern.ipv4(val) || "formato no valido",
    url: (val) => isValidUrl(val) || "formato no valido",
    email: (val, rules) => rules.email(val) || "formato no valido",
    validDate: (val) => date.isValid(val) || "formato no valido",
    creditCard: (val) =>
        testPattern.creditCard(val) || "formato no valido #### #### #### ####",
    monthYear: (val) =>
        testPattern.monthYear(val) || "formato no valido #### ####",
};
export const validations = {
    getRules: (field) => {
        let result = [];
        let help = field?.help ?? [];

        if (field && typeof field === "object") {
            if (field.required) {
                result = [...result, rules.required];
                //help = [...help, "requerido"];
            }
            if (field.unique) {
                help = [...help, "unico"];
            }
            if (field.type) {
                if (field.type === "email") {
                    result = [...result, rules.email];
                    // help = [
                    //     ...help,
                    //     "formato de correo ej: example@example.com",
                    // ];
                }
                if (field.type === "url") {
                    result = [...result, rules.url];
                    // help = [...help, "formato url ej: http://example.com"];
                }
                if (field.type === "creditcard") {
                    result = [...result, (val) => rules.creditCard(val)];
                    // help = [...help, "formato url ej: http://example.com"];
                }
                if (field.type === "monthyear") {
                    result = [...result, (val) => rules.monthYear(val)];
                    // help = [...help, "formato url ej: http://example.com"];
                }
            }
            if (field.minLength) {
                result = [
                    ...result,
                    (val, min) => rules.minLength(val, field.minLength),
                ];
                // help = [...help, `minimo ${field.minLength} caracteres`];
            }
            if (field.minValue) {
                result = [
                    ...result,
                    (val, min) => rules.minValue(val, field.minValue),
                ];
                // help = [...help, `valor mininimo ${field.minValue}`];
            }
            if (field.maxLength) {
                result = [
                    ...result,
                    (val, max) => rules.maxLength(val, field.maxLength),
                ];
                // help = [...help, `maximo ${field.maxLength} caracteres`];
            }
            if (field.maxValue) {
                result = [
                    ...result,
                    (val, max) => rules.maxValue(val, field.maxValue),
                ];
                // help = [...help, `valor maximo ${field.maxValue}`];
            }
            if (field.numeric) {
                result = [...result, rules.numeric];
                // help = [...help, rules.numeric];
            }
            if (field.rules) {
                field.rules.map((r) => {
                    result = [...result, r];
                });
            }
            // if (field.help) {
            //     field.help.forEach((h) => {
            //         help = [...help, h];
            //     });
            // }
        }
        return { rules: result, help: help };
    },
};

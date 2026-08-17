import { date as useDate } from "quasar";

const { extractDate, formatDate } = useDate;

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

const toFormatDate = (dateStr) => {
    if (!dateStr) return null;

    // 1. MANEJO ESPECÍFICO PARA EL FORMATO DE LARAVEL: 2026-07-17T00:00:00.000000Z
    if (
        typeof dateStr === "string" &&
        dateStr.includes("T") &&
        dateStr.includes("Z")
    ) {
        // Extraer solo la parte de la fecha (YYYY-MM-DD)
        const datePart = dateStr.split("T")[0];
        if (/^\d{4}-\d{2}-\d{2}$/.test(datePart)) {
            const parts = datePart.split("-").map(Number);
            const d = new Date(parts[0], parts[1] - 1, parts[2]);
            if (!isNaN(d)) {
                return formatDate(d, "DD/MM/YYYY");
            }
        }
    }

    // 2. Si es YYYY-MM-DD
    if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
        const parts = dateStr.split("-").map(Number);
        const d = new Date(parts[0], parts[1] - 1, parts[2]);
        if (!isNaN(d)) {
            return formatDate(d, "DD/MM/YYYY");
        }
    }

    // 3. Si es YYYY/MM/DD
    if (/^\d{4}\/\d{2}\/\d{2}$/.test(dateStr)) {
        const parts = dateStr.split("/").map(Number);
        const d = new Date(parts[0], parts[1] - 1, parts[2]);
        if (!isNaN(d)) {
            return formatDate(d, "DD/MM/YYYY");
        }
    }

    // 4. Si es DD/MM/YYYY
    if (/^\d{2}\/\d{2}\/\d{4}$/.test(dateStr)) {
        const [day, month, year] = dateStr.split("/").map(Number);
        const d = new Date(year, month - 1, day);
        if (!isNaN(d)) {
            return formatDate(d, "DD/MM/YYYY");
        }
    }

    // 5. Fallback con extractDate
    const fallback = extractDate(dateStr);
    if (fallback && !isNaN(fallback)) {
        return formatDate(fallback, "DD/MM/YYYY");
    }

    // 6. Último intento: crear Date directamente
    try {
        const d = new Date(dateStr);
        if (!isNaN(d)) {
            return formatDate(d, "DD/MM/YYYY");
        }
    } catch (e) {}

    return dateStr;
};

export function useUtils() {
    return {
        getPhoneCodesFromCountry,
        toFormatDate,
    };
}

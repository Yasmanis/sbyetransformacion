import { Notify, Loading } from "quasar";
//import _ from "lodash";

export const notify = (
    type,
    msg,
    position = "top-right",
    progress = true,
    close = false,
    icon
) => {
    let props = {
        message: msg,
        position: position,
        progress: progress,
        closeBtn: close,
        type: type,
        textColor: type !== "info" ? "black" : "white",
        classes: "bg-custom-blue",
    };
    if (icon) {
        props["icon"] = icon;
    }
    Notify.create(props);
};

export const success = (
    msg,
    position = "top-right",
    progress = true,
    close = false
) => {
    notify("info", msg, position, progress, close);
};

export const info = (
    msg,
    position = "top-right",
    progress = true,
    close = false
) => {
    notify("info", msg, position, progress, close);
};

export const warning = (
    msg,
    position = "top-right",
    progress = true,
    close = false
) => {
    notify("warning", msg, position, progress, close);
};

export const error = (
    msg,
    position = "top-right",
    progress = true,
    close = false
) => {
    notify("negative", msg, position, progress, close, "mdi-alert-outline");
};

export const error500 = () => {
    error("error interno, consule al administrador");
};

export const errorValidation = () => {
    error("rectifique los errores");
};

export const errorException = (error) => {
    // if (_.has(error, "data.message")) {
    //   Notify.create({
    //     type: "negative",
    //     message: error.data.message,
    //   });
    // } else {
    //   Notify.create({
    //     type: "negative",
    //     message: error.message,
    //   });
    // }
};

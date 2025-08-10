import Plugin from "@ckeditor/ckeditor5-core/src/plugin";
import Command from "@ckeditor/ckeditor5-core/src/command";
import {
    addListToDropdown,
    createDropdown,
} from "@ckeditor/ckeditor5-ui/src/dropdown/utils";
import Model from "@ckeditor/ckeditor5-ui/src/model";

export default class CustomLineHeightPlugin extends Plugin {
    static get pluginName() {
        return "CustomLineHeight1";
    }

    init() {
        const editor = this.editor;

        // Registrar el comando
        editor.commands.add("lineHeight", new LineHeightCommand(editor));

        // Configurar esquema
        this._defineSchema();

        // Configurar conversión
        this._setupConversion();

        // Crear UI
        this._createDropdown();
    }

    _defineSchema() {
        const schema = this.editor.model.schema;

        // Aplicar a párrafos y encabezados
        schema.extend("paragraph", { allowAttributes: "lineHeight" });
        schema.extend("heading", { allowAttributes: "lineHeight" });
    }

    _setupConversion() {
        const editor = this.editor;

        editor.conversion.attributeToElement({
            model: "lineHeight",
            view: (modelAttributeValue, { writer }) => {
                return writer.createAttributeElement(
                    "span",
                    {
                        style: `line-height: ${modelAttributeValue}`,
                    },
                    { priority: 7 }
                );
            },
        });
    }

    _createDropdown() {
        const editor = this.editor;
        const componentFactory = editor.ui.componentFactory;

        componentFactory.add("customLineHeight", (locale) => {
            const dropdown = createDropdown(locale);
            const command = editor.commands.get("lineHeight");

            // Configurar botón principal
            dropdown.buttonView.set({
                label: "Interlineado",
                //icon: LINE_HEIGHT,
                tooltip: true,
                withText: false,
                class: "ck-line-height-dropdown",
            });

            // Crear modelo con opciones
            const lineHeightOptions = [
                { title: "Predeterminado", value: null },
                { title: "1.0", value: "1" },
                { title: "1.15", value: "1.15" },
                { title: "1.5", value: "1.5" },
                { title: "2.0", value: "2" },
                { title: "2.5", value: "2.5" },
            ];

            // Crear lista de items
            const items = lineHeightOptions.map((option) => {
                const item = new Model({
                    title: option.title,
                    value: option.value,
                    withText: true,
                    role: "menuitemradio",
                });

                item.bind("isOn").to(command, "value", (value) => {
                    return (
                        value === option.value ||
                        (!value && option.value === null)
                    );
                });

                return {
                    type: "button",
                    model: item,
                };
            });

            // Añadir items al dropdown
            addListToDropdown(dropdown, items);

            // Manejar ejecución de comandos
            dropdown.on("execute", (evt) => {
                editor.execute("lineHeight", {
                    value: evt.source.value,
                });
                editor.editing.view.focus();
            });

            // Actualizar estado del dropdown
            dropdown.bind("isEnabled").to(command);

            return dropdown;
        });
    }
}

class LineHeightCommand extends Command {
    refresh() {
        const model = this.editor.model;
        const selection = model.document.selection;

        // Obtener el primer bloque seleccionado
        const firstBlock = selection.getFirstPosition().parent;

        // Actualizar valor del comando
        this.value = firstBlock.getAttribute("lineHeight");
        this.isEnabled = model.schema.checkAttribute(firstBlock, "lineHeight");
    }

    execute({ value }) {
        const model = this.editor.model;

        model.change((writer) => {
            const ranges = model.document.selection.getRanges();

            for (const range of ranges) {
                for (const item of range.getItems()) {
                    if (item.is("paragraph") || item.is("heading")) {
                        if (value) {
                            writer.setAttribute("lineHeight", value, item);
                        } else {
                            writer.removeAttribute("lineHeight", item);
                        }
                    }
                }
            }
        });
    }
}
